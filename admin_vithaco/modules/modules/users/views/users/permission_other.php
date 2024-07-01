<div class="panel panel-primary">
<div class="panel-body">
		<div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('Quyền trên danh mục tin tức'); ?></label>	
					<div class="col-sm-6 col-xs-12">
						<div class="" style="margin-bottom: 10px;">
							<input class="radio-custom" type="radio" id = 'check_news_categories_none' name='area_news_categories_select' value='none' <?php echo (!@$data->news_categories||@$data->news_categories == 'none')? 'checked="checked"':'';?> />
							<label for="check_news_categories_none" class="radio-custom-label"><?php echo FSText::_('Không nơi nào') ?></label>
                            
                            <input class="radio-custom" type="radio" id = 'check_news_categories_select' name='area_news_categories_select' value='select' <?php echo (@$data->news_categories && @$data->news_categories != 'none' && @$data->news_categories != 'all')? 'checked="checked"':'';?> />
							<label for="check_news_categories_select" class="radio-custom-label"><?php echo FSText::_('Lựa chọn') ?></label>
                            
                            <input class="radio-custom" type="radio" id = 'check_news_categories_all' name='area_news_categories_select'  value='all' <?php echo (@$data->news_categories == 'all')? 'checked="checked"':'';?> />
						    <label for="check_news_categories_all" class="radio-custom-label"><?php echo FSText::_('Tất cả') ?></label> 
                        </div>
<!--								-->
						<?php 
							$checked = 0;
							$checked_all = 0;
							
							if((!@$data->news_categories) || @$data->news_categories === 'none' || @$data->news_categories === '0'){
								$checked = 0;
							} else if(@$data->news_categories === 'all'){
								$checked_all = 1;
							} else {
								$checked = 1;
								$checked_all = 0;
								$arr_news_categories = explode(',',@$data->news_categories);
							}?>
<!--								-->
						<select data-placeholder="<?php echo FSText::_('Danh mục tin tức') ?>" 
                                name ="news_categories[]" 
                                <?php echo (!@$data->news_categories || @$data->news_categories == 'none' || @$data->news_categories == 'all')? 'disabled="disabled"':'';?>
                                multiple="multiple" class='form-control news_categories chosen-select-no-results'>
							<?php 
							
							foreach($news_categories as $item) {
								$html_check = "";
								if($checked_all){
									$html_check = "' selected='selected' ";
								} else {
									if($checked){
										if(in_array($item->id,$arr_news_categories)) {
											$html_check = "' selected='selected' ";
										}
									}
								}
							?>
								<option value="<?php echo $item->id; ?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
							<?php } ?>
						</select>
					</div>
		  </div>
          
		  <!--<div class="form-group">
                    <label class="col-sm-2 col-xs-12 control-label"><?php echo FSText :: _('Quyền trên danh mục sản phẩm'); ?></label>
					<div class="col-sm-6 col-xs-12">
						<div class="" style="margin-bottom: 10px;">
							<input class="radio-custom" type="radio" id = 'check_products_categories_none' name='area_products_categories_select' value='none' <?php echo (!@$data->news_categories||@$data->products_categories == 'none')? 'checked="checked"':'';?> />
						    <label for="check_products_categories_none" class="radio-custom-label"><?php echo FSText::_('Không nơi nào') ?></label>
                            
                            <input class="radio-custom" type="radio" id = 'check_products_categories_select' name='area_products_categories_select' value='select' <?php echo (@$data->news_categories && @$data->products_categories != 'none' && @$data->news_categories != 'all')? 'checked="checked"':'';?> />
							<label for="check_products_categories_select" class="radio-custom-label"><?php echo FSText::_('Lựa chọn') ?></label>
                            
                            <input class="radio-custom" type="radio" id = 'check_products_categories_all' name='area_products_categories_select'  value='all' <?php echo (@$data->products_categories == 'all')? 'checked="checked"':'';?> />
						    <label for="check_products_categories_all" class="radio-custom-label"><?php echo FSText::_('Tất cả') ?></label>  
                        </div>
						
						<?php 
							$checked = 0;
							$checked_all = 0;
							
							if((!@$data->products_categories) || @$data->products_categories === 'none' || @$data->products_categories === '0'){
								$checked = 0;
							} else if(@$data->products_categories === 'all'){
								$checked_all = 1;
							} else {
								$checked = 1;
								$checked_all = 0;
								$arr_products_categories = explode(',',@$data->products_categories);
							}?>
						<select data-placeholder="<?php echo FSText::_('Danh mục sản phẩm') ?>" 
                                name ="products_categories[]" 
                                size="20"
                                <?php echo (!@$data->products_categories || @$data->products_categories == 'none' || @$data->products_categories == 'all')? 'disabled="disabled"':'';?> 
                                multiple="multiple" class='form-control products_categories chosen-select-no-results'>
							<?php 
							
							foreach($products_categories as $item) {
								
								$html_check = "";
								if($checked_all){
									$html_check = "' selected='selected' ";
								} else {
									if($checked){
										if(in_array($item->id,$arr_products_categories)) {
											$html_check = "' selected='selected' ";
										}
									}
								}
							?>
								<option value="<?php echo $item->id; ?>" <?php echo $html_check; ?>><?php echo $item -> treename; ?></option>
							<?php } ?>
						</select>
					</div>
				</div>-->
</div>
</div>			
<script type="text/javascript">
	$(document).ready(function() {
		// news
		$('#check_news_categories_none').click(function(){
			$('.news_categories option').each(function(){
				$(this).attr('selected', '');
			});
			$('.news_categories').attr('disabled','disabled');
            $(".news_categories").trigger("chosen:updated");
		});
		$('#check_news_categories_all').click(function(){
			$('.news_categories option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.news_categories').attr('disabled','disabled');
            $(".news_categories").trigger("chosen:updated");
		});
		$('#check_news_categories_select').click(function(){
			$('.news_categories').removeAttr('disabled');
            $(".news_categories").trigger("chosen:updated");
		});
		
		// products
		$('#check_products_categories_none').click(function(){
			$('.products_categories option').each(function(){
				$(this).attr('selected', '');
			});
			$('.products_categories').attr('disabled','disabled');
            $(".products_categories").trigger("chosen:updated");
		});
		$('#check_products_categories_all').click(function(){
			$('.products_categories option').each(function(){
				$(this).attr('selected', 'selected');
			});
			$('.products_categories').attr('disabled','disabled');
            $(".products_categories").trigger("chosen:updated");
		});
		$('#check_products_categories_select').click(function(){
			$('.products_categories').removeAttr('disabled');
            $(".products_categories").trigger("chosen:updated");
		});
	});
</script>
