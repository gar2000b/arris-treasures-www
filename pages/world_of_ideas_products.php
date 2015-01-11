<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arris Treasures</title>
<LINK href="../css/main.css" rel="stylesheet" type="text/css">
<link href="../ajaxphpupload/style/style.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../javascripts/common.js"></script>
<script type="text/javascript" src="../javascripts/index.js"></script>
<script type="text/javascript" src="../javascripts/xmlhttpobject.js"></script>
<script type="text/javascript"></script></head>

<body class="body_main" onload="init();">
<div class="header" onmouseover="// alert('header');">
    <div class="logo" onmouseover="// alert('logo');">
    	<div class="logo_content">
        	<img src="../images/logo.png" style="border:0px; padding:0px;" /></div>
  </div>
    <div class="banner" onmouseover="// alert('banner');">
    	<div class="banner_content">
        Arris Treasures Flash Banner Goes Here...
        </div>
    </div>
</div>
<div class="menu_wrapper" onmouseover="// alert('menu wrapper');">
    <div class="menu" onmouseover="// alert('menu');">
      <table width="300" border="0" cellpadding="0" cellspacing="0">
        <tr align="center">
          <td onmouseover="hover_menu_enter_update('1');" onmouseout="hover_menu_exit_update('1');"><a href="javascript:ajaxPageRequest('link1.html');" style="text-decoration:none; color:#FFFFFF;">Home</a></td>
            <td onmouseover="hover_menu_enter_update('2');" onmouseout="hover_menu_exit_update('2');">Products</td>
            <td onmouseover="hover_menu_enter_update('3');" onmouseout="hover_menu_exit_update('3');">About</td>
            <td onmouseover="hover_menu_enter_update('4');" onmouseout="hover_menu_exit_update('4');"><a href="javascript:checkAdminLogin();" style="text-decoration:none; color:#FFFFFF;">Admin</a></td>
          </tr>
      </table>
        <div class="menu_item" id="menu_itm" style="left:100px;" onmouseover="enter_menu();" onmouseout="exit_menu();">
        	<ul class="menu_list">
            	<li><a href="../gotoPage(1);" class="menu_list_item">link 1</a></li>
                <li><a href="../gotoPage(2);" class="menu_list_item">link 2</a></li>
                <li><a href="../gotoPage(3);" class="menu_list_item">link 3</a></li>
                <li><a href="../gotoPage(4);" class="menu_list_item">link 4</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="content_wrapper" onmouseover="// alert('content');">
  <div class="page_area" id="page_area">
	<!-- ***contentStart*** -->
  	<div style="float:left; width:780px; background-color:#000000; border:0px; margin:1px; border-right:0px; margin-right:0px;">
      <h1 class="header" style="text-decoration:underline;">World of Ideas (Products) Page.<br/>
</h1>
<p align="center" style="color:#F8D583; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">
                Welcome to Arris Treasures <span style="color:#FFFFFF">(home to Scotlands most prestigious Pewter Treasures).</span> Insert Ideas Here:</p>
<form action="../php_scripts/upload.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
<table width="200" border="0" align="center">
  <tr>
    <td><span style="color:#00FF99; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Position</span></td>
    <td><span style="color:#00FF99; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Title</span></td>
	<td width="100" align="center"><span style="color:#00FF99; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Insert / Update</span></td>
  </tr>
  <tr>
    <td><input type="text" id="position" name="position" /></td>
    <td><input type="text" id="title" name="title" /></td>
    <td width="100" align="center"><input type="button" id="submitBtn" name="submitBtn" value="Insert" onclick="worldOfIdeasPage.ajaxInsertItem(document.getElementById('position').value, document.getElementById('title').value, escapeVal(document.getElementById('description')), 1);" /><!--<input type="button" value="Test" onclick="$('#remove-dialog').dialog('open'); //alert(escapeVal(document.getElementById('description')));" />--></td>
  </tr>
  <tr>
  	<td colspan="3"><span style="color:#00FF99; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Description</span></td>
  </tr>
  <tr>
  	<td colspan="3"><textarea name="description" id="description" style="height:50px; width:500px;"></textarea></td>
  </tr>
</table>
<input type="hidden" id="itemUpdateId" name="itemUpdateId" value="" />
<input type="hidden" id="oldPosition" name="oldPosition" value="" />
<input type="hidden" id="removeId" name="removeId" value="" />
<input type="hidden" id="typeId" name="typeId" value="" />
</form>
<br />
<br />
	  <div id="world_of_ideas_wrapper">
<!--        <table width="633" border="0" align="center" id="banner_table">
          <tr>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Position</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Title</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Edit</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Remove</span></td>
          </tr>
          <tr id="tr1">
            <td><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;">1</span></td>
            <td><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;">Laser Etched Keyrings</span></td>
            <td><input type="button" name="edit" id="edit" value="Edit" onclick="bannerAdminPage.ajaxGetBannerItems();" /></td>
            <td><input type="button" name="remove" id="remove" value="Remove" onclick="bannerAdminPage.ajaxGetBannerItems();" /></td>
          </tr>
          <tr>
           	<td colspan="4"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Description</span></td>
          </tr>
          <tr>
          	<td colspan="4"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;">This is the description field for the Laser Etched Keyrings. The idea is to use the Laser Printer to etch peoples photographs straight onto tree branch slices. We then dip in into a finishing solution and voila,<hr style="color:#009966" /></span></td>
          </tr>
          <tr>
          	<td colspan="4">&nbsp;</td>
          </tr>
          <tr>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Position</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Title</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Edit</span></td>
            <td><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Remove</span></td>
          </tr>
          <tr id="tr1">
            <td><span style="color:#0066FF; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif;">2</span></td>
            <td><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;">Laser Etched Keyrings</span></td>
            <td><input type="button" name="edit" id="edit" value="Edit" onclick="bannerAdminPage.ajaxGetBannerItems();" /></td>
            <td><input type="button" name="remove" id="remove" value="Remove" onclick="bannerAdminPage.ajaxGetBannerItems();" /></td>
          </tr>
          <tr>
           	<td colspan="4"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; text-decoration:underline;">Description</span></td>
          </tr>
          <tr>
          	<td colspan="4"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif;">This is the description field for the Laser Etched Keyrings. The idea is to use the Laser Printer to etch peoples photographs straight onto tree branch slices. We then dip in into a finishing solution and voila,<hr style="color:#009966" /></span></td>
          </tr>
        </table>-->
      </div>
      <p style="color:#00FF99; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">&nbsp;</p>
  	</div>
    <div style="clear:both"/>
	<!-- ***contentEnd*** -->
  </div>
</div>
</body>
</html>