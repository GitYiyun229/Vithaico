<table class="table table-striped">
    <tbody>
        <tr>
            <td><b>Trạng thái đơn hàng</b></td>
            <td>
                <select name="status" id="status" class="select2-temp">
                    <?php foreach ($this->status as $i => $item) { ?>
                        <option value="<?php echo $i ?>" <?php echo $i == $order->status ? 'selected' : '' ?>><?php echo $item ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>

        <tr>
            <td><b>Trạng thái thanh toán</b></td>
            <td><?php echo $this->paymentStatus[$order->payment_status] ?></td>
        </tr>

        <tr>
            <td><b>Hình thức thanh toán</b></td>
            <td><?php echo $this->paymentMethod[$order->payment_method] ?></td>
        </tr>

        <?php if ($order->user_id && $buyer) { ?>
            <tr>
                <td><b>Điểm tích lũy</b></td>
                <td><?php echo floor($order->total_before / 1000) ?></td>
            </tr>
        <?php } ?>
        <tr>
            <td><b>Lý do hủy</b></td>
            <td>
                <textarea class="form-control" name="cancel_reason" id="cancel_reason" rows="3"><?php echo $order->cancel_reason ?></textarea>
            </td>
        </tr>
    </tbody>
</table>

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