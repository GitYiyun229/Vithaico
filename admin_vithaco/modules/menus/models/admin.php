
<?php 
	class MenusModelsAdmin
	{
		function __construct()
		{
		}
		
		function setQuery($group)
		{
			// fix user_group_id = 51 là quyền đại lý

			$where ='';
            if ($group != 1) ($where =' AND FIND_IN_SET('. $group .', group_id) > 0');
            $query = " SELECT *, parent_id as parent_id
						  FROM fs_menus_admin
						  WHERE published = 1 ".$where. " 
						  ORDER BY ordering 
						 ";
			return $query;
		}


        function getMenusAdmin($group)
        {
            global $db;
            $query = $this->setQuery($group);
            $sql = $db->query($query);
            $result = $db->getObjectList();

            return $result;
        }

		
		
	}
	
?>