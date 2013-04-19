$(function() {     
	$.manageAjax.destroy('ajax_home_dvd');
	var ajax_home_dvd = $.manageAjax.create('ajax_home_dvd', {queue: 'clear', abortOld: true});
	ajax_home_dvd.add({
		url: dvd_controller+'/best_dvd',
		dataType: 'JSON',
		success: function(data){
			carousel_item = '';
			$.each(data.dvd,function(row,item){
				carousel_item += '<div qtip-id='+item.dvd_id+' class="best-dvd-preloader ui-state-hover ui-corner-all"><img height="220px" width="171px" src="'+data.url+'dvd/'+item.dvd_gambar+'" alt="'+item.dvd_nama+'" rating="'+item.dvd_rating+'" dvd_id='+item.dvd_id+'/></div>';
			});
			$('#carousel').html(carousel_item);
			$('#carousel .best-dvd-preloader').preloader();
			
			var jml = data.dvd.length, wrap = $('#carousel').parents("#wrapper"), img_width = $('#carousel div img').innerWidth(),
			vis = 10, img_pos = 9, slide_size = -161, arr_size = {2:94,3:-50,4:-98,5:-121,6:-136,7:-145,8:-152,9:-157,10:-161};
					
			if (jml < 10) {
				vis = jml; img_pos = jml - 1;
				slide_size = arr_size[jml];
			}		
			$('#carousel').css({"margin-right":slide_size+"px"});
			
			$.fn.carouFredSel.defaults.items.visible = vis;
			$('#carousel').carouFredSel({
				width: wrap.parent().innerWidth(),
				height: wrap.innerHeight(),
				align: false,
				padding: [0, img_width, 0, 0],
				items: {
					visible: vis,
					minimum: 1
				},
				scroll: {
					pauseOnHover: 'immediate-resume',
					mousewheel: 1,
					items: 1,
					duration: 1000,
					onBefore: function( oldI, newI ) {
						oldI.add( newI ).find('span').slideUp();
						//oldI.addClass('ui-priority-secondary');
					},
					onAfter: function( oldI, newI ) {
						newI.last().find('span').slideDown();
						//newI.last().removeClass('ui-priority-secondary');
					}
				},
				direction: "right",
				auto: {
					play: true,
					delay: 1000
				},
				onCreate: function() {
					$(this).children().each(function(idx) {
						//$(this).attr('idx-pos',idx);						
						$(this).append( '<span class="ui-widget-content ui-priority-secondary">'+
						'<table height="100%" width="100%"><tr><td valign="middle" align="center"><strong>' + 
						$('img', this).attr('alt') + '</strong></td></tr><tr><td>'+
						'<button class="ui-state-error ui-corner-all show_detail" onclick="" style="cursor:pointer">Detail</button>'+
						'<button class="ui-state-error ui-corner-all" onclick="add_to_cart('+$(this).attr('qtip-id')+')" style="cursor:pointer">Order</button>'+
						//'<img src="asset/images/stars/'+$('img', this).attr('rating')+'.png" width="50"/>'+
						'</td></tr></table></span>' );
						$(this).find('span').hide();
					});
					
					
					//$(this).children().eq(img_pos).removeClass('ui-priority-secondary');
				}
			})
			.children().find('img').click(function() {
				//$('#carousel').trigger( 'slideTo', [$(this).parent(), -(img_pos), 'prev'] );
				qtip_dvd_detail('#carousel .best-dvd-preloader','left');
			});
			
			$('#carousel').children().mouseover(function() {
				$(this).css({"z-index":"1"}).find('span').slideDown();//.removeClass('ui-priority-secondary');
			}).mouseleave(function(){				
				$(this).css({"z-index":"0"}).find('span').slideUp();//.addClass('ui-priority-secondary');
			});
				
			return false;
		}
		
	});
});