<?php
	require_once('../php_scripts/connect_db.php');
	require_once('../php_scripts/common.php');
	require_once('../php_scripts/wiki.php');
	session_start(); // start up your PHP session!
	if($_SESSION['authorisation'] == true) {
		header("Location: wiki.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Online Interact wiki</title>
<script type="text/javascript" src="../javascripts/wiki.js"></script>
<script type="text/javascript" src="../javascripts/xmlhttpobject.js"></script>
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
-->
</style>
<link type="image/x-icon" href="/images/layout/favicon.ico" rel="icon">
</head>

<body style="font-family:Verdana, Arial, Helvetica, sans-serif" bgcolor="#003366">
<form id="f" name="f" method="post" action="index.php">
    <div class="content" align="center">
      <div align="center" style="width:400px; background-color:#FFFFFF; padding-top:1px; padding-bottom:10px; border-style:solid; border-width:1px;" >
       	  <h2>Online Interact WIKI</h2>
            <table width="200" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td><input type="text" id="username" name="username" style="width:150px;" /></td>
                <td>&nbsp;username</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><input type="password" id="password" name="password" style="width:150px;" /></td>
                <td>&nbsp;password</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td><input type="button" value="Login" onClick="login();" /></td>
              </tr>
            </table>
      </div>
        <div id="feedback"></div>
    </div>
</form>

</body>
</html>
