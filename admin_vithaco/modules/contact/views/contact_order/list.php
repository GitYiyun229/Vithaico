<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Liên hệ') );
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Họ tên','field'=>'name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Thương hiệu','field'=>'trademark','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Điện thoại','field'=>'phone','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text');
	
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
