<!-- HEAD -->
	<?php 
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Manufactor'),'',1,'col-md-8',1);

    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
    	//TemplateHelper::dt_checkbox(FSText::_('Video'),'style',@$data -> style,0);
				TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/small/',URL_ROOT.@$data->icon));

        TemplateHelper::dt_edit_image(FSText :: _('Icon hover'),'avatar',str_replace('/original/','/small/',URL_ROOT.@$data->avatar));
        TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
				TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,6);
				// TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');

        //TemplateHelper::dt_edit_text(FSText :: _('Mô tả dưới'),'summary_small',@$data -> summary_small,'',100,6);
	$this->dt_form_end_col(); // END: col-1
    $this -> dt_form_end(@$data,1,1,2,FSText::_('Cấu hình Seo'),'',1,'col-md-4');
?>
