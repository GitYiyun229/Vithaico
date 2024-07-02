<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');   
	
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
	//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'));
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('News'),'fa-edit',1,'col-md-8',1);
        TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề'),'title',@$data -> title);
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        // TemplateHelper::dt_edit_image(FSText :: _('Hình ảnh'),'image',str_replace('/original/','/small/',URL_ROOT.@$data->image));
        TemplateHelper::dt_edit_selectbox(FSText::_('Categories'),'category_id',@$data -> category_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
        TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-4');
    //TemplateHelper::dt_edit_text(FSText :: _('Link video'),'video',@$data -> video,'',100,1,0,'','','col-sm-3','col-sm-9');
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Quản trị'),'fa-user',1,'col-md-4 fl-right');
        TemplateHelper::dt_text(FSText :: _('Người tạo'),@$data -> author);
        //TemplateHelper::dt_text(FSText :: _('Thời gian tạo'),date('H:i:s d/m/Y',strtotime(@$data -> start_time)));
        TemplateHelper::dt_text(FSText :: _('Người sửa cuối'),@$data -> author_last);
        //TemplateHelper::dt_text(FSText :: _('Thời gian sửa'),date('H:i:s d/m/Y',strtotime(@$data -> end_time)));
    $this->dt_form_end_col(); // END: col-4
        
    $this -> dt_form_begin(1,2,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        // TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin nổi bật'),'is_hot',@$data -> is_hot,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin ở slideshow'),'is_slide',@$data -> is_slide,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin dưới slideshow'),'is_new_video',@$data -> is_new_video,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin video'),'is_video',@$data -> is_video,0,'','','','col-sm-4','col-sm-8');
        //TemplateHelper::dt_checkbox(FSText::_('Tin mới'),'is_new',@$data -> is_new,0,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-8');
    $this->dt_form_end_col(); // END: col-2
    
 
    $this -> dt_form_begin(1,4,FSText::_('Content'),'fa-info',1,'col-md-8');
        TemplateHelper::dt_edit_text(FSText :: _(''),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4

    // $this -> dt_form_begin(1,2,FSText::_('Summary'),'fa-info',1,'col-md-4');
        //TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',100,5,0,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi tiết'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    //$this->dt_form_end_col(); // END: col-4
    //$this->dt_form_begin(1, 2, FSText::_('Tags'), 'fa-tag', 1, 'col-md-4 fl-right');
        //TemplateHelper::dt_edit_selectbox(FSText::_('Tags'),'tag_alias',@$data -> tag_alias,0,$tag,$field_value = 'alias', $field_label='name',$size = 30,1);
    //$this->dt_form_end_col(); // END: col-2

    //$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo');
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
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
            
//        if(!notEmpty('image','bạn phải nhập hình ảnh'))
//			return false;
            
        // if(!notEmpty('category_id','Bạn phải chọn danh mục'))
		 //   return false;
               
        // if(!notEmpty('summary','Bạn phải nhập nội dung mô tả'))
		//    return false;
        
        if (CKEDITOR.instances.content.getData() == '') {
            invalid("content", 'Bạn phải nhập nội dung chi tiết');
            return false;
        }
            
		$('.alert-danger').hide();
		return true;
	}
   

</script>
<?php //include 'detail_seo.php'; ?>
