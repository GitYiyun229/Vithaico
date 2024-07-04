<?php
$arr_unitDiscount = array(
    '1' => 'VND',
    '2' => '%',
//            '3' => 'Outlet'
);

TemplateHelper::dt_edit_text(FSText:: _('Title'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"), '', 'col-md-2', 'col-md-10');
TemplateHelper::datetimepicke(FSText:: _('Ngày bắt đầu'), 'date_start', @$data->date_start ? @$data->date_start : '', FSText:: _('Bạn vui lòng chọn thời gian bắt đầu'), 20, '', 'col-md-2', 'col-md-4');
TemplateHelper::datetimepicke(FSText:: _('Ngày kết thúc'), 'date_end', @$data->date_end ? @$data->date_end : '', FSText:: _('Bạn vui lòng chọn thời gian kết thúc'), 20, '', 'col-md-2', 'col-md-4');
TemplateHelper::dt_edit_selectbox(FSText::_('Đơn vị tính'), 'discount_unit', (int)@$data->discount_unit, 0, $arr_unitDiscount, $field_value = 'id', $field_label = 'name', $size = 1, 0, '', '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_text('Giá trị giảm', 'discount', @$data->discount, '', 20, '', '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm áp dụng'), 'multi_categories', @$data->multi_categories, 0, $categories, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-2', 'col-md-10');

//    TemplateHelper::dt_edit_text(FSText:: _('Giảm tiếp (%)'), 'bonus1', @$data->bonus1, '',20,'','','','','col-md-3','col-md-9');
//    TemplateHelper::dt_edit_text(FSText:: _('Khi tổng đơn đạt (VNĐ)'), 'from1', @$data->from1, '',20,'','','Chỉ áp dụng với sản phẩm trong danh sách bên dưới, nhân với giá đã khuyến mại','','col-md-3','col-md-9');
//    TemplateHelper::dt_edit_text(FSText:: _('Giảm tiếp nữa (%)'), 'bonus2', @$data->bonus2, '',20,'','','','','col-md-3','col-md-6');
//    TemplateHelper::dt_edit_text(FSText:: _('Khi tổng đơn đạt (VNĐ)'), 'from2', @$data->from2, '',20,'','','Chỉ áp dụng với sản phẩm trong danh sách bên dưới, nhân với giá của tất cả khuyến mại','','col-md-3','col-md-9');

//TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm KM'), 'promotion_products', @$data->promotion_products, 0, $products, $field_value = 'id', $field_label = 'name', $size = 1, 1, '', '', '', '', 'col-md-2', 'col-md-10');
//    TemplateHelper::dt_edit_text('Giá gốc', 'price_ol', @$data->price_ol, '', 20);
//    TemplateHelper::dt_edit_image(FSText:: _('Image'), 'image', str_replace('/original/', '/resized/', URL_ROOT . @$data->image));
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
//    TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
//    TemplateHelper::dt_edit_text(FSText:: _('Summary'), 'summary', @$data->summary, '', 60, 3, 0);
//    TemplateHelper::dt_edit_text(FSText:: _('Content'), 'content', @$data->content, '', 650, 450, 1);
//    TemplateHelper::dt_edit_text(FSText:: _('Tags'), 'tags', @$data->tags, '', 100, 2);
//    TemplateHelper::dt_sepa();
//    TemplateHelper::dt_edit_text(FSText:: _('SEO title'), 'seo_title', @$data->seo_title, '', 100, 1);
//    TemplateHelper::dt_edit_text(FSText:: _('SEO meta keyword'), 'seo_keyword', @$data->seo_keyword, '', 100, 1);
//    TemplateHelper::dt_edit_text(FSText:: _('SEO meta description'), 'seo_description', @$data->seo_description, '', 100, 9);
?>

<div class="products_related">
    <div class="row">
        <div class="col-xs-12">
            <div class='products_related_search row'>
                <div class="row-item col-xs-6" style="margin-bottom: 20px;">
                    <select class="form-control chosen-select" name="products_related_category_id"
                            id="products_related_category_id">
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
                        <input type="text" placeholder="Tìm kiếm" name='products_related_keyword' class="form-control"
                               value='' id='products_related_keyword'/>
                        <span class="input-group-btn">
							<a id='products_related_search' class="btn btn-default">
								<i class="fa fa-search"></i>
							</a>
						</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-6">
            <div class='title-related'>Danh sách sản phẩm</div>
            <div id='products_related_l'>
                <div id='products_related_search_list'></div>
            </div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id='products_related_r'>
                <!--	LIST RELATE			-->
                <div class='title-related'>Sản phẩm KM</div>
                <ul id='products_sortable_related'>
                    <?php
                    $i = 0;
                    if (isset($data->promotion_products))
                        foreach ($promotion_products as $item) {
                            ?>
                            <li id='products_record_related_<?php echo $item->id ?>'><?php echo $item->name; ?>
                                <a class='products_remove_relate_bt'
                                   onclick="javascript: remove_products_related(<?php echo $item->id ?>)"
                                   href="javascript: void(0)" title='Xóa'>
                                    <img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
                                </a>
                                <br/>
                                <!--                                <img width="80" src="-->
                                <?php //echo URL_ROOT . str_replace('/original/', '/small/', $item->image); ?><!--">-->
                                <input type="hidden" name='promotion_products[]' value="<?php echo $item->id; ?>"/>
                            </li>
                        <?php } ?>
                </ul>
                <!--	end LIST RELATE			-->
                <div id='products_record_related_continue'></div>
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
    // $("#products_sortable_related").sortable();

    function products_add_related() {
        $('#products_related_l').show();
        $('#products_related_l').attr('width', '50%');
        $('#products_related_r').attr('width', '50%');
        $('.products_close_related').show();
        $('.products_add_related').hide();
    }

    function products_close_related() {
        $('#products_related_l').hide();
        $('#products_related_l').attr('width', '0%');
        $('#products_related_r').attr('width', '100%');
        $('.products_add_related').show();
        $('.products_close_related').hide();
    }

    //function search_products_related(){
    $("#products_related_category_id").change(function () {
        var category_id = $('#products_related_category_id').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related(keyword = null, category_id, product_id, str_exist)
    })
    $('#products_related_search').on('click', function () {
        var keyword = $('#products_related_keyword').val();
        if (keyword == '' || keyword == null) {
            alert('Bạn chưa nhập từ khóa tìm kiếm');
            return
        }
        var category_id = $('#products_related_category_id').val();
        var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
        var str_exist = '';
        products_related(keyword, category_id = null, product_id, str_exist);
    });
    $('#products_related_keyword').on('keyup', function (e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            var keyword = $('#products_related_keyword').val();
            if (keyword == '' || keyword == null) {
                alert('Bạn chưa nhập từ khóa tìm kiếm');
                return
            }
            var category_id = $('#products_related_category_id').val();
            var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
            var str_exist = '';
            products_related(keyword, category_id = null, product_id, str_exist);
        }
    });

    //}
    function products_related(keyword, category_id, product_id, str_exist) {

        $("#products_sortable_related li input").each(function (index) {
            if (str_exist != '')
                str_exist += ',';
            str_exist += $(this).val();
        });
        $.get("index2.php?module=promotion&view=hotsale&task=ajax_get_products_related&raw=1", {
            product_id: product_id,
            keyword: keyword,
            category_id: category_id,
            str_exist: str_exist
        }, function (html) {
            $('#products_related_search_list').html(html);
        });
    }

    function gene_all() {
        var ids = $('#gene_all').val();
        var id = ids.split(',');
        var lenth_arr = id.length;
        for (let i = 0; i < lenth_arr; i++) {
            set_products_related(id[i]);
        }
    }

    function set_products_related(id) {
        // var max_related = 10;
        // var length_children = $("#products_sortable_related li").length;
        // if (length_children >= max_related) {
        //     alert('Tối đa chỉ có ' + max_related + ' sản phẩm liên quan');
        //     return;
        // }
        var title = $('.products_related_item_' + id).html();
        var html = '<li id="products_record_related_' + id + '">' + title + '<input type="hidden" name="promotion_products[]" value="' + id + '" />';
        html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_related(' + id + ')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
        html += '</li>';
        $('#products_sortable_related').append(html);
        $('.products_related_item_' + id).hide();
    }

    function remove_products_related(id) {
        $('#products_record_related_' + id).remove();
        $('.products_related_item_' + id).show().addClass('red');
    }
</script>
<style>
    .title-related {
        background: none repeat scroll 0 0 #F0F1F5;
        font-weight: bold;
        margin-bottom: 4px;
        padding: 2px 0 4px;
        text-align: center;
        width: 100%;
    }

    #products_related_search_list {
        height: 400px;
        overflow: scroll;
    }

    .products_related_item {
        /*background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;*/
        border-bottom: 1px solid #EEEEEE;
        cursor: pointer;
        margin: 2px 10px;
        padding: 5px;
    }

    #products_sortable_related {
        height: 380px;
        overflow-y: auto;
    }

    #products_sortable_related li {
        cursor: move;
        list-style: decimal outside none;
        margin-bottom: 8px;
    }

    .products_remove_relate_bt {
        padding-left: 10px;
    }

    .products_related table {
        margin-bottom: 5px;
    }
</style>
