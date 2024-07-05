<?php
class NewsModelsCat extends FSModels
{
	function __construct()
	{
		parent::__construct();
		global $module_config;
		$this->limit = 8;
		// $fstable = FSFactory::getClass('fstable');
		$this->table_news = FSTable::_('fs_news', 1);
		$this->table_cat_news = FSTable::_('fs_news_categories', 1);
	}

	function set_query_body($cid)
	{
		$query_ordering = '';
		$where = "";
		$query = ' FROM ' . $this->table_news . '
						  WHERE ( category_id = ' . $cid . ' 
						  	OR category_id_wrapper like "%,' . $cid . ',%" )
						  	AND published = 1 AND is_hot = 0
						    ' . $where . '
                            ORDER BY created_time DESC, id DESC 
                            ';
		return $query;
	}

	function get_list_categories()
	{
		global $db;
		$query = "SELECT id, name, alias , image
                  FROM " . $this->table_cat_news . "
                  WHERE published = 1
                  ORDER BY ordering ASC";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function getCategory()
	{
		$id = FSInput::get('id', 0, 'int');
		if ($id) {
			$where = " AND id = '$id' ";
		} else {
			$code = FSInput::get('ccode');
			if (!$code)
				die('Not exist this url');
			$where = " AND `alias` = '$code' ";
		}

		$query = "  SELECT `id`,`name`, `alias`, `parent_id`, `level`, image, list_parents
				    FROM " . $this->table_cat_news . " 
					WHERE `published` = 1 " . $where;
		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
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

	function get_list($query_body)
	{
		if (!$query_body)
			return;

		global $db;
		$query = " SELECT id, title, alias, image, summary, category_name, created_time";
		$query .= $query_body;
		$sql = $db->query_limit($query, $this->limit, $this->page);
		return $db->getObjectList();
	}

	function get_list_hot($cid)
	{
		global $db;
		$query = "SELECT id, title, alias, image, summary, category_name, created_time
                  FROM " . $this->table_news . "
                  WHERE published = 1 AND is_hot = 1 AND ( category_id = " . $cid . " OR category_id_wrapper like '%," . $cid . ",%' )
                  ORDER BY created_time DESC, ordering ASC LIMIT 5";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
}
