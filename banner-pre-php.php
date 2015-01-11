<?php

// connect to the database.
require_once('./php_scripts/connect_alba_db.php');
require_once('./php_scripts/common.php');
session_start(); // start up your PHP session!

?>

<html>
<head>
<title>Banner</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

var transparacy = 100;
var transparacyInverse = 100;
var timer;
var imagePos = 4;

var shiftLeftFlag = false;
var shiftLeftCount = 0;
var shiftRightFlag = false;
var shiftRightCount = 0;

var imageArray = [];
var imageLinkArray = [];

var preload = new Array();
preload[0] = new Image();
imageArray[0] = "belt_buckles.png?id=1";
preload[0].src = "http://www.arristreasures.com/images/banner/" + imageArray[0];
imageLinkArray[0] = "http://www.google.com";
preload[1] = new Image();
imageArray[1] = "kilt_pins.png?id=1";
preload[1].src = "http://www.arristreasures.com/images/banner/" + imageArray[1];
imageLinkArray[1] = "http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Pins-Swarovski-/_i.html?_fsub=3266219012";
preload[2] = new Image();
imageArray[2] = "photos.png?id=1";
preload[2].src = "http://www.arristreasures.com/images/banner/" + imageArray[2];
imageLinkArray[2] = "http://stores.ebay.co.uk/Alba-Accessories/Charms-Pendants-/_i.html?_fsub=2739821012";
preload[3] = new Image();
imageArray[3] = "chess_sets.png?id=1";
preload[3].src = "http://www.arristreasures.com/images/banner/" + imageArray[3];
imageLinkArray[3] = "http://stores.ebay.co.uk/Alba-Accessories/Generic-Scottish-Kilt-Pins-/_i.html?_fsub=2736651012";
preload[4] = new Image();
imageArray[4] = "heart_charms.png?id=1";
preload[4].src = "http://www.arristreasures.com/images/banner/" + imageArray[4];
imageLinkArray[4] = "http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Belt-Buckles-/_i.html?_fsub=3287687012";
preload[5] = new Image();
imageArray[5] = "obama-baby.png?id=1";
preload[5].src = "http://www.arristreasures.com/images/banner/" + imageArray[5];
imageLinkArray[5] = "http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Belt-Buckles-/_i.html?_fsub=3287687012";
preload[6] = new Image();
imageArray[6] = "photo_keyring.png?id=1";
preload[6].src = "http://www.arristreasures.com/images/banner/" + imageArray[6];
imageLinkArray[6] = "http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Belt-Buckles-/_i.html?_fsub=3287687012";
preload[7] = new Image();
imageArray[7] = "zeus_ring.png?id=1";
preload[7].src = "http://www.arristreasures.com/images/banner/" + imageArray[7];
imageLinkArray[7] = "http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Belt-Buckles-/_i.html?_fsub=3287687012";

function hoverOverLeft() {
	document.getElementById('left').src = 'images/banner/left-hover.png';
}

function hoverOutLeft() {
	document.getElementById('left').src = "images/banner/left.png";
}

function hoverOverRight() {
	document.getElementById('right').src = 'images/banner/right-hover.png';
}

function hoverOutRight() {
	document.getElementById('right').src = "images/banner/right.png";
}

function shiftBannerLeft() {
	if(shiftLeftFlag != true){
		shiftImageLeft();
		timer = setInterval(function(){updateTransparacyShiftLeft()},0);
	}
	else{
		shiftLeftCount = shiftLeftCount++;
	}
}

function shiftImageLeft(){
	var temp = imageArray[0];
	for(var i = 0; i < imageArray.length; i++){
		if(i == (imageArray.length - 1)){
			imageArray[i] = temp;
		}
		else{
			imageArray[i] = imageArray[i+1];
		}
	}
	
	var preloadTemp = preload[0];
	for(var i = 0; i < preload.length; i++){
		if(i == (preload.length - 1)){
			preload[i] = preloadTemp;
		}
		else{
			preload[i] = preload[i+1];
		}
	}
	
	var linkTemp = imageLinkArray[0];
	for(var i = 0; i < imageLinkArray.length; i++){
		if(i == (imageLinkArray.length - 1)){
			imageLinkArray[i] = linkTemp;
		}
		else{
			imageLinkArray[i] = imageLinkArray[i+1];
		}
	}
	
}

function updateTransparacyShiftLeft() {

	shiftLeftFlag = true;
	// un-comment if you want to include transition & set all transparacy & transparacyInverse to whatever - 0, 20, 40, 60...
	// transparacy = transparacy - 20;
	
	if(imagePos != 0) {
		// Fade image out.
		document.getElementById('image_' + imagePos).style.filter = "alpha(opacity=" + transparacy + ")";
		document.getElementById('image_' + imagePos).style.opacity = transparacy / 100;
		if(transparacy == 100){
			// document.getElementById('image_' + imagePos).src = "http://www.arristreasures.com/images/banner/" + imageArray[imagePos - 1];
			preload[imagePos - 1].width = "137";
			preload[imagePos - 1].height = "152";
			preload[imagePos - 1].onmouseover = function() { hoverOverImage(this); };
			preload[imagePos - 1].onmouseout = function() { hoverOutImage(this); };
			preload[imagePos - 1].id = "image_" + imagePos;
			preload[imagePos - 1].name = "name_" + imagePos;
			document.getElementById("link_" + imagePos).removeChild(document.getElementById("link_" + imagePos).lastChild);
			document.getElementById("link_" + imagePos).appendChild(preload[imagePos - 1]);
			document.getElementById("link_" + imagePos).href = imageLinkArray[imagePos - 1];
			document.getElementById("image_" + imagePos).style.textDecoration = "none";
			document.getElementById("image_" + imagePos).style.border = "none";
		}
	}
	
	// Fade previous image back in.
	if(imagePos < 4) {
		transparacyInverse = transparacyInverse + 20;
		document.getElementById('image_' + (imagePos+1)).style.filter = "alpha(opacity=" + transparacyInverse + ")";
		// alert("do we get here 2");
		document.getElementById('image_' + (imagePos+1)).style.opacity = transparacyInverse / 100;
		// alert("do we get here 3");
	}
	
	if(transparacy == 100) {
		transparacy = 100;
		transparacyInverse = 100;
		clearInterval(timer);
		imagePos = imagePos - 1;
		if(imagePos != -1) {
			timer = setInterval(function(){updateTransparacyShiftLeft(document.getElementById('image_' + imagePos))},0);
		}
		else {
			imagePos = 4;
			shiftLeftFlag = false;
			if(shiftLeftCount > 0){
				shiftLeftCount = shiftLeftCount - 1;
				shiftBannerLeft();
			}
		}
	}
}

function shiftBannerRight() {
	if(shiftRightFlag != true){
		imagePos = 1;
		shiftImageRight();
		timer = setInterval(function(){updateTransparacyShiftRight()},0);
	}
	else{
		shiftRightCount = shiftRightCount++;
	}
}

function shiftImageRight(){
	var temp = imageArray[7];
	for(var i = 7; i >= 0; i--){
		if(i == 0){
			imageArray[i] = temp;
		}
		else{
			imageArray[i] = imageArray[i-1];
		}
	}
	
	var preloadTemp = preload[7];
	for(var i = 7; i >= 0; i--){
		if(i == 0){
			preload[i] = preloadTemp;
		}
		else{
			preload[i] = preload[i-1];
		}
	}
	
	var linkTemp = imageLinkArray[7];
	for(var i = 7; i >= 0; i--){
		if(i == 0){
			imageLinkArray[i] = linkTemp;
		}
		else{
			imageLinkArray[i] = imageLinkArray[i-1];
		}
	}
	
}

function updateTransparacyShiftRight() {

	shiftRightFlag = true;
	// un-comment if you want to include transition & set all transparacy & transparacyInverse to whatever - 0, 20, 40, 60...
	// transparacy = transparacy - 20
	
	if(imagePos != 5) {
	// alert("do we get here " + imagePos);
		// Fade image out.
		document.getElementById('image_' + imagePos).style.filter = "alpha(opacity=" + transparacy + ")";
		document.getElementById('image_' + imagePos).style.opacity = transparacy / 100;
		// alert("imagePos = " + imagePos + " transparacy = " + transparacy);
		if(transparacy == 100){
			// document.getElementById('image_' + imagePos).src = "http://www.arristreasures.com/images/banner/" + imageArray[imagePos - 1];
			preload[imagePos - 1].width = "137";
			preload[imagePos - 1].height = "152";
			preload[imagePos - 1].onmouseover = function() { hoverOverImage(this); };
			preload[imagePos - 1].onmouseout = function() { hoverOutImage(this); };
			preload[imagePos - 1].id = "image_" + imagePos;
			preload[imagePos - 1].name = "name_" + imagePos;
			document.getElementById("link_" + imagePos).removeChild(document.getElementById("link_" + imagePos).lastChild);
			document.getElementById("link_" + imagePos).appendChild(preload[imagePos - 1]);
			document.getElementById("link_" + imagePos).href = imageLinkArray[imagePos - 1];
			document.getElementById("image_" + imagePos).style.textDecoration = "none";
			document.getElementById("image_" + imagePos).style.border = "none";
		}
	}
	
	// Fade previous image back in.
	if(imagePos < 4) {
		transparacyInverse = transparacyInverse + 20;
		document.getElementById('image_' + (imagePos+1)).style.filter = "alpha(opacity=" + transparacyInverse + ")";
		document.getElementById('image_' + (imagePos+1)).style.opacity = transparacyInverse / 100;
	}
	
	if(transparacy == 100) {
		transparacy = 100;
		transparacyInverse = 100;
		clearInterval(timer);
		imagePos = imagePos + 1;
		if(imagePos != 5) {
			timer = setInterval(function(){updateTransparacyShiftRight(document.getElementById('image_' + imagePos))},0);
		}
		else {
			imagePos = 0;
			shiftRightFlag = false;
			imagePos = 4;
			if(shiftRightCount > 0){
				shiftRightCount = shiftRightCount - 1;
				shiftBannerRight();
			}
		}
	}
}

function hoverOverImage(image){
	// alert("Image Hover");
	image.style.filter = "alpha(opacity=85)";
	image.style.opacity = 85 / 100;
}

function hoverOutImage(image){
	// alert("Image Hover");
	image.style.filter = "alpha(opacity=100)";
	image.style.opacity = 100 / 100;
}

function insertNewImage() {
	// width="137" height="152"
	preload[5].width = "137";
	preload[5].height = "152";
	preload[5].id = "image_1";
	preload[5].id = "name_1";
	document.getElementById("link_1").removeChild(document.getElementById("link_1").lastChild);
	document.getElementById("link_2").removeChild(document.getElementById("link_2").lastChild);
	document.getElementById("link_3").removeChild(document.getElementById("link_3").lastChild);
	document.getElementById("link_4").removeChild(document.getElementById("link_4").lastChild);
	document.getElementById("link_1").appendChild(preload[5]);
	alert("Image Appended");
}

</script>
</head>

<body>
<p>
  <!--<a href="http://www.google.com" target="_blank">Google</a>
<a href="http://www.yahoo.com" target="_blank">Yahoo</a>
<a href="http://www.ebay.com" target="_blank">eBay</a>-->
  
  <img src="images/banner/left.png" name="left" width="90" height="150" id="left" onClick="shiftBannerRight();" onMouseOver="hoverOverLeft();" onMouseOut="hoverOutLeft();" />
  <a id="link_1" name="link_1" href="http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Belt-Buckles-/_i.html?_fsub=3287687012" target="_blank"><img id="image_1" name="image_1" src="images/banner/belt_buckles.png" width="137" height="152" style="text-decoration:none; border:none;" onMouseOver="hoverOverImage(this);" onMouseOut="hoverOutImage(this);" /></a>
  <a id="link_2" name="link_2" href="http://stores.ebay.co.uk/Alba-Accessories/NEW-Kilt-Pins-Swarovski-/_i.html?_fsub=3266219012" target="_blank"><img id="image_2" name="image_2" src="images/banner/kilt_pins.png" width="137" height="152" style="text-decoration:none; border:none;" onMouseOver="hoverOverImage(this);" onMouseOut="hoverOutImage(this);" /></a>
  <a id="link_3" name="link_3" href="http://stores.ebay.co.uk/Alba-Accessories/Charms-Pendants-/_i.html?_fsub=2739821012" target="_blank"><img id="image_3" name="image_3" src="images/banner/photos.png" width="137" height="152" style="text-decoration:none; border:none;" onMouseOver="hoverOverImage(this);" onMouseOut="hoverOutImage(this);" /></a>
  <a id="link_4" name="link_4" href="http://stores.ebay.co.uk/Alba-Accessories/Generic-Scottish-Kilt-Pins-/_i.html?_fsub=2736651012" target="_blank"><img id="image_4" name="image_4" src="images/banner/chess_sets.png" width="137" height="152" style="text-decoration:none; border:none;" onMouseOver="hoverOverImage(this);" onMouseOut="hoverOutImage(this);" /></a>
  <img src="images/banner/right.png" name="right" width="90" height="150" id="right" onClick="shiftBannerLeft();" onMouseOver="hoverOverRight();" onMouseOut="hoverOutRight();" />
  <!--<embed src="http://www.mintebay.com/flash-banners/show.swf?url=http://www.arristreasures.com&txt=Kilt%20Pin&card=http://www.mintebay.com/flash-banners//banner_images/3d/3.jpg&tc=16776960&sc=16711680&font=http://www.mintebay.com/flash-banners/fonts/plainn_lib.swf&tr=0&ts=100&tx=0&ty=0&glitter=1&rounded=0&bevel=0&sepia=0&theme=&theme_al=100" quality="high" bgcolor="#ffffff" width="468" height="60" name="show" align="middle" allowScriptAccess="always" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>-->
  <br />
  <br />
  <br />
  <br />
</p>
<p><input type="button" value="Insert New Image" onClick="insertNewImage();" /></p>
</body>
</html>
