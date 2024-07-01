<?php 
    $array_type = array( 
                        1 => FSText::_('Mua hàng trực tiếp - thanh toán tại cửa hàng'),
                        2 => FSText::_('Giao hàng - nhận tiền (COD)'),
                        3=> FSText::_('Chuyển khoản ngân hàng (click vào để hiện danh sách tài khoản)')
                    );
 ?>
<div class="table-responsive">
	<!-- TABLE 							-->
	<!--	RECIPIENCE INFO				-->
	<table class="table table-striped">
		<tbody> 
		  <tr>
			<td><?php echo FSText::_('Trạng thái đơn hàng') ?></td>
			<td>
				<strong class = "red"><?php echo $this -> showStatus($order->status )?></strong>
			</td>
		  </tr>
		  <?php if(!$order->status  ){?>
			<tr>
				<td>Hủy đơn hàng: </td>
				<td>
					Bạn hãy click vào <a href="javascript: cancel_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> nếu bạn muốn <strong> hủy đơn hàng </strong>này
					<br/>
<!--						Chú ý: nếu bạn hủy đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho họ-->
				</td>
		  </tr>			  	
		  <?php }?>
		 <?php if($order->status < 1 || !$order->status  ){?>
		 	<tr>
				<td>Hoàn tất đơn hàng: </td>
				<td>
					Bạn hãy click vào <a href="javascript: finished_order(<?php echo $order ->id; ?>)" ><strong class='red'> đây</strong></a> để <strong> hoàn tất</strong> đơn hàng này
					<br/>
<!--						Chú ý: nếu bạn hoàn tất đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho gian hàng-->
				</td>
		  </tr>
		 <?php }?>
         <tr>
			<td><?php echo FSText::_('Hình thức thanh toán') ?></td>
			<td>
				<strong class = "red"><?php echo $array_type[$order->ord_payment_type]; ?></strong>
			</td>
		  </tr>
		 </tbody>
	</table>
	<!-- ENd TABLE 							-->
		
</div>
<script>
	function cancel_order(order_id){
		if(confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=cancel_order';
		}
	}
	function finished_order(order_id){
		if(confirm('Bạn có chắc chắn muốn hoàn tất đơn hàng này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=finished_order';
		}
	}
	function pay_penalty(order_id){
		if(confirm('Bạn có chắc chắn đã phạt thành viên này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=pay_penalty';
		}
	}
	function pay_compensation(order_id){
		if(confirm('Bạn có chắc chắn đã bồi thường cho thành viên này?')){
			window.location='index.php?module=order&view=order&id='+order_id+'&task=pay_compensation';
		}
	}
	
</script>