<?php if ( ! defined('BASEPATH')) exit('cant access');

// include dean javascript packer for php http://dean.edwards.name/
include_once(APPPATH.'libraries/packer/class.JavaScriptPacker.php');
// include cssmin for php http://code.google.com/p/cssmin/
include_once(APPPATH.'libraries/packer/cssmin-v3.0.1.php');
include_once(APPPATH.'libraries/packer/CssUrlPrefixMinifierPlugin.php'); // url fix for image and all

class Packer 
{
	var $minifyPath = array(); // source target path packer
	var $isCSS = FALSE; // source is css or not
	var $sourcePath;	// the real path of source
	var $sourceExt = array(0=>'.js',1=>'.css'); // extension source
	var $sourceModTime = array(); // set source file modification time
	var $packedExt = array(0=>'.packed.js',1=>'.packed.css'); // extension packed
	var $contentSrc = array(); // populate the source content for combine
	
	// CONSTRUCTOR
	function __construct()
	{
		$this->CI =& get_instance();
		$minifyPath = $this->CI->config->item('url_packed');	// get config of minify path
		$jsPath = $minifyPath['js'];	// set new minify js path
		$cssPath = $minifyPath['css']; // set new minify css path
		$this->minifyPath = array(0=>$jsPath,1=>$cssPath); // set for new path TRUE for JS or FALSE for CSS
	}
	
	/*
	CREATE A MINIFY FILE PACKED
	params: string
	return: null
	*/
	protected function _packIt($fileName)
	{
		$content = implode(';',$this->contentSrc); // convert arr to string
		
		// packer for css by cssmin
		if ($this->isCSS) {
			$packer = new CssMinifier($content,array(), array(
				"UrlPrefix" => array( "BaseUrl" => 'asset/css/' )
				)
			);
			$packed = $packer->getMinified();
		} 
		// packer for javascript by dean packer
		else {
			$packer = new JavaScriptPacker($content, 'Normal', true, false);
			$packed = $packer->pack();
		}
		
		file_put_contents($fileName,$packed); // create a new packed		
		log_message('dvd','Packer/PackIt->'.$fileName);		
	} 
	
	/*
	CREATE MINIFY FOLDER AND ORIGIN FILE CONTENT
	params:null
	return:null
	*/
	protected function _prepIt()
	{
		// check the folder exist
		$assetFolder = str_replace(base_url(),'',$this->minifyPath[$this->isCSS]);
		if(FALSE === is_dir($assetFolder))
			@mkdir($assetFolder);
				
		$this->contentSrc[] = file_get_contents($this->sourcePath); // get file content
		log_message('dvd','Packer/GetContent->'.$this->sourcePath);		
	}
	
	/* 
	REMOVE THE OLDER MINIFY
	params: string
	return: void
	*/
	protected function _delIt($fileName)
	{
		$setDir  = str_replace(base_url(),'',$this->minifyPath[$this->isCSS]); // parse the asset minify without host name
		$arrFile = explode('.',basename($fileName));	// explode newname into array
		$setName = implode('.',array_splice($arrFile,0,(count($arrFile) - 3))); // erase the {time}.packed.js on array and implode the new array
		$findFile = glob($setDir.'{'.$setName.'}*',GLOB_BRACE); // find file like set name on folder
		//$findFile = new DirectoryIterator("glob://".$setDir.".*");
		
		log_message('dvd','Packer/Del/Init->'.$setName.'->'.json_encode($findFile));
		
		$return = array();
		foreach ($findFile as $delFile)
		{
			@chmod($delFile,0777);	// change the file to full access
			if (@unlink($delFile))	// remove the old file
			{
				log_message('dvd','Packer/Del->'.$delFile);
				$return[] = TRUE;
			}	else
				$return[] = FALSE;
		}
		
		if (!in_array(FALSE,$return))
			return TRUE;
	}
		
	/*
	CHECK FILE EXIST
	params: string, void
	return: string
	*/
	protected function _checkIt($fileName,$combine=FALSE)
	{
		$fileNamePath = str_replace(base_url(),'',$this->minifyPath[$this->isCSS]).$fileName;
		$fileNamePath_full = $this->minifyPath[$this->isCSS].$fileName;
		
		// NORMAL MINIFY
		if (!WEB_COMBINE && FALSE === file_exists($fileNamePath))
		{
			if ($this->_delIt($fileNamePath)) {
				$this->_prepIt();
				$this->_packIt($fileNamePath);
			}
			log_message('dvd','Packer/Check->'.$fileNamePath);
		}
		
		// COMBINE MINIFY
		if ($combine && WEB_COMBINE && FALSE === file_exists($fileNamePath)) {
			if ($this->_delIt($fileNamePath)) {
				$this->_packIt($fileNamePath);
				log_message('dvd','Packer/Check/Combine->'.$fileNamePath);
			}
		} elseif (!$combine && WEB_COMBINE)
			$this->_prepIt();
		
		return $fileNamePath_full;
	}
	
	/*
	PARSE PATH TO NEW PACKED
	param	: string
	return: string
	*/
	protected function _parseIt($sourcePath)
	{
		$this->sourcePath = $sourcePath; // keep origin
		$fileName = basename($sourcePath); // get filename
		$fileName_nonext = basename($sourcePath,$this->sourceExt[$this->isCSS]); // get filename
		$fileModTime = $this->_getFileModTime($sourcePath); // get file time modif
		$this->sourceModTime[$fileName] = $fileModTime;
		$packedName = $fileName_nonext.'.'.$fileModTime.$this->packedExt[$this->isCSS]; // new packed name
		
		return $this->_checkIt($packedName);
	}
	
	/* 
	GENERATE PACKED FROM SOURCE
	params: string/array, void
	return: string/array
	*/
	public function generate($sourcePath,$CSS=FALSE)
	{			
		$this->isCSS = $CSS;
		
		if(is_array($sourcePath))
			foreach ($sourcePath as $getPath)
				$return[] = $this->_parseIt($getPath);
		else
			$return = $this->_parseIt($sourcePath);
		
		// COMBINE THE SOURCE
		if (WEB_COMBINE){
			unset($return);
			$return[] = $this->_combine();
		}
		
		log_message('dvd',json_encode($this->sourceModTime));
		
		unset($this->contentSrc,$this->sourceModTime);
		return $return;
	}
	
	// combine source to one file per controller
	protected function _combine($set=FALSE)
	{
		arsort($this->sourceModTime); // sort of newer mod			
		$combineUnix = substr(md5($this->CI->router->class.$this->CI->router->method),0,6); // set controller and function unix
		$combineName = 'combine.'.$combineUnix.'.'.current($this->sourceModTime).$this->packedExt[$this->isCSS];
		
		if (!$set)
			$combineName = $this->_checkIt($combineName,TRUE);
		
		return $combineName;
	}
	
	/*
	GET FILE MODIFIED VIA CURL
	param : string
	return: integer
	*/
	protected function _getFileModTime($fullpath)
	{
		$curl = curl_init($fullpath);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FILETIME, true);

		$result = curl_exec($curl);
		if ($result === false) {
				die (curl_error($curl)); 
		}
	
		return curl_getinfo($curl, CURLINFO_FILETIME);	
	}
}

/* END OF FILE packer.php */
