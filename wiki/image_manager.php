<?php
	require_once('../php_scripts/connect_db.php');
	require_once('../php_scripts/common.php');
	require_once('../php_scripts/wiki.php');
	session_start(); // start up your PHP session!
	checkLogin();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Image Manager (Online Interact)</title>
<link type="text/css" href="../css/ui-darkness/jquery-ui-1.8.23.custom.css" rel="stylesheet" />
<style>
.ui-widget-overlay.custom-overlay
{
    background-color: black;
    background-image: none;
    opacity: 0.9;
    z-index: 1040;    
}
</style>
<script type="text/javascript" src="../javascripts/wiki.js"></script>
<script type="text/javascript" src="../javascripts/xmlhttpobject.js"></script>
<script type="text/javascript" src="../javascripts/jquery-ui-1-8-23/jquery-1.8.0.min.js"></script>
<script type="text/javascript" src="../javascripts/jquery-ui-1-8-23/jquery-ui-1.8.23.custom.min.js"></script>
<script type="text/javascript" src="../google-code-prettify/run_prettify.js"></script>
<style type="text/css">
<!--

table {
	font-size: 12px;
}
.style1 {color: #003366}
-->
.style2 {font-size: 12px}

a:link {color:#0033CC; text-decoration:none;}      /* unvisited link */
a:visited {color:#0033CC; text-decoration:none;}  /* visited link */
a:hover {color:#0033CC; text-decoration:underline;}  /* mouse over link */
a:active {color:#0033CC; text-decoration:none;}  /* selected link */ 

</style>
<link type="image/x-icon" href="/images/layout/favicon.ico" rel="icon">
</head>

<body style="font-family:Verdana, Arial, Helvetica, sans-serif" bgcolor="#003366" onload="initImageDialog();">
<form id="f" name="f" action="../php_scripts/wiki.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();">
    <div align="center">
      <div align="center" style="width:400px; background-color:#FFFFFF; padding-top:10px; padding-bottom:10px; border-style:solid; border-width:1px;" >
      <a href="wiki.php" class="style2">Home</a> | <a href="#" class="style2" onclick="logout();"><?php getLoginDetails(); ?></a> | <a href="#" class="style2" onclick="logout();">Logout</a><br  /><br  />
		<div id="graphic" style="display:none">
            <p align="center" id="f1_upload_process" style="color:#3399FF; position:relative;" name="f1_upload_process"><span class="style1">Uploading Image</span><br/>
            <img src="../ajaxphpupload/loader.gif" /></p>
        </div>
        <table width="348" border="0" align="center">
          <tr>
            <td width="218"><span style="color:#000000; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Image</span></td>
            <td width="120"><span style="color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Upload</span></td>
          </tr>
          <tr>
            <td><input type="file" id="myfile" name="myfile" style="color:#003399" /></td>
            <td><input type="submit" name="submitBtn" id="submitBtn" value="Upload" /></td>
          </tr>
        </table>
      </div>
      
      <br />
      
      <div align="center">
      	<div align="center" style="width:700px; background-color:#FFFFFF; padding-top:10px; padding-bottom:10px; border-style:solid; border-width:1px;" >
   		  <table width="660" border="0">
            <tr>
                <td><strong>Image Name</strong></td>
              <td><strong>Image Path</strong></td>
              <td><strong>View / Delete</strong></td>
            </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
				<?php getImageDetails(); ?>
            </table>
      	</div>
      </div>
      
      <div id="feedback"></div>
    </div>
    <input type="hidden" name="imageId" id="imageId" value="" />
    <input type="hidden" name="type" id="type" value="uploadImage" />
</form>
<iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"><input type="hidden" name="type" id="type" value="uploadImage" /></iframe>
<div id="view-image-dialog" title="Image">
  <img id="image" name="image" src="" />
</div>
<!--<input type="button" value="Test View Image" onclick="testViewImage('/images/wiki/3-gary_valeria.jpg');" />-->

</body>
</html>
