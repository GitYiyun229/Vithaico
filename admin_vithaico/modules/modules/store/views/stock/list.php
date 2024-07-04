<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<style>
    .update_btn{
        height: 50px;
        display: inline-flex;
        flex-wrap: wrap;
        justify-content: center;
        color: #333;
        padding: 5px 20px;
        border-left: 1px solid #fff;
        text-align: center;
        font-size: 12px;
    }
    .update_btn:hover, .update_btn:focus{
        color: #333;
        text-decoration: none;
        background: #e3e4e4;
    }
    .update_btn span{
        width: 100%;
    }
    .update_btn i{
        height: 25px;
        color: #2e6da4;
        font-size: 16px;
        display: flex;
        align-items: center;
    }
</style>
<?php
global $toolbar;
$toolbar->setTitle(FSText :: _('Kho') );
$toolbar->addButtonHTML('<a class="update_btn" href="'.URL_ROOT.'index.php?module=api&view=product&task=api_update_quantity_store" target="_blank"><i class="fa fa-cloud-download" aria-hidden="true"></i><span>Update Tồn Theo Kho</span></a>');

//	FILTER
$filter_config  = array();
$fitler_config['search'] = 1;
$fitler_config['filter_count'] = 1;
//    $fitler_config['text_count'] = 2;

$filter_categories = array();
$filter_categories['title'] = FSText::_('Cửa hàng');
$filter_categories['list'] = @$categories;
$filter_categories['field'] = 'treename';

$fitler_config['filter'][] = $filter_categories;

$list_config = array();
$list_config[] = array('title' => 'Image', 'field' => 'image', 'type' => 'image', 'arr_params' => array('width' => 60, 'search' => '/original/', 'replace' => '/resized/'));
$list_config[] = array('title'=>'Tên','field'=>'title','name'=> 1, 'type'=>'text','col_width' => '20%');
$list_config[] = array('title'=>'Biến thể','field'=>'sub_name','name'=> 1, 'type'=>'text','col_width' => '5%');
$list_config[] = array('title'=>'Mã SKU','field'=>'product_code','code'=> 1, 'type'=>'text','arr_params'=>array('size'=>5));
$list_config[] = array('title'=>'Số lượng','field'=>'quantity','name'=> 1, 'type'=>'text');
$list_config[] = array('title'=>'Mã kho','field'=>'location_code','code'=> 1, 'type'=>'text','arr_params'=>array('size'=>5));
$list_config[] = array('title'=>'Cửa hàng','field'=>'area_name','ordering'=> 1, 'type'=>'text','col_width' => '15%','arr_params'=>array('arry_select'=>$categories,'field_value'=>'id','field_label'=>'treename','size'=>10));
$list_config[] = array('title'=>'Ngày cập nhật','field'=>'created_time','ordering'=> 1, 'type'=>'text');

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