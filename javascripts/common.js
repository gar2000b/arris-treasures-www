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
	   	adminLogin();
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

// Function to include all other javascript files.
function javascriptInclude(js)
{
	document.write("<script type=\"text/javascript\" src=\"" + js + "\"></script>");
}

// This function is called from the onLoad() function in the body tag.
// It loads all images into memory (with exception of the home page) 
// eliminating the loading time for all subsequent selected page images.
// Resulting in a smooth selection.
function preloadImages()
{
	var preload = new Array();
	var imgs = new Array("images/head.png", "images/commodore.png", "images/einstein.png", "images/officer.png");
	for(var i = 0; i < 4; i++)
	{
		preload[i] = new Image();
		preload[i].src = imgs[i];
	}
	// alert('Images preloaded');
}

// Encodes a string for safe GET passing as part of URL (In particular - our queries)...
function URLEncode (clearString) {
  var output = '';
  var x = 0;
  clearString = clearString.toString();
  var regex = /(^[a-zA-Z0-9_.]*)/;
  while (x < clearString.length) {
    var match = regex.exec(clearString.substr(x));
    if (match != null && match.length > 1 && match[1] != '') {
    	output += match[1];
      x += match[1].length;
    } else {
      if (clearString[x] == ' ')
        output += '+';
      else {
        var charCode = clearString.charCodeAt(x);
        var hexVal = charCode.toString(16);
        output += '%' + ( hexVal.length < 2 ? '0' : '' ) + hexVal.toUpperCase();
      }
      x++;
    }
  }
  return output;
}

function URLDecode (encodedString) {
  var output = encodedString;
  var binVal, thisString;
  var myregexp = /(%[^%]{2})/;
  while ((match = myregexp.exec(output)) != null
             && match.length > 1
             && match[1] != '') {
    binVal = parseInt(match[1].substr(1),16);
    thisString = String.fromCharCode(binVal);
    output = output.replace(match[1], thisString);
  }
  return output;
}

// This function dynamically loads up the new page.
function gotoPage(page)
{
	var html = "";
	// Gain handle on page area.
	var page_area = document.getElementById("page_area");
	
	switch(page)
	{
		case 1:
		html = "<div class=\"title_padding\">content area 1 - version 1.0.3</div>";
		break;
		case 2:
		html = "<div class=\"title_padding\">content area 2 - version 1.0.3</div>";
		break;
		case 3:
		html = "<div class=\"title_padding\">content area 3 - version 1.0.3</div>";
		break;
		case 4:
		html = "<div class=\"title_padding\">content area 4 - version 1.0.3</div>";
		break;
	}
	
	page_area.innerHTML = html;
	exit_menu();
}

// Menu Stuff

// This function alerts a hover message. Test function 04/04/09.
function hover_message(hover_message)
{
	alert("Mouse hovered over me ... " + hover_message);
}

// This function updates an info area located at the bottom of the content area.
function hover_menu_enter_update(data)
{
	var html = "";
	var info_div = document.getElementById("info");
	
	// We wish to set the menu visibility property to visable so we can see
	// the menu.  We shall hide it on mouse out.
	var menu_itm = document.getElementById("menu_itm");
	menu_itm.style.visibility = "visible";
	
	// Now set the position based on item no:
	switch(data)
	{
		case '1':
			menu_itm.style.left = "0px";
			html = "<ul class=\"menu_list\">"
			+ "<li><a href=\"javascript:ajaxPageRequest('link1.html');\" class=\"menu_list_item\">Home</a></li>" 
			+ "<li><a href=\"badge-list.php\" class=\"menu_list_item\">Badge List</a></li>" 
			+ "<li><a href=\"javascript:ajaxPageContentRequest('pages/returns.php');\" class=\"menu_list_item\">Returns</a></li>" 
			+ "<li><a href=\"javascript:ajaxPageRequest('link2.html');\" class=\"menu_list_item\">Einstein</a></li>" 
			+ "<li><a href=\"javascript:ajaxPageRequest('link3.html');\" class=\"menu_list_item\">Full Metal</a></li>" 
			+ "<li><a href=\"javascript:ajaxPageRequest('link4.html');\" class=\"menu_list_item\">Commodore</a></li>"
			+ "<li><a href=\"javascript:ajaxPageRequest('link5.html');\" class=\"menu_list_item\">Terminator</a></li>" + 
			"</ul>";
		break;
		case '2':
			menu_itm.style.left = "75px";
			html = "<ul class=\"menu_list\">"
			+ "<li><a href=\"javascript:ajaxPageContentRequest('pages/products/products.html');\" class=\"menu_list_item\">All Products</a></li>" 
			+ "<li><a href=\"javascript:ajaxPageRequest('circle_page.html');\" class=\"menu_list_item\">Kilt Pins</a></li>"
			+ "<li><a href=\"javascript:ajaxPageRequest('circle_page.html');\" class=\"menu_list_item\">Belt Buckles</a></li>"
			+ "<li><a href=\"javascript:ajaxPageRequest('led_panel_page.html');\" class=\"menu_list_item\">Clan Keyrings</a></li>"
			+ "<li><a href=\"javascript:ajaxPageRequest('led_main_page.html');\" class=\"menu_list_item\">Other</a></li>"
			"</ul>";
		break;
		case '3':
			menu_itm.style.left = "160px";
			html = "<ul class=\"menu_list\">"
			+ "<li><a href=\"gotoPage(1);\" class=\"menu_list_item\">link 9</a></li>"
			+ "<li><a href=\"gotoPage(1);\" class=\"menu_list_item\">link 10</a></li>"
			+ "<li><a href=\"gotoPage(1);\" class=\"menu_list_item\">link 11</a></li>"
			+ "<li><a href=\"gotoPage(1);\" class=\"menu_list_item\">link 12</a></li>" +
			"</ul>";
		break;
		case '4':
			menu_itm.style.left = "235px";
			html = "<ul class=\"menu_list\">"
			+ "<li><a href=\"javascript:ajaxPageRequest('messages.html');\" class=\"menu_list_item\">Messages</a></li>"
			+ "<li><a href=\"javascript:checkAdminLogin();\" class=\"menu_list_item\">Login</a></li>"
			"</ul>";
		break;
	}
	menu_itm.innerHTML = html;
}

// This function sets the menu item to hidden again.
function hover_menu_exit_update(data)
{
	// alert('menu exit');
	var menu_itm = document.getElementById("menu_itm");
	menu_itm.style.visibility = "hidden";
}

// This function sets the menu_set_flag to 1.
function enter_menu()
{
	// alert('menu entered.');
	var menu_itm = document.getElementById("menu_itm");
	menu_itm.style.visibility = "visible";
}

// This function sets the flag to 0.
function exit_menu()
{
	var menu_itm = document.getElementById("menu_itm");
	menu_itm.style.visibility = "hidden";
}

// This function uses xmlhttp to request content of a web page.
// When the async message is read in for the event handler declared,
// the page area is updated with result.
function ajaxPageRequest(serverPage)
{
	var thisdate = new Date();
	url = serverPage + "?time=" + thisdate.getTime();
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", url);
	// alert(objID);
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var page_area = document.getElementById("page_area");
			page_area.innerHTML = xmlhttp.responseText;
			// Initialise Functions.
			if(serverPage == "led_panel_page.html"){ledPanelPage.initLedPanel();}
		}
	}
	xmlhttp.send(null);
	exit_menu();
}

// This is the new page request function which calls the main_ajax.php file
// with the getPage request and full path to web page requested.
// the php code then reads in the page requested and strips out the content area
// to be sent back and rendered.
function ajaxPageContentRequest(pageIn)
{
	var thisdate = new Date();
	var type = "&type=getPage";
	var page = "&page=" + pageIn;
	var serverPage = "../php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + page;
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var page_area = document.getElementById("page_area");
			page_area.innerHTML = xmlhttp.responseText;
			// Initialise Functions.
			if(pageIn == "pages/banner_admin.php"){bannerAdminPage.ajaxGetBannerItems();}
			if(pageIn == "pages/world_of_ideas_products.php"){worldOfIdeasPage.ajaxGetWorldOfIdeas(1);}
			if(pageIn == "pages/world_of_ideas_infrastructure.php"){worldOfIdeasPage.ajaxGetWorldOfIdeas(2);}
		}
	}
	xmlhttp.send(null);
	exit_menu();
}

// Check if admin has already logged in.
function checkAdminLogin()
{
	var thisdate = new Date();
	var type = "&type=adminLogin";

	var serverPage = "../php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){checkAdminLoginAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function checkAdminLoginAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		// alert("output is " + output);
		if(output == "success")
		{
			ajaxPageRequest('admin_page.html');
		}
		else
		{
			ajaxPageRequest('admin_login.html');
		}
	}
}

// Method to login and authenticate an admin / operator user.
function adminLogin()
{
	var thisdate = new Date();
	var type = "&type=adminLogin";
	type += "&username=" + document.getElementById("username").value;
	type += "&password=" + document.getElementById("password").value;

	var serverPage = "../php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){adminLoginAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function adminLoginAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		if(output == "success")
		{
			// alert("Login Successful");
			ajaxPageRequest('admin_page.html');
		}
		else
		{
			alert("Sorry, please ensure your login credentials are correct!");
			// document.getElementById('username').value = "";
			document.getElementById('password').value = "";
		}
	}
}

// Method to logout user.
function adminLogout()
{
	var thisdate = new Date();
	var type = "&type=adminLogout";

	var serverPage = "../php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){adminLogoutAjaxHandler(xmlhttp);}
	xmlhttp.send(null);
}

function adminLogoutAjaxHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var outputDiv = document.getElementById("output");
		// Set div to output.
		var output = xmlhttp.responseText;
		// Set Div to return html.
		// outputDiv.innerHTML = output;
		if(output == "success")
		{
			alert("Logout Successful");
			ajaxPageRequest('admin_login.html');
		}
		else
		{
			alert("Sorry, there was a problem logging you out!");
		}
	}
}

function gotoEbayAPICall()
{
	window.location = './ebay/eBayAPICall.php';
}

function pleaseCallMe()
{
	alert("Please Call Me");
}

// This function substitutes carriage returns for html <br />.
function escapeVal(textarea){
	// Replace with html breakpoint.
	// replaceWith = '<br />';
	replaceWith = '<br />';
	
	var newText = textarea.value;
	
	// textarea is reference to that object, replaceWith is string that will replace the encoded return
	newText = escape(newText); // encode textarea string's carriage returns
	
	for(i = 0; i < newText.length; i++)
	{ 
		// loop through string, replacing carriage return encoding with HTML break tag
		
		if(newText.indexOf("%0D%0A") > -1)
		{ 
			// Windows encodes returns as \r\n hex
			newText=newText.replace("%0D%0A",replaceWith);
		}
		else if(newText.indexOf("%0A") > -1)
		{ 
			// Unix encodes returns as \n hex
			newText=newText.replace("%0A",replaceWith);
		}
		else if(newText.indexOf("%0D") > -1)
		{ 
			// Macintosh encodes returns as \r hex
			newText=newText.replace("%0D",replaceWith);
		}
		
	}
	// alert('Do I get called here.');
	newText=unescape(newText);  // unescape all other encoded characters
	return newText;
}

// This function substitutes carriage returns for html <br />.
function escapeHTMLBr(value){
	// Replace with newline char \n.
	replaceWith = '\n';
	
	var newText = value;
	
	for(i = 0; i < newText.length; i++) {
		if(newText.indexOf("<br />") > -1) {
			newText=newText.replace("<br />",replaceWith);
		}
	}
	
	return newText;
}