<!--	FIELD	-->
		<fieldset>
			<legend>Bộ lọc trong trường</legend>
			<div id="tabs" class="form-contents table-responsive">
		        <!-- <table cellpadding="5"  cellspacing="0" class="field_tbl" width="100%" border="1" bordercolor="red"> -->
                <table class="table table-hover table-striped table-bordered">
		        	<tr>
		        		<td> T&#234;n hi&#7875;n th&#7883;</td>
		        		<td> T&#234;n hiệu
		        			<br/><span>(duy nhất)</span></td>
		        		<td> T&#237;nh to&#225;n </td>
		        		<td> Gi&#225; tr&#7883;<br/><span>(Nếu có 2 giá trị thì cách nhau dấu phẩy)</span></td>
		        		<td width="22%"> SEO </td>
		        		<td> Thứ tự </td>
		        		<td> Published </td>
		        		<td> &nbsp; </td>
		        	</tr>
							<?php $i = 0;?>
							<?php if (!empty($filters)) { ?>
								<?php if(count($filters)) { ?>
									<?php foreach ($filters as $field) { ?>
										<tr id="filter_exist_<?php echo $i; ?>">
											<td>
												<input type="text" name='filter_show_exist_<?php echo $i;?>' value="<?php echo $field->filter_show; ?>" />
												<input type="hidden" name='filter_show_exist_<?php echo $i;?>_begin' value="<?php echo $field->filter_show; ?>" />
											</td>
											<td>
												<input type="text" name='alias_exist_<?php echo $i;?>' value="<?php echo $field->alias; ?>" />
												<input type="hidden" name='alias_exist_<?php echo $i;?>_begin' value="<?php echo $field->alias; ?>" />
											</td>
											
											<td>
												<select name='calculator_exist_<?php echo $i;?>' >
													<?php foreach ($calculators as $item) {?>
														<?php if($item[0] == $field -> calculator) {?>
															<option value="<?php echo $item[0]; ?>" selected="selected" ><?php echo $item[1]; ?></option>
															
														<?php } else { ?>
															<option value="<?php echo $item[0]; ?>"  ><?php echo $item[1]; ?></option>
														<?php }?>
														
													<?php }?>
												</select>
												<input type="hidden" name='calculator_exist_<?php echo $i;?>_begin' value="<?php echo $field->calculator; ?>" />
											</td>
											
											<td>
												<input type="text" name='value_exist_<?php echo $i;?>' value="<?php echo $field->filter_value; ?>" />
												<input type="hidden" name='value_exist_<?php echo $i;?>_begin' value="<?php echo $field->filter_value; ?>" />
											</td>
											<td>
												<span class='seo_label'>Title:&nbsp;&nbsp;&nbsp;</span><input type="text" name='seo_title_exist_<?php echo $i;?>' value="<?php echo $field->seo_title; ?>" />
												<input type="hidden" name='seo_title_exist_<?php echo $i;?>_begin' value="<?php echo $field->seo_title; ?>" />
												<br/>
												<span class='seo_label'>Meta key:</span><input type="text" name='seo_meta_key_exist_<?php echo $i;?>' value="<?php echo $field->seo_meta_key; ?>" />
												<input type="hidden" name='seo_meta_key_exist_<?php echo $i;?>_begin' value="<?php echo $field->seo_meta_key; ?>" />
												<br/>
												<span class='seo_label'>Meta des:</span><input type="text" name='seo_meta_des_exist_<?php echo $i;?>' value="<?php echo $field->seo_meta_des; ?>" />
												<input type="hidden" name='seo_meta_des_exist_<?php echo $i;?>_begin' value="<?php echo $field->seo_meta_des; ?>" />
												<br/>
											</td>
											<td>
												<input type="text" name='field_ordering_exist_<?php echo $i;?>' value="<?php echo $field->field_ordering; ?>" size="4"/>
												<input type="hidden" name='field_ordering_exist_<?php echo $i;?>_begin' value="<?php echo $field->field_ordering; ?>" />
											</td>
											<td>
												<input type="checkbox" name='published_exist_<?php echo $i;?>' <?php echo $field->published?"checked='checked'":""; ?> value="1" />
												<input type="hidden" name='published_exist_<?php echo $i;?>_begin' value="<?php echo $field->published; ?>" />
											</td>
											
											<td>
												<input type="hidden" name='filterid_exist_<?php echo $i;?>' value="<?php echo $field->id; ?>" />
												<a href="javascript: void(0)" onclick="javascript: remove_filter_exist(<?php echo $i?>,'<?php echo $field->id; ?>')" >X&#243;a</a>
											</td>
										</tr>
									<?php $i ++ ;?>
								<?php }?>
							<?php }?>

					<?php } ?>
					
					<?php for( $i = 0 ; $i< 10; $i ++ ) {?>
					<tr id="tr<?php echo $i; ?>" ></tr>
					<?php }?>
					
				</table>
				<a href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Thêm filter"); ?> </a>
		    
			</div>
		</fieldset>
<style>
.seo_label{
	display: inline-flex;
    width: 60px;		
}
</style>