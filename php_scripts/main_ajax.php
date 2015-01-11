<?php

session_start();

// connect to the database.
require_once('./connect_alba_db.php');
require_once('./common.php');

switch($_GET['type'])
{
	case 'getMessages':
	getMessages();
	break;
	case 'getSoapMessage':
	getSoapMessage();
	break;
	case 'adminLogin':
	adminLogin();
	break;
	case 'adminLogout':
	adminLogout();
	break;
	case 'getPage':
	getPage();
	break;
	case 'getReturns':
	getReturns();
	break;
	case 'getBannerItems':
	getBannerItems();
	break;
	case 'removeBannerItem':
	removeBannerItem();
	break;
	case 'getWorldOfIdeas':
	getWorldOfIdeas();
	break;
	case 'insertWorldOfIdeasItem':
	insertWorldOfIdeasItem();
	break;
	case 'removeWorldofIdeasItem':
	removeWorldofIdeasItem();
	break;
	case 'updateWorldOfIdeasItem':
	updateWorldOfIdeasItem();
	break;
	case 'updateEbayID':
	updateEbayID();
	break;
	case 'submitDetails':
	submitDetails();
	break;
}

function submitDetails() {
	
	$transactionID = $_GET['transactionID'];
	
	$query = "UPDATE website_image_upload_keyrings_1 SET details_submitted = 1 WHERE Id = '$transactionID';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
		echo "success";
	}
	
}

function updateEbayID() {
	
	$ebayID = $_GET['ebayID'];
	$transactionID = $_GET['transactionID'];
	
	// Now that we have our basic details, update the DB record with the users eBay ID.
	$query = "UPDATE website_image_upload_keyrings_1 SET ebay_user_id = '$ebayID' WHERE Id = '$transactionID';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
		echo "success";
	}
}

function updateWorldOfIdeasItem()
{
	// Title
	$title = $_GET['title'];
	//Description
	$description = $_GET['description'];
	// Get Id.
	$itemId = $_GET['itemUpdateId'];
	// Take note of new position.
	$position = $_GET['position'];
	// Take note of old position.
	$oldPosition = $_GET['oldPosition'];
	// Type Id
	$typeId = $_GET['typeId'];
	
	
	// Where old position < new position.
	if($oldPosition < $position) {
		$query = "select * from website_world_of_ideas where position > $oldPosition && position <= $position and active = 1 and type_id = $typeId order by position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentSelection = intval($row['position']);
				$currentSelection = $currentSelection - 1;
				
				// Now do the update.
				$query2 = "UPDATE website_world_of_ideas SET position = '$currentSelection' WHERE Id = '$Id';";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
		}
		// Now perform the update for the item in question.
		$query = "UPDATE website_world_of_ideas SET position = '$position', title = '$title', description = '$description' WHERE Id = '$itemId';";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Update successfull.
		}
	}
	// Where old position > new position.
	if($oldPosition > $position) {
		$query = "select * from website_world_of_ideas where position >= $position && position < $oldPosition and active = 1 and type_id = $typeId order by position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentSelection = intval($row['position']);
				$currentSelection = $currentSelection + 1;
				
				// Now do the update.
				$query2 = "UPDATE website_world_of_ideas SET position = '$currentSelection' WHERE Id = '$Id';";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
		}
		// Now perform the update for the item in question.
		$query = "UPDATE website_world_of_ideas SET position = '$position', title = '$title', description = '$description' WHERE Id = '$itemId';";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Update successfull.
		}
	}
	// Where old position = new position.
	if($oldPosition == $position) {
		// Now perform the update for the item in question.
		$query = "UPDATE website_world_of_ideas SET position = '$position', title = '$title', description = '$description' WHERE Id = '$itemId';";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Update successfull.
		}
	}
	echo "success";
}

function removeWorldofIdeasItem()
{
	$reasonType = $_GET['reasonType'];
	$itemId = $_GET['itemId'];
	$typeId = $_GET['typeId'];
	$query = "UPDATE website_world_of_ideas SET active = 0, remove_reason_type_id = $reasonType WHERE Id = $itemId;";
	$result = @mysql_query($query); // Run the query.
	if($result){
	
		// Update successfull. Now shuffle..
		$query = "select * from website_world_of_ideas where id = $itemId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$position = $row['position'];
		}
		
		$query = "select * from website_world_of_ideas where active = 1 and position > $position and type_id = $typeId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentPosition = $row['position'];
				$newPosition = intval($currentPosition) - 1;
				
				$query2 = "UPDATE website_world_of_ideas SET position = '$newPosition' WHERE Id = '$Id';";
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

function insertWorldOfIdeasItem()
{
	$position = $_GET['position'];
	$title = $_GET['title'];
	$description = $_GET['description'];
	$typeId = $_GET['typeId'];
	
	// Now that we have our variables passed in, we need to work out where to insert.
	// Before the new Item is inserted, we have to re-shuffle all items below set position.
	// So perform a select against all items below that position, cycle through them and update / increment
	// each position by 1.
	$query = "select * from website_world_of_ideas where active = 1 and position >= $position and type_id = $typeId;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$Id = $row['Id'];
			$currentPosition = $row['position'];
			$newPosition = intval($currentPosition) + 1;
			
			$query2 = "UPDATE website_world_of_ideas SET position = '$newPosition' WHERE Id = '$Id';";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				// Update successfull.
			}
		}
	}

	// Now insert the new item.
	$query = "INSERT INTO website_world_of_ideas(Id, position, title, description, type_id, remove_reason_type_id, active, date_time) values('', '$position', '$title', '$description', '$typeId', 0, 1, NOW());";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Insert successfull.
		$int_id = mysql_insert_id();
		echo "success";
	}
	
}

function getWorldOfIdeas()
{
	$typeId = $_GET['typeId'];
	$items = "<table width=\"633\" border=\"0\" align=\"center\" id=\"banner_table\">";
	
	$query = "select * from website_world_of_ideas WHERE type_id = $typeId and active = 1 order by position asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$id = $row['Id'];
			$position = $row['position'];
			$title = $row['title'];
			$description = $row['description'];
			$items .= "<tr>
				<td><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;\">Position</span></td>
				<td><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;\">Title</span></td>
				<td><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;\">Edit</span></td>
				<td><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;\">Remove</span></td>
			  </tr>
			  <tr id=\"tr1\">
				<td><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;\">$position</span></td>
				<td><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;\">$title</span></td>
				<td><input type=\"button\" name=\"edit\" id=\"edit\" value=\"Edit\" onclick=\"worldOfIdeasPage.editWorldOfIdeasItem('$id', '$position', '$title', '$description', this);\" /></td>
				<td><input type=\"button\" name=\"remove\" id=\"remove\" value=\"Remove\" onclick=\"worldOfIdeasPage.removeItem('$id'); //bannerAdminPage.ajaxGetBannerItems();\" /></td>
			  </tr>
			  <tr>
				<td colspan=\"4\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;\">Description</span></td>
			  </tr>
			  <tr>
				<td colspan=\"4\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;\">$description<hr style=\"color:#009966\" /></span></td>
			  </tr>
			  <tr>
				<td colspan=\"4\">&nbsp;</td>
			  </tr>";
		}
	}
	
	$items .= "</table>";

	echo "$items";
}

function removeBannerItem()
{
	$itemId = $_GET['itemId'];
	$query = "UPDATE website_ebay_banner SET active = 0 WHERE Id = $itemId;";
	$result = @mysql_query($query); // Run the query.
	if($result){
	
		// Update successfull. Now shuffle..
		$query = "select * from website_ebay_banner where id = $itemId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$position = $row['position'];
		}
		
		$query = "select * from website_ebay_banner where active = 1 and position > $position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentPosition = $row['position'];
				$newPosition = intval($currentPosition) - 1;
				
				$query2 = "UPDATE website_ebay_banner SET position = '$newPosition' WHERE Id = '$Id';";
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
                <td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Position</span></div></td>
                <td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Hyperlink</span></div></td>
                <td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Image</span></div></td>
                <td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Edit</span></div></td>
				<td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Remove</span></div></td>
              </tr>";
	$query = "select * from website_ebay_banner where active = 1 order by position asc;";
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
                <td><div align=\"center\"><input type=\"button\" name=\"edit\" id=\"edit\" value=\"Edit\" onclick=\"bannerAdminPage.editBannerItem('$id', '$position', '$hyperlink_url', this);\" /></div></td>
				<td><div align=\"center\"><input type=\"button\" name=\"remove\" id=\"remove\" value=\"Remove\" onclick=\"bannerAdminPage.ajaxRemoveItem('$id');\" /></div></td></tr>";
		}
	}
	$items .= "</table>";
	echo "$items";
	
}

// This function gets a page request param $_GET['page'] (page name and path).
// It then pulls the string contents of the page into a variable and it's page
// contents subsequently stripped out for return.
function getPage()
{
	// Note: all pages passed in are assumed relative to the root.  Therefore
	// pages/test1.html is really /pages/test1.html
	// We therefore have to preppend ../ to the name for proper reference.
	$file_page_name_path = "../" . $_GET['page'];
	$page_temp = file_get_contents($file_page_name_path);
	$page_contents_start = strpos($page_temp, "<!-- ***contentStart*** -->") + 27;
	$page_contents_end = strpos($page_temp, "<!-- ***contentEnd*** -->");
	$page_contents = substr($page_temp, $page_contents_start, $page_contents_end);
	
	echo $page_contents;
	// echo "<p>wtf</p>";
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
	if(checkAuthorisation() == true)
	{
		echo "success";
	}
	elseif(isset($_GET['username']) && isset($_GET['password']))
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

// This function gets messages from DB & returns string in bespoke format for javascript to parse.
function getMessages()
{
	// Pulls in common variables(from ajax) required specifically for table, like $rowQty, $pageNo & $fromPos.
	include("table.php");
	
	// Build up data table query.
	$columnArray = array(0 => 'name', 'email', 'date_time');
	$columnLabelArray = array(0 => 'Name', 'Email', 'Date Time');
	$tableName = "messages";
	$filterArray = convertFilter($filter);
	$filterQuery = buildFilterQuery($columnArray, $filterArray);
	$selectQuery = buildSelectQuery($columnArray, $columnLabelArray, $tableName, $filterQuery, $fromPos, $rowQty);

	// Function that takes query results and parses to bespoke format for javascript.
	$data = buildDataTableObjectNotation($selectQuery);
	// echo $data . $filter . $query;
	echo $data;
}

function getSoapMessage()
{
	try {
		$soap = new SoapClient("http://88.208.248.38:9876/ts?wsdl");
		$message = $soap->getFirstMessage();
		echo $message;
	} catch(SoapFault $ex) {
		$msg = "Error";
		echo $msg;
		exit;
	}
}

function getReturns()
{

	// Build up HTML Table.
	$html_table = "<table width=\"752\" border=\"0\" align=\"center\">
	  <tr>
		<td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Return Description</span></div></td>
		<td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Hyperlink Postage Label</span></div></td>
		<td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Date / Time Inserted</span></div></td>
		<td><div align=\"center\"><span style=\"color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">Mark as Done</span></div></td>
	  </tr>";
			  
	$query = "SELECT * FROM returns";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$Id = $row['Id'];
			$return_description = $row['return_description'];
			$hyperlink_postage_label = $row['hyperlink_postage_label'];
			$complete_flag = $row['complete_flag'];
			$date_time = $row['date_time'];
			  
			// Assemble individual rows
			$html_table .= "<tr id=\"tr$Id\" style=\"text-decoration:line-through\">
		<td><div align=\"center\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">$return_description</span></div></td>
		<td><div align=\"center\"><a href=\"$hyperlink_postage_label\" target=\"_blank\">View / Print Label</a></div></td>
		<td><div align=\"center\"><span style=\"color:#0066FF; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;\">$date_time</span></div></td>
		<td><div align=\"center\">
		  <label>
		  <input type=\"submit\" name=\"button$Id\" id=\"button$Id\" value=\"Done\" disabled=\"disabled\" />
		  </label>
		</div></td>
	  </tr>";
	  
		} // End of while
	} // End of if
	
	$html_table .= "</table>";
	
	echo $html_table;
}

mysql_close();
?>