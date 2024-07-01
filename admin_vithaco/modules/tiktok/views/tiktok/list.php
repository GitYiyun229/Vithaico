<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Tiktok') );
	//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
	// $toolbar->addButton('show_in_homepage',FSText :: _('Hiển thị trang chủ'),FSText :: _('You must select at least one record'),'show_in_homepage.svg');
	// $toolbar->addButton('unshow_in_homepage',FSText :: _('Ngừng hiển thị trang chủ'),FSText :: _('You must select at least one record'),'show_in_homepage.svg');
	// $toolbar->addButton('is_hot',FSText :: _('Nổi bật'),FSText :: _('You must select at least one record'),'is_hot.svg');
	// $toolbar->addButton('unis_hot',FSText :: _('Ngừng nổi bật'),FSText :: _('You must select at least one record'),'is_hot.svg');
	
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png');  
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 0; 
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tiêu đề tin','field'=>'title','ordering'=> 1,'align'=>'left', 'type'=>'text_link1','col_width' => '30%','','arr_params'=>array('size'=> 30));
	
   
	$list_config[] = array('title'=>'Người đăng','field'=>'author','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
//    $list_config[] = array('title'=>'Người sửa','field'=>'author_last','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Ngày sửa','field'=>'updated_time','ordering'=> 1, 'type'=>'datetime');
    // $list_config[] = array('title'=>'Hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
//    $list_config[] = array('title'=>'Tin mới','field'=>'is_new','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_new'));
    // $list_config[] = array('title'=>'Trang chủ','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'show_in_homepage'));
    $list_config[] = array('title'=>'Hoạt động','field'=>'published','ordering'=> 1, 'type'=>'published');
    // $list_config[] = array('title' => 'Xem', 'type' => 'preview', 'link' => 'index.php?module=products&view=product&ccode=ccode');
	
	$list_config[] = array('title'=>'Edit','type'=>'edit');
	//$list_config[] = array('title'=>'Comment','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_comment'));
	
	//$list_config[] = array('title'=>'Người tạo tin','field'=>'user_post','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>'Id','field'=>'id','ordering'=> 1, 'type'=>'text');
	
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