<!-- HEAD -->
	<?php 
	
	$title = @$data ? FSText::_('Sửa thông tin thành viên'): FSText::_('Thêm thành viên'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png'); 
//	$toolbar->addButton('save',FSText::_('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png'); 
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	<div id="msg_error"></div>
<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
			
			<!--	BASE FIELDS    -->
			<table cellpadding="6" cellspacing="0">
				<tr>
					<td class="label1"><span>Username </span></td>
					<td class="value1">
						<?php if($data -> id){?>
						<a href="<?php echo 'index.php?module=members&view=collaborators&task=edit&id='.@$data -> id; ?>" target="_blink" >
							<?php echo @$data->username; ?>
						</a>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td class="label1"><span>Số lượng thành viên cấp dưới </span></td>
					<td class="value1">
						<?php if($data -> id){?>
						<a href="<?php echo 'index.php?module=members&view=collaborators&task=edit&id='.@$data -> id; ?>" target="_blink" >
							<?php echo @$data->username; ?>
						</a>
						<?php }?>
					</td>
				</tr>
			</table>	
			
		<?php if(@$data->id) { ?>
		<input type="hidden" value="<?php echo @$data->id; ?>" name="id">
		<?php }?>
		<input type="hidden" value="col" name="view">
		<input type="hidden" value="members" name="module">
		<input type="hidden" value="collaborators" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>
<!-- END BODY-->
