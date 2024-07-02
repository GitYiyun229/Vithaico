<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class LocationControllersDistricts extends Controllers
	{
		function __construct()
		{
			$this->view = 'districts' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
            
			$cities = $model-> get_records('published = 1','fs_cities','id,name');
			$areas = $model->get_records('published = 1','fs_areas','id,name');
            
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$cities = $model-> get_records('published = 1','fs_cities','id,name');
			$areas = $model->get_records('published = 1','fs_areas','id,name');
			$maxOrdering = $model->getMaxOrdering();
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
            
			$cities = $model-> get_records('published = 1','fs_cities','id,name');
			$areas = $model->get_records('published = 1','fs_areas','id,name');
            
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>