<link rel="stylesheet" type="text/css" media="screen" href="<?php echo URL_ROOT.'modules/users/assets/css/address_book.css'; ?>" />
<script src="<?php echo URL_ROOT.'modules/users/assets/js/address_book.js'; ?>" type="text/javascript" language="javascript" ></script>
<h2 class='head_content'>
	Thiết lập địa chỉ
</h2>
<div class="tab_content_inner clearfix">
	<div class="title_content">Địa chỉ đăng ký</div>
		<div class="fieldset_item_row">
	    	<div class="form_name">Email:</div>
		    <div class="value">
		    	<?php echo $data->email;?>
		    </div>
		</div>
		<div class="fieldset_item_row">
	    	 <div class="form_name">Họ  và tên:</div>
	    	<div class="value">
	    		<?php echo $data->full_name;?>
	    	</div>
		</div>

		<div class="fieldset_item_row">
			 <div class="form_name">Tỉnh thành:</div>
			<div class="value">
				<?php echo $data->city;?>
			</div>
		</div>
		<div class="fieldset_item_row">
			 <div class="form_name">Giới tính</div>
			<div class="value">
				<?php echo $data->gender;?>
			</div>
		</div>
		<div class="fieldset_item_row">
			 <div class="form_name">Số điện thoại</div>
			<div class="value">
				<?php echo $data->telephone;?>
			</div>
		</div>
		<div class="fieldset_item_row">
			 <div class="form_name">Ngày sinh</div>
			<div class="value">
				<?php echo $data->v_birthday;?>
			</div>
		</div>
		<div class="fieldset_item_row">
			 <div class="form_name">&nbsp;</div>
			<div class="value">
				<a class="button_edit btn" href="javascript: edit()">Chỉnh sửa</a>
			</div>
		</div>
		<?php 
		if(count($address_book)){?>
			<?php foreach ($address_book as $item){ ?>
				<div class="title_content">Địa chỉ khác</div>
				<div class="fieldset_item_row">
			    	<div class="form_name">Email:</div>
				    <div class="value">
				    	<?php echo $item->email;?>
				    </div>
				</div>
				<div class="fieldset_item_row">
			    	 <div class="form_name">Họ  và tên:</div>
			    	<div class="value">
			    		<?php echo $item->full_name;?>
			    	</div>
				</div>
		
				<div class="fieldset_item_row">
					 <div class="form_name">Tỉnh thành:</div>
					<div class="value">
						<?php echo $item->city;?>
					</div>
				</div>
				<div class="fieldset_item_row">
					 <div class="form_name">Giới tính</div>
					<div class="value">
						<?php echo $item->gender;?>
					</div>
				</div>
				<div class="fieldset_item_row">
					 <div class="form_name">Số điện thoại</div>
					<div class="value">
						<?php echo $item->telephone;?>
					</div>
				</div>
				<div class="fieldset_item_row">
					 <div class="form_name">Ngày sinh</div>
					<div class="value">
						<?php echo $item->v_birthday;?>
					</div>
				</div>
				<div class="fieldset_item_row">
					 <div class="form_name">&nbsp;</div>
					<div class="value">
						<a class="button_address_other" href="javascript: edit_add_other(<?php echo $item->id;?>)"><font color="#1B99E9">[Chỉnh sửa]</font></a>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

	<a class="button_add_address btn" href="javascript: add_address()">Thêm địa chỉ mới</a>
</div>
