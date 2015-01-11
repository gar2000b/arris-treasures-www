<?php

error_reporting(E_ALL);  // Turn on all errors, warnings, and notices for easier debugging

// API request variables
$endpoint = 'http://open.api.sandbox.ebay.com/shopping?';  // URL to call
// $query = 'kilt pin padon';                  // Supply your own query keywords as needed

// Construct the findItemsByKeywords POST call
// Load the call and capture the response returned by the eBay API
// The constructCallAndGetResponse function is defined below
$resp = simplexml_load_string(constructPostCallAndGetResponse($endpoint));

// Check to see if the call was successful, else print an error
/*
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
*/

?>

<!-- Build the HTML page with values from the call response -->
<html>
<head>
<title>eBay Search Results for <?php echo $query; ?></title>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
</head>
<body>

<h1>eBay Search Results for GeteBayTimeRequest</h1>

<table>
<tr>
  <td>
    <?php echo "Results Here: "; ?>
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

function constructPostCallAndGetResponse($endpoint) {
  global $xmlrequest;
  global $responsexml;

  // Create the XML request to be POSTed
  $xmlrequest  = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
  $xmlrequest .= "<GeteBayTimeRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">\n";
  $xmlrequest .= "</GeteBayTimeRequest>";
  
  // Set up the HTTP headers
  $headers = array(
    'X-EBAY-API-APP-ID:Digilogu-5bba-4e60-b088-5926316e6c3a',
    'X-EBAY-API-VERSION:697',
    'X-EBAY-API-SITE-ID:0',
    'X-EBAY-API-CALL-NAME:GeteBayTime',
    'X-EBAY-API-REQUEST-ENCODING:XML',
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