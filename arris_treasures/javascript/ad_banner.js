// JavaScript Document

// banner code

$(function(){
	// $(window).load(fadeOut());
	setInterval("fadeOut()", 7000);
});

$(document).ready(function(){
	$('#middle_banner').click(function(e) {  
    	// fadeOut();
	});
});

function fadeOut() {
	if(bannerIndex == bannerCount-1) {
		bannerIndex = 0;
	} else {
		bannerIndex++;
	}
	var box = $("#middle_banner_content");
	box.fadeTo(600, 0.01, function() {
		// Animation complete.
		$("#banner_image").attr("src", preload[bannerIndex].src);
		fadeIn();
	});
}

function fadeIn() {
	var box = $("#middle_banner_content");
	box.fadeTo(600, 1.0);
}

// end banner code.