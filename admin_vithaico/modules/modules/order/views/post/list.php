<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Danh sách đơn hàng') );
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	//$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 3;
    $fitler_config['text_count'] = 2;
    
    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('Từ ngày'); 
	$fitler_config['text'][] = $text_from_date;
    
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('Đến ngày');  
    $fitler_config['text'][] = $text_to_date;
    
	$filter_status = array();
	$filter_status['title'] =  FSText::_('Trạng thái'); 
	$filter_status['list'] = @$array_obj_status;
    $fitler_config['filter'][] = $filter_status;
    
    $filter_payment = array();
	$filter_payment['title'] =  FSText::_('Hình thức thanh toán'); 
	$filter_payment['list'] = @$array_obj_payment;  
	$fitler_config['filter'][] = $filter_payment;

	$filter_use_status = array();
	$filter_use_status['title'] =  FSText::_('Trạng thái sử dụng'); 
	$filter_use_status['list'] = @$array_obj_use_status;  
	$fitler_config['filter'][] = $filter_use_status;
	//$fitler_config['text'][] = $text_userid;
    
    $list_config = array();
    //$list_config[] = array('title'=>FSText :: _('Mã đơn hàng'),'field'=>'id','ordering'=> 1, );
    $list_config[] = array('title'=>FSText :: _('Mã đơn hàng'),'field'=>'code','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Người mua'),'field'=>'name','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText :: _('Email'),'field'=>'email','ordering'=> 1, 'type'=>'text','col_width' => '5%');
	$list_config[] = array('title'=>FSText :: _('Điện thoại'),'field'=>'mobilephone','ordering'=> 1, 'type'=>'text');
    
    //$list_config[] = array('title'=>FSText :: _('Địa chỉ'),'field'=>'address','ordering'=> 1, 'type'=>'text');
    
	$list_config[] = array('title'=>FSText :: _('Giá trị'),'field'=>'total','ordering'=> 1, 'type'=>'format_money');
    $list_config[] = array('title'=>FSText :: _('Trạng thái sử dụng'),'field'=>'usage_status','ordering'=> 1,'col_width' => '15%', 'type'=>'status','arr_params'=>$array_obj_use_status);
    $list_config[] = array('title'=>FSText :: _('Hình thức thanh toán'),'field'=>'form_of_payment','ordering'=> 1,'col_width' => '15%', 'type'=>'status','arr_params'=>$array_obj_payment);
    $list_config[] = array('title'=>FSText :: _('Trạng thái'),'field'=>'status','ordering'=> 1,'col_width' => '15%','type'=>'status','arr_params'=>$array_obj_status);
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title'=>FSText :: _('Chi tiết'),'type'=>'edit');
	$list_config[] = array('title'=>FSText :: _('Ngày mua'),'field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
	$list_config[] = array('title'=>FSText :: _('ID'),'field'=>'id','ordering'=> 1, 'type'=>'text');
    
    TemplateHelper::genarate_form_liting($this->module,$this -> view,$list,$fitler_config,$list_config,$sort_field,$sort_direct,$pagination);
    
?>
<script>
	$(function() {
		$( "#text0" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
		$( "#text1" ).datepicker({
		  clickInput:true,
          dateFormat: 'dd-mm-yy',
          changeMonth: true,
          numberOfMonths: 2,
          changeYear: true,
          maxDate:  " + d ",
          showMonthAfterYear: true
        });
	});
</script>
