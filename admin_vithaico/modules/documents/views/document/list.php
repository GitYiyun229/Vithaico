<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách Catalogue') );
	//$toolbar->addButton('duplicate',FSText :: _('Duplicate'),'','duplicate.png');
	//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	//$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
    //$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1;
	$fitler_config['filter_count'] = 0;

	$array_email = array(
            1 => FSText::_('PDF'),
            2 => FSText::_('PPT'),
            3 => FSText::_('XLS'),
            4 => FSText::_('WORD'),
	);
	$filter_email = array();
	$filter_email['title'] = FSText::_('Loại file');
	$filter_email['list'] = @$array_email;
	$filter_email['field'] = 'name';
	
	$fitler_config['filter'][] = $filter_email;																																																																																																																																																																																																																																																																																																																																																																																																																
    
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên tài liệu','field'=>'name','ordering'=> 1, 'type'=>'text','align'=>'left','col_width' => '15%','arr_params'=>array('size'=> 30));
    //$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>40,'rows'=>8));
    $list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
//	$list_config[] = array('title'=>'Bài học','field'=>'coursename','ordering'=> 1, 'type'=>'text','align'=>'left','col_width' => '30%','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Ngày tạo','field'=>'date_created','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Hiển thị','field'=>'published','ordering'=> 1, 'type'=>'published');
	
	$list_config[] = array('title'=>'Edit','type'=>'edit');
        $list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
		?>
