<?php 
	class ProductsModelsAutumn extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'autumn';
			$this -> table_name = 'fs_autumn';
			$this -> check_alias = 0;
			parent::__construct();
		}
	}
?>