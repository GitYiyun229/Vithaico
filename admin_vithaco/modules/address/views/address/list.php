<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Address') );
//	$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1;
    $fitler_config['filter_count'] = 2;

    $fitler_city  = array();
    $fitler_city['title'] = FSText::_('Cities');
    $fitler_city['list'] = @$cities;
    $fitler_city['field'] = 'name';

    $fitler_district  = array();
    $fitler_district['title'] = FSText::_('District');
    $fitler_district['list'] = @$district;
    $fitler_district['field'] = 'name';

    // $fitler_atm  = array();
    // $fitler_atm['title'] = FSText::_('Lọc theo PGD hoặc ATM');
    // $fitler_atm['list'] = @$is_atm;
    // $fitler_atm['field'] = '1';

    $fitler_config['filter'][] = $fitler_city;
    $fitler_config['filter'][] = $fitler_district;
    // $fitler_config['filter'][] = $fitler_atm;
	
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '25%','arr_params'=>array('size'=> 30));
	//$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','no_col'=>1,'arr_params'=>array('search'=>'/original/','replace'=>'/small/'));
	//$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
//	$list_config[] = array('title'=>'Bitrix ID','field'=>'bitrix_id','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    // $list_config[] = array('title'=>'ATM','field'=>'is_atm','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_atm'));
	$list_config[] = array('title'=>'Edit','type'=>'edit');
//	$list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>