<?php
/*
 * Huy write
 */
class BreadcrumbsBControllersBreadcrumbs
{
	function __construct()
	{
	}
	function display($parameters, $title)
	{
		$style = $parameters->getParams('style');
		$style = $style ? $style : 'default';

		global $tmpl;
		$breadcrumbs = $tmpl->get_variables('breadcrumbs');
		// call views
		include 'blocks/breadcrumbs/views/breadcrumbs/' . $style . '.php';
	}
}
