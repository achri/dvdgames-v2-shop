var message="Content Protected", menu_elm;

function go_menu(idx) {
	$('ol.lavalamp a:eq('+idx+')').parent().trigger('mouseover').trigger('click');
}

function menu_cut()
{
	//CutTxt = document.selection.createRange();
	//CutTxt.execCommand("Cut");
}

function menu_copy()
{
	//var didSucceed = window.clipboardData.setData('Text', 'text to copy');
	//CopiedTxt = document.selection.createRange();
	//CopiedTxt.execCommand("Copy");
	
	//console.log(event.target.nodeName); // "DIV"
}

function menu_paste()
{
	//var clipText = window.clipboardData.getData('Text');
	//document.Form1.txtArea.focus();
	//PastedText = document.Form1.txtArea.createTextRange();
	//PastedText.execCommand("Paste");
} 

function protected_menu() {
	var menu = [
			//{ name: "Potong", func: function (element) { return false; } },
			//{ name: "Salin", func: function (element) { menu_copy(); } },
			//{ name: "Tempel", func: function (element) {  menu_paste(); } },
			//{ name: "<hr/>", func: function (element) { return false; } },
			{ name: "Halaman Utama", func: function (element) { menu_go(0); } },
			{ name: "Daftar DVD", func: function (element) { menu_go(1); } },
			{ name: "Rincian Pemesanan", func: function (element) { menu_go(2); } },
			{ name: "Tracking", func: function (element) { menu_go(3); } },
			{ name: "<hr/>", func: function (element) { return false; } },
			{ name: "Forum", func: function (element) { window.open(["http://forum.dvdgames-online.com"]); } },
			{ name: "FaceBook Page", func: function (element) { window.open(["http://www.facebook.com/apps/application.php?id=182144835203737"]); } }
	];
	$(document).rightClickMenu(menu,true);
	return false;
}

function clickIE4(){
	if (event.button==2){
		//alert(message);
		protected_menu();
		return false;
	}
}

function clickNS4(e){
	if (document.layers||document.getElementById&&!document.all){
		if (e.which==2||e.which==3){
			//alert(message);
			protected_menu();
			return false;
		}
	}
}

if (document.layers){
	document.captureEvents(Event.MOUSEDOWN);
	document.onmousedown=clickNS4;
}
else if (document.all&&!document.getElementById){
	document.onmousedown=clickIE4;
}

function disableSelection(target){
	if (typeof target.onselectstart!="undefined") {//For IE 
		target.onselectstart=function(){return false};
	}
	else if (typeof target.style.MozUserSelect!="undefined") { //For Firefox
		target.style.MozUserSelect="none";
	}
	else { //All other route (For Opera)
		target.onmousedown=function(){return false};
	}
	target.style.cursor = "default";
}
