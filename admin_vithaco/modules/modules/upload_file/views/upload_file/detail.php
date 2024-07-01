<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	//$this -> dt_form_begin();
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Tài liệu'),'fa-edit',1,'col-md-12',1);
	
	TemplateHelper::dt_edit_text(FSText :: _('Name'),'filename',@$data -> filename);
    //TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    //TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
    //TemplateHelper::dt_edit_selectbox(FSText::_('Tài liệu của thành viên'),'user_id',@$data -> user_id,0,$memmber,$field_value = 'id', $field_label='full_name',$size = 10,0,1);
	TemplateHelper::dt_edit_file(FSText :: _('File tài liệu'),'file_upload',@$data->file_upload);
    TemplateHelper::datetimepicke ( FSText :: _('Thời gian upload' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-2','col-md-4');
    //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    
	$this -> dt_form_end(@$data);

?>
