	<?php TemplateHelper::dt_edit_text(FSText::_('Danh mục'), 'category_id', @$data->category_name, '', 255, 1, 0, 'Kích thước lấy theo danh mục sản phẩm', '', 'col-md-3', 'col-md-9', 1);
	?>
	<div class="dataTable_wrapper">
		<table id="table-sizes" border="0" class="tbl_form_contents table table-hover table-striped table-bordered" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
			<thead>
				<tr>
					<th width="25%" align="center">
						<?php echo FSText::_('Size'); ?>
					</th>
					<th width="25%" align="center">
						<?php echo FSText::_('Chọn ảnh'); ?>
					</th>
					<th width="25%" align="center">
						<?php echo FSText::_('Hiển thị'); ?>
					</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if (isset($sizes) && !empty($sizes)) {
					foreach ($sizes as $item) {
						@$data_by_size = $array_data_by_size[$item->id];
				?>
						<?php if (@$data_by_size) { ?>
							<tr>
								<td>
									<?php echo $item->name; ?><br />
								</td>
								<td>
									<?php $link_img = str_replace('/original', '/small/', @$data_by_size->image); ?>
									<img style="margin-top: 10px" onerror="this.src='/images/not_picture.png'" class="sizes-picture img-responsive image-box box-image-<?php echo $item->id ?>" alt="" src="<?php echo URL_ROOT . $link_img; ?>" /><br />
									<div class="fileUpload btn btn-primary ">
										<span><i class="fa fa-cloud-upload"></i> Chọn ảnh</span>
										<input data-id="<?php echo $item->id ?>" data-class="box-image-<?php echo $item->id ?>" class="upload upload select-file" type="file" name="image_exit_size_<?php echo $item->id; ?>" />
										<!-- <input data-id="<?php echo $item->id ?>" data-class="size-box-image-<?php echo $item->id ?>" class="upload select-file" type="file" id="other_image_<?php echo $item->id; ?>" name="other_image_<?php echo $item->id; ?>" data-id=<?php echo $item->id; ?> /> -->
									</div>
									<input type="hidden" value="<?php echo @$data_by_size->id; ?>" name="id_exist_<?php echo $item->id; ?>">
									<input type="hidden" value="<?php echo $item->id; ?>" name="size_exist_total[]" />
									<input type="hidden" id="name_image_exit_<?php echo $item->id; ?>" name="name_price_size_exist_<?php echo $item->id; ?>" value="<?php echo @$data_by_size->image; ?>">
								</td>
								<td>
									<input type="checkbox" value="<?php echo $item->id; ?>" name="other_size_exit[]" id="other_size_exit<?php echo $item->id; ?>" checked />
								</td>
							</tr>
						<?php } else { ?>
							<tr>
								<td>
									<?php echo $item->name; ?><br />
								</td>
								<td>
									<!-- <?php $link_img = str_replace('/original', '/small/', @$item->image); ?> -->
									<img style="margin-top: 10px" onerror="this.src='/images/not_picture.png'" class="sizes-picture img-responsive image-box size-box-image-<?php echo $item->id ?>" alt="" src="<?php echo URL_ROOT . $item->image; ?>" /><br />
									<div class="fileUpload btn btn-primary ">
										<span><i class="fa fa-cloud-upload"></i> Chọn ảnh</span>
										<input data-id="<?php echo $item->id ?>" data-class="size-box-image-<?php echo $item->id ?>" class="upload select-file" type="file" id="other_image_<?php echo $item->id; ?>" name="other_image_<?php echo $item->id; ?>" data-id=<?php echo $item->id; ?> />
									</div>
								</td>
								<td>
									<input class="select-checkbox" id="<?php echo "other_size" . $item->id ?>" type="checkbox" value="<?php echo $item->id; ?>" name="other_size[]" id="other_size<?php echo $item->id; ?>" />
								</td>
							</tr>
						<?php } ?>
				<?php }
				} ?>
			</tbody>
		</table>
	</div>

	<span data-id="<?php echo FSInput::get("id") ?>" class="btn add-more-sizes btn-primary" style="margin-top: 10px">
		Thêm kích thước
		<i class="fa fa-plus-square" aria-hidden="true"></i>
	</span>
	<style>
		input[type=checkbox] {
			transform: scale(1.5);
		}
		.sizes-picture{
			height: 60px !important;
		}
	</style>
	<script>
		$(document).ready(function() {

			// let arr_checkbox = $(".select-checkbox").attr("disabled", true)
			let selected_checkbox
			$(".select-file").change(function(e) {
				let fileId = $(this).attr('data-id');
				let id = $(this).attr('data-id');
				if ($(`#other_image_${fileId}`).val()) {
					// $(`#other_size${id}`).attr("disabled", false);
					$(`#other_size${id}`).attr("checked", true);
				} else {
					// $(`#other_size${id}`).attr("disabled", true);
				}
			})
		})
		$(".add-more-sizes").click(function() {
			let row =
				`
        <tr>
            <td style="width: 100%; height: 175px; display: flex; justify-content: center; align-items: center">
                <input style="border-radius: 5px; width: 50%; margin-right: 20px;" type="text" class="form-control name-color-${order}" placeholder="Tên size" name="name_size" aria-label="Username" aria-describedby="basic-addon1">
            </td>
            <td>
                <img style="margin-top: 10px" onerror="this.src='/images/not_picture.png'" class="color-picture box-image-${order} img-responsive image-box" alt="" src="" /><br />
                <div class="fileUpload btn btn-primary ">
                    <span><i class="fa fa-cloud-upload"></i> Chọn ảnh</span>
                    <input data-class="box-image-${order}" class="upload select-file-${order}" type="file" />
                </div>
            </td>
            <td style="width: 100%; height: 175px; display: flex; justify-content: center; align-items: center"><a data-order="${order}" class="save-size"><img src="templates/default/images/toolbar/save.png"></a></td>
        </tr>
    	`
			$('#table-sizes tr:last').after(row);
			++order;
		})
		let category_id = <?php echo @$data->category_id ?>;
		$(document).on('click', '.save-size', function() {

			let order = $(this).attr("data-order");
			let file_data = $(".select-file-" + order).prop('files')[0];
			let form_data = new FormData();
			form_data.append('file', file_data);
			form_data.append('name_size', $(".name-color-" + order).val());
			form_data.append('record_id', record_id);
			form_data.append('category_id', category_id);
			$.ajax({
				method: 'POST',
				processData: false,
				contentType: false,
				url: "/admin_hcbc/index.php?module=products&view=products&task=save_sizes&raw=1",
				data: form_data,
				success: function(result) {
					alert(result);
				}
			})
		})
	</script>