<?php
	class NewsControllersCategories extends ControllersCategories{
	   function __construct()
		{
			$this->view = 'categories' ; 
			parent::__construct(); 
		}
        
        function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			$categories = $model->get_categories_tree();
 
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	}
	
?>