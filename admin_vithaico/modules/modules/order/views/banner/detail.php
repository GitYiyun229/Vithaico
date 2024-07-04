<!-- HEAD -->
<?php
	$title = @$order ? FSText :: _('Xem đơn hàng ').' '.$order->code: FSText :: _('Add'); 
	global $toolbar;
    
	$toolbar->setTitle($title);
    $toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
    
	$toolbar->addButton('',FSText :: _('Print'),'','print.png',0,1); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');
    
    $payment_array = array(
                        1=>FSText::_('Thanh toán Thẻ tín dụng/Thẻ ghi nợ'),
                        2=>FSText::_('Thanh toán Thẻ ATM'),
                        3=>FSText::_('Thanh toán chuyển khoản'),
                        4=>FSText::_('Thanh toán trực tiếp'),
                    );
                    
    $array_status = array( 
                        1 => FSText::_('Đã hoàn tất'),
                        2 => FSText::_('Đã thanh toán online'),
                        3 => FSText::_('Chưa hoàn tất'),
                        4 => FSText::_('Đã hủy')
                    );
                    
    $value_vocher = '';                
    if($order -> code_vocher){
        if($order->type_vocher == 1)
            $value_vocher = '-'.$order->value_vocher.'%';
        else
            $value_vocher = '-'.$order->value_vocher.'VNĐ';
    }                
                    
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Thông tin cơ bản'),'fa-edit',1,'col-md-8 col-xs-12',1);
        //$category_id = isset($order -> category_id)?$order -> category_id:$cid;
    	TemplateHelper::dt_text(FSText :: _('Họ tên người mua hàng'),@$order -> name);
    	TemplateHelper::dt_text(FSText :: _('Điện thoại'),@$order -> mobilephone);
        
        TemplateHelper::dt_text(FSText :: _('Email'),@$order -> email);
        TemplateHelper::dt_text(FSText :: _('Đơn vị/tổ chức'),@$order -> name_training);
        TemplateHelper::dt_text(FSText :: _('Địa chỉ'),@$order -> address);
        TemplateHelper::dt_text(FSText :: _('Mã số thuế'),@$order -> tax_code);
        TemplateHelper::dt_text(FSText :: _('Ghi chú'),@$order -> note);
        TemplateHelper::dt_text(FSText :: _('Mã giảm giá'),@$order -> code_vocher);
        TemplateHelper::dt_text(FSText :: _('Giá trị mã giảm giá'),$value_vocher);
        TemplateHelper::dt_text(FSText :: _('Tổng giá trị đơn hàng'),'<strong style="color: #F44336;font-size: 16px;">'.format_money($order->total,' VNĐ','0').'</strong>','','',0);
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Admin'),'fa-user',1,'col-md-4');
        TemplateHelper::dt_text(FSText :: _('Người Duyệt trạng thái'),@$order -> user_approval? @$order -> user_approval:FSText::_('Tự động'),'','','','col-md-4','col-md-8');
        TemplateHelper::dt_text( FSText :: _('Thời gian duyệt' ), @$order->time_approval?@$order->time_approval:'','','','','col-md-4','col-md-8');
        TemplateHelper::dt_text(FSText :: _('Người kích hoạt'),@$order -> user_edited? @$order -> user_edited:FSText::_('Tự động'),'','','','col-md-4','col-md-8');
        TemplateHelper::dt_text( FSText :: _('Thời gian kích hoạt' ), @$order->time_edited?@$order->time_edited:'','','','','col-md-4','col-md-8');
        TemplateHelper::dt_text(FSText :: _('User sửa'),@$order -> user_admin_name,'','','','col-md-4','col-md-8');  
        TemplateHelper::dt_text(FSText :: _('Thời gian sửa'), @$order->edited_time?@$order->edited_time:'','', '','','col-md-5','col-md-7');      
    $this->dt_form_end_col(); // END: col-2
    
    $this -> dt_form_begin(1,2,FSText::_('Thời gian'),'fa-clock-o',1,'col-md-4');
        TemplateHelper::dt_text(FSText :: _('Thời gian tạo'), @$order->created_time?@$order->created_time:'','', '','','col-md-5','col-md-7');
        TemplateHelper::dt_text(FSText :: _('Ngày kích hoạt dịch vụ'), @$order->date_start?@$order->date_start:'','','','','col-md-5','col-md-7');
        //TemplateHelper::datetimepicke(FSText :: _('Ngày hết hạn'),show_datetime($order->date_end),'','','','col-md-5','col-md-7');
        TemplateHelper::dt_text( FSText :: _('Ngày hết hạn' ), @$order->date_end?@$order->date_end:'','', '','','col-md-5','col-md-7');
    $this->dt_form_end_col();  //END: col-4

    include_once 'detail_estore.php';
    
    $this -> dt_form_begin(1,2,FSText::_('Trạng thái và hình thức thanh toán'),'fa-bullhorn',1,'col-md-4 fl-right');
        //TemplateHelper::dt_edit_selectbox(FSText::_('Hình thức thanh toán'),'',@$order->form_of_payment,0,$payment_array,$field_value = '', $field_label='',$size = 1,0,'','','','','col-md-4','col-md-8','form_of_payment');
        TemplateHelper::dt_text(FSText :: _('Hình thức thanh toán'),$payment_array[$order->form_of_payment],'','',1,'col-md-4','col-md-8');
        TemplateHelper::dt_edit_selectbox(FSText::_('Trạng thái đơn hàng'),@$order->status != 3? '':'status',@$order->status,0,$array_status,$field_value = '', $field_label='',$size = 1,0,'','','','','col-md-4','col-md-8','status');
        //TemplateHelper::dt_text(FSText :: _('Trạng thái'),$array_status[$order->status],'','',1,'col-md-4','col-md-8');
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$order -> published,1,'','','','col-md-4','col-md-8');
    $this->dt_form_end_col();  //END: col-4
    
    $this -> dt_form_end(@$order,1,0,2,'Cấu hình seo','',1,'col-sm-4');   
?>

<!-- end FORM	MAIN - ORDER						-->
 
<!--  ESTORE INFO -->
<?php ?>
<!--  end ESTORE INFO -->

<!--  RECIPIENT INFO -->
<?php //include_once 'detail_recipient.php';?>
<!--  end RECIPIENT INFO --> 

<?php // include_once 'detail_payment.php';?>
<!-- END BODY-->

<script  type="text/javascript" language="javascript">
	print_page();
	function print_page(){
		var width = 800;
		var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
		$('.Print').click(function(){
			link = window.location.href;
			link += '&print=1';
			window.open(link, "","width="+width+",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left="+ centerWidth + ",top=0");
		});
	}
</script>
