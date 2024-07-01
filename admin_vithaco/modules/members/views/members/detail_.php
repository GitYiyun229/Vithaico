<link type="text/css" rel="stylesheet" media="all" href="../modules/members/assets/css/chosen.css" />
<script type="text/javascript" src="../modules/members/assets/js/select_multiple.js"></script>
<script type="text/javascript" src="../modules/members/assets/js/chosen.jquery.js"></script>
﻿<script language="javascript" type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<link rel="stylesheet" type="text/css" media="screen" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<!-- HEAD -->
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
//    $toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Thành viên'));

if (@$data->avatar) {
    $avatar = strpos(@$data->avatar, 'http') === false ? URL_ROOT . str_replace('/original/', '/original/', @$data->avatar) : @$data->avatar;
} else {
    $avatar = URL_ROOT . 'images/1473944223_unknown2.png';
}
?>
<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Chọn loại thành viên") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="type" id="type_member" class="form-control">
            <option value="">-- <?php echo FSText::_('Chọn loại thành viên') ?> --</option>
            <option value="1" <?php if(@$data->type==1)echo 'selected' ?>>HVN</option>
            <option value="2" <?php if(@$data->type==2)echo 'selected' ?>>Head</option>
            <option value="3"<?php if(@$data->type==3)echo 'selected' ?>>User</option>

        </select>
    </div>
</div>
<?php
TemplateHelper::dt_edit_text(FSText :: _('Tên đăng nhập'), 'username', @$data->username);
TemplateHelper::dt_edit_text(FSText :: _('Password'), 'password', @$data->password);

TemplateHelper::dt_edit_text(FSText :: _('Email'), 'email', @$data->email);
TemplateHelper::dt_edit_text(FSText :: _('Họ và tên'), 'name', @$data->name);
TemplateHelper::dt_edit_text(FSText :: _('Sinh nhật'), 'birthday', @$data->birthday);
TemplateHelper::dt_edit_text(FSText :: _('Số điện thoại'), 'telephone', @$data->telephone);
TemplateHelper::dt_edit_text(FSText :: _('Địa chỉ'), 'address', @$data->address);
?>
  <div class="form-group">
        <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Giới tính")?></label>
        <div class="col-sm-9 col-xs-12">
            <input class="form-control" type="text" name="sex" id="sex" value="<?php echo ($data->sex=='male')?'Nam':'Nữ' ?>" />
        </div>
    </div>
<div class="form-group position">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Chức vụ") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="position" id="position" class="form-control">
            <option value="">-- <?php echo FSText::_('Chọn chức vụ') ?> --</option>
            <?php foreach ($get_posotion as $item) { ?>
                <option value="<?php echo $item->id ?>"  <?php if(@$data->position==$item->id)echo 'selected'; ?> ><?php echo $item->name ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group headid">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText::_("Thuộc đại lý ") ?></label>
    <div class="col-sm-9 col-xs-12">
        <select name="headid" id="headid" class="form-control">
            <option value="">-- <?php echo FSText::_('Chọn Head') ?> --</option>
            <option value="1">Honda Tay Ho</option>
            <option value="2">Honda My Dinh</option>
            <option value="3">Honda Long Bien</option>

        </select>
    </div>
</div>

<?php
//TemplateHelper::dt_edit_text(FSText :: _('Thuộc head'), 'headid', @$data->headid);
TemplateHelper::dt_edit_selectbox(FSText::_('Tỉnh/Tp'), 'city', @$data->city_id, 0, $cities, $field_value = 'id', $field_label = 'name', $size = 10, 0, 1);
?>

<?php
TemplateHelper::dt_checkbox(FSText::_('Trạng thái'), 'published', @$data->published, 1);
?>
<?php
//TemplateHelper::dt_edit_text(FSText :: _('Ordering'),'ordering',@$data -> ordering,@$maxOrdering,'20');

$this->dt_form_end(@$data, 1, 0);
?>
<script  type="text/javascript" language="javascript">






</script>