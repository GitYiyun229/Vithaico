<table cellspacing="1" class="admintable">
<?php 
	TemplateHelper::dt_edit_text(FSText :: _('Tên đối tác'),'name',@$data -> name);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'hotline',$data->hotline);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',$data->email);
    TemplateHelper::dt_edit_text(FSText :: _('Đại chỉ'),'address',@$data -> address);
    
    TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Thành phố'),'city_id',$city_id,0,$cities,$field_value = 'id', $field_label='name',$size = 1,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Quận/huyện'),'district_id',$district_id,0,$district,$field_value = 'id', $field_label='name',$size = 1,0);
    //TemplateHelper::dt_edit_image(FSText :: _('Email'),'email',$data->email);
    
    TemplateHelper::dt_edit_text(FSText :: _('Người liên hệ'),'name_contact',@$data -> name_contact);
    
    TemplateHelper::dt_edit_selectbox(FSText::_('Nhóm dự án'),'group_id',$group_id,0,$group,$field_value = 'id', $field_label='name',$size = 1,0);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>
</table>