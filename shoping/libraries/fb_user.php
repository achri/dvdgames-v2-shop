<?php if ( ! defined('BASEPATH')) exit('cant access');

class Fb_user 
{
	function __construct() 
	{
		$this->CI =& get_instance();
	}
	
	function get()
	{
		$return = [];
		if ($fb_session = $this->CI->session->userdata('fb_user')) 
			$return = json_decode($fb_session);
		return $return;
	}
}