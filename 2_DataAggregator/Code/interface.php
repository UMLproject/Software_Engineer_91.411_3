<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">

    <link rel="stylesheet" href="NewStyle.css" />	

    <script type="text/javascript" src="scripts/formutilities.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/mathjs/0.15.0/math.min.js"></script>

    <title>Food Tracker</title>

    </head>

    <body>

        <!--
          Basic Header
        -->
        <div id="header">
        <h1>Food Tracker</h1>
        </div>


        <!--
          Exciting Code
        -->
        <div id="section">
        <p>Please enter a valid meal, number of calories and a date.</p><br>

        <!--
          Getting User Input
        -->
        <form action="" method="post">
        Meal: <input type="text" name="meal" id="meal" value=""><br>
        Calories:  <input type="text" name="calories" id="calories" value=""><br>
        Date (MM/DD/YY): <input type="text" name="date" id="date" value=""><br>
        <input type="submit" name="submit" value="Submit Meal"/>
        </form><br>


        <!--
          Storing Input into Database
        -->
        <?php
          if(isset($_POST['submit'])) {
              $meal = mysql_real_escape_string($_POST['meal']);
              $calories = mysql_real_escape_string($_POST['calories']);
              $date = mysql_real_escape_string($_POST['date']);

              $db_connection = mysql_connect("localhost", "adp", "asd")
                or die( "<script>$(document).ready( function() {document.write(\"Error Connecting to database...\");});</script>" );

                mysql_select_db("calorie", $db_connection)
                or die( "<script>$(document).ready( function() {document.write(\"Error Loading database...\");});</script>" );

                $result = mysql_query("INSERT INTO meals VALUES ( 'Akash', '".$date."', '" . $meal . "', '".$calories."')" )
            or die( "<p>Error insertng into the database: " . mysql_error() . "</p>" ) ;

            echo "<h5> Meal Entered! </h5>";

              mysql_close($db_connection);
          }
        ?>

        <!--
          Get user to pick a date and print the stats for that date
        -->
        <form action="#" method="post">
        <select name = "red" > 
            <option value="select">Select a Date...</option>
        <?php
            $db_connection = mysql_connect("localhost", "adp", "asd")
                or die( "<script>$(document).ready( function() {document.write(\"Error Connecting to database...\");});</script>" );

            mysql_select_db("calorie", $db_connection)
                or die( "<script>$(document).ready( function() {document.write(\"Error Loading database...\");});</script>" );

            $functions = mysql_query( "SELECT distinct dates FROM meals" )
                or die( "<script>$(document).ready( function() {document.write(\"Error Loading database entries...\");});</script>");

                //Adds an option to the drop down menu                  
                while($row = mysql_fetch_row($functions)) {
                    foreach($row as $key=>$value) {
                        echo "<option value=", $value, ">", $value, "</option>";
                    }
                }
        ?>
        </select>
        <input type="submit" name="submit1" value="Submit Date"/>
        </form><br>

        <?php
        if(isset($_POST['submit1'])) {
            $selected_val = $_POST['red'];

            $db_connection = mysql_connect("localhost", "adp", "asd")
                or die( "<script>$(document).ready( function() {document.write(\"Error Connecting to database...\");});</script>" );

                mysql_select_db("calorie", $db_connection)
                or die( "<script>$(document).ready( function() {document.write(\"Error Loading database...\");});</script>" );


            $function = mysql_query( "SELECT SUM(calories) From meals Where dates = '".$selected_val."'", $db_connection)
              or die( "<script>$(document).ready( function() {document.write(\"Error Loading database entries...\");});</script>");


              while($row2 = mysql_fetch_row($function)) {
                foreach($row2 as $key2=>$value2) {
                    echo "Total Calories Consumed $selected_val: ", $value2;
                }
              }

              echo "<h5>Meal Information For $selected_val</h5>";

              $functions = mysql_query( "SELECT * From meals Where dates = '".$selected_val."'", $db_connection)
              or die( "<script>$(document).ready( function() {document.write(\"Error Loading database entries...\");});</script>");
            
              echo "<table border = '1' align='center' cellpadding='10'>";

              $row1 = mysql_fetch_assoc($functions) or die ("Please Enter a valid batter name!");

              echo "<tr>";
              foreach($row1 as $key1=>$value1) {
                echo "<th>", $key1, "</th>";
              }
              echo "</tr>";
            
              mysql_data_seek($functions, 0);
            
              while($row = mysql_fetch_row($functions)) {
                echo "<tr>";
                foreach($row as $key=>$value) {
                  echo "<td>", $value, "</td>";
                }
                echo "</tr>";
              }

              echo "</table><br />";

              mysql_close($db_connection);
        }    
        ?>

        </div>

   </body>
</html>