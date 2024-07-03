<?php
	// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';
		  
	class ProductsControllersThuonghieu extends Controllers
	{
		function __construct()
		{
			$this->view = 'products' ; 
			parent::__construct();
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
            $model = $this -> model;
			$list = $this -> model->get_data("");


			$pagination = $this -> model->getPagination("");
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        function add()
        {
            $model =  $this -> model;

            $maxOrdering = $model->getMaxOrdering();
            $origin = $model->get_records ('published = 1','fs_products_origin');
            //$categories_products = $model->get_product_categories_tree_by_permission();
            include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
        }
        function edit()
        {
            $model =  $this -> model;
            $ids = FSInput::get('id',array(),'array');
            $id = $ids[0];
            $origin = $model->get_records ('published = 1','fs_products_origin');
            $data = $model->get_record_by_id($id);

            //$categories_products = $model->get_product_categories_tree_by_permission();

            include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
        }
	}
	
?>