$(function() {

// RSS FEEDS
	$("#feeds a.feed").bind('click',function(){
		var idx = $(this).index(),
				url = {
					0:'http://asia.gamespot.com/rss/game_updates.php?platform=5&type=5',
					1:'http://feeds.ign.com/ignfeeds/pc/',
					2:'http://feeds.gamespy.com/gsfeeds/pc/'
				}, 
				feed_type = {0:'GameSpot',1:'IGN',2:'GameSpy'},
				feed_width = 220;//$('.ui-accordion-content').innerWidth() - 30;
		
		$("#feed_show").html('').rss(url[idx], {
			limit: 10,
			ssl: true,
			template: "<div id=\"feed-box\" style='width:"+feed_width+"px !important'>"+
				"<div class='ui-state-default' style='width:"+feed_width+"px !important'><h4>"+feed_type[idx]+"</h4></div>"+
				"{entry}"+
					"<div class='feed-title ui-state-hover dvd-font-header1' style='width:"+feed_width+"px !important'>{title}</div>"+
					"<img class='feed-images' src='{teaserImageUrl}' width='"+feed_width+"px'/>"+
					"<div class='feed-content ui-state-default dvd-font-m' style='width:"+feed_width+"px !important'>{shortBodyPlain}</div>"+
					"<div class='feed-send ui-state-error' style='width:"+feed_width+"px !important'><a href=\"{url}\" target=\"_blank\">{author} {date}</a></div>"+
				"{/entry}"+
			"</div>"
		});	
		
	}).eq(0).trigger('click');
	
});

/* Histats */
	var _Hasync= _Hasync|| [];
	_Hasync.push(['Histats.startgif', '1,1746768,4,10046,"div#histatsC {position: absolute;top:0px;left:0px;}body>div#histatsC {position: fixed;}"']);
	_Hasync.push(['Histats.fasi', '1']);
	_Hasync.push(['Histats.track_hits', '']);
	(function() {
	var hs = document.createElement('script'); hs.type = 'text/javascript'; hs.async = true;
	hs.src = ('http://s10.histats.com/js15_gif_as.js');
	(document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(hs);
	})();
	
/* Tweeter */
	!function(d,s,id){
		var js,fjs=d.getElementsByTagName(s)[0];
		if(!d.getElementById(id)){
			js=d.createElement(s);
			js.id=id;js.src="//platform.twitter.com/widgets.js";
			fjs.parentNode.insertBefore(js,fjs);
		}
	}(document,"script","twitter-wjs");
	
// GOOGLE +1
  window.___gcfg = {lang: 'id'};

  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();

/*	
// ADS SITTI
	var sitti_pub_id = "BC0017262",
			//sitti_ad_width = "468",
			sitti_ad_width = "366",
			sitti_ad_height = "60",
			sitti_ad_type = "9",
			sitti_ad_number = "2",
			sitti_ad_name = "Game PC",
			sitti_dep_id = "42336";
			
	function ads_sitti() {
		$.getScript('http://stat.sittiad.com/delivery/sittiad.b1.js');
	}
*/
// YOUTUBE API
	//$.getScript('AI39si5jXI87LAaz4wf7oZXYJOVlywD3edNd8NyuERUhHje2Ba3F4-E9hamOiHI_i4lRQH0g1xLvgKEa2Oe81g_vh7Pc4JNqKA');
	
//});