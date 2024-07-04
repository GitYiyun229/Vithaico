<?php
    $title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
    global $toolbar;
    $toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
    $toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
    $toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   

	//$this -> dt_form_begin();
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';
            
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Contents'),'fa-edit',1,'col-md-8',1); 
    
    	TemplateHelper::dt_edit_text(FSText :: _('Tên bài viết'),'title',@$data -> title);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        //TemplateHelper::dt_edit_text(FSText :: _('Nguồn tin'),'source',@$data -> source);
        TemplateHelper::dt_edit_image(FSText :: _('Hình ảnh'),'image',URL_ROOT.str_replace('/original/','/small/',@$data->image));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);

    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    	//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    //	TemplateHelper::dt_edit_text(FSText :: _('Tags'),'tags',@$data -> tags,'',100,4);
    
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,4,FSText::_('Quản trị'),'fa-user',1,'col-md-4 fl-right');
        TemplateHelper::dt_text(FSText :: _('Người tạo'),@$data -> author);
        //TemplateHelper::dt_text(FSText :: _('Thời gian tạo'),date('H:i:s d/m/Y',strtotime(@$data -> start_time)));
        TemplateHelper::dt_text(FSText :: _('Người sửa cuối'),@$data -> author_last);
        //TemplateHelper::dt_text(FSText :: _('Thời gian sửa'),date('H:i:s d/m/Y',strtotime(@$data -> end_time)));
    $this->dt_form_end_col(); // END: col-4        
    
    $this -> dt_form_begin(1,4,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0,'','','','col-sm-4','col-sm-8');
    $this->dt_form_end_col(); // END: col-2
    
    //$this -> dt_form_begin(1,2,FSText::_('Tags'),'fa-tag',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _(''),'tags',@$data -> tags,'',100,4,'',0,'','','col-sm-12');
//    $this->dt_form_end_col(); // END: col-2
    
    //$this -> dt_form_begin(1,2,FSText::_('Cấu hình seo'),'',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _('SEO title'),'seo_title',@$data -> seo_title,'',100,1,0,'','','col-md-12','col-md-12');
//		TemplateHelper::dt_edit_text(FSText :: _('SEO meta keyword'),'seo_keyword',@$data -> seo_keyword,'',100,1,0,'','','col-md-12','col-md-12');
//		TemplateHelper::dt_edit_text(FSText :: _('SEO meta description'),'seo_description',@$data -> seo_description,'',100,7,0,'','','col-md-12','col-md-12');
//    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,4,FSText::_('Content'),'fa-user',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4

    $this -> dt_form_end(@$data,0,1,2,'Cấu hình seo','',1,'col-sm-12');
	//$this -> dt_form_end(@$data,1,1);

?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
	function formValidator()
	{
	    $('.alert-danger').show();	
        
		if(!notEmpty('title','Bạn phải nhập tiêu đề'))
			return false;
        
        if(!notEmpty('image','Bạn phải nhập hình ảnh minh họa'))
			return false;
            
        if(!notEmpty('category_id','Bạn phải chọn danh mục'))
		   return false;
       
        if (CKEDITOR.instances.content.getData() == '') {
            invalid("content", 'Bạn phải nhập nội dung');
            return false;
        }
             
		$('.alert-danger').hide();
		return true;
	}
   

</script>
