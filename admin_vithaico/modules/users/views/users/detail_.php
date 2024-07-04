<!-- HEAD -->
<?php
$title = @$data ? FSText :: _('Edit') : FSText :: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText :: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText :: _('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText :: _('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('user'));

TemplateHelper::dt_edit_text(FSText :: _('Username'), 'username', @$data->username, '', 10);
//TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image),'120');
TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'), 'full_name', @$data->full_name);
TemplateHelper::dt_edit_text(FSText :: _('Email'), 'email', @$data->email);
TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'), 'phone', @$data->phone);
TemplateHelper::dt_edit_text(FSText :: _('Address'), 'address', @$data->address);
//TemplateHelper::dt_edit_text(FSText :: _('Country'),'country',@$data -> country);
//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);

TemplateHelper::dt_checkbox(@$data->id ? FSText::_('Sửa password') : FSText::_('Password'), 'edit_pass', @$data->id ? 0 : 1, 0);
?>
<div class="form-group password_area " style="<?php echo @$data->id ? 'display: none;' : '' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Password") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="password1" id="password" />
=======
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('user')); 
     
    TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'),'username',@$data -> username,'',50);
    //TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
    //TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image),'120');
    TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'),'full_name',@$data -> full_name,'',50);
    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email,'',50);
    TemplateHelper::dt_edit_text(FSText :: _('Điện thoại'),'phone',@$data -> phone);
    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address,'',50);
    //TemplateHelper::dt_edit_text(FSText :: _('Country'),'country',@$data -> country);
    //TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    
    TemplateHelper::dt_checkbox(@$data -> id? FSText::_('Sửa password'):FSText::_('Password'),'edit_pass',@$data -> id? 0:1,0);
    ?>
    <div class="form-group password_area " style="<?php echo @$data -> id? 'display: none;':'' ?>">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Password")?></label>
    	<div class="col-sm-6 col-xs-12">
    		<input class="form-control" type="password" name="password1" id="password" maxlength="50" />
    	</div>
>>>>>>> .r27590
    </div>
<<<<<<< .mine
</div>
<div class="form-group password_area" style="<?php echo @$data->id ? 'display: none;' : '' ?>">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Re-Password") ?></label>
    <div class="col-sm-6 col-xs-12">
        <input class="form-control" type="password" name="re-password1" id="re-password" />
=======
    <div class="form-group password_area" style="<?php echo @$data -> id? 'display: none;':'' ?>">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Re-Password")?></label>
    	<div class="col-sm-6 col-xs-12">
    		<input class="form-control" type="password" name="re-password1" id="re-password" maxlength="50" />
    	</div>
>>>>>>> .r27590
    </div>
</div>
<?php
TemplateHelper::dt_edit_text(FSText :: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
$this->dt_form_end(@$data, 1, 0);
?>
<!-- END HEAD-->
<script type="text/javascript">
<<<<<<< .mine
    function formValidator()
    {
        $('.alert-danger').show();
        var check_pass = $("input[name='edit_pass']:checked").val();

        if (!notEmpty('username', 'Nhập username'))
            return false;

        if (!notEmpty('full_name', 'Nhập họ và tên'))
            return false;

        if (!notEmpty("email", "Hãy nhập email")) {
            return false;
        }

        if (!emailValidator('email', 'Email không hợp lệ,yêu cầu nhập đúng định dạng'))
            return false;

=======
    $(document).ready( function(){
        check_exist_username();
    	check_exist_email();
    });
    
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
	function formValidator()
	{
	    $('.alert-danger').show();	
	    var check_pass = $("input[name='edit_pass']:checked").val();
        
		if(!notEmpty('username','Bạn cần nhập Tên đăng nhập'))
			return false;
            
        if (!lengthMin("username", 5, 'Tên đăng nhập phải từ 5 ký tự trở lên')) {
            return false;
        }    
        
        if(!notEmpty('full_name','Nhập họ và tên'))
			return false;
   
        if(!notEmpty("email","Hãy nhập email")){
    		return false;
    	}
        
		if(!emailValidator('email','Email không hợp lệ,yêu cầu nhập đúng định dạng'))
			return false;
        
>>>>>>> .r27590
        if (!notEmpty("phone", "Bạn chưa nhập số điện thoại"))
            return false;

        if (!isPhone("phone", "Số điện thoại không hợp lệ"))
            return false;

        if (!lengthMin("phone", 9, '"Số điện thoại" phải 9 số trở lên, vui lòng sửa lại!')) {
            return false;
        }
<<<<<<< .mine

        if (check_pass && check_pass > 0) {
            if (!notEmpty("password", "Bạn chưa nhập password"))
            {
                return false;
            }

            if (!lengthMin("password", 6, '"Password" phải 6 kí tự trở lên, vui lòng sửa lại!'))
            {
                return false;
            }

            if (!checkMatchPass_2("password", "re-password", "Password bạn nhập không khớp"))
            {
                return false;
            }
=======
        
        if (!lengthMax("phone", 12, 'Số điện thoại không hợp lệ')) {
            return false;
        }
        
        if(check_pass > 0 ){
            
            if(!notEmpty("password","Bạn chưa nhập password"))
        	{
        		return false;
        	}
                    
            if(!lengthMin("password",8,'Mật khẩu gồm 8 ký tự, có ký tự hoa, thường và số'))
        	{
        		return false;
        	}
            
            if(!uppercase('password','Mật khẩu gồm 8 ký tự, có ký tự hoa, thường và số')){
                return false;
            }
            
             if(!number_pass('password','Mật khẩu gồm 8 ký tự, có ký tự hoa, thường và số')){
                return false;
            }
                        
        	if(!checkMatchPass_2("password","re-password","Password bạn nhập không khớp"))
        	{
        		return false;
        	}
>>>>>>> .r27590
        }

        $('.alert-danger').hide();
        return true;
    }

    $('#edit_pass_0').click(function () {
        $('.password_area').hide();
    });
    $('#edit_pass_1').click(function () {
        $('.password_area').show();
    });
    
    
    
    
    /* CHECK EXIST username  */
    function check_exist_username(){
    	$('#username').blur(function(){
    	    var id = $('#id').val()? $('#id').val():0;
    		if($(this).val() != ''){
    			$.ajax({url:"index.php?module=users&view=users&task=ajax_check_exist_username&raw=1",
    				data: {username: $(this).val(),id:id},
    				dataType : "text",
    				success: function(result) {
    					  if(result == 0){
                            document.getElementById('msg_error').innerHTML = 'Tên đăng nhập này đã tồn tại. Ban hãy sử dụng tên đăng nhập khác';
                            $('#msg_error').parent().show();
                            $('#username').focus(); // set the focus to this input                     
    					  }                                        
    				  }
    			});
    		}
    	});
    }
    /* CHECK EXIST EMAIL  */
    function check_exist_email(){
    	$('#email').blur(function(){
    	    var id = $('#id').val()? $('#id').val():0;
    		if($(this).val() != ''){
    			if(!notEmpty("email","Email không hợp lệ,yêu cầu nhập đúng định dạng"))
    				return false;
                    
    			$.ajax({url:"index.php?module=users&view=users&task=ajax_check_exist_email&raw=1",
    				data: {email: $(this).val(),id:id},
    				dataType : "text",
    				success: function(result) {
    					  if(result == 0){
                            document.getElementById('msg_error').innerHTML = 'Email này đã tồn tại. Ban hãy sử dụng email khác';
                            $('#msg_error').parent().show();
                            $('#email').focus(); // set the focus to this input                     
    					  }                                        
    				  }
    			});
    		}
    	});
    }
    
    jQuery(function($){
        $('#username').keyup(function(e){
            var characterReg = /^\s*[a-zA-Z0-9,\s]+\s*$/;
            var str = $(this).val();
            if(!characterReg.test(str)) {
                invalid("username",'Yêu cầu không dấu');
                str = removeDiacritics(str);
                $(this).val(str); 
            }
            if (e.which === 32) {
                //alert('No space are allowed in usernames');
                invalid("username",'Yêu cầu viết liền không dấu');
                str = str.replace(/\s/g,'');
                $(this).val(str);            
            }
            var characterReg2 = /^([a-zA-Z0-9]{5,255})$/;
            if(!characterReg2.test(str)) {
                invalid("username",'Tên đăng nhập từ 5 ký tự trở lên');
                str = removeDiacritics(str);
                str = str.replace(/\s/g,'');
                $(this).val(str); 
            }
        }).blur(function() {
            var str = $(this).val();
            str = removeDiacritics(str);
            str = str.replace(/\s/g,'');
            $(this).val(str);            
        });
    });
    
    
    
    function removeDiacritics(input)
    {
        var output = "";
    
        var normalized = input.normalize("NFD");
        var i=0;
        var j=0;
    
        while (i<input.length)
        {
            output += normalized[j];
    
            j += (input[i] == normalized[j]) ? 1 : 2;
            i++;
        }
    
        return output;    
    }
</script>

