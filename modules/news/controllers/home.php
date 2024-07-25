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
		$model = $this->model;

		$list_cat = $this->model->get_list_categories();
		$list_hot_news = $this->model->get_list_hot();

		$query_body = $model->set_query_body();
		$list_news = $model->get_list_new($query_body);
		$total = $model->getTotal($query_body);
		$pagination = $model->getPagination($total);

		$breadcrumbs = [];
		$breadcrumbs[] = array(0 => FSText::_('Trang chủ'), 1 => FSRoute::_('index.php?module=home&view=home'));
		$breadcrumbs[] = array(0 => FSText::_('Tin tức'), 0);
		// $breadcrumbs[] = array(0 =>FSText::_('Tin tức'), 1 => FSRoute::_('index.php?module=news&view=home'));

		global $tmpl;
		$tmpl->set_seo_special();
		$tmpl->assign('breadcrumbs', $breadcrumbs);

		// call views			
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
}
