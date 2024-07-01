<?php
class Product_categoriesBModelsProduct_categories
{
	function get_list()
	{
		global $db;
		$table = FSTable::_('fs_products_categories');
		$sql = "SELECT id, name, alias, icon, icon_hover,level,parent_id FROM $table WHERE published = 1 AND show_in_homepage = 1";
		$db->query($sql);
		return $db->getObjectList();
	}
	function get_list_cat($id)
	{
		global $db;
		$table = FSTable::_('fs_products_categories');
		$sql = "SELECT id, name, alias, icon, icon_hover,level,parent_id 
		FROM $table
		 WHERE published = 1 AND show_in_homepage = 1 and parent_id = $id";
		$db->query($sql);
		return $db->getObjectList();
	}
}
