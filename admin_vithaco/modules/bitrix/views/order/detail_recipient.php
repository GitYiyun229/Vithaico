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
        <tr>
            <?php if ($order->shipping == 1) { ?>
                <td><b>&#272;&#7883;a ch&#7881; </b></td>
                <td width="5px">:</td>
                <td><?php echo $order->sender_address ?>
                    , <?php echo $order->ward_name ?>
                    , <?php echo $order->district_name . ', ' . $order->city_name ?></td>
            <?php } else { ?>
                <td><b>Nhận tại cửa hàng </b></td>
                <td width="5px">:</td>
                <td><?php echo $store->name ?></td>
            <?php } ?>
        </tr>
        <tr>
            <td><b>&#272;i&#7879;n tho&#7841;i </b></td>
            <td width="5px">:</td>
            <td><?php echo @$order->sender_telephone; ?></td>
        </tr>

        <tr>
            <td><b><?php echo FSText::_('Ghi chú'); ?> </b></td>
            <td width="5px">:</td>
            <td><?php echo $order->sender_comments; ?></td>
        </tr>
        <tr>
            <td><b><?php echo FSText::_('Chuyển danh bạ, dữ liệu qua máy mới'); ?> </b></td>
            <td width="5px">:</td>
            <td><?php echo $order->update_data==1?'Có':''; ?></td>
        </tr>
        <!--			  <tr>-->
        <!--				<td><b>Gi&#7899;i t&#237;nh </b></td>-->
        <!--				<td width="5px">:</td>-->
        <!--				<td>--><?php //echo (@$order->recipients_sex == 'female')? "Nữ":"Nam"; ?>
        <!--				</td>-->
        <!--			  </tr>-->
        <tr>
            <td width="173px"><b>Thời gian mua</b></td>
            <td width="5px">:</td>
            <td><?php echo @$order->created_time; ?></td>
        </tr>
        <?php if ($order->com_name) { ?>
            <tr>
                <td width="173px"><b>Xuất hóa đơn công ty</b></td>
                <td width="5px">:</td>
                <td>Có</td>
            </tr>
            <tr>
                <td width="173px"><b>Tên công ty</b></td>
                <td width="5px">:</td>
                <td><?php echo @$order->com_name; ?></td>
            </tr>
            <tr>
                <td width="173px"><b>Địa chỉ</b></td>
                <td width="5px">:</td>
                <td><?php echo @$order->com_address; ?></td>
            </tr>
            <tr>
                <td width="173px"><b>Mã số thuế</b></td>
                <td width="5px">:</td>
                <td><?php echo @$order->com_tax; ?></td>
            </tr>
        <?php } ?>
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
