<?php
	class DocumentsControllersDepartment extends Controllers
	{
		function __construct()
		{
			$this->view = 'department' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function edit(){
			$id = FSInput::get('id');
			$model  = $this -> model;
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>