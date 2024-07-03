<?php
global $toolbar;
$toolbar->setTitle(FSText :: _('Nhà sản xuất') );
$toolbar->addButton('add',FSText :: _('Add'),'','add.png');
$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png');
$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');

//	FILTER
$array_status = array(
    2=>FSText::_('Tạm dừng'),
    1=>FSText::_('Kích hoạt')

);

$filter_status = array();
$filter_status['title'] = FSText::_('Trạng thái');
$filter_status['list'] = @$array_status;

$filter_config  = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 0;
$fitler_config['filter'][] = $filter_status;

//	CONFIG
$list_config = array();
$list_config[] = array('title'=>'Tên','field'=>'name','ordering'=> 1, 'type'=>'text');
// $list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('width'=> 60,'search'=>'/original/','replace'=>'/resized/'));
$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
//	$list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
$list_config[] = array('title'=>'Edit','type'=>'edit');
$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');

TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
?>
