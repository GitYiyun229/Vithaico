<?php 
	class NewsModelsTags extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			global $module_config;
			FSFactory::include_class('parameters');
//			$current_parameters = new Parameters($module_config->params);
//			$limit   = $current_parameters->getParams('limit');
			$limit = 24;
			$this->limit = $limit;
		}
		function set_query_body($cid)
		{
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_news')."
						  WHERE tags like '%,".$cid.",%' 
						  	AND published = 1
						  	". $where.
						    " ORDER BY ordering DESC,created_time DESC, id DESC
						 ";
			return $query;
		}
		
		/*
		 * get Category current
		 * By Id or By code
		 */
		function getTags()
		{
			$fs_table = FSFactory::getClass('fstable');
			$code = FSInput::get('ccode');

			$query = " SELECT id,name,alias
						FROM ".$fs_table -> getTable('fs_news_tags')." 
						WHERE published = 1 and alias = '".$code."' ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}
		function getNewsList($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT id,title,summary,image, created_time,category_id, category_alias, alias,comments_total,comments_published,hits";
			$query .= $query_body;
			$sql = $db->query_limit($query,$this->limit,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function getTotal($query_body)
		{
			if(!$query_body)
				return ;
			global $db;
			$query = "SELECT count(*)";
			$query .= $query_body;
			$sql = $db->query($query);
			$total = $db->getResult();
			return $total;
		}
		
		function getPagination($total)
		{
			FSFactory::include_class('Pagination');
			$pagination = new Pagination($this->limit,$total,$this->page);
			return $pagination;
		}
	}
	
?>