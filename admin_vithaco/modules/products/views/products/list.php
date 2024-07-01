<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/jquery-ui.css"/>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<style>
    .update_btn {
        height: 50px;
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        color: #333;
        padding: 5px 20px;
        border-left: 1px solid #fff;
        text-align: center;
        font-size: 12px;
    }
    .update_btn i {
        height: 25px;
        color: #2e6da4;
        font-size: 16px;
        display: flex;
        align-items: center;
    }
    .update_btn span {
        width: 100%;
    }
    .update_btn:hover, .update_btn:focus {
        color: #333;
        text-decoration: none;
        background: #e3e4e4;
    }
</style>
<?php

global $toolbar;
$toolbar->setTitle(FSText:: _('Products'));
// $toolbar->addButtonHTML('<a class="update_btn" href="'.URL_ROOT.'index.php?module=api&view=product&task=api_update_merchant" target="_blank"><i class="fa fa-cloud-upload" aria-hidden="true"></i><span>Update Merchant</span></a>');
// $toolbar->addButton('getAvailableAll', 'getAvailableAll', '', 'save.png');
$toolbar->addButton('duplicate', FSText:: _('Duplicate'), FSText:: _('You must select at least one record'), 'duplicate.png');
$toolbar->addButton('save_all', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('add', FSText:: _('Add'), '', 'add.png');
$toolbar->addButton('edit', FSText:: _('Edit'), FSText:: _('You must select at least one record'), 'edit.png');
$toolbar->addButton('remove', FSText:: _('Remove'), FSText:: _('You must select at least one record'), 'remove.png');
$toolbar->addButton('published', FSText:: _('Published'), FSText:: _('You must select at least one record'), 'published.png');
$toolbar->addButton('unpublished', FSText:: _('Unpublished'), FSText:: _('You must select at least one record'), 'unpublished.png');

$array_status_pro = array(
    1 => FSText::_('Sắp ra mắt'),
    2 => FSText::_('Sắp có hàng trở lại'),
    3 => FSText::_('Đang kinh doanh'),
    4 => FSText::_('Ngừng kinh doanh'),
);
//	FILTER

$filter_config = array();
$fitler_config['search'] = 1;
$fitler_config['text_count'] = 2;
$fitler_config['filter_count'] = 2;

$filter_categories = array();
$filter_categories['title'] = FSText::_('Categories');
$filter_categories['list'] = @$categories;
$filter_categories['field'] = 'treename';

$array_merchant = array(
    1 => FSText::_('Google Shopping'),
);
$page = FSInput::get('page');
// $filter_merchant = array();
// $filter_merchant['title'] = FSText::_('GS');
// $filter_merchant['list'] = @$array_merchant;

$filter_status_pro = array();
$filter_status_pro['title'] = FSText::_('Trạng thái');
$filter_status_pro['list'] = @$array_status_pro;

$text_from_date = array();
$text_from_date['title'] = FSText::_('Từ ngày');

$text_to_date = array();
$text_to_date['title'] = FSText::_('Đến ngày');

$fitler_config['filter'][] = $filter_categories;
//    $fitler_config['filter'][] = $filter_status;
//    $fitler_config['filter'][] = $filter_brands;
$fitler_config['filter'][] = $filter_status_pro;
// $fitler_config['filter'][] = $filter_merchant;
$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;

//	CONFIG
$list_config = array();
$list_config[] = array('title' => 'Image', 'field' => 'image', 'type' => 'image', 'arr_params' => array('width' => 60, 'search' => '/original/', 'replace' => '/resized/'));
$list_config[] = array('title' => 'Tên', 'field' => 'name', 'ordering' => 1, 'type' => 'text_link1', 'col_width' => '200', '', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => 'Price', 'field' => 'price', 'ordering' => 1, 'type' => 'format_money', 'col_width' => '100');
$list_config[] = array('title' => 'Tổng tồn', 'field' => 'quantity', 'ordering' => 1, 'type' => 'text');
// $list_config[] = array('title' => 'Giá trị (tr)', 'field' => 'stockvalue', 'ordering' => 1, 'type' => 'text');
$list_config[] = array('title'=>'Category','field'=>'category_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>5));
// $list_config[] = array('title' =>'Khuyến mại', 'field' => 'is_sell', 'ordering' => 1, 'type' => 'change_status_aj_sell', 'arr_params' => array('function' => 'is_sell'));
// $list_config[] = array('title'=>'Nổi bật','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status_aj_hot','arr_params'=>array('function'=>'is_hot'));
// $list_config[] = array('title' => 'Merchant', 'field' => 'gs', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'gs'));
$list_config[] = array('title' => 'Trang chủ', 'field' => 'show_in_home', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'show_in_home'));
// $list_config[] = array('title' => 'New', 'field' => 'is_new', 'ordering' => 1, 'type' => 'change_status_aj', 'arr_params' => array('function' => 'is_new'));
$list_config[] = array('title' => 'Ordering', 'field' => 'ordering', 'ordering' => 1, 'type' => 'edit_text', 'arr_params' => array('size' => 3));
$list_config[] = array('title' => 'Published', 'field' => 'published', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'published'));
// $list_config[] = array('title' => 'Thu cũ', 'field' => 'is_autumn', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'autumn'));
// $list_config[] = array('title' => 'Đổi mới', 'field' => 'is_renew', 'ordering' => 1, 'type' => 'change_status', 'arr_params' => array('function' => 'renew'));
// $list_config[] = array('title' => 'Edit', 'type' => 'edit');
$list_config[] = array('title' => 'Xem', 'type' => 'preview', 'link' => 'index.php?module=products&view=product&code=code&id=id');

// $list_config[] = array('title' => 'Update giá', 'icon' => 'fa fa-cloud-download', 'type' => 'link_edit', 'link' => '/index.php?module=api&view=product&task=api_update_price_by_product&id=record_id','not_rewrite'=>1);

$list_config[] = array('title' => 'Edited time', 'field' => 'edited_time', 'ordering' => 1, 'type' => 'datetime');
$list_config[] = array('title' => 'SEO title', 'field' => 'seo_title', 'ordering' => 1, 'type' => 'edit_text', 'col_width' => '25%', 'arr_params' => array('size' => 100));
$list_config[] = array('title' => 'SEO keyword', 'field' => 'seo_keyword', 'ordering' => 1, 'type' => 'edit_text', 'col_width' => '25%', 'arr_params' => array('size' => 100));
$list_config[] = array('title' => 'SEO description', 'field' => 'seo_description', 'ordering' => 1, 'type' => 'edit_text', 'col_width' => '25%', 'arr_params' => array('size' => 100,'rows'=>4));

$list_config[] = array('title' => 'Id', 'field' => 'id', 'ordering' => 1, 'type' => 'text');

TemplateHelper::genarate_form_liting($this->module, $this->view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination);
?>
<script>
    $(function () {
        $("#text0").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
        $("#text1").datepicker({clickInput: true, dateFormat: 'dd-mm-yy', changeMonth: true, changeYear: true});
    });
</script>

<style>
    td .select2{
        width: 200px !important;
        text-align: left;
    }
</style>
