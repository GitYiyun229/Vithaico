function checkFormsubmit()
{
//	email_new = $('#email_new').val();
//	if(email_new.length ){
//		re_email_new = $('#re_email_new').val();
//		if(!emailValidator("email_new", "Bạn nhập không đúng định dạng email")){
//			return false;
//		}
//		if(email_new != re_email_new){
//			$('#msg_error').html('Email không khớp');
//			return false;
//		}
//	}
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("text_pass_old","Bạn phải nhập mật khẩu cũ"))
	{
		return false;
	}
	if(!notEmpty("text_pass_new","Bạn phải nhập mật khẩu mới"))
	{
		return false;
	}
//	  if(!lengthMin('text_pass_new','6','Bạn phải nhập lại ít nhất 6 kí tự'))
//	  {
//	  	return false;
//	  }
//	  if(checkMatchPass_2("text_pass_new","text_re_pass_new","Mật khẩu mới không khớp"))
//	  {
//		  return false;
//	  }
	return true;
}