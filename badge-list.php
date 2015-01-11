<?php

	require_once('./php_scripts/connect_alba_db.php');
	require_once('./php_scripts/common.php');
	session_start(); // start up your PHP session!

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Badge List</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="">

<div align="center">
	<a href="index.html">Home</a>
	<h1 style="text-decoration:underline">Clan Crest Badge List</h1>
</div>
<div style="width:200;border:1">
	<table width="1072" border="0" align="center" cellpadding="1" cellspacing="0">
      <tr>
        <td width="96"><div align="center"><strong style="text-decoration:underline">Badge</strong></div></td>
        <td width="251"><p align="center"><strong style="text-decoration:underline">Clan</strong></p>      </td>
        <td width="504"><div align="center"><strong style="text-decoration:underline">Motto</strong></div></td>
        <td width="145"><div align="center"><strong style="text-decoration:underline">Mould</strong></div></td>
        <td width="66"><div align="center"><strong style="text-decoration:underline">Clan ID</strong></div></td>
      </tr>
<!--        <tr>
            <td><div align="center"><img src="images/badges/1.png" width="100" height="120" /></div></td>
            <td><p align="center">Clan Buchanan</p>      </td>
            <td><div align="center">CLARIOR HINC HONOS</div></td>
            <td><div align="center">1</div></td>
        </tr>-->
        <?php
			
			$query = "SELECT * FROM clan WHERE active = 1 ORDER BY name";
			$result = @mysql_query($query); // Run the query.
			if($result)
			{
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					$clanId = $row['Id'];
					$clanName = $row['name'];
					$clanMoto = $row['motto'];
					$clanMould = $row['mould'];
					
					// Spit out table row.
					echo "<tr>
            <td><div align=\"center\"><img src=\"images/badges/$clanId.png\" alt=\"Image Missing\" title=\"Clan $clanName\" width=\"100\" height=\"120\" /></div></td>
            <td><p align=\"center\">Clan $clanName</p>      </td>
            <td><div align=\"center\">$clanMoto</div></td>
            <td><div align=\"center\">$clanMould</div></td>
			<td><div align=\"center\">$clanId</div></td>
        </tr>";
				}
			}
		
		?>
</table>
    <br />
</div>

	</form>
</body>
</html>
