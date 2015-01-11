<?php
	// Start session
	session_start();
	require_once('./header.php');
	require_once('./ad_banner.php');
	require_once('./php_scripts/common.php');
	
	// Check admin authorisation.
	checkAdminAuthorisation();
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
        <h1>Admin (<a href="#" onclick="adminLogout();">logout</a>)</h1>        
        
        <table width="200" border="0" align="center" cellpadding="2" cellspacing="0">
          <tr>
            <td><div align="center">
              <input type="button" value="Interactive Banner" onclick="window.location = 'interactive_banner_admin.php';" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Revolving Ad Banner" onclick="window.location = 'advertising_banner_admin.php';" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
          </tr>
          <tr>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
          </tr>
          <tr>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
            <td><div align="center">
              <input type="button" value="Some Other Admin" />
            </div></td>
          </tr>
        </table>
        <p class="clear">&nbsp;</p>
    </div>
    
        <div id="footer"><br/>
    	Online Interact ©
    </div>
    
  </div>
    </div>
</body></html>