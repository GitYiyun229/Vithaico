<?php
$tmpl->addStylesheet('slick', 'libraries/slick-js');
$tmpl->addStylesheet('slick.theme', 'libraries/slick-js');
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('default', 'modules/home/assets/css');
$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('default', 'modules/home/assets/js');
$tmpl->addScript('slick.min', 'libraries/slick-js');
?>
<div class="page-home">
    <div class="d-flex gap-3 section-top mb-3">
        <div class="section-top-center">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>
        </div>
    </div>
    <div class="container">
        <?php if (!empty($flashsaleProductsOriginal)) { ?>
            <div class="section-flash-sale mb-3 mt-5">
                <div class="title-flash-sale d-flex flex-wrap align-items-center">
                    <h3 class="title-categories mb-3 mt-3 fs-sale">
                        <p class="fst-italic"><?= FSText::_('Flash') ?><span class="pl-3"><?= FSText::_('Sale') ?></span> </p>
                    </h3>
                    <div class="time_sales fs-sale">
                        <div class="tile time_count d-flex flex-wrap justify-content-end" data-day="<?= $diffInDays ?>" data-hour="<?= $diffInHours ?>" data-minutes="<?= $diffInMinutes ?>" data-seconds="<?= $diffInSeconds ?>" id="the-FlashSale-countdown">
                            <p>Kết thúc sau:</p>
                            <div id="demo163">
                                <span class="fw-bold number_">00</span>
                                :
                                <span class="fw-bold number_">00</span>
                                :
                                <span class="fw-bold number_">00</span>
                                :
                                <span class="fw-bold number_">00</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="<?php echo count($flashsaleProductsOriginal) > 12 ? 'slider-flashsale' : 'flashsale-listprd' ?>  products d-flex flex-wrap product-gap ">
                    <?php foreach ($flashsaleProductsOriginal as $item_sale) { ?>
                        <?php echo $this->layoutProductItemFlashSale($item_sale) ?>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
        <div class="section-top mb-5 mt-5">
            <h3 class="title-categories mb-3 mt-3"><?= FSText::_('Shop by categories') ?></h3>
            <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'view_menu_categories_home']); ?>
        </div>

        <div class="section-product bg-white mb-3">
            <div class="mb-4 section-title fw-bold"><?php echo FSText::_('Gợi ý cho bạn') ?></div>
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
    </div>
</div>