<!-- HEAD -->
	<?php 
	$title = @$data ? FSText :: _('S&#7917;a v&#7883; tr&#237; hi&#7875;n th&#7883;'): FSText :: _('T&#7841;o m&#7899;i v&#7883; tr&#237; hi&#7875;n th&#7883;'); 
	global $toolbar;
	$toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png',1);
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png',1); 
	$toolbar->addButton('cancel',FSText :: _('Cancel'),'','cancel.png'); 
    
    echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>'; 
    //$this -> dt_form_begin(1,4,$title);
    global $position;
    $this -> dt_form_begin(1,4,FSText::_('Cài đặt'),'fa-edit',1,'col-md-8',1);
        TemplateHelper::dt_edit_text(FSText :: _('Tiêu đề Block'),'title',@$data -> title);
//        TemplateHelper::dt_edit_text(FSText :: _('Link'),'url',@$data -> url);
//        TemplateHelper::dt_edit_text(FSText :: _('Loại thẻ'),'type_html',@$data -> type_html,'','','','','VD: h1 or h2 ....');
//         
//        TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,9,FSText::_('Kích hoạt'),'fa-unlock',1,'col-md-4 fl-right');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_checkbox(FSText::_('Hiển thị tiêu đề'),'showTitle',@$data -> showTitle,0,'','','','col-sm-4','col-sm-8');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'','',0,'','','col-sm-4','col-sm-8');
    $this->dt_form_end_col(); // END: col-2
    
//    $this -> dt_form_begin(1,8,FSText::_('Hiệu ứng mầu của tiêu đề'),'fa-h-square',1,'col-md-4 fl-right');
//        TemplateHelper::dt_edit_text(FSText :: _('Nhập chữ cần đổi màu'),'text_replace',@$data -> text_replace,'','','','','','','col-sm-4','col-sm-8');
//        TemplateHelper::jscolorpicker(FSText:: _('Màu chữ'),'text_color',@$data -> text_color,'','','','col-sm-4','col-sm-8');
//    $this->dt_form_end_col(); // END: col-4
    
    //$this -> dt_form_begin(1,7,FSText::_('Hiệu ứng mầu nền'),'fa-h-square',1,'col-md-4 fl-right');
//        TemplateHelper::dt_checkbox(FSText::_('Kiểu background'),'type_background',@$data -> type_background,1,array(1=>'Tắt',2=>'Mầu',3=>'Ảnh',4=>'Mầu && ảnh'),'','','col-sm-4','col-sm-8');
//        TemplateHelper::jscolorpicker(FSText:: _('Màu nền(background-color)'),'background_color',@$data -> background_color,'','','','col-sm-4','col-sm-8');
//        TemplateHelper::dt_edit_image(FSText :: _('background Image'),'image',str_replace('/original/','/original/',URL_ROOT.@$data->image),'64px','','','col-sm-4','col-sm-8');
//    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Cài đặt'),'fa-edit',1,'col-md-8');
?>
    <div class="form-group">
        <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('N&#417;i xu&#7845;t hi&#7879;n'); ?></label>
		<div class="col-sm-10 col-xs-12">
			<div class="" style="margin-bottom: 10px;">
				<input class="radio-custom" type="radio" id = 'check_none' name='area_select' value='none' <?php echo (!@$data->listItemid||@$data->listItemid == 'none')? 'checked="checked"':'';?> /> 
                <label for="check_none" class="radio-custom-label"><?php echo FSText::_('Không xuất hiện') ?></label>
               
				<input class="radio-custom" type="radio" id = 'check_select' name='area_select' value='select' <?php echo (@$data->listItemid && @$data->listItemid != 'none' && @$data->listItemid != 'all')? 'checked="checked"':'';?> />
				<label for="check_select" class="radio-custom-label"><?php echo FSText::_('Lựa chọn') ?></label>
                
                <input class="radio-custom" type="radio" id = 'check_all' name='area_select'  value='all' <?php echo (@$data->listItemid == 'all')? 'checked="checked"':'';?> />
			    <label for="check_all" class="radio-custom-label"><?php echo FSText::_('Tất cả') ?></label> 
            </div>
			<?php 
				// print_r($menus_items_all);die;
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
			<select data-placeholder="<?php echo FSText::_('Nơi xuất hiện') ?>" name ="menus_items[]" size="8" multiple="multiple" class='form-control chosen-select-no-results listItem' <?php echo (!@$data->listItemid || @$data->listItemid == 'none' || @$data->listItemid == 'all')? 'disabled="disabled"':'';?> >
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
    <div class="form-group">
        <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('Kiểu'); ?></label>
		<div class="col-sm-10 col-xs-12">
			<select data-placeholder="<?php echo FSText::_('Kiểu') ?>" name="type" class="type form-control chosen-select" >
					<?php
					$block_select = isset($data->module)?$data->module:'contents';
					foreach($listmoduletype as $item){
						if( $item->block == $block_select ){
							echo "<option value='" . $item -> id. "' selected='selected'>" . $item->name .' ['.$item -> block.']'. "</option>";
						}
						else{
							echo "<option value='" . $item -> id . "'>" . $item->name .' ['.$item -> block.']'. "</option>";
						}
					} 
					?>
				</select>
		</div>
	</div><!-- END: type -->
    <div class="form-group">
        <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('V&#7883; tr&#237;'); ?></label>
		<div class="col-sm-10 col-xs-12">
			<select data-placeholder="<?php echo FSText :: _('V&#7883; tr&#237;'); ?>" name="position" class="pos form-control chosen-select" >
					<?php
					foreach($positions as $key => $p){
						if( (@$data->position) && $key == @$data->position ){
							echo "<option value='" . $key . "' selected='selected'>" . $p . "</option>";
						}
						else{
							echo "<option value='" . $key . "'>" . $p .'['.$key.']'. "</option>";
						}
					} 
					?>
			</select>
		</div>
	</div><!-- END: positions -->
    <?php if( @$data->module == 'contents'){?>
	<div class="form-group">	
        <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('Content'); ?></label>
		<div class="col-sm-10 col-xs-12">
			<?php
//				echo $data->content;
				$oFCKeditor = new FCKeditor('content') ;
				$oFCKeditor->BasePath	=  '../libraries/wysiwyg_editor/' ;
				$oFCKeditor->Value		= @$data->content;
				$oFCKeditor->Width = 650;
				$oFCKeditor->Height = 450;
				$oFCKeditor->Create() ;
				?>
		</div>
	</div><!-- END: positions -->
	<?php }?>
    <div class="form-group">	
        <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('Parameters'); ?></label>
		<div class="col-sm-10 col-xs-12">
			<?php   include_once 'detail_params.php';?>	
		</div>
	</div>
<?php
    $this->dt_form_end_col(); // END: col-4
    $this -> dt_form_end(@$data,1,0,2,'','',1);
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
      if (e.which == 13) {
        formValidator();
        return false;  
      }
    });
    
	function formValidator()
	{
	    $('.alert-danger').show();	
        
		if(!notEmpty('title','Bạn phải nhập tiêu đề'))
			return false;
            
		$('.alert-danger').hide();
		return true;
	}
   

</script>
<script type="text/javascript">
	$(document).ready(function() {
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