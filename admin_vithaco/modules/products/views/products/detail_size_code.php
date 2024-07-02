<?php $max_ordering = 1; ?>
	<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
		<thead>
			<tr>
				<th align="center" >
					Tên màu
				</th>
				<th align="center" >
					Mã màu
				</th>
				<th align="center"  width="15" >
					Remove
				</th>
			</tr>
		</thead>
		<tbody>
		<?php
			$i = 0; 
			if(isset($color) && !empty($color)){
				foreach ($color as $item) { 
		?>
			<tr>
				<td>
					<input type="hidden" value="<?php echo $item -> id; ?>" name="id_exist_<?php echo $i;?>">
					
					<input type="text" size="20" value="<?php echo $item -> name;?>" name="color_name_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> name; ?>" name="color_name_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input id="colorpickerField2" type="text" size="20" value="<?php echo $item -> code; ?>" name="color_code_exist_<?php echo $i;?>">
					<input type="hidden" value="<?php echo $item -> code; ?>" name="color_code_exist_<?php echo $i;?>_original">
				</td>
				<td>
					<input type="checkbox" onclick="remove_color(this.checked);" value="<?php echo $item->id; ?>"  name="other_color[]" id="other_color<?php echo $i; ?>" />
				</td>
			</tr>
				<?php
					$i++; 
				}
			}
			?>
		<?php for($i = 0; $i < 20; $i ++ ) { ?>
			<tr id='new_record_<?php echo $i?>' class='new_record closed'>
				 <td>
					 <input type="text" size="20" id="new_color_name_<?php echo $i;?>" name="new_color_name_<?php echo $i;?>">
				 </td>
				 <td>
					 <input id="colorpickerField2" type="text" size="20" id="new_color_code_<?php echo $i;?>" name="new_color_code_<?php echo $i;?>">
				 </td>
				<td>
					<input type="checkbox" onclick="remove_color(this.checked);" value="<?php echo $item->id; ?>"  name="other_color[]" id="other_color<?php echo $i; ?>" />
				</td>
			</tr>
	<?php } ?>
	</tbody>		
	</table>
	<div class='add_record'>
		<a href="javascript:add_color()"><strong class='red'>Thêm màu sản phẩm</strong></a>
	</div>
	<input type="hidden" value="<?php echo isset($color)?count($color):0; ?>" name="color_exist_total" id="color_exist_total" />
	
<script type="text/javascript" >
function remove_color(isitchecked){
	if (isitchecked == true){
		document.adminForm.othercolor_remove.value++;
	}
	else {
		document.adminForm.othercolor_remove.value--;
	}
}
function add_color(){
	for(var i = 0; i < 20; i ++){
		tr_current = $('#new_record_'+i);
		if(tr_current.hasClass('closed')){
			tr_current.addClass('opened').removeClass('closed');
			return;
		}
	}
}
$(function() {
	$('#colorpickerField1, #colorpickerField2, #colorpickerField3').ColorPicker({
		onSubmit: function(hsb, hex, rgb, el) {
			$(el).val(hex);
			$(el).ColorPickerHide();
		},
		onBeforeShow: function () {
			$(this).ColorPickerSetColor(this.value);
		}
	})
	.bind('keyup', function(){
		$(this).ColorPickerSetColor(this.value);
	});
});
</script>
<style>
.closed{
	display:none;
}
</style>