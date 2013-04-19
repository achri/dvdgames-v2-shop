$(function(){
	//$.metadata.setType("attr", "validate");
	
	var form = $('#fOrder');
	
	form.validate({
		submitHandler: function(vform) {
			var ord = $("#newapi_cart").jqGrid('getDataIDs');
			if (ord.length) {
				dialog_confirm('Apakah Data Anda sudah sessuai?.',function(yes){
					if (yes) {
						$.ajax({
							url: cart_controller+'/proses_order',
							data: form.serialize(),
							type: 'POST',
							success: function(data) {
								if (data) {
									//$.fn.autosave.removeAllCookies();
									$('#tab-cart').tabs("enable", 2).tabs("select", 2); 
									//.tabs('disable', [0,1]); 
									$('#tab-cart').tabs("option", "disabled", [0,1]);
								}
							}
						});
					}
				});
			}	else {
				alert('Belum ada pemesanan DVD !');
			}
		},
		errorClass: "errormessage",
		errorClass: 'error',
		validClass: 'valid',
		rules: {
			"to": {
				required: true,
				minlength: 3
			},
			"order[wilayah][tariff]": {
				required: true
			},
			"order[info][user_nama]": {
				required: true,
				minlength: 3
			},
			"order[info][user_email]": {
				required: true,
				//email: true
			},
			"order[info][user_alamat]": {
				required: true,
				minlength: 10
			}
		},
		messages: {
			"to": {
				required: 'Masukkan Wilayah tujuan pengiriman.',
				minlength: 'Nama Wilayah minimal 3 karakter'
			},
			"order[wilayah][tariff]": {
				required: 'Pilihlah jenis paket pengiriman.'
			},
			"order[info][user_nama]": {
				required: 'Masukkan Nama Anda.',
				minlength: 'Nama Anda minimal 3 karakter'
			},
			"order[info][user_email]": {
				required: 'Masukkan Email Anda.',
				email: 'Format Email salah.'
			},
			"order[info][user_alamat]": {
				required: 'Masukkan Alamat Lengkap tujuan pengiriman.',
				minlength: 'Alamat Anda minimal 10 karakter'
			}
		},
		errorPlacement: function(error, element)
		{
			var elem = $(element),
					qtip_pos = {0:'left center', 1:'right center', 2:'top center', 3:'bottom center'},
					qtip_view = [{
						'left':{ 
							0:qtip_pos[0],
							1:qtip_pos[1]
						},
						'right':{ 
							0:qtip_pos[1],
							1:qtip_pos[0]
						},
						'top':{ 
							0:qtip_pos[2],
							1:qtip_pos[3]
						},
						'bottom':{ 
							0:qtip_pos[3],
							1:qtip_pos[2]
						}
					}],
					qtip_attr = elem.attr('qtip-pos');
				
			if(!error.is(':empty')) {
				elem.filter(':not(.valid)').qtip({
					//overwrite: false,
					content: error,
					position: {
						my: qtip_pos[0],// !elem.attr('qtip-pos')?qtip_pos[0]:qtip_view[qtip_attr][0],
						at: qtip_pos[1],// !elem.attr('qtip-pos')?qtip_pos[1]:qtip_view[qtip_attr][1],
						target: elem,
						container: elem.parent(),
						//viewport: $(window)
					},
					show: {
						event: false,
						ready: true
					},
					hide: {
						event: false
					},
					style: {
						classes: 'ui-tooltip-shadow ui-tooltip-rounded ui-tooltip-youtube' 
						//widget: true
					}
				})
				.qtip('option', 'content.text', error);
			}
			else { 
				elem.qtip('destroy'); 
			}
		},
		highlight: function(element, errorClass, validClass) {
			var elem = $(element);
			elem.addClass('ui-state-error');
		},
		unhighlight: function(element, errorClass, validClass) {
			var elem = $(element);
			elem.removeClass('ui-state-error');
			elem.qtip('destroy');
		},
		success: $.noop
	});
	
});

