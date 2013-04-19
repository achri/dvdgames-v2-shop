<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_user extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
	
	function get_user($where,$like=FALSE)
	{
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else if ($where)
			$this->db->where('user_email',$where);
			
		if (is_array($like))
			foreach ($like as $field=>$value)
				$this->db->like($field,$value,'before');
		else if ($like)
			$this->db->like('user_email',$like,'before');
			
		return $this->db->get('user');		
	}
	
	function add_user($data)
	{
		$this->db->insert('user',$data);
		return $this->db->insert_id();
	}
	
	function update_user($where,$data)
	{
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else
			$this->db->where('user_email',$where);
		return $this->db->update('user',$data);		
	}
}