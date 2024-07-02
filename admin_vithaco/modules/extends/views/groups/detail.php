<!-- HEAD -->
	<?php 
	$field_type_arr = array(
		'varchar' => 'Chuỗi ký tự',
		// 'int' => 'Kiểu số',
		// 'datetime' => 'Thời gian',
		'text' => 'Textarea',
		'foreign_one' => 'Chọn một',
		'foreign_multi' => 'Chọn nhiều'
	);

	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('save_add',FSText::_('Save & New'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Nhóm thông số/ Phân loại'), 'field_group', @$data->field_group, 0, $field_group, $field_value = 'id', $field_label = 'treename', $size = 10, 0, 1,'','','','col-md-3','col-md-5');
	TemplateHelper::dt_edit_selectbox(FSText::_('Kiểu dữ liệu'), 'field_type', @$data->field_type, '', $field_type_arr, '', '', $size = 10, 0, 1,'','','','col-md-3','col-md-5');

	// TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image));
	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	
	$this -> dt_form_end(@$data,1,0);
	
	?>