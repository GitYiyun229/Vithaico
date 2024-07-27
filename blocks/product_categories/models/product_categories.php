<?php
class Product_categoriesBModelsProduct_categories
{
	function get_list()
	{
		global $db;
		$table = FSTable::_('fs_products_categories');
		$sql = "SELECT id, name, alias, icon,image, icon_hover,level,parent_id FROM $table WHERE published = 1 AND show_in_homepage = 1";
		$db->query($sql);
		return $db->getObjectList();
	}
	function get_list_cat($id)
	{
		global $db;
		$table = FSTable::_('fs_products_categories');
		$sql = "SELECT id, name, alias, icon,image, icon_hover,level,parent_id 
		FROM $table
		 WHERE published = 1 AND show_in_homepage = 1 and parent_id = $id";
		$db->query($sql);
		return $db->getObjectList();
	}
	function getListMobile($group)
	{
		if (!$group)
			return;
		global $db;

		$fstable  = FSFactory::getClass('fstable');
		$table_name = $fstable->getTable('fs_menus_items', '1');

		$sql = " SELECT id,image,link, name, level, parent_id as parent_id, 
                            target, description,link,summary,bk_color
					        FROM " . $table_name . "
					        WHERE published  = 1
						    AND group_id = $group 
					        ORDER BY ordering
                    ";

		$db->query($sql);
		// print_r($sql);
		$result =  $db->getObjectList();
		return $result;
	}
}
