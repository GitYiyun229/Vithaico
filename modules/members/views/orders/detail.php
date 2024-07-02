<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('orders', 'modules/members/assets/css');

$tmpl->addScript('orders', 'modules/members/assets/js');
?>

<div class="container">
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Chi tiết đơn hàng') ?> #<?php echo str_pad($order->id, 8, 0, STR_PAD_LEFT) ?></div>
            <div class="page-content page-orders-detail">
                <div class="page-border-radius bg-white p-4 mb-3 d-flex align-items-center justify-content-between">
                    <a onclick="history.back()" class="d-flex align-items-center gap-1 text-grey">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.0002 13.28L5.65355 8.93333C5.14022 8.42 5.14022 7.58 5.65355 7.06667L10.0002 2.72" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Quay lại
                    </a>
                    <div class="d-flex align-items-center gap-3">
                        <?php if ($order->status == 2) { ?>
                            <div><span class="text-grey">Điểm tích lũy:</span> <b><?php echo floor($order->total_before / 1000) ?></b></div>
                            <div class="text-grey">|</div>
                        <?php } ?>
                        <div class="text-grey"><?php echo date('H:i d/m/Y', strtotime($order->created_time)) ?></div>
                        <div class="text-grey">|</div>
                        <div class="text-red text-uppercase fw-medium"><?php echo $this->status[$order->status] ?></div>
                    </div>
                </div>

                <div class="section-grid d-grid mb-3 gap-3">
                    <div class="page-border-radius bg-white p-4">
                        <div class="text-grey text-uppercase mb-3">Thông tin nhận hàng</div>
                        <div class="mb-1"><?php echo $order->recipients_name ?></div>
                        <div class="mb-1"><?php echo $order->recipients_telephone ?></div>
                        <div><?php echo "$order->recipients_address, $ward, $district, $province" ?></div>
                    </div>
                    <div class="page-border-radius bg-white p-4">
                        <div class="text-grey text-uppercase mb-3">Hình thức thanh toán</div>
                        <div class="mb-2"><?php echo $this->paymentMethod[$order->payment_method] ?></div>
                        <div class="<?php echo $order->payment_status == 1 ? 'text-success' : 'text-error' ?>"><?php echo $this->paymentStatus[$order->payment_status] ?></div>
                    </div>
                    <div class="page-border-radius bg-white p-4">
                        <div class="text-grey text-uppercase mb-3">Vận chuyển & ghi chú</div>
                        <div class="mb-1">Giao hàng nhanh</div>
                        <div class="mb-3">GA3KY8BY</div>
                        <div><?php echo $order->recipients_comments ?></div>
                    </div>
                </div>

                <div class="table-container">
                    <table class="table table-hover table-detail">
                        <thead>
                            <tr>
                                <th class="text-uppercase fw-normal">Sản phẩm</th>
                                <th class="text-uppercase fw-normal">Đơn giá</th>
                                <th class="text-uppercase fw-normal text-center">Số lượng</th>
                                <th class="text-uppercase fw-normal text-end">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($detail as $item) {
                                $link = FSRoute::_("index.php?module=products&view=product&code=" . $item->productInfo->alias . "&id=" . $item->productInfo->id);
                                $img = @$item->subInfo->image ? URL_ROOT . image_replace_webp($item->subInfo->image, 'resized') : URL_ROOT . image_replace_webp($item->productInfo->image, 'resized');
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo $link ?>">
                                            <img src="<?php echo $img ?>" alt="<?php echo $item->productInfo->name ?>" class="img-fluid">
                                            <div>
                                                <div class="fw-medium"><?php echo $item->productInfo->name ?></div>
                                                <div class="text-grey"><?php echo @$item->subInfo->name ?></div>
                                            </div>                                           
                                        </a>
                                    </td>
                                    <td class="fw-medium">
                                        <div><?php echo format_money($item->price) ?></div>
                                        <?php if ($item->price_old > $item->price) { ?>
                                            <div><del class="text-grey"><?php echo format_money($item->price_old) ?></del></div>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center fw-medium">
                                        <?php echo $item->count ?>
                                    </td>
                                    <td class="text-end fw-medium">
                                        <?php echo format_money($item->total) ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="p-4 section-total">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-grey">Tạm tính</div>
                        <div class="fw-medium"><?php echo format_money($order->total_before) ?></div>
                    </div>
                    <?php if ($order->promotion_discount_price) { ?>
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <div class="text-grey">Chiết khấu/ Flashsale</div>
                            <div class="fw-medium"><?php echo format_money($order->promotion_discount_price) ?></div>
                        </div>
                    <?php } ?>    
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-grey">Mã giảm giá/ Thẻ quà tặng</div>
                        <div class="fw-medium"><?php echo format_money($order->code_discount_price, '', '₫0') ?></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="text-grey">Hạng thành viên</div>
                        <div class="fw-medium"><?php echo format_money($order->member_discount_price, '', '₫0') ?></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4 border-bottom pb-4">
                        <div class="text-grey">Phí giao hàng</div>
                        <div class="fw-medium"><?php echo format_money($order->ship_price, '', 'Miễn phí') ?></div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="text-grey fw-medium">Tổng thanh toán</div>
                        <div class="fw-bold fs-5"><?php echo format_money($order->total_end) ?></div>
                    </div>
                </div>

                <?php if ($order->status == 3) { ?>
                    <div class="page-border-radius bg-white p-4 mt-3 section-cancel d-flex align-items-center justify-content-between gap-3">
                        <div class="text-grey text-nowrap">Lý do hủy</div>
                        <div class="fw-medium text-end"><?php echo $order->cancel_reason ?></div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
