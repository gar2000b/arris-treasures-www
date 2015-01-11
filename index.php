<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Web Application Template</title>
<LINK href="css/main.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="javascripts/common.js"></script>
<script type="text/javascript" src="javascripts/index.js"></script>
<script type="text/javascript" src="javascripts/xmlhttpobject.js"></script>
<script type="text/javascript"><?php $in = $_POST['attachment']; //echo"alert('$in');"; ?></script>
</head>

<body class="body_main" onload="init();">
<form method="post" action="index.php" name="f">
<div class="header" onmouseover="// alert('header');">
    <div class="logo" onmouseover="// alert('logo');">
    	<div class="logo_content">
        	<img src="images/logo.png" style="border:0px; padding:0px;" /></div>
  </div>
    <div class="banner" onmouseover="// alert('banner');">
    	<div class="banner_content">
        Online Interact Flash Banner Goes Here...
        </div>
    </div>
</div>
<div class="menu_wrapper" onmouseover="// alert('menu wrapper');">
    <div class="menu" onmouseover="// alert('menu');">
      <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr align="center">
          <td onmouseover="hover_menu_enter_update('1');" onmouseout="hover_menu_exit_update('1');">menu 1</td>
            <td onmouseover="hover_menu_enter_update('2');" onmouseout="hover_menu_exit_update('2');">menu 2</td>
            <td onmouseover="hover_menu_enter_update('3');" onmouseout="hover_menu_exit_update('3');">menu 3</td>
            <td onmouseover="hover_menu_enter_update('4');" onmouseout="hover_menu_exit_update('4');">menu 4</td>
          </tr>
      </table>
        <div class="menu_item" id="menu_itm" style="left:100px;" onmouseover="enter_menu();" onmouseout="exit_menu();">
        	<ul class="menu_list">
            	<li><a href="gotoPage(1);" class="menu_list_item">link 1</a></li>
                <li><a href="gotoPage(2);" class="menu_list_item">link 2</a></li>
                <li><a href="gotoPage(3);" class="menu_list_item">link 3</a></li>
                <li><a href="gotoPage(4);" class="menu_list_item">link 4</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="content_wrapper" onmouseover="// alert('content');">
		<div class="page_area" id="page_area"><!-- <div class="title_padding">content area 1 - version 1.0.3</div> -->
            <div class="title_padding">
              <p>The Terminator - version 1.0.3</p>
              <p><input type="button" value="Get Soap Message" onclick="messagePage.ajaxGetSoapMessage();" /></p>
              <p><input type="file" name="attachment" id="attachment" value="File Path Info here..." /></p>
              <p><input type="file" name="attachment2" id="attachment2" value="File Path Info here..." /></p>
              <p><input type="text" name="textInput"/></p>
              <p><input type="button" value="Update" onclick="document.getElementById('attachment').innerHTML = 'abc'; alert('Done');" /></p>
          </div>
            <img class="image_main" src="images/head.png" />
            <div style="clear:both"/>
        </div>
        <!-- content - version1.0.2 -->
      	<!-- <div id="info" class="info" align="right">info</div> -->
</div>
</form>
<?php
	phpinfo();
?>
</body>
</html>