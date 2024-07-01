<?php
	// models 
	class ExtendsControllersExtends  extends Controllers
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
			$list = $model->get_data();
		
			
			$pagination = $model->getPagination();
			// call views
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		/*
		 * Function support for list items
		 */
		function edit_table($table_name){
			$link = 'index.php?module=extends&view=tables&task=edit&tablename='.	$table_name;
			return '<a href="'.$link.'" target="_blink">Sửa bảng</a>';		
		}
		
		function post_item($table_name){
			$link = 'index.php?module=extends&view=items&table_name='.substr($table_name,11);
			return '<a href="'.$link.'" target="_blink">Dữ liệu</a>';		
		}
		
		function add()
		{
			$model =  $this -> model;
			$maxOrdering = $model->getMaxOrdering();
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$id  = FSInput::get('id',0,'int');
			$data = $model->get_record_by_id($id);
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>