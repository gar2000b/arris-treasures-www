<?php

session_start();
require_once('../php_scripts/common.php');

if(!checkAuthorisation())
{
	header("Location:../index.html");
}

?>

<!-- Build the HTML page with values from the call response -->
<html>
<head>
<title>eBay Search Results for eBay API calls</title>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
<script type="text/javascript" src="../javascripts/ebay.js"></script>
<script type="text/javascript" src="../javascripts/xmlhttpobject.js"></script>
</head>
<body>

<h1>
  <input type="button" value="ArrisHome" onClick="window.location = '../index.html';" />
</h1>
<h1>eBay Search Results for eBay API calls</h1>
<p><input name="button" type="button" id="button" onClick="document.getElementById('pauseContinueGetEbayTimeRequestset').disabled=false; getEbayTimeRequestsetAjax();" value="GeteBayTimeRequest" /></p>
<div id="output">GeteBayTimeRequest Output Here</div>
<p>GeteBayTimeRequest Counter - <span id="counter">0</span></p>
<p><input name="pauseContinueGetEbayTimeRequestset" type="button" id="pauseContinueGetEbayTimeRequestset" onClick="pauseContinueGetEbayTimeRequestset();" value="Pause" disabled /></p>
<h2>Kilt Pin with Swarovski Stone</h2>
<hr>

<p><input name="button" type="button" id="button" onClick="document.getElementById('pauseContinueUploadSiteHostedPicturesRequest').disabled=false; uploadSiteHostedPicturesRequestAjax();" value="UploadSiteHostedPicturesRequest" /></p>
<div id="outputUploadSiteHostedPicturesRequest">UploadSiteHostedPicturesRequest Output Here</div>
<p>UploadSiteHostedPicturesRequest Counter - <span id="counterUploadSiteHostedPicturesRequest">0</span></p>
<p><input name="pauseContinueUploadSiteHostedPicturesRequest" type="button" id="pauseContinueUploadSiteHostedPicturesRequest" onClick="pauseContinueUploadSiteHostedPicturesRequest();" value="Pause" disabled /></p>
<hr>

<p><input name="button" type="button" id="button" onClick="createKiltPinListingsAjax();" value="Create Formated (Kilt Pin) Listing Entries in DB" /></p>
<div id="outputCreateKiltPinListings">CreateKiltPinListings Output Here</div>
<p>CreateKiltPinListings Counter - <span id="counterCreateKiltPinListings">0</span></p>
<p><input name="pauseContinueCreateKiltPinListings" type="button" id="pauseContinueCreateKiltPinListings" onClick="pauseContinueCreateKiltPinListings();" value="Pause" disabled /></p>
<hr>

<p><input name="button" type="button" id="button" onClick="document.getElementById('pauseContinueAddItemRequest').disabled=false; addItemRequestAjax();" value="Add Item Request - Kilt Pin" /> 
Enter No of Listings to generate
<input type="text" id="kilt_pin_listing_qty" name="kilt_pin_listing_qty" value="10" size="2" />
</p>
<div id="outputAddItemRequest">AddItemRequest Output Here</div>
<p>AddItemRequest Counter - <span id="counterAddItemRequest">0</span></p>
<p><input name="pauseContinueAddItemRequest" type="button" id="pauseContinueAddItemRequest" onClick="pauseContinueAddItemRequest();" value="Pause" disabled /></p>
<h2>Kilt Pin(s) with Swarovski Stone</h2>
<hr>

<p>
  <input name="button2" type="button" id="button2" onClick="createKiltPinsListingsAjax();" value="Create Formated (Kilt Pins) Listing Entries in DB" />
</p>
<div id="outputCreateKiltPinsListings">CreateKiltPinsListings Output Here</div>
<p>CreateKiltPinsListings Counter - <span id="counterCreateKiltPinsListings">0</span></p>
<p>
  <input name="pauseContinueCreateKiltPinsListings" type="button" id="pauseContinueCreateKiltPinsListings" onClick="pauseContinueCreateKiltPinsListings();" value="Pause" disabled />
</p>
<hr>
<p>
  <input name="button3" type="button" id="button3" onClick="document.getElementById('pauseContinueAddItemRequestPins').disabled=false; addItemRequestPinsAjax();" value="Add Item Request - Kilt Pins" />
  Enter No of Listings to generate
  <input type="text" id="kilt_pins_listing_qty" name="kilt_pins_listing_qty" value="10" size="2" />
</p>
<div id="outputAddItemRequestPins">AddItemRequestPins Output Here</div>
<p>AddItemRequestPins Counter - <span id="counterAddItemRequestPins">0</span></p>
<p>
  <input name="pauseContinueAddItemRequestPins" type="button" id="pauseContinueAddItemRequestPins" onClick="pauseContinueAddItemRequestPins();" value="Pause" disabled />
</p>
<h2>Kilt Pin - Standard</h2>
<hr>
<p>
  <input name="button4" type="button" id="button4" onClick="document.getElementById('pauseContinueUploadNoStoneSiteHostedPicturesRequest').disabled=false; uploadSiteHostedPicturesNoStoneRequestAjax();" value="UploadNoStonesSiteHostedPicturesRequest" />
</p>
<div id="outputUploadNoStoneSiteHostedPicturesRequest">UploadNoStoneSiteHostedPicturesRequest Output Here</div>
<p>UploadNoStoneSiteHostedPicturesRequest Counter - <span id="counterUploadNoStoneSiteHostedPicturesRequest">0</span></p>
<p>
  <input name="pauseContinueUploadNoStoneSiteHostedPicturesRequest" type="button" id="pauseContinueUploadNoStoneSiteHostedPicturesRequest" onClick="pauseContinueUploadNoStoneSiteHostedPicturesRequest();" value="Pause" disabled />
</p>
<hr>
<p>
  <input name="button4" type="button" id="button4" onClick="createKiltPinNoStoneListingsAjax();" value="Create Formated No Stone (Kilt Pin) Listing Entries in DB" />
</p>
<div id="outputCreateKiltPinNoStoneListings">CreateNoStoneKiltPinListings Output Here</div>
<p>CreateNoStoneKiltPinListings Counter - <span id="counterCreateKiltPinNoStoneListings">0</span></p>
<p>
  <input name="pauseContinueCreateKiltPinNoStoneListings" type="button" id="pauseContinueCreateKiltPinNoStoneListings" onClick="pauseContinueCreateKiltPinNoStoneListing();" value="Pause" disabled />
</p>
<hr>
<p>
  <input name="button4" type="button" id="button4" onClick="document.getElementById('pauseContinueAddItemNoStoneRequest').disabled=false; addItemNoStoneRequestAjax();" value="Add Item No Stones Request - Kilt Pin" />
  Enter No of Listings to generate
  <input type="text" id="kilt_pin_no_stone_listing_qty" name="kilt_pin_no_stone_listing_qty" value="10" size="2" />
</p>
<div id="outputAddItemNoStoneRequest">AddItemNoStoneRequest Output Here</div>
<p>AddItemNoStoneRequest Counter - <span id="counterAddItemNoStoneRequest">0</span></p>
<p>
  <input name="pauseContinueAddItemNoStoneRequest" type="button" id="pauseContinueAddItemNoStoneRequest" onClick="pauseContinueAddItemNoStoneRequest();" value="Pause" disabled />
</p>
<h2>Belt Buckle - Standard</h2>
<hr>
<p>
  <input name="button5" type="button" id="button5" onClick="document.getElementById('pauseContinueUploadBeltBuckleSiteHostedPicturesRequest').disabled=false; uploadBeltBuckleSiteHostedPicturesRequestAjax();" value="UploadBeltBuckleSiteHostedPicturesRequest" />
</p>
<div id="outputUploadBeltBuckleSiteHostedPicturesRequest">UploadBeltBuckleSiteHostedPicturesRequest Output Here</div>
<p>UploadBeltBuckleSiteHostedPicturesRequest Counter - <span id="counterUploadBeltBuckleSiteHostedPicturesRequest">0</span></p>
<p>
  <input name="pauseContinueUploadBeltBuckleSiteHostedPicturesRequest" type="button" id="pauseContinueUploadBeltBuckleSiteHostedPicturesRequest" onClick="pauseContinueUploadBeltBuckleSiteHostedPicturesRequest();" value="Pause" disabled />
</p>
<hr>
<p>
  <input name="button5" type="button" id="button5" onClick="createBeltBuckleListingsAjax();" value="Create Formated (Belt Buckle) Listing Entries in DB" />
</p>
<div id="outputCreateBeltBuckleListings">CreateBeltBuckleListings Output Here</div>
<p>CreateBeltBuckleListings Counter - <span id="counterCreateBeltBuckleListings">0</span></p>
<p>
  <input name="pauseContinueCreateBeltBuckleListings" type="button" id="pauseContinueCreateBeltBuckleListings" onClick="pauseContinueCreateBeltBuckleListings();" value="Pause" disabled />
</p>
<hr>
<p>
  <input name="button5" type="button" id="button5" onClick="document.getElementById('pauseContinueAddItemBeltBuckleRequest').disabled=false; addItemBeltBuckleRequestAjax();" value="Add Item Request - Belt Buckle" />
  Enter No of Listings to generate
  <input type="text" id="belt_buckle_listing_qty" name="belt_buckle_listing_qty" value="10" size="2" />
</p>
<div id="outputAddItemBeltBuckleRequest">AddItemBeltBuckleRequest Output Here</div>
<p>AddItemBeltBuckleRequest Counter - <span id="counterAddItemBeltBuckleRequest">0</span></p>
<p>
  <input name="pauseContinueAddItemBeltBuckleRequest" type="button" id="pauseContinueAddItemBeltBuckleRequest" onClick="pauseContinueAddItemBeltBuckleRequest();" value="Pause" disabled />
</p>
<hr>
<p>&nbsp;</p>
</body>
</html>