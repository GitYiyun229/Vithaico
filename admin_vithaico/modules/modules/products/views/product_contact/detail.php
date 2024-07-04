<?php
$title = @$data ? FSText:: _('Xem') : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png');
//$toolbar->addButton('Save',FSText :: _('Save'),'','save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');

//$this->dt_col_start('col-xs-12 col-md-12 connectedSortable', 1);
$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Liên hệ'));

//    TemplateHelper::dt_edit_text(FSText :: _('Title'),'title',@$data -> title);
//    TemplateHelper::dt_edit_text(FSText :: _('Người gửi'),'fullname',@$data -> fullname);
?>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Họ tên') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="fullname" id="fullname"
                   value="<?php echo $data->fullname ?>" size="60">
        </div>
    </div>
    <!-- <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Tiêu đề') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="title" id="title"
                   value="<?php echo $data->title ?>" size="60">
        </div>
    </div> -->

    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Telephone') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="number" class="form-control" name="telephone" id="type_id"
                   value="<?php echo $data->telephone ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Email') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="email" id="email"
                   value="<?php echo $data->email ?>" size="60">
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Sản phẩm đăng ký') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="products_name" id="products_name"
                   value="<?php echo $data->products_name ?>" size="60">
        </div>
    </div>
<?php if (@$data->version) { ?>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Màu') ?></label>
        <div class="col-md-10 col-xs-12">
            <input disabled="disabled" type="text" class="form-control" name="products_name" id="products_name"
                   value="<?php echo $data->version ?>" size="60">
        </div>
    </div>
<?php } ?>
    <!--    <div class="form-group">-->
    <!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Địa chỉ') ?><!--</label>-->
    <!--        <div class="col-md-10 col-xs-12">-->
    <!--            <input disabled="disabled" type="text" class="form-control" name="address" id="address"-->
    <!--                   value="--><?php //echo $data->address ?><!--" size="60">-->
    <!--        </div>-->
    <!--    </div>-->
    <!--    <div class="form-group">-->
    <!--        <label class="col-md-2 col-xs-12 control-label">--><?php //echo FSText::_('Tỉnh thành') ?><!--</label>-->
    <!--        <div class="col-md-10 col-xs-12">-->
    <!--            <input disabled="disabled" type="text" class="form-control" name="country" id="country"-->
    <!--                   value="--><?php //echo $data->country ?><!--" size="60">-->
    <!--        </div>-->
    <!--    </div>-->

<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Email'),'email',@$data -> email);
//    TemplateHelper::dt_edit_text(FSText :: _('Telephone'),'telephone',@$data -> telephone);
//    TemplateHelper::dt_edit_text(FSText :: _('Address'),'address',@$data -> address);
?>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label"><?php echo FSText::_('Ghi chú') ?></label>
        <div class="col-md-10 col-xs-12">
            <textarea disabled="disabled" class="form-control" name="message"
                      id="content"><?php echo $data->message ?></textarea>
        </div>
    </div>
<?php
//    TemplateHelper::dt_edit_text(FSText :: _('Nội dung'),'content',@$data -> content,'',650,450,1,'','','col-sm-2','col-sm-10');
//$this->dt_col_end(); // show the dong </div>
//$this->dt_form_end(@$data, 1, 0, 2, '', '', 1);
$this->dt_form_end(@$data, 1);

?>