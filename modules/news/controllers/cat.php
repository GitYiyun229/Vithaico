<?php
/*
 * 
 */
	// controller
	
	class NewsControllersCat extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			$redirect = $model->get_redirect();
			$code = substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT_REDUCE));
			if (@$redirect) {
				$data_prd = $model->get_product_re($redirect->record_id);
				$linh_rec = FSRoute::_('index.php?module=news&view=cat&ccode=' . $data_prd->alias);
				if ($code != $data_prd->alias) {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $linh_rec);
					exit();
				}
			}

			$cat  = $model->getCategory();

            if (!$cat){
                $link = URL_ROOT.'404.html';
                setRedirect($link);
            }
			global $tags_group;
        	// $tags_group = $cat -> tags_group;
			$query_body = $model->set_query_body($cat->id);
			$news_list = $model->getNewsList($query_body);			
			$total = $model->getTotal($query_body);
			$pagination = $model->getPagination($total);
			
			$breadcrumbs = array();
			// $breadcrumbs[] = array(0=>'Tin tức', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			$breadcrumbs[] = array(0=>$cat->name, 1 => '');
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			// seo

			$page = FSInput::get('page',1);
			$tmpl -> set_data_seo($cat,$page);
			$pa = $page > 1 ? '/page-'.$page : '';
			$link_canonical = FSRoute::_("index.php?module=news&view=cat&ccode=".$cat->alias."&Itemid=3").$pa;
            $tmpl -> assign ('canonical',$link_canonical);
            $tmpl -> assign ('og_url',FSRoute::_("index.php?module=news&view=cat&ccode=".$cat->alias.""));
			$next_page = $page + 1;
			$tmpl->assign('link_next', FSRoute::_("index.php?module=news&view=home").'/page-'.$next_page);
			if($page > 1){ 
				$prev_page = $page - 1;
				if($prev_page == 1)
					$tmpl->assign('link_prev', FSRoute::_("index.php?module=news&view=cat&ccode=".$cat->alias));
				else
					$tmpl->assign('link_prev', FSRoute::_("index.php?module=news&view=cat&ccode=".$cat->alias).'/page-'.$prev_page);
			} 

			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
?>