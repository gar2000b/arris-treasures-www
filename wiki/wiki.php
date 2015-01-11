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
<title>Online Interact wiki</title>
<script type="text/javascript" src="../javascripts/wiki.js"></script>
<script type="text/javascript" src="../google-code-prettify/run_prettify.js"></script>
<style type="text/css">
<!--
.style1 {
	font-size: 12px;
	font-weight: bold;
}
.style2 {font-size: 12px}

table {
	font-size: 12px;
}

a:link {color:#0033CC; text-decoration:none;}      /* unvisited link */
a:visited {color:#0033CC; text-decoration:none;}  /* visited link */
a:hover {color:#0033CC; text-decoration:underline;}  /* mouse over link */
a:active {color:#0033CC; text-decoration:none;}  /* selected link */ 


-->
</style>
<link type="image/x-icon" href="/images/layout/favicon.ico" rel="icon">
</head>

<body style="font-family:Verdana, Arial, Helvetica, sans-serif" bgcolor="#003366">
<form id="f" name="f" method="post" action="index.php">
	<div align="center">
	<div style="width:800px; background-color:#FFFFFF; border-style:solid; border-width:1px; padding-top:5px; padding-bottom:5px;">
	<a href="image_manager.php" class="style2">Image Manager</a> | <a href="#" class="style2" onclick="logout();"><?php getLoginDetails(); ?></a> | <a href="#" class="style2" onclick="logout();">Logout</a>
  <h2>Online Interact WYSIWYG wiki</h2>
        <p class="style2">Add Group: <input id="group" name="group" type="text" /> <input type="submit" value="Add Group" onclick="document.getElementById('type').value='addGroup';" /> Remove Group: <?php renderSelectGroup('removePageGroup'); ?> <input type="submit" value="Remove Group" onclick="document.getElementById('type').value='removeGroup';" /></p>
<p class="style2">
        	Add Page - Name:
       	  <input type="text" id="pageName" name="pageName" /> 
        	Description:
        	<input type="text" id="pageDescription" name="pageDescription" /> 
			Group: <?php renderSelectGroup('pageGroup'); ?>
          <input type="submit" value="Add Page" onclick="document.getElementById('type').value='addPage';" />
  </p>
<hr /> <br />
    <table width="817" border="0" cellpadding="2" cellspacing="5">
<tr>
            <td width="147"><span class="style1">Groups</span></td>
      <td width="233"><span class="style1">Pages</span></td>
      <td width="218"><span class="style1">Description</span></td>
      <td width="193"><span class="style1">View / Edit / Delete</span></td>
      </tr>
          <tr>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
            <td><span></span></td>
      </tr>
          <?php renderGroupsAndPages(); ?>
<!--          <tr>
            <td><strong>Applications</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Docbook in Linux</td>
            <td>Docbook in Linux</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>New Wiki</td>
            <td>New Wiki</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Dreamweaver</td>
            <td>Dreamweaver</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Calculator</td>
            <td>Calculator</td>
          </tr>
          <tr>
            <td><strong>Backend Systems</strong></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>Backend Systems Integration</td>
            <td>Backend Systems Integration</td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>PNC</td>
            <td>Police National Computer DB</td>
          </tr>-->
        </table>
        
  <input type="hidden" id="type" name="type" value="" />
  <input type="hidden" id="pageId" name="pageId" value="" />
  <!--<a href="#" target="_blank" onclick="">Link</a>-->
  </div>
  </div>
</form>

</body>
</html>
