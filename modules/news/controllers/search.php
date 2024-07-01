<?php
/*
 * Huy write
 */
	// controller
	
	class NewsControllersSearch
	{
		var $module;
		var $view;
		function __construct()
		{
			
			$this->module  = 'news';
			$this->view  = 'search';
			include 'modules/'.$this->module.'/models/'.$this->view.'.php';
		}
		function display()
		{
			// call models
			$model = new NewsModelsSearch();
			$query_body = $model -> set_query_body();
			$list = $model -> get_list($query_body);
			$total = $model -> getTotal($query_body);
			$total_list = count($list);
			$pagination = $model->getPagination($total);
			// print_r($_REQUEST);
			// create breadcrumb
//			$array_breadcrumb = $model -> get_breadcrumb();
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>