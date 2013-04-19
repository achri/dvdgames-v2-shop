<?php if ( ! defined('BASEPATH')) exit($this->obj->lang->line('basepath'));

class jne
{
	protected $obj;
	
  function __construct() 
	{
		$this->obj =& get_instance();
		$this->obj->load->library('tiki_core');
  }
  
  function autocomplete_tariff() 
	{
		$q = strtoupper($this->obj->input->get('q'));
		if ($wilayah = $this->obj->tiki_core->jne_destination($q))
			return $wilayah;
		else {
			$query = "select sync_code, sync_name from master_sync_jne where sync_name like '".$q."%'";
			$get_jne = $this->obj->db->query($query);
			if ($get_jne->num_rows() > 0)
				foreach ($get_jne->result() as $rows)
					if (strpos($rows->sync_name, $q) !== false)
						echo $rows->sync_name."|".$rows->sync_code."\n";
			//else
				//echo "- Tidak Tersedia -";
		}
  }
  
  function get_tariff() 
	{
		
		// CARI DATA LOKAL
		$kode_tujuan = $this->obj->input->post('destination_code');
		$query = "select sync_id,sync_name,sync_ss,sync_reg,sync_yes,sync_oke from master_sync_jne where sync_code = '".$kode_tujuan."'";
		$qtariff = $this->obj->db->query($query);
		
		$sync_name = $this->obj->input->post('destination');
		
		if ($qtariff->num_rows() > 0)
		{
			$tarif['SS'] = $qtariff->row()->sync_ss;
			$tarif['REG'] = $qtariff->row()->sync_reg;
			$tarif['YES'] = $qtariff->row()->sync_yes;
			$tarif['OKE'] = $qtariff->row()->sync_oke;
			
			$sync_id = $qtariff->row()->sync_id;
			$sync_name = $qtariff->row('sync_name');
		}			
		else
		{			
			$data_post['origin_code'] = $this->obj->input->post('origin_code');
			$data_post['destination_code'] = $this->obj->input->post('destination_code');
			$data_post['weight'] = $this->obj->input->post('weight'); 
			
			$destination = $this->obj->input->post('destination');
			
			// GET FROM TIKI CORE
			$tarif = $this->obj->tiki_core->jne_tariff($data_post);
			
			// SYNC DATA JNE
			// bandingkan data lokal dengan online jne
			$data_lokal = $this->obj->db->query('select * from master_sync_jne where sync_code = "'.$data_post['destination_code'].'"');
			$count = $data_lokal->num_rows();
			if ($count <= 0 && sizeOf($tarif) > 0):
				// simpan wilayah baru
				$add['sync_name'] = $destination;
				$add['sync_code'] = $data_post['destination_code'];
				$add['sync_ss']  = isset($tarif['SS']) ? $tarif['SS'] : 0;
				$add['sync_reg'] = isset($tarif['REG']) ? $tarif['REG'] : 0;
				$add['sync_yes'] = isset($tarif['YES']) ? $tarif['YES'] : 0;
				$add['sync_oke'] = isset($tarif['OKE']) ? $tarif['OKE'] : 0;
					
				$this->obj->db->insert('master_sync_jne',$add);
				$sync_id = $this->obj->db->insert_id();
			elseif($count == 1):
				// bandingkan harga lama dan baru
				$update = array();
				if (($data_lokal->row('sync_ss') != $tarif['SS']) && ($tarif['SS'] != 0)):
					$update['sync_ss'] = $tarif['SS'];
				elseif (($data_lokal->row('sync_reg') != $tarif['REG']) && ($tarif['REG'] != 0)):
					$update['sync_reg'] = $tarif['REG'];
				elseif (($data_lokal->row('sync_yes') != $tarif['YES']) && ($tarif['YES'] != 0)):
					$update['sync_yes'] = $tarif['YES'];
				elseif (($data_lokal->row('sync_oke') != $tarif['OKE']) && ($tarif['OKE'] != 0)):
					$update['sync_oke'] = $tarif['OKE'];
				endif;
				// ubah tarif lama
				if (sizeof($update) > 0):
					$this->obj->db->where('sync_code',$data_post['destination_code']);
					$this->obj->db->update('master_sync_jne',$update);	
				endif;
				
				$sync_id = $data_lokal->row('sync_id');
				$sync_name = $data_lokal->row('sync_name');
			endif;
					
		}	
				
		foreach($tarif as $key=>$val)
			if($val=='0'||$val==0||!$val)
				unset($tarif[$key]);
			
		if (sizeOf($tarif) > 0) {			
			$tarif['sync_id'] = $sync_id;
			$tarif['destination'] = $sync_name;
			return json_encode($tarif);
		}
		
  }
	
	/*
	FUTURED TIKI SERVICE
	==========================
	--------------autocomplete-------------
	$text ='<ul><li id="autocomplete_486" rel="486" class="classA">BANDA ACEH</li><li id="autocomplete_498" rel="498" class="classB">BANDAR LAMPUNG</li><li id="autocomplete_501" rel="501" class="classA">BANDUNG</li><li id="autocomplete_515" rel="515" class="classB">BANJARMASIN</li><li id="autocomplete_516" rel="516" class="classA">BANJARBARU</li><li id="autocomplete_524" rel="524" class="classB">BANYUWANGI</li><li id="autocomplete_599" rel="599" class="classA">BANTUL</li><li id="autocomplete_867" rel="867" class="classB">BANDARSERIBENTAN</li><li id="autocomplete_889" rel="889" class="classA">BANYUMAS</li></ul>';
	
	$search = array('<ul>','</ul>','</li>','<li id="autocomplete','" class="classA"','" class="classB"');
	
	$rep = str_replace($search,"",$text);
	$exp = explode('_',$rep);
	
	unset($exp[0]);
	foreach ($exp as $row) {
		$arr[] = explode('>',substr($row,strpos('" rel="',$row)+10,strlen($row)));
	}
	
	echo json_encode($arr);
	
	---------- tariff ----------------
	$data['Origin'] = 'BANDUNG';
	$data['originid'] = 501;
	$data['txtDestinationName'] = 'JAKARTA';
	$data['txtDestinationID'] = 446;
	$data['Quantity'] = 1;
	$text = $this->curl->simple_post('http://www.tiki-online.com/shipping_solution/inquiry',$data);
	if (!$text) return;
	
	$arr1 = explode('<div id="content-bottoms-left">',$text);
	$arr2 = explode('<div id="content-bottoms-right"',$arr1[1]);
	$arr3 = explode('<div class="box_bc"></div>',$arr2[0]);
	$arr4 = explode('</tr>',$arr3[1]);
	//$arr4 = '<table border=0 class="content" width="557"><tr><td><table>'.$arr4[0].'</table>';
	//$arr4 = explode("<tr><td>", $arr3);
	//$arr4 = array_slice($arr4,1);
	//echo $arr4;
	unset($arr4[0],$arr4[5]);
	echo json_encode($arr4);
	
	*/
}
?>