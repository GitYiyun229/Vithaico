<?php
class ContentsModelsCat extends FSModels
{
	function __construct()
	{
		parent::__construct();
		global $module_config;
		$limit = '';
		FSFactory::include_class('parameters');
		if (!empty($module_config->params)) {
			$current_parameters = new Parameters($module_config->params);
			$limit = $current_parameters->getParams('limit');
		}

		$this->limit = $limit ? $limit : 8;
	}
	function set_query_body($cid)
	{
		$where  = "";
		$fs_table = FSFactory::getClass('fstable');
		$query = " FROM " . $fs_table->getTable('fs_contents', 1) . "
						  WHERE ( category_id = $cid 
						  	OR category_id_wrapper like '%," . $cid . ",%' )
						  	AND published = 1 AND category_published = 1
						  	" . $where .
			" ORDER BY  ordering asc, id DESC
						 ";
		return $query;
	}
	/*
		 * get Category current
		 * By Id or By code
		 */
	function getCategory()
	{
		$fs_table = FSFactory::getClass('fstable');
		$code = FSInput::get('ccode');
		if ($code) {
			$where = " AND alias = '$code' ";
		} else {
			$id = FSInput::get('id', 0, 'int');
			if (!$id)
				die('Not exist this url');
			$where = " AND id = '$id' ";
		}
		$query = " SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,list_parents, cat_same
						FROM " . $fs_table->getTable('fs_contents_categories', 1) . " 
						WHERE published = 1 " . $where;
		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}

	public function getDataSame($id)
	{
		global $db;
		$fs_table = FSFactory::getClass('fstable');
		$sql = "SELECT id,name, icon, alias,parent_id as parent_id,seo_title,seo_keyword,seo_description,list_parents, cat_same
					FROM " . $fs_table->getTable('fs_contents_categories', 1) . "
					WHERE id IN (0" . $id . "0) AND published = 1
			";
		// print_r($sql);
		return $db->getObjectList($sql, USE_MEMCACHE);
	}

	function getContentsList($query_body)
	{
		if (!$query_body)
			return;

		global $db;
		$query = " SELECT id,title,image,content, created_time,category_id, category_alias, alias";
		$query .= $query_body;
		$sql = $db->query_limit($query, $this->limit, $this->page);
		// print_r($sql);
		$result = $db->getObjectList();
		return $result;
	}

	function getTotal($query_body)
	{
		if (!$query_body)
			return;
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
		$pagination = new Pagination($this->limit, $total, $this->page);
		return $pagination;
	}

	/*
		 * get Most Reading new
		 * LIMIT IN 600 days
		 */
	function get_most_read_contents($category_id, $limit, $str_contents_ids, $limit_day = 4)
	{
		if (!$limit)
			$limit = 9;
		$fs_table = FSFactory::getClass('fstable');
		$query = ' SELECT id, title,image, summary,alias, category_alias,category_id
					  FROM  ' . $fs_table->getTable('fs_contents', 1) . '
					  WHERE published = 1
					  AND category_id_wrapper like "%,' . $category_id . ',%"
					  AND id NOT IN (' . $str_contents_ids . ')
					  AND updated_time >= DATE_SUB(CURDATE(), INTERVAL ' . $limit_day . ' DAY)
					ORDER BY created_time DESC
					 ';
		global $db;
		$sql = $db->query_limit($query, $limit);
		return  $db->getObjectList();
	}

	function get_list_parent($list_parents, $cat_id)
	{
		if (!$list_parents)
			return;
		$fs_table = FSFactory::getClass('fstable');
		$query = 'SELECT name,id,alias,parent_id FROM ' . $fs_table->getTable('fs_contents_categories', 1) .
			' WHERE id IN (0' . $list_parents . '0) AND id <> ' . $cat_id . '
					ORDER BY POSITION(","+id+"," IN "0' . $list_parents . '0")';
		global $db;
		$db->query($query);
		$list = $db->getObjectList();
		return $list;
	}
}
