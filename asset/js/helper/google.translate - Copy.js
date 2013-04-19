$.translate.load('ABQIAAAAgwDsaFHh_QBkX58Hb5Mj-RQSwqsEUZ_m54gKvLpHNUIqBA782hQr8TBhUES5Oxf3OC13g6Avug8ZhQ');

jQuery(function(){
	jQuery(".translate_block").show();
	var f=document.getElementById("translate_popup");
	f&&document.body.appendChild(f)
}); 

function google_translate(f,e,c){
	var b=document.getElementById(("comment"==e?"div-":"")+e+"-"+c),
			a=".translate_block",
			d;if(!b&&"post"==e)b=document.getElementById("content_div-"+c);

	if(!b&&"comment"==e)b=document.getElementById("comment-"+c);
	if(b){
	if("undefined"!==typeof ga_translation_options)
		if("undefined"!==typeof ga_translation_options.do_not_translate_selector)
			a+=", "+ga_translation_options.do_not_translate_selector;
		d="#translate_loading_"+e+"-"+c;
		jQuery(b).translate(f,{
			fromOriginal:true,
			not:a, 
			start:function(){jQuery(d).show()},
			complete:function(){jQuery(d).hide()},
			error:function(){jQuery(d).hide()},
			each: function(i){
				console.log( this.translation[i] ) // i==this.i
			}, 
			async:  false,
			toggle: true,
			returnAll: true
		})
	}
	jQuery("#translate_popup").slideUp("fast")
}

function localize_languages(f,e){
	var c=jQuery("#translate_popup a").get(),b=[],a;
	for(a in c)b[a]=c[a].title;
	jQuery.translate(b,"en",f,{
	complete:function(){
		b=this.translation;
		for(a in c)c[a].title=b[a];
		jQuery(e).data("localized",true)
	}
	})
} 

function show_translate_popup(f,e,c){
	var b=document.getElementById("translate_popup"),
	a=jQuery(b),
	d=jQuery("#translate_button_"+e+"-"+c),
	g=Math.round(d.offset().left);

	d=Math.round(d.offset().top+d.outerHeight(true));
	if(b){
		jQuery.translate.languageCodeMap.pt="pt-PT";
		if("none"==b.style.display||a.position().top!=d){
			b.style.display="none";a.css("left",g).css("top",d);a.slideDown("fast");
			g=jQuery(window).width()+jQuery(window).scrollLeft()-a.offset().left-a.outerWidth(true);
			g<0&&a.css("left",Math.max(0, a.offset().left+g));
			jQuery("#translate_popup .languagelink").each(function(){
				jQuery(this).unbind("click").click(function(){
					google_translate(this.lang,e,c);
					return false
				})
			});
			"en"!=f&&!a.data("localized")&&localize_languages(f,b)
		} else a.slideUp("fast")
	}
}; 