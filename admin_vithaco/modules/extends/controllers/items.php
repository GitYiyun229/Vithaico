<?php
	// models 
	class ExtendsControllersItems  extends Controllers
	{
		function __construct()
		{
			parent::__construct(); 
		}
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			$model  = $this -> model;
			$list = $model->get_data();
			$table_name = FSInput::get('table_name');
			$pagination = $model->getPagination();
			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model =  $this -> model;
			$maxOrdering = $model->getMaxOrdering();
//			$tables = $model->get_tablenames();
			$fields = $model->get_fields();
			$table_name = FSInput::get('table_name');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		function edit()
		{
			$model =  $this -> model;
			$id  = FSInput::get('id',0,'int');
			$data = $model->get_record_by_id($id);
//			$tables = $model->get_tablenames();
			$fields = $model->get_fields();
			$table_name = FSInput::get('table_name');
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
	function apply()
	{
		$model = $this -> model;
		$id = $model->save();
		$table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&table_name='.$table_name_extend;
		
		// call Models to save
		if($id)
		{
			setRedirect($link.'&task=edit&id='.$id,FSText :: _('Saved'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Not save'),'error');	
		}
	}
	/*
	 * Tạo nút edit cho item
	 */
	function edit_button($id){
		$table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module=extends&view=items&task=edit&table_name='.$table_name_extend.'&id='.$id;
		return '<a href="'.$link.'" ><img border="0" src="templates/default/images/edit_icon.png" alt="Views"></a>';
	}
	function save()
	{
		$model = $this -> model;
		// check password and repass
		// call Models to save
		$id = $model->save();
		$table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&table_name='.$table_name_extend;	
		if($id)
		{
			setRedirect($link,FSText :: _('Saved'));	
		}
		else
		{
			setRedirect($link,FSText :: _('Not save'),'error');	
		}
	}
	function cancel(){
		$table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&table_name='.$table_name_extend;
		setRedirect($link);	
	}
	function back(){
		$table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&table_name='.$table_name_extend;
		setRedirect($link);	
	}
	function save_all(){
	   $model = $this -> model;
        // check password and repass
        // call Models to save
        $id = $model->save_all();
        $table_name_extend = FSInput::get('table_name');
		$link = 'index.php?module='.$this -> module.'&view='.$this -> view.'&table_name='.$table_name_extend;
        $page = FSInput::get('page',0,'int');
        if($page)
              $link .= '&page='.$page;  
        if($id)
        {
            setRedirect($link,FSText :: _('Saved'));    
        }
        else
        {
            setRedirect($link,FSText :: _('Not save'),'error'); 
        }
	}
}
	
?>