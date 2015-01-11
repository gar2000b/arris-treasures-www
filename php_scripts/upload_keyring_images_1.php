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
	$destination_path = getcwd().DIRECTORY_SEPARATOR . "../images/keyrings_1/";
	
	$result_transaction = 0;
	$target_new = '1';
	
	if($_FILES['myfile']['name'] != NULL && $_FILES['myfile']['name'] != "") {
	
		// We need to create a new DB record here before we upload image and rename to include the same ID
		// as the DB record.
		$query = "insert into website_image_upload_keyrings_1(Id, image_original_name, image_name, 
image_url, work_stage, ebay_user_id, details_submitted, active, date_time) values('', '', '', '', 1, '', 0, 1, NOW());";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Insert successfull.
			$int_id = mysql_insert_id();
		}
		
		$image_original_name = basename( $_FILES['myfile']['name']);
		$image_name = "$int_id" . "_" . $image_original_name;
		$imageURL = $site_url . "/images/keyrings_1/" . $image_name;
		
		$target_path = $destination_path . $image_name;
		
		if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
		  // $result_transaction = 1;
		  // $target_path = str_replace("\\", "-", $target_path);
		  // $target_path = str_replace("/", "-", $target_path);
		  // $target_new = '1';
			// Now update the newly inserted record with image names and url.
			$query = "UPDATE website_image_upload_keyrings_1 SET image_original_name = '$image_original_name', 
			image_name = '$image_name', image_url = '$imageURL' WHERE Id = '$int_id';";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				// Update successfull.
				// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Update success');<\/script>";
			}
		}
	}
   
?>

<script language="javascript" type="text/javascript">
	// alert(window.top.frames[3]);
	// alert(window.top.frames['targetFrame'].stopUpload);
	// alert("Please work");
	// alert(window.top.window.frames['b'].frames['d'].stopUpload);
	// alert(parent.stopUpload);
	// alert(stopUpload);
	// window.top.window.frames['b'].frames['d'].stopUpload('<?php echo $imageURL ?>', '<?php echo $int_id ?>');
	// alert('Did we');
	parent.stopUpload('<?php echo $imageURL ?>', '<?php echo $int_id ?>');
</script>