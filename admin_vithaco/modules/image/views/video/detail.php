<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Videos'),'fa-edit',1,'col-md-8',1);
        TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_file('Video','video',@$data->video,'.mp4');
    	TemplateHelper::dt_edit_text(FSText :: _('Hoặc link youtube'),'link_video',@$data -> link_video,'',60,1,0);
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering);
        //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,5);
    $this->dt_form_end_col(); // END: col-1
	
    
    $this -> dt_form_begin(1,2,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('show home'),'show_in_homepage',@$data -> show_in_homepage,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('Video nổi bật'),'is_hot',@$data -> is_hot,1,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Show trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0,'','','','col-sm-4','col-sm-8');
        
    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,2,FSText::_('Ảnh'),'fa-image',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/resized/',URL_ROOT.@$data->image),'','',FSText::_('Chỉ dành cho video mp4,video youtube đã có ảnh mặc định'));
    $this->dt_form_end_col(); // END: col-2
    
    
    $this -> dt_form_begin(1,2,FSText::_('Summary'),'fa-info',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',650,450,1,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi ti?t'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col();  //END: col-4
    //$this -> dt_form_begin(1,4,FSText::_('Vị trí'),'fa-globe',1,'col-md-8');
    //    include  'detail_images.php';
    //$this->dt_form_end_col(); // END: col-4
    
    //$this -> dt_form_begin(1,2,FSText::_('Ảnh'),'fa-globe',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _('Top'),'top',@$data -> top);
//        TemplateHelper::dt_edit_text(FSText :: _('Left'),'pos_left',@$data -> pos_left);
//    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>