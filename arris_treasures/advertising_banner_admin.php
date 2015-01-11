<?php
	session_start();
	require_once('./header.php');
	require_once('./ad_banner.php');
	require_once('./php_scripts/common.php');
	require_once('./php_scripts/advertising_banner_admin.php');
	
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
<script src="javascript/advertising_banner_admin.js"></script>
<script src="javascript/xmlhttpobject.js"></script>
<script type="text/javascript">
	function startUpload(){
		// alert('Is start upload called?');
		  document.getElementById('f1_upload_process').style.visibility = 'visible';
		  // document.getElementById('f1_upload_form').style.visibility = 'hidden';
		  return true;
	}
	
function stopUpload(success, info){
	
		// alert('*** stopUpload called, success = ' + success + ' and info is = ' + info);
		var result = '';
		if (success == 1){
			result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
			// alert(info);
		}
		else {
			result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
			// alert(info);
		}
		document.getElementById('f1_upload_process').style.visibility = 'hidden';
		// document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
		// document.getElementById('f1_upload_form').style.visibility = 'visible';
		
		// TODO: *** we are here ***
		ajaxGetAdvertisingBannerItems();
		// TODO - code to update ad banner...
		// document.getElementById('iframe').src = document.getElementById('iframe').src;
		document.getElementById('submitBtn').value = 'Insert';
		document.getElementById('position').value = '';
		document.getElementById('hyperlink').value = '';
		document.getElementById('itemUpdateId').value = '';
		document.getElementById('oldPosition').value = '';
		document.getElementById('myfile').value = '';
		window.location.reload();
      return true;
}
</script>
</head>
<body onload="ajaxGetAdvertisingBannerItems();">

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
        <h1>Revolving Advertising Banner Admin ^</h1>        
    </div>
    
        <div id="footer">

<form action="./php_scripts/upload_advertising_banner.php" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
            <div align="center">
              <p id="f1_upload_process" style="color:#3399FF; position:relative; visibility:hidden" align="center">Inserting...<br/>
              <img src="ajaxphpupload/loader.gif" /></p>
        </div>
    <table width="700" border="0" align="center">
      <tr>
                <td><span style="color:#000000; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Position</span></td>
                <td><span style="color:#000000; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Hyperlink</span></td>
                <td><span style="color:#000000; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Image</span></td>
                <td><span style="color:#000000; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">Insert / Update</span></td>
              </tr>
              <tr>
                <td><input type="text" id="position" name="position" /></td>
                <td><input type="text" id="hyperlink" name="hyperlink" /></td>
                <td><input type="file" id="myfile" name="myfile" style="color:#003399" /></td>
                <td align="center"><input type="submit" name="submitBtn" id="submitBtn" value="Insert" /></td>
          </tr>
            </table>
            <br />
            <br />
            <br />
            <br />
    <input type="hidden" id="itemUpdateId" name="itemUpdateId" value="" />
            <input type="hidden" id="oldPosition" name="oldPosition" value="" />
        </form>
		
		<div id="advertising_banner_wrapper">
            <table width="633" border="0" align="center" id="banner_table">
              <tr>
                <td><div align="center"><span style="color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Position</span></div></td>
                <td><div align="center"><span style="color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Hyperlink</span></div></td>
                <td><div align="center"><span style="color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Image</span></div></td>
                <td><div align="center"><span style="color:#000000; font-size:12px; font-family:Arial, Helvetica, FreeSans, 'Luxi-sans', 'Nimbus Sans L', sans-serif; padding:6px;">Edit</span></div></td>
              </tr>
              <tr id="tr1">
                <td><div align="center"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">1</span></div></td>
                <td><div align="center"><a href="https://www.paypal.com/uk/cgi-bin/webscr?cmd=_ship-now&paypal_trans_id=2J563853EN7426319&seller_id=L%2FoCtedakbT4QZVfIgNbgaEXmiFTizWsE1tn0CI8xO%2BA1HQlbL%2F%2FrFu1Zd0DP%2BvUz3l%2F4Olw341O%2BeXjMARCrw%3D%3D&item_id=150696245009&trans_id=682542552005&locale=en_GB" target="_blank">View URL / Hyperlink</a></div></td>
                <td><div align="center"><span style="color:#0066FF; font-size:12px; font-family:Arial,Helvetica,FreeSans,'Luxi-sans','Nimbus Sans L',sans-serif; padding:6px;">cupid.png</span></div></td>
                <td><div align="center"><input type="button" name="edit" id="edit" value="Edit" onclick="bannerAdminPage.ajaxGetAdvertisingBannerItems();" /></div></td>
              </tr>
            </table>
            </div>
        <br/>
        <span style="color:black; text-align:center;"><u>Revolution Delay (secs):</u></span>
        <br />
        <br />
        <input id="timeout" name = "timeout" value="<?php getAdvertisingBannerTimeoutInSecs(); ?>" size="1" style="text-align:center;" /><input type="button" onclick="ajaxUpdateAdvertisingBannerTimeout();" name="saveRevDelay" id="saveRevDelay" value="Save" />
        <br /><br />
    	Online Interact &#169;
    </div>
    
    </div>
    <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
    </div>
</body></html>