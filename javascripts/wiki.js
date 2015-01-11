// JavaScript Document

var carriageReturnSet = false;

// Add generic event listening code for cross browser compat.
function keyval(n)
{
    if (n == null) return 'undefined';
    var s= '' + n;
    if (n >= 32 && n < 127) s+= ' (' + String.fromCharCode(n) + ')';
    while (s.length < 9) s+= ' ';
    return s;
}

function keypress(e)
{
   if (!e) e= event;
   pressmesg('keypress',e);
   // return suppressdefault(e,document.testform.keypress.checked);
}

function pressmesg(w,e)
{
   if(keyval(e.keyCode) == 13)
   {
	   carriageReturnSet = true;
	   if(document.getElementById('password'))
	   {
	   	login();
	   }
   }
}

function suppressdefault(e,flag)
{
   if (flag)
   {
       if (e.preventDefault) e.preventDefault();
       if (e.stopPropagation) e.stopPropagation();
   }
   return !flag;
}

function showmesg(t)
{
	alert(t);
	return false;
}

if (document.addEventListener)
{
   document.addEventListener("keypress",keypress,false);
}
else if (document.attachEvent)
{
   document.attachEvent("onkeypress", keypress);
}
else
{
   document.onkeypress= keypress;
}

// deletePage - used to logically delete a wiki page.
function deletePage(pageId) {
	document.getElementById('type').value='deletePage';
	document.getElementById('pageId').value=pageId;
	
	var c = confirm("Are you sure you wish to delete this page?");
	if(c) {
		document.f.submit();
	} else {
		return false;
	}
}

// deleteImage - used to logically delete an image.
function deleteImage(imageId) {
	document.f.action = 'image_manager.php';
	document.f.target = '_self';
	document.f.onsubmit = "";
	document.getElementById('type').value='deleteImage';
	document.getElementById('imageId').value=imageId;
	
	var c = confirm("Are you sure you wish to delete this image?");
	if(c) {
		document.f.submit();
	} else {
		return false;
	}
}

function logout() {
	document.getElementById('type').value='logout';
	
	var c = confirm("Are you sure you wish to logout?");
	if(c) {
		document.f.target = '_self';
		document.f.onsubmit = "";
		document.f.submit();
	} else {
		return false;
	}
}

// Method to login and authenticate an admin / operator user.
function login()
{
	var thisdate = new Date();
	var type = "&type=login";
	type += "&username=" + document.getElementById("username").value;
	type += "&password=" + document.getElementById("password").value;

	var serverPage = "../php_scripts/wiki_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){loginAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function loginAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var output = xmlhttp.responseText;

		if(output == "success")
		{
			// alert("Login Successful");
			window.location = 'wiki.php';
			// ajaxPageRequest('admin_page.html');
		}
		else
		{
			alert("Sorry, please ensure your login credentials are correct!");
			// document.getElementById('username').value = "";
			document.getElementById('password').value = "";
		}
	}
}

function startUpload() {
	document.getElementById('graphic').style.display = 'inline';
}

function stopUpload() {
	// alert('File Uploaded');
	document.getElementById('graphic').style.display = 'none';
	window.location = '/wiki/image_manager.php';
}

function initImageDialog() {
	// Initialise View Image Dialog.
	$(function() {
	
		// Dialog
		$('#view-image-dialog').dialog({
			autoOpen: false,
			modal: true,
			open: function() {
				$('.ui-widget-overlay').addClass('custom-overlay');
			},
			close: function() {
				$('.ui-widget-overlay').removeClass('custom-overlay');
			},
			position:['middle',20],
			buttons: {
				"Close": function() {
					$(this).dialog("close");
				}
			}
		});
	});
}

// TODO: Document this - event that's triggered once image has loaded.
function testViewImage(imagePath) {

	var img = new Image;
	document.getElementById('image').onload = function () {
		$('#view-image-dialog').dialog("option", "width", "auto");
		$('#view-image-dialog').dialog('open');
	};
	document.getElementById('image').src = imagePath;
	
}