<?php
class MainMenuBModelsMainMenu
{
	function getList($group)
	{
		$global_class = FSFactory::getClass('FsGlobal');
		$list = $global_class->get_menu_by_group($group);

		if (!$list)
			return;
		
		$tree_class  = FSFactory::getClass('tree', 'tree/');
		return $list = $tree_class->indentRows($list, 3);
	}

	function get_category()
	{
		$fs_table = FSFactory::getClass('fstable');
		$query = "  SELECT name,id,alias,tablename
						FROM fs_products_categories 
						WHERE published = 1 
					";
		global $db;
		$db->query($query);
		$products = $db->getObjectListByKey('id');
		return $products;
	}
	
	function get_filter_all()
	{
		global $db;
		$query = " SELECT *
							FROM fs_products_filters
							WHERE published = 1
							ORDER BY is_common DESC, field_ordering,filter_show ASC 
							";
		$db->query($query);
		$result = $db->getObjectList('', USE_MEMCACHE);
		return $result;
	}
}
