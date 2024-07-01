<?php
	// models 
	class ExtendsControllersTables  extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
			$fields_default = array(
				0 => array('show'=>'Id','name'=>'id','type'=>'int'),
				1 => array('show'=>'Tên','name'=>'name','type'=>'varchar'),
				2 => array('show'=>'Tên hiệu','name'=>'alias','type'=>'varchar'),
				3 => array('show'=>'Thứ tự','name'=>'ordering','type'=>'int'),
				4 => array('show'=>'Hiển thị','name'=>'published','type'=>'int'),
				5 => array('show'=>'Seo title','name'=>'seo_title','type'=>'varchar'),
				6 => array('show'=>'Seo keyword','name'=>'seo_keyword','type'=>'varchar'),
				7 => array('show'=>'Seo description','name'=>'seo_description','type'=>'varchar'),
				8 => array('show'=>'Ngày tạo','name'=>'created_time','type'=>'datetime'),
				9 => array('show'=>'Ngày sửa','name'=>'edited_time','type'=>'datetime')
			);
			
			$this -> fields_default = $fields_default;
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			// call models
			$model  = $this -> model;
			$list = $model->get_data('');
			
			$pagination = $model->getPagination('');
			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function edit()
		{
			$model = $this -> model;
			$data = $model->getTableFields();
			$table_name = FSInput::get('tablename');
			$table_name = strtolower($table_name);
			if(strpos($table_name, 'fs_extends_') === false){
				$table_name = 'fs_extends_'.$table_name;
			}
			$default_table = $model -> check_enable_default_table($table_name);
			include 'modules/'.$this->module.'/views/tables/detail.php';
		}
		function add()
		{
			$model =  $this -> model;
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		
//		/*********** FIELD ***************/
		function apply_edit()
		{
			$model = $this -> model;
			$tablename = FSInput::get('table_name');
			$tablename = strtolower($tablename);
			$tablename = "fs_extends_".$tablename;
			$rs = $model->save_edit();
			if($rs)
			{
				$cid = FSInput::get('cid');
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$tablename",FSText::_('Saved'));
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
			
		}
		function save_edit()
		{
			$model = $this -> model;
			$rs = $model->save_edit();
			if($rs)
			{
				$cid = FSInput::get('cid');
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Saved'));
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		
		function cancel()
		{
			setRedirect("index.php?module=".$this -> module.'&view='.$this -> view);
		}
		
		/*
		 * Create table
		 */
		function apply_new()
		{
			$model = $this -> model;
			$rs = $model->table_new();
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view."&task=edit&tablename=$rs","L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		/*
		 * Create table
		 */
		function save_new()
		{
			$model = $this -> model;
			$rs = $model->table_new();
			if($rs)
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,"L&#432;u th&#224;nh c&#244;ng");
			}
			else 
			{
				setRedirect("index.php?module=".$this -> module.'&view='.$this -> view,FSText::_('Error'),'error');
			}	
		}
		
		function table_add()
		{
			$fields_default = $this -> fields_default;
			$model = $this -> model;
			include 'modules/'.$this->module.'/views/tables/new.php';
		}
		
		/*
		 * create Filter
		 */
		function filter()
		{
			$tablename  = FSInput::get('table_name');
			
			if($tablename)
			{
				$tablename = "fs_extends_".$tablename;
				setRedirect("index.php?module=".$this -> module."&view=filters&tablename=$tablename");
			}
			else
			{
				$this->table_add();
			}
		}
	/*
		 * Function support for list items
		 */
		function edit_table($table_name){
			$link = 'index.php?module=extends&view=tables&task=edit&tablename='.	$table_name;
			return '<a href="'.$link.'" target="_blink">Sửa bảng</a>';		
		}
		
		function post_item($table_name){
			$link = 'index.php?module=extends&view=items&table_name='.substr($table_name,11);
			return '<a href="'.$link.'" target="_blink">Dữ liệu</a>';		
		}
		function view_edit_table($table_name){
			$link = 'index.php?module=extends&view=tables&task=edit&tablename='.substr($table_name,11);
			return '<a href="'.$link.'" target="_blink"><img border="0" src="templates/default/images/edit_icon.png" alt="Views"></a>';		
		}
	}
	
?>