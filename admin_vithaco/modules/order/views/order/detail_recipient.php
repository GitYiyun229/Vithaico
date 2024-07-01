<table cellspacing="0" cellpadding="6" width="100%" class="table table-striped">
    <tbody>
        <tr>
            <td><b>Họ tên</b></td>
            <td><?php echo @$order->recipients_name; ?></td>
        </tr>
        <tr>
            <td><b>Số điện thoại</b></td>
            <td><?php echo @$order->recipients_telephone; ?></td>
        </tr>
        <tr>
            <td><b>Email</b></td>
            <td><?php echo @$order->recipients_email; ?></td>
        </tr>
        <tr>
            <td><b>Địa chỉ</b></td>
            <td><?php echo "$order->recipients_address, $ward, $district, $province" ?></td>
        </tr>
        <tr>
            <td><b>Ghi chú</b></td>
            <td><?php echo @$order->recipients_comments; ?></td>
        </tr>
        <tr>
            <td><b>Thời gian mua</b></td>
            <td><?php echo @$order->created_time; ?></td>
        </tr>

        <?php if (@$order->com_name) { ?>
            <tr>
                <td><b>Xuất hóa đơn công ty</b></td>
                <td>Có</td>
            </tr>
            <tr>
                <td><b>Tên công ty</b></td>
                <td><?php echo @$order->com_name; ?></td>
            </tr>
            <tr>
                <td><b>Địa chỉ</b></td>
                <td><?php echo @$order->com_address; ?></td>
            </tr>
            <tr>
                <td><b>Mã số thuế</b></td>
                <td><?php echo @$order->com_tax; ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>