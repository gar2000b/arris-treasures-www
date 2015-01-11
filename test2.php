<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Convert Filter Test</title>
</head>

<body>

<?php 
	$filter = "filter=0:ngfd#1:ngfd#2:nfgd#3:categoryValue";

	// Strip out header and get content.
	$filterContent = substr($filter, strpos($filter, "=") + 1);
	// Strip out the last filter element and work out total.
	$position1 = strrpos($filterContent, ":");
	$position2 = strrpos($filterContent, "#", -1);
	$lastElement = substr($filterContent, $position2 + 1, ($position1 - $position2) - 1);
	$totalElements = $lastElement + 1;
	
	echo "Total elements = " + $totalElements;
	
	for($i = 0; $i < $totalElements; $i++) {
		$filterArray[$i] = substr($filterContent, strpos($filterContent, ":") + 1, strpos($filterContent, "#") - strpos($filterContent, ":") - 1);
		$filterContent = substr($filterContent, strpos($filterContent, "#") + 1);
	}
	
	


// echo substr($test, strpos($test, "abc"), 2);
// echo substr($test, strpos($test, ":") + 1, strpos($test, "#") - strpos($test, ":") - 1);

?>

</body>
</html>
