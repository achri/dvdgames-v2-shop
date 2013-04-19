
var grid_content = jQuery("#newapi_cart"),
	lastsel,cart_id,temp_dvd_id = new Object();
	
$(function() {

	var grid = grid_content.jqGrid({   
		url: cart_controller+"/get_data",
		editurl: cart_controller+"/set_data",
		colModel: [ 
			{name:"id",key:true,hidden:true,title:false},
			{name:"cart_id",hidden:true,editable:true,title:false},
			{name:"dvd_id",hidden:true,editable:true,title:false},
			{name:"kat_id",hidden:true,title:false},
			{name:"dvd_nama",label:"Nama.DVD",width:200,align:"left",title:false},
			{name:"dvd_jumlah",label:"Jml.DVD",width:40,align:"right",title:false},
			{name:"dvd_jumlah",hidden:true,editable:true,title:false},
			{name:"qty",label:"Pesan.DVD",width:50,align:"right",editable:true,editrules:{edithidden:true,number:true,required:true,minValue:1,maxValue:50},title:false}, 
			{name:"jml_dvd",label:"Total.DVD",width:50,align:"right",title:false},
			{name:"total_harga",label:"Total.Harga",width:85,align:"right",formatter:'currency', formatoptions:{prefix:"Rp. ",thousandsSeparator:","},title:false},	
			{name:"opsi",label:" ",width:20,sortable:false,align:"center",title:false},
		],
		gridComplete: function(){ 
			var id = grid_content.jqGrid('getDataIDs'); 
			for(var i=0;i < id.length;i++){ 
				var cl = id[i],
					cart_id = grid_content.getRowData(cl).cart_id,
					dvd_id = grid_content.getRowData(cl).dvd_id;
					temp_dvd_id[cl] = {'dvd_id':dvd_id};
				de = "<a alt='Delete' style='cursor:pointer' onclick='drop_dvd("+cart_id+","+dvd_id+","+false+");' class='ui-icon ui-icon-trash'></a>"; 
				grid_content.jqGrid('setRowData',cl,{opsi:de});
			}
			cart_id = grid_content.getRowData(cl).cart_id;
		},
		jsonReader : {
			root:"data",
			repeatitems: false
		},
		pager: "#pnewapi_cart", 
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
			var ids = grid_content.jqGrid('getDataIDs'), cart_id;
			for (var i=0;i<ids.length;i++) {
				var id=ids[i];
				var rowData = grid_content.jqGrid('getRowData',id);
				cart_id = rowData.cart_id;
				$('#'+id,grid_content[0]).removeData('qtip')
				.removeClass('jqgrid-qtip')
				.addClass('jqgrid-qtip')
				.qtip({
					content: {
						text: 'Klik disini untuk menambah pesanan.'
					},
					position: {
						my: 'left center',
						at: 'right center',
					},
					show: {
						//solo: true,
						event: 'mouseover'
					},
					hide: {
						event: 'mouseleave unfocus'
					},
					style: {
						classes: 'ui-tooltip-rounded ui-tooltip-shadow ui-tooltip-youtube', 
						widget: true,
					}
				});
			}
						
			if (ids.length) {
				var udata = grid_content.getGridParam('userData');
				if (udata.dvd_games != null)
					$("#t_newapi_cart").html('<table width="100%">'+
						'<thead align="center" valign="bottom" class="ui-widget-header">'+
						'	<tr>'+
						'		<td width="20%" rowspan=2>Jumlah<br>Pesanan</td>'+
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
						'	<tr class="ui-state-hover">'+
						'		<td>'+udata.dvd_games+'<input type="hidden" name="order[summary][qty_total]" value="'+udata.dvd_games+'"/></td>'+
						'		<td>'+udata.dvd_jumlah_tot+'<input type="hidden" name="order[summary][dvd_total]" value="'+udata.dvd_jumlah_tot+'"/></td>'+
						'		<td>Rp.'+inttocurr(udata.dvd_harga)+'<input type="hidden" name="order[summary][dvd_harga]" value="'+udata.dvd_harga+'"/></td>'+
						'		<td>'+udata.bonus_jumlah+'<input type="hidden" name="order[summary][bonus_total]" value="'+udata.bonus_jumlah+'"/></td>'+
						'		<td>Rp.'+inttocurr(udata.bonus_harga)+'<input type="hidden" name="order[summary][bonus_harga]" value="'+udata.bonus_harga+'"/></td>'+
						'		<td>Rp.'+inttocurr(udata.grand_total)+'<input type="hidden" id="grand_total" name="order[summary][grand_total]" value="'+udata.grand_total+'"/><input type="hidden" name="order[cart][cart_id]" value="'+cart_id+'"/></td>'+
						'	</tr>'+
						'</tbody>'+
					'</table>');
				} else $("#t_newapi_cart").html('');
		},
		onSelectRow: function(id) {			
			//var dvd_id = temp_dvd_id[id].dvd_id;	
			grid_content.jqGrid('restoreRow',lastsel); 
			grid_content.jqGrid('editRow',id,true,false,false,false,false,function() {
					grid_content.trigger('reloadGrid');
				}
			);
			lastsel = id;
			
			$('#'+id+'_qty',grid_content[0]).focus().removeData('qtip').qtip({
				content: {
					text: 'Masukkan jumlah pesanan dan tekan enter.'
				},
				position: {
					my: 'bottom center',
					at: 'top center',
				},
				show: {
					//event: 'mousemove',
					ready: true,
					solo: $('.jqgrid-qtip'),
				},
				hide: {
					target: $('.jqgrid-qtip'),
					event: 'click unfocus',
				},
				style: {
					classes: 'ui-tooltip-rounded ui-tooltip-shadow ui-tooltip-youtube', 
					widget: true,
				}
			});				
			return;
		},
		ondblClickRow: function(id){
			return;
		},
		datatype:'json',
		rowNum:5,
		//rowList:[5,10,15,20,30],
		rownumbers:true,
		hiddengrid:false,
		autowidth:true,
		forceFit:true,
		shrinkToFit:true,
		height:'110',
		footerrow : true,
		userDataOnFooter : true,
		toolbar: [true,"bottom"],
	}); 
	
	$("#t_newapi_cart").css({"text-align":"center","height":"62px","width":"99.60%"}).addClass('tfont');
	grid_content.jqGrid('navGrid',"#pnewapi_cart",{search:false,edit:false,add:false,del:false});
	
});