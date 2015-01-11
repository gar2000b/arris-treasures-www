// JavaScript Document
// http://maps.googleapis.com/maps/api/geocode/json?address=G741DD&sensor=false

function processJson() {
	var JSONObject = {
	   "results" : [
		  {
			 "address_components" : [
				{
				   "long_name" : "36",
				   "short_name" : "36",
				   "types" : [ "street_number" ]
				},
				{
				   "long_name" : "Kittoch Street",
				   "short_name" : "Kittoch St",
				   "types" : [ "route" ]
				},
				{
				   "long_name" : "East Kilbride",
				   "short_name" : "East Kilbride",
				   "types" : [ "locality", "political" ]
				},
				{
				   "long_name" : "South Lanarkshire",
				   "short_name" : "South Lanarkshire",
				   "types" : [ "administrative_area_level_3", "political" ]
				},
				{
				   "long_name" : "South Lanarkshire",
				   "short_name" : "South Lanarkshire",
				   "types" : [ "administrative_area_level_2", "political" ]
				},
				{
				   "long_name" : "Scotland",
				   "short_name" : "Scotland",
				   "types" : [ "administrative_area_level_1", "political" ]
				},
				{
				   "long_name" : "United Kingdom",
				   "short_name" : "GB",
				   "types" : [ "country", "political" ]
				},
				{
				   "long_name" : "G74",
				   "short_name" : "G74",
				   "types" : [ "postal_code_prefix", "postal_code" ]
				},
				{
				   "long_name" : "Glasgow",
				   "short_name" : "Glasgow",
				   "types" : [ "postal_town" ]
				}
			 ],
			 "formatted_address" : "36 Kittoch Street, East Kilbride, South Lanarkshire G74, UK",
			 "geometry" : {
				"location" : {
				   "lat" : 55.7658132,
				   "lng" : -4.1768205
				},
				"location_type" : "ROOFTOP",
				"viewport" : {
				   "northeast" : {
					  "lat" : 55.76716218029149,
					  "lng" : -4.175471519708498
				   },
				   "southwest" : {
					  "lat" : 55.7644642197085,
					  "lng" : -4.178169480291502
				   }
				}
			 },
			 "types" : [ "street_address" ]
		  }
	   ],
	   "status" : "OK"
	}
	;
	
	document.getElementById("lat").innerHTML=JSONObject.results[0].geometry.location.lat
	document.getElementById("long").innerHTML=JSONObject.results[0].geometry.location.lng
}

function getLatLongFromAddress() {
	var postcode = document.getElementById("postcode").value;
	$(document).ready(function () {
		$.ajax({ 
			type: 'GET', 
			url: 'http://maps.googleapis.com/maps/api/geocode/json?address=' + postcode + '&sensor=false', 
			data: { get_param: 'value' }, 
			success: function (data) { 
				document.getElementById("lat").innerHTML = data.results[0].geometry.location.lat;
				document.getElementById("long").innerHTML = data.results[0].geometry.location.lng;
			}
		});
	});
}