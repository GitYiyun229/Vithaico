<?php
/*
 * Huy write
 */
class FSCache{
	private $cacheDir = 'cache';  
//	private $expiryInterval = CACHE_TIME; 
	  
	public function setCacheDir($val) {
		$this->cacheDir = $val; 
	}  
//	public function setExpiryInterval($val) {  
//		$this->expiryInterval = $val; 
//	}  
	
	public function exists($key) {
		
	}
	
	public function put($key, $content,$folder = '',$ext='.cache')  {
		$time = time(); //Current Time
		if (! file_exists($this->cacheDir.'/' .$folder.'/'))
			$this -> create_folder($this->cacheDir.'/' .$folder.'/'); 
		
		$filename_cache = $this->cacheDir . '/' .$folder.'/'. $key .  $ext; //Cache filename  
		file_put_contents ($filename_cache ,  $content); // save the content  
	}
	
	public function get($key,$folder = '',$cache_time,$ext='.cache')  {
   		$filename_cache = $this->cacheDir . '/' .$folder.'/'. $key .  $ext; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
   			if((time() - filemtime($filename_cache)) < $cache_time){
				return file_get_contents ($filename_cache); 
			} 
  		}  
  		return null;  
  	} 
  	
  	/*
  	 * Kiểm tra file đó còn hoạt động được không?
  	 */
	public function check_activated($key,$folder = '',$cache_time,$ext='.cache')  {
   		$filename_cache = $this->cacheDir . '/' .$folder.'/'. $key . $ext; //Cache filename  
   		if (file_exists($filename_cache) )  
   		{  
   			if((time() - filemtime($filename_cache)) < $cache_time){
				return true; 
			} 
  		}  
  		return null;  
  	} 
  	public function remove($key,$folder = '')  {
   		$filename_cache = PATH_BASE.$this->cacheDir . '/' .$folder.'/'. $key . '.cache'; //Cache filename  
   		unlink($filename_cache);
  	}  

  	function create_folder($path){
  		$fsFile = FSFactory::getClass('FsFiles');
  		return $fsFile -> create_folder($path);
  	}
  	/*
  	 * Remove tr�n mobile:
  	 */
  	public function remove_m($key,$folder = '')  {
   		$filename_cache = $this->cacheDir_mobile . '/' .$folder.'/'. $key . '.cache'; //Cache filename
   		unlink($filename_cache);
  	}  
}
