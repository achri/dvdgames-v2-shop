<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_counter extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
	
	// FIELD = inv_no
	function get_counter($field) 
	{
		$date['tahun'] = date('Y');
		$date['bulan'] = date('m');
		
		$this->db->where($date);
		$get = $this->db->get('sys_counter');
		if ($get->num_rows() > 0)
		{
			$counter_no = $get->row()->$field;
		} else {
			$this->db->insert('sys_counter',$date);
			$counter_no = 1;
		}
		
		$this->_update_counter($date,$field,$counter_no);
		return $counter_no;
	}
	
	protected function _update_counter($date,$field,$counter_no)
	{	
		$counter_no++;
		$this->db->where($date);
		$this->db->update('sys_counter',array($field=>$counter_no));
	}
	
}