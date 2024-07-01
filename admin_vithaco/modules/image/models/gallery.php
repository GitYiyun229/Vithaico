<?php 
	class GalleryModelsGallery extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
            parent::__construct();
			$this -> limit = 20;
			$this -> view = 'gallery';			
			$this->type = 'gallery'; 
			$this -> arr_img_paths = array(array('resized',1002,664,'resize_image'),array('small',268,198,'cut_image'));
            $this -> table_name_img = FSTable_ad::_('fs_gallery_images');
            $this -> table_name = FSTable_ad::_('fs_gallery');
			$this -> table_category_name = FSTable_ad::_('fs_gallery_categories');
			$this -> arr_img_paths_other = array(array('resized',1002,664,'resize_image'),array('small',268,198,'cut_image'));
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/gallery/'.$cyear.'/'.$cmonth;
			$this -> check_alias = 1;
			$this -> field_img = 'image';
            
            parent::__construct ();
            $this->load_params ();
			
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
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
            
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND  a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  ".$this -> table_name." AS a
						  	WHERE 1=1".
						 $where.
						 $ordering. " ";
						
			return $query;
		}
		function save(){
			$id = FSInput::get('id',0,'int');
			$fsremote_class = FSFactory::include_class('remote');
            
            $category_id = FSInput::get('category_id','int',0);
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục');
				return;
			}
			
			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
            
			$content = FSRemote :: save_image_in_remote_content(htmlspecialchars_decode($_POST['content']));
			$row['content'] = $content;
            
			$rid = parent::save($row);
			if($id){
				$update_images = $this -> update_images($rid,'edit');
			}else{
				$update_images = $this -> update_images($rid,'add');
			}
			return $rid;
		}
        
        /*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
        
	 	/**
		 * Lấy danh sách ảnh
         * 
         * @return Object list
         */ 
        function get_other_images(){
            $data = base64_decode(FSInput::get('data'));
            $data = explode('|', $data);
            $where = 'record_id = '.$data[1];
            if($data[0] == 'add')
                $where = 'session_id = \''.$data[1].'\'';
            global $db;
            $query = '  SELECT *
                        FROM '.$this -> table_name_img.' 
                        WHERE '.$where.'
                        ORDER BY ordering, id DESC';
    		//$sql = $db->query($query);
    		return $db->getObjectList($query);
        }
		/**
         * Update product id vào images
         */ 
        
        function update_other_images($id=0){
            
            global $db;
            $session_id = FSInput::get('session_id');
            
            $query = '  UPDATE '.$this -> table_name_img.' SET record_id = '.$id.', session_id = \'\'
                        WHERE session_id = \''.$session_id.'\'';
            print_r($query);
            die();
            $db->query($query);
            $rows = $db->affected_rows();
            return $rows;
        }
		/**
         * Upload và resize ảnh
         * 
         * @return Bool
         */ 
        function upload_other_images() {
            global $db;
            $path = PATH_BASE . $this->img_folder . '/original/';
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $file_name = $upload->uploadImage('Filedata', $path, 8000000, '_' . time());
            if (is_string($file_name) and $file_name != '' and ! empty($this->arr_img_paths_other)) {
                foreach ($this->arr_img_paths_other as $item) {
                    $path_resize = str_replace('/original/', '/' . $item [0] . '/', $path);
                    $upload->create_folder($path_resize);
                    $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                    $upload->$method_resize($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
                }
            }
            $data = base64_decode(FSInput::get('data'));
            $data = explode('|', $data);
            $row = array();
            if ($data[0] == 'add')
                $row['session_id'] = $data[1];
            else
                $row['record_id'] = $data[1];
            $row['image'] = $this->img_folder . '/original/' . $file_name;
            $rs = $this->_add($row, $this->table_name_img);
            echo $this->table_name_img;
            return true;
        }

    function delete_other_image($record_id = 0){
            global $db;
            if($record_id)
                $where = 'record_id = \''.$record_id.'\'';
            else{
                $data = FSInput::get('data', 0);
                $where = 'id = \''.$data.'\'';
            }
            $query = '  SELECT *
                        FROM '.$this -> table_name_img.'
                        WHERE '.$where;
            
            $db->query($query);
            $listImages = $db->getObjectList();
            if($listImages){
                foreach($listImages as $item){
                    $query = '  DELETE FROM '.$this -> table_name_img.'
                                WHERE id = \''.$item->id.'\'';
                    $db->query($query);
                    $path = PATH_BASE.$item->image;
                    @unlink($path);
                    foreach ( $this->arr_img_paths_other as $image){
    					@unlink(str_replace ( '/original/', '/'. $image[0] .'/', $path));
    				}
                }
            }
        }
        
        function sort_other_images(){
            global $db;
            if(isset($_POST["sort"])){
            	if(is_array($_POST["sort"])){
            		foreach($_POST["sort"] as $key=>$value){
            			print_r($value);
            			$db->query("UPDATE ".$this -> table_name_img." SET ordering = $key WHERE id = $value");
            		}
            	}
            }
        }
	  function add_title_other_images($record_id = 0 ){
	    
	  	 global $db;
	  	    $title = FSInput::get('title');
	  	 	if($record_id)
                $where = 'record_id = \''.$record_id.'\'';
            else{
                $data = FSInput::get('data', 0);
                $where = 'id = '.$data;
            }
         	 $query = '  UPDATE '.$this -> table_name_img.' SET title = \''.$title.'\'
	                        WHERE '.$where;
         	 echo $query;
	            $db->query($query);
	            $rows = $db->affected_rows();
	            return $rows;
        }
		 /*
		  * Sử lý lại ảnh khi save
		  */
		 function update_images($id,$type = 'edit'){
		    
            global $db;
            if($type == 'add'){
	            $session_id = session_id();
	            $query = '  UPDATE '.$this -> table_name_img.' SET record_id = '.$id.', session_id = \'\'
	                        WHERE session_id = \''.$session_id.'\'';
                echo $query;
	            $db->query($query);
	            $rows = $db->affected_rows();
	            return $rows;
            }
		 }
	
		/*
		 *==================== end.OTHER IMAGES==============================
		 */
	}
	
?>