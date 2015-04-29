function validateChange()
{
	// Get elements to compare
	var newPass = document.getElementById("NewPassword").value;
	var confPass = document.getElementById("checkNewPassword").value;
    var email1 = document.getElementById("email").value;
    var email2 = document.getElementById("checkEmail").value;
   
   var passOK = true;
   var emailOK = true;
	
	// Compare elements
    if (newPass != confPass)
	{
		document.getElementById("checkNewPassword").style.borderColor = "#ff0000";
        passOK = false;
    }
	else
	{
		document.getElementById("checkNewPassword").style.borderColor = "#2d89ef";
		passOK = true;
	}
	if( email1 != email2)
	{
		document.getElementById("checkEmail").style.borderColor = "#ff0000";
		emailOK = false;
	}
	else
	{
		document.getElementById("checkEmail").style.borderColor = "#2d89ef";
		emailOK = true;
	}
	
    if(passOK && emailOK)
		return true;
	else
		return false;
}