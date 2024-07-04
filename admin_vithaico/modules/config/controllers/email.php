<?php
	class ConfigControllersEmail  extends Controllers
	{
		function __construct()
		{
			
			parent::__construct(); 
		}
		function display()
		{
			$model  = $this -> model;
			$data = $model->getData();
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		function save()
		{
			$model  = $this -> model;
		
			// call Models to save
			$cid = $model->save();
			if($cid)
			{
				setRedirect('index.php?module=config&view=email',FSText :: _('Saved'));	
			}
			else
			{
				setRedirect("index.php?module=config&view=email",FSText :: _('Not save'),'error');	
			}
			
		}
	

	}
	
?>