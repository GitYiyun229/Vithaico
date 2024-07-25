<?php
$this->dt_form_begin(1, 2, FSText::_('Hot sale'), 'fa-fire', 1, 'col-md-12 fl-left');
TemplateHelper::dt_edit_selectbox(FSText::_('Đơn vị tính'), 'discount_unit_hot', (int)@$hot_sale->discount_unit, 0, $arr_unitDiscount, $field_value = 'id', $field_label = 'name', $size = 1, 0, '', '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_text('Giá trị giảm', 'discount_hot', @$hot_sale->discount, '', 20, '', '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_checkbox(FSText::_('Áp dụng cho tất cả'), 'is_shared_hot', @$hot_sale->is_shared, 0, '', '', 'Áp dụng giá trị giảm cho tất cả các sản phẩm được chọn bên dưới', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm áp dụng'), 'multi_categories_hot', @$hot_sale->multi_categories, 0, $categories, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-2', 'col-md-10');
?>
<div class="products_related">
    <div class="row">
        <div class="col-xs-12">
            <div class='products_related_search row'>
                <div class="row-item col-xs-6" style="margin-bottom: 20px;">
                    <select class="form-control chosen-select" name="products_related_category_id_hot"
                            id="products_related_category_id_hot">
                        <option value="">Danh mục</option>
                        <?php
                        foreach ($categories as $item) {
                            ?>
                            <option value="<?php echo $item->id; ?>"><?php echo $item->treename; ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="row-item col-xs-6">
                    <div class="input-group custom-search-form">
                        <input type="text" placeholder="Tìm kiếm" name='save_hot_sale_items_hot' class="form-control"
                               value='' id='save_hot_sale_items_hot'/>
                        <span class="input-group-btn">
							<a id='products_related_search_hot' class="btn btn-default">
								<i class="fa fa-search"></i>
							</a>
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class='title-related'>Danh sách sản phẩm</div>
            <div id='products_related_l_hot'>
                <div id='products_related_search_list_hot'></div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id='products_related_r_hot'>
                <!--	LIST RELATE			-->
                <div class='title-related'>Sản phẩm KM</div>
                <ul id='products_sortable_related_hot'>
                    <?php
                    $i = 0;
                    if (@$hot_sale->promotion_products)
                        foreach ($hot_products as $item) {
                            $model = $this->model;
                            $data_sale_item = $model->get_hot_sale_items($item->id, $hot_sale->id);
                            ?>
                            <li id='products_record_related_hot_<?php echo $item->id ?>'><?php echo $item->name; ?>
                                <a class='products_remove_relate_bt'
                                   onclick="javascript: remove_products_related_hot(<?php echo $item->id ?>)"
                                   href="javascript: void(0)" title='Xóa'>
                                    <img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
                                </a>
                                <br/>
                                <div class="top_title"
                                     style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 5px; margin-top: 10px">
                                    <span>Đơn vị:</span>
                                    <span>Giá trị giảm:</span>
                                    <span>Số lượng KM:</span>
                                    <span>Số lượng đã đặt:</span>
                                </div>
                                <div class="box_val"
                                     style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 5px">
                                    <select class="form-control" name="discount_unit_hot_<?php echo $item->id ?>"
                                            id="discount_unit_hot_<?php echo $item->id ?>">
                                        <?php
                                        $i = 1;
                                        foreach ($arr_unitDiscount as $key) {
                                            $selected = '';
                                            if ($data_sale_item->discount_unit == $i)
                                                $selected = 'selected';
                                            ?>
                                            <option value="<?php echo $i; ?>" <?= $selected ?>><?php echo $key; ?> </option>
                                            <?php $i++;
                                        } ?>
                                    </select>
                                    <input class="form-control" type="text" value="<?= $data_sale_item->discount ?>"
                                           name="discount_hot_<?php echo $item->id ?>"
                                           id="discount_hot_<?php echo $item->id ?>">
                                    <input class="form-control" type="text" value="<?= $data_sale_item->total ?>"
                                           name="total_hot_<?php echo $item->id ?>"
                                           id="total_hot_<?php echo $item->id ?>">
                                    <input class="form-control" type="text" value="<?= $data_sale_item->ordered ?>"
                                           name="ordered_hot_<?php echo $item->id ?>"
                                           id="ordered_hot_<?php echo $item->id ?>">
                                </div>
                                <!--                                <img width="80" src="-->
                                <?php //echo URL_ROOT . str_replace('/original/', '/small/', $item->image); ?><!--">-->
                                <input type="hidden" name='promotion_products_hot[]' value="<?php echo $item->id; ?>"/>
                            </li>
                        <?php } ?>
                </ul>
                <!--	end LIST RELATE			-->
                <div id='products_record_related_hot_continue'></div>
            </div>
        </div>

        <!--<div class='products_close_related col-xs-12' style="display:none">
                <a href="javascript:products_close_related()"><strong class='red'>Đóng</strong></a>
            </div>
            <div class='products_add_related col-xs-12'>
                <a href="javascript:products_add_related()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
            </div> -->
    </div>
</div>
<?php
$this->dt_form_end_col(); // END: col-1
?>
<script type="text/javascript" language="javascript">
    // $(function () {
    //     $("#date_end").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    //     $("#date_end").change(function () {
    //         document.formSearch.submit();
    //     });
    //     $("#date_start").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    //     $("#date_start").change(function () {
    //         document.formSearch.submit();
    //     });
    // });
</script>

<script type="text/javascript">
    //search_products_related();
    // $("#products_sortable_related_hot").sortable();

    function products_add_related() {
        $('#products_related_l_hot').show();
        $('#products_related_l_hot').attr('width', '50%');
        $('#products_related_r_hot').attr('width', '50%');
        $('.products_close_related').show();
        $('.products_add_related').hide();
    }

    function products_close_related() {
        $('#products_related_l_hot').hide();
        $('#products_related_l_hot').attr('width', '0%');
        $('#products_related_r_hot').attr('width', '100%');
        $('.products_add_related').show();
        $('.products_close_related').hide();
    }

    //function search_products_related(){
    $("#products_related_category_id_hot").change(function () {
        var category_id = $('#products_related_category_id_hot').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related_hot(keyword = null, category_id, product_id, str_exist)
    })
    $('#products_related_search_hot').on('click', function () {
        var keyword = $('#save_hot_sale_items_hot').val();
        if (keyword == '' || keyword == null) {
            alert('Bạn chưa nhập từ khóa tìm kiếm');
            return
        }
        var category_id = $('#products_related_category_id_hot').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related_hot(keyword, category_id = null, product_id, str_exist);
    });
    $('#save_hot_sale_items_hot').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var keyword = $('#save_hot_sale_items_hot').val();
            if (keyword == '' || keyword == null) {
                alert('Bạn chưa nhập từ khóa tìm kiếm');
                return
            }
            var category_id = $('#products_related_category_id_hot').val();
            var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
            var str_exist = '';
            products_related_hot(keyword, category_id = null, product_id, str_exist);
        }
    });

    //}
    function products_related_hot(keyword, category_id, product_id, str_exist) {

        $("#products_sortable_related_hot li input").each(function (index) {
            if (str_exist != '')
                str_exist += ',';
            str_exist += $(this).val();
        });
        $.get("index2.php?module=promotion&view=promotion&task=ajax_get_products_related_hot&raw=1", {
            product_id: product_id,
            keyword: keyword,
            category_id: category_id,
            str_exist_hot: str_exist
        }, function (html) {
            $('#products_related_search_list_hot').html(html);
        });
    }

    function gene_all_hot() {
        var ids = $('#gene_all_hot').val();
        var id = ids.split(',');
        var lenth_arr = id.length;
        for (var i = 0; i < lenth_arr; i++) {
            set_products_related_hot(id[i]);
        }
    }

    function set_products_related_hot(id) {
        // var max_related = 10;
        // var length_children = $("#products_sortable_related_hot li").length;
        // if (length_children >= max_related) {
        //     alert('Tối đa chỉ có ' + max_related + ' sản phẩm liên quan');
        //     return;
        // }
        var title = $('.products_related_item_' + id).html();
        var html = '<li id="products_record_related_hot_' + id + '">' + title + '<input type="hidden" name="promotion_products_hot[]" value="' + id + '" />';
        html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related_hot(' + id + ')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
        html += '<div class="top_title" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 5px; margin-top: 10px">';
        html += '<span>Đơn vị:</span>';
        html += '<span>Giá trị giảm:</span>';
        html += '<span>Số lượng KM:</span>';
        html += '<span>Số lượng đã đặt:</span>';
        html += '</div>';
        html += '<div class="box_val" style="display: grid; grid-template-columns: 1fr 1fr 1fr 1fr;grid-gap: 5px">';
        html += '<select class="form-control" name="discount_unit_hot_' + id + '" id="discount_unit_hot_' + id + '">';
        html += '<option value="">Đơn vị</option>';
        <?php
        $i = 1;
        foreach ($arr_unitDiscount as $key) {?>
        html += '<option value="<?php echo $i; ?>"><?php echo $key; ?> </option>';
        <?php $i++;} ?>
        html += '</select>';
        html += '<input class="form-control" type="text" value="" name="discount_hot_' + id + '" id="discount_hot_' + id + '">';
        html += '<input class="form-control" type="text" value="" name="total_hot_' + id + '" id="total_hot_' + id + '">';
        html += '<input class="form-control" type="text" value="" name="ordered_hot_' + id + '" id="ordered_hot_' + id + '">';
        html += '</div>';
        html += '</li>';
        $('#products_sortable_related_hot').append(html);
        $('.products_related_item_' + id).hide();
    }

    function remove_products_related_hot(id) {
        $('#products_record_related_hot_' + id).remove();
        $('.products_related_item_' + id).show().addClass('red');
    }
</script>
