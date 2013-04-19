$(function() {
	var page_ready = $(document).ready();
	
	//AJAX LOADING
	var loader = $('<span style="position:relative; margin-left:10px; z-index:10; color:white; text-align:center;"><img src="asset/images/layout/progressbar_microsoft.gif" height="10"></span>')
		.appendTo("#slogan")
		.hide();
	var error = $('<span style="position:relative; margin-left:10px; z-index:10; color:white; text-align:center;">.:: halaman tidak tersedia ::.</span>')
		.appendTo("#slogan")
		.hide();
	
/* AJAX HANDLING */
	var logo_dvd = $('.logo-dvd img, #imageLava');
	$('*').ajaxStart(function() {
		error.hide();
		logo_dvd.rotateThis(true);
	})
	.ajaxStop(function() {
		//if(first) {
		//	first=false;
		//	first_run();
		//}	
		//wrap_loading(false)
		if(page_ready)
			logo_dvd.rotateThis(false);
	})
	.ajaxSend(function(evt, request, settings) {
		logo_dvd.rotateThis(true);
	})
	.ajaxComplete(function(request, settings){
		//wrap_loading(false)
	})
	.ajaxSuccess(function(evt, request, settings){
		error.hide();
		if(page_ready)
			logo_dvd.rotateThis(false);
	})
	.ajaxError(function(event, request, settings) {
		error.show();
		//wrap_loading(false)
		logo_dvd.rotateThis(false);
	});
	
});