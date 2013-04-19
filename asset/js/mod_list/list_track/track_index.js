$(function() {
	var grid_content = jQuery("#newapi_track");
	grid_content.jqGrid({   
		url: track_controller+"/get_data",
		editurl: track_controller+"/set_data",
		postData:{'inv_code':'kosong','tiki_noresi':'kosong'},
		colModel: [ 
			{name:"id",key:true,hidden:true,title:false},
			{name:"inv_id",hidden:true,title:false},
			{name:"inv_tgl",label:"Tgl Invoice",width:110, align: "center",formatter:'date',formatoptions:{srcformat:"Y-m-d H:i:s",newformat:"d-M-Y"},searchoptions:{dataInit:function(el){$(el).datepicker({dateFormat:'yy-mm-dd'});} }},
			{name:"user_nama",label:"Atas Nama"},
			{name:"user_email",label:"Email", align:"center"},
			{name:"user_alamat",hidden:true,title:false},
			{name:"user_pobox",hidden:true,title:false},
			{name:"user_telp",hidden:true,title:false},
			{name:"user_fb_site",hidden:true,title:false},
			{name:"sync_name",hidden:true,title:false},
			{name:"tiki_paket",hidden:true,title:false},
			{name:"tiki_tariff",hidden:true,title:false},
			{name:"tiki_noresi",hidden:true,title:false},
			{name:"grand_total",hidden:true,title:false},
			{name:"grand_total_all",hidden:true,title:false},
			//{name:"grand_total_all",label:"Biaya",width:110, align: "right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","}},
			{name:"inv_status",label:"Status",width:110, align: "center"},
		],
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		pager: "#pnewapi_track", 
		sortname: 'inv_tgl', 
		sortorder: "DESC",
		datatype:'json',
		//rowNum:5,
		//rowList:[5,10,15,20,30],
		rownumbers:false,
		hiddengrid:false,
		//autowidth:true,
		width: '750',
		forceFit:true,
		shrinkToFit:true,
		height:'300',
		//footerrow : true,
		//userDataOnFooter : true,
		toolbar: [true,"top"],
		subGrid: true,
		scroll: true,
		subGridRowExpanded: function(subgrid_id, row_id) {
			var subgrid_table_id = subgrid_id+"_t", 
				pager_id = "p_"+subgrid_table_id,
				inv_data = grid_content.getRowData(row_id);	
			
			$("#"+subgrid_id).html("<table id='"+subgrid_table_id+"'></table><div id='"+pager_id+"'></div>"); 
			
			$("#"+subgrid_table_id).jqGrid({   
				url: cart_controller+"/get_data",
				editurl: cart_controller+"/set_data",
				postData:{'inv_id':inv_data.inv_id},
				colModel: [ 
					{name:"id",key:true,hidden:true,title:false},
					{name:"dvd_nama",label:"Nama.DVD",width:200,align:"left",title:false},
					{name:"qty",label:"Pesan.DVD",width:50,align:"right",editable:true,editrules:{edithidden:true,number:true,required:true,minValue:1,maxValue:50},title:false}, 
					{name:"jml_dvd",label:"Total.DVD",width:50,align:"right",title:false},
					{name:"total_harga",label:"Total.Harga",width:85,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","},title:false},	
				],
				jsonReader : {
					root:"data",
					repeatitems: false
				},
				pager: pager_id, 
				sortname: 'dvd_nama', 
				sortorder: "ASC",
				//viewrecords: true,
				loadError :function(xhr,status, err){ 
					try {
						jQuery.jgrid.info_dialog(jQuery.jgrid.errors.errcap,'<div class="ui-state-error">'+ xhr.responseText +'</div>', jQuery.jgrid.edit.bClose,{buttonalign:'right'});
					} 
					catch(e) { alert(xhr.responseText);} 
				},
		
				loadComplete: function() {
					var ids = $("#"+subgrid_table_id).jqGrid('getDataIDs');
					
					if (ids.length) {
						var udata = $("#"+subgrid_table_id).getGridParam('userData');
						if (udata.dvd_games != null)
							$("#t_"+subgrid_table_id).removeClass('ui-widget ui-state-default ui-widget-header ui-widget-content').html('<table width="100%">'+
								'<thead align="center" valign="bottom" class="ui-state-default">'+
								'	<tr>'+
								'		<td width="10%" rowspan=2>Jumlah<br>Pesanan</td>'+
								'		<td width="30%" colspan=2>DVD</td>'+
								'		<td width="30%" colspan=2>Bonus</td>'+
								'		<td width="20%" rowspan=2>Grand<br>Total</td>'+
								'	</tr>'+
								'	<tr>'+
								'		<td>Jumlah</td>'+
								'		<td>Harga</td>'+
								'		<td>Jumlah</td>'+
								'		<td>Harga</td>'+
								'	</tr>'+
								'</thead>'+
								'<tbody align="center" valign="top">'+
								'	<tr align="right" class="ui-state-hover">'+
								'		<td>'+udata.dvd_games+'</td>'+
								'		<td>'+udata.dvd_jumlah_tot+'</td>'+
								'		<td>Rp.'+inttocurr(udata.dvd_harga)+'</td>'+
								'		<td>'+udata.bonus_jumlah+'</td>'+
								'		<td>Rp.'+inttocurr(udata.bonus_harga)+'</td>'+
								'		<td>Rp.'+inttocurr(udata.grand_total)+'</td>'+
								'	</tr>'+
								'</tbody>'+
								'<tbody align="center" valign="top">'+
								'	<tr class="ui-state-default">'+
								'		<td colspan="3" align="right">'+inv_data.sync_name+' &nbsp;</td>'+
								'		<td align="center">'+inv_data.tiki_paket+'</td>'+
								'		<td align="right">Tarif &nbsp;</td>'+
								'		<td class="ui-state-hover" align="right">Rp.'+inttocurr(inv_data.tiki_tariff)+'</td>'+
								'	</tr>'+
								'</tbody>'+
								'<tbody align="center" valign="top">'+
								'	<tr class="ui-state-hover">'+
								'		<td colspan="5" align="right" class="ui-widget-header">Total Keseluruhan &nbsp;</td>'+
								'		<td align="right" class="ui-state-error"><strong><i>Rp.'+inttocurr(inv_data.grand_total_all)+'</i></strong></td>'+
								'	</tr>'+
								'</tbody>'+
								'<tbody align="center" valign="top">'+
								'	<tr class="ui-state-default">'+
								'		<td colspan="6" align="center" class="ui-widget-header">JNE Tracking</td>'+
								'	</tr>'+
								'	<tr class="">'+
								'		<td colspan="6" align="center" height="100" class="ui-state-hover"><div id="track_jne" align="center"></div></td>'+
								'	</tr>'+
								'</tbody>'+
							'</table>');
							
							// GET TRACK FROM JNE
							if(inv_data.tiki_noresi!='0') {
								var jne_track = $("#t_"+subgrid_table_id+' div#track_jne');
								$.ajax({
									url: track_controller+'/track_jne/'+inv_data.tiki_noresi,
									success: function(data) {
										jne_track.html(data).parents('td').removeClass('preloader');
									},
									beforeSend: function() { jne_track.parents('td').addClass('preloader') }
								});
							} else {
								$("#t_"+subgrid_table_id+' div#track_jne').html('Belum dikirim')
							}
						} else $("#t_"+subgrid_table_id).html('');
						
				},
				gridComplete: function(){ 
					//return;
				},
				onSelectRow: function(id) {						
					//return;
				},
				ondblClickRow: function(id){
					//return;
				},
				
				datatype:'json',
				rowNum:5,
				//rowList:[5,10,15,20,30],
				rownumbers:true,
				hiddengrid:false,
				autowidth:true,
				forceFit:true,
				shrinkToFit:true,
				//height:'110',
				height: 'auto',
				//autoHeight: true,
				footerrow : true,
				userDataOnFooter : true,
				toolbar: [true,"bottom"],
			}); 
			
			$("#t_"+subgrid_table_id).css({"text-align":"center","height":"100%"}).addClass('tfont');
			$("#"+subgrid_table_id).jqGrid('navGrid','#'+pager_id,{search:false,edit:false,add:false,del:false});

		},
		subGridRowColapsed: function(subgrid_id, row_id) { 
			
		}
	});
	
	var toolbar = $("#t_newapi_track");
	
	var email = '', eqs = 2;
	if ($('input#body-themes:checked').length > 0) {
		email = '<td>Email <input id="email" size="10"/></td>';
		eqs = 3;
	}
	
	toolbar.html('<table align="right"><tr>'+email+'<td>No. Invoice <input id="inv_no" size="8" maxlength="6"/></td><td>&nbsp;/&nbsp;</td><td>No. AWB TIKI <input id="tiki_noresi" size="18" maxlength="16"/>&nbsp;</td><td><input id="track_now" type="button" value="Tracking" class="ui-state-error"/></td></tr></table>');
	toolbar.css({"text-align":"center","height":"30px","width":"99.7%"}).addClass('dvd-font-m ui-state-hover ui-corner-tr ui-corner-tl');
	grid_content.jqGrid('navGrid',"#pnewapi_track",{search:false,edit:false,add:false,del:false});
	
	// PROCESS s
	$(':input',toolbar).eq(eqs).click(function() {
		var inv_no = $('#inv_no',toolbar).val(),
				tiki_noresi = $('#tiki_noresi',toolbar).val(),
				email = $('#email',toolbar).val();
		grid_content.jqGrid('setGridParam',{postData:{'inv_code':inv_no,'tiki_noresi':tiki_noresi,'email':email}}).trigger("reloadGrid");
	});
});