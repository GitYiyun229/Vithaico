<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   

	// 	add para table_name into form
	$this -> add_params_form('table_name',$table_name);
	
	$this -> dt_form_begin();
	foreach($fields  as $field){
		$fieldname  = $field -> field_name;
    	$field_display  = $field -> field_name_display;
    	$fieldtype  = $field -> field_type;
    	if($fieldname == 'alias'){
    		TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0," ".FSText::_("Can auto generate"));
    		continue;
    	}
    	if($fieldname == 'ordering'){
    		TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    		continue;
    	}
    	if($fieldname == 'published'){
    		TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    		continue;
    	}
    	if($fieldname == 'created_time'){
    		continue;
    	}
    	if($fieldname == 'edited_time'){
    		continue;
    	}
    	
		if($fieldname == 'seo_title'){
    		continue;
    	}
    	if($fieldname == 'seo_keyword'){
    		continue;
   	 	}
		if($fieldname == 'seo_description'){
    		continue;
    	}
    	switch ($fieldtype){
    		case "text": 
    			TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    			break;
    		default: 
    			TemplateHelper::dt_edit_text($field_display,$fieldname,@$data -> $fieldname);
    			break;
    	}
	}
	$this -> dt_form_end(@$data,1,1);

?>
		
