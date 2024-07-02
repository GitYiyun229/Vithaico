<?php
/*
 * Huy write
 */
	// controller

	class NewsControllersAmp_news extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			// call models
			$model = $this -> model;

			$data = $model->getNews();

			if(!$data)
				setRedirect(URL_ROOT,'Không tồn tại bài viết này','Error');
			$ccode = FSInput::get('acode');

			$category_id = $data -> category_id;
			$relate_news_list = $model->getRelateNewsList($category_id);

			$category = $model -> get_category_by_id($category_id);
			if(!$category)
				setRedirect(URL_ROOT,'Không tồn tại danh mục này','Error');
			global $tmpl,$module_config;
            $tmpl -> load_amp(0, 0,'','','',FSRoute::_('index.php?module=news&view=amp_news&code='.$data->alias.'&id='.$data->id.'&ccode='.$data->category_alias.'&Itemid=50'));
            $tmpl -> set_data_seo($data);
            
			$breadcrumbs = array();
			$breadcrumbs[] = array(0 => 'Tin tức & Sự kiện', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
			$breadcrumbs[] = array(0 => $category->name, 1 => FSRoute::_('index.php?module=news&view=cat&id=' . $data->category_id . '&ccode=' . $data->category_alias));
			$breadcrumbs[] = array(0 => $data->title, 1 => FSRoute::_('index.php?module=news&view=cat&id=' . $data->id . '&ccode=' . $data->alias));
			$tmpl->assign('breadcrumbs', $breadcrumbs);
			$images_face = URL_ROOT . str_replace('/original/', '/original/', $data->image);
			$tmpl->assign('og_image', $images_face);
			// call views
		include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

	}

?>
