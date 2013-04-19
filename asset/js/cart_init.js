
/*** ADD TO CART ***/
function add_to_cart(dvd_id) {
	var cart_status = $.cookie('cart_status');
	if (cart_status == 1) {  
		dialog_confirm('Invoice terakhir belum dikonfirmasi.',function(yes){ if(yes) menu_go(2);});
	} else {
		$.manageAjax.destroy('ajaxAddCart');
		var ajaxAddCart = $.manageAjax.create('ajaxAddCart', {
			queue: 'clear', 
			//maxRequests: 2, 
			abortOld: true,
			//cacheResponse: true, 
			//preventDoubleRequests: false
		});
		
		ajaxAddCart.add({
		//$.ajax({
			url: cart_controller+'/add_to_cart/'+dvd_id,
			type: 'POST',
			success: function(data) {
				load_cart(dvd_id);
				load_cart();
			}
		});
	}
	return false;
}
/*** END ***/

function drop_dvd(cart_id,dvd_id,type){
	dialog_confirm('DVD pesanan ini akan dibatalkan?',function(yes){
		if(yes){
			$.manageAjax.destroy('ajax_drop_cart');
			var ajax_drop_cart = $.manageAjax.create('ajax_drop_cart', {queue: true});
			ajax_drop_cart.add({
			//$.ajax({
				url : cart_controller+'/drop_from_cart/'+cart_id+'/'+dvd_id,
				success: function(data){
					if (data) {
						if (type) {
							load_cart();
						} else {
							$("#newapi_cart").trigger('reloadGrid');
						}
					}
				}
			});
		}
	});
	return false;
}

function load_cart(dvd_id) { 	
	$.manageAjax.destroy('ajax_load_cart');
	var ajax_load_cart = $.manageAjax.create('ajax_load_cart', {queue: 'clear', abortOld: true});
	ajax_load_cart.add({
	//$.ajax({
		url : cart_controller+'/cart_sidebar',
		success: function(data){
			var cart_content = $('#cart-list');
			cart_content.html(data);
			
			if (data) {
				// colaps the accordion to cart content
				var accordion_content = cart_content.parents('div.accordion'),
						accordion_select = accordion_content.accordion( "option", "active" );
				
				if (accordion_select != 0) {
					accordion_content.accordion("activate", 0);
				}
				// end
				
				if (data && dvd_id) {
					$('table#cart-items').parent().scrollTo('a[id='+dvd_id+']',500,{ easing:'swing', queue:true, axis:'xy'});
					$('table#cart-items a[id='+dvd_id+']').parents('tr').effect("pulsate", {}, 2000);
				}
								
				qtip_dvd_detail('#cart-list table#cart-items tr','right','#cart-list');
			}
		}
	});
	return false;
}

$(function() {
	//load_cart();
});