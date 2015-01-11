<?php # connect_db.php

// session_start();

// This file contains the database access information.
// This file also establishes a connection to MySQL and selects the database.
// This file also defines the escape_data() function.

// Set the database access information as constants.

DEFINE('DB_USER', 'alba');
DEFINE('DB_PASSWORD', 'alba1alba1');
DEFINE('DB_HOST', 'remote-mysql4.servage.net');
DEFINE('DB_NAME', 'alba');

// Make the connection.
$dbc = @mysql_connect(DB_HOST, DB_USER, DB_PASSWORD) OR die('Could not connect to mySQL: ' .
 mysql_error());
 
// Select the database.
@mysql_select_db(DB_NAME) OR die('Could not select the database: ' . mysql_error());


// Create a function for escaping the data.
function escape_data($data)
{
	// Address Magic Quotes.
	if(ini_get('magic_quotes_gpc'))
	{
		$data = stripslashes($data);
	}
	
	// Check for mysql_real_escape_string() support.
	if(function_exists('mysql_real_escape_string'))
	{
		global $dbc; // Need the connection.
		$data = mysql_real_escape_string(trim($data), $dbc);
	}
	else
	{
		$data = mysql_escape_string(trim($data));
	}
	
	// Return the escaped value.
	return $data;
} // End of function.

// Standard validation, escaping problomatic characters.
function validate($string)
{
	$string = escape_data($string);
	return $string;
}

// Create function to validate the data.
// Ensure that the field is not left empty
function validate_empty($string, $field)
{
	global $error_message;
	
	if(!empty($string))
	{
		$string = escape_data($string);
		return $string;
	}
	else
	{
		$string = NULL;
		$error_message .= $field . ' is empty\n';
		return $string;
	}
}

// This global function is used to format a given date in the format dd/mm/yy to the format supported by mySQL
// which is yy-mm-dd (or varying char lengths e.g. yyyy-mm-dd or yyyy-m-d).
// The function will then return the newly formated date before insertion or updating the DB.
// Please note: Any dates which are queried from the database using SELECT can use mySQLs own function DATE_FORMAT()
// e.g. SELECT DATE_FORMAT(order_date, '%d-%m-%y') AS date FROM orders; which puts the date into our format of dd-mm-yy.
function format_date($date_in)
{
	$date_passed = $date_in;
	// Find first occurance of '/'.
	$found_at = strpos($date_passed, '/', 0);
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$found_at');</script>";
	// Return day from 0 to '/'.
	$day = substr($date_passed, 0, ($found_at));
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Day is $day');</script>";
	// Return month from first occurance of but not including '/'.
	$found_at2 = strpos($date_passed, '/', ($found_at + 1));
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('date passed - $date_passed. found at + 1 - $found_at. found at2 - $found_at2');</script>";
	$month = substr($date_passed, ($found_at + 1), ($found_at2 - $found_at - 1));
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Month is $month');</script>";
	// Return year from second occurance of but not including '/'.
	$year = substr($date_passed, ($found_at2 + 1), (strlen($date_passed) - 1));
	echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('Year is $year');</script>";
	// Now that we have our day, month and year split out, we shall concatenate than all together in order to give
	// us the format we require for mySQL.
	$date_out = $year . '-' . $month . '-' . $day;
	echo "$date_out";
}

function format_date_return($date_in)
{
	if(strlen($date_in) > 0)
	{
		$date_passed = $date_in;
		// Find first occurance of '/'.
		$found_at = strpos($date_passed, '/', 0);
		// Return day from 0 to '/'.
		$day = substr($date_passed, 0, ($found_at));
		// Return month from first occurance of but not including '/'.
		$found_at2 = strpos($date_passed, '/', ($found_at + 1));
		$month = substr($date_passed, ($found_at + 1), ($found_at2 - $found_at - 1));
		// Return year from second occurance of but not including '/'.
		$year = substr($date_passed, ($found_at2 + 1), (strlen($date_passed) - 1));
		// Now that we have our day, month and year split out, we shall concatenate than all together in order to give
		// us the format we require for mySQL.
		// Add 0 to day and month if string length = 1.
		if(strlen($day) < 2){$day = "0" . $day;}
		if(strlen($month) < 2){$month = "0" . $month;}
		$date_out = $year . '-' . $month . '-' . $day;
		return $date_out;
	}
	else
	{
		return "";
	}
}

// This function is used to put numbers to two decimal places.  It does this by casting them to strings, working out how many
// decimal places exist after the point and then concatenates 0s onto the end
function add_decimals($number_in)
{
	$number_in = (string) $number_in;
	// Find decimal place if any.
	$found_at = strpos($number_in, '.', 0);
	if($found_at > 0)
	{
		// If found, find out decimal qty from end.
		$decimal_qty = strlen($number_in) - ($found_at + 1);
		// If 1 places after decimal, then add one extra zero.
		if($decimal_qty == 1)
		{
			$number_in .= "0";
		}
		// If 2 places after decimal, then do nothing.
		// If more than 2 places, then crop string down to 2 decimal places.
		if($decimal_qty > 2)
		{
			$number_in = substr($number_in,0,strlen($number_in) - ($decimal_qty - 2));
		}
	}
	else
	{
		// Add two zeros.
		$number_in .= ".00";
	}
	// If an empty string is passed in the set value to 0.00.
	if(strlen($number_in) == 0)
	{
		$number_in = "0.00";
	}
	if($number_in == 0)
	{
		$number_in = "0.00";
	}
	// Return number.
	return $number_in;
}

// This function is used to put numbers to four decimal places.  It does this by casting them to strings, working out how many
// decimal places exist after the point and then concatenates 0s onto the end
function add_decimals_four($number_in)
{
	$number_in = (string) $number_in;
	// Find decimal place if any.
	$found_at = strpos($number_in, '.', 0);
	if($found_at > 0)
	{
		// If found, find out decimal qty from end.
		$decimal_qty = strlen($number_in) - ($found_at + 1);
		// If 1 places after decimal, then add one extra zero.
		if($decimal_qty == 1)
		{
			$number_in .= "0";
		}
		// If 4 places after decimal, then do nothing.
		// If more than 4 places, then crop string down to 4 decimal places.
		if($decimal_qty > 4)
		{
			$number_in = substr($number_in,0,strlen($number_in) - ($decimal_qty - 4));
		}
	}
	else
	{
		// Add two zeros.
		$number_in .= ".0000";
	}
	// If an empty string is passed in the set value to 0.00.
	if(strlen($number_in) == 0)
	{
		$number_in = "0.0000";
	}
	if($number_in == 0)
	{
		$number_in = "0.0000";
	}
	// Return number.
	return $number_in;
}

function round_up($value, $dp)
{
	// Before doing any rounds, we have to ensure that the value coming in is not set to 2 decimal places or 1 decimal place.  
	// If it is then ignore and return the same value been sent in.
	$value = (string) $value;
	// Find decimal place if any.
	$found_at = strpos($value, '.', 0);
	
	if($found_at > 0)
	{
		// If found, find out decimal qty from end.
		$decimal_qty = strlen($value) - ($found_at + 1);
	}
	else
	{
		$decimal_qty = 0;
	}
	
	// If the decimals are not equal to one or two decimal places then do the round up function or else, just return the value.
	if(($decimal_qty != 2) && ($decimal_qty != 1) && ($decimal_qty != 0))
	{
    	// Offset to add to $value to cause round() to round up to nearest significant digit for '$dp' decimal places
    	$offset = pow (10, -($dp + 1)) * 5;
    	return round ($value + $offset, $dp);
	}
	else
	{
		return $value;
	}
}

// This function is used to insert characters or strings within other strings.  It takes three arguments, the main string
// to be inserted into, the value string with the characters to be inserted & the position where the characters have to be
// inserted into the main string.

function insert_string($string, $value, $position)
{
	// First thing to do is to split the string into 2 parts and then insert the chars into the middle before concatenating them
	// together again.
	// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$string');<//script>";
	$first_part = substr($string,0,$position);
	//echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$first_part');<//script>";
	$second_part = substr($string,$position,(strlen($string) - 1));
	// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$second_part');<//script>";
	// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$value');<//script>";
	// Now we have our two parts, we join them all together.
	$new_string = $first_part . $value . $second_part;
	// echo "<script language=\"JavaScript\" type=\"text/JavaScript\">alert('$new_string');<//script>";
	return $new_string;
}

// The following 4 functions is invoked from evey script as it is called from within the template markup.
// because each script has the template copied across from dreamweaver, we have to include
// the function in a common script that is invoked thoughout the system.
function get_username()
{
	if(isset($_SESSION['first_name']) && isset($_SESSION['last_name']))
	{
		echo "$_SESSION[first_name] $_SESSION[last_name]";
	}
}

function get_level()
{
	if(isset($_SESSION['user_level']))
	{
		$query = "SELECT * FROM user_level WHERE user_level = '$_SESSION[user_level]'";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$user_level = $row['description'];
			echo "$user_level";
		}
	}
}

function get_location()
{
	if(isset($_SESSION['branch_id']))
	{
		// Get the branch location from the branch_id.
		$query = "SELECT branch_name FROM branch WHERE Id = '$_SESSION[branch_id]'";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$branch_name = $row['branch_name'];
			echo "$branch_name";
		}
	}
}

function get_last_login()
{
	if(isset($_SESSION['employee_number']))
	{
		// Get login details from employee number
		// This function is used to select and return dates/times in a predefined way.
		// Option Switches: %m - month, %d - day, %y - year, %H - hour, %i - minutes, %s - seconds.
		// For more info on these switches and more switches themselves, please refer to page 201
		// in sams teach yourself mySQL in 24 hours.
		
		$query = "SELECT DATE_FORMAT(date_time, '%d-%m-%y %h:%i%p') AS date, date_time FROM logs ORDER BY date_time DESC LIMIT 1";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			$date = $row['date'];
			echo "$date";
		}
	}
}

?>