
<?php 
	class NewsModelsAmp_news extends FSModels
	{
		function __construct()
		{
			$limit = 10;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
			$this->table_name  = $fstable->_('fs_news');
			$this->table_category  = $fstable->_('fs_news_categories');
            $this -> table_comment = $fstable->_('fs_news_comments');
		}
//		function setQuery()
//		{
//			$query = " SELECT id,title,summary,image, categoryid, tag
//						  FROM fs_contents
//						  WHERE categoryid = $cid 
//						  	AND published = 1
//						ORDER BY  id DESC, ordering DESC
//						 ";
//			return $query;
//		}
		/*
		 * get Category current
		 */
		function get_category_by_id($category_id)
		{
			if(!$category_id)
				return "";
			$query = " SELECT *
						FROM ".$this->table_category ."  
						WHERE id = $category_id ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

		function getRelateNewsList($cid)
		{
			if(!$cid)
				die;
			$code = FSInput::get('code');	
			$where = '';
			if($code){
				$where .= " AND alias <> '$code' ";
			} else {
				$id = FSInput::get('id',0,'int');
				if(!$id)
					die('Not exist this url');
				$where .= " AND id <> '$id' ";
			}
			
			global $db;
			$limit = 5;
			$fs_table = FSFactory::getClass('fstable');
			
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_news')."
						WHERE alias <> '".$code."'
							AND category_id = $cid
							AND published = 1
							".$where."
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
			$db->query($query);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		/*
		 * get Article
		 */
		function getNews()
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
						FROM ".$fs_table -> getTable('fs_news')." 
						WHERE published = 1
						".$where." ";
            //print_r($query) ;   
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		
	}
	
?>