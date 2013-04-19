<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));
/*
 @author		Achri
 @date creation	07/10/2011
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

class List_cart extends DVD_Controller
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
      'jne',
    ));
    $this->load->helper(array(
      "rupiah",
    ));
    $this->load->model(array(
      'jqgrid_model','tbl_dvd','tbl_cart','tbl_user','tbl_counter','tbl_invoice','tbl_jne'
    ));
  }
	
  // LOADER JS AND CSS
  function _headerContent()
  {		
    $localCSS = array(
    
    );
		
    $localJS = array(
			'asset/js/mod_list/list_cart/cart_index.js',
			//'asset/js/mod_list/list_cart/cart_grid.js',
    );
		//$JS = array('asset/js/mod_list/list_cart/cart_grid.js');
		//$data['gridContent'] = tag_header($JS);
		
		//$output['headerContent'] = tag_header('jquery/plugins/integration/jquery.metadata.js',false,true);
		$output['headerContent'] = tag_header($localJS);

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
	
  // GET DATA RECORDS
  function _dataRecords()
  {
    $output['data_current_cart'] = $this->tbl_cart->get_data_cart();
    //$output['data_bank'] = $this->db->query('select * from master_bank where bank_status = 1 order by bank_nama');
    return $output;
  }
	
	// @info	: Populate data json to grid
	// @access	: public
	// @params	: POST string
	// @params	: string	$kat_id
	// @return	: JSON array string
	public function get_data()
	{
		// get from tracking
		$inv_id = $this->input->get_post('inv_id');
		
		$condition = 'AND cart.cart_session = "'.sessions('cart_session').'" AND cart.cart_status = 0';
		if ($inv_id)
			$condition = 'AND cart.inv_id = '.$inv_id.' AND cart.cart_status = 2';
		
		$table = "cart_detail";		
		$result = $this->jqgrid_model->get_data($table,FALSE,FALSE,FALSE,array(
			array(
				'table'=>'cart',
				'join'=>'cart.cart_id = '.$table.'.cart_id ' . $condition,
				'fields'=>array('cart_session'),
				'type'=>'INNER'
			),
			array(
				'table'=>'master_dvd',
				'join'=>'master_dvd.dvd_id = '.$table.'.dvd_id',
				'fields'=>array('kat_id','dvd_nama','dvd_jumlah'),
				'type'=>'INNER'
			),
			array(
				'table'=>'master_kategori',
				'join'=>'master_kategori.kat_id = master_dvd.kat_id',
				'fields'=>array('kat_nama'),
				'type'=>'INNER'
			)
		),array(
			'*',
			"(
				select 
				sum(qty)
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_dvd_games",
			"(
				select 
				sum(jml_dvd)
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_dvd_jumlah_tot",
			"(
				select 
				sum(total_harga)
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_total_harga",
			"(
				select 
				floor(sum(jml_dvd)/".config('bonus_dvd').")
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_bonus_jumlah",
			"(
				select 
				(floor(sum(jml_dvd)/".config('bonus_dvd').")*".config('harga_dvd').")
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_bonus_harga",
			"(
				select 
				(sum(total_harga) - floor(sum(jml_dvd)/".config('bonus_dvd').")*".config('harga_dvd').")
				from ".$table."
				where cart_id = cart.cart_id
			) as udata_grand_total"
		),FALSE,FALSE,
		array(
			'qty'=>'udata_dvd_games',
			'dvd_games'=>'udata_dvd_games',
			'jml_dvd'=>'udata_dvd_jumlah_tot',
			'dvd_jumlah_tot'=>'udata_dvd_jumlah_tot',
			'dvd_harga'=>'udata_total_harga',
			'total_harga'=>'udata_total_harga',
			'bonus_jumlah'=>'udata_bonus_jumlah',
			'bonus_harga'=>'udata_bonus_harga',
			'grand_total'=>'udata_grand_total'
		));

		if (false == empty($result['raw_data']))
			unset($result['raw_data']);
			
		echo json_encode($result);
	}
	
	// @info	: Manipulate data from grid
	// @access	: public
	// @params	: POST string
	// @return	: JSON array string
	public function set_data()
	{
		$where['cart_id'] = $this->input->get_post('cart_id');
		$where['dvd_id'] = $this->input->get_post('dvd_id');
		$table = "cart_detail";	
		
		$extra = false;
		
		$dvd_jumlah = $this->input->get_post('dvd_jumlah');
		$dvd_order = $this->input->get_post('qty');
		$dvd_harga = $this->config->item('harga_dvd');
		$extra['jml_dvd'] = $dvd_order * $dvd_jumlah;
		$extra['total_harga'] = ($dvd_order * $dvd_jumlah) * $dvd_harga;
		
		$this->jqgrid_model->set_data($table,FALSE,$where,FALSE,$extra);
	}
		
  // INDEX
  function index()
  {
    $data[''] = '';
    $this->load->view(self::$link_view.'/cart_index',$data);
    $this->load->view('gAnalystic');
  }
	
	// CART SIDEBAR
	function cart_sidebar()
  {
    //$data['extraContent'] = tag_header('asset/js/mod_list/list_cart.js');
		$sql = "select 
			(sum(cd.total_harga) - floor(sum(cd.jml_dvd)/".config('bonus_dvd').")*".config('harga_dvd').") as tot_harga, sum(cd.jml_dvd) as tot_dvd, floor(sum(cd.jml_dvd)/".config('bonus_dvd').") as bonus_dvd
			from cart as c
			inner join cart_detail as cd on cd.cart_id = c.cart_id
			where c.cart_session = '".sessions('cart_session')."' and c.cart_status in (0,1)
		";
		$data['cart_summary'] = $this->db->query($sql);
    $this->load->view(self::$link_view.'/cart_sidebar',$data);
  }
	
	// ADD TO CART
	function add_to_cart($dvd_id)
	{
		if ($this->tbl_cart->add_to_cart($dvd_id))
			echo $dvd_id;
	}
	
	// DROP
	function drop_from_cart($cart_id,$dvd_id)
	{
		$where['cart_id'] = $cart_id;
		$where['dvd_id'] = $dvd_id;
		echo $this->tbl_cart->drop_from_cart($where);
	}
	
	// INFORMASI PEMESANAN
	function list_cart_info()
	{
		$data['list_cart'] = $this->tbl_cart->list_cart_info();
		$this->load->view(self::$link_view.'/cart_info',$data);
	}
	
	// AUTOCOMLETE WILAYAH
	function autocomplete_tariff()
	{
		echo $this->jne->autocomplete_tariff();
	}
	
	// CEK HARGA
	function get_tariff() 
	{
		echo $this->jne->get_tariff();
	}
	
	// CEK HARGA / KOTA (LOCAL DATABASE)
	function get_lokal_tariff()
	{
		$where['sync_name'] = $this->input->post('sync_name');
		$get_jne = $this->tbl_jne->get_sync_jne($where);
		if ($get_jne->num_rows() > 0)
			echo $get_jne->row()->sync_code;
	}
	
	function pull_user_data()
	{
		$where['user_email'] = $this->input->get_post('user_email');
		$get_user['user'] = $this->tbl_user->get_user($where)->result();
		echo json_encode($get_user);
	}
	
	// PREPARE TO DUPLICATE INVOICE NO
	function _inv_code_generate($invoice,$inv_no)
	{
		$invoice_gen['inv_no'] = $inv_no;
		$invoice_gen['inv_code'] = strtoupper(substr(md5(date('Y-m-d G:i:s').$inv_no),rand(0,10),6)); // generate invoice code 
		$invoice = array_merge($invoice,$invoice_gen);
		if ($this->tbl_invoice->add_invoice($invoice))
			return $this->db->insert_id();
		else {
			unset($invoice['inv_no'],$invoice['inv_code']);
			$this->_inv_code_generate($invoice,$inv_no);
		}
	}	
	
	// PROSES ORDER
	function proses_order()
	{
		$data = $this->input->post('order');
		$cart_id = $data['cart']['cart_id'];
		
		// POPULATE USER DATA 
		$user['user_email'] = $data['info']['user_email'];
		$get_user = $this->tbl_user->get_user($user);
		if ($get_user->num_rows() > 0) {
			$this->tbl_user->update_user($user,$data['info']);
			$user_id = $get_user->row()->user_id;
		} else
			$user_id = $this->tbl_user->add_user($data['info']);
			
		// POPULATE JNE DATA
		$tiki = explode('|',$data['wilayah']['tariff']);
		unset($data['wilayah']['tariff']);
		$data['wilayah']['tiki_paket'] = $tiki[0];
		$data['wilayah']['tiki_tariff'] = $tiki[1];		
		
		// GET UNIX INVOICE NO
		$inv_no = $this->tbl_counter->get_counter('inv_no');
		
		// POPULATE INVOICE DATA
		$invoice['grand_total_all'] = $data['summary']['grand_total']+$data['wilayah']['tiki_tariff']+$inv_no;
		$invoice['inv_tgl'] = date('Y-m-d G:i:s');
		$invoice['user_id'] = $user_id;
		$invoice = array_merge($invoice,$data['wilayah']);
		
		$where_inv['cart_id'] = $cart_id;
		$get_inv = $this->tbl_invoice->get_invoice($where_inv);
		if ($get_inv->num_rows() > 0) {
			$inv_id = $this->tbl_invoice->update_invoice($where_inv,$invoice);
		} else {
			// GENERATE INVOICE NO
			$invoice['cart_id'] = $cart_id;
			$inv_id = $this->_inv_code_generate($invoice,$inv_no);
		}
		
		// UPDATE CART DATA
		$cart['inv_id'] = $inv_id;
		//$cart['cart_session'] = '';
		$cart['cart_status'] = 1;
		$cart = array_merge($cart,$data['summary']);
		if ($this->tbl_cart->update_cart($cart_id,$cart))
		{
			//$this->session->unset_userdata('cart_session');	// destroy the current cart session
			echo 'SUKSES';
		}
		
		// session dipertahankan bertujuan jika user ingin melihat pemesanan sebelumnya
	}
	
	// INFORMASI PEMESANAN
	function info_pemesanan()
	{
		//$data[''] = '';
		$JS = array('asset/js/mod_list/list_cart/cart_grid.js');
		$data['gridContent'] = tag_header($JS);
		$this->load->view(self::$link_view.'/cart_grid',$data);
	}
	
	// INFORMASI PEHGIRIMAN
	function info_pengiriman()
	{
		$JS['local'] = array(
			'asset/js/mod_list/list_cart/cart_jne.js',
			'asset/js/mod_list/list_cart/cart_validate.js',
			'asset/js/mod_list/list_cart/cart_kirim.js'
		);
		$data['extraContent'] = js_header($JS);
		$this->load->view(self::$link_view.'/cart_order',$data);
	}
	
	// INFORMASI PEMBAYARAN
	function info_pembayaran($var = false)
	{
		$data['data_invoice'] = $this->tbl_invoice->get_invoice_order();
		if ($var) {
			$data = array_merge($data,$var);
			return $this->load->view(self::$link_view.'/cart_transfer',$data, true);
		} else
			$this->load->view(self::$link_view.'/cart_transfer',$data);
	}
	
	// KEMBALI ORDER
	function order_kembali()
	{
		$where['cart_session'] = sessions('cart_session');
		$where['cart_status'] = 1;
		$data['cart_status'] = 0;
		$this->tbl_cart->update_cart($where,$data);
	}
	
	// BATAL ORDER
	function order_batal_all()
	{
		$cart_id = sessions('cart_id');
		$where['cart_id'] = $cart_id;
		$this->tbl_cart->delete_cart($where);
		$this->tbl_cart->delete_cart_detail($where);
		$this->tbl_invoice->delete_invoice($where);
		echo $cart_id;
	}
	
	// KONFIRMASI ORDER
	function order_konfirmasi()
	{		
		$inv_code = $this->order_email();
		
		$where['cart_session'] = sessions('cart_session');
		$where['cart_status'] = 1;
		$data['cart_status'] = 2;
		$data['cart_session'] = '';
		$this->tbl_cart->update_cart($where,$data);
		
		// CLEAR SESSION
		$unset_session['cart_session'] = '';
		$unset_session['cart_id'] = '';
		$unset_session['cart_status'] = '';
		$this->session->unset_userdata($unset_session);
		
		echo $inv_code;
	}
	
	// SEND EMAIL
	function order_email()
	{
		$var['status'] = 'mail';
		$var['dvd_detail'] = $this->tbl_invoice->get_invoice_orderdet();
		$get_data = $this->tbl_invoice->get_invoice_order();
		
		$mail = $this->info_pembayaran($var);
		$email = $get_data->row()->user_email;
		$inv_code = $get_data->row()->inv_code;
		
		$this->load->library('lib_mail');
		if ($this->lib_mail->order_mail($mail,$email,$inv_code))
		{
			$where['cart_id'] = sessions('cart_id');
			$data['resend_mail'] = 1;
			$this->tbl_invoice->update_invoice($where,$data);
		}
		
		return $get_data->row()->inv_code;
	}
	
}

/* End of file dvdgames_online.php */
/* Location: ./application/controllers/dvdgames_online.php */