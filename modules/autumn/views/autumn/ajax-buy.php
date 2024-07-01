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

<input type="hidden" id="url" value="<?= URL_ROOT ?>">
<input type="hidden" id="products_sub" value="<?php echo @$json ?>">

<div class="all scrollbar change_prd buy_prd" id="style-44">
    <a href="javascript:void(0)" id="close-cart"><img
                src="<?php echo URL_ROOT . 'modules/autumn/assets/images/Group 22.svg'; ?>"></a>
    <h3 class="text-center title_ab">Đặt mua sản phẩm</h3>
    <p class="congthuc text-center">GIÁ MUA = GIÁ NIÊM YẾT <?= $product->name ?> - GIÁ MÁY CŨ ĐÃ ĐƯỢC ĐỊNH GIÁ TẠI SIÊU
        THỊ</p>
    <div class="row">
        <div class="col-md-3 l_img">
                <div class="image_item">
                    <img src="<?php echo 'https://didongthongminh.vn/' . $product->image ?>" alt="Hình ảnh"
                         class="img-responsive image_color">
                </div>

        </div>
        <div class="col-md-9">
            <h3 class="name_prd"><?= $product->name ?></h3>
            <div class="box_price">
                <span>Giá niêm yết:</span>
                <p><span class="price_doi"><?= format_money($price_active, 'đ') ?></span>
                </p>
            </div>
            <div class="thuvao">
                <span>Giá thu vào:</span>
                <span class="price_cu"><?= format_money($_SESSION['autumn'][1], 'đ') ?></span>
            </div>
            <div class="price_end">
                <span>Số tiền cần trả thêm:</span>
                <span class="price_them"><?= format_money($price_active - $_SESSION['autumn'][1], 'đ') ?></span>
            </div>
        </div>
    </div>
    <form action="" novalidate="novalidate" name="change_product" method="post" class="form-group"
          id="change_product">
        <ul class="sex_select">
            <li><input type="radio" name="sex" value="1" id="sex1" class="home2" checked="">
                <label for="sex1" class="home">Anh</label>
            </li>
            <li><input type="radio" name="sex" value="2" id="sex2" class="home2">
                <label for="sex2" class="home">Chị</label>
            </li>
        </ul>
        <div class="row mt0">
            <div class="col-sm-6 col_">
                <input type="text" placeholder="Họ và tên" name="sender_name" id="sender_name" value=""
                       class="form-control"/>
            </div>
            <div class="col-sm-6 col_1">
                <input type="text" placeholder="Số điện thoại" name="sender_telephone"
                       id="sender_telephone" value="" class="form-control"/>
            </div>
        </div>
        <div class="bound-input text-center">
            <a class="sbm_change" href="javascript: void(0)" id='submitchange'>
                <span><?php echo FSText::_('Đặt ngay'); ?></span>
            </a>
        </div>
        <input type="hidden" id="price" name="price" value="<?= $price_active ?>">
        <input type="hidden" id="price_old" name="price_old" value="<?= $price_old ?>">
        <input type="hidden" id="id_sub" name="id_sub" value="<?= $product_active->id ?>">
        <input type="hidden" id="id_prd" name="id_prd" value="<?= $product->id ?>">
        <input type="hidden" id="price_thucu" name="price_thucu" value="<?= $_SESSION['autumn'][1] ?>">
        <input type="hidden" id="ngoaihinh" name="ngoaihinh" value="<?= $_SESSION['autumn'][2] ?>">
        <input type="hidden" id="baohanh" name="baohanh" value="<?= $_SESSION['autumn'][3] ?>">
        <input type="hidden" id="id_cu" name="id_cu" value="<?= $_SESSION['autumn'][0] ?>">
        <input type="hidden" id="discount" value="<?php echo @$insale == 1 ? 1 : 0 ?>">

        <input type="hidden" id="price_them" name="price_them" value="<?= $price_active - $_SESSION['autumn'][1] ?>">
        <input type="hidden" name='module' value="autumn"/>
        <input type="hidden" name='view' value="autumn"/>
        <input type="hidden" name='task' value="autumn_save" id='task'/>
    </form>

</div>
