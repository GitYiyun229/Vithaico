<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách trang tĩnh') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 

	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Categories'); 
	$filter_categories['list'] = @$categories; 
	$filter_categories['field'] = 'treename'; 
	
	$fitler_config['filter'][] = $filter_categories;																																																																																																																																																																																																																																																																																																																																																																																																																						

	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tên bài viết','field'=>'title','ordering'=> 1,'align'=>'left', 'type'=>'text_link','col_width' => '25%','link'=>'index.php?module=contents&view=content&code=code&id=id&Itemid=8','arr_params'=>array('size'=> 30));
	//$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/small/','width'=>'90'));
	//$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
    //$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
	$list_config[] = array('title'=>'Category','field'=>'category_name','ordering'=> 1, 'type'=>'text');
    //$list_config[] = array('title'=>'Hiển thị trang chủ','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_home'));
    //$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Hoạt động','field'=>'published','ordering'=> 1, 'type'=>'published');
    
//    $list_config[] = array('title'=>'Người đăng','field'=>'author','ordering'=> 1, 'type'=>'text');
//    $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
//    $list_config[] = array('title'=>'Người sửa','field'=>'author_last','ordering'=> 1, 'type'=>'text');
//    $list_config[] = array('title'=>'Ngày sửa','field'=>'updated_time','ordering'=> 1, 'type'=>'datetime');
    
	$list_config[] = array('title'=>'Edit','type'=>'edit');
//	$list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
	//$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
	TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
