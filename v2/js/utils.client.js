require(['jquery'], function($) {
	function activateMenuItem(item) {
		
		$('.nav li').removeClass('active');
    	$('#'+item).addClass('active');
	}
	
	return {
		activateMenuItem: activateMenuItem
	}
	
});