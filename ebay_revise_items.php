<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>eBay Revise Items</title>
</head>

<body>
<p>
<?php

require_once("php_scripts/common.php");
require_once('php_scripts/connect_alba_db.php');

global $responseXmlReviseItemRequest;
// Perform the actual eBay call ReviseItemRequest.
// Make the API call.
error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
// production
$endpoint = 'https://api.ebay.com/ws/api.dll'; // URL to call.

$query = "SELECT * FROM ebay_kilt_pin_listing;";
$result = @mysql_query($query); // Run the query.
if($result)
{
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$return_xml = simplexml_load_string($row['return_xml']);
		if($return_xml->Ack != "Failure")
		{
			$ItemID = $return_xml->ItemID;
			$resp = simplexml_load_string(constructCallAndGetResponseReviseItemRequestUK($endpoint, $ItemID));
			echo "<pre>" . htmlentities($responseXmlReviseItemRequest) . "</pre>";
		}
		else
		{
			echo "Failure";
		}
	}
	echo "<br>Ebay Revise Items - Done";
}

function constructCallAndGetResponseReviseItemRequestUK($endpoint, $ItemID)
{
	global $xmlRequestReviseItemRequest;
	global $responseXmlReviseItemRequest;

  // Create the XML request to be POSTed.
	$xmlRequestReviseItemRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xmlRequestReviseItemRequest .= "<ReviseItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
	$xmlRequestReviseItemRequest .= "<ErrorLanguage>en_GB</ErrorLanguage>\n"; // uk
	$xmlRequestReviseItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestReviseItemRequest .= "<Item>\n";
	$xmlRequestReviseItemRequest .= "<ItemID>$ItemID</ItemID>\n";
	$xmlRequestReviseItemRequest .= "<PayPalEmailAddress>payments@arristreasures.com</PayPalEmailAddress>\n";
	$xmlRequestReviseItemRequest .= "</Item>\n";

	// production
	$xmlRequestReviseItemRequest .= "<RequesterCredentials>\n";
	$xmlRequestReviseItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
	$xmlRequestReviseItemRequest .= "</RequesterCredentials>\n";
	
	$xmlRequestReviseItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestReviseItemRequest .= "</ReviseItemRequest>\n";
	
	// production
	// Set up the HTTP headers.
	$headers = array(
	'X-EBAY-API-COMPATIBILITY-LEVEL:705',
	'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
	'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
	'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
	'X-EBAY-API-SITEID:3'/*'X-EBAY-API-SITEID:0'*/,
	'X-EBAY-API-CALL-NAME:ReviseItem',
	); // uk site = 3, us site = 0
	
	$session  = curl_init($endpoint);                       // create a curl session.
	curl_setopt($session, CURLOPT_POST, true);              // POST request type.
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
	curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestReviseItemRequest); // set the body of the POST.
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
	
	$responseXmlReviseItemRequest = curl_exec($session);	// send the request.
	curl_close($session);                               // close the session.
	return $responseXmlReviseItemRequest;					// returns a string.
}

?>
</p>
</body>
</html>
