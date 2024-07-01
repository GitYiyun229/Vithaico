<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin();
	
    if(@$data->avatar && @$data->type){ 
        $link_avatar = @$data->avatar;
    }else { 
        $link_avatar = URL_ROOT.@$data->avatar;
    }
    
	TemplateHelper::dt_edit_text(FSText :: _('Username'),'username',@$data -> username);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    TemplateHelper::dt_edit_image(FSText :: _('Avatar'),'avatar',$link_avatar);

    TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'),'full_name',@$data -> full_name);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
    TemplateHelper::dt_edit_text(FSText :: _('Đại chỉ'),'address',@$data -> address);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    ?>
    <tr>
	   <td class="label1 label key"><span><?php echo FSText::_('Sửa password')?></span></td>
    	<td class="value1">
    		<input type="radio" name="edit_pass" id="edit_pass1" class='edit_pass' value="1" /> Yes
    		<input type="radio" name="edit_pass" id="edit_pass0" class='edit_pass'  value="0" checked="checked"/> No
    	</td>
    </tr>
    <tr class='password_area'>
    	<td class='label1 label key'><font>*</font><?php echo FSText::_("Password")?></td>
    	<td class='value1'>
    		<input type="password" name="password1" id="password" />
    	</td>
    </tr>
    <tr class='password_area'>
    	<td class='label1 label key'><font>*</font><?php echo FSText::_("Re-Password")?></td>
    	<td class='value1'>
    		<input type="password" name="re-password1" id="re-password" />
    	</td>
    </tr>
    <?php
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

	$this -> dt_form_end(@$data,1,0);
	
?>

<script  type="text/javascript" language="javascript">
$(function(){
	//$("select#city_id").change(function(){
//	$.ajax({url: "index.php?module=members&task=district&raw=1",
//			data: {cid: $(this).val()},
//			dataType: "text",
//			
//			success: function(text) {
//				alert(text);
//				if(text == '')
//					return;
//				j = eval("(" + text + ")");
//				
//				var options = '';
//				for (var i = 0; i < j.length; i++) {
//					options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
//				}
//				$('#district_id').html(options);
//				elemnent_fisrt = $('#district_id option:first').val();
//			}
//		});
//	});
	$('.password_area').hide();
	$('#edit_pass0').click(function(){
		$('.password_area').hide();
	});
	$('#edit_pass1').click(function(){
		$('.password_area').show();
	});
			
})
</script>
