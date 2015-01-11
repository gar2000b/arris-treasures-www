<?php

session_start();

// connect to the database.
require_once('./php_scripts/connect_alba_db.php');
require_once('./php_scripts/common.php');

function getAdvertisingBannerTimeoutInSecs() {
	// Get timeout in secs and convert it to ms.
	$query = "select timeout from website_arris_advertising_banner_timeout where id = 1;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$timeout = $row['timeout'];
	}
	
	echo "$timeout";
}

?>