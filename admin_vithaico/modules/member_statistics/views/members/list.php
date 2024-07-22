<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php
global $toolbar;
$toolbar->setTitle(FSText::_('Danh sách thành viên '));
$toolbar->addButton('edit', FSText::_('Edit'), FSText::_('You must select at least one record'), 'edit.png');

//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 1;
$fitler_config['text_count'] = 2;
$type_member = [
	1 => 'Tạm thời',
	2 => 'Thường',
	3 => 'Đại Lý',
	4 => 'Đại lý cấp 1',
	5 => 'Tổng đại lý',
	6 => 'Nhà phân phối',
	7 => 'Giám đốc kinh doanh',
];
$filter_type = array();
$filter_type['title'] = FSText::_('Loại thành viên');
$filter_type['list'] = @$type_member;
$filter_type['field'] = 'name';

$text_from_date = array();
$text_from_date['title'] =  FSText::_('From day');

$text_to_date = array();
$text_to_date['title'] =  FSText::_('To day');

//$fitler_config['filter'][] = $filter_categories;
$fitler_config['filter'][] = $filter_type;
$fitler_config['text'][] = $text_from_date;
$fitler_config['text'][] = $text_to_date;

//	CONFIG	
$list_config = array();
$list_config[] = array('title' => 'Họ và tên', 'field' => 'full_name', 'type' => 'text', 'align' => 'left');
$list_config[] = array('title' => 'telephone', 'field' => 'telephone', 'type' => 'text', 'align' => 'left');
$list_config[] = array('title' => 'Email', 'field' => 'email', 'ordering' => 1, 'type' => 'text', 'col_width' => '10%', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => 'Created time', 'field' => 'created_time', 'ordering' => 1, 'type' => 'datetime');
$list_config[] = array('title' => 'Published', 'field' => 'published', 'ordering' => 1, 'type' => 'published');
$list_config[] = array('title' => 'Số F1', 'field' => 'count_f1', 'ordering' => 1, 'type' => 'text', 'col_width' => '7%', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => 'Số VT-Coin', 'field' => 'total_coin_member', 'ordering' => 1, 'type' => 'text', 'col_width' => '7%', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => '%Hoa hồng', 'field' => 'hoa_hong', 'ordering' => 1, 'type' => 'text', 'col_width' => '7%', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => 'Số đơn hàng', 'field' => 'total_list_order', 'ordering' => 1, 'type' => 'text', 'col_width' => '7%', 'arr_params' => array('size' => 30));
$list_config[] = array('title' => 'Số đơn hàng F1', 'field' => 'total_list_orderf1', 'ordering' => 1, 'type' => 'text', 'col_width' => '7%', 'arr_params' => array('size' => 30));
															// $list_config[] = array('title' => 'Id', 'field' => 'id', 'ordering' => 1, 'type' => 'text');
															$list_config[] = array('title' => 'Chi tiết', 'type' => 'edit');

TemplateHelper::genarate_form_liting($this->module, $this->view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination);
?>
<script>
	$(function() {
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
<script type="text/javascript" language="javascript">
	//configOpenPopup(1);
	//	function configOpenPopup(){
	//		$('.Export').click(function(){
	//			$.get('index.php?module=members&view=members&task=quality_export&raw=1',function(response){
	//					Dialog.insertDom('zone-reason-new-detail','Số bản ghi muốn export',response);
	//					$("#zone-reason-new-detail").dialog({open: function() {$(".ui-dialog").css({width: '620px', left: '400px',top: '200px'});},modal:true,shadow:false,close:function(){$('#zone-reason-new-detail').remove();}});
	//			});
	//		});
	//	}
	//configClickExport(1);
	//function configClickExport(){
	//	$('#submit_quality').click(function(){
	//		var start=$('#start_at').val();
	//		var end=$('#end_at').val();
	//		$.get('index.php?module=members&view=members&task=export_excel&raw=1&start='+start+'&end='+end,function(response){
	//			if(response != "error"){
	//				window.open(response);	
	//			}else{	
	//				alert("Không có thành viên nào");
	//			}
	//		});
	//		alert("Export thành công");
	//	});
	//}
</script>
<!--
<script type="text/javascript" language="javascript" src="<?php echo URL_ROOT . '/libraries/jquery.ui/ui.core.js'; ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo URL_ROOT . '/libraries/jsobj/Dialog.js'; ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo URL_ROOT . '/libraries/jquery.ui/ui.draggable.js'; ?>"></script>
<script type="text/javascript" language="javascript" src="<?php echo URL_ROOT . '/libraries/jquery.ui/ui.dialog.js'; ?>"></script> -->