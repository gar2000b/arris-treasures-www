// Message Page Object.

// Includes
javascriptInclude('javascripts/messages.js');

// Message Page Object Constructor
function MessagePage()
{
	// Members
	this.messages = new Messages();
	
	// Object methods declarations.
	this.ajaxGetMessages = ajaxGetMessages;
	this.doFilter = doFilter;
	this.ajaxGetSoapMessage = ajaxGetSoapMessage;
	this.np = np;
	this.pp = pp;
	
	// Construction code.
	this.messages.setRowQty(5);
	this.messages.setPageNo(1);
}

// This function uses xmlhttp to request messages.
// When the async message is read in for the event handler declared,
// the page area is updated with result.
function ajaxGetMessages()
{
	this.messages.getAjaxMessages();
}

function doFilter()
{
	this.messages.executeFilter();
}

function ajaxGetSoapMessage()
{
	this.messages.getAjaxSoapMessage();
}

function np()
{
	this.messages.nextPage();
}

function pp()
{
	this.messages.previousPage();
}