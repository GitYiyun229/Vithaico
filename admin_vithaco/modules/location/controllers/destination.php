<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class LocationControllersDestination extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$cities = $model->get_all_record('fs_cities');
			
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$cities = $model->get_all_record('fs_cities');
			$districts  = $model -> get_districts(1473);
			$maxOrdering = $model->getMaxOrdering();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$cities = $model->get_all_record('fs_cities');
			$districts  = $model -> get_districts($data -> city_id);
			
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>