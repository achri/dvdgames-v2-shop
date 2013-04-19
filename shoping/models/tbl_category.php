<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_category extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  
  function get_data_categories()
  {
    $this->db->order_by('kat_nama');
    return $this->db->get('master_kategori');
  }
}