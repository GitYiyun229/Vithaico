<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Edit'): FSText::_('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
	$toolbar->addButton('save',FSText::_('Save'),'','save.png');
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');   
	
	$this -> dt_form_begin(1,4,$title.' '.FSText::_('Thành viên'));
	
    if(@$data->avatar){
        $avatar = strpos(@$data->avatar, 'http' ) === false? URL_ROOT.str_replace('/original/', '/original/', @$data->avatar):@$data->avatar;
    }else{
    	$avatar = URL_ROOT.'images/1473944223_unknown2.png';
   }
 //   if(@$data->avatar && @$data->type){ 
//        $link_avatar = @$data->avatar;
//    }else { 
//        $link_avatar = URL_ROOT.@$data->avatar;
//    }
    
	TemplateHelper::dt_edit_text(FSText :: _('Username'),'username',@$data -> username);
	//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
     TemplateHelper::dt_edit_image(FSText :: _('Avatar'),'image',$avatar,'90');
    TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'),'name',@$data -> name);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
    TemplateHelper::dt_edit_text(FSText :: _('SĐT'),'email',@$data -> telephone);

    TemplateHelper::dt_checkbox(FSText::_('Giới tính'),'sex',@$data -> sex,'',$array_value = array(1 => 'Nam', 0 => 'Nữ'));

//    TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'address',@$data -> content);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    TemplateHelper::dt_checkbox(FSText::_('Sửa password'),'edit_pass','',0);
    
    ?>
    <div class="form-group password_area">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Password")?></label>
    	<div class="col-sm-9 col-xs-12">
    		<input class="form-control" type="password" name="password1" id="password" />
    	</div>
    </div>
    <div class="form-group password_area">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Re-Password")?></label>
    	<div class="col-sm-9 col-xs-12">
    		<input class="form-control" type="password" name="re-password1" id="re-password" />
    	</div>
    </div>
    <?php
    // TemplateHelper::dt_edit_text(FSText :: _('Thông tin'),'other_info',@$data -> other_info,'',650,450,1);
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
	$('#edit_pass_0').click(function(){
		$('.password_area').hide();
	});
	$('#edit_pass_1').click(function(){
		$('.password_area').show();
	});
			
})
</script>
