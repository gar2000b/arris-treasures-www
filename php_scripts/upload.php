<?php

	session_start();
	
	// connect to the database.
	require_once('./connect_alba_db.php');
	require_once('./common.php');
	
	// Get URL path from PHP..
	$site_url = "http://" . $_SERVER["SERVER_NAME"];
	
	// Get root folder from PHP..
	$doc_root = $_SERVER['DOCUMENT_ROOT'];
	
	// Edit upload location here
	$destination_path = getcwd().DIRECTORY_SEPARATOR . "../images/banner/";
	
	$result_transaction = 0;
	$target_new = '1';
	
	if($_FILES['myfile']['name'] != NULL && $_FILES['myfile']['name'] != "") {
		$target_path = $destination_path . basename( $_FILES['myfile']['name']);
		
		if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
		  $result_transaction = 1;
		  // $target_path = str_replace("\\", "-", $target_path);
		  // $target_path = str_replace("/", "-", $target_path);
		  $target_new = '1';
		}
	}
	
	$position = $_POST['position'];
	$hyperlink = $_POST['hyperlink'];
	$fileName = basename( $_FILES['myfile']['name'] );
	$imageURL = $site_url . "/images/banner/" . $fileName;

	// We now find out if this is an update or an insert.
	if($_POST['submitBtn'] == "Insert") {
		// Before the new Item is inserted, we have to re-shuffle all items below set position.
		// So perform a select against all items below that position, cycle through them and update / increment
		// each position by 1.
		$query = "select * from website_ebay_banner where active = 1 and position >= $position;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			while($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				$Id = $row['Id'];
				$currentPosition = $row['position'];
				$newPosition = intval($currentPosition) + 1;
				
				$query2 = "UPDATE website_ebay_banner SET position = '$newPosition' WHERE Id = '$Id';";
				$result2 = @mysql_query($query2); // Run the query.
				if($result2)
				{
					// Update successfull.
				}
			}
		}
	
		// Now insert the new item.
		$query = "INSERT INTO website_ebay_banner(Id, position, image_name, image_url, hyperlink_url, active, date_time) values('', '$position', '$fileName', '$imageURL', '$hyperlink', 1, NOW());";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Insert successfull.
			$int_id = mysql_insert_id();
		}
	} elseif($_POST['submitBtn'] == "Update") {
		// Get Id.
		$itemId = $_POST['itemUpdateId'];
		// Take note of new position.
		$position = $_POST['position'];
		// Take note of old position.
		$oldPosition = $_POST['oldPosition'];
		
		// If filename is empty, then get existing image name and image url.
		if($fileName == "") {
			$query = "select * from website_ebay_banner where Id = $itemId";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				$row = mysql_fetch_array($result, MYSQL_ASSOC);
				$fileName = $row['image_name'];
				$imageURL = $row['image_url'];
			}
		}
		
		
		// Where old position < new position.
		if($oldPosition < $position) {
			$query = "select * from website_ebay_banner where position > $oldPosition && position <= $position and active = 1 order by position;";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$Id = $row['Id'];
					$currentSelection = intval($row['position']);
					$currentSelection = $currentSelection - 1;
					
					// Now do the update.
					$query2 = "UPDATE website_ebay_banner SET position = '$currentSelection' WHERE Id = '$Id';";
					$result2 = @mysql_query($query2); // Run the query.
					if($result2)
					{
						// Update successfull.
					}
				}
			}
			// Now perform the update for the item in question.
			$query = "UPDATE website_ebay_banner SET position = '$position', hyperlink_url = '$hyperlink', image_url = '$imageURL', image_name = '$fileName' WHERE Id = '$itemId';";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				// Update successfull.
			}
		}
		// Where old position > new position.
		if($oldPosition > $position) {
			$query = "select * from website_ebay_banner where position >= $position && position < $oldPosition and active = 1 order by position;";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$Id = $row['Id'];
					$currentSelection = intval($row['position']);
					$currentSelection = $currentSelection + 1;
					
					// Now do the update.
					$query2 = "UPDATE website_ebay_banner SET position = '$currentSelection' WHERE Id = '$Id';";
					$result2 = @mysql_query($query2); // Run the query.
					if($result2)
					{
						// Update successfull.
					}
				}
			}
			// Now perform the update for the item in question.
			$query = "UPDATE website_ebay_banner SET position = '$position', hyperlink_url = '$hyperlink', image_url = '$imageURL', image_name = '$fileName' WHERE Id = '$itemId';";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				// Update successfull.
			}
		}
		// Where old position = new position.
		if($oldPosition == $position) {
			// Now perform the update for the item in question.
			$query = "UPDATE website_ebay_banner SET position = '$position', hyperlink_url = '$hyperlink', image_url = '$imageURL', image_name = '$fileName' WHERE Id = '$itemId';";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				// Update successfull.
			}
		}
	}
   
   // sleep(1);
   
?>

<script language="javascript" type="text/javascript">window.top.window.stopUpload(<?php echo $result_transaction; ?>, '<?php echo $int_id; ?>');</script>   
