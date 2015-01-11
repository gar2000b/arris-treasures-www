// Messages Object.

// Includes
javascriptInclude('javascripts/dataTable.js');

// Messages Object Constructor
function Messages()
{
	// Members
	this.rowQty = 10;
	this.pageNo = 1;
	this.dataTable = new DataTable();
	this.filter = "";
	
	// Object methods declarations.
	this.getAjaxMessages = getAjaxMessages;
	this.getAjaxSoapMessage = getAjaxSoapMessage;
	this.getRowQty = getRowQty;
	this.setRowQty = setRowQty;
	this.getPageNo = getPageNo;
	this.setPageNo = setPageNo;
	this.executeFilter = executeFilter;
	this.registerKeyboardHandler = registerKeyboardHandler;
	this.keyPressed = keyPressed;
	this.nextPage = nextPage;
	this.previousPage = previousPage;
	
	// Construction code.
}

function getRowQty()
{
	return this.rowQty;
}

function setRowQty(rowQty)
{
	this.rowQty = rowQty;
}

function getPageNo()
{
	return this.pageNo;
}

function setPageNo(pageNo)
{
	this.pageNo = pageNo;
}

function getAjaxMessages()
{
	// var sql = "SELECT * FROM messages LIMIT 10";
	// sql = URLEncode(sql);
	
	// Must declare these as variables before passing into handler.
	var dataTable = this.dataTable;
	var parent = this;
	
	var thisdate = new Date();
	var type = "&type=getMessages";
	var serverPage = "php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	serverPage += "&rowQty=" + this.rowQty;
	serverPage += "&pageNo=" + this.pageNo;
	serverPage += "&filter=" + this.filter;
	this.filter = "";
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxGetMessagesHandler(xmlhttp, dataTable); registerKeyboardHandler(parent); }
	xmlhttp.send(null);
	exit_menu();
}

function ajaxGetMessagesHandler(xmlhttp, dataTable)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var messages = document.getElementById("messages");
		// Convert String to Array Data Structure...
		var message = xmlhttp.responseText;
		// Create DataTable object & get its HTML.
		dataTable.setMessage(message);
		dataTable.setPagination(false);
		html = dataTable.getHTMLTable();	
		// Update markup container with new HTML DataTable.
		messages.innerHTML = html;
	}
}

function getAjaxSoapMessage()
{
	// var sql = "SELECT * FROM messages LIMIT 10";
	// sql = URLEncode(sql);
	var thisdate = new Date();
	var type = "&type=getSoapMessage";
	var serverPage = "php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	serverPage += "&rowQty=" + this.rowQty;
	serverPage += "&pageNo=" + this.pageNo;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxGetSoapMessageHandler(xmlhttp);}
	xmlhttp.send(null);
	exit_menu();
}

function ajaxGetSoapMessageHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var messages = document.getElementById("messages");
		// Convert String to Array Data Structure...
		var message = xmlhttp.responseText;
	}
}

function nextPage()
{
	this.pageNo += 1;
	// alert("+Page no is " + this.pageNo);
	this.executeFilter();
}

function previousPage()
{
	this.pageNo -= 1;
	// alert("-Page no is " + this.pageNo);
	this.executeFilter();
}

// Adding bespoke filters and executing.
function executeFilter()
{
	// Get handle on markup to update...
	var messages = document.getElementById("messages");
	this.filter = this.dataTable.runFilter();
	// Bolt on new filter (say category) starting next position after columns.
	if(this.filter.length > 0) {
		this.filter = this.filter + this.dataTable.headerArray.length + "%24" + "categoryValue";
	}
	this.getAjaxMessages();
}

// The following two functions register the keyboard handler.
function registerKeyboardHandler(parent) {
	document.getElementById("Name").addEventListener('keydown', function(e){keyPressed(e, parent);}, false);
	document.getElementById("Email").addEventListener('keydown', function(e){keyPressed(e, parent);}, false);
	document.getElementById("Date Time").addEventListener('keydown', function(e){keyPressed(e, parent);}, false);
}

// Actual Keypress function.
function keyPressed(e, parent){
	if (e.keyCode == 13) {
		parent.executeFilter();
	}
}