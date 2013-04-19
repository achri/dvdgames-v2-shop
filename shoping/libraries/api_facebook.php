<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Api_facebook 
{

	function __construct() 
	{
		$this->obj =& get_instance();
	}
	
	function get_cookie($app_id, $app_secret) {
		$args = array();
		parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
		ksort($args);
		$payload = '';
		foreach ($args as $key => $value) {
			if ($key != 'sig') {
				$payload .= $key . '=' . $value;
			}
		}
		if (md5($payload . $app_secret) != $args['sig']) {
			return null;
		}
		return $args;
	}
	
	function api_token()
	{
		$app_id = $this->obj->config->item('facebook_app_id');
		$secret_id = $this->obj->config->item('facebook_api_secret');
		
		if ($this->obj->input->cookie('fbs_' . $app_id))
		{
			$cookie = $this->get_cookie($app_id, $secret_id);
			$get_token = file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']);
			
			if ($get_token)
				return json_decode($get_token);
		}
	}
}