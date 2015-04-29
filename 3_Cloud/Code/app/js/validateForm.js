function validateForm() {
    var pass1 = document.getElementById("password").value;
    var pass2 = document.getElementById("checkPassword").value;
    var email1 = document.getElementById("email").value;
    var email2 = document.getElementById("checkEmail").value;
   
   var ok = true;
	
    if (pass1 != pass2)
	{
		document.getElementById("checkPassword").style.borderColor = "#ff0000";
        ok = false;
    }
	else
	{
		document.getElementById("checkPassword").style.borderColor = "#2d89ef";
	}
	if( email1 != email2)
	{
		document.getElementById("checkEmail").style.borderColor = "#ff0000";
		ok = false;
	}
	else
	{
		document.getElementById("checkEmail").style.borderColor = "#2d89ef";
	}
	
    return ok;
}