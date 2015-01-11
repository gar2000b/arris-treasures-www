// Page Object.

// Includes
// javascriptInclude('javascripts/utilityObjects/utility.js');

// Page Object Constructor
function LedPanelPage()
{
	// Members
	this.count = 0;
	this.led_div_red;
	this.led_div_green;
	this.index = 4;
	this.ranNum = 0;
	this.currentElement = null;
	
	// Object methods declarations.
	this.initLedPanel = function()
	{
		this.led_div_red = document.getElementById("led_div_red");
		this.led_div_green = document.getElementById("led_div_green");
		this.led_div_green.style.zIndex = 2;
		this.led_div_red.style.zIndex = 1;
	};
	
	this.randomNumber = function(limit)
	{
	  return Math.floor(Math.random()*limit);
	};
	
	this.randomTest = function()
	{
		var num = 0;
		for(i = 0; i < 10000; i++)
		{
			num = num + this.randomNumber(3);
		}
		alert("Number is " + num);
	};
	
	this.renderPanel = function()
	{
		for(var i = 0; i < 400; i++)
		{
			this.ranNum = this.randomNumber(3);
			switch(this.ranNum)
			{
				case 0:
				this.currentElement = document.getElementById("led_blue_" + i);
				break;
				case 1:
				this.currentElement = document.getElementById("led_green_" + i);
				break;
				case 2:
				this.currentElement = document.getElementById("led_red_" + i);
				break;
			}
			this.currentElement.style.zIndex = this.index;
			this.index = this.index + 1;
		}
		setTimeout("ledPanelPage.renderPanel()", 1);
	};
	
	this.render = function()
	{
		for(var i = 0; i < 10001; i++)
		{
			if(parseInt(this.led_div_red.style.zIndex) < parseInt(this.led_div_green.style.zIndex))
			{
				this.led_div_red.style.zIndex = parseInt(this.led_div_red.style.zIndex) + 1;
			}
			else
			{
				this.led_div_green.style.zIndex = parseInt(this.led_div_green.style.zIndex) + 1;
			}
			this.count++;
		}
		// var count = document.getElementById("count");
		// count.innerHTML = this.count;
		alert("Finished and count is " + this.count);
	}
	
	this.toggle = function()
	{
		// var led_div_red = document.getElementById("led_div_red");
		// var led_div_green = document.getElementById("led_div_green");
		if(parseInt(this.led_div_red.style.zIndex) < parseInt(this.led_div_green.style.zIndex))
		{
			this.led_div_red.style.zIndex = parseInt(this.led_div_red.style.zIndex) + 1;
		}
		else
		{
			this.led_div_green.style.zIndex = parseInt(this.led_div_green.style.zIndex) + 1;
		}
	}
	
	this.redUp = function()
	{
		var led_div_red = document.getElementById("led_div_red");
		led_div_red.style.zIndex = parseInt(led_div_red.style.zIndex) + 1;
		alert("Red Down Called and is " + led_div_red.style.zIndex);
	};
	
	this.redDown = function()
	{
		var led_div_red = document.getElementById("led_div_red");
		led_div_red.style.zIndex = parseInt(led_div_red.style.zIndex) - 1;
		alert("Red Down Called and is " + led_div_red.style.zIndex);
	};
	
	this.greenUp = function()
	{
		var led_div_green = document.getElementById("led_div_green");
		led_div_green.style.zIndex = parseInt(led_div_green.style.zIndex) + 1;
		alert("Green Up Called and is " + led_div_green.style.zIndex);
	};
	
	this.greenDown = function()
	{
		var led_div_green = document.getElementById("led_div_green");
		led_div_green.style.zIndex = parseInt(led_div_green.style.zIndex) - 1;
		alert("Green Down Called and is " + led_div_green.style.zIndex);
	};
	
	// Construction code.
}