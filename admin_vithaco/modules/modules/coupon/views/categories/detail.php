<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png',1); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png',1); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');  
    
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
	
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Danh mục'),'fa-edit',1,'col-md-8',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Tên Danh mục'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,0,$categories,$field_value = 'id', $field_label='treename',$size = 10,0,1);
        TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,1);
    	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        TemplateHelper::dt_edit_text(FSText :: _('icon font awesome'),'icon',@$data -> icon,'','','','','VD: fa-bullhorn');
        TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/original/',@$data->image));
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,5,0);
    $this->dt_form_end_col(); // END: col-1
    	
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
        
		if(!notEmpty('name','Bạn phải nhập tên danh mục'))
			return false;
                
		$('.alert-danger').hide();
		return true;
	}
 
</script>

