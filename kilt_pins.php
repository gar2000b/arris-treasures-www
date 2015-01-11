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

$query = "SELECT * FROM clan WHERE active = '1';";
$result = @mysql_query($query); // Run the query.
if($result)
{
	$counter = 0;
	$counter2 = 0;
	$counter3 = 0;
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		$id = $row['Id'];
		$name = $row['name'];
		
		$query2 = "SELECT COUNT(*) AS count FROM clan_surnames WHERE clan_id = $id;";
		$result2 = @mysql_query($query2); // Run the query.
		if($result2)
		{
			$row2 = mysql_fetch_array($result2, MYSQL_ASSOC);
			$count = $row2['count'];
			if($count > 210 && $count <= 420)
			{
				$counter2++;
				echo "<p><a href = 'images/kilt_pins/$id.jpg' target='_blank'>$name</a> ($count) *** > 210 <= 420</p>";
			}
			elseif($count > 420)
			{
				$counter3++;
				echo "<p><a href = 'images/kilt_pins/$id.jpg' target='_blank'>$name</a> ($count) *** > 420</p>";
			}
			else
			{
				echo "<p><a href = 'images/kilt_pins/$id.jpg' target='_blank'>$name</a> ($count)</p>";
			}
		}
		
		$counter++;
	}
	
	$mostClans = $counter - $counter2 - $counter3;
	
	echo "<p>Number of clans is $counter</p>";
	echo "<p>Number of clans less than or equal to 210 names is $mostClans</p>";
	echo "<p>Number of clans with over 210 names and less than or equal to 420 is $counter2</p>";
	echo "<p>Number of clans with over 420 names is $counter3</p>";
	echo "<p>Max no of characters per name field is 50</p>";
	echo "<p>Average name in chars is 7</p>";
	echo "<p>Therefore can have 7 names per name field</p>";
	echo "<p>Or 7 x 30 = 210 names per listing.</p>";
	echo "<p>Or 7 x 30 = 210 names per listing.</p>";
	echo "<p>From 19227 names, that gives us 92 listings.</p>";
	echo "<p>92 listings would cost £0.40p x 92 = £36.80</p>";
	echo "<p>( NOT NEEDED - used to help find your clan )</p>";
}

?>

</body>
</html>
