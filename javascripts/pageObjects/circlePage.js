// Circle Page Object.

// Includes
javascriptInclude('javascripts/utilityObjects/circle.js');

// Circle Page Object Constructor
function CirclePage()
{
	// Members
	this.circle = new Circle();
	
	// Object methods declarations.
	// This function calculates the area of the circle - works out from radius..
	this.calculateArea = function()
	{
		this.circle.setRadius(2);
		var circle = document.getElementById("circle");
		circle.innerHTML = "<p>Circle radius is set to " + this.circle.getRadius() + ".</p>";
		circle.innerHTML += "<p>Diameter of circle is " + this.circle.calculateDiameter() + ".</p>";
		circle.innerHTML += "<p>Circumference of circle is " + (Math.round(this.circle.calculateCircumference() * 10000) / 10000) + ".</p>";
		circle.innerHTML += "<p>Area of circle is " + (Math.round(this.circle.calculateArea() * 10000) / 10000) + " squared.</p>";
	};
	
	// Construction code.
}