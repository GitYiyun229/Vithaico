<?php
	$title = @$data ? FSText :: _('Sửa'): FSText :: _('Thêm mới');
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png');
	$toolbar->addButton('save',FSText::_('Save'),'','save.png');
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');
    
    $array_group = array(
                            0=>FSText::_('không xác định'),
                            1=>FSText::_('Jobpro Main Page'),
                            2=>FSText::_('Job Search Main Page'),
                            3=>FSText::_('Autorefresh'),
                            4=>FSText::_('Emphasis Effect'),
                            5=>FSText::_('Package Product'),
                            6=>FSText::_('Sản Phẩm Tìm Hồ Sơ'),
                            7=>FSText::_('Sản Phẩm Tin Nhắn (SMS)'),
                            8=>FSText::_('JOBPRO First Page'),
                        );
                        
    $calculators  = array(
							//1 => '==',
							2 => '>',
							//3 => '<',
							//4 => '>= ',
							//5 => ' <= ',
							//6 => ' > value1 AND < value2',
							7 => ' > value1 AND <= value2',
							//8 => ' >= value1 AND < value2',
							//9 => ' >= value1 AND <= value2 ',
						);

	//$this -> dt_form_begin();
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('Dịch vụ'),'fa-edit',1,'col-md-8',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        //TemplateHelper::dt_edit_text(FSText :: _('Tên trường'),'name_field',@$data -> name_field,'','','','',FSText::_('Trường dùng để so sánh với bảng tuyển dụng (dành cho coder)'));
        
        TemplateHelper::dt_edit_text(FSText :: _('Name en'),'name_en',@$data -> name_en);
        TemplateHelper::dt_edit_text(FSText :: _('Name kr'),'name_kr',@$data -> name_kr);
    	//TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image);
        
    	//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
	//$this -> dt_form_end(@$data);
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,8,FSText::_('Cấu hình'),'fa-gear fa-spin fa-fw',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_selectbox(FSText::_('loại dịch vụ'),'group_id',@$data -> group_id,0,$categories,$field_value = 'id', $field_label='name',$size = 10,0);
        //TemplateHelper::dt_checkbox(FSText::_('loại dịch vụ'),'group_id',@$data -> group_id,0,$array_group);
    	TemplateHelper::dt_edit_text(FSText :: _('Giá'),'price',@$data -> price,0,'','','',FSText::_('VNĐ'));
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        TemplateHelper::dt_checkbox(FSText::_('Loại DV kèm theo'),'is_bonus',@$data -> is_bonus,0);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        TemplateHelper::dt_checkbox(FSText::_('Loại kiểu áp dụng'),'is_type',@$data -> is_type,0,array(0=>FSText::_('kiểu select chọn'),1=>FSText::_('Kiểu tự điền số lượng')));
        TemplateHelper::dt_edit_text(FSText :: _('Số lượng thấp nhất'),'min',@$data -> min,0,'','','',FSText::_('áp dụng cho kiểu điền số lượng'));
        //TemplateHelper::dt_edit_text(FSText :: _('Số lượng thấp nhất'),'name',@$data -> name,0);
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,2,FSText::_('Mô tả dịch vụ'),'fa-info',1,'col-md-8');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
    $this -> dt_form_begin(1,8,FSText::_('Cấu hình vị trí banner'),'fa-gear fa-spin fa-fw',1,'col-md-4 fl-right');
        TemplateHelper::dt_edit_selectbox(FSText::_('Vị trí banner'),'cat_banner_id',@$data -> cat_banner_id,0,$categories_banner,$field_value = 'id', $field_label='name',$size = 10,0,1,FSText::_('áp dụng cho dịch vụ banner'));
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,7,FSText::_('Dịch vụ tặng kèm'),'fa-th-list',1,'col-md-4');
        TemplateHelper::dt_edit_selectbox('','bundled_services',@$data -> bundled_services,0,$list_post,$field_value = 'id', $field_label='name',$size = 10,1,'','','','','','col-md-12');    
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,9,FSText::_('Cấu hình giảm giá dịch vụ chọn kiểu select'),'fa-gear fa-spin fa-fw',1,'col-md-8');
        include 'detail_base.php';
    $this->dt_form_end_col();

    $this -> dt_form_begin(1,7,FSText::_('Dịch vụ được áp dụng đồng thời'),'fa-th-list',1,'col-md-4');
        TemplateHelper::dt_edit_selectbox('','list_service',@$data -> list_service,0,$list_post,$field_value = 'id', $field_label='name',$size = 10,1,'','','','','','col-md-12');    
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,2,FSText::_('Cấu hình giảm giá dịch vụ tự điền số lượng'),'fa-gear fa-spin fa-fw',1,'col-md-8');
        include 'detail_config.php';
    $this->dt_form_end_col();
    
     $this -> dt_form_begin(1,2,FSText::_('Mô tả dịch vụ - anh'),'fa-info',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary_en',@$data -> summary_en,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
     $this -> dt_form_begin(1,2,FSText::_('Mô tả dịch vụ - hàn'),'fa-info',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary_kr',@$data -> summary_kr,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
    
    $this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>

<input type="hidden" id="service_id" value="<?php echo @$data->id? $data->id:$uploadConfig; ?>" />
<input type="hidden" id="stt" value="<?php echo @$data->id? 1:0; ?>" />
<script>
function myFunction(message = '') {
    if(!message)
        return false;
        
    $('#snackbar').text(message);
    
    snackbar
    // Get the snackbar DIV
    var x = document.getElementById("snackbar")
    // Add the "show" class to DIV
    x.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
<style>
    .delete{
        color: red;
        cursor: pointer;
    }
    .keyword .form-group {
        margin-right: 0px;
        margin-left: 0px;
    }
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }
    
    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    
    @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    
    @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    
    @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
    
    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
</style>
