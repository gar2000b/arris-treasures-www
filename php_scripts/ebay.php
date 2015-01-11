<?php

// connect to the database.
require_once('./connect_alba_db.php');
require_once('./common.php');
session_start(); // start up your PHP session!

switch($_GET['type'])
{
	case 'getEbayTimeRequest':
	getEbayTimeRequest();
	break;
	case 'uploadSiteHostedPicturesRequest':
	uploadSiteHostedPicturesRequest();
	break;
	case 'createKiltPinListings':
	createKiltPinListings();
	break;
	case 'addItemRequest':
	addItemRequest();
	break;
	case 'createKiltPinsListings':
	createKiltPinsListings();
	break;
	case 'addItemRequestPins':
	addItemRequestPins();
	break;
	case 'uploadNoStonesSiteHostedPicturesRequest':
	uploadNoStonesSiteHostedPicturesRequest();
	break;
	case 'createKiltPinNoStoneListings':
	createKiltPinNoStoneListings();
	break;
	case 'addItemNoStoneRequest':
	addItemNoStoneRequest();
	break;
	case 'uploadBeltBuckleSiteHostedPicturesRequest':
	uploadBeltBuckleSiteHostedPicturesRequest();
	break;
	case 'createBeltBuckleListings':
	createBeltBuckleListings();
	break;
	case 'addItemBeltBuckleRequest':
	addItemBeltBuckleRequest();
	break;
}

function getEbayTimeRequest()
{
	global $responseXmlGetEbayTimeRequest;
	error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
	// API request variables
	$endpoint = 'http://open.api.sandbox.ebay.com/shopping?';  // URL to call.

	// Load the call and capture the response returned by the eBay API
	// The constructPostCallAndGetResponseGetEbayTimeRequest function is defined below.
	$resp = simplexml_load_string(constructPostCallAndGetResponseGetEbayTimeRequest($endpoint));
	
	// We can now do stuff with the reponse onject like parse it etc...
	if ($resp->Ack == "Success") {
		$result = "<pre>" . htmlentities($responseXmlGetEbayTimeRequest) . "</pre>";
		$result .= "<p>Timestamp = $resp->Timestamp</p>";
		$result .= "<p>Build = $resp->Build</p>";
		$result .= "<p>Version = $resp->Version</p>";
		echo $result;
	} else {
		$result = "<pre>" . htmlentities($responseXmlGetEbayTimeRequest) . "</pre>";
		$result .= "<p>Sorry, there was a problem with the request</p>" . $resp->Ack;
		echo $result;
	}
}

function constructPostCallAndGetResponseGetEbayTimeRequest($endpoint) {
  global $xmlRequestGetEbayTimeRequest;
  global $responseXmlGetEbayTimeRequest;

  // Create the XML request to be POSTed.
  $xmlRequestGetEbayTimeRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlRequestGetEbayTimeRequest .= "<GeteBayTimeRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  $xmlRequestGetEbayTimeRequest .= "</GeteBayTimeRequest>";
  
  // Set up the HTTP headers.
  $headers = array(
    'X-EBAY-API-APP-ID:Digilogu-5bba-4e60-b088-5926316e6c3a',
    'X-EBAY-API-VERSION:697',
    'X-EBAY-API-SITE-ID:3',
    'X-EBAY-API-CALL-NAME:GeteBayTime',
    'X-EBAY-API-REQUEST-ENCODING:XML',
    'Content-Type: text/xml;charset=utf-8',
  );
  
  $session  = curl_init($endpoint);                       // create a curl session.
  curl_setopt($session, CURLOPT_POST, true);              // POST request type.
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestGetEbayTimeRequest); // set the body of the POST.
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
  
  $responseXmlGetEbayTimeRequest = curl_exec($session);   // send the request.
  curl_close($session);                                   // close the session.
  return $responseXmlGetEbayTimeRequest;                  // returns a string.

}  // End of constructPostCallAndGetResponseGetEbayTimeRequest function.

// function to upload images to eBay.
function uploadSiteHostedPicturesRequest()
{
	// If this is the first call, then we have to set all the clan Id's in the database to the session first
	// so that subsequent calls to this function itterate through them to upload their images.
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		// Execute query, populate php array & pass to session.
		// $query = "SELECT * FROM clan WHERE active = 1 AND id > 323;";
		$query = "SELECT * FROM clan WHERE active = 1;";
		// use this for any image uploads that failed.
		// SELECT * FROM clan WHERE active = '1' AND Id NOT IN (SELECT clan_id FROM clan_images);
		// $query = "SELECT * FROM clan WHERE Id = 78 OR Id = 88 OR Id = 93 OR Id = 143 OR Id = 180 OR Id = 187 OR Id = 191 OR Id = 216 OR Id = 218 OR Id = 237 OR Id = 238 OR Id = 258 OR Id = 275 OR Id = 291 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE Id = 78 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE active = 4;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$clanIdArray[] = $row['Id'];
				$clanNameArray[] = $row['name'];
				// $clanId = $row['Id'];
			}
		}
		// Now that the array has been constructed, assign to session variable.
		$_SESSION['clanIdArray'] = $clanIdArray;
		$_SESSION['clanNameArray'] = $clanNameArray;
		$_SESSION['test'] = "test";
		echo sizeof($clanIdArray);
	}
	elseif(isset($_GET['position']))
	{
		// subsequent calls to invoke uploadSiteHostedPicturesRequest eBay API based on array index position.
		$position = $_GET['position'];
		$clanIdArray = $_SESSION['clanIdArray'];
		$clanNameArray = $_SESSION['clanNameArray'];
		$clanId = $clanIdArray[$position];
		$clanName = $clanNameArray[$position];
		
		// Make the API call.
		global $responseXmlUploadSiteHostedPicturesRequest;
		error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
		// API request variables.
		// sandbox
		// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
		
		// production
		$endpoint = 'https://api.ebay.com/ws/api.dll';  // URL to call.
		
		// Load the call and capture the response returned by the eBay API
		// The constructCallAndGetResponseUploadSiteHostedPicturesRequest function is defined below.
		$resp = simplexml_load_string(constructCallAndGetResponseUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName));
		
		// We can now do stuff with the reponse onject like parse it etc...
		if ($resp->Ack == "Success") {
			
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$timeStamp = $resp->Timestamp;
			$build = $resp->Build;
			$version = $resp->Version;
			$pictureSystemVersion = $resp->PictureSystemVersion;
			
			$pictureName = $resp->SiteHostedPictureDetails->PictureName;
			$pictureSet = $resp->SiteHostedPictureDetails->PictureSet;
			$pictureFormat = $resp->SiteHostedPictureDetails->PictureFormat;
			$fullURL = $resp->SiteHostedPictureDetails->FullURL;
			$baseURL = $resp->SiteHostedPictureDetails->BaseURL;
			$externalPictureURL = $resp->SiteHostedPictureDetails->ExternalPictureURL;
			$useByDate = $resp->SiteHostedPictureDetails->UseByDate;
			
			// Insert record into clan_images table.
			$query = "INSERT INTO clan_images(Id, clan_id, ack, time_stamp, build, version, 
picture_system_version, return_xml, picture_name, picture_set, picture_format, 
full_url, base_url, external_picture_url, use_by_date, date_time) VALUES(
'', $clanId, '$resp->Ack', '$timeStamp', '$build', '$version', '$pictureSystemVersion', '$result', '$pictureName', '$pictureSet', 
'$pictureFormat', '$fullURL', '$baseURL', '$externalPictureURL', '$useByDate', NOW());";
			$resultDB = @mysql_query($query); // Run the query.
			if($resultDB)
			{
				// Insert successfull.
				$int_id = mysql_insert_id();
				
				foreach($resp->SiteHostedPictureDetails->PictureSetMember as $PictureSetMember) {
					$MemberURL = $PictureSetMember->MemberURL;
					$PictureHeight  = $PictureSetMember->PictureHeight;
					$PictureWidth = $PictureSetMember->PictureWidth;
					
					$query2 = "INSERT INTO clan_images_members(Id, clan_images, member_url, picture_height, picture_width, date_time) 
	VALUES('', $int_id, '$MemberURL', $PictureHeight, $PictureWidth, NOW());";
					$resultDB2 = @mysql_query($query2); // Run the query.
					if($resultDB2)
					{
						// Insert successfull.
						$int_id2 = mysql_insert_id();
					}
				}
				echo "Success - $int_id";
			}
			else
			{
				echo "Fail";
			}
			
		} else {
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$result .= "<p>Sorry, there was a problem with the request</p>" . $resp->Ack;
			echo $result;
		}
	}
}

function uploadNoStonesSiteHostedPicturesRequest()
{
	// If this is the first call, then we have to set all the clan Id's in the database to the session first
	// so that subsequent calls to this function itterate through them to upload their images.
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		// Use this on mySqlFront to determine missing clans:
		// SELECT * FROM clan WHERE active = '1' AND Id NOT IN (SELECT clan_id FROM clan_no_stone_images);
		// Execute query, populate php array & pass to session.
		$query = "SELECT * FROM clan WHERE active = 1;";
		// $query = "SELECT * FROM clan WHERE Id > 310 AND active = 1;";
		// use this for any image uploads that failed.
		// $query = "SELECT * FROM clan WHERE Id = 9 OR Id = 24 OR Id = 44 OR Id = 101 OR Id = 108 OR Id = 114 OR Id = 121 OR Id = 129 OR Id = 182 OR Id = 210 OR Id = 237 OR Id = 246 OR Id = 261 OR Id = 292 OR Id = 299 OR Id = 335 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE Id = 78 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE active = 4;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$clanIdArray[] = $row['Id'];
				$clanNameArray[] = $row['name'];
				// $clanId = $row['Id'];
			}
		}
		// Now that the array has been constructed, assign to session variable.
		$_SESSION['clanIdArray'] = $clanIdArray;
		$_SESSION['clanNameArray'] = $clanNameArray;
		$_SESSION['test'] = "test";
		echo sizeof($clanIdArray);
	}
	elseif(isset($_GET['position']))
	{
		// subsequent calls to invoke uploadSiteHostedPicturesRequest eBay API based on array index position.
		$position = $_GET['position'];
		$clanIdArray = $_SESSION['clanIdArray'];
		$clanNameArray = $_SESSION['clanNameArray'];
		$clanId = $clanIdArray[$position];
		$clanName = $clanNameArray[$position];
		
		// Make the API call.
		global $responseXmlUploadSiteHostedPicturesRequest;
		error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
		// API request variables.
		// sandbox
		// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
		
		// production
		$endpoint = 'https://api.ebay.com/ws/api.dll';  // URL to call.
		
		// Load the call and capture the response returned by the eBay API
		// The constructCallAndGetResponseNoStonesUploadSiteHostedPicturesRequest function is defined below.
		$resp = simplexml_load_string(constructCallAndGetResponseNoStonesUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName));
		
		// We can now do stuff with the reponse onject like parse it etc...
		if ($resp->Ack == "Success") {
			
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$timeStamp = $resp->Timestamp;
			$build = $resp->Build;
			$version = $resp->Version;
			$pictureSystemVersion = $resp->PictureSystemVersion;
			
			$pictureName = $resp->SiteHostedPictureDetails->PictureName;
			$pictureSet = $resp->SiteHostedPictureDetails->PictureSet;
			$pictureFormat = $resp->SiteHostedPictureDetails->PictureFormat;
			$fullURL = $resp->SiteHostedPictureDetails->FullURL;
			$baseURL = $resp->SiteHostedPictureDetails->BaseURL;
			$externalPictureURL = $resp->SiteHostedPictureDetails->ExternalPictureURL;
			$useByDate = $resp->SiteHostedPictureDetails->UseByDate;
			
			// Insert record into clan_images table.
			$query = "INSERT INTO clan_no_stone_images(Id, clan_id, ack, time_stamp, build, version, 
picture_system_version, return_xml, picture_name, picture_set, picture_format, 
full_url, base_url, external_picture_url, use_by_date, date_time) VALUES(
'', $clanId, '$resp->Ack', '$timeStamp', '$build', '$version', '$pictureSystemVersion', '$result', '$pictureName', '$pictureSet', 
'$pictureFormat', '$fullURL', '$baseURL', '$externalPictureURL', '$useByDate', NOW());";
			$resultDB = @mysql_query($query); // Run the query.
			if($resultDB)
			{
				// Insert successfull.
				$int_id = mysql_insert_id();
				
				foreach($resp->SiteHostedPictureDetails->PictureSetMember as $PictureSetMember) {
					$MemberURL = $PictureSetMember->MemberURL;
					$PictureHeight  = $PictureSetMember->PictureHeight;
					$PictureWidth = $PictureSetMember->PictureWidth;
					

					$query2 = "INSERT INTO clan_no_stone_images_members(Id, clan_images, member_url, picture_height, picture_width, date_time) 
	VALUES('', $int_id, '$MemberURL', $PictureHeight, $PictureWidth, NOW());";
					$resultDB2 = @mysql_query($query2); // Run the query.
					if($resultDB2)
					{
						// Insert successfull.
						$int_id2 = mysql_insert_id();
					}
				}
				echo "Success - $int_id";
			}
			else
			{
				echo "Fail";
			}
			
		} else {
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$result .= "<p>Sorry, there was a problem with the request</p>" . $resp->Ack;
			echo $result;
		}
	}
}

function uploadBeltBuckleSiteHostedPicturesRequest()
{
	// If this is the first call, then we have to set all the clan Id's in the database to the session first
	// so that subsequent calls to this function itterate through them to upload their images.
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		// Use this on mySqlFront to determine missing clans:
		// SELECT * FROM clan WHERE active = '1' AND Id NOT IN (SELECT clan_id FROM clan_no_stone_images);
		// Execute query, populate php array & pass to session.
		$query = "SELECT * FROM clan WHERE active = 1;";
		// $query = "SELECT * FROM clan WHERE Id > 310 AND active = 1;";
		// use this for any image uploads that failed.
		// $query = "SELECT * FROM clan WHERE Id = 7 OR Id = 78 OR Id = 119 OR Id = 136 OR Id = 145 OR Id = 149 OR Id = 150 OR Id = 167 OR Id = 174 OR Id = 208 OR Id = 254 OR Id = 274 OR Id = 311 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE Id = 150 AND active = 1;";
		// $query = "SELECT * FROM clan WHERE active = 4;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$clanIdArray[] = $row['Id'];
				$clanNameArray[] = $row['name'];
				// $clanId = $row['Id'];
			}
		}
		// Now that the array has been constructed, assign to session variable.
		$_SESSION['clanIdArray'] = $clanIdArray;
		$_SESSION['clanNameArray'] = $clanNameArray;
		$_SESSION['test'] = "test";
		echo sizeof($clanIdArray);
	}
	elseif(isset($_GET['position']))
	{
		// subsequent calls to invoke uploadSiteHostedPicturesRequest eBay API based on array index position.
		$position = $_GET['position'];
		$clanIdArray = $_SESSION['clanIdArray'];
		$clanNameArray = $_SESSION['clanNameArray'];
		$clanId = $clanIdArray[$position];
		$clanName = $clanNameArray[$position];
		
		// Make the API call.
		global $responseXmlUploadSiteHostedPicturesRequest;
		error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
		// API request variables.
		// sandbox
		// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
		
		// production
		$endpoint = 'https://api.ebay.com/ws/api.dll';  // URL to call.
		
		// Load the call and capture the response returned by the eBay API
		// The constructCallAndGetResponseNoStonesUploadSiteHostedPicturesRequest function is defined below.
		$resp = simplexml_load_string(constructCallAndGetResponseBeltBuckleUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName));
		
		// We can now do stuff with the reponse onject like parse it etc...
		if ($resp->Ack == "Success") {
			
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$timeStamp = $resp->Timestamp;
			$build = $resp->Build;
			$version = $resp->Version;
			$pictureSystemVersion = $resp->PictureSystemVersion;
			
			$pictureName = $resp->SiteHostedPictureDetails->PictureName;
			$pictureSet = $resp->SiteHostedPictureDetails->PictureSet;
			$pictureFormat = $resp->SiteHostedPictureDetails->PictureFormat;
			$fullURL = $resp->SiteHostedPictureDetails->FullURL;
			$baseURL = $resp->SiteHostedPictureDetails->BaseURL;
			$externalPictureURL = $resp->SiteHostedPictureDetails->ExternalPictureURL;
			$useByDate = $resp->SiteHostedPictureDetails->UseByDate;
			
			// Insert record into clan_images table.
			$query = "INSERT INTO clan_belt_buckle_images(Id, clan_id, ack, time_stamp, build, version, 
picture_system_version, return_xml, picture_name, picture_set, picture_format, 
full_url, base_url, external_picture_url, use_by_date, date_time) VALUES(
'', $clanId, '$resp->Ack', '$timeStamp', '$build', '$version', '$pictureSystemVersion', '$result', '$pictureName', '$pictureSet', 
'$pictureFormat', '$fullURL', '$baseURL', '$externalPictureURL', '$useByDate', NOW());";
			$resultDB = @mysql_query($query); // Run the query.
			if($resultDB)
			{
				// Insert successfull.
				$int_id = mysql_insert_id();

				
				foreach($resp->SiteHostedPictureDetails->PictureSetMember as $PictureSetMember) {
					$MemberURL = $PictureSetMember->MemberURL;
					$PictureHeight  = $PictureSetMember->PictureHeight;
					$PictureWidth = $PictureSetMember->PictureWidth;
					

					$query2 = "INSERT INTO clan_belt_buckle_images_members(Id, clan_images, member_url, picture_height, picture_width, date_time) 
	VALUES('', $int_id, '$MemberURL', $PictureHeight, $PictureWidth, NOW());";
					$resultDB2 = @mysql_query($query2); // Run the query.
					if($resultDB2)
					{
						// Insert successfull.
						$int_id2 = mysql_insert_id();
					}
				}
				echo "Success - $int_id";
			}
			else
			{
				echo "Fail";
			}
			
		} else {
			$result = "<pre>" . htmlentities($responseXmlUploadSiteHostedPicturesRequest) . "</pre>";
			$result .= "<p>Sorry, there was a problem with the request</p>" . $resp->Ack;
			echo $result;
		}
	}
}

function constructCallAndGetResponseUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName)
{
  global $xmlRequestUploadSiteHostedPicturesRequest;
  global $responseXmlUploadSiteHostedPicturesRequest;

  // Create the XML request to be POSTed.
  $xmlRequestUploadSiteHostedPicturesRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<UploadSiteHostedPicturesRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<RequesterCredentials>\n";
  
  // sandbox
  // $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**DeYhTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAZCCowWdj6x9nY+seQ**rXMBAA**AAMAAA**w8wE42mt4tOWWcZ9dW99Si4Egbt9AH+1eBbquJuReFfMNLHs6qa1ppviy7coTO1RiyzOA2dps2ODvdSLaG072uztkimVO174vzngZf08X1amiDLDjEDAk4Qq+Y1h3l4eIdMvJIkSBviYh1yDYQv95YZOYyBB/7zkrZYSVQJ3HYCWpG+UsrHb0cSStJnkVP/indxROCE/otcf3SkUeqx/9sOm8geeTrmWDPAmdCZKb9dcHB7xFx2m+C791hwJBBM+kV7lHs59CBHMOf+jL/Yl3V5RuFandtJlCLr5LUHudVd2cKQd8/A9fcyQZfLTQzOP7N4Bhh/TulI1jq1tJ4DdOvSK/5SiipsUrUNfea2ha/mPqi54M9yOOHkkq0bMddYX3fqZRtmiq21hmTCDl2Z96RYCnm8/eWP1teAty+FbvYuK9uhzYKx1bpn8DaOie+6ZMNkY6OS3iaM6FR0CmmE8Vofmv7qvwlo7B/ikdVzhNifIPQxH2vyb9o7BfBuuHaSSJkuY7shJh6+6dyWZq8RbmC8s5EVsuwC9vyo8sxYfQqELfK+zUemWa7UCX5fKAb+z5LGtvShgcu3GeG87G+iGL6Mu+ZLUu0fhuhvXCx/5arHRocZH9qnmuSdRfSwMmQRPXrrzHEdcaUPZQ1kQj2ukWBvt6lm5ij5iyS7fwdyM61Ez8gOho0v6Mh+t/TcbAQ7nE9IGMFh9cMEGMvi+LEYVsHNpe2+3uHuaFMF2N62GZRc2mTWkvm4nBDims+5Zlo3r</eBayAuthToken>\n";
  
  // production
  $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
  
  $xmlRequestUploadSiteHostedPicturesRequest .= "</RequesterCredentials>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<ExternalPictureURL>http://www.arristreasures.com/images/kilt_pins/$clanId.jpg</ExternalPictureURL>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureName>$clanName</PictureName>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureSet>Supersize</PictureSet>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<WarningLevel>High</WarningLevel>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "</UploadSiteHostedPicturesRequest>";
  
  // Set up the HTTP headers - sandbox
  /*
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-5bba-4e60-b088-5926316e6c3a',
    'X-EBAY-API-CERT-NAME:fcb6584d-5041-421c-8791-6585eeb04e1d',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  */
  
  // Set up the HTTP headers - production
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
    'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  
  $session  = curl_init($endpoint);                       // create a curl session.
  curl_setopt($session, CURLOPT_POST, true);              // POST request type.
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestUploadSiteHostedPicturesRequest); // set the body of the POST.
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
  
  $responseXmlUploadSiteHostedPicturesRequest = curl_exec($session);	// send the request.
  curl_close($session);                                   				// close the session.
  return $responseXmlUploadSiteHostedPicturesRequest;					// returns a string.
}

function constructCallAndGetResponseNoStonesUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName)
{
  global $xmlRequestUploadSiteHostedPicturesRequest;
  global $responseXmlUploadSiteHostedPicturesRequest;

  // Create the XML request to be POSTed.
  $xmlRequestUploadSiteHostedPicturesRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<UploadSiteHostedPicturesRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<RequesterCredentials>\n";
  
  // sandbox
  // $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**DeYhTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAZCCowWdj6x9nY+seQ**rXMBAA**AAMAAA**w8wE42mt4tOWWcZ9dW99Si4Egbt9AH+1eBbquJuReFfMNLHs6qa1ppviy7coTO1RiyzOA2dps2ODvdSLaG072uztkimVO174vzngZf08X1amiDLDjEDAk4Qq+Y1h3l4eIdMvJIkSBviYh1yDYQv95YZOYyBB/7zkrZYSVQJ3HYCWpG+UsrHb0cSStJnkVP/indxROCE/otcf3SkUeqx/9sOm8geeTrmWDPAmdCZKb9dcHB7xFx2m+C791hwJBBM+kV7lHs59CBHMOf+jL/Yl3V5RuFandtJlCLr5LUHudVd2cKQd8/A9fcyQZfLTQzOP7N4Bhh/TulI1jq1tJ4DdOvSK/5SiipsUrUNfea2ha/mPqi54M9yOOHkkq0bMddYX3fqZRtmiq21hmTCDl2Z96RYCnm8/eWP1teAty+FbvYuK9uhzYKx1bpn8DaOie+6ZMNkY6OS3iaM6FR0CmmE8Vofmv7qvwlo7B/ikdVzhNifIPQxH2vyb9o7BfBuuHaSSJkuY7shJh6+6dyWZq8RbmC8s5EVsuwC9vyo8sxYfQqELfK+zUemWa7UCX5fKAb+z5LGtvShgcu3GeG87G+iGL6Mu+ZLUu0fhuhvXCx/5arHRocZH9qnmuSdRfSwMmQRPXrrzHEdcaUPZQ1kQj2ukWBvt6lm5ij5iyS7fwdyM61Ez8gOho0v6Mh+t/TcbAQ7nE9IGMFh9cMEGMvi+LEYVsHNpe2+3uHuaFMF2N62GZRc2mTWkvm4nBDims+5Zlo3r</eBayAuthToken>\n";
  
  // production
  $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
  
  $xmlRequestUploadSiteHostedPicturesRequest .= "</RequesterCredentials>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<ExternalPictureURL>http://www.arristreasures.com/images/kilt_pins_without_stones/$clanId.jpg</ExternalPictureURL>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureName>$clanName</PictureName>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureSet>Supersize</PictureSet>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<WarningLevel>High</WarningLevel>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "</UploadSiteHostedPicturesRequest>";
  
  // Set up the HTTP headers - sandbox
  /*
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-5bba-4e60-b088-5926316e6c3a',
    'X-EBAY-API-CERT-NAME:fcb6584d-5041-421c-8791-6585eeb04e1d',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  */
  
  // Set up the HTTP headers - production
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
    'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  
  $session  = curl_init($endpoint);                       // create a curl session.
  curl_setopt($session, CURLOPT_POST, true);              // POST request type.
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestUploadSiteHostedPicturesRequest); // set the body of the POST.
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
  
  $responseXmlUploadSiteHostedPicturesRequest = curl_exec($session);	// send the request.
  curl_close($session);                                   				// close the session.
  return $responseXmlUploadSiteHostedPicturesRequest;					// returns a string.
}

function constructCallAndGetResponseBeltBuckleUploadSiteHostedPicturesRequest($endpoint, $clanId, $clanName)
{
  global $xmlRequestUploadSiteHostedPicturesRequest;
  global $responseXmlUploadSiteHostedPicturesRequest;

  // Create the XML request to be POSTed.
  $xmlRequestUploadSiteHostedPicturesRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<UploadSiteHostedPicturesRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<RequesterCredentials>\n";
  
  // sandbox
  // $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**DeYhTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAZCCowWdj6x9nY+seQ**rXMBAA**AAMAAA**w8wE42mt4tOWWcZ9dW99Si4Egbt9AH+1eBbquJuReFfMNLHs6qa1ppviy7coTO1RiyzOA2dps2ODvdSLaG072uztkimVO174vzngZf08X1amiDLDjEDAk4Qq+Y1h3l4eIdMvJIkSBviYh1yDYQv95YZOYyBB/7zkrZYSVQJ3HYCWpG+UsrHb0cSStJnkVP/indxROCE/otcf3SkUeqx/9sOm8geeTrmWDPAmdCZKb9dcHB7xFx2m+C791hwJBBM+kV7lHs59CBHMOf+jL/Yl3V5RuFandtJlCLr5LUHudVd2cKQd8/A9fcyQZfLTQzOP7N4Bhh/TulI1jq1tJ4DdOvSK/5SiipsUrUNfea2ha/mPqi54M9yOOHkkq0bMddYX3fqZRtmiq21hmTCDl2Z96RYCnm8/eWP1teAty+FbvYuK9uhzYKx1bpn8DaOie+6ZMNkY6OS3iaM6FR0CmmE8Vofmv7qvwlo7B/ikdVzhNifIPQxH2vyb9o7BfBuuHaSSJkuY7shJh6+6dyWZq8RbmC8s5EVsuwC9vyo8sxYfQqELfK+zUemWa7UCX5fKAb+z5LGtvShgcu3GeG87G+iGL6Mu+ZLUu0fhuhvXCx/5arHRocZH9qnmuSdRfSwMmQRPXrrzHEdcaUPZQ1kQj2ukWBvt6lm5ij5iyS7fwdyM61Ez8gOho0v6Mh+t/TcbAQ7nE9IGMFh9cMEGMvi+LEYVsHNpe2+3uHuaFMF2N62GZRc2mTWkvm4nBDims+5Zlo3r</eBayAuthToken>\n";
  
  // production
  $xmlRequestUploadSiteHostedPicturesRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
  
  $xmlRequestUploadSiteHostedPicturesRequest .= "</RequesterCredentials>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<ExternalPictureURL>http://www.arristreasures.com/images/belt_buckles/$clanId.jpg</ExternalPictureURL>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureName>$clanName</PictureName>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<PictureSet>Supersize</PictureSet>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "<WarningLevel>High</WarningLevel>\n";
  $xmlRequestUploadSiteHostedPicturesRequest .= "</UploadSiteHostedPicturesRequest>";
  
  // Set up the HTTP headers - sandbox
  /*
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-5bba-4e60-b088-5926316e6c3a',
    'X-EBAY-API-CERT-NAME:fcb6584d-5041-421c-8791-6585eeb04e1d',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  */
  
  // Set up the HTTP headers - production
  $headers = array(
    'X-EBAY-API-COMPATIBILITY-LEVEL:697',
    'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
    'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
    'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
    'X-EBAY-API-SITEID:3',
    'X-EBAY-API-CALL-NAME:UploadSiteHostedPictures',
  );
  
  $session  = curl_init($endpoint);                       // create a curl session.
  curl_setopt($session, CURLOPT_POST, true);              // POST request type.
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestUploadSiteHostedPicturesRequest); // set the body of the POST.
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
  
  $responseXmlUploadSiteHostedPicturesRequest = curl_exec($session);	// send the request.
  curl_close($session);                                   				// close the session.
  return $responseXmlUploadSiteHostedPicturesRequest;					// returns a string.
}

// function to create kilt pin listings in the DB.
function createKiltPinListings()
{
	$id = NULL;
	$count = 0;
	$clanName = NULL;
	$surname = NULL;
	$surname_list = NULL;
	$complete_list = NULL;

	$query = "SELECT * FROM clan WHERE active = 1;";
	// $query = "SELECT * FROM clan WHERE active = 1 AND id > 323;";
	// $query = "SELECT * FROM clan WHERE active = 4;"; // use this for any image uploads that failed.
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$clanName = $row['name'];
			
			$complete_list = "Kilt Pin Clan " . $clanName . ":";
			if(strlen($complete_list) < 55)
			{
				// Now run another query to get all surnames linked to clan.
				$query2 = "SELECT surnames.* FROM surnames, clan_surnames, clan WHERE clan.Id = " . $id . " AND clan_surnames.clan_id = clan.Id AND clan_surnames.surname_id = surnames.Id;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
					{
						$surname = $row2['name'];
						if((strlen("Kilt Pin Clan " . $clanName . ":" . $surname_list) + strlen($surname)) < 55) {
							$surname_list .= " " . $surname;
							$complete_list .= " " . $surname;
						} else {
							// Now perform insertion into kilt_pin_listing table in the DB.
							$query3 = "INSERT INTO kilt_pin_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
							$result3 = @mysql_query($query3); // Run the query.
							if($result3)
							{
								// Insert successfull.
								$int_id = mysql_insert_id();
								$surname_list = " " . $surname;
								$complete_list = "Kilt Pin Clan " . $clanName . ":";
							}
							
							// System.out.println("*** " + surname_list);
							$count++;
							// $surname_list = "Clan " . $clanName . " Kilt Pin:";
							// System.out.println("\tCount is " + count);
						}
					}
					// If the surnames while is complete, we still may have to add one last entry.
					// Just check that the complete list is less than 56 characters.
					if(strlen($complete_list) < 55)
					{
						$query3 = "INSERT INTO kilt_pin_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
	VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
						$result3 = @mysql_query($query3); // Run the query.
						if($result3)
						{
							// Insert successfull.
							$int_id = mysql_insert_id();
							$surname_list = "";
						}
					}
				}
			}
		}
	}
	
	// echo "<Ack>Success</Ack>";
	// createKiltPinsListings();
}

// function to create kilt pins listings in the DB.
function createKiltPinsListings()
{
	$id = NULL;
	$count = 0;
	$clanName = NULL;
	$surname = NULL;
	$surname_list = NULL;
	$complete_list = NULL;

	$query = "SELECT * FROM clan WHERE active = 1;";
	// $query = "SELECT * FROM clan WHERE active = 1 AND id > 323;";
	// $query = "SELECT * FROM clan WHERE active = 4;"; // use this for any image uploads that failed.
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$clanName = $row['name'];
			
			$complete_list = "Kilt Pins Clan " . $clanName . ":";
			if(strlen($complete_list) < 55)
			{
				// Now run another query to get all surnames linked to clan.
				$query2 = "SELECT surnames.* FROM surnames, clan_surnames, clan WHERE clan.Id = " . $id . " AND clan_surnames.clan_id = clan.Id AND clan_surnames.surname_id = surnames.Id;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
					{
						$surname = $row2['name'];
						if((strlen("Kilt Pins Clan " . $clanName . ":" . $surname_list) + strlen($surname)) < 55) {
							$surname_list .= " " . $surname;
							$complete_list .= " " . $surname;
						} else {
							// Now perform insertion into kilt_pin_listing table in the DB.
							$query3 = "INSERT INTO kilt_pins_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
							$result3 = @mysql_query($query3); // Run the query.
							if($result3)
							{
								// Insert successfull.
								$int_id = mysql_insert_id();
								$surname_list = " " . $surname;
								$complete_list = "Kilt Pins Clan " . $clanName . ":";
							}
							
							// System.out.println("*** " + surname_list);
							$count++;
							// $surname_list = "Clan " . $clanName . " Kilt Pin:";
							// System.out.println("\tCount is " + count);
						}
					}
					// If the surnames while is complete, we still may have to add one last entry.
					// Just check that the complete list is less than 56 characters.
					if(strlen($complete_list) < 55)
					{
						$query3 = "INSERT INTO kilt_pins_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
	VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
						$result3 = @mysql_query($query3); // Run the query.
						if($result3)
						{
							// Insert successfull.
							$int_id = mysql_insert_id();
							$surname_list = "";
						}
					}
				}
			}
		}
	}
	
	echo "<Ack>Success</Ack>";
}

// function to create kilt pin listings in the DB.
function createKiltPinNoStoneListings()
{
	$id = NULL;
	$count = 0;
	$clanName = NULL;
	$surname = NULL;
	$surname_list = NULL;
	$complete_list = NULL;

	$query = "SELECT * FROM clan WHERE active = 1;";
	// $query = "SELECT * FROM clan WHERE active = 1 AND id > 323;";
	// $query = "SELECT * FROM clan WHERE active = 4;"; // use this for any image uploads that failed.
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$clanName = $row['name'];
			
			$complete_list = "Kilt Pin Clan " . $clanName . ":";
			if(strlen($complete_list) < 55)
			{
				// Now run another query to get all surnames linked to clan.
				$query2 = "SELECT surnames.* FROM surnames, clan_surnames, clan WHERE clan.Id = " . $id . " AND clan_surnames.clan_id = clan.Id AND clan_surnames.surname_id = surnames.Id;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
					{
						$surname = $row2['name'];
						if((strlen("Kilt Pin Clan " . $clanName . ":" . $surname_list) + strlen($surname)) < 55) {
							$surname_list .= " " . $surname;
							$complete_list .= " " . $surname;
						} else {
							// Now perform insertion into kilt_pin_listing table in the DB.
							$query3 = "INSERT INTO kilt_pin_no_stone_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
							$result3 = @mysql_query($query3); // Run the query.
							if($result3)
							{
								// Insert successfull.
								$int_id = mysql_insert_id();
								$surname_list = " " . $surname;
								$complete_list = "Kilt Pin Clan " . $clanName . ":";
							}
							
							// System.out.println("*** " + surname_list);
							$count++;
							// $surname_list = "Clan " . $clanName . " Kilt Pin:";
							// System.out.println("\tCount is " + count);
						}
					}
					// If the surnames while is complete, we still may have to add one last entry.
					// Just check that the complete list is less than 56 characters.
					if(strlen($complete_list) < 55)
					{
						$query3 = "INSERT INTO kilt_pin_no_stone_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
	VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
						$result3 = @mysql_query($query3); // Run the query.
						if($result3)
						{
							// Insert successfull.
							$int_id = mysql_insert_id();
							$surname_list = "";
						}
					}
				}
			}
		}
	}

}

// function to create belt buckle listings in the DB.
function createBeltBuckleListings()
{
	$id = NULL;
	$count = 0;
	$clanName = NULL;
	$surname = NULL;
	$surname_list = NULL;
	$complete_list = NULL;

	$query = "SELECT * FROM clan WHERE active = 1;";
	// $query = "SELECT * FROM clan WHERE active = 1 AND id > 323;";
	// $query = "SELECT * FROM clan WHERE active = 4;"; // use this for any image uploads that failed.
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$clanName = $row['name'];
			
			$complete_list = "Belt Buckle Clan " . $clanName . ":";
			if(strlen($complete_list) < 55)
			{
				// Now run another query to get all surnames linked to clan.
				$query2 = "SELECT surnames.* FROM surnames, clan_surnames, clan WHERE clan.Id = " . $id . " AND clan_surnames.clan_id = clan.Id AND clan_surnames.surname_id = surnames.Id;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC))
					{
						$surname = $row2['name'];
						if((strlen("Belt Buckle Clan " . $clanName . ":" . $surname_list) + strlen($surname)) < 55) {
							$surname_list .= " " . $surname;
							$complete_list .= " " . $surname;
						} else {
							// Now perform insertion into kilt_pin_listing table in the DB.
							$query3 = "INSERT INTO belt_buckle_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
							$result3 = @mysql_query($query3); // Run the query.
							if($result3)
							{
								// Insert successfull.
								$int_id = mysql_insert_id();
								$surname_list = " " . $surname;
								$complete_list = "Belt Buckle Clan " . $clanName . ":";
							}
							
							// System.out.println("*** " + surname_list);
							$count++;
							// $surname_list = "Clan " . $clanName . " Kilt Pin:";
							// System.out.println("\tCount is " + count);
						}
					}
					// If the surnames while is complete, we still may have to add one last entry.
					// Just check that the complete list is less than 56 characters.
					if(strlen($complete_list) < 55)
					{
						$query3 = "INSERT INTO belt_buckle_listing(Id, clan_id, clan_name, surname_list, active, date_time) 
	VALUES('', $id, '$clanName', '$surname_list', 1, NOW());";
						$result3 = @mysql_query($query3); // Run the query.
						if($result3)
						{
							// Insert successfull.
							$int_id = mysql_insert_id();
							$surname_list = "";
						}
					}
				}
			}
		}
	}

}

function addItemRequest()
{
	global $responseXmlAddItemRequest;
	
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		$noOfListings = $_GET['noOfListings'];
		// Get and store max clan id for future use.
		$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pin_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$max_clan_id = $row['max_clan_id'];
			$_SESSION['max_clan_id'] = $max_clan_id;
		}
		
		$query = "SELECT COUNT(*) AS listing_count FROM kilt_pin_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$listing_count = $row['listing_count'];
			
			$query2 = "SELECT position FROM ebay_clan_listing_position WHERE Id = 1;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$_SESSION['clan_id'] = $row2['position'];
			}
			else
			{
				$_SESSION['clan_id'] = 0;
			}
			
			// Set this variable to however many listings you want the transaction to carry out.
			// $noOfListings = 20;
			if($listing_count > $noOfListings)
			{
				echo $noOfListings;
			}
			else
			{
				echo $listing_count;
			}
		}
	}
	elseif(isset($_GET['position']))
	{
		$image_full_url = NULL;
		$clan_id = NULL;
		$clan_name = NULL;
		$surname_list = NULL;
		$uuid = NULL;
		
		$query = "SELECT * FROM kilt_pin_listing WHERE active = 1 AND clan_id > $_SESSION[clan_id] LIMIT 1;";
		
		// Special case since we only want to list specific clans.
		/*
		$query = "SELECT * FROM kilt_pin_listing WHERE active = 1 AND clan_id > $_SESSION[clan_id] AND (clan_id = 302 OR clan_id = 201 OR clan_id = 95 OR clan_id = 275 OR clan_id = 55 
OR clan_id = 221 OR clan_id = 31 OR clan_id = 262 OR clan_id = 75 OR clan_id = 108 
OR clan_id = 123 OR clan_id = 133 OR clan_id = 101 OR clan_id = 248 OR clan_id = 196 
OR clan_id = 132 OR clan_id = 36 OR clan_id = 220 OR clan_id = 60 OR clan_id = 113 
OR clan_id = 14 OR clan_id = 139 OR clan_id = 119 OR clan_id = 109 OR clan_id = 170) LIMIT 1;";
*/
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Grab field info from DB and update session etc...
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$_SESSION['clan_id'] = $row['clan_id'];
			$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 1;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			$id = $row['Id'];
			$clan_id = $row['clan_id'];
			$clan_name = $row['clan_name'];
			$surname_list = $row['surname_list'];
			
			// Pull in the image url.
			$query2 = "SELECT full_url FROM clan_images WHERE clan_id = $clan_id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$image_full_url = $row2['full_url'];
			}
			
			// echo "Success clan name is $clan_name - surname list is $surname_list - clan id is $clan_id - image url is $image_full_url";
			
			// Before we make the eBayCall, we have to create a unique UUID for the listing, we do this by
			// creating an empty entry (for update later) and extracting it's ID and will be in the following
			// format: ########000000000000000000000001 = 32 characters long where ######## will be substituted
			// with a unique transaction id (see id allocations).
			$uuidTransactionId = "00000004";
			$ebayKiltPinListingId = NULL;
			
			$query3 = "INSERT INTO ebay_kilt_pin_listing(Id) VALUES('');";
			$result3 = @mysql_query($query3); // Run the query.
			if($result3)
			{
				// Insert successfull.
				$ebayKiltPinListingId = mysql_insert_id();
			}
			$ebayKiltPinListingIdLength = getNumberLength($ebayKiltPinListingId);
			// Get no of zeros required to assemble this new UUID = 32(total) - 8(transaction id) - #(ebayKiltPinListingIdLength)
			$noOfZeros = getZerosString(32 - 8 - $ebayKiltPinListingIdLength);
			// Now assemble the UUID.
			$uuid = $uuidTransactionId . $noOfZeros . $ebayKiltPinListingId;
			
			
			// Perform the actual eBay listing call AddItemRequest.
			// Make the API call.
			global $responseXmlAddItemRequest;
			error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
			// API request variables.
			// sandbox
			// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
			
			// production
			$endpoint = 'https://api.ebay.com/ws/api.dll'; // URL to call.
			
			// Load the call and capture the response returned by the eBay API
			// The constructCallAndGetResponseUploadSiteHostedPicturesRequest function is defined below.
			$resp = simplexml_load_string(constructCallAndGetResponseAddItemRequestUK($endpoint, $clan_id, $clan_name, $surname_list, $image_full_url, $uuid, 1));
			
			// If successful, then update the ebay_kilt_pin_listing DB entry based on ebayKiltPinListingId retrieved earlier.
			if ($resp->Ack == "Success")
			{
				$query4 = "UPDATE ebay_kilt_pin_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 1, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			elseif($resp->Ack == "Warning")
			{
				$query4 = "UPDATE ebay_kilt_pin_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 2, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			else
			{
				$query4 = "UPDATE ebay_kilt_pin_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 0, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			
			// Update kilt_pin_listing DB entry active to 0 (based on id).
			$query2 = "UPDATE kilt_pin_listing SET active = 0 WHERE Id = $id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			// Update $_SESSION['clan_id'] to current clan_id for next SELECT iteration.
			if($clan_id == $_SESSION['max_clan_id'])
			{
				$_SESSION['clan_id'] = 0;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 1;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
				
				// Get and re-store the current max clan id for future use.
				$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pin_listing WHERE active = 1;";
				$result = @mysql_query($query); // Run the query.
				if($result)
				{
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$max_clan_id = $row['max_clan_id'];
					$_SESSION['max_clan_id'] = $max_clan_id;
				}
			}
			else
			{
				$_SESSION['clan_id'] = $clan_id;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 1;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
			// echo "Success done";
			echo "Success - $clan_id - $_SESSION[clan_id] - $responseXmlAddItemRequest - scid = $_SESSION[clan_id]";
		}
	}
}

function addItemRequestPins()
{
	global $responseXmlAddItemRequest;
	
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		$noOfListings = $_GET['noOfListings'];
		// Get and store max clan id for future use.
		$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pins_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$max_clan_id = $row['max_clan_id'];
			$_SESSION['max_clan_id'] = $max_clan_id;
		}
		
		$query = "SELECT COUNT(*) AS listing_count FROM kilt_pins_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$listing_count = $row['listing_count'];
			
			$query2 = "SELECT position FROM ebay_clan_listing_position WHERE Id = 2;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$_SESSION['clan_id'] = $row2['position'];
			}
			else
			{
				$_SESSION['clan_id'] = 0;
			}
			
			// Set this variable to however many listings you want the transaction to carry out.
			// $noOfListings = 20;
			if($listing_count > $noOfListings)
			{
				echo $noOfListings;
			}
			else
			{
				echo $listing_count;
			}
		}
	}
	elseif(isset($_GET['position']))
	{
		$image_full_url = NULL;
		$clan_id = NULL;
		$clan_name = NULL;
		$surname_list = NULL;
		$uuid = NULL;
		
		$query = "SELECT * FROM kilt_pins_listing WHERE active = 1 AND clan_id > $_SESSION[clan_id] LIMIT 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Grab field info from DB and update session etc...
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$_SESSION['clan_id'] = $row['clan_id'];
			$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 2;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			$id = $row['Id'];
			$clan_id = $row['clan_id'];
			$clan_name = $row['clan_name'];
			$surname_list = $row['surname_list'];
			
			// Pull in the image url.
			$query2 = "SELECT full_url FROM clan_images WHERE clan_id = $clan_id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$image_full_url = $row2['full_url'];
			}
			
			// echo "Success clan name is $clan_name - surname list is $surname_list - clan id is $clan_id - image url is $image_full_url";
			
			// Before we make the eBayCall, we have to create a unique UUID for the listing, we do this by
			// creating an empty entry (for update later) and extracting it's ID and will be in the following
			// format: ########000000000000000000000001 = 32 characters long where ######## will be substituted
			// with a unique transaction id (see id allocations).
			$uuidTransactionId = "00000003";
			$ebayKiltPinListingId = NULL;
			
			$query3 = "INSERT INTO ebay_kilt_pins_listing(Id) VALUES('');";
			$result3 = @mysql_query($query3); // Run the query.
			if($result3)
			{
				// Insert successfull.
				$ebayKiltPinListingId = mysql_insert_id();
			}
			$ebayKiltPinListingIdLength = getNumberLength($ebayKiltPinListingId);
			// Get no of zeros required to assemble this new UUID = 32(total) - 8(transaction id) - #(ebayKiltPinListingIdLength)
			$noOfZeros = getZerosString(32 - 8 - $ebayKiltPinListingIdLength);
			// Now assemble the UUID.
			$uuid = $uuidTransactionId . $noOfZeros . $ebayKiltPinListingId;
			
			
			// Perform the actual eBay listing call AddItemRequest.
			// Make the API call.
			global $responseXmlAddItemRequest;
			error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
			// API request variables.
			// sandbox
			// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
			
			// production
			$endpoint = 'https://api.ebay.com/ws/api.dll'; // URL to call.
			
			// Load the call and capture the response returned by the eBay API
			// The constructCallAndGetResponseUploadSiteHostedPicturesRequest function is defined below.
			$resp = simplexml_load_string(constructCallAndGetResponseAddItemRequestUK($endpoint, $clan_id, $clan_name, $surname_list, $image_full_url, $uuid, 2));
			
			// If successful, then update the ebay_kilt_pin_listing DB entry based on ebayKiltPinListingId retrieved earlier.
			if ($resp->Ack == "Success")
			{
				$query4 = "UPDATE ebay_kilt_pins_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 1, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			elseif($resp->Ack == "Warning")
			{
				$query4 = "UPDATE ebay_kilt_pins_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 2, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			else
			{
				$query4 = "UPDATE ebay_kilt_pins_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 0, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			
			// Update kilt_pin_listing DB entry active to 0 (based on id).
			$query2 = "UPDATE kilt_pins_listing SET active = 0 WHERE Id = $id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			// Update $_SESSION['clan_id'] to current clan_id for next SELECT iteration.
			if($clan_id == $_SESSION['max_clan_id'])
			{
				$_SESSION['clan_id'] = 0;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 2;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
				
				// Get and re-store the current max clan id for future use.
				$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pins_listing WHERE active = 1;";
				$result = @mysql_query($query); // Run the query.
				if($result)
				{
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$max_clan_id = $row['max_clan_id'];
					$_SESSION['max_clan_id'] = $max_clan_id;
				}
			}
			else
			{
				$_SESSION['clan_id'] = $clan_id;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 2;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
			// echo "Success done";
			echo "Success - $clan_id - $_SESSION[clan_id] - $responseXmlAddItemRequest - scid = $_SESSION[clan_id]";
		}
	}
}

function addItemNoStoneRequest()
{
	global $responseXmlAddItemRequest;
	
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		$noOfListings = $_GET['noOfListings'];
		// Get and store max clan id for future use.
		$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pin_no_stone_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$max_clan_id = $row['max_clan_id'];
			$_SESSION['max_clan_id'] = $max_clan_id;
		}
		
		$query = "SELECT COUNT(*) AS listing_count FROM kilt_pin_no_stone_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$listing_count = $row['listing_count'];
			
			$query2 = "SELECT position FROM ebay_clan_listing_position WHERE Id = 3;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$_SESSION['clan_id'] = $row2['position'];
			}
			else
			{
				$_SESSION['clan_id'] = 0;
			}
			
			// Set this variable to however many listings you want the transaction to carry out.
			// $noOfListings = 20;
			if($listing_count > $noOfListings)
			{
				echo $noOfListings;
			}
			else
			{
				echo $listing_count;
			}
		}
	}
	elseif(isset($_GET['position']))
	{
		$image_full_url = NULL;
		$clan_id = NULL;
		$clan_name = NULL;
		$surname_list = NULL;
		$uuid = NULL;
		
		$query = "SELECT * FROM kilt_pin_no_stone_listing WHERE active = 1 AND clan_id > $_SESSION[clan_id] LIMIT 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Grab field info from DB and update session etc...
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$_SESSION['clan_id'] = $row['clan_id'];
			$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 3;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			$id = $row['Id'];
			$clan_id = $row['clan_id'];
			$clan_name = $row['clan_name'];
			$surname_list = $row['surname_list'];
			
			// Pull in the image url.
			$query2 = "SELECT full_url FROM clan_no_stone_images WHERE clan_id = $clan_id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$image_full_url = $row2['full_url'];
			}
			
			// echo "Success clan name is $clan_name - surname list is $surname_list - clan id is $clan_id - image url is $image_full_url";
			
			// Before we make the eBayCall, we have to create a unique UUID for the listing, we do this by
			// creating an empty entry (for update later) and extracting it's ID and will be in the following
			// format: ########000000000000000000000001 = 32 characters long where ######## will be substituted
			// with a unique transaction id (see id allocations).
			$uuidTransactionId = "00000005";
			$ebayKiltPinListingId = NULL;
			
			$query3 = "INSERT INTO ebay_kilt_pin_no_stone_listing(Id) VALUES('');";
			$result3 = @mysql_query($query3); // Run the query.
			if($result3)
			{
				// Insert successfull.
				$ebayKiltPinListingId = mysql_insert_id();
			}
			$ebayKiltPinListingIdLength = getNumberLength($ebayKiltPinListingId);
			// Get no of zeros required to assemble this new UUID = 32(total) - 8(transaction id) - #(ebayKiltPinListingIdLength)
			$noOfZeros = getZerosString(32 - 8 - $ebayKiltPinListingIdLength);
			// Now assemble the UUID.
			$uuid = $uuidTransactionId . $noOfZeros . $ebayKiltPinListingId;
			
			
			// Perform the actual eBay listing call AddItemRequest.
			// Make the API call.
			global $responseXmlAddItemRequest;
			error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
			// API request variables.
			// sandbox
			// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
			
			// production
			$endpoint = 'https://api.ebay.com/ws/api.dll'; // URL to call.
			
			// Load the call and capture the response returned by the eBay API
			// The constructCallAndGetResponseUploadSiteHostedPicturesRequest function is defined below.
			$resp = simplexml_load_string(constructCallAndGetResponseAddItemRequestUK($endpoint, $clan_id, $clan_name, $surname_list, $image_full_url, $uuid, 3));
			
			// If successful, then update the ebay_kilt_pin_listing DB entry based on ebayKiltPinListingId retrieved earlier.
			if ($resp->Ack == "Success")
			{
				$query4 = "UPDATE ebay_kilt_pin_no_stone_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 1, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			elseif($resp->Ack == "Warning")
			{
				$query4 = "UPDATE ebay_kilt_pin_no_stone_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 2, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			else
			{
				$query4 = "UPDATE ebay_kilt_pin_no_stone_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 0, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			
			// Update kilt_pin_listing DB entry active to 0 (based on id).
			$query2 = "UPDATE kilt_pin_no_stone_listing SET active = 0 WHERE Id = $id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			// Update $_SESSION['clan_id'] to current clan_id for next SELECT iteration.
			if($clan_id == $_SESSION['max_clan_id'])
			{
				$_SESSION['clan_id'] = 0;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 3;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
				
				// Get and re-store the current max clan id for future use.
				$query = "SELECT MAX(clan_id) AS max_clan_id FROM kilt_pin_no_stone_listing WHERE active = 1;";
				$result = @mysql_query($query); // Run the query.
				if($result)
				{
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$max_clan_id = $row['max_clan_id'];
					$_SESSION['max_clan_id'] = $max_clan_id;
				}
			}
			else
			{
				$_SESSION['clan_id'] = $clan_id;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 3;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
			// echo "Success done";
			echo "Success - $clan_id - $_SESSION[clan_id] - $responseXmlAddItemRequest - scid = $_SESSION[clan_id]";
		}
	}
}

function addItemBeltBuckleRequest()
{
	global $responseXmlAddItemRequest;
	
	if(isset($_GET['firstCall']) && strcmp($_GET['firstCall'], "true") == 0)
	{
		$noOfListings = $_GET['noOfListings'];
		// Get and store max clan id for future use.
		$query = "SELECT MAX(clan_id) AS max_clan_id FROM belt_buckle_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$max_clan_id = $row['max_clan_id'];
			$_SESSION['max_clan_id'] = $max_clan_id;
		}
		
		$query = "SELECT COUNT(*) AS listing_count FROM belt_buckle_listing WHERE active = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$listing_count = $row['listing_count'];
			
			$query2 = "SELECT position FROM ebay_clan_listing_position WHERE Id = 4;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$_SESSION['clan_id'] = $row2['position'];
			}
			else
			{
				$_SESSION['clan_id'] = 0;
			}
			
			// Set this variable to however many listings you want the transaction to carry out.
			// $noOfListings = 20;
			if($listing_count > $noOfListings)
			{
				echo $noOfListings;
			}
			else
			{
				echo $listing_count;
			}
		}
	}
	elseif(isset($_GET['position']))
	{
		$image_full_url = NULL;
		$clan_id = NULL;
		$clan_name = NULL;
		$surname_list = NULL;
		$uuid = NULL;
		
		$query = "SELECT * FROM belt_buckle_listing WHERE active = 1 AND clan_id > $_SESSION[clan_id] LIMIT 1;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Grab field info from DB and update session etc...
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$_SESSION['clan_id'] = $row['clan_id'];
			$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 4;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			$id = $row['Id'];
			$clan_id = $row['clan_id'];
			$clan_name = $row['clan_name'];
			$surname_list = $row['surname_list'];
			
			// Pull in the image url.
			$query2 = "SELECT full_url FROM clan_belt_buckle_images WHERE clan_id = $clan_id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
				$image_full_url = $row2['full_url'];
			}
			
			// echo "Success clan name is $clan_name - surname list is $surname_list - clan id is $clan_id - image url is $image_full_url";
			
			// Before we make the eBayCall, we have to create a unique UUID for the listing, we do this by
			// creating an empty entry (for update later) and extracting it's ID and will be in the following
			// format: ########000000000000000000000001 = 32 characters long where ######## will be substituted
			// with a unique transaction id (see id allocations).
			$uuidTransactionId = "00000006";
			$ebayKiltPinListingId = NULL;
			
			$query3 = "INSERT INTO ebay_belt_buckle_listing(Id) VALUES('');";
			$result3 = @mysql_query($query3); // Run the query.
			if($result3)
			{
				// Insert successfull.
				$ebayKiltPinListingId = mysql_insert_id();
			}
			$ebayKiltPinListingIdLength = getNumberLength($ebayKiltPinListingId);
			// Get no of zeros required to assemble this new UUID = 32(total) - 8(transaction id) - #(ebayKiltPinListingIdLength)
			$noOfZeros = getZerosString(32 - 8 - $ebayKiltPinListingIdLength);
			// Now assemble the UUID.
			$uuid = $uuidTransactionId . $noOfZeros . $ebayKiltPinListingId;
			
			
			// Perform the actual eBay listing call AddItemRequest.
			// Make the API call.
			global $responseXmlAddItemRequest;
			error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging.
			// API request variables.
			// sandbox
			// $endpoint = 'https://api.sandbox.ebay.com/ws/api.dll';  // URL to call.
			
			// production
			$endpoint = 'https://api.ebay.com/ws/api.dll'; // URL to call.
			
			// Load the call and capture the response returned by the eBay API
			// The constructCallAndGetResponseUploadSiteHostedPicturesRequest function is defined below.
			$resp = simplexml_load_string(constructCallAndGetResponseAddItemRequestUK($endpoint, $clan_id, $clan_name, $surname_list, $image_full_url, $uuid, 4));
			
			// If successful, then update the ebay_kilt_pin_listing DB entry based on ebayKiltPinListingId retrieved earlier.
			if ($resp->Ack == "Success")
			{
				$query4 = "UPDATE ebay_belt_buckle_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 1, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			elseif($resp->Ack == "Warning")
			{
				$query4 = "UPDATE ebay_belt_buckle_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 2, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			else
			{
				$query4 = "UPDATE ebay_belt_buckle_listing SET kilt_pin_listing = $id, uuid = '$uuid', return_xml = '$responseXmlAddItemRequest', success_flag = 0, date_time = NOW() WHERE Id = $ebayKiltPinListingId;";
				$result4 = @mysql_query($query4); // Run the query.
				if($result4)
				{
					// Update successfull.
				}
			}
			
			// Update kilt_pin_listing DB entry active to 0 (based on id).
			$query2 = "UPDATE belt_buckle_listing SET active = 0 WHERE Id = $id;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
			
			// Update $_SESSION['clan_id'] to current clan_id for next SELECT iteration.
			if($clan_id == $_SESSION['max_clan_id'])
			{
				$_SESSION['clan_id'] = 0;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 4;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
				
				// Get and re-store the current max clan id for future use.
				$query = "SELECT MAX(clan_id) AS max_clan_id FROM belt_buckle_listing WHERE active = 1;";
				$result = @mysql_query($query); // Run the query.
				if($result)
				{
					$row = mysql_fetch_array($result, MYSQL_ASSOC);
					$max_clan_id = $row['max_clan_id'];
					$_SESSION['max_clan_id'] = $max_clan_id;
				}
			}
			else
			{
				$_SESSION['clan_id'] = $clan_id;
				$query2 = "UPDATE ebay_clan_listing_position SET position = $_SESSION[clan_id] WHERE Id = 4;";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
			// echo "Success done";
			echo "Success - $clan_id - $_SESSION[clan_id] - $responseXmlAddItemRequest - scid = $_SESSION[clan_id]";
		}
	}
}

function constructCallAndGetResponseAddItemRequestUK($endpoint, $clanId, $clanName, $surname_list, $image_full_url, $uuid, $type)
{
	global $xmlRequestAddItemRequest;
	global $responseXmlAddItemRequest;

	if($type == 1)
	{
		$title = "Clan " . $clanName . ":" . " Highland Wedding Kilt Pin";
	}
	elseif($type == 2)
	{
		// Experiment that has yieled nothing really.
		$title = "Clan " . $clanName . ":" . " Highland Wedding Kilt Pins";
	}
	elseif($type == 3)
	{
		$title = "Highland Wedding Kilt Pin Antique Metal Clan " . $clanName;
	}
	elseif($type == 4)
	{
		$title = "Highland Wedding Kilt Belt Buckle Antique Metal Clan " . $clanName;
	}
	
	$completeSurnameList = NULL;
	
	$query = "SELECT surnames.name FROM clan_surnames, surnames WHERE clan_surnames.clan_id = $clanId 
AND clan_surnames.surname_id = surnames.Id;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$completeSurnameList .= " $row[name]";
		}
	}

  // Create the XML request to be POSTed.
	$xmlRequestAddItemRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xmlRequestAddItemRequest .= "<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
	$xmlRequestAddItemRequest .= "<ErrorLanguage>en_GB</ErrorLanguage>\n"; // uk
	// $xmlRequestAddItemRequest .= "<ErrorLanguage>en_US</ErrorLanguage>\n"; // us
	$xmlRequestAddItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestAddItemRequest .= "<Item>\n";
	$xmlRequestAddItemRequest .= "<Title>$title</Title>\n";
	// $xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000258&gt;&lt;FONT size=5 face=\"Trebuchet MS\"&gt;A beautifully hand crafted Pewter Claymore-Sword shaped&#160;kilt pin made in Scotland&#160;to the finest quality with&#160;Lamont&#160;Crest &amp; Swarovski cut Stone insert.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;SWAROVSKI AVAIL; &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT color=#006535&gt;EMERALD&lt;/FONT&gt; &lt;FONT color=#002cfd&gt;SAPPHIRE&lt;/FONT&gt; &lt;FONT color=#ff0010&gt;RUBY&lt;/FONT&gt; &lt;FONT color=#ac0047&gt;AMETHYST&lt;/FONT&gt; &lt;FONT color=#b3b3b3&gt;CRYSTAL&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;PLEASE ADVISE ON COMPLETION OF PURCHASE THE C&lt;FONT class=Apple-style-span color=#f30094&gt;O&lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#007e46&gt;L&lt;/FONT&gt;O&lt;FONT class=Apple-style-span color=#00ffff&gt;U&lt;/FONT&gt;R OF STONE YOU WOULD LIKE.&#160;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT class=Apple-style-span color=#ff0010&gt;&lt;U&gt;PLEASE NOTE&lt;/U&gt; THE KILT PIN WILL BE DESPATCHED WITH A &lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#002cfd&gt;SAPPHIRE STONE&lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#ff0010&gt; UNLESS OTHERWISE INSTRUCTED.&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;We also offer what we believe is the most extensive database of Scottish sept names anywhere. &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT class=Apple-style-span color=#421e6c&gt;Absolute Pewter kilt pins are available with a choice of Clan Badges with the same choice of Colour Swarovski stones increasing your choice for your very own designer item&lt;/FONT&gt;.&#160;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;We also manufacture pewter items to order.Ask for details.&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#8a0000 face=\"Trebuchet MS\"&gt;&lt;STRONG&gt;&lt;EM&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our kilt pins with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate...&lt;/EM&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";

	if($type == 1 || $type == 2)
	{
		$xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=5&gt;A beautifully hand crafted Pewter Claymore-Sword shaped&#160;kilt pin made in Scotland&#160;to the finest quality with&#160;Scottish&#160;Crest &amp; Swarovski cut Stone insert.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;UL&gt;&lt;LI&gt;&lt;FONT size=3 face=Verdana&gt;&lt;STRONG&gt;Swarovski Avail -&#160;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;FONT color=#000000 size=3 face=Verdana&gt;&lt;STRONG&gt;Emerald or Sapphire&lt;/STRONG&gt;&#160;&lt;/FONT&gt;&lt;/LI&gt;&lt;LI&gt;&lt;FONT color=#000000 size=3 face=Verdana&gt;&lt;STRONG&gt;Please advise on completion of purchase the colour of stone you would like through PayPal otherwise the Kilt Pin will be dispatched with a Sapphire Stone&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/LI&gt;&lt;LI&gt;&lt;FONT size=3&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT class=Apple-style-span&gt;Stone Colour Chart&#160;- &lt;FONT size=2&gt;(Purple: Amethyst, Red: Ruby, Green: Emerald, Blue: Sapphire)&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/LI&gt;&lt;/UL&gt;&lt;P&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;We offer what we believe is the most extensive database of Scottish sept names anywhere.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;We also&#160;manufacture pewter items to order -&#160;feel free to&#160;ask for details.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our kilt pins with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate. Approximate size of Kilt Pin is (10 x 3 centimetres) or (4 x 1 inches). Please note that all Kilt Pins will be sent Recorded Delivery.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT size=2&gt;Please check out our shop for other great Highlandwear and Pewter offers - &lt;a href=http://stores.ebay.co.uk/Alba-Accessories&gt;Alba Accessories Shop&lt;/a&gt;&lt;/P&gt;&lt;P&gt;Names associated with clan $clanName - $completeSurnameList&lt;/P&gt;&lt;img src=http://www.arristreasures.com/images/kilt_pins/$clanId.jpg&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";
	}
	elseif($type == 3)
	{
		$xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=5&gt;A beautifully hand crafted Pewter Claymore-Sword shaped&#160;kilt pin made in Scotland&#160;to the finest quality with&#160;Scottish&#160;Crest.&lt;P&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=2&gt;We offer what we believe is the most extensive database of Scottish sept names anywhere.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;&lt;FONT size=2&gt;We also&#160;manufacture pewter items to order -&#160;feel free to&#160;ask for details.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;&lt;FONT size=2&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our kilt pins with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate. Approximate size of Kilt Pin is (10 x 3 centimetres) or (4 x 1 inches). Please note that all Kilt Pins will be sent Recorded Delivery.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT size=2&gt;Please check out our shop for other great Highlandwear and Pewter offers - &lt;a href=http://stores.ebay.co.uk/Alba-Accessories&gt;Alba Accessories Shop&lt;/a&gt;&lt;/P&gt;&lt;FONT size=2&gt;&lt;P&gt;Names associated with clan $clanName - $completeSurnameList&lt;/P&gt;&lt;img src=http://www.arristreasures.com/images/kilt_pins_without_stones/$clanId.jpg&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";
	}
	elseif($type == 4)
	{
		$xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=5&gt;A beautifully hand crafted Antique Pewter Belt Buckle made in Scotland&#160;to the finest quality with&#160;Scottish&#160;Crest.&lt;P&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=2&gt;We offer what we believe is the most extensive database of Scottish sept names anywhere.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;&lt;FONT size=2&gt;We also&#160;manufacture pewter items to order -&#160;feel free to&#160;ask for details.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;&lt;FONT size=2&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our Belt Buckles with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate. Approximate size of Belt Buckle is (8.89 x 6.35 centimetres) or (3.5 x 2.5 inches). Please note that all Belt Buckles will be sent Recorded Delivery.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT size=2&gt;Please check out our shop for other great Highlandwear and Pewter offers - &lt;a href=http://stores.ebay.co.uk/Alba-Accessories&gt;Alba Accessories Shop&lt;/a&gt;&lt;/P&gt;&lt;FONT size=2&gt;&lt;P&gt;Names associated with clan $clanName - $completeSurnameList&lt;/P&gt;&lt;img src=http://www.arristreasures.com/images/belt_buckles/$clanId.jpg&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";
	}
	$xmlRequestAddItemRequest .= "<PrimaryCategory>\n";
	if($type == 1 || $type == 2 || $type == 3)
	{
		$xmlRequestAddItemRequest .= "<CategoryID>50677</CategoryID>\n"; // uk
	}
	if($type == 4)
	{
		$xmlRequestAddItemRequest .= "<CategoryID>2993</CategoryID>\n"; // uk
	}
	// $xmlRequestAddItemRequest .= "<CategoryID>377</CategoryID>\n"; // us
	$xmlRequestAddItemRequest .= "</PrimaryCategory>\n";
	if($type == 1 || $type == 2)
	{
		$xmlRequestAddItemRequest .= "<StartPrice>13.98</StartPrice>\n";
	}
	elseif($type == 3)
	{
		$xmlRequestAddItemRequest .= "<StartPrice>10.98</StartPrice>\n";
	}
	elseif($type == 4)
	{
		$xmlRequestAddItemRequest .= "<StartPrice>26.98</StartPrice>\n";
	}
	// $xmlRequestAddItemRequest .= "<BuyItNowPrice currencyID=\"GBP\">9.99</BuyItNowPrice>\n";
	$xmlRequestAddItemRequest .= "<ConditionID>1000</ConditionID>\n";
	$xmlRequestAddItemRequest .= "<CategoryMappingAllowed>true</CategoryMappingAllowed>\n";
	$xmlRequestAddItemRequest .= "<Country>GB</Country>\n"; // uk
	// $xmlRequestAddItemRequest .= "<Country>US</Country>\n"; // us
	$xmlRequestAddItemRequest .= "<Currency>GBP</Currency>\n"; // uk
	// $xmlRequestAddItemRequest .= "<Currency>USD</Currency>\n"; // us
	$xmlRequestAddItemRequest .= "<DispatchTimeMax>3</DispatchTimeMax>\n";
	if($type == 1 || $type == 2)
	{
		// $xmlRequestAddItemRequest .= "<ListingDuration>Days_30</ListingDuration>\n";
		$xmlRequestAddItemRequest .= "<ListingDuration>GTC</ListingDuration>\n";
	}
	elseif($type == 3)
	{
		$xmlRequestAddItemRequest .= "<ListingDuration>GTC</ListingDuration>\n";
	}
	elseif($type == 4)
	{
		$xmlRequestAddItemRequest .= "<ListingDuration>GTC</ListingDuration>\n";
	}
	$xmlRequestAddItemRequest .= "<ListingType>FixedPriceItem</ListingType>\n";
	$xmlRequestAddItemRequest .= "<PaymentMethods>PayPal</PaymentMethods>\n";
	$xmlRequestAddItemRequest .= "<PayPalEmailAddress>payments@albaaccessories.com</PayPalEmailAddress>\n";
	$xmlRequestAddItemRequest .= "<PictureDetails>\n";
	$xmlRequestAddItemRequest .= "<PictureURL>$image_full_url</PictureURL>\n";
	$xmlRequestAddItemRequest .= "</PictureDetails>\n";
	$xmlRequestAddItemRequest .= "<PostalCode>G20 8NN</PostalCode>\n"; //uk
	// $xmlRequestAddItemRequest .= "<PostalCode>95125</PostalCode>\n"; // us
	$xmlRequestAddItemRequest .= "<Quantity>100</Quantity>\n";
	
	$xmlRequestAddItemRequest .= "<ReturnPolicy>\n";
	$xmlRequestAddItemRequest .= "<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>\n";
	
	// Commented out for uk.
	/*
	$xmlRequestAddItemRequest .= "<RefundOption>MoneyBack</RefundOption>\n";
	$xmlRequestAddItemRequest .= "<ReturnsWithinOption>Days_7</ReturnsWithinOption>\n";
	*/
	$xmlRequestAddItemRequest .= "<Description>Returns must be sent within 7 days of purchase. All items must be in original sealed condition.</Description>\n";
	$xmlRequestAddItemRequest .= "<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>\n";
	$xmlRequestAddItemRequest .= "</ReturnPolicy>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingDetails>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingType>Flat</ShippingType>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingServiceOptions>\n";
	$xmlRequestAddItemRequest .= "<ShippingServicePriority>1</ShippingServicePriority>\n";
	$xmlRequestAddItemRequest .= "<ShippingService>UK_RoyalMailFirstClassStandard</ShippingService>\n"; // uk
	// $xmlRequestAddItemRequest .= "<ShippingService>USPSMedia</ShippingService>\n"; // us
	$xmlRequestAddItemRequest .= "<ShippingServiceCost>0</ShippingServiceCost>\n";
	$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>0</ShippingServiceAdditionalCost>\n";
	if($type == 1 || $type == 2)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>1.52</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>0.30</ShippingServiceAdditionalCost>\n";
	}
	elseif($type == 3)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>1.52</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>0.30</ShippingServiceAdditionalCost>\n";
	}
	elseif($type == 4)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>1.86</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>0.50</ShippingServiceAdditionalCost>\n";
	}
	$xmlRequestAddItemRequest .= "</ShippingServiceOptions>\n";
	
	$xmlRequestAddItemRequest .= "<InternationalShippingServiceOption>\n";
	$xmlRequestAddItemRequest .= "<ShippingServicePriority>1</ShippingServicePriority>\n";
	$xmlRequestAddItemRequest .= "<ShippingService>UK_RoyalMailAirmailInternational</ShippingService>\n"; // uk
	// $xmlRequestAddItemRequest .= "<ShippingService>USPSExpressMailInternational</ShippingService>\n"; // us
	if($type == 1 || $type == 2)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>7.02</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>1.00</ShippingServiceAdditionalCost>\n";
	}
	elseif($type == 3)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>7.02</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>1.00</ShippingServiceAdditionalCost>\n";
	}
	elseif($type == 4)
	{
		$xmlRequestAddItemRequest .= "<ShippingServiceCost>8.45</ShippingServiceCost>\n";
		$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>2.00</ShippingServiceAdditionalCost>\n";
	}
	$xmlRequestAddItemRequest .= "<ShippingServiceCost>5.99</ShippingServiceCost>\n";
	$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>1.49</ShippingServiceAdditionalCost>\n";
	$xmlRequestAddItemRequest .= "<ShipToLocation>Worldwide</ShipToLocation>\n";
	$xmlRequestAddItemRequest .= "</InternationalShippingServiceOption>\n";
	
	$xmlRequestAddItemRequest .= "</ShippingDetails>\n";
	
	// UK_OtherInternationalPostage - 3.49 - 1.49
	
	
	$xmlRequestAddItemRequest .= "<Site>UK</Site>\n"; // uk
	// $xmlRequestAddItemRequest .= "<Site>US</Site>\n"; // us
	$xmlRequestAddItemRequest .= "<UUID>$uuid</UUID>\n";
	$xmlRequestAddItemRequest .= "</Item>\n";
	
	// sandbox
	/*
	$xmlRequestAddItemRequest .= "<RequesterCredentials>\n";
	$xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**DeYhTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAZCCowWdj6x9nY+seQ**rXMBAA**AAMAAA**w8wE42mt4tOWWcZ9dW99Si4Egbt9AH+1eBbquJuReFfMNLHs6qa1ppviy7coTO1RiyzOA2dps2ODvdSLaG072uztkimVO174vzngZf08X1amiDLDjEDAk4Qq+Y1h3l4eIdMvJIkSBviYh1yDYQv95YZOYyBB/7zkrZYSVQJ3HYCWpG+UsrHb0cSStJnkVP/indxROCE/otcf3SkUeqx/9sOm8geeTrmWDPAmdCZKb9dcHB7xFx2m+C791hwJBBM+kV7lHs59CBHMOf+jL/Yl3V5RuFandtJlCLr5LUHudVd2cKQd8/A9fcyQZfLTQzOP7N4Bhh/TulI1jq1tJ4DdOvSK/5SiipsUrUNfea2ha/mPqi54M9yOOHkkq0bMddYX3fqZRtmiq21hmTCDl2Z96RYCnm8/eWP1teAty+FbvYuK9uhzYKx1bpn8DaOie+6ZMNkY6OS3iaM6FR0CmmE8Vofmv7qvwlo7B/ikdVzhNifIPQxH2vyb9o7BfBuuHaSSJkuY7shJh6+6dyWZq8RbmC8s5EVsuwC9vyo8sxYfQqELfK+zUemWa7UCX5fKAb+z5LGtvShgcu3GeG87G+iGL6Mu+ZLUu0fhuhvXCx/5arHRocZH9qnmuSdRfSwMmQRPXrrzHEdcaUPZQ1kQj2ukWBvt6lm5ij5iyS7fwdyM61Ez8gOho0v6Mh+t/TcbAQ7nE9IGMFh9cMEGMvi+LEYVsHNpe2+3uHuaFMF2N62GZRc2mTWkvm4nBDims+5Zlo3r</eBayAuthToken>\n";
	$xmlRequestAddItemRequest .= "</RequesterCredentials>\n";
	*/

	// production
	$xmlRequestAddItemRequest .= "<RequesterCredentials>\n";
	// Arris Auth Token
	// $xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
	// Alba Auth Token
	$xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**xzNcTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wClYKmAJKHpw6dj6x9nY+seQ**TAcBAA**AAMAAA**errCdeou4JM5KOunMfhBpNCpS8ahUgpoHoAM6XwQl/0YL80SigDRE1mm71IvruOZ2gaV9VVh0Ru1BNxzEbk+oUxu3AeCcj1cs6fkKv09BZYxbSuZiSUK+rvfEcTXA87vwjZq66Bm82SzpY1xMzBDzUElyA5+1pqf3bxfIKUGGr10kEhd6vddX5rBH6fr/cNvV/B5GzRqOtj9PsncA29BGjRrI2LICT/D/cE5R6Ghxlx/ZbhH1L9M+5pOerT2+o7H3BoOPJ3o0BEf+7udzzah7Bv1GhLsidXluaGr9BKcKRgv3W9ZzysuQHQIrT7kgQDxMQi//dULU5AHUTCAkhM81KzA4URAWHYbICWJ4ppPuYSQS9dw/pK0mztWPK2CwPRn39/sttFHS5/fL95l6EwhXjJFJOZeDDmHNaLuLqASn7cFYq4j5bG6H1cjmbuNpqtmYurBcE2m1UwGjxEMy2GLz9j0tgoA/ugJRVnnC4NKKDcCoQZ9LiVwVpNd5coQR78EswPnGoeKd40/qyp69JtI0TWbQj4/JfkbRcyLlbi87Krkea0uFkJI7s4HEFfyhpTJiVSqt7L7kqGTNFZrj4lCkwGzKLK4cpMSPgIoz1x2YSKhRmb2l3ZIBpSivtxfvx2yW/vT5xJ3iA3+w3v8PnZSW5ZRWhwMujHH6pvPRs7t0b/VbW2YCuqk1wwJsqraSo3JjSBF32owrWGlv7eDBFGrS68TXZ6mXEmc/+Tw/T8nMmoWLVsr/whcy+rLYebDMvx4</eBayAuthToken>\n";
	$xmlRequestAddItemRequest .= "</RequesterCredentials>\n";

	
	$xmlRequestAddItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestAddItemRequest .= "</AddItemRequest>\n";
  
  	// sandbox
	// Set up the HTTP headers.
	//$headers = array(
	//'X-EBAY-API-COMPATIBILITY-LEVEL:699',
	//'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
	//'X-EBAY-API-APP-NAME:Digilogu-5bba-4e60-b088-5926316e6c3a',
	//'X-EBAY-API-CERT-NAME:fcb6584d-5041-421c-8791-6585eeb04e1d',
	//'X-EBAY-API-SITEID:3'/*'X-EBAY-API-SITEID:0'*/,
	//'X-EBAY-API-CALL-NAME:AddItem',
	//); // uk site = 3, us site = 0
	
	// production
	// Set up the HTTP headers.
	$headers = array(
	'X-EBAY-API-COMPATIBILITY-LEVEL:699',
	'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
	'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
	'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
	'X-EBAY-API-SITEID:3'/*'X-EBAY-API-SITEID:0'*/,
	'X-EBAY-API-CALL-NAME:AddItem',
	); // uk site = 3, us site = 0
	
	$session  = curl_init($endpoint);                       // create a curl session.
	curl_setopt($session, CURLOPT_POST, true);              // POST request type.
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
	curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestAddItemRequest); // set the body of the POST.
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
	
	$responseXmlAddItemRequest = curl_exec($session);	// send the request.
	curl_close($session);                               // close the session.
	return $responseXmlAddItemRequest;					// returns a string.
}

function constructCallAndGetResponseAddItemRequestUS($endpoint, $clanId, $clanName, $surname_list, $image_full_url, $uuid)
{
	global $xmlRequestAddItemRequest;
	global $responseXmlAddItemRequest;

	$title = "Clan " . $clanName . ":" . $surname_list . " Kilt Pin";
	$completeSurnameList = NULL;
	
	$query = "SELECT surnames.name FROM clan_surnames, surnames WHERE clan_surnames.clan_id = $clanId 
AND clan_surnames.surname_id = surnames.Id;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$completeSurnameList .= " $row[name]";
		}
	}

  // Create the XML request to be POSTed.
	$xmlRequestAddItemRequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	$xmlRequestAddItemRequest .= "<AddItemRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
	// $xmlRequestAddItemRequest .= "<ErrorLanguage>en_GB</ErrorLanguage>\n"; // uk
	$xmlRequestAddItemRequest .= "<ErrorLanguage>en_US</ErrorLanguage>\n"; // us
	$xmlRequestAddItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestAddItemRequest .= "<Item>\n";
	$xmlRequestAddItemRequest .= "<Title>$title</Title>\n";
	// $xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000258&gt;&lt;FONT size=5 face=\"Trebuchet MS\"&gt;A beautifully hand crafted Pewter Claymore-Sword shaped&#160;kilt pin made in Scotland&#160;to the finest quality with&#160;Lamont&#160;Crest &amp; Swarovski cut Stone insert.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;SWAROVSKI AVAIL; &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT color=#006535&gt;EMERALD&lt;/FONT&gt; &lt;FONT color=#002cfd&gt;SAPPHIRE&lt;/FONT&gt; &lt;FONT color=#ff0010&gt;RUBY&lt;/FONT&gt; &lt;FONT color=#ac0047&gt;AMETHYST&lt;/FONT&gt; &lt;FONT color=#b3b3b3&gt;CRYSTAL&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;PLEASE ADVISE ON COMPLETION OF PURCHASE THE C&lt;FONT class=Apple-style-span color=#f30094&gt;O&lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#007e46&gt;L&lt;/FONT&gt;O&lt;FONT class=Apple-style-span color=#00ffff&gt;U&lt;/FONT&gt;R OF STONE YOU WOULD LIKE.&#160;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT class=Apple-style-span color=#ff0010&gt;&lt;U&gt;PLEASE NOTE&lt;/U&gt; THE KILT PIN WILL BE DESPATCHED WITH A &lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#002cfd&gt;SAPPHIRE STONE&lt;/FONT&gt;&lt;FONT class=Apple-style-span color=#ff0010&gt; UNLESS OTHERWISE INSTRUCTED.&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;We also offer what we believe is the most extensive database of Scottish sept names anywhere. &lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;&lt;FONT class=Apple-style-span color=#421e6c&gt;Absolute Pewter kilt pins are available with a choice of Clan Badges with the same choice of Colour Swarovski stones increasing your choice for your very own designer item&lt;/FONT&gt;.&#160;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT face=\"Comic Sans MS\"&gt;We also manufacture pewter items to order.Ask for details.&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#8a0000 face=\"Trebuchet MS\"&gt;&lt;STRONG&gt;&lt;EM&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our kilt pins with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate...&lt;/EM&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";

$xmlRequestAddItemRequest .= "<Description>&lt;FONT size=2 face=Arial&gt;&lt;P&gt;&lt;FONT size=4&gt;&lt;STRONG&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;FONT size=5&gt;A beautifully hand crafted Pewter Claymore-Sword shaped&#160;kilt pin made in Scotland&#160;to the finest quality with&#160;Scottish&#160;Crest &amp; Swarovski cut Stone insert.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/P&gt;&lt;UL&gt;&lt;LI&gt;&lt;FONT size=3 face=Verdana&gt;&lt;STRONG&gt;Swarovski Avail -&#160;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;FONT color=#000000 size=3 face=Verdana&gt;&lt;STRONG&gt;Emerald or Sapphire&lt;/STRONG&gt;&#160;&lt;/FONT&gt;&lt;/LI&gt;&lt;LI&gt;&lt;FONT color=#000000 size=3 face=Verdana&gt;&lt;STRONG&gt;Please advise on completion of purchase the colour of stone you would like&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/LI&gt;&lt;LI&gt;&lt;FONT size=3&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;&lt;STRONG&gt;&lt;FONT class=Apple-style-span&gt;Please Note&#160;- &lt;FONT size=2&gt;THE KILT PIN WILL BE DESPATCHED WITH A &lt;/FONT&gt;&lt;/FONT&gt;&lt;FONT size=2&gt;&lt;FONT class=Apple-style-span&gt;SAPPHIRE STONE&lt;/FONT&gt;&lt;FONT class=Apple-style-span&gt; UNLESS OTHERWISE INSTRUCTED&lt;/FONT&gt;&lt;/FONT&gt;&lt;/STRONG&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/FONT&gt;&lt;/LI&gt;&lt;/UL&gt;&lt;P&gt;&lt;FONT color=#000000&gt;&lt;FONT face=Verdana&gt;We offer what we believe is the most extensive database of Scottish sept names anywhere.&lt;/FONT&gt; &lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;We also&#160;manufacture pewter items to order -&#160;feel free to&#160;ask for details.&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;&lt;FONT color=#000000 face=Verdana&gt;Scottish clans give a sense of identity and shared descent to people in Scotland and to their relatives throughout the world, with a formal structure of Clan Chiefs officially registered with the court of the Lord Lyon, King of Arms which controls the heraldry and Coat of arms. Each clan has its own tartan patterns&#160;and clan crest symbol with motto, usually dating to the 19th century, and those identifying with the clan can wear our kilt pins with your individual clan motto&#160;on the appropriate tartan kilt&#160;as a badge of membership or&#160;as part of&#160;a uniform where appropriate...&lt;/FONT&gt;&lt;/P&gt;&lt;P&gt;Names associated with clan $clanName - $completeSurnameList&lt;/P&gt;&lt;!-- End Description --&gt;&lt;/FONT&gt;</Description>\n";
	$xmlRequestAddItemRequest .= "<PrimaryCategory>\n";
	// $xmlRequestAddItemRequest .= "<CategoryID>50677</CategoryID>\n"; // uk
	$xmlRequestAddItemRequest .= "<CategoryID>98486</CategoryID>\n"; // us
	$xmlRequestAddItemRequest .= "</PrimaryCategory>\n";
	$xmlRequestAddItemRequest .= "<StartPrice>19.95</StartPrice>\n";
	// $xmlRequestAddItemRequest .= "<BuyItNowPrice currencyID=\"GBP\">9.99</BuyItNowPrice>\n";
	$xmlRequestAddItemRequest .= "<ConditionID>1000</ConditionID>\n";
	$xmlRequestAddItemRequest .= "<CategoryMappingAllowed>true</CategoryMappingAllowed>\n";
	$xmlRequestAddItemRequest .= "<Country>GB</Country>\n"; // uk
	// $xmlRequestAddItemRequest .= "<Country>US</Country>\n"; // us - kind of irrelevant now...
	// $xmlRequestAddItemRequest .= "<Currency>GBP</Currency>\n"; // uk
	$xmlRequestAddItemRequest .= "<Currency>USD</Currency>\n"; // us
	$xmlRequestAddItemRequest .= "<DispatchTimeMax>2</DispatchTimeMax>\n";
	$xmlRequestAddItemRequest .= "<ListingDuration>Days_30</ListingDuration>\n";
	$xmlRequestAddItemRequest .= "<ListingType>FixedPriceItem</ListingType>\n";
	$xmlRequestAddItemRequest .= "<PaymentMethods>PayPal</PaymentMethods>\n";
	$xmlRequestAddItemRequest .= "<PayPalEmailAddress>payments@arristreasures.com</PayPalEmailAddress>\n";
	$xmlRequestAddItemRequest .= "<PictureDetails>\n";
	$xmlRequestAddItemRequest .= "<PictureURL>$image_full_url</PictureURL>\n";
	$xmlRequestAddItemRequest .= "</PictureDetails>\n";
	$xmlRequestAddItemRequest .= "<PostalCode>G20 8NN</PostalCode>\n"; //uk
	// $xmlRequestAddItemRequest .= "<PostalCode>95125</PostalCode>\n"; // us
	$xmlRequestAddItemRequest .= "<Quantity>100</Quantity>\n";
	
	$xmlRequestAddItemRequest .= "<ReturnPolicy>\n";
	$xmlRequestAddItemRequest .= "<ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>\n";
	
	// Commented out for uk.
	/*
	$xmlRequestAddItemRequest .= "<RefundOption>MoneyBack</RefundOption>\n";
	$xmlRequestAddItemRequest .= "<ReturnsWithinOption>Days_7</ReturnsWithinOption>\n";
	*/
	$xmlRequestAddItemRequest .= "<Description>Returns must be sent within 7 days of purchase. All items must be in original sealed condition.</Description>\n";
	$xmlRequestAddItemRequest .= "<ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>\n";
	$xmlRequestAddItemRequest .= "</ReturnPolicy>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingDetails>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingType>Flat</ShippingType>\n";
	
	$xmlRequestAddItemRequest .= "<ShippingServiceOptions>\n";
	$xmlRequestAddItemRequest .= "<ShippingServicePriority>1</ShippingServicePriority>\n";
	$xmlRequestAddItemRequest .= "<ShippingService>ShippingMethodStandard</ShippingService>\n"; // uk
	// $xmlRequestAddItemRequest .= "<ShippingService>USPSMedia</ShippingService>\n"; // us
	$xmlRequestAddItemRequest .= "<ShippingServiceCost>0</ShippingServiceCost>\n";
	$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>0</ShippingServiceAdditionalCost>\n";
	$xmlRequestAddItemRequest .= "</ShippingServiceOptions>\n";
	
	$xmlRequestAddItemRequest .= "<InternationalShippingServiceOption>\n";
	$xmlRequestAddItemRequest .= "<ShippingServicePriority>1</ShippingServicePriority>\n";
	$xmlRequestAddItemRequest .= "<ShippingService>StandardInternational</ShippingService>\n"; // uk
	// $xmlRequestAddItemRequest .= "<ShippingService>USPSExpressMailInternational</ShippingService>\n"; // us
	$xmlRequestAddItemRequest .= "<ShippingServiceCost>5.50</ShippingServiceCost>\n";
	$xmlRequestAddItemRequest .= "<ShippingServiceAdditionalCost>2.50</ShippingServiceAdditionalCost>\n";
	$xmlRequestAddItemRequest .= "<ShipToLocation>Worldwide</ShipToLocation>\n";
	$xmlRequestAddItemRequest .= "</InternationalShippingServiceOption>\n";
	
	$xmlRequestAddItemRequest .= "</ShippingDetails>\n";
	
	// UK_OtherInternationalPostage - 3.49 - 1.49
	
	
	$xmlRequestAddItemRequest .= "<Site>US</Site>\n"; // uk
	// $xmlRequestAddItemRequest .= "<Site>US</Site>\n"; // us
	$xmlRequestAddItemRequest .= "<UUID>$uuid</UUID>\n";
	$xmlRequestAddItemRequest .= "</Item>\n";
	
	// sandbox
	/*
	$xmlRequestAddItemRequest .= "<RequesterCredentials>\n";
	$xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**DeYhTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wFk4CoAZCCowWdj6x9nY+seQ**rXMBAA**AAMAAA**w8wE42mt4tOWWcZ9dW99Si4Egbt9AH+1eBbquJuReFfMNLHs6qa1ppviy7coTO1RiyzOA2dps2ODvdSLaG072uztkimVO174vzngZf08X1amiDLDjEDAk4Qq+Y1h3l4eIdMvJIkSBviYh1yDYQv95YZOYyBB/7zkrZYSVQJ3HYCWpG+UsrHb0cSStJnkVP/indxROCE/otcf3SkUeqx/9sOm8geeTrmWDPAmdCZKb9dcHB7xFx2m+C791hwJBBM+kV7lHs59CBHMOf+jL/Yl3V5RuFandtJlCLr5LUHudVd2cKQd8/A9fcyQZfLTQzOP7N4Bhh/TulI1jq1tJ4DdOvSK/5SiipsUrUNfea2ha/mPqi54M9yOOHkkq0bMddYX3fqZRtmiq21hmTCDl2Z96RYCnm8/eWP1teAty+FbvYuK9uhzYKx1bpn8DaOie+6ZMNkY6OS3iaM6FR0CmmE8Vofmv7qvwlo7B/ikdVzhNifIPQxH2vyb9o7BfBuuHaSSJkuY7shJh6+6dyWZq8RbmC8s5EVsuwC9vyo8sxYfQqELfK+zUemWa7UCX5fKAb+z5LGtvShgcu3GeG87G+iGL6Mu+ZLUu0fhuhvXCx/5arHRocZH9qnmuSdRfSwMmQRPXrrzHEdcaUPZQ1kQj2ukWBvt6lm5ij5iyS7fwdyM61Ez8gOho0v6Mh+t/TcbAQ7nE9IGMFh9cMEGMvi+LEYVsHNpe2+3uHuaFMF2N62GZRc2mTWkvm4nBDims+5Zlo3r</eBayAuthToken>\n";
	$xmlRequestAddItemRequest .= "</RequesterCredentials>\n";
	*/

	// production
	$xmlRequestAddItemRequest .= "<RequesterCredentials>\n";
	// Arris Auth Token
	// $xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**aKo0TQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wGkIuoCJGBpwydj6x9nY+seQ**TAcBAA**AAMAAA**BgGGJOqNuaVZDIyO6uROuGDX/5j9U+ZzupI2SnXz+04SHksticWBLY5SmqLkpxfOriR2ZSJO5x5ZEYrG8l5AkTYMZdieGBSqxe0BgLCw6X2ZUcm8xMmHT1jLMlerTiJZdmnQ+6LZVH7uu6CLe75NPHPgvl+2P2xnWiqB2e7oBGKAMigfL2Sw5SJJctZ4tjKRQ0h/4H5HgTKndvcmzIQOhOvo7Qx1GhL2/3GPBJF2r4YAGPwr3BycIl3686btGq+3oOzYOZxO3uKM0Y0Q+uDbbM1n3XFCUCtP/rz9Qf1TFvFVFQSIDQhZ9q7FhEbGBk8sh6rIhoJsDfc8g0fNwuFWuUJLhiCgt/xTLB6arXpNdbaTESKmL9o8fqEWTeVGJ5fItTWWg4MezklbV0Ir2xeOJ9n/wcFVXCZq2SDKrL3+MDETpup4b8+Bb0OVtz4EnoD5NSy3y7wJR7+L66h1mlp7MtqwHR94cLzLvfbHIuHVlfGmAopYIeNpGFca3s6m1PZ3oy1xrSC6rCsn7cD4Byd33RVIqKyo4dIZjUmG0tEwxKUmxtsyfW0cW0xT5d5r8XlD26zSKRSrM7/MRWuMuTxyW7IrpQEi/XeFRBVfWzeCzIDme9f1plmQ/0Zn79nfBNFyy3Odu5du9B1p80oOAGur0gxCvbpVSMMo21/TAtgOFASMGaRnQZtzrkOe4Lv27Mkv5TVMaVxtwUJ+LAppofqiWM69XIp3+ZdFOIGDBnjvZgq+lvOq87AkspjpHLS670MP</eBayAuthToken>\n";
	// Alba Auth Token
	$xmlRequestAddItemRequest .= "<eBayAuthToken>AgAAAA**AQAAAA**aAAAAA**xzNcTQ**nY+sHZ2PrBmdj6wVnY+sEZ2PrA2dj6wClYKmAJKHpw6dj6x9nY+seQ**TAcBAA**AAMAAA**errCdeou4JM5KOunMfhBpNCpS8ahUgpoHoAM6XwQl/0YL80SigDRE1mm71IvruOZ2gaV9VVh0Ru1BNxzEbk+oUxu3AeCcj1cs6fkKv09BZYxbSuZiSUK+rvfEcTXA87vwjZq66Bm82SzpY1xMzBDzUElyA5+1pqf3bxfIKUGGr10kEhd6vddX5rBH6fr/cNvV/B5GzRqOtj9PsncA29BGjRrI2LICT/D/cE5R6Ghxlx/ZbhH1L9M+5pOerT2+o7H3BoOPJ3o0BEf+7udzzah7Bv1GhLsidXluaGr9BKcKRgv3W9ZzysuQHQIrT7kgQDxMQi//dULU5AHUTCAkhM81KzA4URAWHYbICWJ4ppPuYSQS9dw/pK0mztWPK2CwPRn39/sttFHS5/fL95l6EwhXjJFJOZeDDmHNaLuLqASn7cFYq4j5bG6H1cjmbuNpqtmYurBcE2m1UwGjxEMy2GLz9j0tgoA/ugJRVnnC4NKKDcCoQZ9LiVwVpNd5coQR78EswPnGoeKd40/qyp69JtI0TWbQj4/JfkbRcyLlbi87Krkea0uFkJI7s4HEFfyhpTJiVSqt7L7kqGTNFZrj4lCkwGzKLK4cpMSPgIoz1x2YSKhRmb2l3ZIBpSivtxfvx2yW/vT5xJ3iA3+w3v8PnZSW5ZRWhwMujHH6pvPRs7t0b/VbW2YCuqk1wwJsqraSo3JjSBF32owrWGlv7eDBFGrS68TXZ6mXEmc/+Tw/T8nMmoWLVsr/whcy+rLYebDMvx4</eBayAuthToken>\n";

	$xmlRequestAddItemRequest .= "</RequesterCredentials>\n";

	
	$xmlRequestAddItemRequest .= "<WarningLevel>High</WarningLevel>\n";
	$xmlRequestAddItemRequest .= "</AddItemRequest>\n";
  
  	// sandbox
	// Set up the HTTP headers.
	//$headers = array(
	//'X-EBAY-API-COMPATIBILITY-LEVEL:699',
	//'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
	//'X-EBAY-API-APP-NAME:Digilogu-5bba-4e60-b088-5926316e6c3a',
	//'X-EBAY-API-CERT-NAME:fcb6584d-5041-421c-8791-6585eeb04e1d',
	//'X-EBAY-API-SITEID:3'/*'X-EBAY-API-SITEID:0'*/,
	//'X-EBAY-API-CALL-NAME:AddItem',
	//); // uk site = 3, us site = 0
	
	// production
	// Set up the HTTP headers.
	$headers = array(
	'X-EBAY-API-COMPATIBILITY-LEVEL:699',
	'X-EBAY-API-DEV-NAME:633faa1e-b440-4480-bb1b-8dab99d63a5a',
	'X-EBAY-API-APP-NAME:Digilogu-8335-4f13-a866-a6c01477db29',
	'X-EBAY-API-CERT-NAME:a1c4e963-ec0c-4b91-831c-8b6ebc22dae8',
	'X-EBAY-API-SITEID:0'/*'X-EBAY-API-SITEID:0'*/,
	'X-EBAY-API-CALL-NAME:AddItem',
	); // uk site = 3, us site = 0
	
	$session  = curl_init($endpoint);                       // create a curl session.
	curl_setopt($session, CURLOPT_POST, true);              // POST request type.
	curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array.
	curl_setopt($session, CURLOPT_POSTFIELDS, $xmlRequestAddItemRequest); // set the body of the POST.
	curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out.
	
	$responseXmlAddItemRequest = curl_exec($session);	// send the request.
	curl_close($session);                               // close the session.
	return $responseXmlAddItemRequest;					// returns a string.
}

?>