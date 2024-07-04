<?php
	// models 

		  
	class ProductsControllersProduct_contact extends Controllers
	{
		function __construct()
		{
			$this->view = 'product_contact' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $this -> model->get_data('');
			$pagination = $model->getPagination('');
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		
		function add()
		{
			$model =  $this -> model;
			
			$maxOrdering = $model->getMaxOrdering();
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$data = $model->get_record_by_id($id);
			// var_dump($data );			
          
			$tables = $model->get_tablenames();
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	
		function view_history($record_id) {
			$link = 'index.php?module=order&view=order_man&record_id='.$record_id;
			return '<a href="' . $link . '" target="_blink"><img border="0" src="templates/default/images/Money-Graph-icon.png" alt="History"></a>';
		}
		function is_retail()
		{
			$model = $this -> model;
			$rows = $model->is_retail(1);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was event'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when old record'),'error');	
			}
		}
		function unis_retail()
		{
			$model = $this -> model;
			$rows = $model->is_retail(0);
			$link = 'index.php?module='.$this -> module.'&view='.$this -> view;
			$page = FSInput::get('page',0);
			if($page > 1)
				$link .= '&page='.$page;
			if($rows)
			{
				setRedirect($link,$rows.' '.FSText :: _('record was un_sell'));	
			}
			else
			{
				setRedirect($link,FSText :: _('Error when un_old record'),'error');	
			}
		}
	}
	
?>