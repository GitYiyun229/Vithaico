<div class="table-responsive">
	<!-- TABLE 							-->
	<table class="table table-striped">
		<tbody>
		  <tr>
			<td width="173px"><b>T&#234;n ng&#432;&#7901;i &#273;&#7863;t h&#224;ng </b></td>
			<td width="5px">:</td>
			<td><?php echo $order-> sender_name; ?></td>
		  </tr>
		  <tr>
			<td><b>&#272;&#7883;a ch&#7881;  </b></td>
			<td width="5px">:</td>
			<td><?php echo $order-> sender_address; ?></td>
		  </tr>
		  <tr>
			<td><b>Email </b></td>
			<td width="5px">:</td>
			<td><?php echo $order-> sender_email; ?></td>
		  </tr>
		  <tr>
			<td><b>&#272;i&#7879;n tho&#7841;i </b></td>
			<td width="5px">:</td>
			<td><?php echo $order-> sender_telephone; ?></td>
		  </tr>
          <tr>
			<td><b><?php echo FSText::_('Ghi chú'); ?> </b></td>
			<td width="5px">:</td>
			<td><?php echo $order-> sender_comments; ?></td>
		  </tr>
		 </tbody>
	</table>
	<!-- ENd TABLE 							-->
		
</div>
