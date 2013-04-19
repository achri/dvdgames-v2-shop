
	var autoYouTubeThumb = ['default','hqdefault'];//set to '0', '1', '2', '3', or 'default' to automatically grab the YouTube thumbnail
	var protocol = (document.location.protocol == 'https:') ? 'https://' : 'http://';

	function set_info() {
		$('.youtube-auto-thumbnails a[title]').removeData('qtip').qtip({
			position: {
				my: 'top center',
				at: 'bottom center',
				container: $('.ui-tooltip-content'),
				viewport: $(window)
			},
		});
		return false;
	}

	function set_youtube_player() {
		$('.youtube-auto-thumbnails img[vid*="youtube."]').each(function(){
			var videoID = $(this).attr('vid').match(/watch\?v=(.+)+/);
			videoID = videoID[1] + $.fn.qtip.nextid;
			
			$(this).removeData('qtip').qtip(
			{
				content: {
					text: $('<div />', { id: videoID }),
					title: {
							text: 'Youtube',
							button: 'Close',
					},
				},
				position: {
					at: 'bottom center',
					my: 'top center',
					//container: $('.ui-tooltip-content'),
					viewport: $(window)
				},
				show: {
					modal: {
						on: true,
						blur: false,
						escape: false
					},
					event: 'click',
					//solo: true,
					effect: function() {
						var style = this[0].style;
						style.display = 'none';
						setTimeout(function() { style.display = 'block'; }, 1);
					}
				},
				hide: 'unfocus',
				style: {
					classes: 'ui-tooltip-rounded ui-tooltip-shadow', // ui-tooltip-youtube', 
					widget: true,
					width: 350,
					tip: {
						corner: true,
						mimic: false,
						width: 15,
						height: 25,
						border: true,
						offset: 0
					}
				},
				events: {
					render: function(event, api) {
						new YT.Player(videoID, {
							playerVars: {
								autoplay: 1,
								enablejsapi: 1,
								origin: document.location.host
							},
							origin: document.location.host,
							height: 180,
							width: 260,
							videoId: videoID.substr(0, 11), 
							events: {
								'onReady': function(e) {
									api.player = e.target;
								},
							}
						});
					},
					show: function(event, api) { 
						$('.youtube-auto-thumbnails').trigger('stop', true);
					},
					hide: function(event, api){
						if(api.player && api.player.stopVideo) {
							api.player.stopVideo();
							api.player.clearVideo();
							$('.youtube-auto-thumbnails').trigger('play',true);
						}
					}
				}
			}).click(false);
			$.fn.qtip.plugins.modal.zindex = 99999;

		});
		return false;
	}

	function search_youtube(name,start,max){	
		var playlist = "https://gdata.youtube.com/feeds/api/playlists/snippets",
				videos = "http://gdata.youtube.com/feeds/api/videos",
				ajaxReq, max_item;
				
		if (!start) start = 1;
		if (!max) max = 10;
		
		$.manageAjax.destroy('youtubes');
		ajaxReq = $.manageAjax.create('youtubes', {});                
		//ajaxReq.add({
		$.ajax({
			url: "http://gdata.youtube.com/feeds/api/videos?q="+name+"&start-index="+start+"&max-results="+max+"&v=2&alt=jsonc", //&rel=1&alt=json
			dataType: 'JSON',
			async: false,
			success: function(results){				
				if (results)
				{
					var result = results.data;
					max_item = result.totalItems;
					if (max_item > 0) 
					{
						var youtube_items = '',
								youtube_video = $('.youtube-auto-thumbnails'),
								svid,sname,rating,good,bad;
						
						$.each(result.items, function(i,item){
							svid = item.player.default, vid = svid.split("&"), parm = vid[0].split('v=')[1].split('&')[0];
							sname = item.title;
							
							youtube_items += "<div style='cursor:pointer;' class='youtube_items' title='"+sname+"' alt='"+sname+"'><img vid='"+vid[0]+"' title='"+sname+"' alt='"+sname+"' src='"+protocol+"img.youtube.com/vi/"+parm+"/"+autoYouTubeThumb[0]+".jpg' height='60px'/></div>";
						});
						
						youtube_video.html(youtube_items).children().preloader();
							
						// Destroy and build carousel
						$.fn.carouFredSel.defaults.items.visible = 5;
						youtube_video.carouFredSel({
							width: youtube_video.parents(".youtube-carousel").innerWidth(),
							height: youtube_video.parents(".youtube-carousel").innerHeight(),
							//scroll: 1,
							auto: {
								play: true,
								delay: 2000
							},
							direction: 'right',
							scroll: {
								items: 1,
								duration: 1000,
								//fx: "crossfade",
								//easing: "linear",
								mousewheel: 5,
								//queue: true,
								pauseOnHover: 'immediate-resume',
							}
						});
							
						//set_info();
						
						set_youtube_player();
					}
					return max_item;
				}
			}
		});
		return max_item;
	}
	