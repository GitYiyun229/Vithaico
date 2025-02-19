<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class ContactControllersContact extends Controllers
	{
		function __construct()
		{
			$this->view = 'contact' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$list = $this -> model->get_data('');
			// print_r($list);
			$pagination = $this -> model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			
			$data = $model->get_record_by_id($id);
			$parts = $model->get_parts();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>