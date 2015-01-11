<?php

session_start();

// connect to the database.
require_once('./connect_alba_db.php');
require_once('./common.php');

switch($_GET['type'])
{
	case 'adminLogin':
	adminLogin();
	break;
	case 'adminLogout':
	adminLogout();
	break;
	case 'getBannerItems':
	getBannerItems();
	break;
	case 'removeBannerItem':
	removeBannerItem();
	break;
	case 'submitDetails':
	submitDetails();
	break;
	case 'getAdvertisingBannerItems':
	getAdvertisingBannerItems();
	break;
	case 'removeAdvertisingBannerItem':
	removeAdvertisingBannerItem();
	break;
	case 'updateAdvertisingBannerTimeout':
	updateAdvertisingBannerTimeout();
	break;
	case 'testPost':
	testPost();
	break;
	case 'testJSONPost':
	testJSONPost();
	break;
}

// This Ajax function takes in a JSON message (String), decodes it to a PHP object,
// strips out a value nested within Object, instantiates a new PHP object,
// setting response member (via constructor) of new object to value stripped out,
// encodes new object to JSON response message (String),
// returns JSON response message. Note: we create a Response Class definition this time.
function testJSONPost() {
	$json = file_get_contents('php://input');
	$obj = json_decode($json);
	$variableB = $obj->{'nestedClass'}->{'variableB'};
	
	$responseObject = new ResponseClass($variableB);
	$jsonResponse = json_encode($responseObject);
	echo $jsonResponse;
}

function testPost() {
	$lorem = $_POST['lorem'];
	$name = $_POST['name'];
	echo "you passed " . $lorem . " - " . $name;
}

class ResponseClass {
	public $response;

	public function __construct($response) {
		$this->response = $response;
	}
}

function updateAdvertisingBannerTimeout() {
		$jsonRequestAdvertisingTimeout = file_get_contents('php://input');
		$requestAdvertisingTimeout = json_decode($jsonRequestAdvertisingTimeout);
		$timeout = $requestAdvertisingTimeout->{'timeout'};
		
		// Update db with timeout
		$query = "UPDATE website_arris_advertising_banner_timeout SET timeout = $timeout WHERE Id = 1;";
		$result = @mysql_query($query); // Run the query.
		if($result) {
			$responseObject = new ResponseClass("Success");
		} else {
			$responseObject = new ResponseClass("Fail");
		}
		
		$jsonResponse = json_encode($responseObject);
		echo $jsonResponse;
}

function getAdvertisingBannerItems()
{	
	$items = "<table width=\"633\" border=\"0\" align=\"center\" id=\"banner_table\"><tr>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Position</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Hyperlink</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Image</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Edit</span></div></td>
				<td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Remove</span></div></td>
              </tr>";
	$query = "select * from website_arris_advertising_banner where active = 1 order by position asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$position = $row['position'];
			$hyperlink_url = $row['hyperlink_url'];
			$image_name = $row['image_name'];
			$image_url = $row['image_url'];
			$items .= "<tr><td><div align=\"center\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;\">$position</span></div></td>
                <td><div align=\"center\"><a href=\"$hyperlink_url\" target=\"_blank\">View URL / Hyperlink</a></div></td>
                <td><div align=\"center\"><a href=\"$image_url\" target=\"_blank\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;\">$image_name</span></a></div></td>
                <td><div align=\"center\"><input type=\"button\" name=\"edit\" id=\"edit\" value=\"Edit\" onclick=\"editAdvertisingBannerItem('$id', '$position', '$hyperlink_url', this);\" /></div></td>
				<td><div align=\"center\"><input type=\"button\" name=\"remove\" id=\"remove\" value=\"Remove\" onclick=\"ajaxRemoveAdvertisingItem('$id');\" /></div></td></tr>";
		}
	}
	$items .= "</table>";
	echo "$items";
	
}

function removeBannerItem()
{
	$itemId = $_GET['itemId'];
	$query = "UPDATE website_arris_banner SET active = 0 WHERE Id = $itemId;";
	$result = @mysql_query($query); // Run the query.
	if($result){
	
		// Update successfull. Now shuffle..
		$query = "select * from website_arris_banner where id = $itemId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$position = $row['position'];
		}
		
		$query = "select * from website_arris_banner where active = 1 and position > $position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentPosition = $row['position'];
				$newPosition = intval($currentPosition) - 1;
				
				$query2 = "UPDATE website_arris_banner SET position = '$newPosition' WHERE Id = '$Id';";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
		}
		
		echo "success";
	} else {
		echo "fail";
	}
	
}

function removeAdvertisingBannerItem()
{
	$itemId = $_GET['itemId'];
	$query = "UPDATE website_arris_advertising_banner SET active = 0 WHERE Id = $itemId;";
	$result = @mysql_query($query); // Run the query.
	if($result){
	
		// Update successfull. Now shuffle..
		$query = "select * from website_arris_advertising_banner where id = $itemId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$position = $row['position'];
		}
		
		$query = "select * from website_arris_advertising_banner where active = 1 and position > $position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentPosition = $row['position'];
				$newPosition = intval($currentPosition) - 1;
				
				$query2 = "UPDATE website_arris_advertising_banner SET position = '$newPosition' WHERE Id = '$Id';";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
		}
		
		echo "success";
	} else {
		echo "fail";
	}
	
}

function getBannerItems()
{	
	$items = "<table width=\"633\" border=\"0\" align=\"center\" id=\"banner_table\"><tr>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Position</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Hyperlink</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Image</span></div></td>
                <td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Edit</span></div></td>
				<td><div align=\"center\"><span style=\"color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Remove</span></div></td>
              </tr>";
	$query = "select * from website_arris_banner where active = 1 order by position asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$position = $row['position'];
			$hyperlink_url = $row['hyperlink_url'];
			$image_name = $row['image_name'];
			$image_url = $row['image_url'];
			$items .= "<tr><td><div align=\"center\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;\">$position</span></div></td>
                <td><div align=\"center\"><a href=\"$hyperlink_url\" target=\"_blank\">View URL / Hyperlink</a></div></td>
                <td><div align=\"center\"><a href=\"$image_url\" target=\"_blank\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;\">$image_name</span></a></div></td>
                <td><div align=\"center\"><input type=\"button\" name=\"edit\" id=\"edit\" value=\"Edit\" onclick=\"editBannerItem('$id', '$position', '$hyperlink_url', this);\" /></div></td>
				<td><div align=\"center\"><input type=\"button\" name=\"remove\" id=\"remove\" value=\"Remove\" onclick=\"ajaxRemoveItem('$id');\" /></div></td></tr>";
		}
	}
	$items .= "</table>";
	echo "$items";
	
}

function adminLogout()
{
	$_SESSION['authorisation'] = NULL;
	$_SESSION['username'] = NULL;
	$_SESSION['forename'] = NULL;
	$_SESSION['surname'] = NULL;
	$_SESSION['user_level'] = NULL;
	
	echo "success";
}

// function to login and authenticate admin users and set session.
function adminLogin()
{
	if(isset($_GET['username']) && isset($_GET['password']))
	{
		$username = $_GET['username'];
		$password = $_GET['password'];
		
		$query = "SELECT * FROM user WHERE username = '$username' AND password = SHA('$password');";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if($row)
			{
				$_SESSION['authorisation'] = true;
				$_SESSION['username'] = $row['username'];
				$_SESSION['forename'] = $row['forename'];
				$_SESSION['surname'] = $row['surname'];
				$_SESSION['user_level'] = $row['user_level'];
				
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
	}
	else
	{
		echo "fail";
	}
}

mysql_close();
?>