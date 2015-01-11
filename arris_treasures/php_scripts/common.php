<?php

	// Check admin authorisation.
	function checkAdminAuthorisation() {
		if(isset($_SESSION['authorisation']) && isset($_SESSION['username']) && 
			isset($_SESSION['user_level'])){
			// If the auth is set to ok then proceed.
			if($_SESSION['authorisation'] != true || $_SESSION['user_level'] != '1'){
				header("Location:admin_login.php");
			}
		} else {
			header("Location:admin_login.php");
		}
	}

?>