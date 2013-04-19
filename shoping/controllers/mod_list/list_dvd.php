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

class List_dvd extends DVD_Controller
{
  // PUBLIC STATIC VARIABLE
  public static $link_controller, $link_view;
	
  // CONSTRUCTOR
  function __construct() 
  {
    parent::__construct();
    $class = strtolower(get_class($this));
    $this->_loader();
    $output = array();
    $output += $this->_headerContent();
    $output += $this->_publicStatic($class);
    $output += $this->_dataRecords();
    //$output += $this->_variable();

    $this->load->vars($output);

    log_message('dvd', "Controller ($class) init executed.");
  }
	
  // LOADER 
  function _loader()
  {
    $this->load->library(array(
     
    ));
    $this->load->helper(array(
      "text",
    ));
    $this->load->model(array(
      'tbl_category','tbl_dvd'
    ));
  }
	
  // LOADER JS AND CSS
  function _headerContent()
  {
    $localCSS = array(
			/*** general ***/
			//'asset/css/mod_list/list_dvd/dvd_index.css',
    );
		
    $localJS = array(
			/*** general ***/
			'asset/js/mod_list/list_dvd/dvd_index.js',
    );

		$output['headerContent'] = tag_header($localJS,$localCSS);

    return $output;
  }
	
  // INITIALING PUBLIC STATIC VARIABLE
  function _publicStatic($class)
  {
    // public variable
    self::$link_controller = 'mod_list/'.$class;
    self::$link_view = 'mod_list/'.$class;
    $output['link_view'] = self::$link_view;
    $output['link_controller'] = self::$link_controller;
		$output['link_controller_cart'] = 'mod_list/list_cart';
    return $output;
  }
	
  // GET DATA RECORDS
  function _dataRecords()
  {
    $output['data_categories'] = $this->tbl_category->get_data_categories();
    return $output;
  }
	
  // INDEX
  function index($kat_id = FALSE, $dvd_nama = FALSE, $page = FALSE)
  {
		$where = FALSE;
		$like = FALSE;
		
		$kat_id = !$kat_id ? $this->input->post('kat_id') : $kat_id;
		if ($kat_id)
			$where['kat_id'] = $kat_id;
			
		$dvd_nama = !$dvd_nama ? $this->input->post('dvd_nama') : $dvd_nama;
		if ($dvd_nama)
			$like['both']['dvd_nama'] = $dvd_nama;
			
		$page = !$page ? $this->input->post('page') : $page;
		
		// MANUAL PAGINA
		$pos = config('dvd_limit');
		
		$total_pages = ceil($this->tbl_dvd->get_dvd($where,$like)->num_rows() / $pos);
      
    if ($page > $total_pages)
      $page = $total_pages;
			
    $limitstart = $pos * $page - $pos; 
    $limitstart = ($limitstart < 0)?0:$limitstart;
    if( !isset($limitstart) || $limitstart == '' )
      $limitstart = 0;
    if( isset($limitstart) && !empty($pos) )
      $pos = $limitstart;
					
		$limit['pos'] = $pos;
		$limit['max'] = config('dvd_limit');
		
		$order['dvd_nama'] = 'ASC';
		
    $data['data_dvd'] = $this->tbl_dvd->get_dvd($where,$like,$limit,$order);
		$data['kat_id'] = $kat_id;
		$data['dvd_nama'] = $dvd_nama;
		$data['pos'] = $pos;
		$data['page'] = !$page ? 1 : $page;
		$data['total_pages'] = $total_pages;
    $this->load->view(self::$link_view.'/dvd_index',$data);
		$this->load->view('gAnalystic');
  }
	
  // GET DVD DETAIL BY ID
  function show_detail_dvd($dvd_id=false)
  {
		if (!$dvd_id)
			$dvd_id = $this->input->post('dvd_id');
			
    $data['data_dvd'] = $this->tbl_dvd->get_detail_dvd($dvd_id);
		
		$CSS = array('asset/css/mod_list/list_dvd/dvd_detail.css');
		
		$JS = false;
		if(config('youtube'))
			$JS = array('asset/js/mod_list/list_dvd/dvd_detail.js');
		
		$data['extraContent'] = tag_header($JS,$CSS);
		
    $this->load->view(self::$link_view.'/dvd_detail',$data);
  }
	
	function dvd_detail($dvd_id)
	{
		
	}
	
	function get_youtube($name)
	{
		$post['?q'] = $name."%20trailers%20HD%20official%20pc%20games";
		$post['start-index'] = 1;
		$post['max-results'] = 20;
		$post['v'] = 2;
		$post['alt'] = 'jsonc';
		//&rel=1&alt=json
		//echo json_encode($post).'<br/>';
		$result = $this->curl->simple_post("http://gdata.youtube.com/feeds/api/videos?",implode('&',$post)); 
		if (!$result) return;
		$result = json_decode($result);
		
		echo $result->data->totalItems.'<br/>';
		foreach ($result->data->items as $row)
			echo $row->title.'<br/>';
	}
	
	// NEW DVD
	function new_dvd()
	{
		$sql = "
			select md.*,count(cd.dvd_id) as c
			from cart_detail cd, master_dvd md
			where cd.dvd_id = md.dvd_id
			group by cd.dvd_id
			order by c desc
			limit 1
		";
		$get_dvd = $this->db->query($sql);//$this->tbl_dvd->get_dvd(array('dvd_gambar !='=>''),FALSE,FALSE,array('created'=>'desc'));
		if ($get_dvd->num_rows() > 0)
			echo $get_dvd->row()->dvd_id.'|'.$get_dvd->row()->dvd_nama.'|'.config('asset_upload').'thumb/'.$get_dvd->row()->dvd_gambar;
	}
	
	// BEST DVD
	function best_dvd($type='new')
	{
		switch ($type):
			case 'new' :
				$query = "
					select * from master_dvd order by created desc limit 0,30
				";
			break;
			case 'best' :
				$query = "
					select md.*,count(cd.dvd_id) as c
					from cart_detail cd, master_dvd md
					where cd.dvd_id = md.dvd_id
					group by cd.dvd_id
					order by c desc
					limit 0,30
				";
			break;
		endswitch;
		$get_best = $this->db->query($query);
		if ($get_best->num_rows() > 0) {
			$json['url'] = $this->config->item('asset_upload');
			$json['dvd'] = $get_best->result();
			echo json_encode($json);
		}
	}
}

/* End of file dvdgames_online.php */
/* Location: ./application/controllers/dvdgames_online.php */