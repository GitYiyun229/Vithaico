<?php
class ProductsControllersProduct extends Controllers
{
	function __construct()
	{
		$this->view = 'product';
		parent::__construct();
	}
	function display()
	{
		parent::display();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;

		$model  = $this->model;
		$list = $model->get_data();
		$categories = $model->get_categories_tree();

		$pagination = $model->getPagination('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add2()
	{
		$model = $this->model;
		$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();

		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	function add()
	{
		$model = $this->model;
		$cid = FSInput::get('cid');
		if ($cid) {
			$category = $model->get_record_by_id($cid, 'fs_products_categories');
			$list_manufactor = explode(',', $category->list_manufactor);
			$tablename = @$category->tablename;
			$relate_categories = $model->getRelatedCategories(@$category->tablename);
			$manufactories = $model->getManufactories(@$category->tablename);

			for ($i = 1; $i < count($list_manufactor) - 1; $i++) {
				$list_producer[$i] = $model->get_record_by_id($list_manufactor[$i], 'fs_products_manufactories');
			}
			$origin = $model->get_records('published = 1', 'fs_products_origin');
			$colors = $model->get_records('published = 1', 'fs_products_colors');
			// types
			$types = $model->get_records('published = 1', 'fs_products_types');

			// extend field
			$extend_fields = $model->getExtendFields($tablename);
			$data_foreign = $model->get_data_foreign($extend_fields);
			$maxOrdering = $model->getMaxOrdering();

			// all categories
			$categories = $model->get_categories_tree();
			include 'modules/' . $this->module . '/views/' . $this->view . '/select_categories.php';

		} else {
			$categories = $model->get_categories_tree();
			include 'modules/' . $this->module . '/views/' . $this->view . '/select_categories.php';
		}
	}
	function edit()
	{
		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$model = $this->model;
		$data = $model->get_record_by_id($id);
		$categories = $model->get_categories_tree();
		// data from fs_products_categories
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}

	function is_hot()
	{
		$this->is_check('is_hot', 1, 'is_hot');
	}
	function unis_hot()
	{
		$this->unis_check('is_hot', 0, 'un_hot');
	}
	function is_sell()
	{
		$this->is_check('is_sell', 1, 'is hot');
	}
	function unis_sell()
	{
		$this->unis_check('is_sell', 0, 'un is hot');
	}
	function is_stock()
	{
		$this->is_check('is_stock', 1, 'is_stock');
	}
	function unis_stock()
	{
		$this->unis_check('is_stock', 0, 'un_stock');
	}
}
