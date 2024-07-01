<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersTags extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;
			$tags  = $model->getTags();

            if (!$tags){
                $link = URL_ROOT.'404.html';
                setRedirect($link);
            }
			global $tags_group;
//            $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($tags->id);
			$news_list = $model->getNewsList($query_body);			
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Tin tức & Sự kiện', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			$breadcrumbs[] = array(0=>$tags->name, 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo
			$page = FSInput::get('page');
            $tmpl->assign('title', $data->title);
			$tmpl -> set_data_seo($tags,$page);
			$pa = $page?'-page'.$page:'';
			$link_canonical = FSRoute::_("index.php?module=news&view=cat&ccode=".$tags->alias."&Itemid=3").$pa;
            $tmpl -> assign ( 'canonical',$link_canonical);
			
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>