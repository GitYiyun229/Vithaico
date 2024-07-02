<?php 
	class VideosModelsVideo extends FSModels
	{
		function __construct()
		{
			$limit = 2;
			$page = FSInput::get('page');
			$this->limit = $limit;
			$this->page = $page;
			$fstable = FSFactory::getClass('fstable');
		}

		function getVideos()
		{
			$id = FSInput::get('id',0,'int');
			if($id){
				$where = " AND id = '$id' ";				
			} else {
				$code = FSInput::get('code');
				$where = " AND alias = '$code' ";
			}
			$fs_table = FSFactory::getClass('fstable');
			$query = " SELECT *
						FROM ".$fs_table -> getTable('fs_video')." 
						WHERE published = 1
						".$where." ";
			global $db;
			$sql = $db->query($query);
			$result = $db->getObject();
			return $result;
		}

	}
	
?>