<link type="text/css" rel="stylesheet" media="all" href="../ddtm_admin/templates/default/css/select2.min.css"/>
<script type="text/javascript" src="../ddtm_admin/templates/default/js/select2.min.js"></script>

<?php 
	
	$title = isset($data)?"S&#7917;a b&#7843;ng":"Tạo mới bảng"; 
	global $toolbar;
	$toolbar->setTitle($title);
	if(isset($data)){
	//		$toolbar->addButton('filter',FSText::_("B&#7897; l&#7885;c"),'','filter-export.png');
		$toolbar->addButton('apply_edit',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
		$toolbar->addButton('save_edit',FSText::_('L&#432;u'),'','save.png'); 
		$tablename = FSInput::get('tablename');
	} else {
		$toolbar->addButton('apply_new',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
		$toolbar->addButton('save_new',FSText::_('L&#432;u'),'','save.png'); 
	}
	$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png');
	$max_ordering = 0;
?>

<style>
	.checkbox-cusor{
		cursor: pointer;
		height: 20px;
		width: 20px;
	}
	table .select2{
		width: 100% !important;
	}
	.select2-container--default .select2-selection--single{
		height: 34px;
		border: 1px solid #ccc;
		-webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
		box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%);
		-webkit-transition: border-color ease-in-out .15s,-webkit-box-shadow ease-in-out .15s;
		-o-transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
		transition: border-color ease-in-out .15s,box-shadow ease-in-out .15s;
	}
	.select2-container--default .select2-selection--single .select2-selection__rendered{
		line-height: 34px;
	}
	.select2-container--default.select2-container--open .select2-selection--single{
		border-color: #66afe9;
		outline: 0;
		-webkit-box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
		box-shadow: inset 0 1px 1px rgb(0 0 0 / 8%), 0 0 8px rgb(102 175 233 / 60%);
	}
	.table>thead>tr{
		background: #f9f9f9;
	}
	.table>thead>tr>th, .table>thead>tr>td{
		border: none;
	}
	.table td:nth-child(5) .select2-container--default .select2-selection--single .select2-selection__rendered{
		width: 180px;
	}
	.table td:nth-child(4) .select2-container--default .select2-selection--single .select2-selection__rendered{
		width: 200px;
	}
	#addExtendGroup .modal-dialog{
		width: 1000px;
	}
	#addExtendDetail .modal-dialog{
		width: 1000px;
	}
	.flex-container{
		display: flex;
		align-items: center;
		grid-gap: 10px;
	}
	.flex-container .item{
		width: 100%;
	}
	.flex-container .item-btn{
		width: 15px;
	}
	.flex-container .item-btn .btn-detail{
		display: none;
	}
	.flex-container .item-btn .btn-detail.active{
		display: block;
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
<div class="panel panel-default">
	<div class="panel-body">	
		<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend>Tạo field cho bảng</legend>
				<div id="tabs" class="col-md-6">
					<table>
						<tr>
							<td>Tên bảng: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
							<td>
							<?php if(isset($data)){ ?> 	
								<?php if(strpos($tablename, 'fs_'.$this->type.'_') !== false){$tablename = str_replace('fs_'.$this->type.'_','',$tablename);}?>
								<input class="form-control" type="text" name = "table_name"  value = "<?php echo $tablename; ?>" />
								<input type="hidden" name = "table_name_begin"  value = "<?php echo $tablename; ?>" />
							<?php } else { ?>
								<input type="text" name = "table_name"  />
							<?php } ?>
							</td>
						</tr>
					</table>
				</div>
			</fieldset>
			<fieldset>
				<legend>Tạo field cho bảng</legend>	
				<div id="tabs" class="form-contents table-responsive">
					<table class="table table-hover table-striped table-bordered" class="field_tbl" width="100%" border="1" bordercolor="red">
						<thead>
						<tr>
							<td><b>TT</b></td>
							<td><b>Tên hiển thị</b></td>
							<!-- <td><b>Kiểu dữ liệu</b></td> -->
							<td>
								<b>Danh sách thông số, phân loại</b>
								<a style="color:#FF6600" href="" data-toggle="modal" data-target="#addExtendGroup">
									<i data-toggle="tooltip" title="Thêm danh sách thông số, phân loại" class="fa-lg fa fa-plus-square-o"></i>
								</a>
							</td>
							<td>
								<b>Nhóm thông số, phân loại</b>
								<a style="color:#FF6600" href="" data-toggle="modal" data-target="#addExtendFieldGroup">
									<i data-toggle="tooltip" title="Thêm nhóm thông số, phân loại" class="fa-lg fa fa-plus-square-o"></i>
								</a>
							</td>
							<td>
								<b data-toggle="tooltip" data-placement="left" title='<img style="height: 200px;width: auto;object-fit: cover;" src="/ddtm_admin/images/chuthich_boloc_hienthi.png" alt="image" />'>Hiển thị</b>
							</td>
							<td><b>Lọc</b></td>
							<td><b>Chỉ Lọc</b></td>
							<td><b>Xóa</b></td>
						</tr>
						</thead>
						
						<tbody>
						<?php $i = 0;?>
						<?php if(isset($data) && count($data)) { 
							$array_default = array('id','productid','categoryid','manufactory','models');
							foreach ($data as $field) { 
								if( !in_array(strtolower($field->field_name),$array_default) ){
									$field_name = $field->field_name;
									$ordering = $field->ordering? $field->ordering: 0;
									$max_ordering = $max_ordering > $ordering ? $max_ordering:$ordering;		
							?>
								<tr id="extend_field_exist_<?php echo $i; ?>"  >
									<td valign="top" class="left_col">
										<input class="form-control" type="text" name='ordering_exist_<?php echo $i;?>' value="<?php echo $ordering; ?>"  class='ordering' size="2"/>
										<input type="hidden" name='ordering_exist_<?php echo $i;?>_begin' value="<?php echo $field->ordering; ?>" />
									</td>
									<td valign="top" class="left_col">
										<input class="form-control" type="text" name='fshow_exist_<?php echo $i;?>' value="<?php echo $field->field_name_display; ?>" />
										<input type="hidden" name='fshow_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_name_display; ?>" />
										<input type="hidden" name='fname_exist_<?php echo $i;?>_begin' value="<?php echo $field_name; ?>" />
										<input type="hidden" name='ftype_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_type; ?>" />

									</td>
									
									<!-- <td class="right_col">
										<select name='ftype_exist_<?php echo $i ?>' class='select2-box' id='ftype_exist_<?php echo $i ?>' onchange="javascript: change_ftype(this);" >
											<option value="varchar" <?php echo $field->field_type == "varchar" ? "selected=\"selected\"":""; ?>>Chuỗi ký tự</option>
											<option value="int" <?php echo $field->field_type == "int" ? "selected=\"selected\"":""; ?>>Kiểu số</option>
											<option value="datetime" <?php echo $field->field_type == "datetime" ? "selected=\"selected\"":""; ?>>Thời gian</option>
											<option value="text" <?php echo $field->field_type == "text" ? "selected=\"selected\"":""; ?>>Textarea</option>
											<option value="foreign_one" <?php echo $field->field_type == "foreign_one" ? "selected=\"selected\"":""; ?>>Chọn một </option>
											<option value="foreign_multi" <?php echo $field->field_type == "foreign_multi" ? "selected=\"selected\"":""; ?>>Chọn nhiều </option>
										</select>
										<input type="hidden" name='ftype_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_type; ?>" />
									</td> -->

									<td class="right_col">
										<div class="flex-container">
											<div class="item">
												<?php $cat_compare = isset($field->foreign_id)?$field->foreign_id:0; ?>
												<select data-btn="btn-detail<?php echo $i ?>" data-change="group_id_exist_<?php echo $i;?>" class="select2-group select2-box" name="foreign_id_exist_<?php echo $i;?>" id='foreign_id_exist_<?php echo $i;?>' >
													<option value="0" >Chọn danh sách thông số, phân loại</option>
													<?php foreach ($foreign_data as $item){
														$checked = "";
														if($cat_compare == $item->id )
															$checked = "selected=\"selected\"";
													?>
														<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
													<?php } ?>
												</select>
												<input type="hidden" name='foreign_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->foreign_id; ?>" />
											</div>
											<div class="item-btn">
												<a class="btn-detail btn-detail<?php echo $i ?> <?php echo $cat_compare != 0 ? 'active' : '' ?>" data-table="<?php echo FSInput::get('tablename') ?>" data-id="<?php echo $cat_compare ?>" style="color:#FF6600" href="" data-toggle="modal" data-target="#addExtendDetail">
													<i data-toggle="tooltip" title="Chi tiết thông số, phân loại" class="fa-lg fa fa-list-alt"></i>
												</a>
											</div>
										</div>	
									</td>

									<td class="right_col">
										<?php $cat_compare = isset($field->group_id)?$field->group_id:0; ?>
										<select class="select2-box selectGroup" name="group_id_exist_<?php echo $i;?>" id="group_id_exist_<?php echo $i ?>" >
											<option value="0" >Chọn nhóm thông số, phân loại</option>
											<?php foreach ($group_field as $item){
												$checked = "";
												if($cat_compare == $item->id )
													$checked = "selected=\"selected\"";
											?>
												<option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name ?></option>
											<?php }?>
										</select>
										<input type="hidden" name='group_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->group_id; ?>" />
									</td>

									<td valign="top" class="left_col">
										<input title="Hiển thị" class="checkbox-cusor" type="checkbox" <?php echo @$field->is_main == 1 ? 'checked' : '' ?> name="is_main_exist_<?php echo $i;?>" id="is_main_exist_<?php echo $i;?>">
										<input type="hidden" name='is_main_<?php echo $i;?>_begin' value="<?php echo @$field->is_main; ?>" />
									</td>

									<td>
										<input title='Lọc' data-select="ftype_exist_<?php echo $i ?>" <?php echo @$field->is_filter == 1 ? 'checked' : '' ?> class="checkbox-cusor check-filter" type="checkbox" name="is_filter_exist_<?php echo $i;?>" id='is_filter_exist_<?php echo $i;?>' />
										<input type="hidden" name='is_filter_<?php echo $i;?>_begin' value="<?php echo @$field->is_filter; ?>" />
									</td>

									<td>
										<input title="Chỉ Lọc" data-select="ftype_exist_<?php echo $i ?>" <?php echo @$field->only_filter == 1 ? 'checked' : '' ?> class="checkbox-cusor check-filter" type="checkbox" name="only_filter_exist_<?php echo $i;?>" id='only_filter_exist_<?php echo $i;?>' />
										<input type="hidden" name='only_filter_<?php echo $i;?>_begin' value="<?php echo @$field->only_filter; ?>" />
									</td>

									<td>
										<a href="javascript: void(0)" onclick="javascript: remove_extend_field(<?php echo $i?>,'<?php echo $field_name; ?>')" >
											<i class="fa fa-trash"></i>	
											<?php echo FSText :: _("Remove")?>
										</a>
									</td>
								</tr>
								<?php } ?>		
							<?php $i ++ ;?>
							<?php } ?>
						<?php } ?>
						<?php for( $i = 0 ; $i< 10; $i ++ ) {?>
							<tr id="tr<?php echo $i; ?>" ></tr>
						<?php }?>
						</tbody>
					</table>
				<a href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Th&#234;m tr&#432;&#7901;ng"); ?> </a>
				</div>
			</fieldset>
			
			<!--	end FIELD	-->
			<input type="hidden" value="" name="field_remove" id="field_remove" />
			<input type="hidden" value="<?php echo isset($data)?count($data):0; ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
			<input type="hidden" value="" name="new_field_total" id="new_field_total" />
					
			<input type="hidden" value="<?php echo $this -> module;?>" name="module" />
			<input type="hidden" value="<?php echo $this -> view;?>" name="view" />
			<input type="hidden" value="" name="task" />
			<input type="hidden" value="0" name="boxchecked" />
			<input type="hidden" value="<?php echo $max_ordering?>" name="max_ordering" id = "max_ordering" />
		</form>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="addExtendGroup" tabindex="-1" role="dialog" aria-labelledby="addExtendGroupLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
		</button>
        <h4 class="modal-title" id="myModalLabel">Thêm mới danh sách thông số, phân loại</h4>
      </div>
      <div class="modal-body">
		  <form id="save1" action="index2.php?module=products&view=tables&task=save_new_extend_field&raw=1" method="post">
			<table class="table">
				<thead>
					<th>Tên</th>
					<th width="20%">Alias</th>
					<th>Nhóm thông số, phân loại</th>
					<th>Kiểu dữ liệu</th>
					<th width="100">Thứ tự</th>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" name="eg_name[]"  class="form-control" placeholder="Tên"></td>
						<td><input type="text" name="eg_alias[]"  class="form-control" placeholder="Tên hiệu (Có thể sinh tự động)"></td>
						<td>
							<select name="eg_field[]" class="select2-box">
								<option value="0">Chọn nhóm thông số, phân loại</option>
								<?php foreach ($group_field as $item){ ?>
									<option value="<?php echo $item->id; ?>" ><?php echo $item->name ?></option>
								<?php }?>
							</select>
						</td>
						<td>
							<select name='eg_type[]' class='select2-box'>
								<option value="varchar" selected>Chuỗi ký tự</option>
								<option value="int">Kiểu số</option>
								<option value="datetime">Thời gian</option>
								<option value="text">Textarea</option>
								<option value="foreign_one">Chọn một</option>
								<option value="foreign_multi">Chọn nhiều</option>
							</select>
						</td>
						<td><input type="text" name="eg_order[]"  class="form-control" placeholder="Thứ tự"></td>
					</tr>
				</tbody>
			</table>
			<a href="javascript:void(0)" style="color:#333" onclick="addFieldModal(1)">
				<i class="fa fa-lg fa-plus-square-o"></i>
				Thêm
			</a>
			<input type="hidden" name="redirect" value="<?php echo FSInput::get('tablename') ?>">
			<div style="text-align: right;">
				<button class="btn btn-primary" type="submit">Lưu</button>
			</div>
		  </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addExtendFieldGroup" tabindex="-1" role="dialog" aria-labelledby="addExtendFieldGroupLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
		</button>
        <h4 class="modal-title" id="myModalLabel">Thêm mới nhóm thông số, phân loại</h4>
      </div>
      <div class="modal-body">
		  <form id="save2" action="index2.php?module=products&view=tables&task=save_new_extend_field_group&raw=1" method="post">
			<table class="table">
				<thead>
					<th>Tên</th>
					<th width="100">Thứ tự</th>
				</thead>
				<tbody>
					<tr>
						<td><input type="text" name="efg_name[]"  class="form-control" placeholder="Tên nhóm"></td>
						<td><input type="text" name="efg_order[]"  class="form-control" placeholder="Thứ tự"></td>
					</tr>
				</tbody>
			</table>
			<a href="javascript:void(0)" style="color:#333" onclick="addFieldModal(2)">
				<i class="fa fa-lg fa-plus-square-o"></i>
				Thêm
			</a>
			<input type="hidden" name="redirect" value="<?php echo FSInput::get('tablename') ?>">
			<div style="text-align: right;">
				<button class="btn btn-primary" type="submit">Lưu</button>
			</div>
		  </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addExtendDetail" tabindex="-1" role="dialog" aria-labelledby="addExtendDetailLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="text-danger close" data-dismiss="modal" aria-label="Close">
			<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-x-circle" viewBox="0 0 16 16"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/></svg>
		</button>
        <h4 class="modal-title" id="myModalLabel">Chi tiết thông số, phân loại</h4>
      </div>
      <div class="modal-body">
		  <form id="list_detail" name="list_detail" method="post">
			
		  </form>
      </div>
    </div>
  </div>
</div>

<script>
	$(document).ready(function(){
		$('.select2-box').select2();

		$(document).on('click','.check-filter',function(){
			if($(this).is(':checked') == true){
				let select = $(this).attr('data-select');
				let value = $('#'+select).select2('val');
				if(value != 'foreign_one' && value != 'foreign_multi')
					$('#'+select).select2().val('foreign_one').trigger('change');
			}
		});
	});

	function addFieldModal(id,id_group = null){
		if(id === 2){
			let html = `
			<tr>
				<td><input type="text" name="efg_name[]" class="form-control" placeholder="Tên nhóm"></td>
				<td><input type="text" name="efg_order[]" class="form-control" placeholder="Thứ tự"></td>
			</tr>
			`;
			$('#addExtendFieldGroup .table tbody').append(html);
		}
		if(id === 1){
			let html = `
			<tr>
				<td><input type="text" name="eg_name[]" class="form-control" placeholder="Tên"></td>
				<td><input type="text" name="eg_alias[]" class="form-control" placeholder="Tên hiệu (Có thể sinh tự động)"></td>
				<td>
					<select name="eg_field[]" class="select2-box">
						<option value="0">Chọn nhóm thông số, phân loại</option>
						<?php foreach ($group_field as $item){ ?>
							<option value="<?php echo $item->id; ?>" ><?php echo $item->name ?></option>
						<?php }?>
					</select>
				</td>
				<td>
					<select name='eg_type[]' class='select2-box'>
						<option value="varchar" selected>Chuỗi ký tự</option>
						<option value="int">Kiểu số</option>
						<option value="datetime">Thời gian</option>
						<option value="text">Textarea</option>
						<option value="foreign_one">Chọn một</option>
						<option value="foreign_multi">Chọn nhiều</option>
					</select>
				</td>
				<td><input type="text" name="eg_order[]" class="form-control" placeholder="Thứ tự"></td>
				<script>$(document).ready(function(){$('.select2-box').select2();})<\/script>
			</tr>
			`;
			$('#addExtendGroup .table tbody').append(html);
		}

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
	$(function () {
		$('[data-toggle="tooltip"]').tooltip({
			animated: 'fade',
			placement: 'top',
			html: true
		});
	})
	var i = 0;
	// check 
	//	var fieldsname = new Array();
	//	< ?php foreach ($fields_fixed as $field) {?>
	//		fieldsname.push('< ?php echo $field[0];?>');
	//	< ?php }?>
	
	function addField()
	{
		max_ordering = $('#max_ordering').val();
		area_id = "#tr"+i;
		ordering = parseInt(max_ordering) + i + 1;
		htmlString = "<td>" ;
		htmlString += "<input class='form-control' type=\"text\" name='new_ordering_"+i+"' id='new_ordering_"+i+"' value='"+ordering+"' class='ordering' size='2' />";
		htmlString += "</td>";

		htmlString += "<td>" ;
		htmlString +=  "<input class='form-control' type=\"text\" name='new_fshow_"+i+"' id='new_fshow_"+i+"'  />";
		htmlString += "</td>";

		// htmlString += "<td>";
		// htmlString += "<select class='select2-box' name='new_ftype_"+i+"'  id='new_ftype_"+i+"' class='new_ftype' onchange='javascript: change_ftype(this);'>";
		// htmlString += "<option value=\"varchar\" >Chuỗi ký tự</option>";
		// htmlString += "<option value=\"int\" >Kiểu số</option>";
		// htmlString += "<option value=\"datetime\" >Thời gian</option>";
		// htmlString += "<option value=\"text\" >Soạn thảo Editor</option>";
		// htmlString += "<option value=\"foreign_one\" >Chọn một</option>";
		// htmlString += "<option value=\"foreign_multi\" >Chọn nhiều</option>";
		// htmlString += "</select>";
		// htmlString += "</td>";
		
		// foreign_data
		htmlString += "<td>";
		htmlString += "<div class='flex-container'>";
		htmlString += "<div class='item'>";
		htmlString += "<select data-btn='addBtnDetail"+i+"' data-change='new_group_id_"+i+"' class='select2-group select2-box' name='new_foreign_id_"+i+"' id='new_foreign_id_"+i+"' >";
		htmlString += "<option value='0'>Chọn danh sách thông số, phân loại</option>";
		<?php foreach ($foreign_data as $item) {?>
			htmlString += "<option value=\"<?php echo $item->id; ?>\" ><?php echo $item->name;  ?></option>";
		<?php }?>
		htmlString += "</select>";
		htmlString += "</div>";
		htmlString += "<div class='item-btn'>";
		htmlString += "<a class='btn-detail addBtnDetail"+i+"' data-table='<?php echo FSInput::get('tablename') ?>' data-id='' style='color:#FF6600' href='' data-toggle='modal' data-target='#addExtendDetail'>";
		htmlString += "<i data-toggle='tooltip' title='Chi tiết thông số, phân loại' class='fa-lg fa fa-list-alt'></i>";
		htmlString += "</a>";
		htmlString += "</div>";
		htmlString += "</div>";
		htmlString += "</td>";

		htmlString += "<td>";
		htmlString += "<select class='select2-box selectGroup' id='new_group_id_"+i+"' name='new_group_id_"+i+"'>";
		htmlString += "<option value=\"0\" >Chọn nhóm thông số, phân loại</option>";
		<?php foreach ($group_field as $item) {?>
			htmlString += "<option value=\"<?php echo $item->id; ?>\" ><?php echo $item->name;  ?></option>";
		<?php }?>
		htmlString += "</select>";
		htmlString += "</td>";
		

		// compare
		htmlString += "<td>";
		htmlString += "<input title='Hiển thị' class='checkbox-cusor' type='checkbox' checked name='new_is_main_"+i+"' id='new_is_main_"+i+"'>";
		htmlString += "</td>";

		htmlString += "<td>";
		htmlString += "<input title='Lọc' class='checkbox-cusor check-filter' data-select='new_ftype_"+i+"' type='checkbox' name='new_is_filter_"+i+"' id='new_is_filter_"+i+"'>";
		htmlString += "</td>";

		htmlString += "<td>";
		htmlString += "<input title='Chỉ lọc' class='checkbox-cusor check-filter' data-select='new_ftype_"+i+"' type='checkbox' name='new_only_filter_"+i+"' id='new_only_filter_"+i+"'>";
		htmlString += "</td>";
		
		htmlString += "<td>";
		htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ i +")\" >" + " X&#243;a" + "</a>";
		htmlString += "</td>";
		htmlString += "<script>$(document).ready(function(){$('.select2-box').select2();})<\/script>";
		$(area_id).html(htmlString);		
		i++;
		$("#new_field_total").val(i);
	}

	//remove extend field exits
	function remove_extend_field(area,fieldid)
	{
		if(confirm("You certain want remove this fiels"))
		{
			remove_field = "";
			remove_field = $('#field_remove').val();
			remove_field += ","+fieldid;
			$('#field_remove').val(remove_field);
			$('#extend_field_exist_'+area).html("");
		}
		return false;
	}
	//remove new extend field 
	function remove_new_field(area)
	{
		if(confirm("You certain want remove this fiels"))
		{
			area_id = "#tr"+area;
			$(area_id).html("");
		}
		return false;
	}

	function change_ftype(element){
		type_id = $(element).attr('id');
		foreign_id = type_id.replace("ftype","foreign_id"); 
		val = $(element).val();
		if(val == 'foreign_one' || val == 'foreign_multi'){
			$('#'+foreign_id).show();
			$('#'+foreign_id).select2();
			$('#container'+foreign_id).show();
		}else{
			$('#'+foreign_id).select2('destroy');
			$('#'+foreign_id).hide();
			$('#container'+foreign_id).hide();
		}
	}
	
	$(document).on('change','.select2-group',function(){
		let id = $(this).select2('val');
		id = parseInt(id);
		let change = $(this).attr('data-change');
		let btn = $(this).attr('data-btn');
		$.ajax({
            type: 'GET',
            dataType: 'html',
            url: 'index2.php?module=products&view=tables&task=ajax_get_group&raw=1',
            data: {id:id},
            success: function (data) {
				data = parseInt(data);
                $('#'+change).val(data);
				$('#'+change).trigger('change');
				$("#"+change+" ~ .select2").css('pointer-events:', 'none');
				if(id !== 0)
					$('.'+btn).attr('data-id',id).addClass('active');
				else	
					$('.'+btn).attr('data-id',id).removeClass('active');
            }
        });
	});

	$(document).on('click','.btn-detail',function(){
		let id = $(this).attr('data-id');
		let tablename = $(this).attr('data-table');
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
<style>
/* .field_tbl select{
	width: 120px;
}
.field_tbl select.ftype_exist,.field_tbl select.new_ftype{
	width: 90px;
} */
.field_tbl select.is_main_exist, .field_tbl select.new_is_main,
.field_tbl select.is_filter_exist, .field_tbl select.new_is_filter,
.field_tbl select.is_config_exist, .field_tbl select.new_is_config {
    width: 60px;
}
</style>