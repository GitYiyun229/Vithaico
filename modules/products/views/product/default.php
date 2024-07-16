<?php
global $config, $tmpl, $module, $user;
$tmpl->addStylesheet('slick', 'libraries/slick-js');
$tmpl->addStylesheet('product', 'modules/products/assets/css');
$tmpl->addScript('slick.min', 'libraries/slick-js');
$tmpl->addScript('product', 'modules/products/assets/js');
// unset($_SESSION['cart'])

?>

<input type="hidden" id="product" value="<?php echo $data->id ?>">
<div class="section-breadcrumb p-3 mb-5">
    <div class="container ">
        <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
    </div>
</div>
<div class="container">
    <div class="section-product-detail d-flex mb-5">
        <div class="section-image d-flex justify-content-between">
            <div class="box-nav">
                <div class="slider-nav">
                    <?php foreach (@$dataImage as $item) { ?>
                        <div>
                            <img src="<?php echo image_replace_webp(URL_ROOT . $item->image, 'tiny') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="box-for">
                <div class="slider-for" id="animated-thumbnails">
                    <?php foreach ($dataImage as $item) { ?>
                        <div>
                            <img src="<?php echo image_replace_webp(URL_ROOT . $item->image, 'larges') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid image">
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
        <div class="section-main">
            <div class="main_content d-grid gap-4">
                <div class="p-name"><?php echo $data->name ?></div>
                <div class="p-code-status">
                    <div class="p-code">
                        <span class="p-title"><?php echo FSText::_('Mã SP:') ?></span>
                        <b><?php echo $data->code ?></b>
                    </div>
                    <div class="<?php echo $data->status_prd == 4 ? 'p-status-out' : 'p-status-in' ?>">
                        <?php if ($data->status_prd == 4) { ?>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.5 4.5L4.5 13.5" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                                <path d="M4.5 4.5L13.5 13.5" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        <?php } else { ?>
                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M15 4.5L6.75 12.75L3 9" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        <?php } ?>
                        <?php echo $status_prd ?>
                    </div>
                </div>
                <div class="p-price">
                    <div class="p-price_retail">
                        <div class="p-title"><?php echo FSText::_('Giá bán lẻ:') ?></div>
                        <?php if ($user->userID) { ?>
                            <div class="price fs-5 fw-bold" id="price" data-price="<?= $user->userID ? $data->price_discount : $data->price ?>" data-coin="<?= $data->coin ?>">
                                <?= format_money($data->price, '₫') ?>
                            </div>
                        <?php } else { ?>
                            <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="title_see_price"><?= FSText::_('Đăng nhập để xem giá') ?></a>
                        <?php } ?>
                    </div>
                    <div class="p-price_discount">
                        <div class="p-title"><?php echo FSText::_('Giá thành viên:') ?></div>
                        <?php if ($user->userID) { ?>
                            <div class="price fs-5 fw-bold" id="price_discount">
                                <?php echo format_money($data->price_discount, '₫') ?> / <span><?= $data->coin ?></span> <span>VTCoin</span>
                            </div>
                        <?php } else { ?>
                            <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="title_see_price"><?= FSText::_('Đăng nhập để xem giá') ?></a>
                        <?php } ?>

                    </div>
                </div>
                <div class="p-summary">
                    <div class="p-title"><?= $data->summary ?></div>
                </div>
                <?php if ($user->userID) { ?>
                    <div class="p-form border-top pt-4">
                        <?php if ($data->quantity) { ?>
                            <div class="p-line d-flex align-items-center gap-2">
                                <div class="p-line-title"><?php echo FSText::_('Số lượng') ?></div>
                                <div class="p-line-content d-flex align-items-center gap-4 border rounded-2">
                                    <div class="p-quantity d-flex align-items-center">
                                        <button class="subtract btn">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="5" width="12" height="2" rx="1" fill="#3B3B3B" />
                                            </svg>
                                        </button>
                                        <input class="form-control border-bottom-0 border-top-0 rounded-0 text-center" id="order-quantity" type="number" value="1" min="1" max="<?php echo $data->quantity ?>">
                                        <button class="plus btn">
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <rect y="5" width="12" height="2" rx="1" fill="#3B3B3B" />
                                                <rect x="5" width="2" height="12" rx="1" fill="#3B3B3B" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="p-submit d-flex align-items-center flex-wrap gap-3 mt-4">
                            <?php if ($data->quantity) { ?>
                                <a href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>" class="btn-submit buy-now">
                                    <?php echo FSText::_('Mua ngay') ?>
                                </a>
                                <a href="" class="btn-submit add-cart">
                                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M2.1665 1.66669H3.61651C.51651 1.66669 5.22484 2.44169 5.14984 3.33335L4.45817 11.6333C4.3415 12.9917 5.4165 14.1583 6.78317 14.1583H15.6582C16.8582 14.1583 17.9082 13.175 17.9998 11.9834L18.4498 5.73336C18.5498 4.35002 17.4998 3.22502 16.1082 3.22502H5.34984M7.99984 6.66669H17.9998M15.0832 17.2917C15.0832 17.867 14.6168 18.3334 14.0415 18.3334C13.4662 18.3334 12.9998 17.867 12.9998 17.2917C12.9998 16.7164 13.4662 16.25 14.0415 16.25C14.6168 16.25 15.0832 16.7164 15.0832 17.2917ZM8.4165 17.2917C8.4165 17.867 7.95013 18.3334 7.37484 18.3334C6.79954 18.3334 6.33317 17.867 6.33317 17.2917C6.33317 16.7164 6.79954 16.25 7.37484 16.25C7.95013 16.25 8.4165 16.7164 8.4165 17.2917Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <?php echo FSText::_('Thêm vào giỏ hàng') ?>
                                </a>
                            <?php } else { ?>
                                <div class="btn-submit out-of-stock">
                                    <?php echo FSText::_('Hết hàng') ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <? } else { ?>
                    <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="">
                        <div class="login-to-buy d-flex align-items-center justify-content-center">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 16.6667C4.94649 14.6021 7.58918 13.3333 10.5 13.3333C13.4108 13.3333 16.0535 14.6021 18 16.6667M14.25 6.25C14.25 8.32107 12.5711 10 10.5 10C8.42893 10 6.75 8.32107 6.75 6.25C6.75 4.17893 8.42893 2.5 10.5 2.5C12.5711 2.5 14.25 4.17893 14.25 6.25Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span>
                                Đăng nhập để mua hàng
                            </span>
                        </div>

                    </a>
                <?php } ?>
            </div>
        </div>
    </div>

    <div class="section-description">
        <p class="section-title"><?= FSText::_('Mô tả sản phẩm') ?></p>
        <div class="section-body"> <?php echo $data->description ?></div>
    </div>


</div>
<div class="section-product-related container ">
    <p class="section-title"><?php echo FSText::_('Sản phẩm liên quan') ?></p>
    <?php if (!empty($dataSame)) { ?>
        <div class="<?php echo (count($dataRelated) > 4) ? 'slider-related' : 'list-related d-grid' ?>">
            <?php foreach ($dataSame as $item) {
                echo $this->layoutProductItem($item);
            } ?>
        </div>
    <?php } ?>
</div>