<?php if ( ! defined('BASEPATH')) exit('cant access');

function tag_header($arrJS=FALSE,$arrCSS=FALSE,$asset_src=FALSE)
{
	$CI =& get_instance();
	$host = base_url();
	
	if ($asset_src)
		$host = $CI->config->item('asset_src');
		
	$content = array();
	
	if (is_array($arrCSS))
		foreach ($arrCSS as $css):
			$content['css'][] = $host.$css;
		endforeach;
	elseif ($arrCSS)
		$content['css'][] = $host.$arrCSS;

  if (is_array($arrJS))
		foreach ($arrJS as $js):
			$content['js'][] = $host.$js;
		endforeach;
	elseif ($arrJS)
		$content['js'][] = $host.$arrJS;
		
	// GENERATE MINIFY SCRIPT
	if ($arrJS && $CI->config->item('minify'))
	{
		$CI->load->library('packer');
		$content['js'] = $CI->packer->generate($content['js']);
	}
	
	$return = array();
	
	foreach ($content as $types=>$type) {
		foreach ($type as $val)
			if ($types == 'js')
				$return[] = "<script type=\"text/javascript\" src=\"".$val."\"></script>";
			else
				$return[] = "<link type=\"text/css\" rel=\"stylesheet\" href=\"".$val."\"/>";
	}
				
	return implode((WEB_DEBUG?"\n":""),$return);
}

function css_header($arrCSS)
{
	$CI =& get_instance();
	$content = array();
	$host_remote = $CI->config->item('asset_src');
	$host_local = base_url();
	
	if (is_array($arrCSS))
		foreach ($arrCSS as $type=>$link):
			switch ($type) {
				case 'direct_url': 
					foreach ($link as $css)
						$content['direct_url'][] = $css; 
				break;
				case 'remote': 
					foreach ($link as $css)
						$content['remote'][] = $host_remote.$css; 
				break;
				case 'local' : 
					foreach ($link as $css)
						$content['local'][] = $host_local.$css; 
				break;
			}
		endforeach;
	elseif ($arrCSS)
		$content[] = $host.$arrCSS;
	
	// GENERATE MINIFY CSS
	if ($CI->config->item('minify'))
	{
		$CI->load->library('packer');
		
		$content['local'] = $CI->packer->generate($content['local'],TRUE);
	}
	
	$return = array();	
	foreach ($content as $types=>$type) {
		foreach ($type as $val)
			$return[] = "<style type=\"text/css\">@import \"".$val."\"</style>".(WEB_DEBUG?"\n":"");
	}
	
	return implode($return);
}

function js_header($arrJS)
{
	$CI =& get_instance();
	$content = array();
	$host_remote = $CI->config->item('asset_src');
	$host_local = base_url();
	
	if (is_array($arrJS))
		foreach ($arrJS as $type=>$link):
			switch ($type) {
				case 'direct_url': 
					foreach ($link as $js)
						$content[] = $js; 
				break;
				case 'remote': 
					foreach ($link as $js) 
						$content[] = $host_remote.$js;
				break;
				case 'local' : 
					foreach ($link as $js) 
						$content[] = $host_local.$js;
				break;
			}
		endforeach;
	elseif ($arrJS)
		$content[] = $host_remote.$arrJS;
	
	// GENERATE MINIFY SCRIPT
	if ($CI->config->item('minify'))
	{
		$CI->load->library('packer');
		$content = $CI->packer->generate($content);
	}
	
	$return = '';
	foreach ($content as $js)
			$return .= "<script type=\"text/javascript\" src=\"".$js."\"></script>".(WEB_DEBUG?"\n":"");
	
	return $return;
}



