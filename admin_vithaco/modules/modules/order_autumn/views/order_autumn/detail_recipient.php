<div class="form_user_head_c"></div>
<div class="form_user_footer_body">
    <!-- TABLE 							-->
    <!--	RECIPIENCE INFO				-->
    <table cellspacing="0" cellpadding="6" border="0" width="100%" class="table table-striped">
        <tbody>
        <tr>
            <td width="173px"><b>Tên người mua hàng </b></td>
            <td width="5px">:</td>
            <td><?php echo @$order->sender_name; ?></td>
        </tr>
<!--        --><?php //if ($order->method != 1) { ?>
<!--            <tr>-->
<!--                --><?php //if ($order->shipping == 1) { ?>
<!--                    <td><b>&#272;&#7883;a ch&#7881; </b></td>-->
<!--                    <td width="5px">:</td>-->
<!--                    <td>--><?php //echo $order->address_detail ?><!--</td>-->
<!--                --><?php //} else { ?>
<!--                    <td><b>Nhận tại cửa hàng </b></td>-->
<!--                    <td width="5px">:</td>-->
<!--                    <td>--><?php //echo $order->address_detail ?><!--</td>-->
<!--                --><?php //} ?>
<!--            </tr>-->
<!--        --><?php //} ?>
        <tr>
            <td><b>&#272;i&#7879;n tho&#7841;i </b></td>
            <td width="5px">:</td>
            <td><?php echo @$order->sender_telephone; ?></td>
        </tr>
<!--        <tr>-->
<!--            <td><b>Email </b></td>-->
<!--            <td width="5px">:</td>-->
<!--            <td>--><?php //echo @$order->email; ?><!--</td>-->
<!--        </tr>-->
<!--        --><?php //if ($order->method == 1) { ?>
<!--            <tr>-->
<!--                <td><b>Ngày sinh </b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo date('d/m/Y',strtotime($order->date_cus)); ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td><b>Số CMND/CCCD </b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo @$order->cmnd; ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td><b>Địa chỉ hộ khẩu </b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo @$order->household; ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td><b>Lãi suất</b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo @$order->interest_rate.'%'; ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td><b>Bảo hiểm</b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo @$order->insurance_included=='true'?'Có':'Không'; ?><!--</td>-->
<!--            </tr>-->
<!---->
<!--            <tr>-->
<!--                <td><b>Trả trước(--><?//=$order->percentage.'%'?><!--)</b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo format_money_0($order->prepaid,'đ','liên hệ'); ?><!--</td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td><b>Góp mỗi tháng(--><?//=$order->month_in.' Tháng'?><!--)</b></td>-->
<!--                <td width="5px">:</td>-->
<!--                <td>--><?php //echo format_money_0($order->monthly,'đ','liên hệ'); ?><!--</td>-->
<!--            </tr>-->
<!--        --><?php //} ?>
<!--        <tr>-->
<!--            <td><b>--><?php //echo FSText::_('Ghi chú'); ?><!-- </b></td>-->
<!--            <td width="5px">:</td>-->
<!--            <td>--><?php //echo $order->note; ?><!--</td>-->
<!--        </tr>-->
        <tr>
            <td width="173px"><b>Thời gian mua</b></td>
            <td width="5px">:</td>
            <td><?php echo @$order->created_time; ?></td>
        </tr>
        <tr><!--
			  <tr>
				<td width="173px"><b>Địa điểm nhận hàng</b></td>
				<td width="5px">:</td>
				<td><?php if (@$order->here = '1') {
                echo "Nhận tại nhà hàng";
            } else {
                echo "Nhận tại địa chỉ người nhận";
            } ?></td>
			  </tr>
			  <tr>
				<td width="173px"><b>Phương thức mua hàng: </b></td>
				<td width="5px">:</td>
				<td><?php if (@$order->pay_method = '0') {
                echo "Thanh toán trực tiếp";
            } else {
                echo "Thanh toán thông qua address";
            } ?></td>
			  </tr>
			 -->
        </tbody>
    </table>
    <!-- ENd TABLE 							-->

</div>
