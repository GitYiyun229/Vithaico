<?php 
		
	$path = PATH_BASE . DS . 'modules' . DS . 'contact' . DS . 'controllers' . DS . 'contact' . ".php";
	if(!file_exists($path))
		echo FSText :: _("Not found controller");
	else
		require_once 'controllers/contact.php';
		
	$c =  'ContactControllersContact';
	$controller = new $c();
	$task = FSInput::get('task','display');
	$controller->$task();
?>