<?php 

	class ImageModelsVideo extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
            $this->type = 'video';
			$this -> table_name = FSTable_ad::_('fs_video');
			$this -> arr_img_paths = array(
                                        array('resized',374,232,'resize_image'),
                                        array('small',374,232,'cut_image'),
                                        //array('large',414,234,'cut_image')
                                        );
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/video/'.$cyear.'/'.$cmonth.'/'.$cday;
			//$this -> video_folder = 'images/image/videos/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 1;
			$this -> field_img = 'image';
			
			parent::__construct();
		}
        
		function setQuery(){
			
			// ordering
			$ordering = "";
			$where = "  ";
			if(isset($_SESSION[$this -> prefix.'sort_field']))
			{
				$sort_field = $_SESSION[$this -> prefix.'sort_field'];
				$sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
				$sort_direct = $sort_direct?$sort_direct:'asc';
				$ordering = '';
				if($sort_field)
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
			}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.lesson_id =  "'.$filter.'" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = ' SELECT *
						  FROM 
						  	'.$this -> table_name.' AS a
						  	WHERE 1=1 
						 '. $where . 
						 $ordering;
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
            
			if(!$name)
				return false;
			
            
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
            
            $path = PATH_BASE.'images'.DS.'video'.DS.$cyear.DS.$cmonth.DS.$cday.DS;
            require_once(PATH_BASE.'libraries'.DS.'upload.php');
            $upload = new  Upload();
            $upload->create_folder ( $path );
            
            $file_upload = $_FILES["video"]["name"];
			if($file_upload){
                //$name = $_FILES['video']['name'];
                $type_video = explode('.', $file_upload);
                $type_video = end($type_video);
                //$random = rand();
                $tmp = $_FILES['video']['tmp_name']; 
                //var_dump($_FILES['video']);die;
                if($type_video != "mp4")
                {
                    echo "File Format Not Suppoted";
                }else{
                     move_uploaded_file($tmp,$path.$file_upload);
                }  
                $row['video'] = 'images/video/'.$cyear.'/'.$cmonth.'/'.$cday.'/'.$file_upload;
			}
			 	
			$result_id =  parent::save($row);
			return $result_id;
		}
  
	}
	
?>