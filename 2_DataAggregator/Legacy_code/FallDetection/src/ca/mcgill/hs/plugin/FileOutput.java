/* 
 * Copyright (c) 2010 Jordan Frank, HumanSense Project, McGill University
 * Licensed under the MIT license: http://www.opensource.org/licenses/mit-license.php
 * See LICENSE for more information 
 */
package ca.mcgill.hs.plugin;

import java.io.BufferedOutputStream;
import java.io.DataOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashMap;
import java.util.Iterator;
import java.util.zip.GZIPOutputStream;

import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.preference.Preference;
import android.preference.PreferenceActivity;
import ca.mcgill.hs.HSAndroid;
import falldetection.analysis.fall.R;
import ca.mcgill.hs.plugin.BluetoothLogger.BluetoothPacket;
import ca.mcgill.hs.plugin.GPSLogger.GPSPacket;
import ca.mcgill.hs.plugin.GSMLogger.GSMPacket;
import ca.mcgill.hs.plugin.LocationLogger.LocationPacket;
import ca.mcgill.hs.plugin.SensorLogger.SensorPacket;
import ca.mcgill.hs.plugin.WifiLogger.WifiPacket;
import ca.mcgill.hs.prefs.PreferenceFactory;
import ca.mcgill.hs.serv.LogFileUploaderService;
import ca.mcgill.hs.util.Log;

/**
 * An OutputPlugin which writes data to files. Format for each InputPlugin must
 * be specified in this file, and so it needs to be updated in order to be able
 * to handle new sources of data.
 * 
 */
public class FileOutput extends OutputPlugin {

	// in milliseconds = 12 hours
	private static final String FILE_ROLLOVER_INTERVAL_DEFAULT = Integer
			.toString(12 * 60 * 60 * 1000);

	// in bytes = 4K
	private static final String BUFFER_SIZE_DEFAULT = "8192";

	private static final String PLUGIN_NAME = "FileOutput";

	// File Extensions to be added at the end of each file.
	private static final String WIFI_EXT = "-wifiloc.log";
	private static final String GPS_EXT = "-gpsloc.log";
	private static final String SENS_EXT = "-raw.log";
	private static final String GSM_EXT = "-gsmloc.log";
	private static final String BT_EXT = "-bt.log";
	private static final String LOC_EXT = "-location.log";
	private static final String DEF_EXT = ".log";

	/**
	 * Parses and writes given BluetoothPacket to given DataOutputStream.
	 * 
	 * @param packet
	 *            The BluetoothPacket to parse and write out.
	 * @param outputStream
	 *            The DataOutputStream to write to.
	 */
	private static void dataParse(final BluetoothPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeLong(packet.time);
			outputStream.writeInt(packet.neighbours);
			for (int i = 0; i < packet.neighbours; i++) {
				outputStream.writeUTF(packet.names.get(i) == null ? "null"
						: packet.names.get(i));
				outputStream.writeUTF(packet.addresses.get(i) == null ? "null"
						: packet.addresses.get(i));
			}
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Parses and writes given GPSLoggerPacket to given DataOutputStream.
	 * 
	 * @param packet
	 *            The GPSLoggerPacket to parse and write out.
	 * @param outputStream
	 *            The DataOutputStream to write to.
	 */
	private static void dataParse(final GPSPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeLong(packet.time);
			outputStream.writeFloat(packet.accuracy);
			outputStream.writeFloat(packet.bearing);
			outputStream.writeFloat(packet.speed);
			outputStream.writeDouble(packet.altitude);
			outputStream.writeDouble(packet.latitude);
			outputStream.writeDouble(packet.longitude);
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Parses and writes given GSMLoggerPacket to given DataOutputStream.
	 * 
	 * @param packet
	 *            The GSMLoggerPacket to parse and write out.
	 * @param outputStream
	 *            The DataOutputStream to write to.
	 */
	private static void dataParse(final GSMPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeLong(packet.time);
			outputStream.writeInt(packet.mcc);
			outputStream.writeInt(packet.mnc);
			outputStream.writeInt(packet.cid);
			outputStream.writeInt(packet.lac);
			outputStream.writeInt(packet.rssi);
			outputStream.writeInt(packet.neighbors);
			for (int i = 0; i < packet.neighbors; i++) {
				outputStream.writeInt(packet.cids[i]);
				outputStream.writeInt(packet.lacs[i]);
				outputStream.writeInt(packet.rssis[i]);
			}
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Parses and writes given SensorLoggerPacket to given DataOutputStream.
	 * 
	 * @param packet
	 *            The WifiLoggerPacket to parse and write out.
	 * @param outputStream
	 *            The DataOutputStream to write to.
	 */
	private static void dataParse(final SensorPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeLong(packet.time);
			outputStream.writeFloat(packet.x);
			outputStream.writeFloat(packet.y);
			outputStream.writeFloat(packet.z);
			outputStream.writeFloat(packet.m);
			outputStream.writeFloat(packet.temperature);
			for (int i = 0; i < packet.magfield.length; i++) {
				outputStream.writeFloat(packet.magfield[i]);
			}
			for (int i = 0; i < packet.orientation.length; i++) {
				outputStream.writeFloat(packet.orientation[i]);
			}
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Parses and writes given WifiLoggerPacket to given DataOutputStream.
	 * 
	 * @param packet
	 *            The WifiLoggerPacket to parse and write out.
	 * @param outputStream
	 *            The DataOutputStream to write to.
	 */
	private static void dataParse(final WifiPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeInt(packet.numAccessPoints);
			outputStream.writeLong(packet.timestamp);
			for (int i = 0; i < packet.numAccessPoints; i++) {
				outputStream.writeInt(packet.signalStrengths[i]);
				outputStream.writeUTF(packet.SSIDs[i]);
				outputStream.writeUTF(packet.BSSIDs[i]);
			}
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Returns the String corresponding to the file extension (of the
	 * DataPacket) that should be added to the name of the file currently being
	 * created.
	 * 
	 * @param packet
	 *            The given DataPacket
	 * 
	 * @return The String representing the extension to add to the filename.
	 */
	private static String getFileExtension(final DataPacket packet) {
		final int packetId = packet.getDataPacketId();
		if (packetId == WifiPacket.PACKET_ID) {
			return WIFI_EXT;
		} else if (packetId == GPSPacket.PACKET_ID) {
			return GPS_EXT;
		} else if (packetId == SensorPacket.PACKET_ID) {
			return SENS_EXT;
		} else if (packetId == GSMPacket.PACKET_ID) {
			return GSM_EXT;
		} else if (packetId == BluetoothPacket.PACKET_ID) {
			return BT_EXT;
		} else if (packetId == LocationPacket.PACKET_ID) {
			return LOC_EXT;
		} else {
			Log.d(PLUGIN_NAME,
					"Unknown packet id, returning default file extension.");
			return DEF_EXT;
		}
	}

	// The preference manager for this plugin.
	private final SharedPreferences prefs;

	// HashMap used for keeping file handles. There is one file associated with
	// each input plugin connected.
	private final HashMap<Integer, DataOutputStream> fileHandles = new HashMap<Integer, DataOutputStream>();

	// Size of BufferedOutputStream buffer
	private int bufferSize;

	// Preference Keys
	private static final String BUFFER_SIZE_KEY = "fileOutputBufferSize";
	private static final String ROLLOVER_INTERVAL_KEY = "fileOutputRolloverInterval";
	private static final String FILE_OUTPUT_LOG_SENSOR_DATA = "fileOutputLogSensorDataFlag";

	/**
	 * @see OutputPlugin#getPreferences(PreferenceActivity)
	 */
	public static Preference[] getPreferences(final PreferenceActivity activity) {
		final Preference[] prefs = new Preference[4];

		prefs[0] = PreferenceFactory.getCheckBoxPreference(activity,
				FILE_OUTPUT_ENABLED_PREF,
				R.string.fileoutput_enable_pref_label,
				R.string.fileoutput_enable_pref_summary,
				R.string.fileoutput_enable_pref_on,
				R.string.fileoutput_enable_pref_off, true);
		prefs[1] = PreferenceFactory.getListPreference(activity,
				R.array.fileoutput_pref_buffer_size_strings,
				R.array.fileoutput_pref_buffer_size_values,
				BUFFER_SIZE_DEFAULT, BUFFER_SIZE_KEY,
				R.string.fileoutput_buffersize_pref,
				R.string.fileoutput_buffersize_pref_summary);
		prefs[2] = PreferenceFactory.getListPreference(activity,
				R.array.fileoutput_pref_rolloverinterval_strings,
				R.array.fileoutput_pref_rolloverinterval_values,
				FILE_ROLLOVER_INTERVAL_DEFAULT, ROLLOVER_INTERVAL_KEY,
				R.string.fileoutput_rolloverinterval_pref,
				R.string.fileoutput_rolloverinterval_pref_summary);
		prefs[3] = PreferenceFactory.getCheckBoxPreference(activity,
				FILE_OUTPUT_LOG_SENSOR_DATA,
				R.string.fileoutput_log_sensor_data_pref_label,
				R.string.fileoutput_log_sensor_data_pref_summary,
				R.string.fileoutput_log_sensor_data_pref_on,
				R.string.fileoutput_log_sensor_data_pref_off, false);

		return prefs;
	}

	/**
	 * @see OutputPlugin#hasPreferences()
	 */
	public static boolean hasPreferences() {
		return true;
	}

	// Boolean representing whether or not the plugin has been signalled to
	// stop.
	private boolean pluginStopping;

	// Boolean representing whether to log all sensor data
	private boolean logSensorData;

	// Semaphore counter for the number of threads currently executing data
	// read/write operations.
	private int numThreadsWriting;

	// A boolean making sure we're not uselessly uploading.
	private boolean hasRunOnce = false;
	// Preference key for this plugin's state
	private final static String FILE_OUTPUT_ENABLED_PREF = "fileOutputEnabled";
	// Date format used in the log file names
	private final static SimpleDateFormat dateFormatter = new SimpleDateFormat(
			"yy-MM-dd-HHmmss");
	// Timestamps used for file rollover.
	private long initialTimestamp = -1;

	private long rolloverTimestamp = -1;

	private long rolloverInterval;

	private long currentTimeMillis;

	// The Context in which to use preferences.
	private final Context context;

	/**
	 * Constructs a new FileOutput output plugin.
	 * 
	 * @param context
	 *            The application context, required for accessing the
	 *            preferences.
	 */
	public FileOutput(final Context context) {
		this.context = context;
		pluginStopping = false;
		numThreadsWriting = 0;

		prefs = PreferenceFactory.getSharedPreferences(context);
	}

	/**
	 * Closes all open file handles.
	 */
	private synchronized void closeAll() {
		// Retrieve the files from the hashmap and close them.
		for (final Iterator<Integer> it = fileHandles.keySet().iterator(); it
				.hasNext();) {
			try {
				final int id = it.next();
				fileHandles.get(id).close();
			} catch (final IOException e) {
				Log.e(PLUGIN_NAME, "Caught IOException");
				Log.e(PLUGIN_NAME, e);
			}
		}
		fileHandles.clear();

		// In this block, we move all files that are in live (the most recent
		// files) into the recent directory.
		try {
			// Current live directory
			final File directory = new File(HSAndroid.getStorageDirectory(),
					HSAndroid.getAppString(R.string.live_file_path));
			if (!directory.isDirectory()) {
				if (!directory.mkdirs()) {
					throw new IOException("ERROR: Unable to create directory "
							+ directory.getName());
				}
			}

			// Get files in directory.
			final File[] filesInDirectory = directory.listFiles();

			// If directory not empty
			if (filesInDirectory != null) {

				// Destination directory
				final File dest = new File(HSAndroid.getStorageDirectory(),
						HSAndroid.getAppString(R.string.recent_file_path));
				if (!dest.isDirectory()) {
					if (!dest.mkdirs()) {
						throw new IOException(
								"ERROR: Unable to create directory "
										+ dest.getName());
					}
				}

				// Move files
				for (final File f : filesInDirectory) {
					if (!f.renameTo(new File(dest, f.getName()))) {
						throw new IOException("ERROR: Unable to transfer file "
								+ f.getName());
					}
				}
			}
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}

		if (prefs.getBoolean("autoUploadData", false)) {
			final Intent uploadIntent = new Intent(context,
					LogFileUploaderService.class);
			context.startService(uploadIntent);
		}
	}

	private void dataParse(final LocationPacket packet,
			final DataOutputStream outputStream) {
		try {
			outputStream.writeLong(packet.time);
			outputStream.writeUTF(packet.location);
		} catch (final IOException e) {
			Log.e(PLUGIN_NAME, e);
		}
	}

	/**
	 * Gets the output stream for the specified packet id, creating a new one if
	 * the file hasn't already been opened.
	 * 
	 * @param id
	 *            The Packet id to create the file for.
	 * @param extension
	 *            The filename suffix for the file that data for this packet
	 *            type will be stored in.
	 * @return The output stream for writing data for the specified packet type.
	 */
	private synchronized DataOutputStream getFileForPacketType(final int id,
			final String extension) {
		if (!fileHandles.containsKey(id)) {
			try {
				final File j = new File(HSAndroid.getStorageDirectory(),
						HSAndroid.getAppString(R.string.live_file_path));
				if (!j.isDirectory()) {
					if (!j.mkdirs()) {
						Log.e("Output Dir",
								"Could not create output directory!");
						return null;
					}
				}

				// Generate file name based on the plugin it came from and
				// the current time.
				final Date d = new Date(currentTimeMillis);
				final File fh = new File(j, dateFormatter.format(d) + extension);
				if (!fh.exists()) {
					fh.createNewFile();
				}
				Log.i("File Output", "File to write: " + fh.getName());
				fileHandles.put(id, new DataOutputStream(
						new BufferedOutputStream(new GZIPOutputStream(
								new FileOutputStream(fh), bufferSize))));
			} catch (final IOException e) {
				Log.e(PLUGIN_NAME, "Caught IOException");
				Log.e(PLUGIN_NAME, e);
				return null;
			}
		}
		return fileHandles.get(id);
	}

	/**
	 * This method gets called whenever an InputPlugin registered to FileOutput
	 * has data available to output. This method creates a file handle (if it
	 * doesn't exist already) for the InputPlugin the received DataPacket comes
	 * from. This method calls the appropriate version of dataParse based on the
	 * DataPacket type.
	 * 
	 * @param packet
	 *            The DataPacket that was received.
	 */
	@Override
	final void onDataReceived(final DataPacket packet) {
		if (!pluginEnabled || pluginStopping) {
			return;
		}

		numThreadsWriting++;
		final int id = packet.getDataPacketId();

		// Record system time
		currentTimeMillis = System.currentTimeMillis();

		// Check to see if files need to be rolled over
		if (currentTimeMillis >= rolloverTimestamp && rolloverInterval != -1) {
			initialTimestamp = currentTimeMillis;

			// If files need to be rolled over, close all currently open
			// files and clear the hash map.
			if (hasRunOnce) {
				closeAll();
			} else {
				hasRunOnce = true;
			}
			Log.i("ROLLOVER", "Creating rollover timestamp.");
			rolloverTimestamp = currentTimeMillis + rolloverInterval;
		}
		DataOutputStream outputStream = fileHandles.get(id);
		if (outputStream == null) {
			outputStream = getFileForPacketType(id, getFileExtension(packet));
		}
		/*
		 * Choose correct dataParse method based on the packet identifier.
		 */
		if (id == SensorPacket.PACKET_ID) {
			if (logSensorData) {
				dataParse((SensorPacket) packet, outputStream);
			}
		} else if (id == WifiPacket.PACKET_ID) {
			dataParse((WifiPacket) packet, outputStream);
		} else if (id == GSMPacket.PACKET_ID) {
			dataParse((GSMPacket) packet, outputStream);
		} else if (id == GPSPacket.PACKET_ID) {
			dataParse((GPSPacket) packet, outputStream);
		} else if (id == BluetoothPacket.PACKET_ID) {
			dataParse((BluetoothPacket) packet, outputStream);
		} else if (id == LocationPacket.PACKET_ID) {
			dataParse((LocationPacket) packet, outputStream);
		} else {
			Log.e(PLUGIN_NAME, "Unknown packet id: " + id);
		}
		numThreadsWriting--;
	}

	@Override
	protected void onPluginStart() {
		Log.d(PLUGIN_NAME, "onPluginStart");
		pluginEnabled = prefs.getBoolean(FILE_OUTPUT_ENABLED_PREF, false);
		bufferSize = Integer.parseInt(prefs.getString(BUFFER_SIZE_KEY,
				BUFFER_SIZE_DEFAULT));
		rolloverInterval = Integer.parseInt(prefs.getString(
				ROLLOVER_INTERVAL_KEY, FILE_ROLLOVER_INTERVAL_DEFAULT));
		logSensorData = prefs.getBoolean(FILE_OUTPUT_LOG_SENSOR_DATA, true);
		if (pluginEnabled) {
			Log.d(PLUGIN_NAME, "Plugin enabled.");
		}
	}

	@Override
	protected void onPluginStop() {
		Log.d(PLUGIN_NAME, "onPluginStop");
		pluginStopping = true;

		// Wait until all threads have finished writing.
		// TODO: Busy-wait sucks, although this is called very rarely.
		while (numThreadsWriting != 0) {
		}

		// Close all open files.
		closeAll();

		pluginStopping = false;
	}

	@Override
	public void onPreferenceChanged() {
		final boolean pluginEnabledNew = prefs.getBoolean(
				FILE_OUTPUT_ENABLED_PREF, true);
		rolloverInterval = Integer.parseInt(prefs.getString(
				ROLLOVER_INTERVAL_KEY, FILE_ROLLOVER_INTERVAL_DEFAULT));
		rolloverTimestamp = initialTimestamp + rolloverInterval;
		bufferSize = Integer.parseInt(prefs.getString(BUFFER_SIZE_KEY,
				BUFFER_SIZE_DEFAULT));
		logSensorData = prefs.getBoolean(FILE_OUTPUT_LOG_SENSOR_DATA, false);
		super.changePluginEnabledStatus(pluginEnabledNew);
	}

}
