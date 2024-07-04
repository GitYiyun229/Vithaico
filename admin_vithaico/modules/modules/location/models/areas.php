<?php 
	class LocationModelsAreas extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'areas';
			$this -> table_name = 'fs_areas';
			parent::__construct();
            //$this -> array_synchronize = array('fs_schedules'=>array('id'=>'area_id','name'=>'area_name','alias'=>'area_alias'),
            //                                    'fs_cities'=>array('id'=>'area_id','name'=>'area_name','alias'=>'area_alias'));
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
					$ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
					
			}
			if(!$ordering)
				$ordering .= " ORDER BY  id DESC ";
			
			$where = "  ";
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND name LIKE '%".$keysearch."%' ";
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
		
	}
	
?>