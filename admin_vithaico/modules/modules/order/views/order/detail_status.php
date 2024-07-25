<?php
$array_type = array(
    1   => FSText::_('Sử dụng thẻ ATM nội địa'),
    2   => FSText::_('Sử dụng thẻ Visa/Master card'),
    20  => FSText::_('Giao hàng - nhận tiền (COD)'),
    2950 => FSText::_('Chuyển khoản ngân hàng'),
    295 => FSText::_('Chuyển khoản ngân hàng qua cổng Bảo Kim'),
    297 => FSText::_('Thanh toán qua VNPAY-QR'),
    311 => FSText::_('Ví điện tử Momo'),
    316 => FSText::_('Ví điện tử ViettelPay'),
    500 => FSText::_('Thanh toán qua cổng Kredivo')

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
//var_dump($order->payment_method);
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

        <tr>
            <td>
                <div class="col-md-3">
                    <?php echo FSText::_('Hình thức thanh toán') ?>
                </div>
                <div class="col-md-9">
                    <strong class="red"><?php echo $array_type[$order->payment_method]; ?></strong>
                </div>
                <div class="clearfix"></div>
                <hr>
                <?php
                if ((@$order->payment_method != 20
                        || @$order->payment_method != 295
                        || @$order->payment_method != 21)
                    && @$order->payment_method != 500
                ) { ?>
                    <div class="col-md-3">
                        <?php echo FSText::_('Trạng thái thanh toán Bảo Kim') ?>
                    </div>
                    <div class="col-md-9">
                        <?php if ($order->status_bk == 1) { ?>
                            <p><b>Giao dịch thành công</b></p>
                        <?php } elseif ($order->status_bk == 2) { ?>
                            <p><b>Giao dịch thất bại</b></p>
                        <?php } elseif ($order->status_bk == 0
                            && $order->status_bk != null
                        ) { ?>
                            <p><b>Giao dịch đang xử lý</b></p>
                        <?php } ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="col-md-3">
                        <?php echo FSText::_('Mã giao dịch Bảo Kim') ?>
                    </div>
                    <div class="col-md-9">
                        <p><b><?= $order->reference_id ?></b></p>
                    </div>
                <?php } ?>

                <?php
                if (@$order->payment_method == 500) { ?>
                    <div class="col-md-3">
                        <?php echo FSText::_('Trạng thái thanh toán Kredivo') ?>
                    </div>
                    <div class="col-md-9">
                        <?php
                        switch ($order->status_kredivo_int) {
                            case 0:
                                echo '<p><b>Giao dịch khởi tạo</b></p>';
                                break;
                            case 1:
                                echo '<p><b>Giao dịch thành công</b></p>
                                        <a href="javascript:void(0)" onclick="cancel_order('.$order->id.')" style="color: red; display: inline-block">Hủy đơn hàng</a>';
                                break;
                            case 2:
                                echo '<p><b>Giao dịch đã bị Kredivo từ chối</b></p>';
                                break;
                            case 3:
                                echo '<p><b>Giao dịch đã hủy</b></p>';
                                break;
                            case 4:
                                echo '<p><b>Giao dịch quá thời gian</b></p>';
                                break;
                        }
                        ?>
                    </div>
                    <div class="clearfix"></div>
                    <hr>
                    <div class="col-md-3">
                        <?php echo FSText::_('Id giao dịch Kredivo') ?>
                    </div>
                    <div class="col-md-9">
                        <p><b><?= $order->transaction_id ?></b></p>
                    </div>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td>
                <div class="col-md-3">

                </div>
                <div class="col-md-9">
                    <!--                      <a class="btn btn-danger" style="color: #fff" href="javascript:void(0)" onclick="ghtk(<?= $id ?>)">
                            Tạo vận đơn</a>-->
                </div>
            </td>
        </tr>

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