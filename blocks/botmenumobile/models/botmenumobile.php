<?php 
	class BotmenumobileBModelsBotmenumobile
	{
		function __construct()
		{
          
		}
		
		function setQuery($id){
			$this->table_name  = 'fs_sellers';

			$where = ' AND id = '.$id.'';
			$query = ' SELECT * 
						  FROM '. $this->table_name .'
						  WHERE  published = 1 '. $where ;
			return $query;
		}
        
		function get_list($id){
			global $db;
			$query = $this->setQuery($id);
			if(!$query)
				return;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function get_agency(){
		    $table_agency = 'fs_agency_'.USER_ID_AGENCY;
		    global $db;
            $where = ' AND level = 0';
            $query = ' SELECT * 
						  FROM '. $table_agency .'
						  WHERE  published = 1 '. $where ;
            $sql = $db->query($query);
            $result = $db->getObject();
            return $result;

        }
        
        function get_menu($group_id){
		    global $db;
            $query = ' SELECT * 
						  FROM fs_menus_items
						  WHERE  published = 1 AND group_id = '.$group_id.' ORDER BY  ordering ASC, id ASC' ;
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;

        }


	}
	
?>