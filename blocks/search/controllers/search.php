<?php

require 'blocks/search/models/search.php';

class SearchBControllersSearch
{
	function display($parameters, $title = '')
	{
		$style = $parameters->getParams('style');
		$style = $style ? $style : 'default';

		$model = new SearchBModelsSearch();
		global $tmpl;
		
		include 'blocks/search/views/search/' . $style . '.php';
	}
}
