<div class="form_user_head_c"></div>
<div class="form_user_footer_body">
	<!-- TABLE 							-->
	<!--	RECIPIENCE INFO				-->
	<table cellspacing="0" cellpadding="6" border="0" width="100%" class="table table-striped">
		<tbody>
			<tr>
				<td width="173px"><b>Tên người đăng kí </b></td>
				<td width="5px">:</td>
				<td><?php echo @$agency->name; ?></td>
			</tr>
			<tr>
				<td><b>&#272;&#7883;a ch&#7881; </b></td>
				<td width="5px">:</td>
				<td><?php echo @$agency->address ?></td>
			</tr>
			<tr>
				<td><b>Email </b></td>
				<td width="5px">:</td>
				<td><?php echo @$agency->email; ?></td>
			</tr>
			<tr>
				<td><b>&#272;i&#7879;n tho&#7841;i </b></td>
				<td width="5px">:</td>
				<td><?php echo @$agency->phone; ?></td>
			</tr>
			<tr>
				<td width="173px"><b>Thời gian đăng kí</b></td>
				<td width="5px">:</td>
				<td><?php echo @$agency->created_time; ?></td>
			</tr>
		</tbody>
	</table>
	<!-- ENd TABLE 							-->

</div>