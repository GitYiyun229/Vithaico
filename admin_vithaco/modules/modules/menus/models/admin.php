
<?php 
	class MenusModelsAdmin
	{
		function __construct()
		{
		}
		
		function setQuery()
		{
			// fix user_group_id = 51 là quyền đại lý

			$where ='';

			$query = " SELECT *, parent_id as parent_id
						  FROM fs_menus_admin
						  WHERE published = 1
						  ".$where."
						  ORDER BY ordering 
						 ";
			return $query;
		}
		
		
		function getMenusAdmin()
		{
			global $db;
			$query = $this->setQuery();
			$result = $db->getObjectList($query);
			
			return $result;
		}
		
		function user_permission(){
			if(!isset($_SESSION['ad_userid']))
				return false;
			global $db;
			$user_id = $_SESSION['ad_userid'];
			
			// get groupid
			$query = ' SELECT a.permission,b.module ,b.view 
						FROM fs_users_permission AS a 
						INNER JOIN fs_permission_tasks  AS b ON a.task_id = b.id
						WHERE user_id = '.$user_id.'
					';	
			$result = $db->getObjectList($query);
			
			$array_permission = array();
			for($i = 0 ; $i < count($result); $i ++ ){
				$array_permission[$result[$i]->module][$result[$i]->view] = $result[$i]->permission;
			}
			return $array_permission;
		}
		
		
	}
	
?>