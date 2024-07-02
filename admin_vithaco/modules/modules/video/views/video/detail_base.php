			<table cellspacing="1" class="admintable">
				
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Title'); ?>
					</td>
					<td>
						<input type="text" name='title' value="<?php echo @$data->title; ?>"  id="title">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Alias'); ?>
					</td>
					<td>
						<input type="text" name='alias' value="<?php echo @$data->alias; ?>"  id="alias">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Link'); ?>
					</td>
					<td>
						<input type="text" name='file_flash' value="<?php echo @$data->file_flash; ?>"  id="file_flash">
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Estores'); ?>
					</td>
					<td>
							<?php 
							// selected category
							echo '<select name="estore_id" size="10" id="estore_id">';
							$compare = isset($data->estore_id) ?  $data->estore_id : 0;
							
							// owner is not estore
							$checked_not_estore = '';
							if(!$compare)
								$checked_not_estore = "selected=\"selected\"";
							echo '<option value="0" '. $checked_not_estore.' > Thuộc sàn </option>';	
							if(isset($estores))
								foreach ($estores as $item) {
									$checked = "";
									if($compare == $item->id)
										$checked = "selected=\"selected\"";
									echo '<option value="'.$item->id.'" '. $checked.' >'. $item->estore_name.' </option>';	
								}
							echo '</select>';
							?>
						
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Image'); ?>
					</td>
					<td>
						<?php if(@$data->image){?>
						<img alt="<?php echo $data->title?>" src="<?php echo URL_IMG_VIDEO.'resized/'.$data->image; ?>" /><br/>
						<?php }?>
						<input type="file" name="image"  />
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Published'); ?>
					</td>
					<td>
						<input type="radio" name="published" value="1" <?php if(@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="published" value="0" <?php if(!@$data->published) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				<!--<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Homepage'); ?>
					</td>
					<td>
						<input type="radio" name="show_in_homepage" value="1" <?php if(@$data->show_in_homepage) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('Yes'); ?>
						<input type="radio" name="show_in_homepage" value="0" <?php if(!@$data->show_in_homepage) echo "checked=\"checked\"" ;?> />
						<?php echo FSText :: _('No'); ?>
					</td>
				</tr>
				--><tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Ordering'); ?>
					</td>
					<td>
						<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>">
					</td>
				</tr>
				<tr>
					<td valign="top" class="key">
						<?php echo FSText :: _('Summary'); ?>
					</td>
					<td>
						<textarea rows="9" cols="60" name="summary"><?php echo @$data->summary; ?></textarea>
					</td>
	
				</tr>
			</table>
		