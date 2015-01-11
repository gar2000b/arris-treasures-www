// Banner Admin Page Object.

// Includes

// Banner Admin Page Object Constructor
function WorldOfIdeasPage()
{
	// Initialise Remove Dialog.
	$(function() {
	
		// Dialog
		$('#remove-dialog').dialog({
			autoOpen: false,
			width: 640,
			modal: true,
			buttons: {
				"Implemented": function() {
					ajaxRemoveWorldOfIdeasItem(document.getElementById('removeId').value, 1, document.getElementById("typeId").value);
					$(this).dialog("close");
				},
				"Not Required": function() {
					ajaxRemoveWorldOfIdeasItem(document.getElementById('removeId').value, 2, document.getElementById("typeId").value);
					$(this).dialog("close");
				},
				"Will Revisit": function() {
					ajaxRemoveWorldOfIdeasItem(document.getElementById('removeId').value, 3, document.getElementById("typeId").value);
					$(this).dialog("close");
				},
				"Poor": function() {
					ajaxRemoveWorldOfIdeasItem(document.getElementById('removeId').value, 4, document.getElementById("typeId").value);
					$(this).dialog("close");
				},
				"Infeasible": function() {
					ajaxRemoveWorldOfIdeasItem(document.getElementById('removeId').value, 5, document.getElementById("typeId").value);
					$(this).dialog("close");
				},
				"Cancel": function() {
					$(this).dialog("close");
				}
			}
		});
	});
	
	// Members
	
	// Object methods declarations.
	this.ajaxGetWorldOfIdeas = ajaxGetWorldOfIdeas;
	this.ajaxInsertItem = ajaxInsertItem;
	this.removeItem = removeItem;
	this.ajaxRemoveWorldOfIdeasItem = ajaxRemoveWorldOfIdeasItem;
	this.editWorldOfIdeasItem = editWorldOfIdeasItem;

	// Construction code.
}

// This function uses xmlhttp to request banner items.
// When the async message is read in for the event handler declared,
// the page area is updated with result.
function ajaxGetWorldOfIdeas(typeId)
{
	document.getElementById("typeId").value = typeId;
	var thisdate = new Date();
	var type = "&type=getWorldOfIdeas";
	var typeId = "&typeId=" + typeId;
	var serverPage = "php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + typeId;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxGetWorldOfIdeasHandler(xmlhttp, typeId);}
	xmlhttp.send(null);
}

function ajaxGetWorldOfIdeasHandler(xmlhttp, typeId)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var items = xmlhttp.responseText;
		// alert(items);
		document.getElementById("world_of_ideas_wrapper").innerHTML = items;
		// alert(items);
	}
}

//function ajaxInsertItem() {
//	alert("ajaxInsertItem called.");
//}

function ajaxInsertItem(position, title, description, typeId)
{
	var thisdate = new Date();
	var type = '';
	if(document.getElementById('submitBtn').value == 'Insert') {
		type = "&type=insertWorldOfIdeasItem";
	}
	else if(document.getElementById('submitBtn').value == 'Update') {
		type = "&type=updateWorldOfIdeasItem";
		type += "&itemUpdateId=" + document.getElementById('itemUpdateId').value;
		type += "&oldPosition=" + document.getElementById('oldPosition').value;
	}
	var worldOfIdeasItem = "&position=" + position;
	worldOfIdeasItem += "&title=" + title;
	worldOfIdeasItem += "&description=" + description;
	worldOfIdeasItem += "&typeId=" + typeId;
	var serverPage = "php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + worldOfIdeasItem;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxInsertItemHandler(xmlhttp, typeId);}
	xmlhttp.send(null);
}

function ajaxInsertItemHandler(xmlhttp, typeId)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var successFlag = xmlhttp.responseText;
		if(successFlag == "success") {
			// alert("Item Added Successfully");
			worldOfIdeasPage.ajaxGetWorldOfIdeas(typeId);
			document.getElementById('position').value = "";
			document.getElementById('title').value = "";
			document.getElementById('description').value = "";
			document.getElementById('submitBtn').value = 'Insert';
		} else {
			alert("Item not inserted");
		}
	}
}

function removeItem(id) {
	document.getElementById('removeId').value = id;
	$('#remove-dialog').dialog('open');
}

function ajaxRemoveWorldOfIdeasItem(itemId, reasonType, typeId)
{
	// alert("ajaxRemoveItem called " + bannerItemId);
	var thisdate = new Date();
	var type = "&type=removeWorldofIdeasItem";
	var worldOfIdeasItem = "&itemId=" + itemId + "&typeId=" + typeId;
	var reasonTypeIn = "&reasonType=" + reasonType;
	var serverPage = "php_scripts/main_ajax.php?time=" + thisdate.getTime() + type + reasonTypeIn + worldOfIdeasItem;
	
	xmlhttp = getxmlhttp();
	xmlhttp.open("GET", serverPage);
	xmlhttp.onreadystatechange = function(){ajaxRemoveWorldOfIdeasItemHandler(xmlhttp, typeId);}
	xmlhttp.send(null);
}

function ajaxRemoveWorldOfIdeasItemHandler(xmlhttp, typeId)
{
	if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
	{
		// Get handle on markup to update...
		var successFlag = xmlhttp.responseText;
		if(successFlag == "success") {
			worldOfIdeasPage.ajaxGetWorldOfIdeas(typeId);
			// alert("Item Removed Successfully");
		} else {
			alert("Item not removed");
		}
	}
}

function editWorldOfIdeasItem(Id, position, title, description, button) {
	if(button.value == 'Edit') {
		document.getElementById('submitBtn').value = 'Update';
		document.getElementById('position').value = position;
		document.getElementById('title').value = title;
		document.getElementById('description').value = escapeHTMLBr(description);
		document.getElementById('itemUpdateId').value = Id;
		document.getElementById('oldPosition').value = position;
		button.value = 'Cancel';
		// alert("Please update your values above and click Update or click the same button to cancel.");
	} else if(button.value == 'Cancel') {
		document.getElementById('submitBtn').value = 'Insert';
		document.getElementById('position').value = '';
		document.getElementById('title').value = '';
		document.getElementById('description').value = '';
		document.getElementById('itemUpdateId').value = '';
		document.getElementById('oldPosition').value = '';
		button.value = 'Edit';
	}
}