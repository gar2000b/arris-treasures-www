// JavaScript Document

// This function uses xmlhttp to request banner items.
// When the async message is read in for the event handler declared,
// the page area is updated with result.
function ajaxGetBannerItems()
{
	var thisdate = new Date();
	var type = "&type=getBannerItems";
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxGetBannerItemsHandler(xmlhttp);}
	xmlhttp.send(null);
}

function ajaxGetBannerItemsHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var items = xmlhttp.responseText;
		// alert(items);
		document.getElementById("banner_wrapper").innerHTML = items;
		// alert(items);
	}
}

function editBannerItem(Id, position, hyperlink, button) {
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

function ajaxRemoveItem(bannerItemId)
{
	// alert("ajaxRemoveItem called " + bannerItemId);
	var thisdate = new Date();
	var type = "&type=removeBannerItem";
	var bannerItem = "&itemId=" + bannerItemId;
	var serverPage = "./php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + bannerItem;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxRemoveItemHandler(xmlhttp);}
	xmlhttp.send(null);
}

function ajaxRemoveItemHandler(xmlhttp)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var successFlag = xmlhttp.responseText;
		if(successFlag == "success") {
			// alert("Item Removed Successfully");
			ajaxGetBannerItems();
			document.getElementById('iframe').src = document.getElementById('iframe').src;
		} else {
			alert("Item not removed");
		}
	}
}