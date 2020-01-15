initCPanel();
function initCPanel() {
	var $marginRighty = $('.cpanelContainer .boss-themedesign');
	$marginRighty.animate({
		marginLeft: -($marginRighty.outerWidth()-10)
	});
	$marginRighty.addClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_closed" : "cpanel_opened").removeClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_opened" : "cpanel_closed");
}
$('.cpanelContainer .cpanel_icon').click(function() {
	$('.cpanelContainer .boss-themedesign').show(); 
	
	var $marginRighty = $('.cpanelContainer .boss-themedesign');
	$marginRighty.animate({
		marginLeft: parseInt($marginRighty.css('marginLeft'),10) == 0 ? -($marginRighty.outerWidth()-10) : 0
	});
	
	$marginRighty.addClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_closed" : "cpanel_opened").removeClass(parseInt($marginRighty.css('marginLeft'),10) == 0 ? "cpanel_opened" : "cpanel_closed");
});
$(document).ready(function() {
	$('#bt_category').dcAccordion({
		menuClose: false,
		autoClose: true,
		saveState: false,
		disableLink: false,	
		autoExpand: true
	});
});
