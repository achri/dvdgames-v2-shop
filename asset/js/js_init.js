/* 
*	CREATED BY AHRIE 
*	@2011
*/

$(document).ready(function() {
/* MENU LAVALAMP */
	$("#menu ol.lavalamp").lavaLamp({ 
		fx: "easeOutBack", 
		speed: 1000,
		click: function(event, menuItem) {
			var module = $('a',menuItem).attr('module');
			// CALL FUNC MENU AJAX
			if (module != '') {
				menu_ajax(module);
			}
			return false;
		},
		startItem: 0, 
		autoReturn: true,
		returnDelay: 0,
		setOnClick: true,
		//homeTop: 125,
		//homeLeft: 220,
		homeWidth: 0,
		homeHeight: 0,
		returnHome: false,
		image: 'asset/images/layout/dvds_small.png'
	});
	
/* SIDEBAR ACCORDION */
	$("#content-right .accordion").accordion({
		active: 0,
		//collapsible: true,
		//fillSpace: true,
		autoHeight: true,
		//event: "mouseover",
		icons: {
   			header: "ui-icon-circle-arrow-e",
  			headerSelected: "ui-icon-circle-arrow-s"
		},
	});
	
/* SIDEBAR KATEGORI SELECTABLE */
	$('#content-right .selectable-kategori').selectable({
		selected:function(ev,ui){
			var	kat_id = $('.ui-selected',this).attr('id');
			menu_ajax('list_dvd',kat_id);
      return false;
		}
	});
	
/* DVDGAMES HELP UI FUTURED */
	$('#dvd-help').bind('mouseover',function() {
		$(this).removeClass('ui-state-default').addClass('ui-state-hover');
	}).bind('mouseleave',function() {
		$(this).removeClass('ui-state-hover').addClass('ui-state-default');
	}).bind('mousedown',function() {
		//$('#wrap').effect('explode',2000,function(){ $(this).show() });
		$(this).removeClass('ui-state-hover ui-state-default').addClass('ui-state-active');
	}).bind('mouseup',function() {
		$(this).removeClass('ui-state-active').addClass('ui-state-hover ui-state-default');
	});
	
/* SLIDE FOOTER */
	$('#login-pane').toggle(
		function(){
			$('#footer-badge').hide();
			$('#footer-left').animate({width:'464px'},1000,function(){
				$('#login').show();
				$('.footer-login .login-text:eq(0)').text('CLOSE');
				$('#login .cs-im').hide();
				$('#login .cs-email').show();
				$('.lrow1').removeClass('ui-icon-circle-arrow-w').addClass('ui-icon-circle-arrow-e').css('float','right');
				//$('.lrow2').css('float','right');
				
			});
			return false;
		},
		function(){
			$('#login').hide();
			$('#login-im').trigger('click');
			$('#footer-left').animate({width:'95px'},1500,function(){
				$('.lrow1').removeClass('ui-icon-circle-arrow-e').addClass('ui-icon-circle-arrow-w').css('float','left').text('LOGIN');
				//$('.lrow2').css('float','left');
				$('#footer-badge').show();
				$('.footer-login .login-text:eq(0)').text('OPEN');
			});
			return false;
		}
	);
	
	$('#login-im').toggle(
		function(){
			$('.footer-login .login-text:eq(1)').text('CHAT');
			$('#login .cs-email').hide();
			$('#login .cs-im').show();
			return false;
		},
		function(){
			$('.footer-login .login-text:eq(1)').text('EMAIL');
			$('#login .cs-im').hide();
			$('#login .cs-email').show();
			return false;
		}
	);
	
/* HEADER COVER NEW DVD */
	var ajax_new_dvd = $.manageAjax.create('ajax_new_dvd', {});
	ajax_new_dvd.add({
		url: dvd_controller+'/new_dvd',
		type: 'POST',
		success: function(data) {
			if (data) {
				var spl = data.split('|');
				$('.header-dvd-new .new_dvd').attr('qtip-id',spl[0])
				.attr('title',spl[1])
				.attr('src',spl[2])
				.css({'cursor':'pointer'});
				qtip_dvd_detail('.header-dvd-new .new_dvd','bottom');
			}
		}
	});

/* BEST DVD CONTENT FOOTER */
	var ajax_best_dvd = $.manageAjax.create('ajax_best_dvd', {queue: 'clear', abortOld: true});
	ajax_best_dvd.add({
		url: dvd_controller+'/best_dvd/best',
		type: 'POST',
		dataType: 'JSON',
		success: function(data){
			var best_dvd = $('#best-dvd-carousel'), 
					best_dvd_item = '';
					
			$.each(data.dvd,function(row,item){
				best_dvd_item += '<a qtip-id='+item.dvd_id+' class="best-dvd-carousel-items" href="javascript:void(0)" alt="'+item.dvd_nama+'"><img src="'+data.url+'thumb/'+item.dvd_gambar+'" alt="'+item.dvd_nama+'" title="'+item.dvd_nama+'" height="52px"/></a>';
			});
			
			$.fn.carouFredSel.defaults.items.visible = 6;
			best_dvd.html(best_dvd_item);
			$('#best-dvd-carousel .best-dvd-carousel-items').preloader();
			best_dvd.carouFredSel({
				width: best_dvd.parents("#best-dvd-box").innerWidth(),
				height: best_dvd.parents("#best-dvd-box").innerHeight(),
				scroll: {
					items: 1,
					duration: 1000,
					mousewheel: 5,
					pauseOnHover: 'immediate-resume',
				},
				auto: {
					play: true,
					delay: 2000
				},
				prev : "#bdvd-prev",
				next : "#bdvd-next",
			});
			
			qtip_dvd_detail('#best-dvd-carousel .best-dvd-carousel-items','bottom');
			/*
			best_dvd.children().mouseover(function() {
				$(this).effect('zoom');
			}).mouseleave(function(){
				$(this).css({"z-index":"0"});
			}).click(function(){
				qtip_dvd_det(this,'top');
			});
			*/
			return false;
		}
	});	
	
// MOVE FOOTER LAVALAMP
  $("#footer-right a[href^='#']").click(function() {
    var move_to = $(this).attr('module');
    $('ol.lavalamp a[module='+move_to+']').parent().trigger('mouseover').trigger('click');
    return false;
  }); 
	
// BODY UI THEMES
	$('input#body-themes').click(function() {
		var cek = $('input#body-themes:checked').length;
		if (cek > 0) {
			$('body').addClass('ui-widget-header body-ui-themes')
		} else {
			$('body').removeClass('ui-widget-header body-ui-themes').addClass('body-default');
		}
	});
	
// SELECT HOME ON THE FIRST TIME
	//menu_go(0);
	
// PROTECT THE RIGHT CLICK
	protected_menu();

/*
// GOOGLE TRANSLATE (buggy)
	$.translate(function() {
		jQuery('#feed-box').translate('en','id',{
			fromOriginal:true,
			not:'img, .feed-send', 
			//start:function(){jQuery(d).show()},
			//complete:function(){jQuery(d).hide()},
			//error:function(){jQuery(d).hide()},
			async: 500,
			returnAll: true,
			walk: true,
			replace: true
		});
	});	
*/
});