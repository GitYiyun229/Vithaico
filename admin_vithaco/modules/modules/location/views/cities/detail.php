<!-- HEAD -->
<?php

	$title = @$data ? FSText::_('Edit'): FSText::_('Add');
	global $toolbar;
	$toolbar->setTitle($title);
    //$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png',1);
	$toolbar->addButton('save',FSText::_('Save'),'','save.png',1);
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Tỉnh/TP'),'fa-edit',1,'col-md-12',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    	//TemplateHelper::dt_edit_selectbox(FSText::_('Vùng miền'),'area_id',@$data -> area_id,0,$areas,$field_value = 'id', $field_label='name',$size = 10,0,1);
    	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,14,0);
    $this->dt_form_end_col(); // END: col-1

//	TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',@$data -> icon);

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
        
		if(!notEmpty('title','Bạn phải nhập tên Tỉnh/TP'))
			return false;

		$('.alert-danger').hide();
		return true;
	}
   

</script>
