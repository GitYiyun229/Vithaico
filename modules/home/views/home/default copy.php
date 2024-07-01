<?php
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('default', 'modules/home/assets/css');
$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('default', 'modules/home/assets/js');

?>

<div class="page-home">
    <div class="container">
        <div class="d-flex gap-3 section-top mb-3">
            <div class="bg-white section-top-left">
                <p class="mb-0 pe-3 ps-3 pt-2 pb-2 fs-6 fw-bold"><?php echo FSText::_('Danh mục') ?></p>
                <div class="section-menu">
                    <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu']); ?>
                </div>
            </div>

            <div class="section-top-center">
                <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>

                <div class="section-icon mt-3 p-3 bg-white d-flex justify-content-between text-center">
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/chiet-khau-san-pham.svg" alt="Chiết khấu sản phẩm" class="img-fluid mb-2">
                        <div>
                            Chiết khấu <br>
                            sản phẩm
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/mua-si-gia-hoi.svg" alt="Mua sỉ giá hời" class="img-fluid mb-2">
                        <div>
                            Mua sỉ <br>
                            giá hời
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/voucher-giam.svg" alt="Voucher giảm đến 200k" class="img-fluid mb-2">
                        <div>
                            Voucher giảm <br>
                            đến 200k
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/qua-tang-hap-dan.svg" alt="Quà tặng hấp dẫn" class="img-fluid mb-2">
                        <div>
                            Quà tặng <br>
                            hấp dẫn
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/chiet-khau-phi-van-chuyen.svg" alt="Chiết khấu phí vẫn chuyển" class="img-fluid mb-2">
                        <div>
                            Chiết khẩu <br>
                            phí vẫn chuyển
                        </div>
                    </div>
                    <div>
                        <img src="<?php echo URL_ROOT ?>images/flash-sale-gia-soc.svg" alt="Flash sale giá sốc" class="img-fluid mb-2">
                        <div>
                            Flash sale <br>
                            giá sốc
                        </div>
                    </div>
                </div>
            </div>

            <div class="section-top-right">
                <div class="section-user mb-3">
                    <div class="section-user-top">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <img src="<?php echo URL_ROOT . $userImage ?>" alt="user" class="img-fluid">
                            <div>
                                <p class="fw-medium"><?php echo FSText::_('Xin chào quý khách!') ?></p>
                                <?php if ($user->userID) { ?>
                                    <p class="user-name fw-bold fs-6"><?php echo $user->userInfo->full_name ?></p>
                                <?php } else { ?>
                                    <p><?php echo FSText::_('Đăng nhập và mua sắm ngay thôi') ?></p>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <?php if ($user->userID) { ?>
                                <div class="p-2 bg-white d-flex align-items-center justify-content-between user-level">
                                    <span><?php echo FSText::_('Hạng thành viên') ?></span>
                                    <div class="icon d-flex align-items-center text-uppercase icon-<?php echo $user->userInfo->level ?>">
                                        <img src="/images/user-level.svg" alt="level" class="img-fluid">
                                        <?php echo $userLevel[$user->userInfo->level] ?>
                                    </div>
                                </div>
                                <a href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>" class="text-center p-2 btn-guest btn-logout" title="<?php echo FSText::_('Đăng xuất') ?>"><?php echo FSText::_('Đăng xuất') ?></a>
                            <?php } else { ?>
                                <a href="" class="text-center p-2 btn-guest btn-login" title="<?php echo FSText::_('Đăng nhập') ?>"><?php echo FSText::_('Đăng nhập') ?></a>
                                <a href="" class="text-center p-2 btn-guest btn-register" title="<?php echo FSText::_('Đăng ký') ?>"><?php echo FSText::_('Đăng ký') ?></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="section-user-center bg-white text-center">
                        <div>
                            <p class="mb-1 fw-semibold"><?php echo $orderNew ?></p>
                            <?php echo FSText::_('Đơn hàng <br> mới') ?>
                        </div>
                        <div>
                            <p class="mb-1 fw-semibold"><?php echo $orderShipping ?></p>
                            <?php echo FSText::_('Đang vận chuyển') ?>
                        </div>
                        <div>
                            <p class="mb-1 fw-semibold"><?php echo $orderSuccess ?></p>
                            <?php echo FSText::_('Hoàn <br> thành') ?>
                        </div>
                        <div>
                            <p class="mb-1 fw-semibold">0</p>
                            <?php echo FSText::_('Điểm <br> của bạn') ?>
                        </div>
                    </div>
                    <div class="section-user-bottom bg-white">
                        <div class="d-flex align-items-center gap-3">
                            <a class="text-center position-relative section-user-btn active" data-hover="section-user-tab-0"><?php echo FSText::_('Khuyến mãi dành cho bạn') ?></a>
                            <a class="text-center position-relative section-user-btn" data-hover="section-user-tab-1"><?php echo FSText::_('Thông tin bảo hành') ?></a>
                        </div>
                        <div class="position-relative">
                            <div class="position-absolute section-user-tab" id="section-user-tab-0">
                                <?php echo FSText::_('Quý khách vui lòng đăng nhập để xem ưu đãi!') ?>
                            </div>
                            <div class="position-absolute section-user-tab" id="section-user-tab-1" style="display: none;">
                                <?php echo FSText::_('Quý khách vui lòng đăng nhập để kiểm tra bảo hành!') ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="section-user-banner">
                    <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '2', 'style' => 'default']); ?>
                </div>
            </div>
        </div>

        <div class="section-banner d-flex align-items-center gap-3 mb-3">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '3', 'style' => 'default']); ?>
        </div>



        <div class="section-banner d-flex align-items-center gap-3 mb-3">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '4', 'style' => 'default']); ?>
        </div>

        <div class="section-product bg-white mb-3">
            <div class="mb-2 section-title"><?php echo FSText::_('Gợi ý hôm nay') ?></div>
            <div class="categories d-flex align-items-center flex-wrap justify-content-between gap-3" role="tablist">
                <a class="text-title active" data-bs-toggle="tab" data-bs-target="#nav-0" type="button" role="tab" aria-controls="nav-0" aria-selected="true">
                    <?php echo FSText::_('Gợi ý phổ biến') ?>
                </a>
                <?php foreach ($categories as $item) {
                    $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id");
                    ?>
                    <a  title="<?php echo $item->name ?>" data-bs-toggle="tab" data-bs-target="#nav-<?php echo $item->id ?>" type="button" role="tab" aria-controls="nav-<?php echo $item->id ?>" aria-selected="false">
                    <?php echo $item->name ?>
                </a>
                <?php } ?>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-0" role="tabpanel" aria-labelledby="nav-0-tab" tabindex="0">
                    <div class="products d-flex flex-wrap product-gap">
                        <?php foreach ($products as $item) { ?>
                            <?php echo $this->layoutProductItem($item) ?>
                        <?php } ?>
                    </div>
                    <div class="loading-scroll w-100" limit="20" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
                </div>

                <?php foreach ($categories as $item) { ?>
                    <div class="tab-pane fade" id="nav-<?php echo $item->id ?>" role="tabpanel" aria-labelledby="nav-<?php echo $item->id ?>-tab" tabindex="0">
                        <div class="d-flex flex-wrap product-gap">
                            <?php foreach ($item->products as $prd) { ?>
                                <?php echo $this->layoutProductItem($prd) ?>
                            <?php } ?>
                        </div>
                    </div>  
                <?php } ?>    
            </div>
        </div>

        <div class="section-banner d-flex align-items-center gap-3 mb-3">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '5', 'style' => 'default']); ?>
        </div>

        <div class="section-slogan d-flex gap-3 align-items-center">
            <div class="section-item bg-white d-flex align-items-center justify-content-center gap-3">
                <img src="<?php echo URL_ROOT ?>images/san-pham-chinh-hang.svg" alt="Sản phẩm chính hãng" class="img-fluid">
                <div class="text-uppercase"><?php echo FSText::_('Sản phẩm') ?> <b><?php echo FSText::_('chính hãng') ?></b></div>
            </div>
            <div class="section-item bg-white d-flex align-items-center justify-content-center gap-3">
                <img src="<?php echo URL_ROOT ?>images/bao-hanh-1-1-toan-quoc.svg" alt="Bảo hành 1 đổi 1 toàn quốc" class="img-fluid">
                <div class="text-uppercase"><?php echo FSText::_('Bảo hành 1 đổi 1') ?> <b><?php echo FSText::_('toàn quốc') ?></b></div>
            </div>
            <div class="section-item bg-white d-flex align-items-center justify-content-center gap-3">
                <img src="<?php echo URL_ROOT ?>images/hotline-ho-tro.svg" alt="Hotline hỗ trợ <?php echo $config['hotline'] ?>" class="img-fluid">
                <div class="text-uppercase"><?php echo FSText::_('Hotline hỗ trợ') ?> <b><?php echo $config['hotline'] ?></b></div>
            </div>
            <div class="section-item bg-white d-flex align-items-center justify-content-center gap-3">
                <img src="<?php echo URL_ROOT ?>images/thu-tuc-doi-tra-de-dang.svg" alt="Thủ tục đổi trả dễ dàng" class="img-fluid">
                <div class="text-uppercase"><?php echo FSText::_('Thủ tục đổi trả') ?> <b><?php echo FSText::_('dễ dàng') ?></b></div>
            </div>
        </div>
    </div>
</div>