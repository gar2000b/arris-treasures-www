// JavaScript Document

// alert('Index gets called');

// Calculate Distance between Lat Long Coords
// http://www.movable-type.co.uk/scripts/latlong.html

// ---- extend Number object with methods for converting degrees/radians
/** Converts numeric degrees to radians */
if (typeof Number.prototype.toRad == 'undefined') {
  Number.prototype.toRad = function() {
    return this * Math.PI / 180;
  }
}

function calculateLatLongDistance(lat1, lon1, lat2, lon2) {
	var R = 6371; // km
	var dLat = (lat2-lat1).toRad();
	var dLon = (lon2-lon1).toRad();
	var lat1 = lat1.toRad();
	var lat2 = lat2.toRad();
	var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
			Math.sin(dLon/2) * Math.sin(dLon/2) * Math.cos(lat1) * Math.cos(lat2);
	var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
	var distanceKm = R * c;
	var distanceMiles = 0.621371192 * distanceKm;
	distanceMiles = distanceMiles.toFixed(2);
	
	alert('Distance based on Lat Long Coords is ' + distanceMiles + ' miles.');
}

// Test Lat Long distance
// calculateLatLongDistance(56.824932, -4.295654, 56.646412, -4.379425);