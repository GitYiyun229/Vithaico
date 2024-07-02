<?php
$array_type = array(
    1 => FSText::_('Giao hàng - nhận tiền (COD)'),
    2 => FSText::_('Chuyển khoản ngân hàng'),
    3 => FSText::_('Quẹt QR Thanh Toán (VNPAY-QR)')
);
$postStatus = array(
    0 => FSText::_('Chưa xử lý'),
    1 => FSText::_('Đã nhận đơn'),
    2 => FSText::_('Đang chờ xin hàng'),
    3 => FSText::_('Đang chờ chuyển hàng'),
    4 => FSText::_('Đã chuyển hàng'),
    5 => FSText::_('Thành công'),
    6 => FSText::_('Hủy đơn hàng')
);
//var_dump($order);
$id = FSInput::get('id');
?>
<div class="table-responsive" style="min-height: 350px">

    <table class="table table-striped">
        <tbody>
        <tr>
            <td>
                <?php
                TemplateHelper::dt_edit_selectbox(FSText::_('Trạng thái đơn hàng'), 'status', @$order->status, 0, $postStatus, $field_value = 'id', $field_label = 'title', $size = 1, 0, 1); ?>
            </td>
        </tr>
        <!--        <tr>-->
        <!--            <td>-->
        <!--                --><?php //echo FSText::_('Ghi chú') ?>
        <!--            </td>-->
        <!--            <td>-->
        <!--                --><?php
        //                TemplateHelper::dt_edit_text(FSText:: _('Ghi chú'), 'note_adc', @$order->note_adc, '', '', 5);
        //                ?>
        <!--            </td>-->

        <!--        </tr>-->

        <!--		  --><?php //if(!$order->status  ){?>
        <!--			<tr>-->
        <!--				<td>Hủy đơn hàng: </td>-->
        <!--				<td>-->
        <!--					Bạn hãy click vào <a href="javascript: cancel_order(-->
        <?php //echo $order ->id; ?><!--)" ><strong class='red'> đây</strong></a> nếu bạn muốn <strong> hủy đơn hàng </strong>này-->
        <!--					<br/>-->
        <!--						Chú ý: nếu bạn hủy đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho họ-->
        <!--				</td>-->
        <!--		  </tr>			  	-->
        <!--		  --><?php //}?>
        <!--		 --><?php //if($order->status < 1 || !$order->status  ){?>
        <!--		 	<tr>-->
        <!--				<td>Hoàn tất đơn hàng: </td>-->
        <!--				<td>-->
        <!--					Bạn hãy click vào <a href="javascript: finished_order(-->
        <?php //echo $order ->id; ?><!--)" ><strong class='red'> đây</strong></a> để <strong> hoàn tất</strong> đơn hàng này-->
        <!--					<br/>-->
        <!--						Chú ý: nếu bạn hoàn tất đơn hàng mà khách hàng đã thanh toán thì hệ thống sẽ trả lại tiền cho gian hàng-->
        <!--				</td>-->
        <!--		  </tr>-->
        <!--		 --><?php //}?>
        <tr>
            <td>
                <div class="col-md-3">
                    <?php echo FSText::_('Hình thức thanh toán') ?>
                </div>
                <div class="col-md-9">
                    <?php if ($order->method != 1) { ?>
                        <strong class="red"><?php echo "Trả góp qua cổng thanh toán Bảo Kim"; ?></strong>
                    <?php } else { ?>
                        <strong class="red"><?php echo "Trả góp qua công ty tài chính " . $order->company_name; ?></strong>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
                <hr>
                <!--                --><?php //if (@$order->ord_payment_type == 3) { ?>
                <?php if ($order->method != 1) { ?>

                    <div class="col-md-3">
                        <?php echo FSText::_('Trạng thái thanh toán Bảo Kim') ?>
                    </div>
                    <div class="col-md-9">
                        <?php if ($order->status_bk == 1) { ?>
                            <p><b>Giao dịch thành công</b></p>
                        <?php } elseif ($order->status_bk == 2) { ?>
                            <p><b>Giao dịch thất vại</b></p>
                        <?php } elseif ($order->status_bk == 0 && $order->status_bk != null) { ?>
                            <p><b>Giao dịch đang xử lý</b></p>
                        <?php } ?>
                    </div>
                <?php } ?>

                <!--                --><?php //} ?>

            </td>
        </tr>
        <!--        <tr>-->
        <!--            <td>-->
        <!--                <div class="col-md-3">-->
        <!---->
        <!--                </div>-->
        <!--                <div class="col-md-9">-->
        <!--                    <!--                      <a class="btn btn-danger" style="color: #fff" href="javascript:void(0)" onclick="ghtk(-->
        <? //= $id ?><!--)">-->
        <!--                            Tạo vận đơn</a>-->
        <!--                </div>-->
        <!--            </td>-->
        <!--        </tr>-->

        </tbody>
    </table>
    <!-- ENd TABLE 							-->

</div>
<script>

    function cancel_order(order_id) {
        if (confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')) {
            window.location = 'index.php?module=order&view=order&id=' + order_id + '&task=cancel_order';
        }
    }

    function finished_order(order_id) {
        if (confirm('Bạn có chắc chắn muốn hoàn tất đơn hàng này?')) {
            window.location = 'index.php?module=order&view=order&id=' + order_id + '&task=finished_order';
        }
    }

    function pay_penalty(order_id) {
        if (confirm('Bạn có chắc chắn đã phạt thành viên này?')) {
            window.location = 'index.php?module=order&view=order&id=' + order_id + '&task=pay_penalty';
        }
    }

    function pay_compensation(order_id) {
        if (confirm('Bạn có chắc chắn đã bồi thường cho thành viên này?')) {
            window.location = 'index.php?module=order&view=order&id=' + order_id + '&task=pay_compensation';
        }
    }

    function ghtk(order_id) {
        if (confirm('Bạn có chắc chắn muốn tạo vận đơn?')) {
            window.location = 'index.php?module=order&view=order&id=' + order_id + '&task=ghtk';
        }
    }


</script>