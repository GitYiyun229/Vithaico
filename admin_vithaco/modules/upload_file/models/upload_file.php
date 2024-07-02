<?php 
	class Upload_fileModelsUpload_file extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'upload_files';
			$this -> table_name = FSTable_ad::_('fs_upload_files');
			parent::__construct();
		}

		function setQuery(){
			
			// ordering
			$ordering = "";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.filename LIKE '%".$keysearch."%' ";
				}
			}
			

            $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " . $where . $ordering . " ";
						
			return $query;
		}
                
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
            
			// file downlaod
            global $db; 
            $cyear = date ( 'Y' ); 
    		$path = PATH_BASE.'images'.DS.'upload_file'.DS.$cyear.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            
            $file_upload = $_FILES["file_upload"]["name"];
			if($file_upload){
				$path_original = $path;
				// remove old if exists record and img
				if($id){
					$img_paths = array();
					$img_paths[] = $path_original;
					// special not remove when update
//					$this -> remove_file($id,$img_paths,'file_upload');
				}
				$fsFile = FSFactory::getClass('FsFiles');
				// upload
				$file_upload_name = $fsFile -> upload_file("file_upload", $path_original ,20000000, '_'.time());
				if(!$file_upload_name)
					return false;
				$row['file_upload'] = 'images/upload_file/'.$cyear.'/'.$file_upload_name;
			}
            
			return parent::save($row);
		}


	}
	
?>