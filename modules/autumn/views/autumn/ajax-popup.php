<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 6/12/2021
 * Time: 10:50 AM
 */
global $tmpl;
$tmpl->addStylesheet('points', 'modules/autumn/assets/css');
$tmpl->addScript('points', 'modules/autumn/assets/js');
?>
<div class="all scrollbar" id="style-44">

    <a href="javascript:void(0)" id="close-cart"><img
                src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Group 22.svg'; ?>"></a>

    <h3 class="text-center title_ab">Tình trạng máy cũ</h3>
    <div class="body_a">
        <div class="left_body">
            <a href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $product->alias) ?>">
                <img src="<?php echo 'https://didongthongminh.vn/' . str_replace('original', 'resized', $product->image) ?>"
                     alt="<?= $product->name ?>" class="img-responsive">
            </a>
        </div>
        <div class="right_body">
            <p class="name_p">Điện thoại của bạn: <span><?= $product->name ?></span></p>
            <p class="ngoaihinh">Ngoại hình máy:</p>
            <div class="list_autm">
                <?php
                $i = 1;
                foreach ($list_autumn as $item) {
                    $active = '';
                    if ($i == 1)
                        $active = 'active';
                    $price_a = 'price_autumn_'.$i
                    ?>
                    <p class="item_au <?= $active ?> item_price1_<?= $item->id ?>" data-autumn="<?= $item->id ?>"
                       data-price="<?=$i==1?0:$product->$price_a; ?>"
                       data-type="<?= $item->code ?>">
                        <?= $item->code ?>:
                        <span><?= $item->name ?></span>
                    </p>
                    <?php $i++;
                } ?>
            </div>
            <div class="combo_11">
                <p class="ngoaihinh1">Phụ kiện và bảo hành:</p>
                <div class="list_combo">
                    <?php
                    $i = 1;
                    foreach ($list_combo as $item) {
                        ?>
                        <p class="item_combo item_price_<?= $item->id ?>" data-combo="<?= $item->id ?>"
                           data-price-combo="<?= $item->price ?>" >
                            <span class="name_combo"><?= $item->name ?></span>
                            <span class="price_combo">+<?= format_money($item->price, 'đ') ?></span>
                        </p>
                        <?php $i++;
                    } ?>
                </div>
            </div>
            <p class="price_expected">Giá dự kiến thu lại <span class="type_au">loại 1</span>:<b
                        class="price_10"><?= format_money($product->price_autumn, 'đ') ?></b></p>
            <p class="note_au">Lưu ý: Giá thu mua áp dụng cho dung lượng pin > 90% & số lần sạc < 400 lần (ngoài ra giá
                mua có thể trừ chi phí thay pin.)</p>
        </div>
    </div>
    <p class="text-center sbm"><a href="#">Đổi ngay</a></p>
    <div class="clearfix"></div>
    <input type="hidden" id="price_autumn" value="<?php echo $product->price_autumn ?>">
    <input type="hidden" id="price_autumn_1" value="<?php echo $product->price_autumn ?>">
    <input type="hidden" id="price_autumn_2" value="<?php echo $product->price_autumn ?>">

    <input type="hidden" id="type_autumn" value="<?php echo $list_autumn[0]->id ?>">
    <input type="hidden" id="type_combo" value="">
    <input type="hidden" id="id_prd_old" value="<?= $product->id ?>">
</div>
