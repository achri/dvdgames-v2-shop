/*** STANDAR AJAX PAGINATION ***/
$(function() {
	var set_page,
			tot_page = $('#dvd-page-total').val(),
			page = $('#dvd-page').val(),
			tOut;
			
	function pagina() {
		if (Number(page) > 0){
			$('a.ui-icon-seek-start').show();
			$('a.ui-icon-seek-prev').show();
		} else {
			$('a.ui-icon-seek-start').hide();
			$('a.ui-icon-seek-prev').hide();
		}
			
		if (Number(page) < Number(tot_page)) {
			$('a.ui-icon-seek-next').show();
			$('a.ui-icon-seek-end').show();
		} else {
			$('a.ui-icon-seek-next').hide();
			$('a.ui-icon-seek-end').hide();
		}
		
	}

	$('a.pagina.ui-icon').click(function() {
		var type = $(this),condition = false;
		
		if (type.hasClass('ui-icon-seek-start')) {
			set_page = 1;
			condition = true;
		}
		else if (type.hasClass('ui-icon-seek-next')){
			if (Number(page) < Number(tot_page)) {
				set_page = Number(page) + 1;
				condition = true;
			}
		}
		else if (type.hasClass('ui-icon-seek-prev')){
			if (Number(page) > 1) {
				set_page = Number(page) - 1;
				condition = true;
			}
		}
		else if (type.hasClass('ui-icon-seek-end')) {
			set_page = Number(tot_page);
			condition = true;
		}
			
		if (condition) {
			$('#dvd-page').val(set_page);
			get_dvd();
		}
		
		return false;
	});
	/*** END ***/

	/*** MOUSE WHELL LIST PAGINATION ***/
	$('#dvd-box').mousewheel(function(obj,idx){
		var condition = false;
		if (Math.ceil(idx) <= 0) {
			if (Number(page) > 1) {
				set_page = Number(page) - 1;
				condition = true;
			}
		} else {
			if (Number(page) < Number(tot_page)) {
				set_page = Number(page) + 1;
				condition = true;
			}
		}
		if (condition) {
			$('#dvd-page').val(set_page);
			get_dvd();
		}
		return false;
	});
	/*** END ***/

	/*** RETIVE DVD LIST ***/
	function get_dvd() {         
		var post_data = {
					'kat_id' : $('#kat_id').val(),
					'dvd_nama' : $('#dvd_nama').val(),
					'page' : $('#dvd-page').val()
				};
				
		$.manageAjax.destroy('ajax_get_dvd');
		var ajax_get_dvd = $.manageAjax.create('ajax_get_dvd', {queue: 'clear', abortOld: true});
		ajax_get_dvd.add({
		//$.ajax({
			url: dvd_controller+'/index',
			type: 'POST',
			data: post_data,
			success: function(data) {
				$('.content-view').html(data);
			}
		});
		return false;
	}

	/*
	// AUTO HIDE PANEL NAVIGATION
	$('.content-ajax-sub').bind("mouseenter",function(){
		$('#list-dvd-nav').effect('slide',{direction: 'up', mode: 'show'},500);
	}).bind("mouseleave",function(){
		$('#list-dvd-nav').effect('slide',{direction: 'up', mode: 'hide'},500);
	});
	*/
	
	$('#kat_id').change(function() {
		$('#dvd_nama').val('').focus();
		$('#dvd-page').val(1);
		get_dvd();
	});
	
	$('#dvd_nama, #dvd-page').keyup(function(event) {
		if ($(this).val() != '') {
			clearTimeout(tOut);
			tOut = window.setTimeout(get_dvd,1000);
		}
	}); 

	//detail dvd
	qtip_dvd_detail('#dvd-box-list .dvd-preloader img','left','li');
	
	pagina();
	$('.dvd-preloader').preloader();
	$('#dvd_nama').focus();	
});