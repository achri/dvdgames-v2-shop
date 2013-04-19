var cart_tab = $('#tab-cart'),
		form = $('#fOrder');

function order_proses() {
	$('#fOSubmit').trigger('click');
	return false;
}

function order_konfirm() {
	if ($('#order-agree:checked').length > 0) {
		$.post(cart_controller+'/order_konfirmasi', function(data){
			$('#content-full').html();
			menu_go(0);
			dialog_alert('Konfirmasi Invoice No.'+data+' Selesai. Untuk rincian pesanan anda, silahkan masuk ke menu tracking atau email anda. Terimakasih.');
		});
	} else {
		dialog_alert('Anda belum menyetujui mengkonfirmasi pemesanan ini.');
	}
	return false;
}

$(function(){	
	cart_tab.tabs();
	cart_tab.bind('tabsselect', function(event, ui) {
		var tab_idx = ui.index;
		tab_idx++; // prevent null/nill output
		switch(tab_idx) {
			case 1: 
				$('#next').removeAttr('onClick').val('Lanjut Proses '+ (tab_idx+1));
				$('#order-ubah, #order-batal').hide();
			break;
			case 2:
				$('#next').attr('onClick','order_proses();').val('Lanjut Proses '+ (tab_idx+1));
				$('#order-ubah, #order-batal').hide();
			break;
			case 3:
				$('#next').attr('onClick','order_konfirm();').val('KONFIRMASI PEMESANAN');
				$('#order-ubah, #order-batal').show();
			break;
		}
	});
	
	if ($.cookie('cart_status') != 1) {
		cart_tab.tabs("select", 0).tabs('disable', 2)
	} else {
		cart_tab.tabs("select", 2).tabs("option", "disabled", [0,1]);
	}
	
	// Button Next
	$('#next').bind('click',function(){
		var tab_pos = cart_tab.tabs('option', 'selected');
		cart_tab.tabs( 'select' , tab_pos + 1 );
	});
	
	// Ubah Order
	$('#order-ubah').bind('click',function(){
		$.post(cart_controller+'/order_kembali',function(){
			menu_go(2);
		});
	});
	
	// Batal Order
	$('#order-batal').bind('click',function(){
		dialog_confirm('Anda yakin akan membatalkan pemesanan ini ?.',function(yes){
			if (yes) {
				dialog_confirm('Apakah Anda setuju ?.',function(yes){
					if (yes) {
						$.post(cart_controller+'/order_batal_all',function(data){
							menu_go(0);
							dialog_alert('Order pemesanan berhasil dibatalkan.');
						});
					}	
				});
			}
		});
	});
	
});