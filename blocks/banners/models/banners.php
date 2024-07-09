<?php
class BannersBModelsBanners
{
	function getList($category_id, $product_category_id = null)
	{
		if ($product_category_id) {
			$where = " AND products_categories LIKE '%,$product_category_id,%' ";
		} else {
			$where = " AND category_id IN ($category_id) ";
		}

		$query = "SELECT name, id, image, link, content, summary
				FROM fs_banners AS a
				WHERE published = 1 $where  
				ORDER BY ordering, id 
		";

		global $db;
		return $db->getObjectList($query, USE_MEMCACHE);
	}
}