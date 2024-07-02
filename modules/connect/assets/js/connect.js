function validContact(){
    if(!notEmpty('contact_name','Hãy nhập họ và tên.')){
        return false;
    }
    if(!notEmpty('contact_address','Hãy nhập địa chỉ.')){
        return false;
    }
    if(!notEmptyTextarea('message','Hãy nhập nội dung.')){
        return false;
    }
    if(!notEmpty('txtCaptcha','Hãy nhập Mã bảo mật.')){
        return false;
    }
    document.forms['frm_contact'].submit();
}