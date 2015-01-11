// Main Application.

// Includes
javascriptInclude('javascripts/dataTable.js');
javascriptInclude('javascripts/pageObjects/messagePage.js');
javascriptInclude('javascripts/pageObjects/circlePage.js');
javascriptInclude('javascripts/pageObjects/ledPanelPage.js');
javascriptInclude('javascripts/pageObjects/ledMainPage.js');
javascriptInclude('javascripts/pageObjects/bannerAdminPage.js');
javascriptInclude('javascripts/pageObjects/worldOfIdeasPage.js');

// JavaScript Page Objects.
var messagePage;
var circlePage;

// Initialisation Function / Application Constructor - Called from body onload().
function init()
{
	preloadImages();
	messagePage = new MessagePage();
	circlePage = new CirclePage();
	ledPanelPage = new LedPanelPage();
	ledMainPage = new LedMainPage();
	bannerAdminPage = new BannerAdminPage();
	worldOfIdeasPage = new WorldOfIdeasPage();
}