<?php
	
	// connect to the database.
	require_once('./php_scripts/connect_alba_db.php');
	require_once('./php_scripts/common.php');
	session_start(); // start up your PHP session!

	// header("Cache-Control: max-age=3600");
	// header("Cache-Control:max-age=86400");

?>

<html>
<head>
<title>Banner</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta http-equiv="Cache-control" content="public">
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

<?php
	
	// Now get all banner info.
	$query = "SELECT * FROM website_ebay_banner WHERE active = 1 ORDER BY position ASC;";
	$result = @mysql_query($query); // Run the query.
	if($result)
	{
		while($row = mysql_fetch_array($result, MYSQL_ASSOC))
		{
			$position = $row['position'];
			$image_url = $row['image_url'];
			$hyperlink_url = $row['hyperlink_url'];
			$arrayIndex = $position - 1;
			
			echo "preload[$arrayIndex] = new Image();";
			echo "preload[$arrayIndex].src = \"$image_url\";";
			echo "preload[$arrayIndex].width = \"120\";";
			echo "preload[$arrayIndex].height = \"133\";";
			echo "imageArray[$arrayIndex] = \"$image_url\";";
			echo "imageLinkArray[$arrayIndex] = \"$hyperlink_url\";";
		}
	}
	
?>

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
		shiftLeftFlag = true;
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

	// un-comment if you want to include transition & set all transparacy & transparacyInverse to whatever - 0, 20, 40, 60...
	// transparacy = transparacy - 20;
	
	if(imagePos != 0) {
		// Fade image out.
		document.getElementById('image_' + imagePos).style.filter = "alpha(opacity=" + transparacy + ")";
		document.getElementById('image_' + imagePos).style.opacity = transparacy / 100;
		if(transparacy == 100){
			preload[imagePos - 1].width = "120";
			preload[imagePos - 1].height = "133";
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
		shiftRightFlag = true;
		imagePos = 1;
		shiftImageRight();
		timer = setInterval(function(){updateTransparacyShiftRight()},0);
	}
	else{
		shiftRightCount = shiftRightCount++;
	}
}

function shiftImageRight(){
	var temp = imageArray[(imageArray.length - 1)];
	for(var i = (imageArray.length - 1); i >= 0; i--){
		if(i == 0){
			imageArray[i] = temp;
		}
		else{
			imageArray[i] = imageArray[i-1];
		}
	}
	
	var preloadTemp = preload[(imageArray.length - 1)];
	for(var i = (imageArray.length - 1); i >= 0; i--){
		if(i == 0){
			preload[i] = preloadTemp;
		}
		else{
			preload[i] = preload[i-1];
		}
	}
	
	var linkTemp = imageLinkArray[(imageArray.length - 1)];
	for(var i = (imageArray.length - 1); i >= 0; i--){
		if(i == 0){
			imageLinkArray[i] = linkTemp;
		}
		else{
			imageLinkArray[i] = imageLinkArray[i-1];
		}
	}
	
}

function updateTransparacyShiftRight() {

	// un-comment if you want to include transition & set all transparacy & transparacyInverse to whatever - 0, 20, 40, 60...
	// transparacy = transparacy - 20;
	
	if(imagePos != 5) {
		// Fade image out.
		document.getElementById('image_' + imagePos).style.filter = "alpha(opacity=" + transparacy + ")";
		document.getElementById('image_' + imagePos).style.opacity = transparacy / 100;
		if(transparacy == 100){
			preload[imagePos - 1].width = "120";
			preload[imagePos - 1].height = "133";
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

</script>
</head>

<body>
<!--<a href="http://www.google.com" target="_blank">Google</a>
<a href="http://www.yahoo.com" target="_blank">Yahoo</a>
<a href="http://www.ebay.com" target="_blank">eBay</a>-->
<div align="center">
    <img src="images/banner/left.png" name="left" width="40" height="135" id="left" onClick="shiftBannerRight();" onMouseOver="hoverOverLeft();" onMouseOut="hoverOutLeft();" />
    <?php
    
        // Get the first 4 ads from banner info.
        $query = "SELECT * FROM website_ebay_banner WHERE active = 1 ORDER BY position ASC LIMIT 4;";
        $result = @mysql_query($query); // Run the query.
        if($result)
        {
            while($row = mysql_fetch_array($result, MYSQL_ASSOC))
            {
                $position = $row['position'];
                $image_url = $row['image_url'];
                $hyperlink_url = $row['hyperlink_url'];
                $arrayIndex = $position - 1;
                
                echo "<a id=\"link_$position\" name=\"link_$position\" href=\"$hyperlink_url\" target=\"_blank\"><img id=\"image_$position\" name=\"image_$position\" src=\"$image_url\" width=\"120\" height=\"133\" style=\"text-decoration:none; border:none;\" onMouseOver=\"hoverOverImage(this);\" onMouseOut=\"hoverOutImage(this);\" /></a> ";
            }
        }
    
    ?>
    <img src="images/banner/right.png" name="right" width="40" height="135" id="right" onClick="shiftBannerLeft();" onMouseOver="hoverOverRight();" onMouseOut="hoverOutRight();" />
    <!--<embed src="http://www.mintebay.com/flash-banners/show.swf?url=http://www.arristreasures.com&txt=Kilt%20Pin&card=http://www.mintebay.com/flash-banners//banner_images/3d/3.jpg&tc=16776960&sc=16711680&font=http://www.mintebay.com/flash-banners/fonts/plainn_lib.swf&tr=0&ts=100&tx=0&ty=0&glitter=1&rounded=0&bevel=0&sepia=0&theme=&theme_al=100" quality="high" bgcolor="#ffffff" width="468" height="60" name="show" align="middle" allowScriptAccess="always" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>-->
    <br />
    <br /><br /><br />
</div>
<!-- Scroll to top of window
<br/>
<input type="button" value="Click Here" onclick="parent.window.scrollTo(0, 0);" />
-->
</body>
</html>
