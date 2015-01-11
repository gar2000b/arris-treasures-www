// JavaScript Document

// Ajax Code -----------------------------------------------------------

// Globals used to control time clock - see startClock() function.

var xx = 5;
var yy = 1;

// This function creates the actual xmlhttp object for asynchronus calls to web resources such as PHP or HTML files.
function getxmlhttp()
{
	// Create a boolean variable to check for a valid internet explorer instance.
	var xmlhttp = false;
	
	// Check if we are using Internet Explorer.
	try
	{
		// If the jav ascript version is greater than 5.
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
		// alert("You are using microsoft internet explorer - javascript is greater than 5.");
	}
	catch(e)
	{
		// If not then use the older active x object.
		try
		{
			// If we are using internet explorer.
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			// alert("You are using microsoft internet explorer - using older active x object");
		}
		catch(E)
		{
			// Else we must be using a non-IE browser.
			xmlhttp = false;
		}
	}
	
	// If we are using a non-internet explorer browser, create a javascript instance of the object.
	if(!xmlhttp && typeof XMLHttpRequest != 'undefined')
	{
		xmlhttp = new XMLHttpRequest();
		// alert("You are using another browser not Internet Explorer");
	}
	
	return xmlhttp;
}



// This last function makerequest() may be redundant and was used for basic GET requests... Left in for completeness.  
// You will find that this code has been build into the processajax function.

function makerequest(serverPage)
{
	// var obj = document.getElementById('product_details');
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	// alert(objID);
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			alert(xmlhttp.responseText);
		}
	}
	xmlhttp.send(null);
}

// End of Ajax Code.
// ----------------------------------------------------------------------------------------------

function call_ajax()
{
	var thisdate = new Date();
	var a = thisdate.getTime();
	
	var serverPage = "http://www.inkshopcrm.com/php_scripts/test_ajax.php?time=" + a;
	// serverPage = serverPage.replace(/\+/, "\&#43;");
	// &#43;
	// alert('Serverpage is ' + serverPage);
	makerequest(serverPage);
}