<?php
$arr_unitDiscount = array(
    '1' => 'VND',
    '2' => '%',
);

$this->dt_form_begin(1, 2, FSText::_('Thông tin chung'), '', 1, 'col-md-12 fl-left');

TemplateHelper::dt_edit_text(FSText::_('Title'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
// TemplateHelper::dt_edit_text(FSText::_('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"), '', 'col-md-2', 'col-md-10');
TemplateHelper::datetimepicke(FSText::_('Ngày bắt đầu'), 'date_start', @$data->date_start ? @$data->date_start : '', FSText::_('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-4');
TemplateHelper::datetimepicke(FSText::_('Ngày kết thúc'), 'date_end', @$data->date_end ? @$data->date_end : '', FSText::_('Bạn vui lòng chọn thời gian kết thúc'), 20, '', 'col-md-2', 'col-md-4');
// TemplateHelper::dt_edit_image(FSText::_('Icon'), 'image', str_replace('/original/', '/original/', URL_ROOT . @$data->image), '', '', '', 'col-md-2 right', 'col-md-10');
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
// TemplateHelper::dt_edit_text(FSText::_('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20', 1, 0, '', '', 'col-md-2', 'col-md-10');
 
// TemplateHelper::dt_edit_text(FSText::_('Nội dung'), 'content', @$data->content, '', 650, 450, 1, '', '', 'col-xs-12 left mt10', 'col-xs-12', '', 1);
 
$this->dt_form_end_col(); // END: col-1

?>