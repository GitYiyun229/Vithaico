<?php
	class AdvicesControllersAdvices extends Controllers
	{
		function __construct()
		{
			$this->view = 'advices' ; 
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$categories = $model->get_categories_tree();
			
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
			$categories = $model->get_categories_tree();
			
			// data from fs_news_categories
			$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
			
			// products related
			$products_categories = $model->get_products_categories_tree();
				
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		
		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
			$categories  = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
			// products related
			$products_categories = $model->get_products_categories_tree();
			$products_related = $model -> get_products_related($data -> products_related);
			
			// data from fs_news_categories
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
		function view_comment($advice_id){
			$link = 'index.php?module=advices&view=comments&keysearch=&text_count=1&text0='.$advice_id.'&filter_count=1&filter0=0';
			return '<a href="'.$link.'" target="_blink">Comment</a>'; 
		}
		/***********
		 * PRODUCTS RELATED
		 ************/
		function ajax_get_products_related(){
			$model = $this -> model;
			$data = $model->ajax_get_products_related();
			$html = $this -> products_genarate_related($data);
			echo $html;
			return;
		}
		function products_genarate_related($data){
			$str_exist = FSInput::get('str_exist');
			$html = '';
				$html .= '<div class="products_related">';
				foreach ($data as $item){
					if($str_exist && strpos(','.$str_exist.',', ','.$item->id.',') !== false ){
						$html .= '<div class="red products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')" style="display:none" >';	
						$html .= $item -> title;				
						$html .= '</div>';					
					}else{
						$html .= '<div class="products_related_item  products_related_item_'.$item -> id.'" onclick="javascript: set_products_related('.$item->id.')">';	
						$html .= $item -> title;				
						$html .= '</div>';	
					}
				}
				$html .= '</div>';
				return $html;
		}
		/***********
		 * end PRODUCTS RELATED.
		 ************/
	}
?>