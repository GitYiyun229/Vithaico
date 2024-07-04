<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php
	global $toolbar;
	$toolbar->setTitle(FSText::_('Danh sách mã giảm giá') );
	//$toolbar->addButton('duplicate',FSText :: _('Duplicate'),FSText :: _('You must select at least one record'),'duplicate.png');
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png');
	$toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png');
	$toolbar->addButton('edit',FSText::_('S&#7917;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'edit.png');
	$toolbar->addButton('remove',FSText::_('X&#243;a'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'remove.png');
	$toolbar->addButton('published',FSText::_('K&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'published.png');
	$toolbar->addButton('unpublished',FSText::_('Ng&#7915;ng k&#237;ch ho&#7841;t'),FSText::_('B&#7841;n ch&#432;a ch&#7885;n b&#7843;n ghi n&#224;o !'),'unpublished.png');
//	$toolbar->addButton('export',FSText :: _('Export'),'','Excel-icon.png');
    
    //	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1;
    $fitler_config['text_count'] = 2;
    
    $text_from_date = array();
	$text_from_date['title'] =  FSText::_('From day'); 
	
	$text_to_date = array();
	$text_to_date['title'] =  FSText::_('To day');  
    
	//$fitler_config['filter'][] = $filter_categories;
    $fitler_config['text'][] = $text_from_date;
	$fitler_config['text'][] = $text_to_date;
    
	//	CONFIG
	$list_config = array();
    $list_config[] = array('title'=>'Name','field'=>'title','ordering'=> 1, 'type'=>'text','col_width' => '20%','align'=>'left','arr_params'=>array('have_link_edit'=> 1));
	$list_config[] = array('title'=>'Mã','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','align'=>'left','arr_params'=>array('have_link_edit'=> 1));
	// $list_config[] = array('title'=>'L/s đơn hàng','field'=>'id','type'=>'text','arr_params'=>array('function'=>'view_history'));
	$list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	$list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	//$list_config[] = array('title'=>'Home','field'=>'show_in_homepage','ordering'=> 1, 'type'=>'change_status','arr_params'=>array('function'=>'home'));
    $list_config[] = array('title'=>FSText::_('Tổng số lượng'),'field'=>'count_total','ordering'=> 1, 'type'=>'text');
	$list_config[] = array('title'=>FSText::_('Số lượng sử dụng còn lại'),'field'=>'count','ordering'=> 1, 'type'=>'text');
    $list_config[] = array('title'=>'Edit','type'=>'edit');
//	$list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
    $list_config[] = array('title'=>FSText::_('Thời gian áp dụng'),'field'=>'date_start','ordering'=> 1, 'type'=>'datetime');
    $list_config[] = array('title'=>FSText::_('Thời gian hết hạn'),'field'=>'date_end','ordering'=> 1, 'type'=>'datetime');
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
