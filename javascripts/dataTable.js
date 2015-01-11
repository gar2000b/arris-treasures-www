// JavaScript Document

// DataTable Object.
function DataTable()
{
	// Object member declarations.
	// this.message = message;
	this.pagination = false;
	this.messageArray = "";
	this.headerArray = [];
	this.columnQty = "";
	this.returnedRecordQty = "";
	this.recordDataStartingPosition = "";
	this.tempRecordDataStartingPosition = "";
	this.tableArray = [];
	this.htmlTable = "";
	this.filterArray = [];
	
	// Object methods declarations.
	this.setMessage = setMessage;
	this.getMessage = getMessage;
	this.convertToArray = convertToArray;
	this.constructHTMLTable = constructHTMLTable;
	this.getHTMLTable = getHTMLTable;
	this.getPagination = getPagination;
	this.setPagination = setPagination;
	this.setPaginationSettings = setPaginationSettings;
	this.runFilter = runFilter;
}

function getPagination()
{
	return this.pagination;
}

function setPagination(pagination)
{
	this.pagination = pagination
}

function setMessage(message)
{
	this.message = message;
}

function getMessage()
{
	return this.message;
}

function setPaginationSettings()
{
	// We are here...
}

function convertToArray()
{
	this.messageArray = this.message.split(",");
	this.columnQty = this.messageArray[0];
	this.columnQty = parseInt(this.columnQty);
	this.returnedRecordQty = this.messageArray[this.columnQty+1];
	this.recordDataStartingPosition = this.columnQty+2;
	this.recordDataStartingPosition = parseInt(this.recordDataStartingPosition);
	this.tempRecordDataStartingPosition = this.recordDataStartingPosition;
	this.tempRecordDataStartingPosition = parseInt(this.tempRecordDataStartingPosition);
	
	// Create and populate associative array to contain all table information returned.
	this.tableArray = [];
	// Now specify associative types (for each of the table column names - starting with ID - always assigned).
	this.tableArray['ID'] = new Array();
	for(i = 0; i < this.columnQty; i++)
	{
		this.tableArray[this.messageArray[i+1]] = new Array();
	}
	
	// Now populate the new tableArray with table info sent back.
	for(i = 0; i < this.returnedRecordQty; i++)
	{
		// alert("i is " + i);
		this.tableArray['ID'][i] = this.messageArray[this.tempRecordDataStartingPosition];
		// alert(this.tempRecordDataStartingPosition);
		// alert("Message Array at currently selected point is " + messageArray[tempRecordDataStartingPosition]);
		// alert("temp record point is " + tempRecordDataStartingPosition);
		this.tempRecordDataStartingPosition++;
		for(j = 0; j < this.columnQty; j++)
		{
			this.tableArray[this.messageArray[j+1]][i] = this.messageArray[this.tempRecordDataStartingPosition];
			this.tempRecordDataStartingPosition++;
		}
	}
	this.tempRecordDataStartingPosition = this.recordDataStartingPosition;
}

function constructHTMLTable()
{
	// Construct Data Table Here (Temporarily)...
	// Build HTML.
	this.htmlTable = "";
	
	// Build up table, header row & filter row.
	this.htmlTable += "<table width=\"100%\" border=\"0\" cellpadding=\"2\" cellspacing=\"0\">";
	
	// Header Row.
	this.htmlTable += "<tr>";
	for(i = 0; i < this.columnQty; i++)
	{
		this.headerArray[i] = this.messageArray[i+1];
		this.htmlTable += "<td><strong>" + this.messageArray[i+1] + "</strong></td>";
	}
	this.htmlTable += "</tr>";
	
	// Filter Row.
	this.htmlTable += "<tr>";
	for(i = 0; i < this.columnQty; i++)
	{
		this.htmlTable += "<td><input name=\"" + this.headerArray[i] + "\" id=\"" + this.headerArray[i] + "\" type=\"text\" /></td>";
	}
	this.htmlTable += "</tr>";
	
	// DataRows.
	// Need to know total number of returned records first - which we have assigned above.
	for(i = 0; i < this.returnedRecordQty; i++)
	{
		this.htmlTable += "<tr>";
		// We require a loop to cycle through no of columns again.
		for(j = 0; j < this.columnQty; j++)
		{
			// Get name of column to extract its contents.
			this.htmlTable += "<td><strong>" + this.tableArray[this.messageArray[j+1]][i] + "</strong></td>";
		}
		this.htmlTable += "</tr>";
	}
	
	// end loop.
	this.htmlTable += "</table>";
	
	// If pagination is set then write out pagination links.
	if(this.pagination)
	{
		this.htmlTable += "<p align = \"center\"><a><< &nbsp;< &nbsp; Pagination goes here &nbsp; > &nbsp;>></a></p>";
	}
}

function runFilter()
{
	var filterData = "";
	
	// alert("Do we get here?");
	for(i = 0; i < parseInt(this.headerArray.length); i++)
	{
		// alert(this.headerArray[i]);U
		var filter = document.getElementById(this.headerArray[i]);
		if(filter.value.length > 0) {
			// alert("Column " + this.headerArray[i] + " value is " + filter.value);
			filterData = filterData + i + "%24" + filter.value + "%23";
		}
	}
	
	if(filterData.length > 0) {
		filterData = "filter_" + filterData;
	}
	
	return filterData;
}

function getHTMLTable()
{
	this.convertToArray();
	this.setPaginationSettings(); // We are here...
	this.constructHTMLTable();
	return this.htmlTable;
}