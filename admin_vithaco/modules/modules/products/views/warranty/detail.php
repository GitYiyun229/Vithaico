<?php
?>
<!-- HEAD -->
<?php

$title = @$data ? FSText:: _('Sửa bảo hành') : FSText:: _('Sửa bảo hành');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText:: _('Save and new'), '', 'save_add.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin();
TemplateHelper::dt_edit_text(FSText:: _('Name'), 'name', @$data->name);
//TemplateHelper::dt_edit_text(FSText:: _('Price'), 'price', @$data->price);
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
TemplateHelper::dt_edit_image(FSText:: _('Image'), 'image', str_replace('/original/', '/resized/', URL_ROOT . @$data->image));
TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm'), 'categories', @$data->categories, 0, $categories, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3', 'col-md-9');
TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm'), 'products', @$data->products, 0, $products_add, $field_value = 'id', $field_label = 'name', $size = 1, 1, '', '', '', '', 'col-md-3', 'col-md-9');
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
//TemplateHelper::dt_edit_text(FSText:: _('Tóm tắt'), 'code', @$data->code);
//TemplateHelper::dt_edit_text(FSText:: _('Mô tả'), 'content', @$data->content, '', 650, 450, 1);
TemplateHelper::dt_edit_text(FSText::_('Mô tả'), 'content', @$data->content, '', 500, 6, 1, '', '', 'col-md-3', 'col-md-9','',1);

require_once('detail_warraty.php');

$this->dt_form_end(@$data);
?>
<!-- END HEAD-->
