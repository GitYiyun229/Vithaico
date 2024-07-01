<?php
global $config;
global $tmpl;
$tmpl->addStylesheet('owl.carousel.min', 'libraries/jquery/owlcarousel/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/jquery/owlcarousel/assets');
$tmpl->addStylesheet('points', 'modules/autumn/assets/css');
$tmpl->addScript('points', 'modules/autumn/assets/js');
//$tmpl->addTitle(FSText::_('Thu cũ đổi mới'));
$Itemid = FSInput::get('Itemid', 0);
?>
<?php if (@$banner) { ?>
    <div class="container">
        <div class="top_point">
            <!--            --><?php //foreach ($banner as $item) { ?>
            <div class="item">
                <a href="<?= $banner->link ?>" title="banner">
                    <img src="<?php echo URL_ROOT . str_replace('original', 'resized', $banner[0]->image) ?>"
                         alt="banner"
                         class="img-responsive hidden-xs">
                    <!--                        <img src="-->
                    <?php //echo 'https://didongthongminh.vn/' . $banner_mb->image ?><!--" alt="banner"-->
                    <!--                             class="img-responsive hidden-lg hidden-md hidden-sm">-->
                </a>
            </div>
            <!--            --><?php //} ?>
        </div>
    </div>
<?php } ?>
    <div class="body_autumn">
        <div class="container">
            <div class="search_autumn">
                <input class="input_name" id="autumn_search" type="text"
                       placeholder="Nhập tên sản phẩm bạn muốn định giá!">
                <span class="form-control-feedback icon_">
            <img src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Path 182.svg' ?>" alt="search">
        </span>
            </div>
            <div class="list_prd" id="list_prd">
                <ul class="nav nav_tabs nav1">
                    <?php
                    $i = 0;
                    foreach ($list_cat_autumn as $item) {
                        ?>
                        <li class="<?php if ($i == 0) {
                            echo 'active';
                        } ?>  new_tab_item click_<?php echo $item->id; ?>">
                            <a data-toggle="tab" href="#cat<?php echo $item->id ?>"><?php echo $item->name ?></a>
                        </li>
                        <?php $i++;
                    } ?>
                </ul>
                <div class="tab-content">
                    <?php
                    $i = 0;
                    foreach ($list_cat_autumn as $item) {
                        ?>
                        <div id="cat<?php echo $item->id ?>" class="tab-pane fade <?php if ($i == 0) {
                            echo 'in active';
                        } ?>">
                            <div class="row row_autumn">
                                <?php foreach ($list_prd[$item->id] as $key) {
                                    $image_webp = str_replace(['.jpg', '.png'], ['.webp', '.webp'], $key->image);
                                    $image_webp = URL_ROOT . str_replace('/original/', '/resized/', $image_webp);
                                    ?>
                                    <div class="col-md-2dot4 col_autumn col-xs-6">
                                        <div class="item_prd text-center">
                                            <a href="javascript:void(0)" onclick="autumn(<?= $key->id ?>)">
                                                <div class="bo_img">
                                                    <img  class="img-responsive img_org"  data-src="<?php echo $image_webp ?>" src="<?php echo $image_webp; ?>"
                                                         alt="<?= $key->name ?>" class="img-responsive">
                                                </div>
                                                <h3><?= $key->name ?></h3>
                                                <p>Giá thu cũ:
                                                    <span><?php echo format_money($key->price_autumn, 'đ') ?></span></p>
                                            </a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <?php $i++;
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <!--    <div class="box_comment">-->
    <!--        <div class="container">-->
    <!--            --><?php //include 'comment_autumn/comments/rating.php'; ?>
    <!--        </div>-->
    <!--    </div>-->
<?php if (@$_SESSION['sc']) { ?>
    <div id="fs-popup-sc" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="gridSystemModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <button type="button" class="close close_au" data-dismiss="modal" aria-hidden="true">×</button>
            <div class="modal-content" style="    background: transparent;    box-shadow: none;
    border: none;">
                <img src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Group 29.png' ?>" alt="success"
                     class="img-responsive hidden-xs">
                <div class="box_st text-center">
                    <?php if ($_SESSION['sc'] == 1) { ?>
                        <h3>Đặt hàng thành công!</h3>
                    <?php } else { ?>
                        <h3>Đặt hàng không thành công!</h3>
                    <?php } ?>
                    <p>Cảm ơn Quý khách đã mua hàng tại <a href="<?php echo 'https://didongthongminh.vn/' ?>">didongthongminh.vn</a>
                    </p>
                    <p>Tổng đài viên sẽ liên hệ đến Quý khách <b>trong vòng 5 phút.</b></p>
                    <p>Xin cảm ơn Quý khách đã cho chúng tôi cơ hội được phục vụ!</p>
                    <p>Hotline <a href="tel:0855100001">0855100001</a></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>