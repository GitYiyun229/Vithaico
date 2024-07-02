<?php
$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add', FSText :: _('Save and new'), '', 'save_add.png', 1);
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png', 1);
$toolbar->addButton('back', FSText :: _('Cancel'), '', 'cancel.png'); 

	$this -> dt_form_begin();
	
	TemplateHelper::dt_edit_text(FSText :: _('Tên'),'title',@$data -> title);
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
	TemplateHelper::dt_edit_text(FSText :: _('Link'),'url',@$data -> url);	
	TemplateHelper::dt_edit_text(FSText :: _('Giới hạn trang'),'limit',@$data -> limit,0);	
        TemplateHelper::dt_edit_selectbox(FSText::_('Categories'), 'category_id', @$data->category_id, 0, $categories, $field_value = 'id', $field_label = 'treename', $size = 10, 0, 1);
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
//	TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.str_replace('/original/','/resized/',@$data->image));
	TemplateHelper::dt_edit_text(FSText :: _('Mô tả'),'summary',@$data -> summary,'',100,9);
	$this -> dt_form_end(@$data,1,0);

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
        
		if(!notEmpty('title','Bạn phải nhập tên'))
			return false;
                
		$('.alert-danger').hide();
		return true;
	}
   

</script>
