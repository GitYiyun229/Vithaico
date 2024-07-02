<?php if(isset($config['fields_seo_h1']['fields']) && $config['fields_seo_h1']['fields'] && count($config['fields_seo_h1']['fields'])): ?>
	<?php $count_fields = count($config['fields_seo_h1']['fields']);?>	
	<tr>
		<td valign="top" width="109">
			<?php $title = isset($config['fields_seo_title']['title'])?$config['fields_seo_title']['title']:FSText::_('H1'); ?>
			<?php echo $title; ?>
		</td>
		<td   valign="top">
			<?php $data_fields_seo_h1 = isset($data -> fields_seo_h1)?$data -> fields_seo_h1:'';?>
			<select name="fields_seo_h1" class='seo_field'>
				<?php foreach($config['fields_seo_h1']['fields'] as $field_name => $field_title):?>
					<option value="<?php echo $field_name;?>" <?php echo $field_name == $data_fields_seo_h1?'selected="selected"':''?> ><?php echo $field_title;?></option>
				<?php endforeach;?>
			</select>
		</td>
		<td  width="30">
			<?php if(isset($config['fields_seo_h1']['help']) && $config['fields_seo_h1']['help'] ) {?>
				<a href="javascript:void()" title="Help " class="fa fa-exclamation-circle">
					<div class='help_content' style="display:none"><?php echo $config['fields_seo_h1']['help'] ;?></div>
				</a>
			<?php }else{?>
				&nbsp;
			<?php }?>
		</td>
	</tr>
<?php endif;?>
	