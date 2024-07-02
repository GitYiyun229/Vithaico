<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Danh sách dữ liệu mở rộng') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
		
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
																																																																																																																																																																																																																																																																																																																																																																																																																						
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '40%','arr_params'=>array('size'=> 30));

	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Edit','field'=>'id', 'type'=>'text','arr_params'=>array('function'=> 'edit_button'));
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
//	add_params_form($name,$value = '')
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination,array('table_name'=>$table_name));
?>
