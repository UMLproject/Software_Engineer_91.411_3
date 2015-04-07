using UnityEngine;
using System.Collections;

public class HandRightControll : MonoBehaviour {
	private GameObject RightHand; // Create Variable for RightHand
	void Start () {
	}
	void Update ()
	{
		// If Right Hand is empty null it finding else it changing hand position
		if( RightHand == null)
		{
			RightHand = GameObject.Find("HandRight");
		}
		else
		{
			gameObject.transform.position = new Vector3(RightHand.transform.position.x,
			                                            RightHand.transform.position.y,
			                                            RightHand.transform.position.z
			                                            );
		}
	}
}