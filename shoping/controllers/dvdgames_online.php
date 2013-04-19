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
class Dvdgames_online extends DVD_Controller 
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
    $output += $this->_publicStatic($class);
    $output += $this->_dataRecords();
		$output += $this->_set_themes();
		$this->load->vars($output);

    log_message('dvd', "Controller ($class) init executed.");
  }
	
  // LOADER 
  function _loader()
  {
    $this->load->helper(array(
      
    ));
    $this->load->model(array(
      'tbl_category','tbl_dvd'
    ));
  }
	
  // LOADER JS AND CSS
  function _headerContent()
  {	
		$CSS['remote'] = array(
			/*** jQuery Plugins CSS ***/
			'jquery/plugins/picture/preloader/jquery.preloader.css',
			'jquery/plugins/tooltip/qtip/jquery.qtip.min.css',
			'jquery/plugins/table/jqGrid/css/ui.jqgrid.css',
			'jquery/plugins/form/formalize/css/formalize.css',
			'jquery/plugins/form/autocomplete/jquery.autocomplete.css',
			'jquery/plugins/menu/rightclickmenu/jquery.rightClickMenu.css'
		);
		
		$CSS['local'] = array(
			/*** General ***/
			'asset/css/body.css',
			'asset/css/layout.css',
			'asset/css/helper/dialog.qtip.css',
			'asset/css/mod_list/list_dvd/dvd_index.css',
    );
				
		$JS['remote'] = array(
			/*** jQuery ***/
			'jquery/core/jquery-1.5.2.js', 
			'jquery/ui/jquery-ui-1.8.12.custom.js',
			//(WEB_DEBUG?"jquery/core/jquery.lint.js":""),
			'jquery/plugins/integration/jquery.cookie.js',
			'jquery/plugins/manager/jquery.ajaxmanager.js',
			/*** Plugins ***/
			'jquery/plugins/menu/rightclickmenu/jquery.rightClickMenu.js',
			'jquery/plugins/menu/jquery.lavalamp.js',
			'jquery/plugins/menu/jquery.easing.js',
			'jquery/plugins/picture/preloader/jquery.preloader.js',
			'jquery/plugins/picture/carouFredSel-5.1.2/jquery.carouFredSel-5.1.2-packed.js',
			'jquery/plugins/navigation/jquery.mousewheel.js',
			'jquery/plugins/movement/jquery.scrollTo.min.js',
			'jquery/plugins/tooltip/qtip/jquery.qtip.min.js',
			'jquery/plugins/table/jqGrid/src/i18n/grid.locale-en.js',
			'jquery/plugins/table/jqGrid/js/jquery.jqGrid.min.js',
			'jquery/plugins/form/jquery.form.js',
			'jquery/plugins/form/jquery.autosave.js',
			'jquery/plugins/form/formalize/js/jquery.formalize.js',
			'jquery/plugins/form/autocomplete/jquery.autocomplete.js',
			'jquery/plugins/form/validate/jquery.validate.js',
			'jquery/plugins/translator/jquery.translate.min.js',
			'jquery/plugins/feed/jquery.rss.min.js',
			//'jquery/plugins/feed/jquery.gfeed.js'
		);
		
		$JS['local'] = array(
			'asset/js/helper/jquery.rotateThis.js',
			/*** General ***/
			'asset/js/helper/security.js',
			'asset/js/global_init.js',
			'asset/js/dvd_qtip_init.js',
			'asset/js/js_init.js',
			'asset/js/loader_init.js',
			'asset/js/helper/dialog.qtip.js',
			'asset/js/cart_init.js',
			'asset/js/helper/currency.js',
    );
		
		if (!config('uc')){
			$output['loaderContent'] = css_header($CSS).js_header($JS);		
		}
		else
			$output['loaderContent'] = tag_header(FALSE,'asset/css/default.css');
			
    return $output;
  }
	
  // INITIALING PUBLIC STATIC VARIABLE
  function _publicStatic($class)
  {
    // public variable
    self::$link_controller = $class;
    self::$link_view = 'mod_home';
    $output['link_view'] = self::$link_view;
    $output['link_controller'] = self::$link_controller;
    return $output;
  }
	
  // GET DATA RECORDS
  function _dataRecords()
  {
    $output['data_categories'] = $this->tbl_category->get_data_categories();
    return $output;
  }
	
	// GET AND SET THEMES FROM SESSION
	function _set_themes()
	{
		$output['set_themes'] = $this->session->userdata('set_themes');
		return $output;
	}
	
	// INDEX
  function index($op=FALSE,$id=FALSE)
  {
		if($op) {
			switch ($op) {
				case 'dvd':
					$data['bind_url'] = "
						<script language='javascript'>
						$(function() {
							menu_go(1);
						});
						</script>
					";
				break;
				case 'dvd_detail':
					$data['bind_url'] = "
						<script language='javascript'>
						$(function() {
							menu_ajax('".$op."','".$id."');
						});
						</script>
					";
				break;
				case 'cart':
					$data['bind_url'] = "
						<script language='javascript'>
						$(function() {
							menu_go(2);
						});
						</script>
					";
				break;
				case 'tracking':
					$data['bind_url'] = "
						<script language='javascript'>
						$(function() {
							menu_ajax('list_tracking','".$id."');
						});
						</script>
					";
				break;
			}
		} else {
			$data['bind_url'] = "
				<script language='javascript'>
				$(function() {
					menu_go(0);
				});
				</script>
			";
		}
		
		$data['get_og'] = false;
		if (is_fb())
			$data['get_og'] = json_encode($_GET);
			
    $this->load->view('index',$data);
  }
	
	function canvas()
	{
		$data[''] = '';
		$this->load->view('mod_info/canvas',$data);
	}
	
}

/* End of file dvdgames_online.php */
/* Location: ./application/controllers/dvdgames_online.php */