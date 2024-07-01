<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css"/>
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<style>
    .panel-info {
        border: 1px solid #ddd !important;
    }

    #gmap {
        height: 400px;
        margin: 20px 0px;
        width: 100% !important;
    }

    .controls {
        margin-top: 16px;
        border: 1px solid transparent;
        border-radius: 2px 0 0 2px;
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        height: 32px;
        outline: none;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    #pac-input {
        background-color: #fff;
        font-family: Roboto;
        font-size: 15px;
        font-weight: 300;
        margin-left: 12px;
        padding: 15px;
        text-overflow: ellipsis;
        width: 400px;
    }

    #pac-input:focus {
        border-color: #4d90fe;
    }

    .pac-container {
        font-family: Roboto;
    }

    #type-selector {
        color: #fff;
        background-color: #4d90fe;
        padding: 5px 11px 0px 11px;
    }

    #type-selector label {
        font-family: Roboto;
        font-size: 13px;
        font-weight: 300;
    }

    table th, td {
        /* text-align: center; */
    }

    /*.ui-widget-header {*/
    /*background:none;*/
    /*border:none;*/
    /*}*/
    /*.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {*/
    /*border: none;*/
    /*}*/
    .ui-state-active a, .ui-state-active a:link, .ui-state-active a:visited {
        color: #C73536 !important;
    }

    .ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited {
        color: #333;
    }

    body .panel a:focus, body .panel a:hover {
        color: #C73536 !important;
        background-color: transparent !important;
    }

    /*.ui-widget-content {*/
    /*border: none;*/
    /*background: white;*/
    /*}*/
    .ui-state-default:focus {
        outline: none !important;
    }

    .panel-info > .panel-heading {
        color: #ffffff;
        background-color: #333;
        border-color: #333;
    }

    .panel-info {
        border: none;
    }

    .ui-tabs .ui-tabs-nav {
        background: none;
        border: none;
        padding: 0;
    }
    .ui-tabs .ui-tabs-nav li{
        margin: 0 10px 0 0;
        border-radius: 0;
        border: 1px solid #ccc;
    }
    .ui-tabs .ui-tabs-nav .ui-tabs-anchor {
        outline: none !important;
    }

    #tabs {
        margin: 0;
        border: none;
        padding: 0;
    }
    .ui-tabs .ui-tabs-panel{
        padding: 10px;
    }

    .select2{
        width: 100% !important;
    }
    .select2-container .select2-selection--single{
        height: 32px;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered{
        line-height: 32px;
    }
</style>

<script>
    $(document).ready(function () {
        $("#tabs").tabs();
    });
</script>

<?php
$title = @$data ? FSText::_('Edit'): FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png');
$toolbar->addButton('apply',FSText::_('Apply'),'','apply.png');
$toolbar->addButton('save',FSText::_('Save'),'','save.png');
$toolbar->addButton('cancel',FSText::_('Cancel'),'','cancel.png');
$this -> dt_form_begin(1,4,$title.' '.FSText::_('Categories'),'',1,'col-md-12',1);

?>
<div id="tabs">
    <ul>
        <li><a href="#fragment-1"><span><?php echo FSText::_("Trường cơ bản"); ?></span></a></li>
        <!-- <li><a href="#fragment-3"><span><?php //echo FSText::_("Nội dung"); ?></span></a></li> -->
        <li><a href="#fragment-7"><span><?php echo FSText::_("Thứ tự SP"); ?></span></a></li>
        <!-- <li><a href="#fragment-2"><span><?php echo FSText::_("Bộ lọc"); ?></span></a></li> -->
        <li><a href="#fragment-4"><span><?php echo FSText::_("SEO"); ?></span></a></li>
        <!-- <li><a href="#fragment-5"><span><?php //echo FSText::_("Tin liên quan"); ?></span></a></li> -->
        <!-- <li><a href="#fragment-6"><span><?php //echo FSText::_("Landing Page"); ?></span></a></li> -->
        <!-- <li><a href="#fragment-8"><span><?php //echo FSText::_("Giá theo khu vực"); ?></span></a></li> -->
    </ul>

    <div id="fragment-1">
        <?php
        TemplateHelper::dt_edit_text(FSText :: _('Name'),'name',@$data -> name);
        TemplateHelper::dt_edit_text(FSText :: _('Alias'),'alias',@$data -> alias,'',60,1,0,FSText::_("Can auto generate"));
        TemplateHelper::dt_edit_selectbox(FSText::_('Parent'),'parent_id',@$data -> parent_id,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,0,1);
        // TemplateHelper::dt_edit_selectbox(FSText::_('Danh Mục Cha Phụ'),'multi_parent',@$data -> multi_parent,'',$categories,$field_value = 'id', $field_label='treename',$size = 1,1,1);
        // TemplateHelper::dt_edit_selectbox(FSText::_('Bảng thông số kỹ thuật'),'tablename',@$data -> tablename,'fs_products',$tables,$field_value = 'table_name', $field_label='table_name',$size = 1,0,1);
        TemplateHelper::dt_checkbox(FSText::_('Published'),'published',@$data -> published,1);
        // TemplateHelper::dt_checkbox(FSText::_('Danh mục phụ kiện?'),'is_accessories',@$data -> is_accessories,0);
        TemplateHelper::dt_checkbox(FSText::_('Hiển thị trang chủ'),'show_in_homepage',@$data -> show_in_homepage,0);
        // TemplateHelper::dt_checkbox(FSText::_('Landing Page'),'is_landing',@$data -> is_landing,0);
        // TemplateHelper::dt_checkbox(FSText::_('Giá gồm VAT'),'vat',@$data -> vat,0);
        // TemplateHelper::dt_edit_selectbox(FSText::_('Gói bảo hành'), 'warranty', @$data->warranty, 0, $warranty, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3 right', 'col-md-9');
        // TemplateHelper::dt_edit_selectbox(FSText::_('Gói bảo hành'), 'warranty', @$data->warranty, 0, $warranty, $field_value = 'id', $field_label = 'name', $size = 1, 1, 0, '', '', '', 'col-md-3 right', 'col-md-9');
        TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');
        // TemplateHelper::dt_edit_image(FSText :: _('Image'),'image',URL_ROOT.@$data->image,'','','Ảnh đại diện khi vào Danh mục. Lưu ý ảnh vuông');
        TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/original/',URL_ROOT.@$data->icon));
        // TemplateHelper::dt_edit_image(FSText :: _('Icon Hover'),'icon_hover',str_replace('/original/','/original/',URL_ROOT.@$data->icon_hover));
        // TemplateHelper::dt_edit_image(FSText :: _('Logo Sản phẩm'),'logo',str_replace('/original/','/original/',URL_ROOT.@$data->logo));
        // TemplateHelper::dt_edit_image(FSText :: _('Icon'),'icon',str_replace('/original/','/small/',URL_ROOT.@$data->icon));
        // TemplateHelper::dt_edit_text(FSText :: _('Svg'),'svg',@$data -> svg,'','','4');
        ?>
    </div>

    <!-- <div id="fragment-2">
        </?php
        echo '<div style="margin-bottom: 15px">';
        TemplateHelper::dt_edit_selectbox(FSText::_('Khoảng giá'), 'price', @$data->price, 0, $range_price, $field_value = 'id', $field_label = 'treename', $size = 1, 1,0,'','','','col-md-12 left','col-md-12');
        echo '</div>';
        // require_once ('detail_extend.php');
        ?>
    </div> -->

    <div id="fragment-3">
        <?php
        // TemplateHelper::dt_edit_text(FSText::_('Bộ sản phẩm chuẩn'),'product_set',@$data -> product_set,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
        // TemplateHelper::dt_edit_text(FSText::_('Khuyến mại'),'accessories',@$data -> accessories,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
        // TemplateHelper::dt_edit_text(FSText::_('Khuyến mại Ngắn gọn'),'sale_brief',@$data -> sale_brief,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
        // TemplateHelper::dt_edit_text(FSText::_('Bảo hành cơ bản'),'basic_warranty',@$data -> basic_warranty,'',100,6,'1','','','col-md-12 left','col-md-12 ','','1');
        // TemplateHelper::dt_edit_text(FSText::_('Mô tả'),'description',@$data -> description,'',100,6,'1','','','col-md-12 left','col-md-12 ');
        ?>
    </div>

    <div id="fragment-4">
        <div class="row">
            <div class="col-md-12 col-xs-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <i class="fa fa-cog"></i> Cấu hình Seo
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-12 col-xs-12 control-label">SEO title</label>
                            <div class="col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="seo_title" id="seo_title" value="<?php echo @$data->seo_title ?>" size="60" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 col-xs-12 control-label">SEO meta keyword</label>
                            <div class="col-sm-12 col-xs-12">
                                <input type="text" class="form-control" name="seo_keyword" id="seo_keyword" value="<?php echo @$data->seo_keyword ?>" size="60" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 col-xs-12 control-label">SEO meta description</label>
                            <div class="col-sm-12 col-xs-12">
                                <textarea class="form-control" rows="9" cols="60" name="seo_description" id="seo_description"><?php echo @$data->seo_description ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="fragment-5">
        <?php //require_once ('detail_relate.php'); ?>
    </div>

    <div id="fragment-6">
        <?php
        //require_once 'detail_landing.php';
        ?>
    </div>

    <div id="fragment-7">
        <?php
        require_once 'detail_order.php';
        ?>
    </div>

    <div id="fragment-8">
        <?php
        //require_once 'detailPriceByCity.php';
        ?>
    </div>
</div>
<?php
$this->dt_form_end(@$data,1,0,2,FSText::_('Cấu hình Seo'),'',1,'col-md-12');
?>

<style>
    .image-area-single{
        background: #f5f5f5;
    }
</style>
