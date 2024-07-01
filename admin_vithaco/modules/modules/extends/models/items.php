<?php 
	class ExtendsModelsItems  extends FSModels
	{
		function __construct()
		{
			$table_name_extend = FSInput::get('table_name');
			$this -> table_name = 'fs_extends_'.$table_name_extend;
			global $db;
			if(!$db -> checkExistTable($this -> table_name))
				die('Not data type');
			$this -> limit = 30;
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
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.name LIKE '%".$keysearch."%' ";
				}
			}
			
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
						 $where.
						 $ordering. " ";
			return $query;
		}
		
		function get_fields()
		{
			global $db;
			$tablename = $this -> table_name;	
			$query = " SELECT * 
						FROM fs_extends_tables
						WHERE table_name =  '$tablename' 
						AND field_name <> 'id' 
						ORDER BY id ASC
						";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
	}