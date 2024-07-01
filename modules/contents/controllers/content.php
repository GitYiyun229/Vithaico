<?php
/*
 * Huy write
 */
	// controller
	
	class ContentsControllersContent extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{	
			$model = $this->model;

            $data = $model->get_data_content(); 
			$cat  = $model->getCategory();
			echo 1 ;
			foreach($cat as $item_cat){ 
				$item_cat->list_item = $model->getList($item_cat->id);

			}
 
            global $tmpl; 
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}

	}
	
?>