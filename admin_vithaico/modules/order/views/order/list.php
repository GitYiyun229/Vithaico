<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<?php
global $toolbar;
$toolbar->setTitle(FSText:: _('Danh sách đơn hàng'));
$toolbar->addButton('edit', FSText:: _('Edit'), FSText:: _('You must select at least one record'), 'edit.png');
//$toolbar->addButton('remove', FSText:: _('Remove'), FSText:: _('You must select at least one record'), 'remove.png');
//$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
//	FILTER
$filter_config = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 1;
$fitler_config['text_count'] = 2;

$array_obj_status2 = array(
    1 => 'Có',
    2 => 'Không'
);

$text_from_date = array();
$text_from_date['title'] = FSText::_('Từ ngày');

$text_to_date = array();
$text_to_date['title'] = FSText::_('Đến ngày');

$filter_status = array();
$filter_status['title'] = FSText::_('Trạng thái');
$filter_status['list'] = $array_obj_status;

// $filter_status1 = array();
// $filter_status1['title'] = FSText::_('Trạng thái Bảo Kim');
// $filter_status1['list'] = @$array_obj_status1;


// $filter_status3 = array();
// $filter_status3['title'] = FSText::_('Trạng thái Kredivo');
// $filter_status3['list'] = @$array_obj_status_k;


// $filter_status2 = array();
// $filter_status2['title'] = FSText::_('Trạng thái đồng bộ Bitrix');
// $filter_status2['list'] = @$array_obj_status2;



$fitler_config['filter'][] = $filter_status;
// $fitler_config['filter'][] = $filter_status1;
// $fitler_config['filter'][] = $filter_status2;
// $fitler_config['filter'][] = $filter_status3;
$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;
//$fitler_config['text'][] = $text_userid;

$list_config = array();
$list_config[] = array('title' => FSText:: _('Mã đơn hàng'), 'field' => 'id', 'ordering' => 1, 'type' => 'order');
$list_config[] = array('title' => FSText:: _('Người mua'), 'field' => 'recipients_name', 'ordering' => 1, 'type' => 'text');
//$list_config[] = array('title' => FSText:: _('Email'), 'field' => 'sender_email', 'ordering' => 1, 'type' => 'text');
$list_config[] = array('title' => FSText:: _('Điện thoại'), 'field' => 'recipients_telephone', 'ordering' => 1, 'type' => 'text');

$list_config[] = array('title' => FSText:: _('Giá trị'), 'field' => 'total_end', 'ordering' => 1, 'type' => 'format_money');
$list_config[] = array('title' => FSText:: _('Trạng thái đơn hàng'), 'field' => 'status', 'ordering' => 1, 'type' => 'status', 'arr_params' => $array_obj_status);
// $list_config[] = array('title' => FSText:: _('Trạng thái Bảo Kim'), 'field' => 'status_bk', 'ordering' => 1, 'type' => 'status', 'arr_params' => $array_obj_status1);
// $list_config[] = array('title' => FSText:: _('Trạng thái Kredivo'), 'field' => 'status_kredivo_int', 'ordering' => 1, 'type' => 'status', 'arr_params' => $array_obj_status_k);
$list_config[] = array('title' => FSText:: _('Trạng thái thanh toán'), 'field' => 'payment_status', 'ordering' => 1, 'type' => 'status', 'arr_params' => $array_obj_payment_status);
$list_config[] = array('title' => FSText:: _('Hình thức thanh toán'), 'field' => 'payment_method', 'ordering' => 1, 'type' => 'status', 'arr_params' => $array_obj_payment_method);
// $list_config[] = array('title' => FSText:: _('Trạng thái Bitrix'), 'field' => 'bitrix_id', 'ordering' => 1, 'type' => 'sync_status');
// $list_config[] = array('title' => 'Đồng bộ Bitrix', 'icon' => 'fa fa-cloud-upload', 'type' => 'link_edit', 'link' => '/index.php?module=api&view=order&task=api_bitrix_sync_order&type=order&id=record_id','not_rewrite'=>1);

//$list_config[] = array('title' => FSText:: _('Mã giao dịch BK'), 'field' => 'reference_id', 'ordering' => 1, 'type' => 'text');
$list_config[] = array('title' => FSText:: _('Chi tiết'), 'type' => 'edit');
$list_config[] = array('title' => FSText:: _('Ngày mua'), 'field' => 'created_time', 'ordering' => 1, 'type' => 'datetime');


TemplateHelper::genarate_form_liting($this->module, $this->view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination);

?>
<script>
    $(function () {
        $("#text0").datepicker({
            clickInput: true,
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            numberOfMonths: 2,
            changeYear: true,
            maxDate: " + d ",
            showMonthAfterYear: true
        });
        $("#text1").datepicker({
            clickInput: true,
            dateFormat: 'dd-mm-yy',
            changeMonth: true,
            numberOfMonths: 2,
            changeYear: true,
            maxDate: " + d ",
            showMonthAfterYear: true
        });
    });
</script>
