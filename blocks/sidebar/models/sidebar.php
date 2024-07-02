<?php
class SidebarBModelsSidebar
{
	function __construct()
	{
		$fstable = FSFactory::getClass('fstable');
		$this->table_name = $fstable->_('fs_products', 1);
		$this->table_categories = $fstable->_('fs_products_categories', 1);
	}
	function get_categories($data = 6)
	{
		// if (empty($data)) {
		// 	$link = FSRoute::_('index.php?module=products&view=home');
		// 	$text = FSText::_('Xin chào !');
		// 	setRedirect($link, $text, '');
		// }
		global $db;
		$query = "SELECT *
			FROM " . $this->table_categories . "
			WHERE id = $data
			";
		$sql = $db->query($query);
		$result = $db->getObject();
		return $result;
	}
	function getList($group)
	{
		if (!$group)
			return;
		global $db;

		$fstable  = FSFactory::getClass('fstable');
		$table_name = $fstable->getTable('fs_menus_items', '1');

		$sql = " SELECT id,image,link, name, level, parent_id as parent_id, 
                            target, description,is_type,is_link,summary,bk_color
					        FROM " . $table_name . "
					        WHERE published  = 1
						    AND group_id = $group 
					        ORDER BY ordering
                    ";

		$db->query($sql);
		$result =  $db->getObjectList();
		$tree_class  = FSFactory::getClass('tree', 'tree/');
		return $list = $tree_class->indentRows($result, 3);
	}
	function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '')
	{
		$sql_where = " ";
		if ($where) {
			$sql_where .= ' WHERE ' . $where;
		}
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
						  FROM " . $table_name . $sql_where;
		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		if ($limit)
			$query .= ' LIMIT ' . $limit;
		global $db;

		if (!$field_key)
			$result = $db->getObjectList($query);
		else
			$result = $db->getObjectListByKey($field_key, $query);

		return $result;
	}
}
