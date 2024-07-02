<!-- HEAD -->
<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Vùng miền'),'fa-edit',1,'col-md-12',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,14,0);
    $this->dt_form_end_col(); // END: col-1
 
//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);
	
	$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
	
?>