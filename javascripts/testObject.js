// JavaScript Document

function userobject(parameter)
{
	this.parameter = parameter;
	this.callme = callme;
	this.callobject = callobject;
}

function callme(value)
{
	alert("I have been called with value of " + value);
}

function callobject()
{
	return this.parameter;
}