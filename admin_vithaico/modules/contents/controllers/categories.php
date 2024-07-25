<?php
class ContentsControllersCategories extends ControllersCategories
{
	function __construct()
	{
		$this->view = 'categories';
		parent::__construct();
	}
	function display()
	{
		parent::display();
		// $sort_field = $this -> sort_field;
		// $sort_direct = $this -> sort_direct;

		// $model  = $this -> model;
		// $list = $this -> model->get_categories_tree();
		// $pagination = $model->getPagination('');
		// include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
	}
	function add()
	{
		// parent::add();
		$list_cat = $model->get_records('published = 1', 'fs_contents_categories', 'id, name');
		$model =  $this->model;


		$categories = $model->get_categories_tree();
		$maxOrdering = $model->getMaxOrdering();
		//$categories_products = $model->get_product_categories_tree_by_permission();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	function edit()
	{
		$model =  $this->model;
		$list_cat = $model->get_records('published = 1', 'fs_contents_categories', 'id, name');

		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$data = $model->get_record_by_id($id);
		$categories = $model->get_categories_tree();
		//$categories_products = $model->get_product_categories_tree_by_permission();

		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
}
