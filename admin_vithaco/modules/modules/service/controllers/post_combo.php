<?php
	class ServiceControllersPost_combo  extends Controllers
	{
		function __construct()
		{
			$this->view = 'post_combo' ;
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
            
            $list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			//$categories = $model->get_categories_tree();
			//$list_key = array();
			// data from fs_news_categories
			//$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			//$uploadConfig = base64_encode('add|'.session_id());
            //$list_key = $model->get_records(' new_id = "'.$uploadConfig.'"','fs_news_keyword');
            $list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
            
            $list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}


	}

?>
