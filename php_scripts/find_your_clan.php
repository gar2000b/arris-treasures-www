<?php

// connect to the database.
require_once('./connect_alba_db.php');
require_once('./common.php');
session_start(); // start up your PHP session!

switch($_GET['type'])
{
	case 'findYourClan':
	findYourClan();
	break;
}

function findYourClan()
{
	$surname = $_GET['surname'];
	$results = "";
	
	$query = "SELECT clan.* FROM clan, clan_surnames, surnames WHERE clan_surnames.clan_id = clan.Id AND 
clan_surnames.surname_id = surnames.Id AND clan.active = 1 AND surnames.active = 1 AND 
surnames.name = '$surname'";
	$result = @mysql_query($query); // Run the query.
	$num_rows = mysql_num_rows($result);
	if($result)
	{
		if($num_rows == 0)
		{
			$results = "Sorry, no results!";
		}
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$clanName = $row['name'];
			$results .= "<a href = 'http://stores.ebay.co.uk/Alba-Accessories/_i.html?_nkw=Clan+$clanName&submit=Search' target='_blank'>Clan $clanName</a> ";
		}
	}
	
	echo "<p>$results</p>";
}

?>