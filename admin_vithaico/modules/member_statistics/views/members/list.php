<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Member List') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
	
	//	FILTER
	$filter_config  = array();
	$fitler_config['search'] = 1; 
	$fitler_config['filter_count'] = 1;
    $fitler_config['text_count'] = 2;

	// $filter_categories = array();
	// $filter_categories['title'] = FSText::_('group'); 
	// $filter_categories['list'] = @$group; 
	// $filter_categories['field'] = 'name'; 
	$type_member = [
		1 => 'Thường',
		2 => 'Nhân viên DDTM'
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
	//$list_config[] = array('title'=>'Title','field'=>'username','ordering'=> 1, 'type'=>'edit_text','col_width' => '20%','arr_params'=>array('size'=> 30));
    $list_config[] = array('title'=>'Username','field'=>'username','type'=>'text','align'=>'left');
	
    // $list_config[] = array('title'=>'Avatar','field'=>'avatar','type'=>'image','arr_params'=>array('search'=>'/original/','replace'=>'/original/','width'=>'92'));
    // $list_config[] = array('title'=>'Full Name','field'=>'name','ordering'=> 1, 'type'=>'text','col_width' => '20%','arr_params'=>array('size'=> 30));
    $list_config[] = array('title'=>'Email','field'=>'email','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));
    //$list_config[] = array('title'=>'Group','field'=>'group_id','ordering'=> 1, 'type'=>'edit_selectbox','arr_params'=>array('arry_select'=>$group,'field_value'=>'id','field_label'=>'name','size'=>10));
    //$list_config[] = array('title'=>'Post grograms','field'=>'post_programs','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));
    //$list_config[] = array('title'=>'Reward point','field'=>'point','ordering'=> 1, 'type'=>'text','col_width' => '10%','arr_params'=>array('size'=> 30));
//    $list_config[] = array('title'=>'Ordering','field'=>'ordering','ordering'=> 1, 'type'=>'edit_text','arr_params'=>array('size'=>3));
	
    $list_config[] = array('title'=>'Created time','field'=>'created_time','ordering'=> 1, 'type'=>'datetime');
    $list_config[] = array('title'=>'Published','field'=>'published','ordering'=> 1, 'type'=>'published');
	$list_config[] = array('title'=>'Edit','type'=>'edit');
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
<script  type="text/javascript" language="javascript">
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
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.core.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jsobj/Dialog.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.draggable.js';?>"></script>
<script type="text/javascript" language="javascript" src="<?php  echo URL_ROOT.'/libraries/jquery.ui/ui.dialog.js';?>"></script> -->