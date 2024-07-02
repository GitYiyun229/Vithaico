<?php
/*
 * 
 */
	// controller
	
	class NewsControllersHome extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body();
			$news_list = $model->getNewsList($query_body);
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);


            $breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức & Sự kiện', 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);

			$page = FSInput::get('page',1);
			$tmpl -> set_seo_special($page);
			$pa = $page > 1 ? '/page-'.$page : '';
			$link_canonical = FSRoute::_("index.php?module=news&view=home").$pa;
			// $link_canonical = FSRoute::_("index.php?module=news&view=home");
            $tmpl -> assign ('canonical',$link_canonical);
			$tmpl -> assign ('og_url',FSRoute::_("index.php?module=news&view=home"));
			$next_page = $page + 1;
			$tmpl->assign('link_next', FSRoute::_("index.php?module=news&view=home").'/page-'.$next_page);
			if($page > 1){ 
				$prev_page = $page - 1;
				if($prev_page == 1)
					$tmpl->assign('link_prev', FSRoute::_("index.php?module=news&view=home"));
				else
					$tmpl->assign('link_prev', FSRoute::_("index.php?module=news&view=home").'/page-'.$prev_page);
			} 
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
	}
	
?>