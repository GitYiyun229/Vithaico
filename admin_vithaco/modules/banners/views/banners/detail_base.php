<?php
  TemplateHelper::dt_edit_text(FSText :: _('Tên Banner'),'name',@$data -> name);
  TemplateHelper::dt_edit_text(FSText :: _('Link'),'link',@$data -> link);
  //TemplateHelper::dt_edit_selectbox(FSText::_('Loại banner'),'type',@$data->type,0,$array_type,$field_value = 'id', $field_label='group_name',$size = 1,0);

 ?>
	<!-- <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_('Loại banner'); ?></label>
		<div class="col-sm-9 col-xs-12">
			<select class="form-control chosen-select" name="type" id="type" >
				<?php
				// selected category
				$cat_compare  = 0;
				if(@$data->type)
				{
					$cat_compare = $data->type;
				}
				$i = 0;
				foreach ($array_type as $key => $name) {
					$checked = "";
					if(!$cat_compare && !$i){
						$checked = "selected=\"selected\"";
					} else {
						if($cat_compare == $key)
							$checked = "selected=\"selected\"";
					}

				?>
					<option value="<?php echo $key; ?>" <?php echo $checked; ?> ><?php echo $name;  ?> </option>
				<?php
					$i ++;
				}?>
			</select>
		</div>
	</div> -->

<?php
//TemplateHelper::dt_edit_text(FSText :: _('Width'),'width',@$data -> width,0);
//TemplateHelper::dt_edit_text(FSText :: _('Height'),'height',@$data -> height,0);
	TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục banner'),'category_id',@$data->category_id,0,$categories,$field_value = 'id', $field_label='name',$size = 1,0);
?>
	<div class="form-group" id="set-width">
  	<label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_('Chiều rộng'); ?></label>
		<div class="col-sm-9 col-xs-12">
			<select class="form-control select2-temp" name="type" id="type" >
				<?php
				$width = array(0 => '25', 1 => '50', 2 => '100');
				foreach ($width as $key => $name) {
					$checked = "";
				?>
					<option value="<?php echo $key; ?>" <?php echo $checked; ?> > <?php echo $name .'% diện tích màn hình';  ?>  </option>
				<?php
					$i ++;
				}?>
			</select>
		</div>
	</div>
<?php
  TemplateHelper::dt_edit_image(FSText:: _('Image'),'image',URL_ROOT.@$data->image,'','',FSText::_('(Dùng ảnh JPG ở vị trí này)'));
?>

<?php 
// TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'(Nếu bạn chọn loại banner là HTML)','','col-sm-3','col-sm-9');  ?>

	<div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText :: _('N&#417;i xu&#7845;t hi&#7879;n'); ?></label>
		<div class="col-sm-9 col-xs-12">
			<div class="" style="margin-bottom: 10px;">
				<input class="radio-custom" type="radio" id = 'check_none' name='area_select' value='none' <?php echo (!@$data->listItemid||@$data->listItemid == 'none')? 'checked="checked"':'';?> />
                <label for="check_none" class="radio-custom-label"><?php echo FSText::_('Không xuất hiện') ?></label>

				<input class="radio-custom" type="radio" id = 'check_select' name='area_select' value='select' <?php echo (@$data->listItemid && @$data->listItemid != 'none' && @$data->listItemid != 'all')? 'checked="checked"':'';?> />
				<label for="check_select" class="radio-custom-label"><?php echo FSText::_('Lựa chọn') ?></label>

                <input class="radio-custom" type="radio" id = 'check_all' name='area_select'  value='all' <?php echo (@$data->listItemid == 'all')? 'checked="checked"':'';?> />
			    <label for="check_all" class="radio-custom-label"><?php echo FSText::_('Tất cả') ?></label>
            </div>
			<?php
				$listItemid = @$data->listItemid;
				$checked = 0;
				$checked_all = 0;

				if((!@$data->listItemid) || @$data->listItemid === 'none' || @$data->listItemid === '0'){
					$checked = 0;
				} else if(@$data->listItemid === 'all'){
					$checked_all = 1;
				} else {
					$checked = 1;
					$checked_all = 0;
					$arr_menu_item = explode(',',@$data->listItemid);
				}
			?>
			<select data-placeholder="<?php echo FSText::_('Nơi xuất hiện') ?>" name ="menus_items[]" size="8" multiple="multiple" class='form-control chosen-select-no-results select2-temp listItem' <?php echo (!@$data->listItemid || @$data->listItemid == 'none' || @$data->listItemid == 'all')? 'disabled="disabled"':'';?> >
				<?php

				foreach($menus_items_all as $item) {

					$html_check = "";
					if($checked_all){
						$html_check = "' selected='selected' ";
					} else {
						if($checked){
							if(in_array($item->id,$arr_menu_item)) {
								$html_check = "' selected='selected' ";
							}
						}
					}
				?>
					<option value="<?php echo $item->id?>" <?php echo $html_check; ?>><?php echo $item -> name; ?></option>
				<?php } ?>
			</select>
		</div>
	</div><!-- END: type -->

<?php
//    TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục tin tức'),'news_categories',@$data->news_categories,0,$news_categories,$field_value = 'id', $field_label='treename',$size = 1,1);
    //TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm'),'products_categories',@$data->products_categories,0,$products_categories,$field_value = 'id', $field_label='treename',$size = 1,1);
//    TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục trang tĩnh'),'contents_categories',@$data->contents_categories,0,$contents_categories,$field_value = 'id', $field_label='treename',$size = 1,1);
	TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm').'','products_categories',@$data->products_categories, 0,$products_categories,$field_value = 'id', $field_label='treename',$size = 1,1);

	TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
?>

<script type="text/javascript">
	$(document).ready(function() {
		
		$("#set-width").hide()

		$('#category_id').change(function() {
			if ($('#category_id').val() == 13) {
				$("#set-width").show()
			} else {
				$("#set-width").hide()
			}
		})

		$('#check_none').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', '');
			});
			$('.listItem').attr('disabled','disabled');
            $(".listItem").trigger("chosen:updated");
		});
		$('#check_all').click(function(){
			$('.listItem option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.listItem').attr('disabled','disabled');
            $(".listItem").trigger("chosen:updated");
		});
		$('#check_select').click(function(){
			$('.listItem').removeAttr('disabled');
            $(".listItem").trigger("chosen:updated");
		});
	});

</script>
