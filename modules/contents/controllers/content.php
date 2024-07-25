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
		if (!$data) {
			setRedirect(URL_ROOT, 'Bài viết không tồn tại', 'error');
		}

		// foreach ($cat as $item_cat) {
		// 	$item_cat->list_item = $model->getList($item_cat->id);
		// }
		$list_item = $model->getList($data->category_id);
		$cat_id = $data->category_id;
		$cat  = $model->getCategory($cat_id);
		$dataSame = $model->getCatSame($cat->cat_same);
		// print_r($cat);
		// print_r($dataSame);
		// $cat  = $model->getCategory();
		foreach ($dataSame as $item_same) {
			// $query_body_same = $model->set_query_body($item_same->id);
			$item_same->list_item = $model->getList($item_same->id);
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
