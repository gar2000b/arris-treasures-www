<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Kilt Pins</title>
</head>

<body>

<?php

require_once("php_scripts/common.php");
require_once('php_scripts/connect_alba_db.php');

$counter = 0;

$query = "SELECT * FROM clan WHERE active = '1' ORDER BY name;";
$result = @mysql_query($query); // Run the query.
if($result)
{
	echo "<p>";
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$id = $row['Id'];
		$name = $row['name'];
		echo "$name, ";
	}
	echo"<br/>";
	echo "<p>$counter</p>";
}

?>

</body>
</html>
