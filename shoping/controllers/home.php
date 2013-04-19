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
class Home extends DVD_Controller 
{
  // PUBLIC STATIC VARIABLE
  public static $link_controller, $link_view;
	
  // CONSTRUCTOR
  function __construct() 
  {
    parent::__construct();
    $class = get_class($this);
    $this->_loader();
    $output = array();
    $output += $this->_headerContent();
    $output += $this->_publicStatic();
		$this->load->vars($output);

    log_message('dvd', "Controller $class Init success");
  }
	
  // LOADER 
  function _loader()
  {
	
  }
	
  // LOADER JS AND CSS
  function _headerContent()
  {	
		$CSS['local'] = array('asset/css/mod_home/home_index.css');
		$JS['local'] = array('asset/js/mod_home/home_index.js');
		
		$output['extraContent'] = js_header($JS).css_header($CSS);			
		
    return $output;
  }
	
  // INITIALING PUBLIC STATIC VARIABLE
  function _publicStatic()
  {
    // public variable
    self::$link_controller = 'home';
    self::$link_view = 'mod_home';
    $output['link_view'] = self::$link_view;
    $output['link_controller'] = self::$link_controller;
    return $output;
  }
	
	// INDEX
  function index()
  {
		$data[''] = '';
			
    $this->load->view('mod_home/home',$data);
  }
		
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */