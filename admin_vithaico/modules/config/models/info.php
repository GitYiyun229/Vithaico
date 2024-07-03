<?php 
	class ConfigModelsInfo   extends FSModels
	{

		function __construct()
		{
			parent::__construct();
            $this -> name_table = FSTable_ad::_('fs_config_info');
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
						  WHERE published = 1
						  ORDER BY ordering, id 
						 ";
						
			return $query;
		}
		
		/*
		 * 
		 * Save
		 */
		function save($row = array(),$use_mysql_real_escape_string = 0)
		{
			$data = $this->getData();
			$fsFile = FSFactory::getClass('FsFiles');
			global $db;
			
			foreach($data as $item)
			{
				if($item->data_type == 'editor')
					$value =htmlspecialchars_decode(FSInput::get("$item->name"));
				else if($item->data_type == 'image'){
					if(isset($_FILES[$item->name]['name']) && !empty($_FILES[$item->name]['name'])){
						$path = PATH_BASE.'images'.DS.'config'.DS;
						$image = $fsFile -> uploadImage($item->name, $path,2000000,'_'.time());
						if(!$image)	
							continue;
						$value = 'images/config/'.$image;
					}else{
						continue;
					}
				} else 
					$value = FSInput::get("$item->name");
				
				$sql = " UPDATE ". $this -> name_table ." SET 
						value = '$value'
						WHERE name = '$item->name' ";
				$db->query($sql);
				$rows = $db->affected_rows();
			}
			return true;
			
		}
		
		
	}
	
?>