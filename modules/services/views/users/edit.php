<?php
  global $tmpl;
  $tmpl -> addStylesheet("users_info","modules/users/assets/css");
?>
<script src="<?php echo URL_ROOT.'modules/users/assets/js/users_edit.js'; ?>" type="text/javascript" language="javascript" >
</script>
<form id="form-user-edit" action="<?php echo FSRoute::_("index.php?module=users&task=edit_save&Itemid=40"); ?>" method="post" name="form-user-edit">
	<div width="100%" border="0">
  <h1 class="infor_title">Thông tin cá nhân</h1>

 <div class="tr-001">
    <span class="infor_user">Họ tên</span>
    <input class="infor_input"  type="text" name="full_name" id="full_name" value="<?php echo $data->full_name;?>" />
  </div>

  <div class="tr-001">
    <span class="infor_user">Ngày sinh</span>
    <div id="td-wapper-birthday">
      <input class="infor_input"  type="text" name="birthday" value="<?php echo date("d/m/Y",strtotime($data->birthday) );?>" id="birthday"  />
    	<!-- <input class="infor_input" type="hidden" name="birth_day" value="<?php echo date("d",strtotime($data->birthday) );?>" id = "birth_day"/>
    	<input class="infor_input" type="hidden" name="birth_month" value="<?php echo date("m",strtotime($data->birthday) );?>" id = "birth_month"/>
    	<input class="infor_input" type="hidden" name="birth_year" value="<?php echo date("Y",strtotime($data->birthday) );?>" id = "birth_year"/> -->
    </div>
    
    <!-- <div class="infor_edit">
      <img class="edit-icon" src="<?php echo URL_ROOT.'images/edit-icon.png';?>" alt="Sửa thông tin" /> 
      <a class="edit-user-info" lang="birthday" title="Sửa thông tin">Sửa thông tin</a>
    </div> -->

  </div>
  
  <div class="tr-001">
    <span class="infor_user">Điện thoại</span>
    <input class="infor_input"  type="text" name="mobilephone" id="mobilephone" value="<?php echo $data->mobilephone;?>" />
  </div>

   <div class="tr-001">
    <span class="infor_user">Email</span>
    <input class="infor_input" type="text" name="email" id="email" value="<?php echo $data->email;?>" />
  </div>

  <div class="tr-001">
    <span class="infor_user">Địa chỉ</span>
    <input class="infor_input" type="text" name="address" id="address" value="<?php echo $data->address;?>" />
  </div>

  <div>
  	<div class="button-submit-tr">
    	<input class="button-submit-edit button" name="submit" type="submit" value="Sửa thông tin"  />
      <!-- <input class="button-reset-edit button" name="reset" type="reset" value="Hủy bỏ"   /> -->
    </div>
  </div>
</div>

</form>