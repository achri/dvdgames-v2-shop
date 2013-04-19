<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class DVD_Controller extends CI_Controller 
{
	protected $CI;
  function __construct() 
  {
    parent::__construct();
		$this->CI =& get_instance();
		// CONTROL HEADER
		$this->_set_header();
		
		// DEVELOPER LOGIn
		if(WEB_DEBUG){
			$this->_dev_login();
		}
    // LANG BASEPATH
    $this->lang->load('info_page', 'indonesia');
		
		$this->_fb_routine();
		$this->_session_cart();
		$this->_status_order();
		
		// TIME ZONE
		date_default_timezone_set('Asia/Jakarta');
		
		// DEBUG INIT LOG
		log_message('dvd','Class of ('.$this->router->class.') and method ('.$this->router->method.') init called successful. Data: POST='.json_encode($_POST).' | GET='.json_encode($_GET));
  }
	
	// Control header
	function _set_header()
	{
		// problem with ajax, no solution yet
	}
	
	// usefull native session never expired ui
	function _session_cart()
	{
		if($this->session)
		{
			if (!$this->session->userdata('cart_session'))
			{
				$test = session_id();
				if (empty($test))
					session_start();
					
				$date = getdate();
				$encript = session_id();//md5("$date");
				$this->session->set_userdata('cart_session',$encript);
			}
		} 
		else
		{
			exit();
		}
	}
	
	// cek session order status
	function _status_order()
	{
		//$this->load->model('tbl_cart');
		//$where['cart_session'] = $this->session->userdata('cart_session');
		//$get_cart = $this->tbl_cart->get_cart($where);
		$cart_session = $this->session->userdata('cart_session');
		$query = "select cart_status from cart where cart_session='".$cart_session."' order by cart_id desc";
		$get_cart = $this->db->query($query);
		if ($get_cart->num_rows() > 0)
		{
			$this->session->set_userdata('cart_status',$get_cart->row()->cart_status);
			$cart_status = $get_cart->row()->cart_status;
		} else {
			$this->session->set_userdata('cart_status',0);
			$cart_status = 0;
		}
		$cookie = array(
			'name'   => 'cart_status',
			'value'  => $cart_status,
			'expire' => '0',
		);
		$this->input->set_cookie($cookie);
	}
	
	// fb cookie
	function _fb_routine()
	{
		if(config('facebook'))
		{
			$cookie = array(
				'name'   => 'fb_appid',
				'value'  => config('facebook_app_id'),
				'expire' => '0',
			);
			$this->input->set_cookie($cookie);
		}	
	}
	
	function _dev_login()
	{
		$this->load->library(array("lib_login"));
		
		$unlocked = array('core_login');
		if ( ! $this->lib_login->is_logged_in() AND ! in_array(strtolower(get_class($this)), $unlocked))
		{
			redirect(site_url('core_login'),'location');
		} 
	}
}