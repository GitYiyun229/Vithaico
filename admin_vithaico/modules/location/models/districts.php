<?php
	class LocationModelsDistricts extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 200;
			$this -> view = 'districts';
			$this -> table_name = 'fs_districts';
          $this -> table_city = 'fs_cities';
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
			if(isset($_SESSION[$this -> prefix.'filter'])){
				$filter = $_SESSION[$this -> prefix.'filter'];
				if($filter){
					$where .= ' AND b.id =  "'.$filter.'" ';
				}
			}

            if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.city_id = '.$filter ;
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

			$query = ' SELECT a.*, b.name as city_name
						  FROM
						  	'.$this -> table_name.' AS a
						  	LEFT JOIN '.$this -> table_city.' AS b ON a.city_id = b.id
						  	WHERE 1=1 '.
						 $where.
						 $ordering. " ";

			return $query;
		}


	}

?>
