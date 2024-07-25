<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('orders', 'modules/members/assets/css');
$tmpl->addScript('orders', 'modules/members/assets/js');

$titleRate = [
    1 => 'Tệ',
    2 => 'Không hài lòng',
    3 => 'Bình thường',
    4 => 'Hài lòng',
    5 => 'Tuyệt vời',
];
?>

<div class="container">
    <div class="mb-3">
        <?php include PATH_BASE . 'modules/members/views/level.php' ?>
    </div>
    <div class="page-member">

        <div class="page-side">
            <div class="page-sidebar  p-4 pb-2">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-content page-orders">
                <div class="page-top bg-white">

                    <div class="page-title fs-5 fw-bold text-uppercase"><?php echo FSText::_('Lịch sử giao dịch') ?></div>
                    <div class="page-border-radius  mb-3 order-status d-flex align-items-center">

                        <a href="" class="fs-6 fw-medium status-filter active" status="all">Tất cả</a>
                        <?php foreach ($this->status as $i => $item) { ?>
                            <a href="" class="fs-6 fw-medium status-filter" status="<?php echo $i ?>"><?php echo $item ?></a>
                        <?php } ?>
                    </div>
                </div>


                <?php foreach ($list as $item) {
                ?>
                    <div class="item-order mb-3" status="<?php echo $item->status ?>">
                        <div class="item-header page-border-radius bg-white d-flex align-items-center justify-content-between">
                            <div class="fw-medium fs-6 fw-bold">#<?php echo str_pad($item->id, 8, 0, STR_PAD_LEFT) ?></div>

                            <div class="d-flex align-items-center gap-3">
                                <div><span>Mua hàng</span></div>
                                <div class="text-grey">|</div>
                                <div>+<b><?php echo floor($item->member_coin) ?></b><span class="text-grey"> VT-Coin:</span></div>
                                <div class="text-grey">|</div>
                                <div class="text-grey"><?php echo date('H:i d/m/Y', strtotime($item->created_time)) ?></div>
                                <div class="text-grey">|</div>
                                <div class="text-red text-uppercase fw-medium"><?php echo $this->status[$item->status] ?></div>
                            </div>
                        </div>
                        <div class="item-body page-border-radius bg-white">
                            <?php foreach ($item->orderDetail as $detail) {
                                $link = FSRoute::_("index.php?module=products&view=product&code=" . $detail->productInfo->alias . "&id=" . $detail->productInfo->id);
                                $img = @$detail->subInfo->image ? URL_ROOT . image_replace_webp($detail->subInfo->image, 'resized') : URL_ROOT . image_replace_webp($detail->productInfo->image, 'resized');
                            ?>
                                <div class="item-order-detail">
                                    <a href="<?php echo $link ?>">
                                        <img src="<?php echo $img ?>" alt="<?php echo $detail->productInfo->name ?>" class="img-fluid">
                                    </a>
                                    <div class="d-flex align-items-center justify-content-between">
                                        <a href="<?php echo $link ?>">
                                            <?php echo $detail->productInfo->name ?>
                                        </a>
                                        <div class="text-grey">SL: x<?php echo $detail->count ?></div>
                                        <div>
                                            <span class="fw-medium"><?php echo format_money($detail->productInfo->price_discount) ?>/<?php echo $detail->count * $detail->productInfo->coin ?>VT-Coin</span>
                                            <span class="ms-3"></span>
                                        </div>
                                        <div>
                                            <span class="fw-medium"><?php echo format_money($detail->count * $detail->productInfo->price_discount) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="item-footer page-border-radius d-flex align-items-center justify-content-between gap-2 flex-row-reverse">
                            <div class="d-flex align-items-center gap-3">
                                <div class="title">Tổng thanh toán</div>
                                <div class="fs-5 fw-bold"><?php echo format_money($item->total_end) ?></div>
                            </div>
                            <a class="btn-detail" href="<?php echo FSRoute::_("index.php?module=members&view=orders&task=detail&id=$item->id") ?>">
                                Xem chi tiết
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php foreach ($list as $item) { ?>
    <?php foreach ($item->orderDetail as $detail) {
        $link = FSRoute::_("index.php?module=products&view=product&code=" . $detail->productInfo->alias . "&id=" . $detail->productInfo->id);
        $img = @$detail->subInfo->image ? URL_ROOT . image_replace_webp($detail->subInfo->image, 'resized') : URL_ROOT . image_replace_webp($detail->productInfo->image, 'resized');
    ?>
        <?php if ($item->status == 2) { ?>
            <div class="modal modal-order-complete modal-check-coverage fade" id="modalCheckCoverage<?php echo $detail->id ?>" tabindex="-1" aria-labelledby="modalCheckCoverage<?php echo $detail->id ?>Label" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <p class="mb-4 fs-4">Thông tin bảo hành sản phẩm</p>
                            <a href="<?php echo $link ?>" class="mb-4 modal-product">
                                <img src="<?php echo $img ?>" alt="<?php echo $detail->productInfo->name ?>" class="img-fluid">
                                <div>
                                    <div><?php echo $detail->productInfo->name ?></div>
                                    <div class="text-grey"><?php echo @$detail->subInfo->name ?></div>
                                </div>
                            </a>

                            <table class="table text-center">
                                <tr>
                                    <td>NGÀY MUA</td>
                                    <td>HẠN BẢO HÀNH</td>
                                </tr>
                                <tr class="fw-medium">
                                    <td><?php echo date('d/m/Y', strtotime($item->created_time)) ?></td>
                                    <td><?php echo date('d/m/Y', strtotime($item->created_time)) ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($detail->rate || (time() - strtotime($item->created_time) <= $this->dateAllowRate)) { ?>
                <div class="modal modal-order-complete modal-rate fade" id="modalRate<?php echo $detail->id ?>" tabindex="-1" aria-labelledby="modalRate<?php echo $detail->id ?>Label" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                <p class="mb-4 fs-4">Đánh giá sản phẩm</p>
                                <a href="<?php echo $link ?>" class="mb-4 modal-product">
                                    <img src="<?php echo $img ?>" alt="<?php echo $detail->productInfo->name ?>" class="img-fluid" accept=".png, .jpg, .jpeg">
                                    <div>
                                        <div><?php echo $detail->productInfo->name ?></div>
                                        <div class="text-grey"><?php echo @$detail->subInfo->name ?></div>
                                    </div>
                                </a>

                                <form action="" method="POST" enctype="multipart/form-data">
                                    <div class="review-rate d-flex align-items-center justify-content-between gap-2 mb-3 position-relative">
                                        <div class="review-title"><?php echo $detail->rate ? '<soan class="fw-medium text-red">' . $titleRate[$detail->rate] . '</soan>' : 'Đánh giá:' ?></div>
                                        <?php if ($detail->rate) { ?>
                                            <div class="star-rating fs-4" style="--rating: <?php echo $detail->rate ?>;"></div>
                                        <?php } else { ?>
                                            <div class="review-rating d-flex align-items-center fs-4">
                                                <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                    <div class="review-rating-item" value="<?php echo $i ?>">
                                                        <i class="fa-solid fa-star"></i>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <?php if ($detail->rate) { ?>
                                        <div class="list-image-review d-flex align-items-center gap-2 mb-4">
                                            <?php foreach ($detail->rateInfo->image as $imageRate) { ?>
                                                <img src="<?php echo URL_ROOT . image_replace_webp($imageRate->image, 'resized') ?>" alt="" class="img-fluid">
                                            <?php } ?>
                                        </div>
                                    <?php } else { ?>
                                        <div class="d-flex align-items-center flex-wrap gap-2 mb-4">
                                            <div class="list-image-review d-flex align-items-center gap-2"></div>
                                            <a href="" class="submit-image d-flex align-items-center justify-content-center gap-2">
                                                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.0002 8H14.0002M7.26017 22H17.7402C20.5002 22 21.6002 20.31 21.7302 18.25L22.2502 9.99C22.3902 7.83 20.6702 6 18.5002 6C17.8902 6 17.3302 5.65 17.0502 5.11L16.3302 3.66C15.8702 2.75 14.6702 2 13.6502 2H11.3602C10.3302 2 9.13017 2.75 8.67017 3.66L7.95017 5.11C7.67017 5.65 7.11017 6 6.50017 6C4.33017 6 2.61017 7.83 2.75017 9.99L3.27017 18.25C3.39017 20.31 4.50017 22 7.26017 22ZM12.5002 18C14.2902 18 15.7502 16.54 15.7502 14.75C15.7502 12.96 14.2902 11.5 12.5002 11.5C10.7102 11.5 9.25017 12.96 9.25017 14.75C9.25017 16.54 10.7102 18 12.5002 18Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span>Thêm hình ảnh</span>
                                            </a>
                                        </div>
                                    <?php } ?>

                                    <textarea name="comment" rows="5" class="form-control mb-4" placeholder="Hãy chia sẻ những điều bạn thích về sản phẩm này nhé."><?php echo @$detail->rateInfo->comment ?></textarea>

                                    <?php if (!$detail->rate && (time() - strtotime($item->created_time) <= $this->dateAllowRate)) { ?>
                                        <a href="" class="form-submit d-flex align-items-center justify-content-center">ĐÁNH GIÁ</a>
                                        <?php echo csrf::displayToken() ?>
                                        <input type="file" name="image[]" id="<?php echo $detail->id ?>" class="d-none" multiple>
                                        <input type="hidden" name="module" value="members">
                                        <input type="hidden" name="view" value="orders">
                                        <input type="hidden" name="task" value="rate">
                                        <input type="hidden" name="order_id" value="<?php echo $item->id ?>">
                                        <input type="hidden" name="order_item_id" value="<?php echo $detail->id ?>">
                                        <input type="hidden" name="product_id" value="<?php echo $detail->product_id ?>">
                                        <input type="hidden" name="sub_id" value="<?php echo $detail->id_sub ?>">
                                        <input type="hidden" name="rate" value="0">
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>