//$(function() {
	function qtip_dvd_det(selector,pos,target)
	{
		var item_tooltip = $(selector),
				qtip_pos = {0:'right center', 1:'left center', 2:'top center', 3:'bottom center'},
				qtip_view = {
					'left' : {0:qtip_pos[0],1:qtip_pos[1]},
					'right' : {0:qtip_pos[1],1:qtip_pos[0]},
					'top' : {0:qtip_pos[2],1:qtip_pos[3]},
					'bottom' : {0:qtip_pos[3],1:qtip_pos[2]},
				};
		
		dvd_id = item_tooltip.attr('qtip-id');
		if (!dvd_id)
			dvd_id = item_tooltip.attr('id');
		
		item_tooltip.qtip({
			//prerender: true,
			position: {
				my: pos ? qtip_view[pos][0] : qtip_view['left'][0],
				at: pos ? qtip_view[pos][1] : qtip_view['left'][1],
				//target: qtip_dvd,
				container: $('#wrap'),
				viewport: $(window)
			},
			style: {
				classes: 'ui-tooltip-rounded ui-tooltip-shadow dvd-items-tooltips ui-tooltip-dvd', // ui-tooltip-youtube',
				widget: true,
				//width: 500,
				//height: 300,
				//height: false,
				tip: {
					 corner: true,
					 mimic: false,
					 width: 17,
					 height: 40,
					 border: true,
					 offset: 0
				}
			},
			content: {
				attr: 'alt',
				text: 'Loading...',
				title: {
					text: 'DVDGames',
					button: 'Close',
				},
				ajax: {
					url: dvd_controller+'/show_detail_dvd/'+dvd_id, 
					type: 'POST',
					loading: false,
					once: false,
					success: function(data, status) {
						this.set('content.text', data);
					}
				}
			},
			show: {
				event: 'click',
				//target: $('#dvd-box-list li div'),
				solo: true,
				//delay: 1500,
				//ready: true,
				effect: function(offset) {
					$(this).slideDown(100); // "this" refers to the tooltip
				}
			},
			hide: {
				leave: false,
				event: 'unfocus',
				//inactive: 5000,
				fixed: true,
				effect: function(offset) {
					$(this).slideDown(100); // "this" refers to the tooltip
				}
			},
			events: {
				render: function(event, api) {
					//$('button.add-to-cart', api.elements.content).click(api.hide);
				},
				show: function(event, api) {
					// stop all carousel
					item_tooltip.parent().trigger('stop', true);
					// hold home carousel img
					item_tooltip.css({"z-index":"1"}).find('span').slideDown();
					item_tooltip.unbind('mouseleave');
					//caroufredsel_wrapper
					//event.preventDefault(); // Stop it!
				},
				hide: function(event, api) {
					// play all carousel
					item_tooltip.parent().trigger('play', true);
					// unleash home carousel img
					item_tooltip.css({"z-index":"0"}).find('span').slideUp();
					item_tooltip.bind('mouseleave',function(){
						$(this).css({"z-index":"0"}).find('span').slideUp();
					});
				}
			}
		});
		
		if (target===true) {
			item_tooltip.qtip('api').set('position.target', item_tooltip.parent());
		} else if (target != null) {
			item_tooltip.qtip('api').set('position.target', item_tooltip.parents(target));
		}
			
		return;
	}

	function qtip_dvd_detail(selector,pos,target)
	{
		var qtip_dvd = $(selector);
		qtip_dvd.each(function(){
			var item_tooltip = this;
			
			qtip_dvd_det(item_tooltip,pos,target);
		});		
		return false;
	}
	
//});
