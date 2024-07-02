<div class="extend-new">
<?php
$foreign_data = $this->model->get_records('published = 1','fs_extends_groups');
$data_extends = unserialize(@$data->data_extends);
// foreach ($extend_fields_new as $item){
//     switch ($item->field_type){
//         case 'select':
//             $sub_item ='';
//             TemplateHelper::dt_edit_selectbox($item->field_name, $item->id.'_extend', @$data_extends[$item->id]['value'],0, @$item->select_option,'id', 'name', $size = 1,0,1,'',$sub_item);
//             break;
//         case 'multi_select':
//             $sub_item ='';
//             TemplateHelper::dt_edit_selectbox($item->field_name, $item->id.'_extend', @$data_extends[$item->id]['value'],0, @$item->select_option,'id', 'name', $size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item', $sub_item);
//             break;
//         case 'yesno':
//             TemplateHelper::dt_checkbox($item->field_name, $item->id.'_extend', @$data_extends[$item->id]['value'], $default = 0, $array_value = array(1 => 'Có', 0 => 'Không'), $sub_item = '');
//             break;
//         default:
//             TemplateHelper::dt_edit_text($item->field_name, $item->id.'_extend', @$data_extends[$item->id]['value']);
//             break;
//     }
// }
foreach ($extend_fields_new as $item){
    switch ($item->field_type){
        case 'foreign_one':
            $sub_item ='';
            TemplateHelper::dt_edit_selectbox("$item->field_name_display <span data-toggle='modal' data-target='#addExtendDetail' data-id='".$item->foreign_id."' class='add-btn'><i class='fa fa-lg fa-plus-square'></i></span>", $item->id.'_extend', @$data_extends[$item->id]['value'],0, @$item->select_option,'id', 'name', $size = 1,0,1,'',$sub_item);
            break;
        case 'foreign_multi':
            $sub_item ='';
            TemplateHelper::dt_edit_selectbox("$item->field_name_display <span data-toggle='modal' data-target='#addExtendDetail' data-id='".$item->foreign_id."' class='add-btn'><i class='fa fa-lg fa-plus-square'></i></span>", $item->id.'_extend', @$data_extends[$item->id]['value'],0, @$item->select_option,'id', 'name', $size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item', $sub_item);
            break;
        case 'yesno':
            TemplateHelper::dt_checkbox($item->field_name_display, $item->id.'_extend', @$data_extends[$item->id]['value'], $default = 0, $array_value = array(1 => 'Có', 0 => 'Không'), $sub_item = '');
            break;
        default:
            TemplateHelper::dt_edit_text("$item->field_name_display <span data-toggle='modal' data-target='#addExtendDetail' data-id='".$item->foreign_id."' class='add-btn'><i class='fa fa-lg fa-plus-square'></i></span>", $item->id.'_extend', @$data_extends[$item->id]['value']);
            break;
    }
} 
?>
</div>

<style>
    .extend-new .control-label{
        display: flex;
        align-items: center;
        justify-content: right;
        grid-gap: 15px;
    }
    .extend-new .control-label .add-btn{
        cursor: pointer;
        transition: 0.1s ease-in-out;
    }
    .extend-new .control-label .add-btn:hover{
        color: #FF6700;
    }
    .btnSaveDetail{
        text-decoration: none;
        color: #fff;
    }
    #addExtendDetail .select2 .select2-selection{
        height: 34px;
        line-height: 34px;
    }
    #addExtendDetail .select2 .select2-selection .select2-selection__rendered{
        line-height: 34px;
    }
    #addExtendDetail .modal-dialog{
        width: 1000px;
    }
    #append{
		position: absolute;
		width: 100%;
		height: 100%;
		background: rgba(255,255,255,0.7);
		top: 0;
		left: 0;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>
<script>
    function addFieldModal(id,id_group = null){
		if(id === 3){
			let html = `
			<tr>
				<td><input type="text" name="new_name[]" class="form-control" placeholder="Tên"></td>
				<td><input type="text" name="new_alias[]" class="form-control" placeholder="Tên hiệu (Có thể sinh tự động)"></td>
				<td>
					<select name="new_group[]" class="select2-box">
						<?php foreach ($foreign_data as $item){ ?>
							<option ${id_group == <?php echo $item->id ?> ? 'selected' : ''} value="<?php echo $item->id; ?>" ><?php echo $item->name ?></option>
						<?php }?>
					</select>
				</td>
				<td><input type="text" name="new_order[]" class="form-control" placeholder="Thứ tự" value="0"></td>
				<script>$(document).ready(function(){$('.select2-box').select2();})<\/script>
			</tr>
			`;
			let total_new = $('#total_new').val();
			total_new = parseInt(total_new);
			total_new ++;
			$('#total_new').val(total_new)
			$('#addExtendDetail .table tbody').append(html);
		}
	}
    $(document).on('click','.add-btn',function(){
		let id = $(this).attr('data-id');
		let tablename = $('#addExtendDetail').attr('data-table');
		$.ajax({
            type: 'GET',
            dataType: 'html',
            url: 'index2.php?module=products&view=tables&task=ajax_get_detail_field&raw=1',
            data: {id:id,tablename:tablename},
            success: function (data) {
				$('#list_detail').html(data);
            }
        });
	});

	$(document).on('click','.btnSaveDetail',function(){
		let data_form = $('#list_detail').serialize();
		$('#addExtendDetail .modal-body').append('<div id="append">Loading...</div>')
		$.ajax({
			type: 'POST',
			dataType: 'html',
			url: 'index2.php?module=products&view=tables&raw=1&task=ajax_save_detail_field',
			data: data_form,
			success: function(data) {
				setTimeout(function(){
					$('#append').remove();
				},1000)
				$('#list_detail').html(data);
			}
		});
	})
</script>