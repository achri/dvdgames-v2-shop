function formatItem(row)
{
	return row[0];;
};

function findValueDestination(event,data, formatted)
{
	jQuery("#destination").val(data[0]);
	jQuery("#destination_code").val(data[1]);
	if(jQuery.trim(data[1])=='null'){
		jQuery("#destination").val('');
		jQuery("#destination_code").val('');
	}
	
	if(formatted) {
		cek_tariff();
	}
};

function populate_tariff(data)
{
	var selector = $('#jenis_paket'),
			arrBypass = ['sync_id','destination'];
			
	selector.children().remove();
	
	if (!data) {
		selector.append("<option value=''></option>");
		return false;
	}
	
	$('#sync_id').val(data.sync_id);	
	$('#destination').val(data.destination);	
	$.each(data,function(key,val){
		var pass = $.inArray(key,arrBypass);
		if (pass < 0) {
			selector.append("<option value='"+key+"|"+val+"'>"+key+" (Rp."+inttocurr(val)+")</option>");
		}
	});
		
	selector.attr("disabled",false);
}

function cek_tariff() 
{
	
	if ($('#destination_code').val() != '') {
		var senData = {
					"origin_code" : $('#origin_code').val(),
					"destination" : $('#destination').val(),
					"destination_code" : $('#destination_code').val(),
					"weight" : $('#weight').val()
				};
		
		$.manageAjax.destroy('ajax_get_tariff');
		var ajax_get_dvd = $.manageAjax.create('ajax_get_tariff', {queue: 'clear', abortOld: true});
		ajax_get_dvd.add({
		//$.ajax({
			url: cart_controller+'/get_tariff',
			type: 'POST',
			data: senData,//$('#fOrder').formSerialize(),
			dataType: 'JSON',
			success: function(data) {
				if (data) {
					populate_tariff(data);
				} else {
					alert('Koneksi sibuk, cobalah mengisi ulang wilayah tujuan pengiriman.');
				}
			},
			beforeSend: function(){
				$('.cek-tariff').show();
			},
			complete: function(){
				$('.cek-tariff').hide();
			}
		});
	}
	return false;
};

jQuery(function(){
	jQuery("#weight").attr('autocomplete','off');
	//destination
	jQuery("#destination").qtip({
		content: {
			title: 'Tips Pencarian',
			text: 'Untuk mencari nama Desa/Daerah/Kota berdasarkan nama Kota/Prov/Kabupaten diawali dengan karakter %[nama kabupaten]. Contoh: %SEMARANG atau %KAB.LAMPUNG'
		},
		position: {
			my: 'bottom center',
			at: 'top center'
		},
		hide: {
			event: 'unfocus'
		},
		show: {
			event: 'focus'
		},
		style: {
			classes: 'ui-tooltip-rounded ui-tooltip-shadow ui-tooltip-youtube'
			//widget: true
		}
	})
	.css({'text-transform':'uppercase'})
	.autocomplete(cart_controller+"/autocomplete_tariff",{
		width:200,
		minChars:3, 
		matchSubset:1, 
		matchContains:1, 
		max:50, 
		cacheLength:50, 
		formatItem:formatItem, 
		selectOnly:1, 
		autoFill:false, 
		cleanUrl:false, 
		multiple:true, 
		multipleSeparator:'|', 
		scroll:false
	}).result(findValueDestination).keyup(function(event) {
		var paket = $('#jenis_paket');
		paket.children().remove();
		paket.html('<option value=""></option>');
	}).next().click(function(){});

});