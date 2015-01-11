<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Convert Filter Test</title>
</head>

<body>

<?php 

	require_once('../common.php');

	$testsPassedFlag = true;
	$failureCount = 0;
	$filter = "filter_0\$abcd#1\$efgh#2\$ijkl#3\$categoryValue";
	// $filter = "filter_0\$der#3\$categoryValue";
	
	// 1st test - check 4 elements are stripped out.
	$filterArray = convertFilter($filter);
	echo "Filter Array Length is " . sizeof($filterArray) . "<br />";
	if(!assert(sizeof($filterArray) == 4)){$testsPassedFlag = false; $failureCount++;}

	// 2nd test - check each value.
	if(!assert($filterArray[0] == "abcd")){$testsPassedFlag = false; $failureCount++;}
	if(!assert($filterArray[1] == "efgh")){$testsPassedFlag = false; $failureCount++;}
	if(!assert($filterArray[2] == "ijkl")){$testsPassedFlag = false; $failureCount++;}
	if(!assert($filterArray[3] == "categoryValue")){$testsPassedFlag = false; $failureCount++;}
	
	// 2nd test - check each value.
//	if(!assert($filterArray[0] == "der")){$testsPassedFlag = false; $failureCount++;}
//	if(!assert($filterArray[1] == "")){$testsPassedFlag = false; $failureCount++;}
//	if(!assert($filterArray[2] == "")){$testsPassedFlag = false; $failureCount++;}
//	if(!assert($filterArray[3] == "categoryValue")){$testsPassedFlag = false; $failureCount++;}
	
	if($testsPassedFlag) {
		echo "<br />All Tests PASSED.";
	}
	else {
		echo "<br />$failureCount Tests FAILED.";
	}

?>

</body>
</html>
