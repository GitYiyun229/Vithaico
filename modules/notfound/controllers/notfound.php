<?php
/*
 * Huy write
 */
	// controller
	
	class NotfoundControllersNotfound extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
	}
	
?>