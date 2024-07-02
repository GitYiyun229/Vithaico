<?php

use Google\Service\CloudSearch\Value;

$arr_status = array(
    1 => FSText::_('Sắp ra mắt'),
    2 => FSText::_('Sắp có hàng trở lại'),
    3 => FSText::_('Đang kinh doanh'),
    4 => FSText::_('Ngừng kinh doanh'),
);

$arr_unitDiscount = array(
    '1' => 'VND',
    '2' => '%',
    // '3' => 'Outlet'
);

$this->dt_form_begin(1, 2, FSText::_('Thông tin chung'), '', 1, 'col-md-8 fl-left editor');
    // TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '', '', 0, '', '');
    // TemplateHelper::dt_edit_text(FSText::_('Nhanh ID'), 'nhanh_id', @$data->nhanh_id, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');
    TemplateHelper::dt_edit_text(FSText::_('Name'), 'name', @$data->name, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');
    TemplateHelper::dt_edit_text(FSText::_('Alias'), 'alias', @$data->alias, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');
    TemplateHelper::dt_edit_text(FSText::_('Diễn giải phụ'), 'subtitle', @$data->subtitle, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9', '', '', 1, '');
    TemplateHelper::dt_edit_text(FSText::_('Tên phiên bản'), 'nick_name', @$data->nick_name, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9', '', '', '1', '');
    TemplateHelper::dt_edit_text(FSText::_('Mã sản phẩm'), 'code', @$data->code, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');
    TemplateHelper::dt_edit_text(FSText::_('Thương hiệu'), 'trademark', @$data->trademark, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');
    TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục'), 'category_id', $category_id, 0, $relate_categories, $field_value = 'id', $field_label = 'treename', $size = 1, 0, 0, '', '', '', 'col-md-3 left', 'col-md-9', '', '1', 'Danh mục chính của sản phẩm');
    TemplateHelper::dt_edit_image(FSText::_('Ảnh đại diện'), 'image', URL_ROOT . @$data->image, '', '', '', 'col-md-3 left', 'col-md-9', 1);

    TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm cùng loại'), 'products_same', @$data->products_same, 0, $list_products, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3 left', 'col-md-9', '', 1, '');
    // TemplateHelper::dt_edit_text(FSText::_('Quà tặng'), 'text_sale', @$data->text_sale, '', 15, 1, 0, 'Lưu ý giới hạn ký tự', '', 'col-md-3 left', 'col-md-9', '', '', '1', '');
    TemplateHelper::dt_edit_selectbox(FSText::_('Trạng thái'), 'status_prd', @$data->status_prd, 0, $arr_status, $field_value = 'id', $field_label = 'title', $size = 1, 0, 1, '', '', '', 'col-md-3 left', 'col-md-9');
    // TemplateHelper::dt_edit_text(FSText::_('Video'), 'video', @$data->video, '', 255, 2, 0, 'vd: ', '', 'col-md-3 left', 'col-md-9', '', '', '1', '');
    // TemplateHelper::dt_edit_text(FSText::_('Khuyến mại'), 'summary', @$data->summary, '', 100, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
    TemplateHelper::dt_edit_text(FSText::_('Khuyến mại'), 'sale_brief', @$data->sale_brief, '', 500, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
    TemplateHelper::dt_edit_text(FSText::_('Mô tả'), 'description', @$data->description, '', 100, 6, 1, '', '', 'col-md-12 left', 'col-md-12');
$this->dt_form_end_col(); // END: col-1

$this->dt_form_begin(1, 2, FSText::_('Giá'), 'fa-usd', 1, 'col-md-4 fl-left');
    TemplateHelper::dt_edit_text(FSText::_('Tồn'), 'quantity', @$data->quantity, '', 20, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
    TemplateHelper::dt_edit_text(FSText::_('Giá thị trường'), 'price_old', @$data->price_old, '', 20, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
    TemplateHelper::dt_edit_text(FSText::_('Giá bán'), 'price', @$data->price, '', 20, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
    ?>
    <div class="form-group">
        <label class="col-md-4 left col-xs-12 control-label">Tiết kiệm</label>
        <div class="col-md-8 col-xs-12">
            <input type="text" disabled class="form-control" name="discount" id="discount" value="<?= format_money_0(@$data->discount, 'đ', '0₫') ?>" size="60" maxlength="20">
        </div>
    </div>
    <?php
    // TemplateHelper::dt_edit_text(FSText::_('Giá mua kèm'), 'price_compare', format_money_0(@$data->price_compare, 'đ'), '', 20, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
    TemplateHelper::dt_edit_text(FSText::_('Đã bán'), 'sold_out', @$data->sold_out, '', 20, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
    TemplateHelper::dt_edit_text(FSText::_('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, 255, 1, 0, '', '', 'col-md-4 left', 'col-md-8');
$this->dt_form_end_col(); 

$this->dt_form_begin(1, 2, FSText::_('Kích hoạt'), 'fa-unlock', 1, 'col-md-4 fl-left');
    // TemplateHelper::dt_checkbox(FSText::_('COMBO'), 'combo', @$data->combo, 1, '', '', '', 'col-md-5 left', 'col-md-7');
    TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_checkbox(FSText::_('Quản lý tồn kho'), 'is_stocking', @$data->is_stocking, 0, [1 => 'Không', 0 => 'Có'], '', '(Không - luôn sẵn hàng, Có đồng bộ từ ERP)', 'col-md-5 left', 'col-md-7 stock');
    TemplateHelper::dt_checkbox(FSText::_('Sản phẩm mới'), 'is_new', @$data->is_new, 1, '', '', '', 'col-md-5 left', 'col-md-7', 1, '');
    TemplateHelper::dt_checkbox(FSText::_('Bán chạy'), 'is_sell', @$data->is_sell, 0, '', '', '', 'col-md-5 left', 'col-md-7', '1', '');
    // TemplateHelper::dt_checkbox(FSText::_('Độc quyền'), 'is_monopoly', @$data->is_monopoly, 0, '', '', '', 'col-md-5 left', 'col-md-7', '1', '');
    // TemplateHelper::dt_checkbox(FSText::_('Trả góp 0%'), 'is_installment', @$data->is_installment, 0, '', '', '', 'col-md-5 left', 'col-md-7', '1', '');
    // TemplateHelper::dt_checkbox(FSText::_('Quà tặng'), 'is_gift', @$data->is_gift, 0, '', '', '', 'col-md-5 left', 'col-md-7', 1, '');
    TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'), 'show_in_home', @$data->show_in_home, 0, '', '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_checkbox(FSText::_('Sapo TSKT'), 'checksapo', @$data->checksapo, 0, '', '', '', 'col-md-5 left', 'col-md-7', 1, 'Áp dụng cho thông số dạng bảng, convert từ web cũ. Chọn `Không` sau khi đã nhập TSKT theo form mới');
    // TemplateHelper::dt_checkbox(FSText::_('Google Merchant'), 'gs', @$data->gs, 0, '', '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_checkbox(FSText::_('Kiểu slide'), 'type_slide', @$data->type_slide, 0, [0 => 'Cũ', 1 => 'Mới'], '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_edit_text(FSText::_('Tags'), 'tags', @$data->tags, '', 255, 3, 0, '', '', 'col-md-3 left', 'col-md-9');
$this->dt_form_end_col();

$this->dt_form_begin(1, 2, FSText::_('SEO'), 'fa-seo', 1, 'col-md-4', '', 1, '');
?>
    <div id="app">
        <div class="form-group">
            <label class="col-xs-12 control-label">Từ khóa SEO</label>
            <div class="col-xs-12">
                <input type="text" class="form-control" name="seo_main_key" id="seo_main_key" value="<?= $data->seo_main_key ?>" size="60" maxlength="100" v-model="keyword" @input="countLengthKeyword">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO title</label>
            <div class="col-xs-12">
                <input type="text" class="form-control mb-3" name="seo_title" id="seo_title" value="<?= $data->seo_title ?>" size="60" v-model="title">
                <div class="progress">
                    <div class="progress-bar" :class="classTile" role="progressbar" aria-valuemin="0" aria-valuemax="<?php echo MAX_TITLE; ?>" :style="{'width': `${parseInt(width)}%`}">
                        {{ countLengthTitle }}%
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO meta keyword</label>
            <div class="col-xs-12">
                <input type="text" class="form-control" name="seo_keyword" id="seo_keyword" value="<?php echo @$data->seo_keyword; ?>" size="60" maxlength="100">
            </div>
        </div>
        <div class="form-group">
            <label class="col-xs-12 control-label">SEO meta description</label>
            <div class="col-xs-12">
                <textarea class="form-control mb-3" rows="9" cols="60" name="seo_description" id="seo_description" v-model="description"><?php echo @$data->seo_description ?></textarea>
                <div class="progress">
                    <div class="progress-bar" :class="classDes" role="progressbar" aria-valuemin="0" aria-valuemax="<?php echo MAX_DES; ?>" :style="{'width': `${parseInt(widthDes)}%`}">
                        {{ countLengthDescription }}%
                    </div>
                </div>
            </div>
        </div>
        <?php
        TemplateHelper::dt_sepa();
        ?>
        <div class="row">
            <div class="col-md-12">
                <h3 style="text-align: center; background: #fff; border-radius: 10px; padding: 5px;">Phân tích SEO</h3>
                <ul class="list-check-seo">
                    <li><i class="fa fa-circle mr-2" :class="classTextKey"></i>Độ dài từ khóa (Nên có <?php echo MIN_KEY; ?> - <?php echo MAX_KEY; ?> từ)
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="classTextTitle"></i>Độ dài tiêu đề (Nên dài <?php echo MIN_TITLE; ?> - <?php echo MAX_TITLE; ?> ký tự)
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="classTextDes"></i>Độ dài mô tả (Nên dài <?php echo MIN_DES; ?> - <?php echo MAX_DES; ?> ký tự)
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': checkKey, 'text-danger': !checkKey}"></i>Từ khóa trong tiêu đề chính
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': checkKeyDes, 'text-danger': !checkKeyDes}"></i>Từ khóa trong mô tả
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classWord, 'text-danger': !classWord}"></i><span>Số lượng từ:</span>Nội dung có {{ countWord }} từ (Nên có ít nhất <?php echo MIN_CONTENT; ?> từ)
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classInternal, 'text-danger': !classInternal}"></i><span>Internal Link:</span>Nội dung có {{ countInternalLink }} link nội bộ
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classExternal, 'text-danger': !classExternal}"></i><span>External Link:</span>Nội dung có {{ countExternalLink }} link bên ngoài
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classKeyContent, 'text-danger': !classKeyContent}"></i><span>Từ khóa trong nội dung:</span>Nội dung đã có {{ countKeyContent }} từ khóa
                    </li>
                    <li><i class="fa fa-circle mr-2" :class="{'text-success': classKeyHeading, 'text-danger': !classKeyHeading}"></i><span>Tiêu đề phụ:</span>Tiêu đề phụ có {{ countKeyHeading }} từ khóa
                    </li>
                </ul>
            </div>
        </div>
    </div>
<?php
$this->dt_form_end_col();

// $this->dt_form_begin(1, 2, FSText::_('Thu cũ đổi mới'), 'fa-list-alt', 1, 'col-md-4 fl-left');
    // TemplateHelper::dt_checkbox(FSText::_('Thu cũ'), 'is_autumn', @$data->is_autumn, 0, '', '', '', 'col-md-5 left', 'col-md-7', '1', '');
    // TemplateHelper::dt_checkbox(FSText::_('Đổi mới'), 'is_renew', @$data->is_renew, 0, '', '', '', 'col-md-5 left', 'col-md-7', 1, '');
    // TemplateHelper::dt_edit_text(FSText::_('Giá thu vào loại 1'), 'price_autumn', format_money_0(@$data->price_autumn, 'đ'), '', 20, 1, 0, '', '', 'col-md-5 left', 'col-md-7', '', '', '1', '');
    // TemplateHelper::dt_edit_text(FSText::_('Giá thu vào loại 2'), 'price_autumn_2', format_money_0(@$data->price_autumn_2, 'đ'), '', 20, 1, 0, '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_edit_text(FSText::_('Giá thu vào loại 3'), 'price_autumn_3', format_money_0(@$data->price_autumn_3, 'đ'), '', 20, 1, 0, '', '', 'col-md-5 left', 'col-md-7');
    // TemplateHelper::dt_edit_text(FSText::_('Giá thu vào loại 4'), 'price_autumn_4', format_money_0(@$data->price_autumn_4, 'đ'), '', 20, 1, 0, '', '', 'col-md-5 left', 'col-md-7');
// $this->dt_form_end_col();

// $this->dt_form_begin(1, 2, FSText::_('Bộ sản phẩm chuẩn'), 'fa-info', 1, 'col-md-4', '', 1, '');
    // TemplateHelper::dt_edit_text(FSText::_(''), 'product_set', @$data->product_set, '', 500, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
// $this->dt_form_end_col();

// $this->dt_form_begin(1, 2, FSText::_('Khuyến mãi'), 'fa-info', 1, 'col-md-4', '', '1', '');
    // TemplateHelper::dt_edit_text(FSText::_(''), 'accessories', @$data->accessories, '', 500, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
// $this->dt_form_end_col();

// $this->dt_form_begin(1, 2, FSText::_('Khuyến mãi Ngắn gọn'), 'fa-info', 1, 'col-md-4', '', '1', '');
    // TemplateHelper::dt_edit_text(FSText::_(''), 'sale_brief', @$data->sale_brief, '', 500, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
// $this->dt_form_end_col();

// $this->dt_form_begin(1, 2, FSText::_('Bảo hành cơ bản'), 'fa-info', 1, 'col-md-4', '', 1, '');
    // TemplateHelper::dt_edit_text(FSText::_(''), 'basic_warranty', @$data->basic_warranty, '', 500, 6, 1, '', '', 'col-md-12 left', 'col-md-12', '', 1);
// $this->dt_form_end_col();
?>
<script>
    // $('.btn-image').click(function () {
    //     var name = $(this).attr('data-name');
    //     selectFileWithCKFinder(name);
    // });
    $(function() {
        $('.hot_deal_area').hide();
        $('#is_hotdeal_0').click(function() {
            $('.hot_deal_area').slideUp();
        });
        $('#is_hotdeal_1').click(function() {
            $('.hot_deal_area').slideDown();
        });
    });
</script>