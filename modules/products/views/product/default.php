<?php
global $config, $tmpl, $module, $user;
$tmpl->addStylesheet('slick', 'libraries/slick-js');
$tmpl->addStylesheet('slick.theme', 'libraries/slick-js');
$tmpl->addStylesheet('product', 'modules/products/assets/css');

$tmpl->addScript('slick.min', 'libraries/slick-js');
$tmpl->addScript('product', 'modules/products/assets/js');

// unset($_SESSION['cart'])

?>

<input type="hidden" id="product" value="<?php echo $data->id ?>">
<div class="container">
    <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
</div>

<div class="section-product-detail bg-white mb-3 pt-3 pb-3">
    <div class="container d-flex">
        <div class="section-image">
            <div class="image mb-3">
                <div class="slider-for">
                    <div>
                        <img src="<?php echo image_replace_webp(URL_ROOT . $data->image, 'larges') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid">
                    </div>
                    <?php foreach ($dataImage as $item) { ?>
                        <div>
                            <img src="<?php echo image_replace_webp(URL_ROOT . $item->image, 'larges') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid">
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="thumbnail">
                <div class="slider-nav">
                    <div>
                        <img src="<?php echo image_replace_webp(URL_ROOT . $data->image, 'larges') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid">
                    </div>
                    <?php foreach ($dataImage as $item) { ?>
                        <div>
                            <img src="<?php echo image_replace_webp(URL_ROOT . $item->image, 'larges') ?>" onerror="this.src='/images/not_picture.png'" alt="<?php echo $data->name ?>" class="img-fluid">
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="section-main">
            <div class="p-sub-title">
                <a href="">HOME </a>
                <a href="" class="text-uppercase">/ <?php echo $data->category_name ?></a>
            </div>
            <h1 class="p-name"><?php echo $data->name ?></h1>
            <p class="p-sub-title"><?php echo $data->subtitle ?></p>
            <div class="p-sub-Evaluate d-flex justify-content-between">
                <div class="d-flex align-items-center gap-2 mb-1">
                    <div class="star-rating" style="--rating: <?php echo 5 ?>;"></div>
                    <div class="rate-name fw-medium"><?php echo $this->rateName[5] ?></div>
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
            <div class="p-trademark d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <span><?php echo FSText::_('Thương hiệu:') ?></span>
                        <b><?php echo $data->trademark ?></b>
                    </div>
                    <div class="wrap"></div>
                    <div>
                        <b><?php echo $data->sold_out ?></b>
                        <span><?php echo FSText::_('Đã bán') ?></span>
                    </div>
                </div>
            </div>
            <div class="p-price-promotion">
                <div class="d-flex align-items-center gap-3 justify-content-between">
                    <div class="layout-public-price align-items-center gap-3">
                        <div class="price fs-4"><?php echo format_money($data->price_discount, '₫') ?></div>
                        <div class="layout-origin-price"> <?php echo $data->price_old && $data->price_discount < $data->price_old ? format_money($data->price_old, '₫') : '' ?></div>
                        <?php if ($data->percent) { ?>
                            <div class="layout-info">
                                <div class="item-info item-percent">- <?php echo $data->percent ?>%</div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($user->userID) { ?>
                        <a href="" class="btn-submit add-like <?php echo $favorite ? 'added' : 'no-add' ?>">
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.44 0.100006C12.63 0.100006 11.01 0.980006 10 2.33001C8.99 0.980006 7.37 0.100006 5.56 0.100006C2.49 0.100006 0 2.60001 0 5.69001C0 6.88001 0.19 7.98001 0.52 9.00001C2.1 14 6.97 16.99 9.38 17.81C9.72 17.93 10.28 17.93 10.62 17.81C13.03 16.99 17.9 14 19.48 9.00001C19.81 7.98001 20 6.88001 20 5.69001C20 2.60001 17.51 0.100006 14.44 0.100006Z" fill="#BFBFBF" />
                            </svg>
                        </a>
                    <?php } else { ?>
                        <a href="javascript:void(0)" class="btn-submit add-like" data-bs-toggle="tooltip" data-bs-title="Vui lòng đăng nhập để sử dụng tính năng">
                            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.44 0.100006C12.63 0.100006 11.01 0.980006 10 2.33001C8.99 0.980006 7.37 0.100006 5.56 0.100006C2.49 0.100006 0 2.60001 0 5.69001C0 6.88001 0.19 7.98001 0.52 9.00001C2.1 14 6.97 16.99 9.38 17.81C9.72 17.93 10.28 17.93 10.62 17.81C13.03 16.99 17.9 14 19.48 9.00001C19.81 7.98001 20 6.88001 20 5.69001C20 2.60001 17.51 0.100006 14.44 0.100006Z" fill="#BFBFBF" />
                            </svg>
                        </a>
                    <?php } ?>
                </div>
                <?php if ($data->have_flash) { ?>
                    <div class="p-promotion d-flex align-items-center justify-content-between ps-3 pe-3">
                        <img src="/images/flash-text.svg" alt="Fashsale" class="img-fluid">
                        <div class="d-flex align-items-center gap-1">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.4735 10.12L8.40683 8.88668C8.04683 8.67334 7.7535 8.16001 7.7535 7.74001V5.00668M14.6668 8.00001C14.6668 11.68 11.6802 14.6667 8.00016 14.6667C4.32016 14.6667 1.3335 11.68 1.3335 8.00001C1.3335 4.32001 4.32016 1.33334 8.00016 1.33334C11.6802 1.33334 14.6668 4.32001 14.6668 8.00001Z" stroke="#F2C3B0" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="title"><?php echo FSText::_('KẾT THÚC TRONG') ?> </span>
                            <div class="count-down d-flex align-items-center gap-1" time-end="<?php echo date('M d Y H:i:s', strtotime($promotionDiscount->date_end)) ?>"></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="p-price">
                    <!-- <div class="p-line align-items-end">
                        <div class="p-line-title"><?php echo FSText::_('Giá') ?></div>
                        <div class="p-line-content">
                            <div class="p-price-public d-inline-block">
                                <?php echo format_money($data->price_public) ?>
                            </div>
                            <?php if ($data->price_old > $data->price_public) { ?>
                                <div class="p-price-origin d-inline-block ms-3">
                                    <?php echo format_money($data->price_old) ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div> -->
                    <?php if ($promotionDiscount && $promotionDiscount->quantity_user) { ?>
                        <div class="p-note">
                            Giá chỉ còn <b class="p-price-discount"><?php echo format_money($data->price_discount) ?></b> cho <?php echo $promotionDiscount->quantity_user ?> sản phẩm mua lần đầu trong thời gian diễn ra chương trình
                        </div>
                    <?php } ?>
                    <?php if ($data->sale_brief) { ?>
                        <div class="p-line p-sale-brief">
                            <div class="p-line-title"><?php echo FSText::_('Khuyến mại') ?></div>
                            <div class="p-line-content">
                                <?php echo $data->sale_brief ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>

            <div class="p-form">
                <?php if (!empty($dataType)) { ?>
                    <div class="p-line">
                        <div class="p-line-title"><?php echo $data->text_buy ?: 'Màu sắc' ?></div>
                        <div class="p-line-content d-flex flex-wrap gap-2">
                            <?php foreach ($dataType as $i => $item) {
                                $active = '';
                                if ($item->quantity && !@$found) {
                                    $found = true;
                                    $active = 'active';
                                }
                            ?>
                                <a href="" data-sub="<?php echo $item->id ?>" data-price="<?php echo $item->price_public ?>" data-price-origin="<?php echo $item->price ?>" data-price-old="<?php echo $item->price_old ?>" price-format="<?php echo format_money($item->price_public) ?>" price-old-format="<?php echo format_money($item->price_old) ?>" price-discount-format="<?php echo format_money($item->price_discount) ?>" data="<?php echo @$item->thumbnail_index ?>" class="p-choose p-type <?php echo !$item->quantity ? 'out-of-stock' : '' ?> <?php echo $active ?>">
                                    <?php echo $item->name ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } else { ?>
                    <div class="p-type active d-none" data-sub="0" data-price="<?php echo $data->price_public ?>" data-price-old="<?php echo $data->price_old ?>"></div>
                <?php } ?>

                <?php if (!empty($dataSame)) { ?>
                    <div class="p-line">
                        <div class="p-line-title"><?php echo FSText::_('Phân loại') ?></div>
                        <div class="p-line-content d-flex flex-wrap gap-2">
                            <?php foreach ($dataSame as $i => $item) {
                                $url = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
                            ?>
                                <a href="<?php echo $url ?>" title="<?php echo $item->name ?>" class="p-choose <?php echo !$item->quantity ? 'out-of-stock' : '' ?> <?php echo $item->id == $data->id ? 'active' : '' ?>">
                                    <?php echo $item->nick_name ?>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>

                <?php if ($data->quantity) { ?>
                    <div class="p-line">
                        <div class="p-line-title"><?php echo FSText::_('Số lượng') ?></div>
                        <div class="p-line-content d-flex align-items-center gap-4">
                            <div class="p-quantity d-flex align-items-center">
                                <button class="subtract btn">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="5" width="12" height="2" rx="1" fill="#3B3B3B" />
                                    </svg>
                                </button>
                                <input class="form-control" id="order-quantity" type="number" value="1" min="1" max="<?php echo $data->quantity ?>">
                                <button class="plus btn">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect y="5" width="12" height="2" rx="1" fill="#3B3B3B" />
                                        <rect x="5" width="2" height="12" rx="1" fill="#3B3B3B" />
                                    </svg>
                                </button>
                            </div>
                            <div class="p-line-title"><?php echo $data->quantity ?> sản phẩm có sẵn</div>
                        </div>
                    </div>
                <?php } ?>

                <div class="p-submit d-flex align-items-center justify-content-between gap-3 mt-4">
                    <?php if ($data->quantity) { ?>
                        <a href="" class="btn-submit add-cart">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M2.1665 1.66669H3.61651C.51651 1.66669 5.22484 2.44169 5.14984 3.33335L4.45817 11.6333C4.3415 12.9917 5.4165 14.1583 6.78317 14.1583H15.6582C16.8582 14.1583 17.9082 13.175 17.9998 11.9834L18.4498 5.73336C18.5498 4.35002 17.4998 3.22502 16.1082 3.22502H5.34984M7.99984 6.66669H17.9998M15.0832 17.2917C15.0832 17.867 14.6168 18.3334 14.0415 18.3334C13.4662 18.3334 12.9998 17.867 12.9998 17.2917C12.9998 16.7164 13.4662 16.25 14.0415 16.25C14.6168 16.25 15.0832 16.7164 15.0832 17.2917ZM8.4165 17.2917C8.4165 17.867 7.95013 18.3334 7.37484 18.3334C6.79954 18.3334 6.33317 17.867 6.33317 17.2917C6.33317 16.7164 6.79954 16.25 7.37484 16.25C7.95013 16.25 8.4165 16.7164 8.4165 17.2917Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <?php echo FSText::_('Thêm vào giỏ hàng') ?>
                        </a>
                        <a href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>" class="btn-submit buy-now">
                            <?php echo FSText::_('Mua ngay') ?>
                        </a>
                    <?php } else { ?>
                        <div class="btn-submit out-of-stock">
                            <?php echo FSText::_('Hết hàng') ?>
                        </div>
                    <?php } ?>

                    <?php if ($user->userID) { ?>
                        <a href="" class="btn-submit add-like <?php echo $favorite ? 'added' : 'no-add' ?>">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.0165 17.3416C10.7332 17.4416 10.2665 17.4416 9.98317 17.3416C7.5665 16.5166 2.1665 13.075 2.1665 7.24165C2.1665 4.66665 4.2415 2.58331 6.79984 2.58331C8.3165 2.58331 9.65817 3.31665 10.4998 4.44998C11.3415 3.31665 12.6915 2.58331 14.1998 2.58331C16.7582 2.58331 18.8332 4.66665 18.8332 7.24165C18.8332 13.075 13.4332 16.5166 11.0165 17.3416Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span><?php echo FSText::_('Yêu thích') ?></span>
                        </a>
                    <?php } else { ?>
                        <a href="javascript:void(0)" class="btn-submit add-like" data-bs-toggle="tooltip" data-bs-title="Vui lòng đăng nhập để sử dụng tính năng">
                            <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.0165 17.3416C10.7332 17.4416 10.2665 17.4416 9.98317 17.3416C7.5665 16.5166 2.1665 13.075 2.1665 7.24165C2.1665 4.66665 4.2415 2.58331 6.79984 2.58331C8.3165 2.58331 9.65817 3.31665 10.4998 4.44998C11.3415 3.31665 12.6915 2.58331 14.1998 2.58331C16.7582 2.58331 18.8332 4.66665 18.8332 7.24165C18.8332 13.075 13.4332 16.5166 11.0165 17.3416Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span><?php echo FSText::_('Yêu thích') ?></span>
                        </a>
                    <?php } ?>
                </div>
            </div>
            <p class="bd-row"></p>
            <div class="b-collapse mt-2 mb-2">
                <p class="btn btn-primary p-collapse text-uppercase" data-bs-toggle="collapse" href="#MoTaSanPham" role="button" aria-expanded="false" aria-controls="MoTaSanPham">Mô tả sản phẩm</p>
                <div class="collapse mt-3 mb-3 " id="MoTaSanPham">
                    <div class="card card-body border-0">
                        <?php echo $data->description ?>
                    </div>
                </div>
            </div>
            <p class="bd-row"></p>
            <div class="b-collapse mt-2 mb-2">
                <p class="btn btn-primary p-collapse text-uppercase" data-bs-toggle="collapse" href="#HoanTra" role="button" aria-expanded="false" aria-controls="HoanTra">Chính sách vận chuyển và hoàn trả</p>
                <div class="collapse mt-3 mb-3" id="HoanTra">
                    <div class="card card-body border-0">
                        <?php echo $config['title_vanchuyen'] ?>
                    </div>
                </div>
            </div>
            <p class="bd-row"></p>
        </div>
    </div>
</div>

<div class="container">
    <?php if (!empty($dataRelated)) { ?>
        <div class="section-product-related bg-white mb-3">
            <h2 class="text-center h2 mb-4"><?php echo FSText::_('có thể bạn cũng thích') ?></h2>
            <div class="<?php echo count($dataRelated) > 5 ? 'slider-related' : 'list-related d-flex' ?>">
                <?php foreach ($dataRelated as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>
        </div>
    <?php } ?>
    <?php if (!empty($dataRelated)) { ?>
        <div class="section-product-related bg-white mb-4">
            <h2 class="text-center h2 mb-4"><?php echo FSText::_('Sản phẩm khuyến nghị') ?></h2>
            <div class="<?php echo count($dataRelated) > 5 ? 'slider-related' : 'list-related d-flex' ?>">
                <?php foreach ($dataRelated as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>
        </div>
    <?php } ?>
    <?php if (empty($dataRelated)) { ?>
        <div class="section-product-related bg-white mb-4">
            <h2 class="text-center h2 mb-4"><?php echo FSText::_('Sản phẩm khuyến nghị') ?></h2>
            <div class="<?php echo count($dataSell) > 5 ? 'slider-related' : 'list-related d-flex' ?>">
                <?php foreach ($dataSell as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>
        </div>
    <?php } ?>

    <div class="section-grid">
        <div class="section-grid-left">
            <?php if (!empty($dataExtend)) { ?>
                <div class="section-item section-technical bg-white mb-3">
                    <h2 class="section-title text-center h2 fw-bold position-relative"><?php echo FSText::_('Thông tin chi tiết') ?></h2>
                    <?php foreach ($dataExtend as $item) { ?>
                        <div class="d-grid item-technical">
                            <div class="title-technical"><?php echo $item->field_name_display ?></div>
                            <div class="content-technical fw-medium"><?php echo nl2br($item->field_value) ?></div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>



            <?php if (!empty($dataRate)) { ?>
                <div class="section-item section-rate-comment bg-white mb-3">
                    <h2 class="section-title text-center h2 mb-4 position-relative"><?php echo FSText::_('Đánh giá của khách hàng') ?></h2>
                    <div class="section-rate">
                        <div class="rate">
                            <p class="fw-medium mb-3 fs-6"><?php echo FSText::_('Tổng quan') ?></p>
                            <div class="rate-overview d-flex align-items-center mb-3">
                                <div class="percent-rate fw-bold"><?php echo $totalRatePoint ?></div>
                                <div>
                                    <div class="star-rating mb-1" style="--rating: <?php echo $totalRatePoint ?>;"></div>
                                    (<?php echo $data->comments_total ?> <?php echo FSText::_('đánh giá') ?>)
                                </div>
                            </div>
                            <div class="rate-detail">
                                <?php for ($i = 5; $i > 0; $i--) { ?>
                                    <div class="rate-detail-item d-flex gap-2 align-items-center ">
                                        <div class="star-rating" style="--rating: <?php echo $i ?>;"></div>
                                        <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                            <div class="progress-bar" style="width: <?php echo round($countRate[$i] / $totalRate * 100) ?>%"></div>
                                        </div>
                                        <span><?php echo $countRate[$i] ?: 0 ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="image">
                            <p class="fw-medium mb-3 fs-6"><?php echo FSText::_('Tất cả hình ảnh') ?> (<?php echo count($dataRateImage) ?>)</p>
                            <?php if (!empty($dataRateImage)) { ?>
                                <div class="list-image d-flex flex-wrap gap-2">
                                    <?php foreach ($dataRateImage as $i => $image) { ?>
                                        <div class="item-image position-relative">
                                            <img src="<?php echo URL_ROOT . image_replace_webp($image->image, 'resized') ?>" alt="" class="img-fluid">
                                            <?php if ($i == 13 && count($dataRateImage) > 14) { ?>
                                                <div class="text-white position-absolute lef-0 top-0 w-100 h-100 more-image d-flex flex-column align-items-center justify-content-center">
                                                    <span>+<?php echo count($dataRateImage) - 14 ?></span>
                                                    <span>hình ảnh</span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php if ($i == 13 && count($dataRateImage) > 14) break;
                                    } ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="section-comment-filter d-flex align-items-center justify-content-between gap-2 flex-wrap">
                        <p class="fw-medium mb-0 fs-6"><?php echo FSText::_('Lọc theo') ?></p>
                        <div class="select-menu ">
                            <div class="select">
                                <p> <?= FSText::_('Sắp xếp theo ') ?>
                                </p>
                                <i class="fas fa-angle-down"></i>
                            </div>
                            <div class="options-list">
                                <div class="filter-div">
                                    <?php foreach ($this->commentFilter as $i => $item) { ?>
                                        <a href="" class="comment-filter fw-bold d-block w-100 mt-1  <?php echo $i == 0 ? 'active' : '' ?>" data-filter="<?php echo $i ?>">
                                            <?php echo $item ?>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="section-comment">
                        <?php foreach ($dataRate as $i => $item) { ?>
                            <div class="item-comment <?php echo !empty($item->rate_image) ? 'filter-6' : '' ?> filter-<?php echo $item->rating ?>" <?php echo $i > 4 ? 'style="display: none;"' : '' ?>>
                                <img src="<?php echo URL_ROOT ?>images/user-customer-icon.svg" alt="<?php echo $item->name ?>" class="img-fluid">
                                <div class="content-comment">
                                    <div class="d-flex align-items-center gap-2 mb-1">
                                        <div class="star-rating" style="--rating: <?php echo $item->rating ?>;"></div>
                                        <div class="rate-name fw-medium"><?php echo $this->rateName[$item->rating] ?></div>
                                    </div>

                                    <div class="mb-1 fw-medium mb-1"><?php echo $item->name ?></div>

                                    <div class="comment-time mb-1 d-flex align-items-center gap-2">
                                        <?php echo date('H:i d/m/Y', strtotime($item->created_time)) ?>
                                        <svg width="5" height="5" viewBox="0 0 5 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <circle cx="2.5" cy="2.5" r="2" fill="#BFBFBF" />
                                        </svg>
                                        <?php echo FSText::_('Phân loại hàng:') ?> <?php echo $item->sub_name ? "$item->sub_name, " : "" ?><?php echo $item->product_name ?>
                                    </div>

                                    <?php if ($item->comment) { ?>
                                        <div class="comment-text mt-3">
                                            <?php echo nl2br($item->comment) ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (!empty($item->image)) { ?>
                                        <div class="comment-image mt-3 d-flex flex-wrap gap-2">
                                            <?php foreach ($item->image as $image) { ?>
                                                <img src="<?php echo URL_ROOT . image_replace_webp($image->image, 'resized') ?>" alt="" class="img-fluid">
                                            <?php } ?>
                                        </div>
                                    <?php } ?>

                                    <?php if (!empty($item->admin_answer)) { ?>
                                        <div class="mt-3">
                                            <?php foreach ($item->admin_answer as $admin) { ?>
                                                <div class="comment-admin mt-2">
                                                    <img src="<?php echo URL_ROOT ?>images/user-icon.svg" alt="vuabanlo.vn" class="img-fluid">
                                                    <div class="content-admin">
                                                        <div class="mb-1 fw-medium mb-1">ShopUSA.VN</div>
                                                        <div class="comment-text">
                                                            <?php echo nl2br($admin->comment) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="text-center">
                            <a href="" class="more-comment fw-medium"><?php echo FSText::_('Xem thêm') ?></a>
                        </div>
                    </div>
                </div>
            <?php } ?>

        </div>

    </div>
</div>