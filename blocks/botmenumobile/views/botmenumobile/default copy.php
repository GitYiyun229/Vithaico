<?php
global $tmpl, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default', 'blocks/botmenumobile/assets/css');
//var_dump($list_menu);
?>
<ul class="list_menu">
    <?php
    $i = 0;
    foreach ($list_menu_mb as $item) {
        $class = '';
        if ($i == 2)
            $class = 'menu_item_';
        ?>
        <li class="<?= $class ?>">
            <?php if ($i == 2) { ?>
<!--                <img src="--><?//=URL_ROOT.'templates/default/images/bo_img.png'?><!--" alt="" class="bo_out">-->
                <span class="bo_out"></span>
                <span class="bo_in"></span>
            <?php } ?>
            <a href="<?php echo FSRoute::_($item->link) ?>">
                <img src="<?php echo URL_ROOT . $item->image ?>" alt="<?php echo $item->name ?>"
                     class="img-responsive">
                <span><?php echo $item->name ?></span>
            </a>
        </li>
        <?php $i++;
    } ?>

    <li><a href="#" id="open_menu">
            <img src="<?php echo URL_ROOT ?>images/img_mb/more.svg" alt="home" class="img-responsive menu_more">
            <span class="more_m">Thêm</span>
        </a>
        <div id="navigation-menu">
            <div class="login_view text-center">
                <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=login') ?>">ĐĂNG NHẬP XEM LỊCH SỬ
                    MUA HÀNG</a>
            </div>
            <ul class="menu_mobile_">
                <?php foreach ($list_menu as $item) { ?>
                    <li><a href="<?php echo FSRoute::_($item->link) ?>">
                            <img src="<?php echo URL_ROOT . $item->image ?>" alt="<?php echo $item->name ?>"
                                 class="img-responsive">
                            <span><?php echo $item->name ?></span>
                        </a></li>
                <?php } ?>
            </ul>
            <div class="box_qr">

                <img src="<?php echo URL_ROOT . $config['qr_code'] ?>" alt="mã qr" class="img-responsive">

                <img src="<?php echo URL_ROOT . $config['qr_code'] ?>" alt="mã qr" class="img-responsive">
            </div>
            <div class="box_uudai">
                <a href="https://zalo.me/1112886222473365643?src=qr" target="_blank">
                    <span>Quan tâm Zalo Pay</span>
                </a>
                <div class="img_ud">
                    <img src="<?php echo URL_ROOT . 'templates/default/images/uudai.png' ?>" alt="mã qr"
                         class="img-responsive">
                </div>
                <span>Tải App 24hstore</br>trên App Store</span>
            </div>
            <div class="clearfix"></div>
        </div>
    </li>
</ul>
