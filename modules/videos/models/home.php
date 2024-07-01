<?php
	class VideosModelsHome extends FSModels
	{
		function getVideos()
		{
			global $db;
			$query = "SELECT a.id, a.video, a.title, a.hits, a.show_in_homepage, a.product_id, b.alias as product_alias FROM fs_video as a LEFT JOIN fs_products as b 
                                                          ON a.product_id = b.id
                                                          WHERE a.published = 1 ORDER BY a.ordering DESC, a.id DESC";
			$db->query($query);
			$data = $db->getObjectList();
			return $data;
		}

	}

?>
