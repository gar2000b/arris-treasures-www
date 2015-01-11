// JavaScript Document

function findYourClan()
{
	// alert(document.getElementById("surname").value);
	var outputDiv = document.getElementById("results");
	outputDiv.innerHTML = "<p>Searching...</p>";
	var thisdate = new Date();
	var type = "&type=findYourClan";
	var surname = "&surname=" + document.getElementById("surname").value;
	var serverPage = "../php_scripts/find_your_clan.php?time=" + thisdate.getTime() + type + surname;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	// alert(objID);
	xmlhttp.onreadystatechange = function(){findYourClanAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function findYourClanAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("results");
		// Set div to output.
		var output = xmlhttp.responseText;

		outputDiv.innerHTML = output;
	}
}