<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<?php
//$title = @$data ? FSText :: _('Edit'): FSText :: _('Add');
global $toolbar;
$toolbar->setTitle('Chi tiết đặt trước');
//$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png',1);
$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back',FSText :: _('Cancel'),'','cancel.png');

//$this -> dt_form_begin(1,4,$title.' '.FSText::_('News'));
$this -> dt_form_begin(1,4,FSText::_('Chi tiết'),'fa-edit',1,'col-md-7',1);
    TemplateHelper::dt_edit_text(FSText :: _('Họ tên'),'name',@$data->name);
    TemplateHelper::dt_edit_text(FSText :: _('SĐT'),'telephone',@$data->telephone);
//    TemplateHelper::dt_edit_text(FSText :: _('CMND'),'cmnd',@$data->cmnd);
//    TemplateHelper::dt_edit_text(FSText :: _('Ngày sinh'),'birth',@$data->birth);
//    TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/ Thành phố'),'city_id',@$data ->city_id,0,$city);
//    TemplateHelper::dt_edit_selectbox(FSText::_('Quận/ Huyện'),'district_id',@$data ->district_id,0,$district);
//    TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'),'address',@$data->address);
//    TemplateHelper::dt_edit_text(FSText :: _('SĐT người thân'),'rel_tel',@$data->rel_tel);
    TemplateHelper::datetimepicke( FSText :: _('Published time' ), 'created_time', @$data->created_time?@$data->created_time:date('Y-m-d H:i:s'), FSText :: _('Bạn vui lòng chọn thời gian hiển thị'), 20,'','col-md-3','col-md-5');
$this->dt_form_end_col(); // END: col-1

$this -> dt_form_begin(1,2,FSText::_('Quản trị'),'fa-user',1,'col-md-5 fl-right');
TemplateHelper::dt_edit_selectbox(FSText::_('Trạng thái'),'status',@$data ->status,0,$this->arr_status);
?>
<?php $product = $this->model->get_record('id ='.@$data->record_id,'fs_products','name,alias,id,image') ?>
<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">Sản phẩm</label>
    <div class="col-md-9 col-xs-12">
        <a style="color: #73c5fa" href="<?php echo FSRoute::_('index.php?module=products&view=product&code='.$product->alias.'&id='.$product->id) ?>" target="_blank">
            <img src="<?php echo URL_ROOT.$product->image ?>" alt="" class="img-responsive" style="margin: auto">
            <?php echo @$product->name ?>
        </a>
    </div>
</div>
<?php
$this->dt_form_end_col(); // END: col-4

//$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo');
$this -> dt_form_end(@$data,1,0,2,'Cấu hình seo','',1,'col-sm-4');
?>

