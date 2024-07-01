<?php
	class LocationControllersCities extends Controllers
	{
	   function __construct()
		{
			$this->view = 'cities' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data('');
			$areas = $model->get_records('published = 1','fs_areas');
			
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$areas = $model->get_records('published = 1','fs_areas');
			$maxOrdering = $model->getMaxOrdering();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$areas = $model->get_records('published = 1','fs_areas');
			$data = $model->get_record_by_id($id);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		/*
		 * Tạo alias tỉnh / thành phố để bổ sung
		 */
		function genarate_alias(){
			$model = $this -> model;
			$areas = $model->genarate_alias();
		}
	}
	
?>