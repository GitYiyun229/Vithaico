<!-- Bootstrap Core CSS -->
<link href="templates/default/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="templates/default/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
<!-- DataTables Responsive CSS -->
<link href="templates/default/css/styles.css" rel="stylesheet">
<div class="table-responsive">
	<form action="#" name="linkedForm" method="get">
		<div class='contents'>
			<table  class="table table-hover table-bordered" >
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th>
						<?php echo ucfirst($field_display); ?>
					</th>
		
					<?php foreach($arr_field_value as $field_one){?>
						<?php if($field_display != $field_one){?>	
					<th>
						<?php echo ucfirst($field_one); ?>
					</th>
						<?php }?>
					<?php }?>
					<th>
						<?php echo FSText :: _('Add Link'); ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php foreach ($list as $row) { ?>
						<?php $str_value_in_record = '';?>
						<tr class="row<?php echo $i%2; ?>">
							<td><?php echo $i+1; ?></td>
							<td><?php echo $row->$field_display; ?></td>
							<?php $j = 0;?>
							<?php foreach($arr_field_value as $field_one){?>
							<?php if($field_display != $field_one){?>
								<?php if($j > 0) $str_value_in_record .= ',';?>
								<?php $str_value_in_record .= $row->$field_one;?>					
							<td >
								<?php echo $row->$field_one; ?>
							</td>
								<?php $j ++;?>
							<?php }?>
							<?php }?>
							<td><a href="javascript: add_param('<?php echo $str_value_in_record; ?>')" >Create link</a></td>
						</tr>
						<?php $i++; ?>
					<?php }?>
					
				</tbody>
			</table>
			
		</div>
		<div class="footer_form">
			<?php echo $pagination->showPagination();?>
		</div>
	
		<input type="hidden" value="news" name="module" />
		<input type="hidden" value="add_param" name="task" />
		<input type="hidden" value="news" name="view" />
	</form>
</div>
<script type="text/javascript">
    
	param = '<?php echo $add_param;?>';
	arr_param = param.split(',');
	function add_param(value){
		arr_value = value.split(',');
		str_uri = '';
		for(i = 0; i < arr_param.length; i ++){
			str_uri += '&'+arr_param[i]+'='+arr_value[i];
		}
        //alert(str_uri);
		window.opener.document.getElementById("<?php echo $results_id ?>").value += str_uri;
		window.close();
	}
</script>