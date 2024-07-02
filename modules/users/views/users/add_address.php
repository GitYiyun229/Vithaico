<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/users/assets/css/add_address.css'; ?>" />
<h2 class='head_content'>
	Thêm địa chỉ mới
</h2>
<div class="tab_content_inner clearfix">
	<form id="form-add-address" action="<?php echo FSRoute::_("index.php?module=users&task=add_address_save&Itemid=40"); ?>" method="post" name="form-add-address">
		<div class="fieldset_item_row">
		    <div class="form_name">Email</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="email" id="email" value="" />
		    </div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Họ &amp; tên</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="full_name" id="full_name" value="" />
		 	</div>
		 </div>
		 <div class="fieldset_item_row">
		    <div class="form_name">Tỉnh thành</div>
		    <div class="value">
		    	<input class="txtinput" type="text" name="city" id="city" value="" />
		    </div>
		  </div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Giới tính</div>
	   		<div class="value">
		    	<input class="txtinput" type="text" name="gender" id="gender" value="" />
		    </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Số điện thoại</div>
	   		 <div class="value">
	   		 	<input class="txtinput" type="text" name="telephone" id="telephone" value="" />
	   		 </div>
	  	</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Ngày sinh</div>
			<div class="value">
		    	<input class="txtinput" type="text" name="birthday" id="birthday" value="" />
		    </div>
	 	</div>
		<div class="fieldset_item_row">
	  		<div class="form_name">&nbsp;</div>
		  	<div class="value">
		    	<input class="button-submit-add-address submitbt btn " name="submit" type="submit" value="Thêm mới"  />
		    </div>
	  </div>
	</form>
</div>