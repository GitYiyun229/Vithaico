<?php
global $toolbar;

$toolbar->setTitle(FSText::_('Categories'));
$toolbar->addButton('duplicate', FSText::_('Duplicate'), FSText::_('You must select at least one record'), 'duplicate.png');
$toolbar->addButton('save_all', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('add', FSText::_('Add'), '', 'add.png');
$toolbar->addButton('edit', FSText::_('Edit'), FSText::_('You must select at least one record'), 'edit.png');
$toolbar->addButton('remove', FSText::_('Remove'), FSText::_('You must select at least one record'), 'remove.png');
$toolbar->addButton('published', FSText::_('Published'), FSText::_('You must select at least one record'), 'published.png');
$toolbar->addButton('unpublished', FSText::_('Unpublished'), FSText::_('You must select at least one record'), 'unpublished.png');
// $toolbar->addButton('home',FSText :: _('Home'),FSText :: _('You must select at least one record'),'published.png');
// $toolbar->addButton('unhome',FSText :: _('Unhome'),FSText :: _('You must select at least one record'),'unpublished.png');	
//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1;

//	CONFIG	
$list_config = array();
$list_config[] = array('title' => 'Name', 'field' => 'treename', 'ordering' => 1, 'type' => 'text', 'col_width' => '30%', 'align' => 'left', 'arr_params' => array('have_link_edit' => 1));
// $list_config[] = array('title'=>'Bảng TSKT','field'=>'tablename','ordering'=> 1, 'type'=>'text','col_width' => '10%','align'=>'left','arr_params'=>array('function'=> 'link_edit_tablename'));
// $list_config[] = array('title'=>'Tính lại bộ lọc','field'=>'','ordering'=> 0, 'type'=>'text','col_width' => '20%','arr_params'=>array('function'=> 'view_genarate_filter'));
$list_config[] = array('title' => 'Bảng TSKT', 'field' => 'tablename', 'tablename' => 1, 'type' => 'table_name', 'col_width' => '10%', 'align' => 'left');

$list_config[] = array('title' => 'Ordering', 'field' => 'ordering', 'ordering' => 1, 'type' => 'edit_text', 'arr_params' => array('size' => 3));
$list_config[] = array('title' => 'Published', 'field' => 'published', 'ordering' => 1, 'type' => 'published');
$list_config[] = array('title' => 'Hiển thị trang chủ', 'field' => 'show_in_homepage', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'show_in_homepage'));
// $list_config[] = array('title' => 'Thu cũ', 'field' => 'is_autumn', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'autumn'));
// $list_config[] = array('title' => 'Đổi mới', 'field' => 'is_renew', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'renew'));
// $list_config[] = array('title'=>'Import','field'=>'id','type'=>'text','arr_params'=>array('function'=>'link_import'));
// $list_config[] = array('title'=>'Đăng sản phẩm','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'home'));
$list_config[] = array('title' => 'Edit', 'type' => 'edit');
$list_config[] = array('title' => 'Created time', 'field' => 'created_time', 'ordering' => 1, 'type' => 'datetime');
$list_config[] = array('title' => 'Id', 'field' => 'id', 'ordering' => 1, 'type' => 'text');

TemplateHelper::genarate_form_liting($this->module, $this->view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination);
