// Object.

// Circle Object Constructor
function Circle()
{
	// Members.
	this.radius = 1;
	this.diameter;
	this.circumference;
	this.area;
	
	// Object getter & setter method declarations.
	this.getRadius = function(){ return this.radius; };
	this.setRadius = function(radiusIn){ this.radius = radiusIn; };
	this.getDiameter = function(){ return this.diameter; };
	this.setDiameter = function(diameterIn){ this.diameter = diameterIn; };
	this.getCircumference = function(){ return this.circumference; };
	this.setCircumference = function(circumferenceIn){ this.circumference = circumferenceIn; };
	this.getArea = function(){ return this.area; };
	this.setArea = function(areaIn){ this.area = areaIn; };
	
	// Object utility method declarations.
	this.calculateDiameter = function()
	{
		this.diameter = (2 * this.radius);
		return this.diameter;
	}
	
	this.calculateArea = function()
	{
		this.area = (Math.PI / 4) * ((this.radius * 2) * (this.radius * 2));
		// this.area = Math.PI * Math.pow(this.radius, 2);
		return this.area;
	};
	
	this.calculateCircumference = function()
	{
		this.circumference = (Math.PI * (2 * this.radius));
		return this.circumference;
	}
	// Construction code.
}