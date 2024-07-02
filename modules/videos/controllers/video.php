<?php
/*
 * Huy write
 */
	// controller
	
	class VideosControllersVideo extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{
			// call models
			$model = new VideosModelsVideo();
			
			$data = $model->getVideos();

           if (! $data){
               $link = URL_ROOT.'404.html';
               setRedirect($link);
           }

			global $tmpl,$module_config;
			$tmpl -> set_data_seo($data);

			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>"Video", 1 => FSRoute::_('index.php?module=videos&view=cat'));
			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// seo
			$tmpl -> set_data_seo($data);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		
	}
	
?>