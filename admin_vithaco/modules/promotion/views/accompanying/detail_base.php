<?php
$arr_unitDiscount = array(
    '1' => 'VND',
    '2' => '%',
//            '3' => 'Outlet'
);
$arr_type = array(
    '1' => 'Text',
    '2' => 'Chọn 1',
);
$this->dt_form_begin(1, 2, FSText::_('Thông tin chung'), '', 1, 'col-md-12 fl-left');

TemplateHelper::dt_edit_text(FSText:: _('Title'), 'title', @$data->title, '', '', '', '', '', '', 'col-md-2', 'col-md-10');
//TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"), '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_selectbox(FSText::_('Danh mục sản phẩm'), 'multi_categories', @$data->multi_categories, 0, $categories, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm'), 'products_main', @$data->products_main, 0, $products, $field_value = 'id', $field_label = 'name', $size = 1, 1, '', '', '', '', 'col-md-2', 'col-md-10');
//    TemplateHelper::dt_edit_image(FSText:: _('Icon'), 'image', str_replace('/original/', '/original/', URL_ROOT . @$data->image), '', '', '', 'col-md-2 right', 'col-md-10');
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-md-2', 'col-md-10');
TemplateHelper::dt_edit_selectbox(FSText::_('Loại quà tặng'), 'is_shared', (int)@$data->is_shared, 0, $arr_type, $field_value = 'id', $field_label = 'name', $size = 1, 0, '', '', '', '', 'col-md-2', 'col-md-10');

TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20', 1, 0, '', '', 'col-md-2', 'col-md-10');
//    TemplateHelper::dt_edit_text(FSText:: _('Summary'), 'summary', @$data->summary, '', 60, 3, 0);
//    TemplateHelper::dt_edit_text(FSText:: _('Nội dung'), 'content', @$data->content, '', 650, 450, 1,'', '', 'col-xs-12 left mt10', 'col-xs-12');
//    TemplateHelper::dt_edit_text(FSText:: _('Tags'), 'tags', @$data->tags, '', 100, 2);
$this->dt_form_end_col(); // END: col-1

?>


<style>
    .mt10{
        margin-bottom: 10px!important;
    }
    .title-related {
        background: none repeat scroll 0 0 #F0F1F5;
        font-weight: bold;
        margin-bottom: 4px;
        padding: 2px 0 4px;
        text-align: center;
        width: 100%;
    }

    .col-md-12 {
        padding: 0;
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

    #products_sortable_related li, #products_sortable_related_hot li {
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

    #products_related_l #products_related_search_list .actived {
        opacity: 0.6;
        pointer-events: none;
    }
</style>
