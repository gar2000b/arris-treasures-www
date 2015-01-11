<?php
	session_start();
	require_once('./header.php');
	require_once('./ad_banner.php');
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
        <h1>Arris Treasures</h1>        
        
        <h1>Take a look at some of our amazing Gifts</h1>
        <p class="clear">
        <img src="template_files/icon1.png" alt="" title="" class="left_img" height="48" width="48">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
 eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
minim veniam, quis nostrud exercitation        </p>
        
        <p class="clear">
        <img src="template_files/icon2.png" alt="" title="" class="left_img" height="48" width="48">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
 eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
minim veniam, quis nostrud exercitation        </p>        
        
        
        <p class="clear">
        <img src="template_files/icon3.png" alt="" title="" class="left_img" height="48" width="48">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
 eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad 
minim veniam, quis nostrud exercitation        </p>        
        </div>
    
        <div id="footer">
        <br/>
      <iframe id="iframe" name="iframe" src="banner.php" width="765" height="160" scrolling="no" style="border:none;">
                <p>Your browser does not support iframes.</p>
      </iframe>
        <br/>
    	Online Interact ©
    </div>
    
    </div>
    </div>
</body></html>