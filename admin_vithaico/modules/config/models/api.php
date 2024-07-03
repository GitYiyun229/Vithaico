<?php 
	class ConfigModelsApi   extends FSModels
	{

		function __construct()
		{
			parent::__construct();
            $this -> name_table = FSTable_ad::_('fs_config');
		}
		
		function getData()
		{
			global $db;
			$query = $this->setQuery();
			if(!$query)
				return array();
				
			$sql = $db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		function setQuery()
		{
			$query = " SELECT *
						  FROM 
						  	". $this -> name_table ."
						  WHERE published = 1 and is_api = 1
						  ORDER BY ordering, id 
						 ";
			// echo $query;			
			return $query;
		}
		
		/*
		 * 
		 * Save
		 */
		function save($row = array(),$use_mysql_real_escape_string = 1)
		{
			$data = $this->getData();
			$fsFile = FSFactory::getClass('FsFiles');
			global $db;
			
			foreach($data as $item)
			{
				// $value = FSInput::get("$item->name");
				$value = $_REQUEST["$item->name"];
				
                if($use_mysql_real_escape_string){
					$value = $db -> escape_string($value);	
				}

				if($item->name == 'ec_user_id1'){
					$old_record = $this->get_record('name = "ec_user_id1" ','fs_config','value');
					$this->_update(['name'=> $value],'fs_api_login','name = "'.$old_record->value.'" ',0);
				}
                if($item->name == 'ec_user_id2'){
					$old_record = $this->get_record('name = "ec_user_id2" ','fs_config','value');
					$this->_update(['name'=> $value],'fs_api_login','name = "'.$old_record->value.'" ',0);
				}

				$sql = " UPDATE ". $this -> name_table ." SET 
						value = '$value'
						WHERE name = '$item->name' ";
				$db->query($sql);
				$rows = $db->affected_rows();
			}
            $memcache = new Memcache();
            $memcache->addServer('127.0.0.1', 11211);
            $memcache->flush();
			return true;
			
		}
		
		
	}
	
?>