<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/users/assets/css/add_address.css'; ?>" />
<h2 class='head_content'>
	Sửa địa chỉ
</h2>
<div class="tab_content_inner clearfix">
	<form id="form-add-address" action="<?php echo FSRoute::_("index.php?module=users&task=edit_address_save&Itemid=40"); ?>" method="post" name="form-add-address">
		<div class="fieldset_item_row">
		    <div class="form_name">Email</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="email" id="email" value="<?php echo $address->email?>" />
		    </div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Họ &amp; tên</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="full_name" id="full_name" value="<?php echo $address->full_name?>" />
		 	</div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Tỉnh thành</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="city" id="city" value="<?php echo $address->city?>" />
		    </div>
		  </div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Giới tính</div>
	   		<div class="value">
		    	<input class="txtinput" type="text" name="gender" id="gender" value="<?php echo $address->gender?>" />
		    </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Số điện thoại</div>
	   		 <div class="value">
	   		 	<input class="txtinput" type="text" name="telephone" id="telephone" value="<?php echo $address->gender?>" />
	   		 </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Ngày sinh</div>
			<div class="value">
		    	<input class="txtinput" type="text" name="birthday" id="birthday" value="<?php echo $address->v_birthday?>" />
		    </div>
	 	</div>
		<div class="fieldset_item_row">
	  		<div class="form_name">&nbsp;</div>
		  	<div class="value">
		    	<input class="button-submit-add-address submitbt btn " name="submit" type="submit" value="Thêm mới"  />
		    </div>
	  </div>
	  <input type="hidden" name="id" value="<?php echo $address->id?>">
	</form>
</div>