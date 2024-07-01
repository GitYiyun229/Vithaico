<?php
global $config;
global $tmpl;
$tmpl->addStylesheet('owl.carousel.min', 'libraries/jquery/owlcarousel/assets');
//$tmpl->addStylesheet('owl.theme.default.min', 'libraries/jquery/owlcarousel/assets');
$tmpl->addStylesheet('points', 'modules/points/assets/css');
//$tmpl->addScript('owl.carousel.min', 'libraries/jquery/owlcarousel');
$tmpl->addScript('points', 'modules/points/assets/js');
$tmpl->addTitle(FSText::_('Tích điểm thành viên'));
$Itemid = FSInput::get('Itemid', 0);
?>
<?php if ($data->image) { ?>
    <div class="top_point">
        <div class=" ">
            <a href="<?= $data->link_banner ?>" title="banner">
                <img src="<?php echo URL_ROOT . $data->image ?>" alt="banner" class="img-responsive">
            </a>
        </div>
    </div>
<?php } ?>
<div class="search_member">
    <div class=" content_search">
        <div class="title_search text-center">
            <img src="<?php echo URL_ROOT ?>modules/points/assets/images/TRANG-THE-THANH-VIEN_02.png" alt="hình ảnh"
                 class="img-responsive">
            <span>Tra cứu hạng thành viên và nhận ngay ưu đãi</span>
        </div>
        <div class="ip_search">
            <p class="top_tt"><span class="boder_"></span>Nhập ngay số điện thoại <span class="aaa">Để xem chi tiêu tích lũy và các ưu đãi bạn đang có nhé!</span>
            </p>
        </div>
        <div class="clearfix"></div>
        <div class="input_1">
            <input type="text" class="form-control input2" required>
        </div>
    </div>
</div>
<div class="content_member">
    <div class="box_1 box_width">
        <div class="title_box1">
            <img src="<?php echo URL_ROOT ?>modules/points/assets/images/box_1.png" alt="hình ảnh"
                 class="img-responsive">
        </div>
        <div class="table_re">
            <?php echo html_entity_decode($data->content) ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="box_2 ">
        <div class="box_width">
            <div class="title_no text-center">
                <img src="<?= URL_ROOT ?>modules/points/assets/images/no.png" alt="hình ảnh" class="img-responsive">
                <span>Lưu ý về quyền lợi</span>
            </div>
            <div class="border_tb">
                <?php echo html_entity_decode($data->permission) ?>
            </div>
            <div class="text-center more_">
                <img src="<?= URL_ROOT ?>modules/points/assets/images/more.png" alt="hình ảnh" class="img-responsive">
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="box_3 box_width">
        <div class="title_box1">
            <img src="<?php echo URL_ROOT ?>modules/points/assets/images/box_2.png" alt="hình ảnh"
                 class="img-responsive">
        </div>
        <div class="contebts_faq">
            <?php echo html_entity_decode($data->faq) ?>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="box_4 box_width">
        <div class="title_slide">
            Hãy trở thành khách hàng thân thiết để nhận được ưu đãi cực tốt
        </div>
        <div class="slide_point owl-carousel owl-theme">
            <?php
            foreach ($slide as $item) {
                ?>
                <a href="<?php echo $item->link ?>" class="link_bn">
                    <div class="item">
                        <div class="bor_img">
                            <img src="<?php echo URL_ROOT . str_replace('original', 'banner_large', $item->image) ?>"
                                 alt="hình ảnh">
                        </div>
                    </div>
                </a>
            <?php } ?>
        </div>
    </div>
</div>
