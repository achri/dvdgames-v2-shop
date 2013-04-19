<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_invoice extends CI_Model
{
  function __construct()
  {
    parent::__construct();
		$CI =& get_instance();
		$this->cart_session = $CI->session->userdata('cart_session');
		$this->cart_status = $CI->session->userdata('cart_status');
  }
	
	// GLOBAL GET DATA INVOICE
	function get_invoice($where)
	{
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else
			$this->db->where('inv_id',$where);
		return $this->db->get('invoice');		
	}
	
	// GET DATA INVOICE ORDER per SESSION
	function get_invoice_order()
	{
		/*
		select 
		inv.inv_id, inv.inv_no, inv.inv_tgl, inv.qty_total, inv.dvd_total, inv.dvd_harga, inv.bonus_total, inv.bonus_harga, inv.grand_total, inv.tariff, inv.grand_total_all, inv.paket,
		u.user_nama, u.user_email, u.user_alamat, u.user_pobox, u.user_telp, u.user_fb_site,
		jne.sync_name, jne.sync_ss, jne.sync_reg, jne.sync_yes, jne.sync_oke
		from cart as c
		inner join invoice as inv on inv.inv_id = c.inv_id and inv.cart_id = c.cart_id
		inner join user as u on u.user_id = inv.user_id
		inner join master_sync_jne as jne on jne.sync_id = inv.sync_id
		where c.cart_session = '2sna0se74q0961hjt5avakeqn5'
		*/
		$cart_session = $this->cart_session;
		$this->db->select("
			inv.inv_id, inv.inv_no, inv.inv_code, inv.inv_tgl, inv.grand_total_all, inv.tiki_paket, inv.tiki_tariff,
			c.cart_id, c.qty_total, c.dvd_total, c.dvd_harga, c.bonus_total, c.bonus_harga, c.grand_total, 
			u.user_nama, u.user_email, u.user_alamat, u.user_pobox, u.user_telp, u.user_fb_site,
			jne.sync_name, jne.sync_ss, jne.sync_reg, jne.sync_yes, jne.sync_oke
		");
		$this->db->from('invoice as inv');
		$this->db->join('cart as c','c.inv_id = inv.inv_id');
		$this->db->join('user as u','u.user_id = inv.user_id');
		$this->db->join('master_sync_jne as jne','jne.sync_id = inv.sync_id');
		$this->db->where('c.cart_session',$cart_session);
		$this->db->where('c.cart_status',1);
		//$this->db->where('c.cart_id','inv.cart_id');
		return $this->db->get();
	}
	
	// GET DATA INVOICE ORDER per SESSION
	function get_invoice_orderdet()
	{
		$cart_session = $this->cart_session;
		$this->db->select("
			dvd.dvd_nama, dvd.dvd_jumlah, 
			cd.qty, cd.jml_dvd, cd.total_harga
		");
		$this->db->from('invoice as inv');
		$this->db->join('cart as c','c.inv_id = inv.inv_id');
		$this->db->join('cart_detail as cd','cd.cart_id = c.cart_id');
		$this->db->join('master_dvd as dvd','dvd.dvd_id = cd.dvd_id');
		$this->db->where('c.cart_session',$cart_session);
		$this->db->where('c.cart_status',1);
		return $this->db->get();
	}
	
	// ADD INVOICE
	function add_invoice($data)
	{
		return $this->db->insert('invoice',$data);
	}
	
	// UPDATE INVOICE
	function update_invoice($where,$data)
	{
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else
			$this->db->where('inv_id',$where);
		
		$this->db->update('invoice',$data);	
		return $this->get_invoice($where)->row()->inv_id;
	}
		
	function delete_invoice($where)
	{
		if(is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else
			$this->db->where('cart_id',$where);
			
		return $this->db->delete('invoice');
	}
}