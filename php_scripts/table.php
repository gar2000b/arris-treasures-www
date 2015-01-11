<?php

	$rowQty = $_GET['rowQty']; // 5
	$pageNo = $_GET['pageNo']; // 3
	$fromPos = ((integer)$rowQty * (integer)$pageNo) - (integer)$rowQty; // 10
	$filter = $_GET['filter'];

?>