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
<!--<input type="hidden" id="id_thucu" value="--><?//=$id?><!--">-->
<!--<input type="hidden" id="price_thucu" value="--><?//=$id?><!--">-->

<div class="all scrollbar" id="style-44">

    <a href="javascript:void(0)" id="close-cart"><img
                src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Group 22.svg'; ?>"></a>

    <h3 class="text-center title_ab">chọn sản phẩm lên đời</h3>
    <div class="search_autumn">
        <input class="input_name" id="autumn_search1" type="text"
               placeholder="Nhập tên sản phẩm bạn muốn định giá!">
        <span class="form-control-feedback icon_">
                        <img src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Path 182.svg' ?>" alt="search">
                    </span>
    </div>
    <div class="list_prd_1" id="list_prd_1">
        <ul class="nav nav_tabs nav1">
            <?php
            $i = 0;

            foreach ($list_cat_autumn as $item) {
                ?>
                <li class="<?php if ($i == 0) {
                    echo 'active';
                } ?>  new_tab_item click_<?php echo $item->id; ?>">
                    <a data-toggle="tab" href="#cat_<?php echo $item->id ?>"><?php echo $item->name ?></a>
                </li>
                <?php $i++;
            } ?>
        </ul>
        <div class="tab-content">
            <?php
            $i = 0;
            foreach ($list_cat_autumn as $item) {
                ?>
                <div id="cat_<?php echo $item->id ?>" class="tab-pane fade <?php if ($i == 0) {
                    echo 'in active';
                } ?>">
                    <div class="row row_autumn">
                        <?php foreach ($list_prd[$item->id] as $key) { ?>
                            <div class="col-md-3 col_autumn col-xs-6">
                                <div class="item_prd">
                                    <a href="javascript:void(0)" class="change_prd" data-id="<?= $key->id ?>">
                                        <img src="<?php echo 'https://didongthongminh.vn/' . str_replace('original', 'resized', $key->image) ?>"
                                             alt="<?= $key->name ?>" class="img-responsive">
                                        <h3><?= $key->name ?></h3>
                                        <p><span>Giá máy:</span>
                                            <span><?php echo format_money($key->price, 'đ') ?></span>
                                        </p>
                                        <p><span>Giá máy cũ:</span>
                                            <span><?php echo format_money($price, 'đ') ?></span>
                                        </p>
                                        <p><span>Bù chênh lệch:</span>
                                            <span class="price_end"><?php if($key->price >$price){echo format_money($key->price - $price, 'đ');}else{echo 'Liên hệ';} ?></span>
                                        </p>
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
