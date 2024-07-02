$(document).ready( function(){
//	check_exist_email();
	/****** Expert ******/
	$('.register-submit').click(function(){
		if(checkFormsubmit())
			document.register_form.submit();
	})
	$('.signin-submit').click(function(){
		if(checkFormsubmit())
			document.login_form.submit();
	});
	$('.sbm_otp').click(function(){
		if(checkFormsubmit_otp())
			document.otp_form.submit();
	});
});
     
function checkFormsubmit()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();
    if(!notEmpty("telephone","Bạn chưa nhập số điện thoại"))
    {
        return false;
    }
    if (!isPhone("telephone", "Số điện thoại không hợp lệ")) {
        return false;
    }
	if(!notEmpty("email","Hãy nhập email")){
		return false;
	}
	if(!emailValidator("email","Email nhập không hợp lệ")){
		return false;
	}

	return true;
}
function checkFormsubmit_login()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("username","Bạn chưa nhập tài khoản")){
		return false;
	}
	if(!emailValidator("username","Email nhập không hợp lệ")){
		return false;
	}
	if(!notEmpty("password","Bạn chưa nhập password"))
	{
		return false;
	}
	return true;
}
function checkFormsubmit()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();
    if(!notEmpty("telephone","Bạn chưa nhập số điện thoại"))
    {
        return false;
    }
    if (!isPhone("telephone", "Số điện thoại không hợp lệ")) {
        return false;
    }
	if(!notEmpty("email","Hãy nhập email")){
		return false;
	}
	if(!emailValidator("email","Email nhập không hợp lệ")){
		return false;
	}

	return true;
}
function checkFormsubmit_otp()
{

	$('label.label_error').prev().remove();
	$('label.label_error').remove();

	if(!notEmpty("otp","Bạn chưa nhập otp")){
		return false;
	}
	return true;
}

/* CHECK EXIST EMAIL  */
function check_exist_email(){
	$('#email').blur(function(){
		if($(this).val() != ''){
			if(!emailValidator("email","Email không đúng định dạng"))
				return false;
			$.ajax({url: root+"index.php?module=users&task=ajax_check_exist_email&raw=1",
				 data: {email: $(this).val()},
				  dataType: "text",
				  success: function(result) {
						$('label.email_check').prev().remove();
						$('label.email_check').remove();
					  if(result == 0){
						  invalid('email','Email này đã tồn tại. Bạn hãy sử dụng email khác');
					  } else {
						  valid('email');
						  $('<br/><div class=\'label_success username_check\'>'+'Email này được chấp nhận'+'</div>').insertAfter($('#email').parent().children(':last'));
					  }
				  }
			});
		}
	});
}