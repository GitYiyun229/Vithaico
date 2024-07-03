<table cellpadding="6" cellspacing="0">
	<tr>
		<td class="label1"><span>Username </span></td>
		<td class="value1">
			<?php if($data -> id){?>
			<a href="<?php echo 'index.php?module=members&view=members&task=edit&id='.@$data -> id; ?>" target="_blink" >
				<?php echo @$data->username; ?>
			</a>
			<?php }?>
		</td>
	</tr>
	<tr>
		<td class="label1"><span>Số lượng thành viên cấp dưới: </span></td>
		<td class="value1">
			<strong><?php echo count($children_members); ?></strong> 
		</td>
	</tr>
</table>	