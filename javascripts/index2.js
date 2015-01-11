// JavaScript Document

// This function alerts a hover message. Test function 04/04/09.
function hover_message(hover_message)
{
	alert("Mouse hovered over me ... " + hover_message);
}

// This function updates an info area located at the bottom of the content area.
function hover_menu_enter_update(data)
{
	// alert();
	var html = "";
	var info_div = document.getElementById("info");
	info_div.innerHTML = "new " + data;
	
	// The following commented code is used to keep to strict DOM rules
	// on constructing and appending html but innerHTML is easier, even if
	// it is a sledge hammer.
	
	/*
	alert("Do we get here...");
	var paragraph = document.createElement("p");
	info_div.appendChild(paragraph);
	var txt = document.createTextNode(data);
	paragraph.appendChild(txt);
	*/
	
	// We wish to set the menu visibility property to visable so we can see
	// the menu.  We shall hide it on mouse out.
	var menu_itm = document.getElementById("menu_itm");
	menu_itm.style.visibility = "visible";
	
	// Now set the position based on item no:
	switch(data)
	{
		case '1':
			menu_itm.style.left = "0px";
			html = "<ul class=\"menu_list\"><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 1</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 2</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 3</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 4</a></li></ul>";
		break;
		case '2':
			menu_itm.style.left = "75px";
			html = "<ul class=\"menu_list\"><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 5</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 6</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 7</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 8</a></li></ul>";
		break;
		case '3':
			menu_itm.style.left = "150px";
			html = "<ul class=\"menu_list\"><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 9</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 10</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 11</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 12</a></li></ul>";
		break;
		case '4':
			menu_itm.style.left = "225px";
			html = "<ul class=\"menu_list\"><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 13</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 14</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 15</a></li><li><a href=\"javascript:void(0);\" class=\"menu_list_item\">link 16</a></li></ul>";
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