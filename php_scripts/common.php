<?php

// This function will build the initial portion of the select query for our data table.
function buildSelectQuery($columnArray, $columnLabelArray, $tableName, $filterQuery, $fromPos, $rowQty)
{
	$query = "SELECT $columnArray[0] AS $columnLabelArray[0], $columnArray[1] AS $columnLabelArray[1], $columnArray[2] AS '$columnLabelArray[2]' FROM $tableName $filterQuery LIMIT $fromPos, $rowQty";
	
	return $query;
}

// This function will take in a columnArray and filterArray and then build up a filter query.
function buildFilterQuery($columnArray, $filterArray)
{
	$queryContent = "";
	for($i = 0; $i < sizeof($columnArray); $i++) {
		if($i != sizeof($columnArray) - 1) {
			$queryContent = $queryContent . $columnArray[$i] . " LIKE '%$filterArray[$i]%' AND ";
		}
		else {
			$queryContent = $queryContent . $columnArray[$i] . " LIKE '%$filterArray[$i]%'";
		}
	}
	return $filterQuery = "WHERE $queryContent";
	// $filterQuery = "WHERE name LIKE '%$filterArray[0]%' AND email LIKE '%$filterArray[1]%' AND date_time LIKE '%$filterArray[2]%'";
}

// This function will convert the filter string into a filter array that can be used when constructing the select query for tabular data.
function convertFilter($filter)
{
	// Strip out header and get content.
	$filterContent = substr($filter, strpos($filter, "_") + 1);
// 	echo "$filterContent";
	// Strip out the last filter element and work out total.
	$position1 = strrpos($filterContent, "$");
	$position2 = strrpos($filterContent, "#", -1);
	$lastElement = substr($filterContent, $position2 + 1, ($position1 - $position2) - 1);
	$totalElements = $lastElement + 1;
	
// 	echo "<br/>do we get here - $totalElements<br/>";
	for($i = 0; $i < $totalElements; $i++) {
		$termPos = strpos($filterContent, "#");
		if($termPos == "") {
			$termPos = strlen($filterContent);
		}
		// Need a condition to determine whether we should add the current element data to the array. We do this by checking that the element number
		// is equal to the loops index position. If not, do not add as this means that a column filter has been left empty and we want the array to
		// represent this. In fact, we'll make it an empty string so that the like clause picks this up OK.
		$newTermPos = strpos($filterContent, "$");
		$currentElement = substr($filterContent, 0, $newTermPos);
		if($currentElement == $i) {
			$filterArray[$i] = substr($filterContent, strpos($filterContent, "$") + 1, $termPos - strpos($filterContent, "$") - 1);
			// echo "<br/> Are we getting here. $filterArray[$i].";
			$filterContent = substr($filterContent, strpos($filterContent, "#") + 1);
		}
		else {
			$filterArray[$i] = "";
		}
	}
	
	return $filterArray;
}

// This Generic Function is called for all SELECT Queries.
// This function gets select query results and parses to bespoke format for javascript.
function buildDataTableObjectNotation($query)
{
	$html = "";
	$columnNames = "";
	$columnNamesArray;
	$rowData = "";
	$rowIncrementer = 0;
	$rowIncrementerColumns = 0;
	// $query = urldecode($_GET['query']);
	// $query = str_replace("\'", "'", $query);
	
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			// Get Table Column Names from last record retrieved.
			$columnNames = ""; // Ensure resultsString is empty
			$columnNamesArray = NULL; // Ensure columnNamesArray is empty
			$rowIncrementerColumns = 0;
			foreach($row as $key => $value)
			{
				$columnNames .= "$key,";
				$columnNamesArray[] = $key;
				$rowIncrementerColumns++;
			}
			
			// Get rowData for current record and append to rowData.
			$rowData .= "#$rowIncrementer=,";
			for($i = 0; $i < sizeof($columnNamesArray); $i++)
			{
				$elementName = $columnNamesArray[$i];
				$rowData .= $row[$elementName] . ",";
			}
			
			$rowIncrementer++;
		}
	}
	// $rowIncrementerColumns = number of columns.
	// $rowIncrementer = number of rows.
	$data = $rowIncrementerColumns . "," . $columnNames . $rowIncrementer .  "," . $rowData;
	return "$data";
}

// This function is called by most requests to ensure that the current user is authorised
// and permitted to call it.
function checkAuthorisation()
{
	if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == true)
	{
		return true;
	}
	else
	{
		return false;
	}
}

// This function returns the length of a number e.g: 1000 = length of 4.
// Reliable up to a length of 16.
function getNumberLength($num)
{
	return strlen($num);
}

// This function returns the number of zeros required as a string, e.g: 5 zeros = '00000'.
function getZerosString($noOfZeros)
{
	$zeroString = "";
	for($i=0; $i < $noOfZeros; $i++)
	{
		$zeroString .= "0";
	}
	return $zeroString;
}

?>