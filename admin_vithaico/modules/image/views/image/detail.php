<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Thư viện ảnh'),'fa-edit',1,'col-md-8',1);
        //$category_id = isset($data -> category_id)?$data -> category_id:$cid;
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',40,1,0,FSText::_("You must enter alias "));
    
    	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
    
    	//TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',$category_id,0,$relate_categories,$field_value = 'id', $field_label='treename',$size = 1,0);
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('show home'),'show_in_homepage',@$data -> show_in_homepage,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-6');
    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,2,FSText::_('Summary'),'fa-info',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',100,9,0,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi tiết'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,2,FSText::_('Ảnh'),'fa-image',1,'col-md-8');
        TemplateHelper::dt_edit_image2(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),'','','',1);
    $this->dt_form_end_col(); // END: col-3
    
//
//    $this -> dt_form_begin(1,2,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
//		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
//		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,9,0,'','','col-md-12','col-md-12');
//    $this->dt_form_end_col(); // END: col-4

    
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>
