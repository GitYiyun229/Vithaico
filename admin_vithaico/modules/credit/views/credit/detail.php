<?php
$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');
$array_method = array(
    1 => 'Qua điện thoại',
    2 => 'Online',
    3 => 'Tại cửa hàng'
);
$profile = [
    1 => 'CMND + Hộ Khẩu',
    2 => 'CMND/CCCD',
    3 => 'CMND + Bằng lái xe / hộ khẩu',
    4 => 'CMND + Hộ Khẩu + Hóa đơn điện',
    5 => 'CMND + Hộ Khẩu + Hóa đơn điện',
    6 => 'CMND + Bằng lái /Hộ khẩu + Hóa đơn điện',
    7 => 'CMND + Bằng lái xe'
];
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'back.png');

$this->dt_form_begin();

TemplateHelper::dt_edit_text(FSText:: _('Title'), 'title', @$data->title);
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
TemplateHelper::dt_edit_image(FSText:: _('Image'), 'image', str_replace('/original/', '/original/', URL_ROOT . @$data->image));
TemplateHelper::dt_edit_text(FSText:: _('Phí thu hộ theo tháng'), 'price', @$data->price, '', 100, 1);
TemplateHelper::dt_edit_selectbox(FSText::_('Hồ sơ yêu cầu'), 'profile', @$data->profile, 0, @$profile, $field_value = 'id', $field_label = 'title', $size = 1, 0, 1, '', '', '', 'col-md-3 right', 'col-md-9');
TemplateHelper::dt_edit_selectbox(FSText::_('Hình thức duyệt hồ sơ'), 'method', @$data->method, 0, @$array_method, $field_value = 'id', $field_label = 'title', $size = 1, 0, 1, '', '', '', 'col-md-3 right', 'col-md-9');
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
//	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
include_once 'detail_month.php';

$this->dt_form_end(@$data, 1, 0);

?>
	