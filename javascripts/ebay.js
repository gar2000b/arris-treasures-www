// JavaScript Document

// For use within uploadSiteHostedPicturesRequestAjax
var counterTemp1 = 0;
var arrayLengthTemp = 0;
var arrayPositionTemp = 0;

var counterUploadSiteHostedPicturesRequest = 0;
var pauseFlagUploadSiteHostedPicturesRequest = false;

// For use within uploadSiteHostedPicturesNoStoneRequestAjax
var counterTemp3 = 0;
var arrayLengthTemp3 = 0;
var arrayPositionTemp3 = 0;

var counterUploadSiteHostedPicturesNoStoneRequest = 0;
var pauseFlagUploadSiteHostedPicturesNoStoneRequest = false;

// For use within uploadSiteHostedPicturesBeltBuckleRequestAjax
var counterTemp4 = 0;
var arrayLengthTemp4 = 0;
var arrayPositionTemp4 = 0;

var counterUploadSiteHostedPicturesBeltBuckleRequest = 0;
var pauseFlagUploadSiteHostedPicturesBeltBuckleRequest = false;

// For use within addItemRequestAjax
var counterTemp2 = 0;
var arrayLengthTemp2 = 0;
var arrayPositionTemp2 = 0;

// For use within getEbayTimeRequestsetAjax
var counter = 0;
var pauseFlag = false;

// For use within createKiltPinListingsAjax
var counterCreateKiltPinListingsAjax = 0;
var pauseFlagCreateKiltPinListingsAjax = false;

// For use within createKiltPinsListingsAjax
var counterCreateKiltPinsListingsAjax = 0;
var pauseFlagCreateKiltPinsListingsAjax = false;

// For use within createKiltPinNoStoneListingsAjax
var counterCreateKiltPinNoStoneListingsAjax = 0;
var pauseFlagCreateKiltPinNoStoneListingsAjax = false;

// For use within createBeltBuckleListingsAjax
var counterCreateBeltBuckleListingsAjax = 0;
var pauseFlagCreateBeltBuckleListingsAjax = false;

var counterAddItemRequestAjax = 0;
var pauseFlagAddItemRequestAjax = false;

var counterAddItemRequestPinsAjax = 0;
var pauseFlagAddItemRequestPinsAjax = false;

var counterAddItemNoStoneRequestAjax = 0;
var pauseFlagAddItemNoStoneRequestAjax = false;

var counterAddItemBeltBuckleRequestAjax = 0;
var pauseFlagAddItemBeltBuckleRequestAjax = false;

function getEbayTimeRequestsetAjax()
{
	var thisdate = new Date();
	var type = "&type=getEbayTimeRequest";
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlag == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){getEbayTimeRequestsetAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function getEbayTimeRequestsetAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
		{
			outputDiv.innerHTML = output;
			
			counter++;
			var counterDiv = document.getElementById("counter");
			counterDiv.innerHTML = counter;
			
			if(counter < 100)
			{
				getEbayTimeRequestsetAjax();
			}
			else
			{
				counter = 0;
				document.getElementById('pauseContinueGetEbayTimeRequestset').disabled=true;
			}
		}
		else
		{
			outputDiv.innerHTML = output;
		}
	}
}

function pauseContinueGetEbayTimeRequestset()
{
	// alert("Do I get called. " + document.getElementById("pauseContinueGetEbayTimeRequestset").value);
	if(document.getElementById("pauseContinueGetEbayTimeRequestset").value == "Continue")
	{
		document.getElementById("pauseContinueGetEbayTimeRequestset").value = "Pause";
		pauseFlag = false;
		getEbayTimeRequestsetAjax();
	}
	else if(document.getElementById("pauseContinueGetEbayTimeRequestset").value == "Pause")
	{
		document.getElementById("pauseContinueGetEbayTimeRequestset").value = "Continue";
		pauseFlag = true;
		
	}
}

// --------------------------------

function uploadSiteHostedPicturesRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=uploadSiteHostedPicturesRequest";
	if(counterTemp1 == 0)
	{
		type += "&firstCall=true";
	}
	else if(arrayPositionTemp < arrayLengthTemp)
	{
		type += "&position=" + arrayPositionTemp;
		arrayPositionTemp++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;

	if(pauseFlagUploadSiteHostedPicturesRequest == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){uploadSiteHostedPicturesRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function uploadSiteHostedPicturesRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputUploadSiteHostedPicturesRequest");
		// Set div to output.
		var output = xmlhttp.responseText;
		// alert(output + " and countertemp1 = " + counterTemp1);

		if(counterTemp1 == 0)
		{
			arrayLengthTemp = output;
			arrayPositionTemp = 0;
			counterTemp1++;
			uploadSiteHostedPicturesRequestAjax();
		}
		else
		{
			//if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
			//{
				outputDiv.innerHTML = output;
				// alert('output is = ' + output);
				var counterDiv = document.getElementById("counterUploadSiteHostedPicturesRequest");
				counterDiv.innerHTML = counterTemp1;
				
				// alert('arrayLengthTemp = ' + arrayLengthTemp + ' and counterTemp1 = ' + counterTemp1);
				if(arrayLengthTemp != counterTemp1)
				{
					counterTemp1++;
					uploadSiteHostedPicturesRequestAjax();
				}
				else
				{
					// finish gracefully.
					counterTemp1 = 0;
					document.getElementById('pauseContinueUploadSiteHostedPicturesRequest').disabled=true;
				}
			//}
			//else
			//{
			//	outputDiv.innerHTML = output;
			//}
		}
	}
}

function pauseContinueUploadSiteHostedPicturesRequest()
{
	if(document.getElementById("pauseContinueUploadSiteHostedPicturesRequest").value == "Continue")
	{
		document.getElementById("pauseContinueUploadSiteHostedPicturesRequest").value = "Pause";
		pauseFlagUploadSiteHostedPicturesRequest = false;
		uploadSiteHostedPicturesRequestAjax();
	}
	else if(document.getElementById("pauseContinueUploadSiteHostedPicturesRequest").value == "Pause")
	{
		document.getElementById("pauseContinueUploadSiteHostedPicturesRequest").value = "Continue";
		pauseFlagUploadSiteHostedPicturesRequest = true;
		
	}
}

// --------------------------------

function uploadSiteHostedPicturesNoStoneRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=uploadNoStonesSiteHostedPicturesRequest";
	if(counterTemp3 == 0)
	{
		type += "&firstCall=true";
	}
	else if(arrayPositionTemp3 < arrayLengthTemp3)
	{
		type += "&position=" + arrayPositionTemp3;
		arrayPositionTemp3++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;

	if(pauseFlagUploadSiteHostedPicturesNoStoneRequest == false)
	{
		// alert('Do we get here.');
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){uploadSiteHostedPicturesNoStoneRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function uploadSiteHostedPicturesNoStoneRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputUploadNoStoneSiteHostedPicturesRequest");
		// Set div to output.
		var output = xmlhttp.responseText;
		// alert(output + " and countertemp1 = " + counterTemp1);

		if(counterTemp3 == 0)
		{
			arrayLengthTemp3 = output;
			arrayPositionTemp3 = 0;
			counterTemp3++;
			uploadSiteHostedPicturesNoStoneRequestAjax();
		}
		else
		{
			//if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
			//{
				outputDiv.innerHTML = output;
				// alert('output is = ' + output);
				var counterDiv = document.getElementById("counterUploadNoStoneSiteHostedPicturesRequest");
				counterDiv.innerHTML = counterTemp3;
				
				// alert('arrayLengthTemp = ' + arrayLengthTemp + ' and counterTemp1 = ' + counterTemp1);
				if(arrayLengthTemp3 != counterTemp3)
				{
					counterTemp3++;
					uploadSiteHostedPicturesNoStoneRequestAjax();
				}
				else
				{
					// finish gracefully.
					counterTemp3 = 0;
					document.getElementById('pauseContinueUploadNoStoneSiteHostedPicturesRequest').disabled=true;
				}
			//}
			//else
			//{
			//	outputDiv.innerHTML = output;
			//}
		}
	}
}

function pauseContinueUploadNoStoneSiteHostedPicturesRequest()
{
	if(document.getElementById("pauseContinueUploadNoStoneSiteHostedPicturesRequest").value == "Continue")
	{
		document.getElementById("pauseContinueUploadNoStoneSiteHostedPicturesRequest").value = "Pause";
		pauseFlagUploadSiteHostedPicturesNoStoneRequest = false;
		uploadSiteHostedPicturesNoStoneRequestAjax();
	}
	else if(document.getElementById("pauseContinueUploadNoStoneSiteHostedPicturesRequest").value == "Pause")
	{
		document.getElementById("pauseContinueUploadNoStoneSiteHostedPicturesRequest").value = "Continue";
		pauseFlagUploadSiteHostedPicturesNoStoneRequest = true;
		
	}
}

// -----------------------------------------------------

function uploadBeltBuckleSiteHostedPicturesRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=uploadBeltBuckleSiteHostedPicturesRequest";
	if(counterTemp4 == 0)
	{
		type += "&firstCall=true";
	}
	else if(arrayPositionTemp4 < arrayLengthTemp4)
	{
		type += "&position=" + arrayPositionTemp4;
		arrayPositionTemp4++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;

	if(pauseFlagUploadSiteHostedPicturesBeltBuckleRequest == false)
	{
		// alert('Do we get here.');
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){uploadSiteHostedPicturesBeltBuckleRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function uploadSiteHostedPicturesBeltBuckleRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputUploadBeltBuckleSiteHostedPicturesRequest");
		// Set div to output.
		var output = xmlhttp.responseText;
		// alert(output + " and countertemp1 = " + counterTemp1);

		if(counterTemp4 == 0)
		{
			arrayLengthTemp4 = output;
			arrayPositionTemp4 = 0;
			counterTemp4++;
			uploadBeltBuckleSiteHostedPicturesRequestAjax();
		}
		else
		{
			//if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
			//{
				outputDiv.innerHTML = output;
				// alert('output is = ' + output);
				var counterDiv = document.getElementById("counterUploadBeltBuckleSiteHostedPicturesRequest");
				counterDiv.innerHTML = counterTemp4;
				
				// alert('arrayLengthTemp = ' + arrayLengthTemp + ' and counterTemp1 = ' + counterTemp1);
				if(arrayLengthTemp4 != counterTemp4)
				{
					counterTemp4++;
					uploadBeltBuckleSiteHostedPicturesRequestAjax();
				}
				else
				{
					// finish gracefully.
					counterTemp4 = 0;
					document.getElementById('pauseContinueUploadBeltBuckleSiteHostedPicturesRequest').disabled=true;
				}
			//}
			//else
			//{
			//	outputDiv.innerHTML = output;
			//}
		}
	}
}

function pauseContinueUploadBeltBuckleSiteHostedPicturesRequest()
{
	if(document.getElementById("pauseContinueUploadBeltBuckleSiteHostedPicturesRequest").value == "Continue")
	{
		document.getElementById("pauseContinueUploadBeltBuckleSiteHostedPicturesRequest").value = "Pause";
		pauseFlagUploadSiteHostedPicturesBeltBuckleRequest = false;
		uploadBeltBuckleSiteHostedPicturesRequestAjax();
	}
	else if(document.getElementById("pauseContinueUploadBeltBuckleSiteHostedPicturesRequest").value == "Pause")
	{
		document.getElementById("pauseContinueUploadBeltBuckleSiteHostedPicturesRequest").value = "Continue";
		pauseFlagUploadSiteHostedPicturesBeltBuckleRequest = true;
		
	}
}

// -----------------------------------------------------

function createKiltPinListingsAjax()
{
	var thisdate = new Date();
	var type = "&type=createKiltPinListings";
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagCreateKiltPinListingsAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){createKiltPinListingsAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function createKiltPinListingsAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputCreateKiltPinListings");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
		{
			outputDiv.innerHTML = output;
			
			counterCreateKiltPinListingsAjax++;
			var counterDiv = document.getElementById("counterCreateKiltPinListings");
			counterDiv.innerHTML = counterCreateKiltPinListingsAjax;
			
			if(counterCreateKiltPinListingsAjax < 1)
			{
				getEbayTimeRequestsetAjax();
			}
			else
			{
				counterCreateKiltPinListingsAjax = 0;
				document.getElementById('pauseContinueGetEbayTimeRequestset').disabled=true;
			}
		}
		else
		{
			outputDiv.innerHTML = output;
		}
	}
}

function pauseContinueCreateKiltPinListings()
{
	// alert("Do I get called. " + document.getElementById("pauseContinueGetEbayTimeRequestset").value);
	if(document.getElementById("pauseContinueCreateKiltPinListings").value == "Continue")
	{
		document.getElementById("pauseContinueCreateKiltPinListings").value = "Pause";
		pauseFlagCreateKiltPinListingsAjax = false;
		getEbayTimeRequestsetAjax();
	}
	else if(document.getElementById("pauseContinueCreateKiltPinListings").value == "Pause")
	{
		document.getElementById("pauseContinueCreateKiltPinListings").value = "Continue";
		pauseFlagCreateKiltPinListingsAjax = true;
		
	}
}

// ----------------------------------------

function createKiltPinsListingsAjax()
{
	var thisdate = new Date();
	var type = "&type=createKiltPinsListings";
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagCreateKiltPinsListingsAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){createKiltPinsListingsAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function createKiltPinsListingsAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputCreateKiltPinsListings");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
		{
			outputDiv.innerHTML = output;
			
			counterCreateKiltPinsListingsAjax++;
			var counterDiv = document.getElementById("counterCreateKiltPinsListings");
			counterDiv.innerHTML = counterCreateKiltPinsListingsAjax;
			
			if(counterCreateKiltPinsListingsAjax < 1)
			{
				getEbayTimeRequestsetAjax();
			}
			else
			{
				counterCreateKiltPinsListingsAjax = 0;
				document.getElementById('pauseContinueGetEbayTimeRequestset').disabled=true;
			}
		}
		else
		{
			outputDiv.innerHTML = output;
		}
	}
}

function pauseContinueCreateKiltPinListings()
{
	// alert("Do I get called. " + document.getElementById("pauseContinueGetEbayTimeRequestset").value);
	if(document.getElementById("pauseContinueCreateKiltPinListings").value == "Continue")
	{
		document.getElementById("pauseContinueCreateKiltPinListings").value = "Pause";
		pauseFlagCreateKiltPinListingsAjax = false;
		getEbayTimeRequestsetAjax();
	}
	else if(document.getElementById("pauseContinueCreateKiltPinListings").value == "Pause")
	{
		document.getElementById("pauseContinueCreateKiltPinListings").value = "Continue";
		pauseFlagCreateKiltPinListingsAjax = true;
		
	}
}

// ----------------------------------------

function createKiltPinNoStoneListingsAjax()
{
	var thisdate = new Date();
	var type = "&type=createKiltPinNoStoneListings";
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagCreateKiltPinNoStoneListingsAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){createKiltPinNoStoneListingsAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function createKiltPinNoStoneListingsAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputCreateKiltPinNoStoneListings");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
		{
			outputDiv.innerHTML = output;
			
			counterCreateKiltPinNoStoneListingsAjax++;
			var counterDiv = document.getElementById("counterCreateKiltPinNoStoneListings");
			counterDiv.innerHTML = counterCreateKiltPinNoStoneListingsAjax;
			
			if(counterCreateKiltPinNoStoneListingsAjax < 1)
			{
				createKiltPinNoStoneListingsAjax();
			}
			else
			{
				counterCreateKiltPinNoStoneListingsAjax = 0;
				document.getElementById('pauseContinueCreateKiltPinNoStoneListings').disabled=true;
			}
		}
		else
		{
			outputDiv.innerHTML = output;
		}
	}
}

function pauseContinueCreateKiltPinNoStoneListing()
{
	// alert("Do I get called. " + document.getElementById("pauseContinueGetEbayTimeRequestset").value);
	if(document.getElementById("pauseContinueCreateKiltPinNoStoneListings").value == "Continue")
	{
		document.getElementById("pauseContinueCreateKiltPinNoStoneListings").value = "Pause";
		pauseFlagCreateKiltPinNoStoneListingsAjax = false;
		createKiltPinNoStoneListingsAjax();
	}
	else if(document.getElementById("pauseContinueCreateKiltPinNoStoneListings").value == "Pause")
	{
		document.getElementById("pauseContinueCreateKiltPinNoStoneListings").value = "Continue";
		pauseFlagCreateKiltPinNoStoneListingsAjax = true;
		
	}
}

// ----------------------------------------

function createBeltBuckleListingsAjax()
{
	var thisdate = new Date();
	var type = "&type=createBeltBuckleListings";
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagCreateBeltBuckleListingsAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){createBeltBuckleListingsAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function createBeltBuckleListingsAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputCreateBeltBuckleListings");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(output.match("&lt;Ack&gt;Success&lt;/Ack&gt;") != null)
		{
			outputDiv.innerHTML = output;
			
			counterCreateBeltBuckleListingsAjax++;
			var counterDiv = document.getElementById("counterCreateBeltBuckleListings");
			counterDiv.innerHTML = counterCreateBeltBuckleListingsAjax;
			
			if(counterCreateBeltBuckleListingsAjax < 1)
			{
				createBeltBuckleListingsAjax();
			}
			else
			{
				counterCreateBeltBuckleListingsAjax = 0;
				document.getElementById('pauseContinueCreateBeltBuckleListings').disabled=true;
			}
		}
		else
		{
			outputDiv.innerHTML = output;
		}
	}
}

function pauseContinueCreateBeltBuckleListings()
{
	// alert("Do I get called. " + document.getElementById("pauseContinueGetEbayTimeRequestset").value);
	if(document.getElementById("pauseContinueCreateBeltBuckleListings").value == "Continue")
	{
		document.getElementById("pauseContinueCreateBeltBuckleListings").value = "Pause";
		pauseFlagCreateBeltBuckleListingsAjax = false;
		createBeltBuckleListingsAjax();
	}
	else if(document.getElementById("pauseContinueCreateBeltBuckleListings").value == "Pause")
	{
		document.getElementById("pauseContinueCreateBeltBuckleListings").value = "Continue";
		pauseFlagCreateBeltBuckleListingsAjax = true;
		
	}
}

// ----------------------------------------

function addItemRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=addItemRequest";
	var noOfListings = document.getElementById("kilt_pin_listing_qty").value;
	if(counterTemp2 == 0)
	{
		type += "&firstCall=true";
		type += "&noOfListings=" + noOfListings;
	}
	else if(arrayPositionTemp2 < arrayLengthTemp2)
	{
		type += "&position=" + arrayPositionTemp2;
		arrayPositionTemp2++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagAddItemRequestAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){getAddItemRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function getAddItemRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputAddItemRequest");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(counterTemp2 == 0)
		{
			alert("Size is " + output);
			arrayLengthTemp2 = output;
			arrayPositionTemp2 = 0;
			counterTemp2++;
			addItemRequestAjax();
		}
		else
		{
			// alert("am i being called 2 - " + output);
			if(output.match("Success") != null)
			{
				// alert("am i being called 3");
				outputDiv.innerHTML = output;
				// alert("0");
				counterAddItemRequestAjax++;
				var counterDiv = document.getElementById("counterAddItemRequest");
				counterDiv.innerHTML = counterAddItemRequestAjax;
				
				// alert("1");
				if(arrayLengthTemp2 != counterTemp2)
				{
					// alert("2");
					counterTemp2++;
					addItemRequestAjax();
				}
				else
				{
					// alert("3");
					// finish gracefully.
					counterTemp2 = 0;
					document.getElementById('pauseContinueAddItemRequest').disabled=true;
				}
			}
			else
			{
				// outputDiv.innerHTML = output;
			}
		}
	}
}

function pauseContinueAddItemRequest()
{
	if(document.getElementById("pauseContinueAddItemRequest").value == "Continue")
	{
		document.getElementById("pauseContinueAddItemRequest").value = "Pause";
		pauseFlagAddItemRequestAjax = false;
		addItemRequestAjax();
	}
	else if(document.getElementById("pauseContinueAddItemRequest").value == "Pause")
	{
		document.getElementById("pauseContinueAddItemRequest").value = "Continue";
		pauseFlagAddItemRequestAjax = true;
		
	}
}

// ----------------------------------------

function addItemRequestPinsAjax()
{
	var thisdate = new Date();
	var type = "&type=addItemRequestPins";
	var noOfListings = document.getElementById("kilt_pins_listing_qty").value;
	if(counterTemp2 == 0)
	{
		type += "&firstCall=true";
		type += "&noOfListings=" + noOfListings;
	}
	else if(arrayPositionTemp2 < arrayLengthTemp2)
	{
		type += "&position=" + arrayPositionTemp2;
		arrayPositionTemp2++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	// alert(serverPage);
	
	if(pauseFlagAddItemRequestAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){getAddItemRequestPinsAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function getAddItemRequestPinsAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputAddItemRequestPins");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(counterTemp2 == 0)
		{
			alert("Size is " + output);
			arrayLengthTemp2 = output;
			arrayPositionTemp2 = 0;
			counterTemp2++;
			addItemRequestPinsAjax();
		}
		else
		{
			// alert("am i being called 2 - " + output);
			if(output.match("Success") != null)
			{
				// alert("am i being called 3");
				outputDiv.innerHTML = output;
				// alert("0");
				counterAddItemRequestPinsAjax++;
				var counterDiv = document.getElementById("counterAddItemRequestPins");
				counterDiv.innerHTML = counterAddItemRequestPinsAjax;
				
				// alert("1");
				if(arrayLengthTemp2 != counterTemp2)
				{
					// alert("2");
					counterTemp2++;
					addItemRequestPinsAjax();
				}
				else
				{
					// alert("3");
					// finish gracefully.
					counterTemp2 = 0;
					document.getElementById('pauseContinueAddItemRequestPins').disabled=true;
				}
			}
			else
			{
				// outputDiv.innerHTML = output;
			}
		}
	}
}

function pauseContinueAddItemRequestPins()
{
	if(document.getElementById("pauseContinueAddItemRequestPins").value == "Continue")
	{
		document.getElementById("pauseContinueAddItemRequestPins").value = "Pause";
		pauseFlagAddItemRequestPinsAjax = false;
		addItemRequestPinsAjax();
	}
	else if(document.getElementById("pauseContinueAddItemRequestPins").value == "Pause")
	{
		document.getElementById("pauseContinueAddItemRequestPins").value = "Continue";
		pauseFlagAddItemRequestPinsAjax = true;
		
	}
}

// --------------------------------------------------------

function addItemNoStoneRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=addItemNoStoneRequest";
	var noOfListings = document.getElementById("kilt_pin_no_stone_listing_qty").value;
	if(counterTemp2 == 0)
	{
		type += "&firstCall=true";
		type += "&noOfListings=" + noOfListings;
	}
	else if(arrayPositionTemp2 < arrayLengthTemp2)
	{
		type += "&position=" + arrayPositionTemp2;
		arrayPositionTemp2++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagAddItemNoStoneRequestAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){getAddItemNoStoneRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function getAddItemNoStoneRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputAddItemNoStoneRequest");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(counterTemp2 == 0)
		{
			alert("Size is " + output);
			arrayLengthTemp2 = output;
			arrayPositionTemp2 = 0;
			counterTemp2++;
			addItemNoStoneRequestAjax();
		}
		else
		{
			// alert("am i being called 2 - " + output);
			if(output.match("Success") != null)
			{
				// alert("am i being called 3");
				outputDiv.innerHTML = output;
				// alert("0");
				counterAddItemNoStoneRequestAjax++;
				var counterDiv = document.getElementById("counterAddItemNoStoneRequest");
				counterDiv.innerHTML = counterAddItemNoStoneRequestAjax;
				
				// alert("1");
				if(arrayLengthTemp2 != counterTemp2)
				{
					// alert("2");
					counterTemp2++;
					addItemNoStoneRequestAjax();
				}
				else
				{
					// alert("3");
					// finish gracefully.
					counterTemp2 = 0;
					document.getElementById('pauseContinueAddItemNoStoneRequest').disabled=true;
				}
			}
			else
			{
				// outputDiv.innerHTML = output;
			}
		}
	}
}

function pauseContinueAddItemNoStoneRequest()
{
	if(document.getElementById("pauseContinueAddItemNoStoneRequest").value == "Continue")
	{
		document.getElementById("pauseContinueAddItemNoStoneRequest").value = "Pause";
		pauseFlagAddItemNoStoneRequestAjax = false;
		addItemNoStoneRequestAjax();
	}
	else if(document.getElementById("pauseContinueAddItemNoStoneRequest").value == "Pause")
	{
		document.getElementById("pauseContinueAddItemNoStoneRequest").value = "Continue";
		pauseFlagAddItemNoStoneRequestAjax = true;
		
	}
}

// ----------------------------------------

function addItemBeltBuckleRequestAjax()
{
	var thisdate = new Date();
	var type = "&type=addItemBeltBuckleRequest";
	var noOfListings = document.getElementById("belt_buckle_listing_qty").value;
	if(counterTemp2 == 0)
	{
		type += "&firstCall=true";
		type += "&noOfListings=" + noOfListings;
	}
	else if(arrayPositionTemp2 < arrayLengthTemp2)
	{
		type += "&position=" + arrayPositionTemp2;
		arrayPositionTemp2++;
	}
	var serverPage = "../php_scripts/ebay.php?time=" + thisdate.getTime() + type;
	
	if(pauseFlagAddItemBeltBuckleRequestAjax == false)
	{
		xmlhttp = getxmlhttp();
		xmlhttp.open("GET", serverPage);
		// alert(objID);
		xmlhttp.onreadystatechange = function(){getAddItemBeltBuckleRequestAjaxHandler(xmlhttp);}
		xmlhttp.send(null);
	}
}

function getAddItemBeltBuckleRequestAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("outputAddItemBeltBuckleRequest");
		// Set div to output.
		var output = xmlhttp.responseText;

		if(counterTemp2 == 0)
		{
			alert("Size is " + output);
			arrayLengthTemp2 = output;
			arrayPositionTemp2 = 0;
			counterTemp2++;
			addItemBeltBuckleRequestAjax();
		}
		else
		{
			// alert("am i being called 2 - " + output);
			if(output.match("Success") != null)
			{
				// alert("am i being called 3");
				outputDiv.innerHTML = output;
				// alert("0");
				counterAddItemBeltBuckleRequestAjax++;
				var counterDiv = document.getElementById("counterAddItemBeltBuckleRequest");
				counterDiv.innerHTML = counterAddItemBeltBuckleRequestAjax;
				
				// alert("1");
				if(arrayLengthTemp2 != counterTemp2)
				{
					// alert("2");
					counterTemp2++;
					addItemBeltBuckleRequestAjax();
				}
				else
				{
					// alert("3");
					// finish gracefully.
					counterTemp2 = 0;
					document.getElementById('pauseContinueAddItemBeltBuckleRequest').disabled=true;
				}
			}
			else
			{
				// outputDiv.innerHTML = output;
			}
		}
	}
}

function pauseContinueAddItemBeltBuckleRequest()
{
	if(document.getElementById("pauseContinueAddItemBeltBuckleRequest").value == "Continue")
	{
		document.getElementById("pauseContinueAddItemBeltBuckleRequest").value = "Pause";
		pauseFlagAddItemBeltBuckleRequestAjax = false;
		addItemBeltBuckleRequestAjax();
	}
	else if(document.getElementById("pauseContinueAddItemBeltBuckleRequest").value == "Pause")
	{
		document.getElementById("pauseContinueAddItemBeltBuckleRequest").value = "Continue";
		pauseFlagAddItemBeltBuckleRequestAjax = true;
		
	}
}

// ----------------------------------------