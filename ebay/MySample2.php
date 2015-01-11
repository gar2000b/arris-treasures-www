<?php

error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging

// API request variables
$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
$query = 'kilt pin padon';                  // Supply your own query keywords as needed

// Create a PHP array of the item filters you want to use in your request
$filterarray =
  array(
    array(
    'name' => 'MaxPrice',
    'value' => '25',
    'paramName' => 'Currency',
    'paramValue'  => 'USD'),
    array(
    'name' => 'FreeShippingOnly',
    'value' => 'true',
    'paramName' => '',
    'paramValue'  => ''),
    array(
    'name' => 'ListingType',
    'value' => array('AuctionWithBIN','FixedPrice','StoreInventory'),
    'paramName' => '',
    'paramValue'  => ''),
  );
  
// Generates an XML snippet from the array of item filters
function buildXMLFilter ($filterarray) {
  global $xmlfilter;
  // Iterate through each filter in the array
  foreach ($filterarray as $itemfilter) {
    $xmlfilter .= "<itemFilter>\n";
    // Iterate through each key in the filter
    foreach($itemfilter as $key => $value) {
      if(is_array($value)) {
        // If value is an array, iterate through each array value
        foreach($value as $arrayval) {
          $xmlfilter .= " <$key>$arrayval</$key>\n";
        }
      }
      else {
        if($value != "") {
          $xmlfilter .= " <$key>$value</$key>\n";
        }
      }
    }
    $xmlfilter .= "</itemFilter>\n";
  }
  return "$xmlfilter";
} // End of buildXMLFilter function

// Build the item filter XML code
buildXMLFilter($filterarray);

// Construct the findItemsByKeywords POST call
// Load the call and capture the response returned by the eBay API
// The constructCallAndGetResponse function is defined below
$resp = simplexml_load_string(constructPostCallAndGetResponse($endpoint, $query, $xmlfilter));

// Check to see if the call was successful, else print an error
if ($resp->ack == "Success") {
  $results = '';  // Initialize the $results variable

  // Parse the desired information from the response
  foreach($resp->searchResult->item as $item) {
    $pic   = $item->galleryURL;
    $link  = $item->viewItemURL;
    $title = $item->title;

    // Build the desired HTML code for each searchResult.item node and append it to $results
    $results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td></tr>";
  }
}
else {  // If the response does not indicate 'Success,' print an error
  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
  $results .= "AppID for the Production environment.</h3>";
}

?>

<!-- Build the HTML page with values from the call response -->
<html>
<head>
<title>eBay Search Results for <?php echo $query; ?></title>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
</head>
<body>

<h1>eBay Search Results for <?php echo $query; ?></h1>

<table>
<tr>
  <td>
    <?php echo $results;?>
  </td>
</tr>
</table>
<p>Request</p>
<pre><?php echo htmlentities($xmlrequest);?></pre>
<p>Response</p>
<pre><?php echo htmlentities($responsexml);?></pre>
</body>
</html>

<?php

function constructPostCallAndGetResponse($endpoint, $query, $xmlfilter) {
  global $xmlrequest;
  global $responsexml;

  // Create the XML request to be POSTed
  $xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlrequest .= "<findItemsByKeywordsRequest xmlns=\"http://www.ebay.com/marketplace/search/v1/services\">\n";
  $xmlrequest .= "<keywords>";
  $xmlrequest .= $query;
  $xmlrequest .= "</keywords>\n";
  $xmlrequest .= $xmlfilter;
  $xmlrequest .= "<paginationInput>\n  <entriesPerPage>3</entriesPerPage>\n</paginationInput>\n";
  $xmlrequest .= "</findItemsByKeywordsRequest>";
  
  // Set up the HTTP headers
  $headers = array(
    'X-EBAY-SOA-OPERATION-NAME: findItemsByKeywords',
    'X-EBAY-SOA-SERVICE-VERSION: 1.3.0',
    'X-EBAY-SOA-REQUEST-DATA-FORMAT: XML',
    'X-EBAY-SOA-GLOBAL-ID: EBAY-GB',
    'X-EBAY-SOA-SECURITY-APPNAME: Digilogu-8335-4f13-a866-a6c01477db29',
    'Content-Type: text/xml;charset=utf-8',
  );
  
  $session  = curl_init($endpoint);                       // create a curl session
  curl_setopt($session, CURLOPT_POST, true);              // POST request type
  curl_setopt($session, CURLOPT_HTTPHEADER, $headers);    // set headers using $headers array
  curl_setopt($session, CURLOPT_POSTFIELDS, $xmlrequest); // set the body of the POST
  curl_setopt($session, CURLOPT_RETURNTRANSFER, true);    // return values as a string, not to std out
  
  $responsexml = curl_exec($session);                     // send the request
  curl_close($session);                                   // close the session
  return $responsexml;                                    // returns a string

}  // End of constructPostCallAndGetResponse function

?>