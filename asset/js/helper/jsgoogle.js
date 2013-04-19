$("#feeds").rss(url.ign, {
		limit: 10,
		//filterLimit: 5,
		ssl: true,
		//filter: function(entry, tokens) {
		//	return tokens.title.indexOf('my filter') > -1
		//},
		// template for the html transformation
		// default: "<ul>{entry}<li><a href='{url}'>[{author}@{date}] {title}</a><br/>{shortBodyPlain}</li>{/entry}</ul>"
		template: "<div id='1236' style='width:"+feed_width+"px !important'>"+
			"{entry}"+
				"<div id=\"content_div-{index}\">"+
				"<div class=\"translate_block ui-state-active\"><a id=\"translate_button_post-{index}\" href=\"#\" onclick=\"javascript:show_translate_popup('en','post',{index});\" class=\"translate_translate\" lang=\"en\" xml:lang=\"en\">Terjemahan</a><img id=\"translate_loading_post-{index}\" class=\"translate_loading\" width=\"16\" height=\"16\" style=\"display: none;\" src=\"asset/css/helper/transparent.gif\"></div>"+
				"<h4 class='feed-title ui-state-hover'>{title}</h4>"+
				"<img class='feed-images' src='{teaserImageUrl}' width='200px' />"+
				"<span class='feed-content' >{bodyPlain}</span>"+
				"</div>"+
			"{/entry}"+
		"</div>",

		// additional token definition for in-template-usage
		// default: {}
		tokens: {
			'foto': function(entry, tokens) { return tokens.teaserImage }
		}
	});