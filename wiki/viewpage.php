<?php
	require_once('../php_scripts/connect_db.php');
	require_once('../php_scripts/common.php');
	require_once('../php_scripts/wiki.php');
	session_start(); // start up your PHP session!
	
	$pageId = $_GET['pageId'];
	$query = "SELECT * FROM wiki_pages WHERE Id = $pageId;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$content = $row['content'];
		// Specific to code prettifier wiki page to remove spaces from < pre & < /pre>
		$content = str_replace("&lt; pre", "&lt;pre", $content);
		$content = str_replace("&lt; /pre", "&lt;/pre", $content);
		$pageName = $row['page_name'];
		$visibility = $row['visibility'];
	}
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo "$pageName"; ?></title>
<script type="text/javascript" src="../google-code-prettify/run_prettify.js"></script>
<link type="image/x-icon" href="/images/layout/favicon.ico" rel="icon">
</head>

<body bgcolor="#003366">
<?php
	echo "<div align=\"center\">";
	echo "<div style = \"background-color:#FFFFFF; border-style:solid; border-width:1px; padding:5px; width:75%; text-align:left; \">$content</div><br/>";
	echo "</div>";
?>
</body>
</html>
