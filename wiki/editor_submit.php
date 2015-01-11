<?php

	require_once('../php_scripts/connect_db.php');
	require_once('../php_scripts/common.php');
	require_once('../php_scripts/wiki.php');
	session_start(); // start up your PHP session!

	$pageId = $_POST['pageId'];
	$content = "";
	if( isset($_POST['content']) ){
		$pageName = $_POST['pageName'];
		$pageDescription = $_POST['pageDescription'];
		$content = str_replace("\\\"", "\"", $_POST['content']);
		$query = "UPDATE wiki_pages SET content = \"$_POST[content]\", 
	last_updated = NOW(), page_name = '$pageName', description = '$pageDescription' WHERE Id = $pageId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			// Update successfull.
			// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Update success');<\/script>";
		}
		else {
			"<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Sorry, there was a problem');</script>";
		}
		
		// replace \\ with \
		$content = str_replace("\\\\", "\\", $content);
		// Specific to code prettifier wiki page to remove spaces from < pre & < /pre>
		$content = str_replace("&lt; pre", "&lt;pre", $content);
		$content = str_replace("&lt; /pre", "&lt;/pre", $content);
		
		echo "<html>";
		echo "<head>";
		echo "<title>$pageName (preview)</title>";
		echo "<script type=\"text/javascript\" src=\"../google-code-prettify/run_prettify.js\"></script>";
		echo "<link type=\"image/x-icon\" href=\"/images/layout/favicon.ico\" rel=\"icon\">";
		echo "</head>";
		echo "<body bgcolor=\"#003366\">";
		echo "<div align=\"center\">";
		echo "<div style = \"background-color:#FFFFFF; border-style:solid; border-width:1px; padding:5px; width:75%; text-align:left; \">$content</div><br/>";
		echo "<input type=\"button\" onclick=\"window.location = 'editor.php?pageId=$_POST[pageId]';\" value=\"Back\" />";
		echo "</div>";
		echo "</body>";
		echo "</html>";
	} else {
		$query = "SELECT * FROM wiki_pages WHERE Id = $pageId;";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$content = $row['content'];
			// replace \\ with \
			$content = str_replace("\\\\", "\\", $content);
			// Specific to code prettifier wiki page to remove spaces from < pre & < /pre>
			$content = str_replace("&lt; pre", "&lt;pre", $content);
			$content = str_replace("&lt; /pre", "&lt;/pre", $content);
			$pageName = $row['page_name'];
			echo "<html>";
			echo "<head>";
			echo "<title>$pageName (preview)</title>";
			echo "<script type=\"text/javascript\" src=\"../google-code-prettify/run_prettify.js\"></script>";
			echo "<link type=\"image/x-icon\" href=\"/images/layout/favicon.ico\" rel=\"icon\">";
			echo "</head>";
			echo "<body bgcolor=\"#003366\">";
			echo "<div align=\"center\">";
			echo "<div style = \"background-color:#FFFFFF; border-style:solid; border-width:1px; padding:5px; width:75%; text-align:left; \">$content</div><br/>";
			echo "<input type=\"button\" onclick=\"window.location = 'editor.php?pageId=$_POST[pageId]';\" value=\"Back\" />";
			echo "</div>";
			echo "</body>";
			echo "</html>";
		}
	}

?>