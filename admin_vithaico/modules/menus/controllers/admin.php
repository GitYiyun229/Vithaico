<?php
/*
 * Huy write
 */
	// models 
	include 'modules/menus/models/admin.php';
	
	class MenusControllersAdmin
	{
		function __construct()
		{
			$module = 'menus';
			$this -> module = $module ;
		}
		function display()
		{
            global $db;
            $user_id = $_SESSION['ad_userid'];
            $sql_group = 'SELECT groupid as group_id FROM fs_users_groups WHERE userid = ' . $user_id;
            $db->query($sql_group);
            $result = $db->getObjectList();
            $group = $result[0]->group_id;
            $model = new MenusModelsAdmin();
            $list = $model->getMenusAdmin($group);
			include 'modules/menus/views/admin/default.php';
		}

	
		function showMenu($level=1,$parent = 0,$start_level=0,$end_level=0,$params)
		{
			$rs = "";
			$list = JvpdMenuHelpler::getCategory($params);
			$Itemid = JvpdMenuHelpler::getItemIdJvProduct();
			$i = 0;
			$len =0;
	//		$length = count($list);
	//		echo $length;
	
			foreach ( $list as $item )
			{ 
				if($item->level == $level && $item->parent_id == $parent )
				{
					$len++;
				}
			}
			
			foreach ( $list as $item ) {
	        	if($item->level == $level && $item->parent_id == $parent )
	        	{
	        		// class type: last and first
	        		$class_type="";
	        		if($i==0)
	        		{
	        			$class_type .= " jv_first_item";
	        		}
	        		if(($i+1)==$len)
	        		{
	        			$class_type .= " jv_last_item";
	        		}
	        		if($i!=0 && ($i+1)!=$len)
	        		{
	        			$class_type = "";
	        		}
	        		
	        		// level
	        		$condition1 = false;
	        		$condition2 = false;
	        		if(($start_level && $item->level>=$start_level )||(!$start_level)) 
	        		{
	        			$condition1 =   1;
	        		}
	        		if(($end_level && $item->level<=$end_level )||(!$end_level)) 
	        		{
	        			$condition2 =   1;
	        		}
	        		if($condition1 &&  $condition2)
	        		{
		        		$link = JRoute::_("index.php?option=com_jv_product&view=category&cid=".$item->id."&Itemid=".$Itemid."");
		        		
		        		// Begin check current link:
		        		$current_class=	"";
		        		if(JRequest::getVar('option','') == 'com_jv_product'
		        			&& JRequest::getVar('view','') == 'category'
		        			&& JRequest::getVar('cid',0) == $item->id
		        			&& JRequest::getVar('Itemid') == $Itemid	        			
		        		)
	        			{
	        				$current_class=	"current";
	        			}
		        		// End check current link.
		        		
		        		
		        		if($item->children &&  (($end_level && $item->level<$end_level) || !$end_level) )
		        		{
		        			$rs .= "<li id=\"item$item->id\" level=\"$item->level\" access=\"$item->access\" class=\"hasChild $class_type $current_class item$item->id\" >";
		        			$rs .= "		<a href=\"$link\"><span>".$item->name."</span>";
		        			$rs .= "<span class=\"span_hasChild\"></span></a> "	;
		        		}
		        		else
		        		{
		        			$rs .= "<li id=\"item$item->id\" level=\"$item->level\" access=\"$item->access\"  class=\"$class_type $current_class item$item->id\">";
		        			$rs .= "		<a href=\"$link\"><span>".$item->name."</span></a>";
		        		}
		        		
	        		}
	        		
	        	
	        		
	        		if($item->children)
	        		{	
	        			if((($item->level)+1)==$start_level)
	        			{
	        				$rs .= JvpdMenuHelper::showMenu(($item->level)+1,$item->id,$start_level,$end_level,$params);
	//        				echo "<ul>";
	        			}
	        			else
	        			{
	//        				$rs .= "<ul style=\"display: none; visibility: hidden;\">";
	        				$rs .= "<ul>";
	        				$rs .= JvpdMenuHelpler::showMenu(($item->level)+1,$item->id,$start_level,$end_level,$params);
	        				$rs .= "</ul>";
	        			}
	        			
	        			
	        		}
	        		$i++;
	        		$rs .= "</li>";
	        	}
				
	        }	
	        return $rs;	
	     	
		}
	}
	
?>