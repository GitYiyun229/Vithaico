<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('News') );
	//$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
	$toolbar->addButton('show_in_homepage',FSText :: _('Hiển thị trang chủ'),FSText :: _('You must select at least one record'),'show_in_homepage.svg');
	$toolbar->addButton('unshow_in_homepage',FSText :: _('Ngừng hiển thị trang chủ'),FSText :: _('You must select at least one record'),'show_in_homepage.svg');
	$toolbar->addButton('is_hot',FSText :: _('Nổi bật'),FSText :: _('You must select at least one record'),'is_hot.svg');
	$toolbar->addButton('unis_hot',FSText :: _('Ngừng nổi bật'),FSText :: _('You must select at least one record'),'is_hot.svg');
	
    $toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png');  
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1;
	$fitler_config['filter_count'] = 1;
//    $fitler_config['text_count'] = 2;

	$filter_categories = array();
	$filter_categories['title'] = FSText::_('Categories');
	$filter_categories['list'] = @$categories;
	$filter_categories['field'] = 'treename';
    
//    $text_from_date = array();
//	$text_from_date['title'] =  FSText::_('Từ ngày');
//
//	$text_to_date = array();
//	$text_to_date['title'] =  FSText::_('Đến ngày');
	
	$fitler_config['filter'][] = $filter_categories;
//    $fitler_config['text'][] = $text_from_date;
//	$fitler_config['text'][] = $text_to_date;
	//	CONFIG	
	$list_config = array();
	$list_config[] = array('title'=>'Tiêu đề tin','field'=>'title','ordering'=> 1,'align'=>'left', 'type'=>'text_link1','col_width' => '30%','','arr_params'=>array('size'=> 30));
	
    //$list_config[] = array('title'=>'Title','field'=>'','type'=>'text','align'=>'left','arr_params'=>array('function'=>'view_title'),'col_width' => '20%');
	$list_config[] = array('title'=>'Image','field'=>'image','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/small/','width'=>'90'));
//	$list_config[] = array('title'=>'Summary','field'=>'summary','type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=>30,'rows'=>8));
	$list_config[] = array('title'=>'Danh mục','field'=>'category_name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
	$list_config[] = array('title'=>'Người đăng','field'=>'author','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Ngày tạo','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
//    $list_config[] = array('title'=>'Người sửa','field'=>'author_last','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Ngày sửa','field'=>'updated_time','ordering'=> 1, 'type'=>'datetime');
    $list_config[] = array('title'=>'Hot','field'=>'is_hot','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_hot'));
//    $list_config[] = array('title'=>'Tin mới','field'=>'is_new','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'is_new'));
    $list_config[] = array('title'=>'Trang chủ','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'show_in_homepage'));
    $list_config[] = array('title'=>'Hoạt động','field'=>'published','ordering'=> 1, 'type'=>'published');
    $list_config[] = array('title' => 'Xem', 'type' => 'preview', 'link' => 'index.php?module=products&view=product&ccode=ccode');
	
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