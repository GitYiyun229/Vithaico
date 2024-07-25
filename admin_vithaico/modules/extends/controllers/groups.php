<?php
class ExtendsControllersGroups extends Controllers {
	
	function display() {
		parent::display ();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;
		
		$model = $this->model;
		$list = $model->get_data ('');
		$field_group = $model->get_field_group();
		$pagination = $model->getPagination ('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}

	function add()
	{
		$model =  $this->model;
		$field_group = $model->get_field_group();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	
	function edit()
	{
		$model =  $this->model;
		$id  = FSInput::get('id', 0, 'int');
		$data = $model->get_record_by_id($id);
		$field_group = $model->get_field_group();
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
}

?>