<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_jne extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
  
  function get_sync_jne($where)
  {
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else
			$this->db->where('sync_id',$where);
			
    return $this->db->get('master_sync_jne');
  }
  
}