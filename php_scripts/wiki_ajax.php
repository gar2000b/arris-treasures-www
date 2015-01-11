<?php

session_start();

// connect to the database.
require_once('./connect_db.php');
require_once('./common.php');

switch($_GET['type']) {
	case 'login':
	login();
	break;
}

// function to login and authenticate admin users and set session.
function login()
{
//	if(checkLoginAuthorisation() == true)
//	{
//		echo "success";
//	}
	if(isset($_GET['username']) && isset($_GET['password']))
	{
		$username = $_GET['username'];
		$password = $_GET['password'];
		
		$query = "SELECT * FROM users WHERE user_name = '$username' AND password = SHA('$password');";
		$result = @mysql_query($query); // Run the query.
		if($result)
		{
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			if($row)
			{
				$_SESSION['authorisation'] = true;
				$_SESSION['username'] = $row['user_name'];
				$_SESSION['forename'] = $row['first_name'];
				$_SESSION['surname'] = $row['last_name'];
				$_SESSION['user_level'] = $row['user_level'];
				
				echo "success";
			}
			else
			{
				echo "fail";
			}
		}
	}
	else
	{
		echo "fail";
	}
}

// This function is called by most requests to ensure that the current user is authorised
// and permitted to call it.
function checkLoginAuthorisation()
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

?>