<?php
$cache_expire = 60*60*24*365;
header("Pragma: public");
header("Cache-Control: max-age=".$cache_expire);
header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
//if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start(); 
ob_start(); 
?>  
<!doctype html>
<html class="noscript" lang="en" itemscope itemtype="http://schema.org/Product" <?php echo config('facebook') ? 'xmlns:og="http://ogp.me/ns#"' : ''?>>
<head <?php echo config('facebook') ? config('facebook_prefix') : ''?>>
	<title>
		Penjualan Online DVD Games
  </title>
	<meta name="robots" content="INDEX, FOLLOW"/>
	<meta name="keywords" content="penjualan online, dvd, games, jual, pc, game, murah, bandung">
	<meta name="description" content="penjualan online dvd games murah bandung">
	<meta content="text/html; charset=UTF-8" http-equiv="Content-Type">
	
	<!-- Add the following three tags inside head -->
	<meta itemprop="name" content="DVDGames-Online">
	<meta itemprop="description" content="Penjualan Online DVDGames">
	<meta itemprop="image" content="https://fbcdn-photos-a.akamaihd.net/photos-ak-snc1/v85006/49/182144835203737/app_1_182144835203737_943.gif">

	<?php if(WEB_FEATURE) {
		foreach (config('facebook_og') as $property => $content)
			echo "<meta property=\"$property\" content=\"$content\"/>\n";
	?>
	<script src="https://www.google.com/jsapi?key=ABQIAAAAgwDsaFHh_QBkX58Hb5Mj-RQSwqsEUZ_m54gKvLpHNUIqBA782hQr8TBhUES5Oxf3OC13g6Avug8ZhQ" type="text/javascript"></script>
	<!--script src="http://api.microsofttranslator.com/V2/Ajax.svc" type="text/javascript"></script-->
	<script src="http://www.youtube.com/player_api" type="text/javascript"></script>
	<script src="asset/js/helper/google.js" type="text/javascript"></script>
	<script type="text/javascript">
	if(document.location.protocol=='http:'){
	 var Tynt=Tynt||[];Tynt.push('c_XIZMkimr4AYkacwqm_6r');Tynt.i={"ap":"Read more:"};
	 (function(){var s=document.createElement('script');s.async="async";s.type="text/javascript";s.src='http://tcr.tynt.com/ti.js';var h=document.getElementsByTagName('script')[0];h.parentNode.insertBefore(s,h);})();
	}
	</script>

	<?php } 
		// header content
		if (isset($loaderContent))
		{
			echo $loaderContent;
		} else {
			die();
		}

		echo link_tag('asset/images/layout/dvd1.png', 'shortcut icon', 'image/ico');
		echo link_tag('feed', 'alternate', 'application/rss+xml', 'My RSS Feed');
		// themes
		$link = array(
			'id' => 'ui-themes',
			'href' => config('asset_src').'jquery/themes/'.($set_themes?$set_themes:config('themes_default')).'/jquery.ui.all.css',
			'rel' => 'stylesheet',
			'type' => 'text/css',
			'media' => 'screen'
		);
		echo link_tag($link);
	?>
	<base href="<?php echo base_url()?>"/>
	<script type="text/javascript">
	// SITE ASSET SRC
	function ui_switch(themes) {
		$('#ui-themes').attr('href',function(){
			$.post('index.php/general/save_themes/'+themes);
			return '<?php echo config('asset_src')?>jquery/themes/'+themes+'/jquery.ui.all.css';
		});
	}
	// ADMIN
	$(function() {
		$('#dvd-help').click(function() {
			window.open(["<?php echo config('asset_upload')?>"]);
		});
	});
	</script>
</head>
<body>
	<input type="checkbox" style="position:absolute; left: 0; margin:0; padding: 0; opacity: 0.05;" id="body-themes"/>
	<div id="glare">
		<div id="glare-image"></div>
	</div>
<?php if (!config('uc')) {?>
	<div id="wrap">
		<div id="header" class="dvd-corner-tl-14-fix dvd-corner-tr-60 ui-widget-header">
			<div class="header-content">
				<div style="float:left; width: 430px !important;">
					<div class="title dvd-font-header1"><h1 itemprop="name">Penjualan Online DVD</h1></div>
					<div class="slogan dvd-font-header1"><p itemprop="description">@DVDGames-Online.COM</p></div>
					<?php 
					// FB LOGIN
					if(WEB_FEATURE) {?>	
					<div id="online-stats">
						<ul>
							<li>
								<!--div id="fb-login-button" class="fb-login-button" data-show-faces="false" data-width="100" data-max-rows="1" data-perms="email,read_stream" data-redirect-uri="</?php echo base_url()?>"></div-->
								<div id="fb-login-button" class="fb-login-button" data-show-faces="false" data-width="100" data-max-rows="1" data-scope="email,user_location,create_event,sms" data-redirect-uri="<?php echo base_url()?>"></div>
							</li>
							<li><div class="fb-like" data-href="" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false" data-colorscheme="dark" data-font="segoe ui"></div></li>
							<li><a href="https://twitter.com/share" class="twitter-share-button" data-via="twitterapi" data-lang="en" data-count="horizontal">Tweet</a></li>
							<li><div class="g-plusone" data-size="medium"></div></li>
							<li><div id="histats_counter"></div></li>
						</ul>
					</div>
					<?php }?>
				</div>
				
				<div class="header-dvd-new">
					<img class="new_dvd ui-corner-all ui-state-error" height="90px" />
					<img class="best_dvd" src="asset/images/layout/bestbuy.png" height="55px" />
				</div>
			</div>
			<span class="logo-dvd"><img itemprop="image" src="asset/images/layout/dvds.png"/></span>
			<div class="header-extra dvd-corner-tr-14 ui-state-default" id="dvd-help">
				<!--span class="dvd-font-header2">help</span-->
			</div>
		</div>
		
		<div class="clearfix"></div>
		
		<div id="menu" class="dvd-font-menu ui-state-hover">
			<div id="menu-lava-content">
				<ol id="menu-lava" class="lavalamp">
					<li><a href="#" module="home">Halaman Utama</a></li> 
					<li><a href="#" module="list_dvd">Daftar DVD</a></li> 
					<li><a href="#" module="list_cart">Rincian Pemesanan</a></li>
					<li><a href="#" module="list_tracking">Tracking</a></li> 
				</ol>
			</div>
			<div id="themes"> 
				<select onChange="ui_switch(this.value);" class="ui-widget-select ui-widget-content">
					<?php
						$url_themes = json_decode($this->curl->simple_post(config('asset_src').'directory_listner.php?dir=jquery/themes'));//directory_map(config('asset_src').'jquery/themes/', TRUE);
						$no = 1;
						foreach ($url_themes as $themes)
						{
					?>
							<option value="<?php echo $themes?>" <?php echo ($themes==($set_themes?$set_themes:config('themes_default')))?('SELECTED'):('')?>><?php echo "skin ".$no?></option>
					<?php
						$no++;
						}
					?>
				</select>
			</div>
		</div>
		
		<div class="clearfix"></div>
		
		<div id="main-content">
			<div id="main-overlay">
				<div class="main-overlay-top" class="ui-priority-secondary"></div>
				<div class="main-overlay-loading">Sedang Memuat ...</div>
				<div class="main-overlay-bottom" class="ui-priority-secondary"></div>
			</div>
			
			<div id="content" class="ui-widget-content">
				<div id="content-left">
					<div class="content-view ui-state-highlight ui-corner-all">
						<!-- MAIN CONTENT AJAX -->
					</div>
				</div>
				
				<div id="content-right">					
					<div id="accordion-content">
						<div class="accordion">
							<h3>
								<a href="#">
									DVD Pesanan
									<!--span style="float:right; position:absolute; margin:0 0 0 65px; width:50px;">
										<span class="ui-icon ui-icon-cart" style="float:left;"></span>
										<span style="float:right;">10</span>
									</span-->
								</a>
							</h3>
							<div class="ui-state-highlight">
								<div id="cart-list">
									<!-- CURRENT CART ITEM -->
								</div>
							</div>
							<h3><a href="#">Kategori</a></h3>
							<div>
								<ul class="selectable-kategori dvd-font-t">
									<li id="" class="ui-selected">[ SEMUA ]</li>
								<?php
								if (isset($data_categories)) 
								{
									foreach ($data_categories->result() as $rkat) 
									{
									?>
									<li id="<?php echo $rkat->kat_id?>"><?php echo $rkat->kat_nama;?></li>
									<?php
									}
								}
								?>
								</ul>
							</div>
							<?php if(WEB_FEATURE) {?>
							<h3><a href="#">Facebook</a></h3>
							<div class="ui-state-active">
								<!-- FACEBOOK PAGE STREAM -->
								<div class="fb-like-box" data-href="https://www.facebook.com/apps/application.php?id=182144835203737" data-width="220" data-show-faces="true" data-stream="true" data-header="false"></div>
							</div>
							<h3><a href="#">RSS Feed</a></h3>
							<div class="ui-state-highlight">
								<!-- RETIVE GAMES FEEDS -->
								<div id="feeds">
									<a class="feed" href="#">GameSpot</a> 
									<a class="feed" href="#">IGN</a> 
									<a class="feed" href="#">GAMESPY</a> 
									<div id="feed_show"></div>
								</div> 
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				
				<div class="clearfix"></div>
				
				<div class="content-footer-left ui-state-hover ui-corner-all">
					<div id="best-dvd-box"> 
						<div id="best-dvd-carousel"></div>
						<div class="clearfix"></div>
						<a href="#" id="bdvd-prev"><span class="ui-icon ui-icon-circle-arrow-w"></span></a>
						<a href="#" id="bdvd-next"><span class="ui-icon ui-icon-circle-arrow-e"></span></a>
					</div>
				</div>
				<div class="content-footer-right">
					<div class="content-footer-rl ui-widget-content ui-corner-all">
						<!-- FACEBOOK PHOTO PROFILE -->
						<?php if(config('facebook')) {?>
						<fb:profile-pic uid="loggedinuser" size="square" facebook-logo="true"></fb:profile-pic>
						<?php }?>
					</div>
					
					<div class="content-footer-rr ui-state-active ui-corner-all">
						
					</div>
				</div>
			</div>
			
			<div class="clearfix"></div>
			
			<div id="content-full" class="ui-widget-content"></div>
			
		</div>
		
		<div class="clearfix"></div>
		
		<div id="footer" class="dvd-corner-bl-14 dvd-corner-br-14 ui-widget-header">
			<div id="footer-badge"> 
			<?php if(WEB_FEATURE) $this->load->view('site_badge') ?>
			</div>
			<div id="footer-content">
				<div id="footer-left" class="dvd-corner-bl-14 ui-widget-content">
					<div class="footer-login">
						<button id="login-pane" class="login ui-widget-header ui-corner-all">
							<span class="lrow lrow1 ui-icon ui-icon-circle-arrow-w"></span> <span class="login-text">OPEN</span>
						</button>
						<button id="login-im" class="login ui-widget-header ui-corner-all">
							<span id="signup" class="lrow lrow2 ui-icon ui-icon-person"></span> <span class="login-text">EMAIL</span>
						</button>
					</div>
					<div id="login">
						<div class="cs-email">
							<table>
							<tr>
								<td>Komplain Penjualan</td><td>&nbsp;:&nbsp;</td><td><a href="mailto:sales@dvdgames-online.com">sales@dvdgames.online.com</a></td> 
							</tr>
							<tr>
								<td>Komplain DVD</td><td>&nbsp;:&nbsp;</td><td><a href="mailto:support@dvdgames-online.com">support@dvdgames.online.com</a></td> 
							</tr>
							</table>
						</div>
						<div class="cs-im" style="display:none">
							<table>
							<tr>
								<td>IM</td><td>&nbsp;:&nbsp;</td><td>dvdgames.online@yahoo.com</td> 
							</tr>
							<tr>
								<td>Telp</td><td>&nbsp;:&nbsp;</td><td></td> 
							</tr>
							</table>
						</div>
					</div>
				</div>
				
				<div id="footer-right" class="dvd-corner-br-14 dvd-font-t ui-widget-header">
					<p>
							<A href="#" module="home">home</A>
							| <A href="#" module="list_dvd">dvd</A> 
							| <A href="#" module="list_cart">rincian</A> 
							| <A href="#" module="list_tracking">tracking</A> 
							| <A href="http://forum.dvdgames-online.com" target="_blank">forum</A> 
							<span id="fb-logout-button" style="display:none">| <a href="#" onclick="fb_logout()">logout</a></span>
					</p>
					<p id="owner" class="dvd-font-m">
						<a href="http://www.dvdgames-online.com">&copy; 2011 dvdgames-online.com&trade; All Right Reserved</a>
					</p>
					<div style="float: right;margin:-2px 24px 0 0;color: rgb(103, 103, 103);">
						<span style="vertical-align:middle;font-family:arial,sans-serif;font-size:11px;">
							powered by<img src="asset/images/badge/google.png" style="padding-left:1px;vertical-align:middle;">
						</span>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php 
} else
  $this->load->view('mod_info/info_uc_view');
?>
	<div id="glare-foot">
		<div id="glare-foot-image"></div>
	</div>
<?php if(WEB_FEATURE) {?>	
<div id="fb-root"></div>
<script src="asset/js/helper/fb_init.js" type="text/javascript"></script>
<script src="asset/js/widget.js" type="text/javascript"></script>
<?php }
if ($bind_url)
	echo $bind_url;
?>
</body>
</html>
