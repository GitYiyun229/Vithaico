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
	
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Tag'),'fa-edit',1,'col-md-7',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Tên'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    	TemplateHelper::dt_checkbox(FSText::_('Hot'),'is_hot',@$data -> is_hot,0);
    $this->dt_form_end_col(); // END: col-1
    $this -> dt_form_end(@$data,1,1,2,FSText::_('Cấu hình Seo'),'',1,'col-md-5');
	
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

