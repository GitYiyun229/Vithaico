<?php
	class NewsControllerstags extends ControllersCategories{
	   function __construct()
		{
			$this->view = 'tags' ;
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

        function is_hot()
        {
            $this->is_check('is_hot', 1, 'is_hot');
        }

        function unis_hot()
        {
            $this->unis_check('is_hot', 0, 'un_hot');
        }
	}
	
?>