// CONTROLLER ROUTE
var dvd_controller = 'index.php/mod_list/list_dvd',
		cart_controller = 'index.php/mod_list/list_cart',
		track_controller = 'index.php/mod_list/list_tracking';

var main_controller = 'dvdgames_online';

/* MENU AJAX */
function menu_ajax(module, op_id) {
	var controller,
			mod_class = module.split('_');
	
	if (!op_id) {
		op_id = 0;
	}	else {
		$('ol.lavalamp a[module='+module+']').trigger('mouseover');
	}
	
	switch (module) {
		case 'home':
			controller = 'index.php/home';
			load_cart();
		break;
		case 'dvd_detail':
			controller = 'index.php/mod_list/list_dvd/show_detail_dvd/'+op_id;
			load_cart();
		break;
		default:
				controller = 'index.php/mod_'+mod_class[0]+'/'+module+'/index/'+op_id;
			//controller = 'index.php/mod_'+mod_class[0]+'/'+module;
		break;
	}
	
	//mod_class[1] //module type
	
	// LOAD AJAX HTML
	//$.manageAjax.destroy('user_email');
	var ajax_menu = $.manageAjax.create('ajax_menu', {queue: 'clear', abortOld: true});
	ajax_menu.add({
		url: controller,
		type: 'POST',
		success: function(data) {
			switch(mod_class[1]) {
				case 'cart' : $('#content-full').html(data).show(); $('#content').hide();  break;
				case 'tracking' : $('#content-full').html(data).show(); $('#content').hide();  break;
				default : $('#content-left .content-view').html(data); $('#content').show(); $('#content-full').hide(); break;
			}
		}
	});
}

/* TRIGGER THE MENULAVA ITEM */
function menu_go(idx) {		
	$('ol.lavalamp a:eq('+idx+')').trigger('mouseover').trigger('click');
}
