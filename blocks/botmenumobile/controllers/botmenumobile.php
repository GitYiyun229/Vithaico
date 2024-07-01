<?php
	// models 
	include 'blocks/botmenumobile/models/botmenumobile.php';
	class BotmenumobileBControllersBotmenumobile
	{
		function __construct()
		{
		}
		function display($parameters,$title)
		{

			$ordering = $parameters->getParams('ordering'); 
		    $type  = $parameters->getParams('type'); 
			$limit = $parameters->getParams('limit');
			$limit = $limit ? $limit:5; 
			// call models
			$model = new BotmenumobileBModelsBotmenumobile();
//			$id = FSInput::get('id');
			$list_menu = $model -> get_menu(21);
			$list_menu_mb = $model -> get_menu(24);
//			$agency = $model->get_agency();
//            if(!$list && !$agency)
//                return false;
            $style = $parameters->getParams('style');
            $style = $style?$style:'default';
			include 'blocks/botmenumobile/views/botmenumobile/'.$style.'.php';
		}
	}
	
?>