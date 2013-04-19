<?php if ( ! defined('BASEPATH')) exit('cant access');

/*
* creator Achri 2011
* JAVASCRIPT AND CSS MINIFY GENERATOR
* ==========================================
* Feature:
* 	- combine source to one package
*/

// include dean javascript packer for php http://dean.edwards.name/
include_once(APPPATH.'libraries/packer/class.JavaScriptPacker.php');
// include cssmin for php http://code.google.com/p/cssmin/
include_once(APPPATH.'libraries/packer/cssmin-v3.0.1.php');
include_once(APPPATH.'libraries/packer/CssUrlPrefixMinifierPlugin.php'); // url fix for image and all

class Packer {
	protected $CI;
	protected $minifyPath; // array of path on config
	protected $jsPath; // array of path on config
	protected $cssPath; // array of path on config
	
	protected $fileName; // real source name
	protected $newName; // new packed name
	
	protected $realPath; // real source path
	protected $newPath; // new source path
	protected $newMinify; // full link of new minify
	protected $newPacked;	// non hostname of new minify
	protected $sourceMod = array(); // the time of file modiff
	
	protected $isCSS = FALSE;
	protected $type = array(0=>'.packed.js',1=>'.packed.css'); // packed name
	protected $pettern = "/.min.|-packed|.custom.|-en./"; // pattern outside process
	
	protected $contentSrc = array(); // array of source get content
	
	protected $isCombine = WEB_COMBINE; // combine source to one file per controller
	
	function __construct()
	{
		$this->CI =& get_instance();
		$this->minifyPath = $this->CI->config->item('url_packed');	// get config of minify path
		$this->jsPath = $this->minifyPath['js'];	// set new minify js path
		$this->cssPath = $this->minifyPath['css']; // set new minify css path
		$this->minifyPath = array(0=>$this->jsPath,1=>$this->cssPath); // set for new path
	}
	
	// GET FILE MODIFIED VIA CURL
	protected function _fileModRemote($path)
	{
		$curl = curl_init($path);
		curl_setopt($curl, CURLOPT_NOBODY, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_FILETIME, true);

		$result = curl_exec($curl);
		if ($result === false) {
				die (curl_error($curl)); 
		}
	
		return curl_getinfo($curl, CURLINFO_FILETIME);	
	}
	
	// CREATE A MINIFY FILE PACKED
	protected function _packIt()
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
		
		file_put_contents($this->newPacked,$packed); // create a new packed
		unset($this->contentSrc);
		
		log_message('dvd','Packer/Create->'.$this->newPacked);		
	} 
	
	// PREPARE MINIFY FOLDER AND ORIGIN FILE CONTENT
	protected function _prepIt()
	{
		// check the folder exist
		$jsFolder = str_replace(base_url(),'',substr($this->jsPath,0,strlen($this->jsPath)-1)); 
		if(FALSE === is_dir($jsFolder))
			@mkdir($jsFolder);
			
		$cssFolder = str_replace(base_url(),'',substr($this->cssPath,0,strlen($this->cssPath)-1)); 
		if(FALSE === is_dir($cssFolder))
			@mkdir($cssFolder);
		
		$this->contentSrc[] = file_get_contents($this->realPath); // get file content
		log_message('dvd','Packer/GetContent->'.$this->realPath);		
	}
	
	// PROCESS TO REMOVE THE OLD MINIFY ON PATH
	protected function _delIt()
	{
		$setDir  = str_replace(base_url(),'',$this->newPath); // parse the asset minify without host name
		$arrFile = explode('.',$this->newName);	// explode newname into array
		$setName = implode('.',array_splice($arrFile,0,(count($arrFile) - 3))); // erase the {time}.packed.js on array and implode the new array
		$findFile = glob($setDir.'{'.$setName.'}*',GLOB_BRACE); // find file like set name on folder
		
		$return = array();
		foreach ($findFile as $delFile)
		{
			@chmod($delFile,0777);	// change the file to full access
			if (@unlink($delFile))	// remove the old file
			{
				log_message('dvd','Packer/Delete->'.$delFile);
				$return[] = TRUE;
			}	else
				$return[] = FALSE;
		}
		
		if (!in_array(FALSE,$return))
			return TRUE;
	}
		
	// PROCESS TO CHECK DIFFERENT TIME ON MINIFY AND SOURCE FILE
	protected function _checkIt($combine=FALSE)
	{				
		// check the new file, if not exist delete the old one and create the new one
		/*if (FALSE === file_exists($this->newPacked)) 
			if ($this->_delIt()) { // delete the old minify
				if (!$combine) $this->_prepIt();
				if (!$this->isCombine || $combine) // bypass if combine
					$this->_packIt();
			}
		*/
		if (!$this->isCombine) {
			if (FALSE === file_exists($this->newPacked)) 
				if ($this->_delIt()) {
					$this->_prepIt();
					$this->_packIt();
				}
		}	else {
			if (FALSE === file_exists($this->newPacked))
				$this->_packIt();
		}
		
		return $this->newMinify;
	}
	
	// PREPARE TO PARSE PATH AND FILENAME
	protected function _parseIt($path)
	{
		$this->newPath = $this->minifyPath[$this->isCSS]; // set to new path for minify
		$this->realPath = $path; // keep old name
		$arrPath = explode('/',$path); // parse real filename
		$this->fileName = $arrPath[count($arrPath) - 1]; // set real filename
		
		$getMod = $this->_fileModRemote($path); // get the time modiffed from source	
		$this->sourceMod[] = $getMod;
		$setTime = '.'.$getMod;	// set time on name
		if ($this->isCSS)
			$setTime = $getMod;
		
		$this->newName = substr($this->fileName,0,strlen($this->fileName) - 3).$setTime.$this->type[$this->isCSS]; // parse packedname
		$this->newPacked = str_replace(base_url(),'',$this->newPath).$this->newName; // new packed filename non http
		
		$this->newMinify = $this->newPath.$this->newName; // new packed filename full url
		
		log_message('dvd','Packer/Name->'.$this->newName);
		return $this->_checkIt(); // return the new path or the old path
	}
	
	// PREPARE TO POPULATE PATH FROM HELPER TAG
	public function generate($path,$css=FALSE)
	{	
		//if (is_array($path) && sizeOf($path) <= 1)
		//	$this->isCombine = FALSE;
		
		$this->isCSS = $css;
		
		$return = array();
		if(is_array($path))
			foreach ($path as $getPath)
				$return[] = $this->_parseIt($getPath);
		else
			$return[] = $this->_parseIt($path);
		
		// if combine source packed
		if ($this->isCombine)
			$return = $this->_combine();
		
		return $return;
	}
	
	// combine source to one file per controller
	protected function _combine($check = FALSE)
	{
		arsort($this->sourceMod); // sort of newer mod			
		$combineUnix = substr(md5($this->CI->router->class.$this->CI->router->method),0,6); // set controller and function unix
		$combineName = 'combine.'.$combineUnix.'.'.current($this->sourceMod).$this->type[$this->isCSS];
		$combinePath[] = $this->newPath.$combineName;	
		$combinePacked = str_replace(base_url(),'',$this->newPath).$combineName;
		
		$this->newPacked = $combinePacked;
		$this->newName = $combineName;
				
		log_message('dvd','Combine/Check->'.$combineName);
		$this->_checkIt(TRUE);
		
		$this->_clearIt();
		
		return $combinePath;
	}
	
	// clear array of content
	protected function _clearIt()
	{
		unset($this->contentSrc,$this->sourceMod); 
	}
	
}
/* END OF FILE PACKED.PHP */