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
	TemplateHelper::dt_checkbox(FSText::_('Search programs'),'search_programs',@$data -> search_programs,0);
    TemplateHelper::dt_checkbox(FSText::_('Review programs'),'review_programs',@$data -> review_programs,0);
    TemplateHelper::dt_edit_text(FSText:: _('Post Programs'),'post_programs',@$data -> post_programs);
    TemplateHelper::dt_edit_text(FSText:: _('Prices'),'prices',@$data -> prices);
    TemplateHelper::dt_edit_text(FSText:: _('Per Posting'),'per_posting',@$data -> per_posting);
    TemplateHelper::jscolorpicker(FSText:: _('Color level'),'color_level',@$data -> color_level);
    TemplateHelper::dt_edit_text(FSText:: _('Level'),'level',@$data -> level);
    TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Description'),'description',@$data -> description,'',650,450,1);
    
	$this -> dt_form_end(@$data,1,0);
?>
