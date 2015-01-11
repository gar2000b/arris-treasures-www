// Start Keypress Event Listener Code
var carriageReturnSet = false;

// Add generic event listening code for cross browser compat.
function keyval(n)
{
    if (n == null) return 'undefined';
    var s= '' + n;
    if (n >= 32 && n < 127) s+= ' (' + String.fromCharCode(n) + ')';
    while (s.length < 9) s+= ' ';
    return s;
}

function keypress(e)
{
   if (!e) e= event;
   pressmesg('keypress',e);
   // return suppressdefault(e,document.testform.keypress.checked);
}

function pressmesg(w,e)
{
   if(keyval(e.keyCode) == 13)
   {
	   carriageReturnSet = true;
	   if(document.getElementById('password'))
	   {
	   	adminLogin();
	   }
   }
}

function suppressdefault(e,flag)
{
   if (flag)
   {
       if (e.preventDefault) e.preventDefault();
       if (e.stopPropagation) e.stopPropagation();
   }
   return !flag;
}

function showmesg(t)
{
	alert(t);
	return false;
}

	// Event Listener Code
	if (document.addEventListener)
	{
	   document.addEventListener("keypress",keypress,false);
	}
	else if (document.attachEvent)
	{
	   document.attachEvent("onkeypress", keypress);
	}
	else
	{
	   document.onkeypress= keypress;
	}
	
// End Keypress Event Listener Code

// Check if admin has already logged in.
function checkAdminLogin()
{
	var thisdate = new Date();
	var type = "&type=adminLogin";

	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){checkAdminLoginAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function checkAdminLoginAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		// alert("output is " + output);
		if(output == "success")
		{
			window.location = 'admin.php';
		}
	}
}

// Method to login and authenticate an admin / operator user.
function adminLogin()
{
	var thisdate = new Date();
	var type = "&type=adminLogin";
	type += "&username=" + document.getElementById("username").value;
	type += "&password=" + document.getElementById("password").value;

	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){adminLoginAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function adminLoginAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		if(output == "success")
		{
			// alert("Login Successful");
			window.location = 'admin.php';
		}
		else
		{
			alert("Sorry, please ensure your login credentials are correct!");
			// document.getElementById('username').value = "";
			document.getElementById('password').value = "";
		}
	}
}

// Method to logout user.
function adminLogout()
{
	var thisdate = new Date();
	var type = "&type=adminLogout";

	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){adminLogoutAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function adminLogoutAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		if(output == "success")
		{
			alert("Logout Successful");
			window.location = 'admin_login.php';
		}
		else
		{
			alert("Sorry, there was a problem logging you out!");
		}
	}
}
