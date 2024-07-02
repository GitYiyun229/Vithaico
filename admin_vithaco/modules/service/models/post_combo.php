<?php
	class ServiceModelsPost_combo extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 50;
			$this -> view = 'post_combo';
			$this -> table_name = 'fs_service_combo';
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
					$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
			}
			if(!$ordering)
				$ordering .= " ORDER BY ordering DESC , id DESC ";


			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND ( a.name LIKE '%".$keysearch."%' )";
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


		function save($row = array(), $use_mysql_real_escape_string = 1){
		
            // related projects
    		$products_related  = FSInput::get ( 'id_wrapper', array (), 'array' );
            $str_products_related = implode ( ',', $products_related );
    		if ($str_products_related) {
    			$str_products_related = ',' . $str_products_related . ',';
    		}
    		$row ['id_wrapper'] = $str_products_related;
            
			$rs = parent::save($row);
            return $rs;
		}
	}
?>
