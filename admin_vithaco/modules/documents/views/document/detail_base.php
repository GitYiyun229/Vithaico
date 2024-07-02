<?php
TemplateHelper::dt_edit_text(FSText :: _('Tên tài liệu'),'name',@$data -> name);
TemplateHelper::dt_edit_text(FSText :: _('Số hiệu'),'code',@$data -> code);
    //TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Cơ quan ban hành'),'department_id',@$data -> department_id,0,$department,$field_value = 'id', $field_label='name',$size = 10,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Người ký'),'position_id',@$data -> position_id,0,$position,$field_value = 'id', $field_label='name',$size = 10,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Lĩnh vực'),'field_id',@$data -> field_id,0,$field,$field_value = 'id', $field_label='name',$size = 10,0);
    TemplateHelper::dt_edit_selectbox(FSText::_('Loại văn bản'),'type_id',@$data -> type_id,0,$type,$field_value = 'id', $field_label='name',$size = 10,0);
    TemplateHelper::dt_edit_text(FSText :: _('Đơn vị soạn thảo'),'unit',@$data ->unit );
    TemplateHelper::dt_edit_text(FSText :: _('Độ khẩn'),'urgency',@$data ->urgency );
    TemplateHelper::dt_edit_text(FSText :: _('Độ mật'),'confidentiality',@$data ->confidentiality );
    //TemplateHelper::dt_edit_selectbox(FSText::_('Tài liệu của thành viên'),'user_id',@$data -> user_id,0,$memmber,$field_value = 'id', $field_label='full_name',$size = 10,0,1);
    //TemplateHelper::dt_edit_selectbox(FSText::_('Nơi xuất hiện'),'courseid',@$data -> courseid,0,$menus_items_all,$field_value = 'item', $field_label='treename',$size = 2,1);
    TemplateHelper::dt_edit_image(FSText::_('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
    TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'description',@$data -> description,'',100,5,0);
    TemplateHelper::dt_date_pick ( FSText :: _('Ngày ban hành' ), 'date_created', @$data->date_created?@$data->date_created:date('Y-m-d'), FSText :: _('Bạn vui lòng chọn thời gian ban hành'), 20);
    //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//    TemplateHelper::dt_checkbox(FSText::_('Lựa chọn'),'is_view',@$data -> is_view,0,array(0=>FSText::_('Xem'),1=>FSText::_('Download') ));
//    TemplateHelper::dt_edit_file(FSText :: _('File tài liệu'),'urlfile',@$data->urlfile, 'Upload File (Word, Excel, PPT, BDF)');
	//TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>