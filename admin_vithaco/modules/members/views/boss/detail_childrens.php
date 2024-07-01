<table cellpadding="5" cellspacing="0"  border="1" bordercolor="#D1D1D1" width="100%" >
	<thead>
		<tr align="center" bgcolor="white">
			<th width="30" align="center"><b>STT</b></th>
			<th align="center"><b><?php echo "Họ tên";?></b></th>
			<th align="center"><b><?php echo "SĐT";?></b></th>
			<th width="117" align="center"><b><?php echo "Kích hoạt"; ?></b></th>
			<th width="117" align="center"><b><?php echo "Ngày tạo"; ?></b></th>
	  	</tr>
	  </thead>
	<tbody>
	<?php if(count($children_members)){?>
		<?php $i = 1; ?>
		<?php foreach($children_members as $item){?>
			<tr class='row<?php echo ($i%2); ?>'>
				<td align="center">
					<strong><?php echo ($i); ?></strong><br/>
				</td>
				<td align="center">
					<?php echo $item -> full_name; ?>
				</td>
				<td align="center">
					<?php echo $item -> mobilephone; ?>
				</td>
				<td align="center">
					<?php  echo $item -> published?'Đã kích hoạt':'Chờ kích hoạt'; ?>
				</td>
				<td>
					<?php echo date('d/m/Y',strtotime($item->created_time));?>
				</td>
			</tr>
			<?php $i ++; ?>
		<?php } ?>
	<?php } ?>
		</tbody>
	</table>