<?php

include 'blocks/product_categories/models/product_categories.php';

class Product_categoriesBControllersProduct_categories
{
	function __construct()
	{
	}
	function display($parameters, $title)
	{
		$ordering = $parameters->getParams('ordering');
		$limit = $parameters->getParams('limit');
		$category_id = $parameters->getParams('category_id');
		$group = $parameters->getParams('group');

		$limit = $limit ? $limit : 10;

		$model = new Product_categoriesBModelsProduct_categories();
		$style = $parameters->getParams('style') ?: 'default';

		if (!empty($category_id)) {
			$list = $model->get_list_cat($category_id);
		} else {
			$list = $model->get_list();
		}
		$list_mobile = $model->getListMobile($group);
		// print_r($list_mobile);
		// call views
		include 'blocks/product_categories/views/product_categories/' . $style . '.php';
	}
	
}
 