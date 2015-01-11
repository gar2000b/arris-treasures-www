<?php
	// Start session
	session_start();
	require_once('./header.php');
	require_once('./ad_banner.php');
	
	// Check if authorisation variables are set.
	if(isset($_SESSION['authorisation']) && isset($_SESSION['username']) && 
		isset($_SESSION['user_level'])){
		// If the auth is set to ok then proceed.
		if($_SESSION['authorisation'] == true && $_SESSION['user_level'] == '1')
		{
			header("Location:admin.php");
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Arris Treasures</title>
<link href="template_files/style.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" /></script>
<script src="javascript/index.js"></script>
<script type="text/javascript"><?php require_once('./php_scripts/ad_banner.php'); ?></script>
<script src="javascript/common.js"></script>
<script src="javascript/xmlhttpobject.js"></script>
<script></script>
</head>
<body>

<div id="main_container">
<div class="top_illustration"><img id="dog_image" src="template_files/doggy.png" alt="" title="" height="156" width="156"></div>
		<?php
			renderHeader();
		?>
    
		<?php
			renderMenu();
		?>
            
            
<div id="main_content">
    
		<?php
            renderAdBanner();
        ?>
        
        
        <div id="left_content_template">  
        
        <h1>Admin Login</h1>
        <p class="clear">
        	<img src="template_files/icon3.png" alt="" title="" class="left_img" height="48" width="48">
        	<div class="content">
	<div align="center">
    	<table width="200" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td><input type="text" id="username" name="username" style="width:150px;" /></td>
            <td>&nbsp;username</td>
          </tr>
          <tr><td><br /></td><td><br /></td></tr>
          <tr>
            <td><input type="password" id="password" name="password" style="width:150px;" /></td>
            <td>&nbsp;password</td>
          </tr>
          </tr>
          <tr><td><br /></td><td><br /></td></tr>
          <tr>
          <tr>
            <td>&nbsp;</td>
            <td><input type="button" value="Login" onClick="adminLogin();" /></td>
          </tr>
        </table>
  </div>
  	<div id="feedback"></div>
</div>
		</p>        
        </div>
    
        <div id="footer">
        <br/>
    	Online Interact ©
    </div>
    
    </div>
    </div>
</body></html>