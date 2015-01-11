<?php

session_start();

switch($_POST['type']) {
	case 'addGroup':
	addGroup();
	break;
	case 'addPage':
	addPage();
	break;
	case 'deletePage':
	deletePage();
	break;
	case 'deleteImage':
	deleteImage();
	break;
	case 'removeGroup':
	removeGroup();
	case 'adminLogin':
	adminLogin();
	break;
	case 'logout':
	logout();
	break;
	case 'uploadImage':
	uploadImage();
	break;
}

function uploadImage() {

	require_once('connect_db.php');

	// Get URL path from PHP..
	$site_url = "http://" . $_SERVER["SERVER_NAME"];
	// Get root folder from PHP..
	$doc_root = $_SERVER['DOCUMENT_ROOT'];
	$fileName = basename( $_FILES['myfile']['name'] );
	
	// Edit upload location here
	$destination_path = getcwd().DIRECTORY_SEPARATOR . "../images/wiki/";
	$result = 0;
   
	// Before we assemble the target path and copy the file across from tmp to actual location,
	// we have to create the DB entry that will track this upload entry.
	$query = "INSERT INTO wiki_images(Id, image_name, image_path, active, date_time, last_updated) values('', '', '', 1, NOW(), NOW());";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Insert successfull.
		$int_id = mysql_insert_id();
	}
	
	$fileName = $int_id . "-" .$fileName;
	
	// Now that we've inserted the DB Entry, we have to update the image_name & image_path based on the Id just created.
	$query = "UPDATE wiki_images SET image_name = '$fileName', image_path = '/images/wiki/$fileName' WHERE Id = '$int_id';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
	}
	
	$target_path = $destination_path . $fileName;
	
	if(@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
		$result = 1;
	}
	
	sleep(1);
	
	echo "<script language=\"javascript\" type=\"text/javascript\">window.top.stopUpload();</script>";
}

function logout() {

	$_SESSION['authorisation'] = false;
	$_SESSION['username'] = '';
	$_SESSION['forename'] = '';
	$_SESSION['surname'] = '';
	$_SESSION['user_level'] = '';
	
	header("Location: /wiki/index.php");
	
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
				$_SESSION['username'] = $row['user_name'];
				$_SESSION['forename'] = $row['first_name'];
				$_SESSION['surname'] = $row['last_name'];
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

function removeGroup() {
	$removePageGroup = $_POST['removePageGroup'];
	$query = "UPDATE wiki_group SET active = 0 WHERE Id = '$removePageGroup';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
	}
}

function deletePage() {
	$pageId = $_POST['pageId'];
	$query = "UPDATE wiki_pages SET active = 0, last_updated = NOW() WHERE Id = '$pageId';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
	}
}

function deleteImage() {
	$imageId = $_POST['imageId'];
	$query = "UPDATE wiki_images SET active = 0, last_updated = NOW() WHERE Id = '$imageId';";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		// Update successfull.
	}
}

function addPage() {
	$pageName = $_POST['pageName'];
	$pageDescription = $_POST['pageDescription'];
	$pageGroup = $_POST['pageGroup'];
	
	$query = "INSERT INTO wiki_pages(Id, page_name, content, description, group_id, date_time, last_updated) values('', '$pageName', '', '$pageDescription', '$pageGroup', NOW(), NOW());";
	$result = @mysql_query($query); // Run the query.
	if($result) {
		// Insert successfull.
		$int_id = mysql_insert_id();
	}
}

function addGroup() {
	$group = $_POST['group'];
	
	$query = "INSERT INTO wiki_group(Id, name) values('', '$group');";
	$result = @mysql_query($query); // Run the query.
	if($result) {
		// Insert successfull.
		$int_id = mysql_insert_id();
	}
}

function renderGroupsAndPages() {
	$query = "select * from wiki_group where active = 1 order by name asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$name = $row['name'];
			$Id = $row['Id'];
			
			echo "<tr>
				<td><strong>$name</strong></td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			  </tr>";
			  
			// Now get pages against group.
			$query2 = "select * from wiki_pages WHERE group_id = '$Id' and active = 1;";
			$result2 = @mysql_query($query2); // Run the query.
			if($result2)
			{
				while($row2 = mysql_fetch_array($result2, MYSQL_ASSOC)) {
					$pageId = $row2['Id'];
					$pageName = $row2['page_name'];
					$pageContent = $row2['content'];
					$pageDescription = $row2['description'];
					$pageGroupId = $row2['group_id'];
					
					echo "<tr>
						<td>&nbsp;</td>
						<td>$pageName</td>
						<td>$pageDescription</td>
						<td><a href=\"viewpage.php?pageId=$pageId\" target=\"_blank\">View</a> / <a href=\"editor.php?pageId=$pageId\" target=\"_blank\">Edit</a> / <a href=\"#\" onclick=\"deletePage('$pageId');\">Delete</a></td>
					  </tr>";
				}
			}
		}
	}
}

function renderSelectGroup($groupIdName) {
	echo "<select id = '$groupIdName' name = '$groupIdName'>";
	$query = "select * from wiki_group where active = 1 order by name asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$Id = $row['Id'];
			$name = $row['name'];
			echo "<option value=\"$Id\">$name</option>";
		}
	}
	echo "</select>";
}

function checkLogin() {
	if($_SESSION['authorisation'] != true) {
		header("Location: index.php");
	}
}

function getLoginDetails() {
	
	echo "Logged in user: " . $_SESSION['forename'] . " " . $_SESSION['surname'];
	
}

function getImageDetails() {

	$query = "SELECT * FROM wiki_images WHERE active = 1 ORDER BY Id DESC;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$Id = $row['Id'];
			$image_name = $row['image_name'];
			$image_path = $row['image_path'];
			echo "<tr>";
			echo "<td>$image_name</td>";
			echo "<td>$image_path</td>";
			echo "<td><a href=\"#\" onclick=\"testViewImage('$image_path');\">View</a> / <a href=\"#\" onclick=\"deleteImage('$Id');\">Delete</a></td>";
			echo "</tr>";
		}
	}
}

?>