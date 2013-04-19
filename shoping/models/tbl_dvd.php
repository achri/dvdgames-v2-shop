<?php if ( ! defined('BASEPATH')) exit($this->lang->line('basepath'));

class Tbl_dvd extends CI_Model
{
  function __construct()
  {
    parent::__construct();
  }
	
	function get_dvd($where = FALSE, $like = FALSE, $limit = FALSE, $sort = FALSE)
	{
		// where
		if (is_array($where))
			foreach ($where as $field=>$value)
				$this->db->where($field,$value);
		else if ($where)
			$this->db->where('dvd_id',$where);
		
		// like
		if (is_array($like))
			foreach ($like as $operand=>$fields)
				if (!is_array($fields))
					$this->db->like($operand,$fields);
				else
					foreach ($fields as $field=>$value)
						$this->db->like($field,$value,$operand);
		else if ($like)
			$this->db->like('dvd_nama',$like);
		
		// limit
		if (is_array($limit))
			$this->db->limit($limit['max'],$limit['pos']);
		else if ($limit)
			$this->db->limit($limit);
		
		// order
		if (is_array($sort))
			foreach ($sort as $fields=>$order)
				$this->db->order_by($fields,$order);
		else if ($sort)
			$this->db->order_by('dvd_nama',$sort);
		
		// get record
		return $this->db->get('master_dvd');
	}
  
  function get_data_dvds()
  {
    return $this->db->get('master_dvd');
  }
  
  function get_peritem_dvds($kat_id,$dvd_nama='',$page,$limit=true)
  {
    if ($kat_id)
      $this->db->where('kat_id',$kat_id);
    if ($dvd_nama)
      $this->db->like('dvd_nama',$dvd_nama,'after');
    if ($limit)
      $this->db->limit($this->config->item('dvd_limit'),$page);
    $this->db->order_by('dvd_nama');
    
    return $this->db->get('master_dvd');
  }
  
  function get_detail_dvd($dvd_id)
  {
		$this->db->select("*, (
		select c.cart_id
		from cart_detail as cd inner join cart as c on c.cart_id = cd.cart_id
		where c.cart_session = '".sessions('cart_session')."' and c.cart_status = 0 and cd.dvd_id = md.dvd_id
		) as cart_id");
		$this->db->from('master_dvd as md');
    $this->db->where('md.dvd_id',$dvd_id);
    return $this->db->get();
  }
}