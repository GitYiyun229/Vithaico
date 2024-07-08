<?php
/*
 * Huy write
 */
// controller

class ContentsControllersContent extends FSControllers
{
	var $module;
	var $view;

	function display()
	{
		$model = $this->model;

		$data = $model->get_data_content();
		print_r($data->category_id);
		if (!$data) {
			setRedirect(URL_ROOT, 'Bài viết không tồn tại', 'error');
		}
		$cat  = $model->getCategory();
		foreach ($cat as $item_cat) {
			$item_cat->list_item = $model->getList($item_cat->id);
		}
		// if ($data->category_id == 1 || $data->category_id == 2) {
		// 	$cat  = $model->getCategory(1);
		// 	$cat2  = $model->getCategory(2);
		// 	foreach ($cat as $item_cat) {
		// 		$item_cat->list_item = $model->getList(1);
		// 	}
		// 	foreach ($cat2 as $item_cat2) {
		// 		$item_cat2->list_item2 = $model->getList(2);
		// 	}
		// } else {
		// 	$cat  = $model->getCategory($data->category_id);
		// 	foreach ($cat as $item_cat) {
		// 		$item_cat->list_item = $model->getList($data->category_id);
		// 	}
		// }
		global $tmpl;
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	}
}