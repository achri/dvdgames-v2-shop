;(function($){
// ROTATE CSS3 by ahrie 2011 implement from css3 tutorial
	/*
	browser: {
		mozilla:	!!$b.mozilla
	,	webkit:		!!$b.webkit || !!$b.safari // webkit = jQ 1.4
	,	msie:		!!$b.msie
	,	isIE6:		!!$b.msie && $b.version == 6
	,	boxModel:	false	// page must load first, so will be updated set by _create
	//,	version:	$b.version - not used
	}
	*/
	
	var dvd_stop=false, 
			run_anim, d_save,
			browser = $.browser;
				
	$.fn.rotateThis = function(status) {
		if (browser.msie) {
			return;
		}
	
		if (status === null) {
			status = true;
		}
	
		var selector = this,
				degrees = 30,i = 0,degreesList = [];
				
		for (i = 0; i < degrees; i++) {
			degreesList.push(i);
		}
				
		// reset degress index ui
		if (!d_save) {
			i = 0;
		} else {
			i = d_save; // continue with save degrees index
		}
			
		if (status){
			if (dvd_stop===false){
				run_anim = setInterval(draw, 1000/degrees);
				dvd_stop = true;
			}
		} else {
			if (dvd_stop){
				clearInterval(run_anim);
				reset();
				dvd_stop = false;
				//dvd_rotate(0);
				//return false;
			}
		}

		function reset() {
			var left = degreesList.slice(0, 1);
			var right = degreesList.slice(1, degreesList.length);
			degreesList = right.concat(left);
		}
		
		function dvd_rotate(deg) {
			return selector.css({
			"transform":"rotate("+deg+"deg)",
			"-ms-transform":"rotate("+deg+"deg)",
			"-moz-transform":"rotate("+deg+"deg)", 
			"-webkit-transform":"rotate("+deg+"deg)", 
			"-o-transform":"rotate("+deg+"deg)" 
			});
		}
				
		function draw() {
			var c, s, e, d = 0;
			void dvd_stop;
			if (i == 0) {
				reset();
			}
			d = degreesList[i];
			c = Math.floor(255/degrees*i);
			s = Math.floor(360/degrees*(d));
			e = Math.floor(360/degrees*(d+1)) - 1;
				
			dvd_rotate(e);
			d_save = d;

			i++;
			if (i >= degrees) {
				i = 0;
			}
		}  	
		
	}
})(jQuery);