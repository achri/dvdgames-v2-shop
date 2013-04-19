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

class List_tracking extends DVD_Controller
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
    //$output += $this->_dataRecords();
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
     
    ));
    $this->load->model(array(
      'jqgrid_model','tbl_cart','tbl_invoice'
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
			'asset/js/mod_list/list_track/track_index.js',
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
    return $output;
  }
	
	function get_data()
	{	
		$inv_no = trim($this->input->get_post('inv_code'));
		$tiki_noresi = trim($this->input->get_post('tiki_noresi'));
		$email = trim($this->input->get_post('email'));
		
		if ($inv_no)
			$where['inv_code'] = $inv_no;
		elseif ($tiki_noresi)
			$where['tiki_noresi'] = $tiki_noresi;
		elseif ($email)
			$where['user_email'] = $email;
		
		$table = "invoice";	
		$result = $this->jqgrid_model->get_data($table,FALSE,$where,FALSE,
		array(
			array(
				'table'=>'cart',
				'join'=>'cart.cart_id = '.$table.'.cart_id AND cart.cart_status = 2',
				'fields'=>array('cart_tgl','qty_total','dvd_total','dvd_harga','bonus_total','bonus_harga','grand_total'),
				'type'=>'INNER'
			),
			array(
				'table'=>'user',
				'join'=>'user.user_id = '.$table.'.user_id',
				'fields'=>array('user_nama','user_email'),
				'type'=>'INNER'
			),
			array(
				'table'=>'master_sync_jne',
				'join'=>'master_sync_jne.sync_id = '.$table.'.sync_id',
				'fields'=>array('sync_name'),
				'type'=>'INNER'
			)
		),array(
			'*',
			'(
				CASE inv_status
					WHEN 0 THEN "Belum Transfer" 
					WHEN 1 THEN "Belum Dikirim" 
					WHEN 2 THEN "Telah Dikirim" 
					WHEN 3 THEN "Telah Ditunda" 
					WHEN 4 THEN "Telah Dibatalkan" 
					WHEN 5 THEN "Expired" 
				END
			) as inv_status'
		),FALSE,FALSE,FALSE);

		if (false == empty($result['raw_data']))
			unset($result['raw_data']);
			
		echo json_encode($result);
	}
	
	function set_data()
	{
	
	}
	
	// INDEX
	function index($inv_code=FALSE)
	{
		$data['inv_code']= $inv_code;
		$this->load->view(self::$link_view.'/track_index',$data);
		$this->load->view('gAnalystic');
	}
	
	function tracking($inv_code)
	{
		
	}
	
	// TRACKING DARI JNE
	function track_jne($tiki_noresi)
	{
		$text = $this->curl->simple_post('http://www.jne.co.id/index.php?mib=tracking.detail&awb='.$tiki_noresi.'&awb_list='.$tiki_noresi);
		if (!$text) {
			echo "Koneksi error ... untuk informasi selanjutnya klik di <a href='http://www.jne.co.id/index.php?mib=tracking.detail&awb=".$tiki_noresi."&awb_list=".$tiki_noresi."' target='_blank'>sini</a>";
			return;
		}
		
		$arr1 = explode('<td align="left" valign="top" class="content">',$text);
		$arr2 = explode('<td align="left" valign="top">&nbsp;</td>',$arr1[1]);
		$arr3 = '<table border=0 class="content" width="557"><tr><td><table>'.$arr2[0].'</table>';
		$arr3 .= "Informasi selengkapnya di <a href='http://www.jne.co.id/index.php?mib=tracking.detail&awb=".$tiki_noresi."&awb_list=".$tiki_noresi."' target='_blank'>www.jne.co.id</a>";
		echo "
		<style type='text/css'>
		.content {font: normal 12px Arial;line-height: 16px;}
		.trackH {background: #1e3377;text-align: center;color: #fff;}
		.trackC {background: #e0e0e0;text-align: left;color: #000;}
		.trfH {background: #1e3377;color: #fff;margin-left: 2px;}
		.trfC {background: #e0e0e0;text-align: left;color: #000;}
		</style>";
		echo $arr3;
	}
	
	
}