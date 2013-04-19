<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));
/*
 @author		Achri
 @date creation	04/10/2011
 @model
	- 
 @view
	- 
 @library
		- JS
		- PHP
 @comment
	- Class First Loader
*/
class General extends DVD_Controller 
{
  // PUBLIC STATIC VARIABLE
  public static $link_controller, $link_view;
	
  // CONSTRUCTOR
  function __construct() 
  {
    parent::__construct();
		$class = get_class($this);
    log_message('dvd', "Controller $class Init success");
  }
		
	// SAVE THEMES
	function save_themes($themes)
	{
		$this->session->set_userdata('set_themes',$themes);
	}
	
	// SAVE FB USER
	function login_fb_user()
	{
		$this->session->set_userdata("fb_user",json_encode($this->input->post('fb_data')));
	}
	
	// SAVE FB USER
	function logout_fb_user()
	{
		$this->session->unset_userdata("fb_user");
	}
	
}

/* End of file general.php */
/* Location: ./application/controllers/general.php */