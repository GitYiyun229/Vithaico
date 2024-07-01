<?php 
	class LocationModelsCities extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit =50;
			$this -> view = 'cities';
			$this -> table_name = 'fs_cities';
            $this -> table_area = 'fs_areas';
			parent::__construct();
//            $this -> array_synchronize = array('fs_schedules'=>array('id'=>'city_id','name'=>'city_name','alias'=>'city_alias','area_id'=>'area_id'
//          ,'area_name'=>'area_name','area_alias'=>'area_alias'),
//
//          'fs_areas'=>array('area_id'=>'id','area_name'=>'name','area_alias'=>'alias')
//            
//          );
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
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}
            
            // estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
            
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = ' SELECT * 
						  FROM '.$this -> table_name.' 
						  	'.
						 $where.
						 $ordering;
						
			return $query;
		}
        
        function save($row = array(), $use_mysql_real_escape_string = 1){			

			$id = FSInput::get('id',0,'int');	
			$area_id = FSInput::get('area_id',0,'int');
			if(!$area_id){
				Errors::_(FSText::_('Chọn vùng miền'));
				return;
			}
			$area =  $this->get_record_by_id($area_id,$this -> table_area);
			$row['area_name'] = $area -> name;
			$row['area_alias'] = $area -> alias;
          //  
//            $image_name_icon = $_FILES["icon"]["name"];
//    		if($image_name_icon){
//    			$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
//    			if($image_icon){
//    				$row['icon'] = $image_icon;
//    			}
//    		}
			
			return parent::save($row);
		}

	}
	
?>