<?php  
	global $toolbar;
	$toolbar->setTitle(FSText::_('Danh sách dữ liệu mở rộng') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
//	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
		
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
																																																																																																																																																																																																																																																																																																																																																																																																																						
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
//	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '25%','arr_params'=>array('size'=>40,'rows'=>3));
//	$list_config[] = array('title'=>'Tên bảng mở rộng','field'=>'table_name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Dữ liệu','field'=>'table_name', 'type'=>'text','arr_params'=>array('function'=> 'post_item'));
//	$list_config[] = array('title'=>'Sửa bảng','field'=>'table_name', 'type'=>'text','arr_params'=>array('function'=> 'edit_table'));

	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
//	$list_config[] = array('title'=>'Sửa','field'=>'table_name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30,'function'=> 'view_edit_table'));
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
