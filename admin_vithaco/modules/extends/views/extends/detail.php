<?php
$title = @$data ? FSText :: _('Sửa trường mở rộng'): FSText :: _('Thêm mới trường mở rộng'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
//	TemplateHelper::dt_edit_selectbox(FSText::_('Tên bảng mở rộng'),'table_name',@$data -> table_name,0,$tables,$field_value = 'table_name', $field_label='table_name',$size = 10,0);
	
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	$this -> dt_form_end(@$data);

?>
<style>
#table_name{
	width: 334px;
}
</style>
		
