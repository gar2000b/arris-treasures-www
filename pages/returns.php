<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Arris Treasures</title>
<LINK href="../css/main.css" rel="stylesheet" type="text/css">
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
  	<div style="float:left; width:780px; height:380px; background-color:#000000; border:0px; margin:1px; border-right:0px; margin-right:0px;">
      <h1 class="header">Returns Page.</h1>
            <p style="color:#F8D583; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">
                Welcome to Arris Treasures <span style="color:#FFFFFF">(home to Scotlands most prestigious Pewter Treasures).</span></p>
            <p style="color:#00FF99; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Return Description: 
              <label>
              <input type="text" name="textfield" id="textfield" style="width:240px;" />
              </label>
            Hyperlink to Postage Label: 
              <label>
              <input type="text" name="textfield2" id="textfield2" style="width:240px;" />
              </label>
      </p>
      <div align="center">
                <input type="submit" name="button" id="button" value="Insert Return" />
      </div>
            </p>
            <table width="752" border="0" align="center">
              <tr>
                <td><div align="center"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Return Description</span></div></td>
                <td><div align="center"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Hyperlink Postage Label</span></div></td>
                <td><div align="center"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Date / Time Inserted</span></div></td>
                <td><div align="center"><span style="color:#99FF33; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Mark as Done</span></div></td>
              </tr>
              <tr id="tr1" style="text-decoration:line-through">
                <td><div align="center"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Kilt Pin Antique Metal Clan Campbell</span></div></td>
                <td><div align="center"><a href="https://www.paypal.com/uk/cgi-bin/webscr?cmd=_ship-now&paypal_trans_id=2J563853EN7426319&seller_id=L%2FoCtedakbT4QZVfIgNbgaEXmiFTizWsE1tn0CI8xO%2BA1HQlbL%2F%2FrFu1Zd0DP%2BvUz3l%2F4Olw341O%2BeXjMARCrw%3D%3D&item_id=150696245009&trans_id=682542552005&locale=en_GB" target="_blank">View / Print Label</a></div></td>
                <td><div align="center"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">2011-01-06 00:00:00</span></div></td>
                <td><div align="center">
                  <label>
                  <input type="submit" name="button1" id="button1" value="Done" disabled="disabled" />
                  </label>
                </div></td>
              </tr>
            </table>
            <p style="color:#00FF99; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">&nbsp;</p>
  	</div>
    <div style="clear:both"/>
	<!-- ***contentEnd*** -->
  </div>
</div>
</body>
</html>