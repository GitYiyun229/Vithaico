<?php 
	class AddressModelsAddress extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'address';
            $this -> arr_img_paths = array(
                array('large',450,350,'resize_image_fix_width'),
                array('tiny',150,100,'resize_image_fix_width')
            );
			$this -> table_name = FSTable_ad::_('fs_address');
            // config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/address/'.$cyear.'/'.$cmonth;
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
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = FSInput::clean($_SESSION[$this -> prefix.'keysearch']);
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
            if(isset($_SESSION[$this -> prefix.'filter0'])){
                $filter = FSInput::clean($_SESSION[$this -> prefix.'filter0']);
                if($filter){
                    $where .= ' AND a.city_id = '.$filter ;
                }
            }
            if(isset($_SESSION[$this -> prefix.'filter1'])){
                $filter = FSInput::clean($_SESSION[$this -> prefix.'filter1']);
                if($filter){
                    $where .= ' AND a.district_id = '.$filter ;
                }
            }
            if(isset($_SESSION[$this -> prefix.'filter2'])){
                $filter = FSInput::clean($_SESSION[$this -> prefix.'filter2']);
                if($filter){
                    if($filter == 2){
                        $where .= ' AND a.is_atm = 0' ;
                    }else{
                        $where .= ' AND a.is_atm = '.$filter ;
                    }
                }
            }
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			//echo $query;
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name)
				return false;
                	
			$alias= FSInput::get('alias');
			$fsstring = FSFactory::getClass('FSString','','../');
			if(!$alias){
				$row['alias'] = $fsstring -> stringStandart($name);
			} else {
				$row['alias'] = $fsstring -> stringStandart($alias);
			}
			$row['latitude'] = FSInput::get('latitude');
			$row['longitude'] = FSInput::get('longitude');
			$id = FSInput::get('id',0,'int');


            $show_contact = FSInput::get('show_contact');
            //if(isset($show_contact ) && $show_contact != 0)
			//{
				//$rs = $this -> _update_column('fs_address', 'show_contact','0');
			//}
			// remove other_image
			if(!$this -> remove_other_images($id))
				return false;
			// upload other_imge
			
			//if(!$this->upload_other_images($id))
			//{
				//Errors::setError('Can not upload other_image');
			//}
			return parent::save($row);
		}
		function remove(){
			$img_paths = array();
			$path_original =  PATH_IMG_ADDRESS.'original'.DS;
			$path_resize =  PATH_IMG_ADDRESS.'resized'.DS; //142x100
			$path_large =  PATH_IMG_ADDRESS.'large'.DS; //309x219
			$img_paths[] = $path_original;
			$img_paths[] = $path_resize;
			$img_paths[] = $path_large;
			return parent::remove('image',$img_paths);
		}
		
		/*
		 * value: == 1 :hot
		 * value  == 0 :unhot
		 * published record
		 */
		function hot($value)
		{
			$ids = FSInput::get('id',array(),'array');
			
			if(count($ids))
			{
				global $db;
				$str_ids = implode(',',$ids);
				$sql = " UPDATE ".$this -> table_name."
							SET is_hot = $value
						WHERE id IN ( $str_ids ) " ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return 0;
		}
        function get_district($cid = '1')
        {
            if(!isset($cid))
                $cid = 1;
            global $db;
            $query = " SELECT a.*
						  FROM 
						  	fs_local_districts AS a
						  	WHERE published = 1
						  	AND city_id = $cid
						  	ORDER BY ordering 
						";
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        
		function get_showroom_images($address_id){
			if(!$address_id)
				return;
			$query   = " SELECT image,id 
						FROM fs_showroom_images
						WHERE address_id = $address_id";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
		function remove_other_images($add_id)
		{
			if(!$add_id)
				return true;
			$other_images_remove = FSInput::get('other_image',array(),'array');
			$str_other_images = implode(',',$other_images_remove);
			if($str_other_images)
			{
				global $db;
				
				// remove images in folder contain these images
				$query   = " SELECT image 
						FROM fs_showroom_images
						WHERE address_id = $add_id
						AND id IN ($str_other_images)
						";
				$sql = $db->query($query);
				$images_need_remove = $db->getObjectList();
				
				$fsFile = FSFactory::getClass('FsFiles','');
				foreach ($images_need_remove as $item) {
					if($item->image)
					{
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'original'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'resized'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'large'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'medium'.DS);
						$fsFile-> remove($item->image, PATH_IMG_ADDRESS.'small'.DS);
						
					}
				}
				
				// remove in database
				$sql = " DELETE FROM fs_showroom_images
						WHERE address_id = $add_id
							AND id IN ($str_other_images)" ;
				$db->query($sql);
				$rows = $db->affected_rows();
				return $rows;
			}
			return true;
		}

    function getListDistricts($city_id = 0)
    {
        global $db;
        $sqlWhere = '';
        if ($city_id)
            $sqlWhere = ' AND city_id = "' . $city_id . '"';
        $query = '  SELECT id, name
						FROM fs_districts 
						WHERE published = 1 ' . $sqlWhere . '
						ORDER BY ordering ASC';
//                        echo $query;die;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_categories_tree2()
    {
        global $db;
        $query = " SELECT *
						  FROM 
						  	fs_local_cities AS a where 1=1 order by a.ordering asc
						  	 ";
        //	echo $query;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $result;
    }

    function get_city()
    {
        global $db;
        $query = "SELECT a.*
                      FROM fs_local_cities
                      AS a 
                      ORDER BY ordering asc ";
        $sql = $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }


    function getDistricts($cityid = '1473')
    {
        if (!$cityid)
            $cityid = '1473';
        global $db;
        $sql = " SELECT id, name FROM fs_districts
					WHERE city_id = $cityid ";
        //echo $sql;die;
        $db->query($sql);
        return $db->getObjectList();
    }


    function get_categories_tree($id_province = null)
    {
        $where = '';
        if($id_province)
         $where.= ' city_id = '.$id_province.'';

        global $db;
        $query = " SELECT name,id,city_id
						  FROM 
						  	fs_districts AS a where $where order by a.ordering asc
						  	 ";
        //	echo $query;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $result;
    }
	}
	
?>