// JavaScript Document

// This function uses xmlhttp to request banner items.
// When the async message is read in for the event handler declared,
// the page area is updated with result.
function ajaxGetAdvertisingBannerItems()
{
	var thisdate = new Date();
	var type = "&type=getAdvertisingBannerItems";
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxGetAdvertisingBannerItemsHandler(xmlhttp);}
	xmlhttp.send(null);
	
	// alert("*** called");
}

function ajaxGetAdvertisingBannerItemsHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var items = xmlhttp.responseText;
		// alert(items);
		document.getElementById("advertising_banner_wrapper").innerHTML = items;
		// ajaxTestJSONPost();
		// alert("*** called");
	}
}

function editAdvertisingBannerItem(Id, position, hyperlink, button) {
	if(button.value == 'Edit') {
		document.getElementById('submitBtn').value = 'Update';
		document.getElementById('position').value = position;
		document.getElementById('hyperlink').value = hyperlink;
		document.getElementById('itemUpdateId').value = Id;
		document.getElementById('oldPosition').value = position;
		document.getElementById('myfile').value = '';
		button.value = 'Cancel';
		// alert("Please update your values above and click Update or click the same button to cancel.");
	} else if(button.value == 'Cancel') {
		document.getElementById('submitBtn').value = 'Insert';
		document.getElementById('position').value = '';
		document.getElementById('hyperlink').value = '';
		document.getElementById('itemUpdateId').value = '';
		document.getElementById('oldPosition').value = '';
		document.getElementById('myfile').value = '';
		button.value = 'Edit';
	}
}

function ajaxRemoveAdvertisingItem(bannerItemId)
{
	// alert("ajaxRemoveItem called " + bannerItemId);
	var thisdate = new Date();
	var type = "&type=removeAdvertisingBannerItem";
	var bannerItem = "&itemId=" + bannerItemId;
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + bannerItem;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxRemoveAdvertisingItemHandler(xmlhttp);}
	xmlhttp.send(null);
}

function ajaxRemoveAdvertisingItemHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var successFlag = xmlhttp.responseText;
		if(successFlag == "success") {
			// alert("Item Removed Successfully");
			
			ajaxGetAdvertisingBannerItems();
			window.location.reload();
			// TODO - code to update ad banner...
			// document.getElementById('iframe').src = document.getElementById('iframe').src;
			
		} else {
			alert("Item not removed");
		}
	}
}

function RequestAdvertisingTimeout(timeout) {
	this.timeout = timeout;
}

function ajaxUpdateAdvertisingBannerTimeout() {
	
	var thisdate = new Date();
	var type = "&type=updateAdvertisingBannerTimeout";
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	var timeout = document.getElementById('timeout').value;
	var requestAdvertisingTimeout = new RequestAdvertisingTimeout(timeout);
	var requestAdvertisingTimeoutJSONMessage = JSON.stringify(requestAdvertisingTimeout);
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("POST", serverPage, true);
	
	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/json");
	xmlhttp.setRequestHeader("Content-length", requestAdvertisingTimeoutJSONMessage.length);
	xmlhttp.setRequestHeader("Connection", "close");
	
	xmlhttp.onreadystatechange = function(){ajaxUpdateAdvertisingBannerTimeoutHandler(xmlhttp);}
	xmlhttp.send(requestAdvertisingTimeoutJSONMessage);
}

function ajaxUpdateAdvertisingBannerTimeoutHandler(xmlhttp) {
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200) {
		var jsonResponse = xmlhttp.responseText;
		var responseObject = JSON.parse(jsonResponse);
		var response = responseObject.response;
		if(response == "Success") {
			window.location.reload();
		} else {
			alert("Sorry, there appeared to be a problem updating the timeout. Please try again later.");
		}
	}
}

function debugIt() {
	alert('debugIt called');
}

// This example demonstrates a typical html form POST - real code would more than likely build up the params from
// the actual html forms using the DOM.
function ajaxTestPost() {
	
	var thisdate = new Date();
	var type = "&type=testPost";
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	var params = "lorem=ipsum&name=binny";
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("POST", serverPage, true);
	
	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");
	
	xmlhttp.onreadystatechange = function(){ajaxTestPostHandler(xmlhttp);}
	xmlhttp.send(params);
}

function ajaxTestPostHandler(xmlhttp) {
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var response = xmlhttp.responseText;
		alert(response);
	}
}

// This example demonstrates a typical JSON POST request & JSON response.
// Note: this time we supply the class definitions for the request jsonMessage.
function SomeClass(propertyA, propertyB, propertyC, list, nestedClass) {
	this.propertyA = propertyA;
	this.propertyB = propertyB;
	this.propertyC = propertyC;
	
	this.list = list;
	
	this.nestedClass = nestedClass;
}

function NestedClass(variableA, variableB, variableC) {
    this.variableA = variableA;
	this.variableB = variableB;
	this.variableC = variableC;
}

function ajaxTestJSONPost() {
	
	var thisdate = new Date();
	var type = "&type=testJSONPost";
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	var list = ["item1", "item2", "item3", "item4"];
	var nestedClass = new NestedClass("varA", "This is my Test Reponse", "varC");
	var someClass = new SomeClass("a", "b", "c", list, nestedClass);
	var jsonMessage = JSON.stringify(someClass);
		
	xmlhttp = getxmlhttp();
	xmlhttp.open("POST", serverPage, true);
	
	//Send the proper header information along with the request
	xmlhttp.setRequestHeader("Content-type", "application/json");
	xmlhttp.setRequestHeader("Content-length", jsonMessage.length);
	xmlhttp.setRequestHeader("Connection", "close");
	
	xmlhttp.onreadystatechange = function(){ajaxTestJSONPostHandler(xmlhttp);}
	xmlhttp.send(jsonMessage);
}

function ajaxTestJSONPostHandler(xmlhttp) {
	
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var jsonResponse = xmlhttp.responseText;
		var responseObject = JSON.parse(jsonResponse);
		var response = responseObject.response;
		alert("Ajax Test JSON Response is: " + response);
	}
}