<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');

	$this -> dt_form_begin();

	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
//	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/slideshow_large/', @$data->image),'','',FSText::_('(Dùng ảnh JPG ở vị trí này)'));
	TemplateHelper::dt_edit_text(FSText :: _('Url'),'url',@$data -> url,'',255,1,0);
//	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
TemplateHelper::dt_edit_text(FSText:: _('Summary'), 'summary', @$data->summary, '', 650, 450, 1, '', '', 'col-sm-3', 'col-sm-9');

TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
	$this -> dt_form_end(@$data);

?>
		
