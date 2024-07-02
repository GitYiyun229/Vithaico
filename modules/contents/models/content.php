<?php 
	class ContentsModelsContent extends FSModels
	{
		function __construct()
		{
		
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_contents',1);
			$this->table_category  = $fstable->_('fs_contents_categories',1);
            $this -> table_add = $fstable->_('fs_address',1);
		}
 
		function get_data_content()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				if(!$code)
					die('Not exist this url');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT *
						FROM ". $fs_table -> getTable('fs_contents',1) ." 
						WHERE published = 1 
						".$where ;
			//echo $query; die;
			global $db;
		$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function getCategory()
		{
			$fs_table = FSFactory::getClass('fstable');
			// $code = FSInput::get('ccode');
			// if($code){
			// 	$where = " AND alias = '$code' ";
			// } else {
			// 	$id = FSInput::get('id',0,'int');
			// 	if(!$id)
			// 		die('Not exist this url');
			// 	$where = " AND id = '$id' ";
			// }
			$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,list_parents
						FROM ".$fs_table -> getTable('fs_contents_categories',1)." 
						WHERE published = 1 ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObjectList();
			return $result;
		}
         

        function getList($id){
            $query = ' select id, content, category_alias, category_name, title, image, alias, published 
                       from '. $this -> table_name.' 
                       where published = 1 and category_id = '.$id.' order by ordering asc';
					//    echo $query;
            global $db;
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
	}
	
?>