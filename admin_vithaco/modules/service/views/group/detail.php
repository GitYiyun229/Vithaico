<?php
	$title = @$data ? FSText :: _('Sửa'): FSText :: _('Thêm mới');
	global $toolbar;
	$toolbar->setTitle($title);
	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
	$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png');
	$toolbar->addButton('save',FSText::_('Save'),'','save.png');
	$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');

    $calculators  = array(
							//1 => '==',
							2 => '>',
							3 => '<',
							//4 => '>= ',
							//5 => ' <= ',
							//6 => ' > value1 AND < value2',
							7 => ' > value1 AND <= value2',
							8 => ' >= value1 AND < value2',
							//9 => ' >= value1 AND <= value2 ',
						);
	//$this -> dt_form_begin();
    $this -> dt_form_begin(1,4,$title.' '.FSText::_('E-marketing'),'fa-edit',1,'col-md-12',1);
    	TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
    	TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        
        TemplateHelper::dt_edit_text(FSText :: _('Name en'),'name_en',@$data -> name_en);
        TemplateHelper::dt_edit_text(FSText :: _('Name kr'),'name_kr',@$data -> name_kr);
        
        TemplateHelper::dt_checkbox(FSText::_('Áp dụng tích lũy J-point'),'is_jpoint',@$data -> is_jpoint,0);
    	// TemplateHelper::dt_edit_selectbox(FSText::_('Sử dụng cho các bảng'),'tablenames',@$data -> tablenames,0,$tables,'table_name','table_name',$size = 10,1,0,'Giữ phím Ctrl để chọn nhiều item');
    	TemplateHelper::dt_checkbox(FSText::_('Dịch vụ package'),'is_package',@$data -> is_package,0);
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
    	TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
    
    	//TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',650,450,1);
    	//TemplateHelper::dt_edit_text(FSText :: _('Content'),'contents',@$data -> contents,'',650,450,1);
    $this->dt_form_end_col(); // END: col-1
    
    $this -> dt_form_begin(1,2,FSText::_('Cấu hình Phần trăm tích lũy J-point'),'fa-gear fa-spin fa-fw',1,'col-md-12');
        include 'detail_config.php';
    $this->dt_form_end_col();
    
    $this -> dt_form_begin(1,2,FSText::_('Mô tả dịch vụ'),'fa-info',1,'col-md-12');
        TemplateHelper::dt_edit_text(FSText :: _(''),'summary',@$data -> summary,'',650,450,1,'','','col-sm-2','col-sm-12');
        //TemplateHelper::dt_edit_text(FSText :: _('Thông tin chi tiết'),'description',@$data -> description,'',650,450,1,'','','col-sm-2','col-sm-12');
    $this->dt_form_end_col(); // END: col-4
    
    $this->dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
	//$this -> dt_form_end(@$data);
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