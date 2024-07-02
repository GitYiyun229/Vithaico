<?php
$tmpl->addStylesheet('success', 'modules/products/assets/css');
?>

<div class="section-order-success">
    <div class="container">
        <div class="section-item p-4 bg-white = mb-3 text-center section-header">
            <h1 class="text-uppercase fw-bold fs-4 mb-3"><?php echo FSText::_('Đặt hàng thành công') ?></h1>
            <p class="mb-3 text-grey"><?php echo FSText::_('Trên thị trường có quá nhiều sự lựa chọn, cảm ơn bạn đã lựa chọn mua sắm tại') ?> <b>Vuabanlo</b>.</p>
            <p class="mb-1 text-grey"><?php echo FSText::_('Đơn hàng của bạn CHẮC CHẮN đã được chuyển tới hệ thống xử lý đơn hàng của Vuabanlo.') ?></p>
            <p class="mb-3 text-grey"><?php echo FSText::_('Trong quá trình xử lý Vuabanlo sẽ liên hệ lại nếu như cần thêm thông tin từ bạn. Ngoài ra Vuabanlo cũng sẽ có gửi xác nhận đơn hàng bằng Email và tin nhắn') ?></p>

            <a href="<?php echo URL_ROOT ?>" title="<?php echo FSText::_('Khám phá thêm các sản phẩm khác') ?>"><?php echo FSText::_('Khám phá thêm các sản phẩm khác') ?></a>
        </div>

        <div class="section-item p-4 bg-white mb-3 section-body">
            <h2 class="fw-medium fs-4 mb-3 text-center"><?php echo FSText::_('Thông tin đơn hàng') ?></h2>
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="order-id text-uppercase fw-semibold"><?php echo FSText::_('Đơn hàng') . ' #' . $orderID ?></div>
                <div class="text-grey"><?php echo date('H:i d/m/Y', strtotime($order['created_time'])) ?></div>
            </div>
            <div class="mb-3 table-container">
                <table class="table table-hover mb-0 table-order">
                    <thead>
                        <tr>
                            <th><?php echo FSText::_('Sản phẩm') ?></th>
                            <th class="text-center"><?php echo FSText::_('Đơn giá') ?></th>
                            <th class="text-center"><?php echo FSText::_('Số lượng') ?></th>
                            <th class="text-end"><?php echo FSText::_('Thành tiền') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item) { ?>
                            <tr>
                                <td>
                                    <div class="d-flex gap-3">
                                        <a href="<?php echo $item['url'] ?>">
                                            <img src="<?php echo $item['image'] ?>" alt="<?php echo $item['product_name'] ?>" class="img-fluid">
                                        </a>
                                        <div>
                                            <a href="<?php echo $item['url'] ?>"><?php echo $item['product_name'] ?></a>
                                            <div class="text-grey mt-1"><?php echo @$item['sub_name'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php echo format_money($item['price']) ?>
                                </td>
                                <td class="text-center">
                                    <?php echo $item['quantity'] ?>
                                </td>
                                <td class="text-end">
                                    <?php echo format_money($item['price'] * $item['quantity']) ?>
                                </td>
                            </tr>
                        <?php } ?>    
                        <tr>
                            <td colspan="3" class="text-grey"><?php echo FSText::_('Tạm tính') ?></td>
                            <td class="text-end fw-bold text-end"><?php echo format_money($order['total_before']) ?></td>
                        </tr>
                        <?php if ($promotionDiscountPrice) { ?>
                            <tr>
                                <td colspan="3" class="text-grey"><?php echo FSText::_('Chiết khấu/ Flashsale') ?></td>
                                <td class="text-end fw-bold text-end"><?php echo format_money($promotionDiscountPrice) ?></td>
                            </tr>
                        <?php } ?>    
                        <tr>
                            <td colspan="3" class="text-grey"><?php echo FSText::_('Mã giảm giá/ Thẻ quà tặng') ?></td>
                            <td class="text-end fw-bold text-end">- <?php echo format_money($order['code_discount_price'], '', '₫0') ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-grey"><?php echo FSText::_('Hạng thành viên') ?></td>
                            <td class="text-end fw-bold text-end">- <?php echo format_money($order['member_discount_price'], '', '₫0') ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-grey"><?php echo FSText::_('Phí giao hàng') ?></td>
                            <td class="text-end fw-bold text-end"><?php echo format_money($order['ship_price'], '', FSText::_('Miễn phí')) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="fw-bold"><?php echo FSText::_('Tổng thanh toán') ?></td>
                            <td class="fw-bold fs-5 text-end"><?php echo format_money($order['total_end']) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center"><span class="text-grey"><?php echo FSText::_('* Ghi chú:') ?></span> <?php echo $order['recipients_comments'] ?></div>
        </div>

        <div class="section-item p-4 bg-white mb-3 section-footer">
            <h2 class="fw-medium fs-4 mb-3 text-center"><?php echo FSText::_('Thông tin nhận hàng') ?></h2>
            <div class="d-flex gap-3 flex-wrap">
                <div class="d-flex w-100">
                    <div class="col-3">
                        <?php echo FSText::_('Tên người nhận') ?>
                    </div>
                    <div class="col-9">
                        <?php echo $order['recipients_name'] ?>
                    </div>
                </div>
                <div class="d-flex w-100">
                    <div class="col-3">
                        <?php echo FSText::_('Email') ?>
                    </div>
                    <div class="col-9">
                        <?php echo $order['recipients_email'] ?>
                    </div>
                </div>
                <div class="d-flex w-100">
                    <div class="col-3">
                        <?php echo FSText::_('Số điện thoại') ?>
                    </div>
                    <div class="col-9">
                        <?php echo $order['recipients_telephone'] ?>
                    </div>
                </div>
                <div class="d-flex w-100">
                    <div class="col-3">
                        <?php echo FSText::_('Hình thức thanh toán') ?>
                    </div>
                    <div class="col-9">
                        Thanh toán tiền mặt khi nhận hàng
                    </div>
                </div>
                <div class="d-flex w-100">
                    <div class="col-3">
                        <?php echo FSText::_('Địa chỉ nhận hàng') ?>
                    </div>
                    <div class="col-9">
                        <?php echo $order['recipients_address'] ? $order['recipients_address'] . ',' : '' ?> <?php echo $ward->name ?>, <?php echo $district->name ?>, <?php echo $province->name ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>