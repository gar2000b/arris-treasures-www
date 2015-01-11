<?php

	// connect to the database.
	require_once('./php_scripts/connect_alba_db.php');
	require_once('./php_scripts/common.php');
	session_start(); // start up your PHP session!

	// Get Banner Count of active items
	$query = "select count(*) as count from website_arris_advertising_banner where active = 1;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$count = $row['count'];
		echo "var bannerCount = $count;";
	}
	
	echo "var bannerIndex = 0;";
	echo "var preload = new Array();";
	echo "var hyperlinkURLArray = new Array();";
	
	$query = "select * from website_arris_advertising_banner where active = 1 order by position asc;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$counter = 0;
		while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
			$image_url = $row['image_url'];
			$hyperlink_url = $row['hyperlink_url'];
			echo "preload[$counter] = new Image();";
			echo "preload[$counter].src = \"$image_url\";";
			echo "hyperlinkURLArray[$counter] = '$hyperlink_url';";
			$counter = $counter + 1;
		}
	}
	
	// Get timeout in secs and convert it to ms.
	$query = "select timeout from website_arris_advertising_banner_timeout where id = 1;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		$row = mysql_fetch_array($result, MYSQL_ASSOC);
		$timeout = $row['timeout'];
	}
	
	$timeout = $timeout * 1000;
	
	echo "
	$(function(){
		// $(window).load(fadeOut());
		setInterval(\"fadeOut()\", $timeout);
	});
	
	$(document).ready(function(){
		$('#middle_banner').click(function(e) {  
			window.open(hyperlinkURLArray[bannerIndex], '_blank');
			// alert(hyperlinkURLArray[bannerIndex]);
		});
	});
	
	function fadeOut() {
		if(bannerIndex == bannerCount-1) {
			bannerIndex = 0;
		} else {
			bannerIndex++;
		}
		var box = $(\"#middle_banner_content\");
		box.fadeTo(600, 0.01, function() {
			// Animation complete.
			$(\"#banner_image\").attr(\"src\", preload[bannerIndex].src);
			fadeIn();
		});
	}
	
	function fadeIn() {
		var box = $(\"#middle_banner_content\");
		box.fadeTo(600, 1.0);
	}";
?>