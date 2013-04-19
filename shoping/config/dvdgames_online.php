<?php if (!defined('BASEPATH')) exit('PERINGATAN !!! TIDAK BISA DIAKSES SECARA LANGSUNG ...'); 

// BASE DIRECT OPENSSL OR NATIVE SERVER PROTOCOL @AHRIE
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$wwwp = 'https://';
} else {
	$wwwp = 'http://';
}

/*if (INWEB) {
	$asset_src = 'source.dvdgames-online.com/';
	$asset_upload = 'storage.dvdgames-online.com/storage/';
	$env_status = '';
} else {
*/
	$asset_src = $_SERVER['SERVER_NAME'].':5001/';
	$asset_upload = $_SERVER['SERVER_NAME'].':5002/storage/';	
	$env_status = getenv('APP_STATUS');
//}

// BASE LINK
$config['base_url'] = $wwwp.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'];
// ASSET LINK
$config['asset_src'] = $wwwp.$asset_src;
$config['asset_upload'] = $wwwp.$asset_upload;
// APPLICATION STATUS
$config['app_status'] = $env_status;

// CONFIG HARGA
$config['bonus_dvd'] = 5;
$config['harga_dvd'] = 30000;
$config['harga_cd'] = 15000;

// LIMIT ITEM DVD
$config['dvd_limit'] = 8;

// EMAIL
if (INWEB) {
	$config['email_admin'] = "admin@dvdgames-online.com";
	$config['email_marketing'] = "marketing@dvdgames-online.com";
	$config['email_sales'] = "sales@dvdgames-online.com";
	$config['email_support'] = "support@dvdgames-online.com";
} else {
	$config['email_admin'] = "administrator@localhost";
	$config['email_marketing'] = "marketing@localhost";
	$config['email_sales'] = "sales@localhost";
	$config['email_support'] = "support@localhost";
}

// DEBUG
$config['debug'] = WEB_DEBUG;
// UNDERCONTRACTION
$config['uc'] = WEB_UC;
// DEVELOPMENT
$config['dev'] = WEB_DEBUG;

// JS AND CSS COMPRESOR
$config['minify'] = WEB_MINIFY;
$config['url_packed']['css'] = $config['base_url'].'/asset/css/packed/';
$config['url_packed']['js'] = $config['base_url'].'/asset/js/packed/';
$config['url_packed']['temp'] = $config['base_url'].'/asset/temp/';

// DEFAULT SKIN
$config['themes_default'] = WEB_THEMES;

/*** FACEBOOK FEATURE ***/
if (!empty($config['app_status']) && $config['app_status'] == 'DEVELOPMENT'):
// DEV
$config['facebook_app_id'] 			= '273481472690679';
$config['facebook_api_secret'] 	= '7f5017c1674226a78fdf68ca07a25964';
else:
// RELEASE
$config['facebook_app_id'] 			= '182144835203737';
$config['facebook_api_secret'] 	= '500829942f8414ec29d035dd3ded1a2f';
endif;

/*
// OPEN GRAPH
$config['facebook_prefix'] = 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# dvdgames: http://ogp.me/ns/fb/dvdgames#"';
$config['facebook_og']["og:app_id"] = $config['facebook_app_id'];
$config['facebook_og']["og:type"] = "dvdgames_dev:dvd";
$config['facebook_og']["og:url"] = $config['base_url'];
$config['facebook_og']["og:title"] = "PC Games";
$config['facebook_og']["og:description"] = "Penjualan Online DVD Game";
$config['facebook_og']["og:image"] = "https://fbcdn-photos-a.akamaihd.net/photos-ak-snc1/v85006/49/182144835203737/app_1_182144835203737_943.gif";

$config['facebook_og']["og:site_name"] = "DVD Games - Online";
*/
/*
$config['facebook_prefix'] = 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# dvdgames: http://ogp.me/ns/fb/dvdgames#"';
$config['facebook_og']["og:app_id"] = $config['facebook_app_id'];
$config['facebook_og']["og:type"] = "dvdgames:dvd";
$config['facebook_og']["og:url"] = $config['base_url'];
$config['facebook_og']["og:title"] = "PC Games";
$config['facebook_og']["og:description"] = "Penjualan Online DVD Game";
$config['facebook_og']["og:image"] = "https://fbcdn-photos-a.akamaihd.net/photos-ak-snc1/v85006/49/182144835203737/app_1_182144835203737_943.gif";
$config['facebook_og']["fb:admins"] = "1040244522";
*/

if (WEB_FEATURE) {
	$config['facebook_prefix'] = 'prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb# dvdgames: http://ogp.me/ns/fb/dvdgames#"';
	//$config['facebook_og']["og:app_id"] = $config['facebook_app_id'];
	//$config['facebook_og']["og:type"] = "dvdgames:dvd";
	$config['facebook_og']["og:title"] = "Penjualan Online DVD Games";
	$config['facebook_og']["og:type"] = "website";
	$config['facebook_og']["og:url"] = "http://dvdgames-online.com";
	$config['facebook_og']["og:image"] = "https://fbcdn-photos-a.akamaihd.net/photos-ak-snc1/v85006/49/182144835203737/app_1_182144835203737_943.gif";
	$config['facebook_og']["og:site_name"] = "http://dvdgames-online.com";
	$config['facebook_og']["fb:admins"] = "1040244522";
	$config['facebook_og']["og:locale"] = "id_ID";
}

$config['youtube_id'] = 'AI39si5jXI87LAaz4wf7oZXYJOVlywD3edNd8NyuERUhHje2Ba3F4-E9hamOiHI_i4lRQH0g1xLvgKEa2Oe81g_vh7Pc4JNqKA'; //
$config['google_api_id'] = 'ABQIAAAAgwDsaFHh_QBkX58Hb5Mj-RQSwqsEUZ_m54gKvLpHNUIqBA782hQr8TBhUES5Oxf3OC13g6Avug8ZhQ'; //

// FEATURE
$online_feature = WEB_FEATURE;
$config['youtube'] = $online_feature;
$config['facebook'] = $online_feature;
$config['rss'] = $online_feature;
$config['ads_sitti'] = $online_feature;
$config['google'] = $online_feature;
$config['counter'] = $online_feature;
