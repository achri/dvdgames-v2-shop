<?php if ( ! defined('BASEPATH')) exit('cant access');

function fb_user($target) 
{
	$CI =& get_instance();
	$split = explode(',',$target);
	$length = sizeOf($split);
	$return = '';
	if ($fb_session = $CI->session->userdata('fb_user')) {
			$return = json_decode($fb_session);
			switch ($length) {
				case 1: $return = $return->$split[0]; break;
				case 2: $return = $return->$split[0]->$split[1]; break;
			}
	}
	return $return;
}

function is_fb()
{
	$CI =& get_instance();
	if ($CI->config->item('facebook'))
		return true;
	else
		return false;
}