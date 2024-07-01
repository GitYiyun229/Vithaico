<div class="table-responsive">
    <!-- TABLE 							-->
    <table class="table table-striped">
        <tbody>
        <tr>
            <td width="173px"><b>Tên người nhận hàng </b></td>
            <td width="5px">:</td>
            <td><?php echo $order->re_name ? $order->re_name : $order->sender_name; ?></td>
        </tr>
        <tr>
            <?php if ($order->shipping == 1) { ?>
                <td><b>&#272;&#7883;a ch&#7881; </b></td>
                <td width="5px">:</td>
                <td><?php echo $order->sender_address ?>
                    , <?php echo $order->ward_name ?>, <?php echo $order->district_name . ', ' . $order->city_name ?></td>
            <?php } else { ?>
                <td><b>Nhận tại cửa hàng </b></td>
                <td width="5px">:</td>
                <td><?php echo $store->name ?></td>
            <?php } ?>
        </tr>
        <!--		  <tr>-->
        <!--			<td><b>Email </b></td>-->
        <!--			<td width="5px">:</td>-->
        <!--			<td>--><?php //echo $order-> sender_email; ?><!--</td>-->
        <!--		  </tr>-->
        <tr>
            <td><b>&#272;i&#7879;n tho&#7841;i </b></td>
            <td width="5px">:</td>
            <td><?php echo $order->re_telephone?$order->re_telephone:$order->sender_telephone; ?></td>
        </tr>
        <tr>
            <td><b><?php echo FSText::_('Ghi chú'); ?> </b></td>
            <td width="5px">:</td>
            <td><?php echo $order->sender_comments; ?></td>
        </tr>
        </tbody>
    </table>
    <!-- ENd TABLE 							-->

</div>
