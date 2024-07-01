<?php 
	class VideosModelsCat extends FSModels
	{
		function __construct()
		{
			parent::__construct();
			global $module_config;
			FSFactory::include_class('parameters');
			// $current_parameters = new Parameters($module_config->params);
			// $limit   = $current_parameters->getParams('limit'); 
			$limit = 20;
			$this->limit = $limit;
		}
		function set_query_body()
		{
			$where  = "";
			$fs_table = FSFactory::getClass('fstable');
			$query = " FROM ".$fs_table -> getTable('fs_video')."
						  WHERE published = 1 
						  	". $where.
						    " ORDER BY  created_time DESC, id DESC
						 ";
			return $query;
		}
		/*
		 * get Category current
		 * By Id or By code
		 */
		function getContentsList($query_body)
		{
			if(!$query_body)
				return;
				
			global $db;
			$query = " SELECT *";
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
		
		/*
		 * get Most Reading new
		 * LIMIT IN 600 days
		 */
		function get_most_read_contents($category_id,$limit,$str_contents_ids,$limit_day = 4){
			if(!$limit)
				$limit = 9;
			$query = ' SELECT id, title,image, summary,alias, category_alias,category_id
					  FROM fs_contents
					  WHERE published = 1
					  AND category_id_wrapper like "%,'.$category_id.',%"
					  AND id NOT IN ('.$str_contents_ids.')
					  AND updated_time >= DATE_SUB(CURDATE(), INTERVAL '.$limit_day.' DAY)
					ORDER BY created_time DESC
					 ';
			global $db;
			$sql = $db->query_limit($query,$limit);
			return  $db->getObjectList();
		}
		
		function get_list_parent($list_parents,$cat_id){
			if(!$list_parents)
				return;
			$fs_table = FSFactory::getClass('fstable');
			$query = 'SELECT name,id,alias,parent_id FROM '.$fs_table -> getTable('fs_contents_categories').
					' WHERE id IN (0'.$list_parents.'0) AND id <> '.$cat_id.'
					ORDER BY POSITION(","+id+"," IN "0'.$list_parents.'0")';
			global $db;
			$db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
	}
	
?>