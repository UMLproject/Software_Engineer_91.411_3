using UnityEngine;
using System.Collections;

public class HandLeftControll : MonoBehaviour {
	private GameObject LeftHand; // Create Variable for RightHand
	void Start () {
	}
	void Update ()
	{
		// If Right Hand is empty null it finding else it changing hand position
		if( LeftHand == null)
		{
			LeftHand = GameObject.Find("HandLeft");
		}
		else
		{
			gameObject.transform.position = new Vector3(LeftHand.transform.position.x,
			                                            LeftHand.transform.position.y,
			                                            LeftHand.transform.position.z
			                                            );
		}
	}
}