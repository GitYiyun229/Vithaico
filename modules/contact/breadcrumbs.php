<?php 
	class BreadcrumbsContact
	{
		function getBreadcrumbs()
		{
			$rs = array();
			$view = FSInput::get('view');
			$task = FSInput::get('task');
			$rs[0][0] = "Hệ thống cửa hàng";
			$rs[0][1] = '';
			return $rs;
		}
	}
?>