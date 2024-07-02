$(document).ready( function(){
	$("select#province").change(function(){
		$.getJSON("index.php?module=users&task=district&raw=1",{cid: $(this).val()}, function(j){
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
			}
			
			$("#district").html(options);
			$('#district option:first').attr('selected', 'selected');
		})
	});
	
	/* REGISTER FORM */
	$('#submitbt').click(function(){
		if(checkFormsubmit())
			document.register_form.submit();
	})
	$('#use_estore').click(function(){
		if($(this).is(':checked'))
			$('#estore_register').show();
		else 
			$('#estore_register').hide();
	});
//	
//	// Famous in right column 
//	$(".famous_item_head").click(function () {
//		famous_body = $(this).next();
//		famous_body.slideToggle(600);
//		
//		tag_parent = $(this).parent();
//		if(tag_parent.hasClass('famous_openned'))
//			tag_parent.removeClass('famous_openned').addClass('famous_closed');
//		else 
//			tag_parent.removeClass('famous_closed').addClass('famous_openned');
//	})

});
     
function checkFormsubmit()
{
	
	$('label.label_error').prev().remove();
	$('label.label_error').remove();
	if(!notEmpty("username","Bạn phải nhập username"))
		return false;
	if(!isUsername("username","Username chỉ gồm: chữ, số, kí tự '-' và '_'"))
		return false;
	if(!lengthMin("password",6,"Mật khẩu phải từ 6 kí tự trở lên"))
		return false;
	if(!checkMatchPass("Mật khẩu nhập lại không khớp"))
		return false;	
	if(!notEmpty("full_name","Nhập họ và tên đệm"))
		return false;	

	if(!notEmpty("email","Nhập email"))
		return false;	
	
	if(!emailValidator("email","Email không đúng định dạng"))
		return false;	
	if(!checkMatchEmail("Email không khớp"))
		return false;
	
	if(!notEmpty("mobilephone","Nhập số điện thoại di động"))
		return false;
	if(!isPhone("mobilephone","Số điện thoại di động chưa đúng"))
		return false;	
//	if(!notEmpty("telephone","Nhập số điện thoại cố định"))
//		return false;
//	if(!isPhone("telephone","Nhập số điện thoại cố định"))
//		return false;	
	if(!notEmpty("txtCaptcha","Bạn phải nhập mã hiển thị"))
		return false;
	
//	if($('#use_estore').is(':checked') == true){
//		if(!notEmpty("cpn_name","Nhập tên công ty"))
//			return false;
//		if(!notEmpty("cpn_telephone","Nhập điện thoại cố định của công ty"))
//			return false;
//		if(!isPhone("cpn_telephone","Số cố định không đúng định dạng"))
//			return false;
//	}
//	if(!madeCheckbox("read_term","Bạn chưa đồng ý với các điều kiện đăng kí thành viên"))
//		return false;
	
	return true;
}
click_edit_user_info(1);
function click_edit_user_info(){
	$('.edit-user-info').click(function(){
		var id=$(this).attr('lang');
		$('.button-submit-tr').css({'display':'block'});
		if(id == 'birthday'){
			birth_day = $('#birth_day').val();
			birth_month = $('#birth_month').val();
			birth_year = $('#birth_year').val();
			$.get('index.php?module=users&task=views_select_birthday&raw=1&birth_day='+birth_day+'&birth_month='+birth_month+'&birth_year='+birth_year,function(response){
				$('#td-wapper-birthday').html(response);
//				alert(response);
			});
			
		}else{
			$('#'+id).removeAttr('disabled').css({'border':'1px solid #7f9db9','background-color':'#fff'});
		}
		
	});
	$('.button-reset-edit').click(function(){
		location.reload();
	});
}