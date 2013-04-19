<?php if ( ! defined('BASEPATH')) exit($this->obj->lang->line('basepath'));

class Tiki_core
{
	protected $obj;
	function __construct()
	{	
		$this->obj =& get_instance();
	}
	
	/*
	GET JNE WILAYAH
	desc   : $destination string of destination name
	params : string
	return : string
	*/
	function jne_destination($destination)
	{
		$destination = strtoupper($destination);
		return $this->obj->curl->simple_post('http://www.jne.co.id/tariff.php?q='.$destination);
	}
	
	/*
	GET JNE TARIFF
	$obj->tiki_core->jne_tariff($data_post);
	desc	 : $data_post array of field origin_code, destination_code and weight
	params : array or string
	return : array
	*/
	function jne_tariff($data_post)
	{
		//$tarif	= array('SS'=>'0', 'YES'=>'0', 'REG'=>'0', 'OKE'=>'0', 'PAKET'=>'0', 'DOKUMEN'=>'0');
		$tarif	= array();
		
		if (is_array($data_post))
		{
			foreach ($data_post as $post=>$val)
				$post_data[] = $post .'='. $val;
			$data_post = implode('&',$post_data);
		}
		
		$text = $this->obj->curl->simple_post('http://www.jne.co.id/index.php?mib=tariff&amp;lang=IN',$data_post);
		if(empty($text)) return;
		
		$arr1 = explode('<table border="0" bgcolor="#fff" cellspacing="1">',$text);
		$arr2 = explode('<td align="left" valign="top">&nbsp;</td>',$arr1[1]);
		$arr3 = '<table border=1><tr><td><table>'.$arr2[0].'</table>';
		$arr3 = explode("<tr class='trfC'><td>", $arr3);
			
		$i = 0; $uss = 0; $temp = 0; $pnd = 0;
		foreach($arr3 as $item)
		{
			if($i>0)
			{
				$obj = strip_tags($item);
				$cao = explode('SS ', $obj);
				if(count($cao)>1) $pnd = 1;

				$cao = explode('YES ', $obj);
				if(count($cao)>1) $pnd = 2;

				$cao = explode('REG ', $obj);
				if(count($cao)>1) $pnd = 3;

				$cao = explode('OKE ', $obj);
				if(count($cao)>1) $pnd = 4;

				$last = explode('Rp.', $obj);
				if(count($last)<2)
				{
					$last = explode('$ ', $obj);
					$uss  = 1;
				}
				$nilai = end($last);
				$nilai = trim($nilai);
				$nilai = str_replace(',', '', $nilai);
				$nilai = str_replace('.00', '', $nilai);
				if($uss>0)
				{
					//$nilai	= $nilai*10000;
					if($temp>0)
					{
						$tarif['PAKET'] = $nilai>$temp ? $nilai : $temp;
						$tarif['DOKUMEN'] = $nilai<$temp ? $nilai : $temp;
					}
					else $temp	= $nilai;
				}
				else
				{
					switch($pnd)
					{
						case 1:
							$tarif['SS'] = is_numeric($nilai) && $nilai > 0 ? $nilai : '0';
							break;
						case 2:
							$tarif['YES'] = is_numeric($nilai) && $nilai > 0 ? $nilai : '0';
							break;
						case 3:
							$tarif['REG'] = is_numeric($nilai) && $nilai > 0 ? $nilai : '0';
							break;
						case 4:
							$tarif['OKE'] = is_numeric($nilai) && $nilai > 0 ? $nilai : '0';
							break;
					}
				}
			}
			$i++;
		}
		
		return $tarif;
	}

}