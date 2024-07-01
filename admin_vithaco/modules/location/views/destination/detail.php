<!-- HEAD -->
	
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		<table cellspacing="1" class="admintable">
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Name'); ?>
				</td>
				<td>
					<input type="text" name='name' value="<?php echo @$data->name; ?>" size="70" />
				</td>
			</tr>
				<tr>
					<td class="key"><span>T&#7881;nh/th&agrave;nh ph&#7889;</span></td>
					<td class="value1">
						<select name="city_id" id = "city_id">
							<?php foreach($cities as $city){?>
								<?php $checked =  (@$data->city_id == $city->id)? " selected = 'selected'": ""; ?>
								<option value="<?php echo $city->id; ?>" <?php echo $checked; ?>><?php echo $city->name ; ?></option>
							<?php } ?>
						</select>
					</td>
				</tr>
				<tr>
					<td class="key"><span>Qu&#7853;n/huy&#7879;n</span></td>
					<td class="value1">
						<select name="district_id" id = "district_id">
							<?php foreach($districts as $district){?>
								<?php $checked =  (@$data->district_id == $district->id)?  " selected = 'selected'": ""; ?>
								<option value="<?php echo $district->id; ?>" <?php echo $checked; ?> ><?php echo $district->name ; ?></option>
							<?php } ?>
						</select>
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
			
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Ordering'); ?>
				</td>
				<td>
					<input type="text" name='ordering' value="<?php echo (isset($data->ordering)) ? @$data->ordering : @$maxOrdering; ?>"/>
				</td>
			</tr>
			<tr>
				<td valign="top" class="key">
					<?php echo FSText :: _('Description'); ?>
				</td>
				<td>
					<?php
					$oFCKeditor1 = new FCKeditor('description') ;
					$oFCKeditor1->BasePath	=  '../libraries/wysiwyg_editor/' ;
					$oFCKeditor1->Value		= @$data->description;
					$oFCKeditor1->Width = 650;
					$oFCKeditor1->Height = 450;
					$oFCKeditor1->Create() ;
					?>
				</td>
			</tr>
		</table>
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo $data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
<script  type="text/javascript" language="javascript">
$(function(){
	$("select#city_id").change(function(){
		$.getJSON("index.php?module=estores&view=estores&task=district&raw=1",{cid: $(this).val()}, function(j){
			
			var options = '';
			for (var i = 0; i < j.length; i++) {
				options += '<option value="' + j[i].id + '">' + j[i].name + '</option>';
				
			}
			$("#district_id").html(options);
			$('#district_id option:first').attr('selected', 'selected');
		})
	})			
})
</script>