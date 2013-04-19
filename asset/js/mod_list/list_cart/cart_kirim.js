$(function(){	
	$('.autosave, .autosave-hidden',form).autosave({interval:5000});
	if ($.cookie("autosave_0_0")) {
		$.fn.autosave.restore();
	}
	
	// cek and get tariff auto from cookies
	var sync_name = $('#destination',form).val(),
			to_code = $('#destination_code',form).val();
			
	if (to_code!=''){
		cek_tariff();
	} else if (sync_name!='') {
		$.post(cart_controller+'/get_lokal_tariff',{'sync_name':sync_name},function(data){
			$('#destination_code',form).val(data);
			cek_tariff();
		});
	}
	
	// FILL USER INFO WITH EMAIL EXISTING
	$('#user_email').bind('blur',function() {	
		var email = $(this).val();
		
		$.manageAjax.destroy('user_email');
		ajaxReq = $.manageAjax.create('user_email', {queue: 'clear', abortOld: true});      
		ajaxReq.add({
			url: cart_controller+'/pull_user_data',
			data: {'user_email':email}, 
			type: 'POST',
			dataType: 'JSON',
			success: function(data) {
				if(data) {
					if(data.user.length > 0) {
						$.each(data.user, function(idx,row) {
							$('#user_fuid',form).val(row.user_fuid);
							$('#user_fb_site',form).val(row.user_fb_site);
							$('#user_nama',form).val(row.user_nama);
							$('#user_alamat',form).val(row.user_alamat);
							$('#user_pobox',form).val(row.user_pobox);
							$('#user_telp',form).val(row.user_telp);
						});
					}
				}
			}
		});
		
	});
});