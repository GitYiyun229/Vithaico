<?php

include 'blocks/banners/models/banners.php';

class BannersBControllersBanners
{
	function display($parameters, $title, $id = null)
	{
		$style = $parameters->getParams('style');
		$suffix = $parameters->getParams('suffix');
		$category_id = $parameters->getParams('category_id');
		$product_category_id = $parameters->getParams('product_category_id');
		$out_id = $parameters->getParams('id');

		$style = $style ? $style : 'default';

		// call models
		$model = new BannersBModelsBanners();
		$list = $model->getList($category_id, $product_category_id);

		if (!$list)
			return;
		// call views
		include 'blocks/banners/views/banners/' . $style . '.php';
	}
}
