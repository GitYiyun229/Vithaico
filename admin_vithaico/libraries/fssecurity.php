<?php
class FSSecurity
{
	function __construct(){
		
	}
	static function check_permission($module,$view='',$task=''){
	
		if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
            
		if(!$task)
			$task = 'display';
            
		$module = strtolower($module);
		$view = strtolower($view);
		$task = strtolower($task);
        
		if($module == 'users' && $view == 'log' && $task == 'logout' )
			return true;
			
		if(!isset($_SESSION['ad_userid']))
			return false;

		global $db;
		// get task_id
	
		$sql = ' SELECT id,`trigger` FROM fs_permission_tasks WHERE module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db = $db->getObject($sql);
		if(!$task_db)
			return true;
			// trigger	
		$user_id = $_SESSION['ad_userid'];
        
        $sql_permission_user = ' SELECT user_id FROM fs_users_permission WHERE user_id = "'.$user_id.'" ' ;
        $permission_user = $db->getObjectList($sql_permission_user);
        if(!count($permission_user))
			return true;

		$sql_permission = ' SELECT permission FROM fs_users_permission WHERE user_id = "'.$user_id.'" AND task_id IN ('.$task_db -> id.') ' ;
		$permission = $db->getResult($sql_permission);

		if(!$permission)
		//	return false;

		// view	
		if(($task == 'display' || $task =='detail' ) && $permission < 3) // || $task == 'edit'  || $task == 'permission'
		//	return false;

        
        $sql2 = ' SELECT id,list_function FROM fs_permission_tasks WHERE published = 1 AND `list_function`!= "" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db2 = $db->getObject($sql2);
		if(!$task_db2)
			return true;
            
          
        if(strpos($task_db2->list_function,','.$task.',') === false){
            return true;
        }
        
        //print_r($task);die;
        $sql3 = ' SELECT id,list_field FROM fs_users_permission_fun WHERE user_id = '.$user_id.' AND `list_field` LIKE "%,'.$task.',%" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ; 
        $task_db3 = $db->getObject($sql3);  

         //print_r($task);die;
        if($task_db3){
			return true;
        }else{
            return false;
        }    
         
		return true;
	}
    
    static function check_permission_field($module,$view='',$field=''){
        if(!isset($_SESSION['ad_userid']))
			return false;
        $user_id = $_SESSION['ad_userid'];    
	    if($user_id == 1 || $user_id == 9){
	       return true;
	    }

        if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
        
        if(!$field)
            return false;
        
        $module = strtolower($module);
		$view = strtolower($view);
        $field = strtolower($field);
		//$task = strtolower($task);
                  
        global $db;
		// get task_id

		$sql = ' SELECT id,list_field FROM fs_permission_tasks WHERE published = 1 AND is_contents = 1 AND `list_field`!= "" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db = $db->getObject($sql);
		if(!$task_db)
			return true;
        
        if(strpos($task_db->list_field,','.$field.',') === false){
            return true;
        }
        
        $sql2 = ' SELECT id,list_field FROM fs_users_permission_field WHERE user_id = '.$user_id.' AND `list_field` LIKE "%,'.$field.',%" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ; 
        $task_db2 = $db->getObject($sql2);  
        if($task_db2){
			return true;
        }else{
            return false;
        }     
              
    }
    
    static function check_permission_fun($module,$view='',$field=''){
        
        if(!isset($_SESSION['ad_userid']))
			return false;
        $user_id = $_SESSION['ad_userid'];    
	    if($user_id == 1 || $user_id == 9){
	       return true;
	    }
        
        if(!$module)
			$module = FSInput::get('module');
			
		if(!$view)
			$view =  FSInput::get('view',$module);
        
        if(!$field)
            return false;
        
        $module = strtolower($module);
		$view = strtolower($view);
        $field = strtolower($field);
		//$task = strtolower($task);
                  
        global $db;
		// get task_id

		$sql2 = ' SELECT id,list_function FROM fs_permission_tasks WHERE published = 1 AND `list_function`!= "" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ;
		$task_db2 = $db->getObject($sql2);
		if(!$task_db2)
			return true;  
            
        if(strpos($task_db2->list_function,','.$field.',') === false){
            return true;
        }
        
        $sql3 = ' SELECT id,list_field FROM fs_users_permission_fun WHERE user_id = '.$user_id.' AND `list_field` LIKE "%,'.$field.',%" AND  module = "'.$module.'" AND `view` = "'.$view.'"' ; 
        $task_db3 = $db->getObject($sql3);  
        
         //print_r($task);die;
        if($task_db3){
			return true;
        }else{
            return false;
        }    
              
    }
    		
}