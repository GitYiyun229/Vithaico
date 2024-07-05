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
		$model = $this->model;
		$cat = $model->getCategory();

		if (!$cat) {
			setRedirect(URL_ROOT, 'Không tồn tại danh mục này', 'error');
		}

		$list_cat = $this->model->get_list_categories();
		$list_hot_news = $this->model->get_list_hot($cat->id);

		$query_body = $model->set_query_body($cat->id);
		$list_news = $model->get_list($query_body);

		$total = $model->getTotal($query_body);
		$pagination = $model->getPagination($total);

		$breadcrumbs = array();
		$breadcrumbs[] = array(0 => FSText::_('Trang chủ'), 1 => FSRoute::_('index.php?module=home&view=home'));
		$breadcrumbs[] = array(0 => FSText::_('Tin tức'), 1 => FSRoute::_(''));

		$cat_parent = $this->model->get_records('id IN (0' . $cat->list_parents . '0)', FSTable::_('fs_news_categories', 1), 'id,name,alias', 'level asc');
		foreach ($cat_parent as $item) {
			$breadcrumbs[] = array(0 => $item->name, 0);
		}
		// $breadcrumbs[] = array(0 => $cat->name, 1 => '');
		global $tmpl;
		$tmpl->assign('breadcrumbs', $breadcrumbs);
		$tmpl->assign('title', $cat->name);
		$tmpl->assign('alias', $cat->alias);
		$tmpl->assign('id', $cat->id);

		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
}
