<!-- HEAD -->
<?php

$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('cancel', FSText:: _('Cancel'), '', 'cancel.png');
//
//$this->dt_form_begin(0);
//
//$this->dt_form_begin(1, 4, $title, 'fa-edit', 1, 'col-md-8', 1);
//TemplateHelper::dt_edit_text(FSText:: _('Username'), 'username', @$data->username);
//TemplateHelper::dt_edit_text(FSText:: _('Password'), 'password', @$data->password);
//TemplateHelper::dt_edit_text(FSText:: _('Re-password'), 'repass', @$data->repass);
//TemplateHelper::dt_edit_selectbox(FSText::_('User group'), 'category_id', $cid, 0, $groups_all, $field_value = 'id', $field_label = 'name', $size = 1, 1);
//
//$this->dt_form_end_col(); // END: col-3
//
//$this->dt_form_begin(1, 2, FSText::_('Kích hoạt'), 'fa-lock', 1, 'col-md-4');
//
//TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1, '', '', '', 'col-sm-4', 'col-sm-8');
//TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '10', 1, 0, '', '', 'col-md-4', 'col-md-8');
//$this->dt_form_end_col(); // END: col-3
//
//$this->dt_form_begin(1, 2, FSText::_('Nội dung'), 'fa-image', 1, 'col-md-8');
//TemplateHelper::dt_edit_text(FSText:: _(''), 'description', @$data->description, '', 700, 600, 1, '', '', 'col-md-4', 'col-md-12');
//$this->dt_form_end_col(); // END: col-3
//
//
//$this->dt_form_end(@$data, 1, 0, 2, 'Cấu hình seo', '', 1);

?>
<!-- END HEAD-->

<!-- BODY-->
<div class="form_body">
    <div id="msg_error"></div>
    <div class="form-contents">
        <form action="index.php?module=users&view=users" name="adminForm" method="post" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('First name'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="fname" id="fname" value="<?php echo @$data->fname; ?>" size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Last name'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="lname" id="lname" value="<?php echo @$data->lname; ?>" size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Phone'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="phone" id="phone" value="<?php echo @$data->phone; ?>" size="20"></div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Email'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="email" id="email" value="<?php echo @$data->email; ?>" size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Username'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="username" id="username" value="<?php echo @$data->username; ?>"
                                   size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Password'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="password" class="form-control" name="password" id="password" value="" size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Re-password'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="password" class="form-control" name="repass" id="repass" value="" size="20"></div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('User group'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <select name="group_ids[]"  id="groups" class="select2-temp">
                                <!--                                <option value="">--><?php //echo FSText:: _('User group'); ?>
                                <?php for ($i = 0;
                                           $i < count($groups_all);
                                           $i++) { ?>
                                    <?php
                                    if (isset($groups_contain_user) && (in_array($groups_all[$i]->id, @$groups_contain_user)))
                                        $checked = "selected=\"selected\"";
                                    else
                                        $checked = "";
                                    ?>
                                    <option value="<?php echo $groups_all[$i]->id; ?>" <?php echo $checked; ?> ><?php echo $groups_all[$i]->group_name; ?> </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Published'); ?>
                        </label>
                        <!--                        --><?php //var_dump(@$data->published); ?>
                        <div class="col-md-10 col-xs-12">
                            <input class="radio-custom" type="radio" name="published"
                                   value="1" id="published_1" <?php if (@$data->published) echo "checked=\"checked\""; ?>>
                            <label for="published_1" class="radio-custom-label"><?php echo FSText:: _('Yes'); ?>&nbsp;&nbsp;</label>

                            <input class="radio-custom" type="radio" name="published" value="0"
                                   id="published_0" <?php if (!@$data->published) echo "checked=\"checked\""; ?>>
                            <label for="published_0" class="radio-custom-label"><?php echo FSText:: _('No'); ?>&nbsp;&nbsp;</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 col-xs-12 control-label">
                            <?php echo FSText:: _('Ordering'); ?>
                        </label>
                        <div class="col-md-10 col-xs-12">
                            <input type="text" class="form-control" name="ordering" id="ordering" value="<?php echo @$data->ordering; ?>"
                                   size="20">
                        </div>
                    </div>
                </div>
            </div>


            <?php if (@$data->id) { ?>
                <input type="hidden" value="<?php echo $data->id; ?>" name="id">
            <?php } ?>
            <input type="hidden" value="users" name="view">
            <input type="hidden" value="users" name="module">
            <input type="hidden" value="" name="task">
            <input type="hidden" value="0" name="boxchecked">
        </form>
    </div><!--end: .form-contents-->
</div>
<!-- END BODY-->

<script type="text/javascript">
    function formValidator() {

        if (!notEmpty('username', 'T&#234;n &#273;&#259;ng nh&#7853;p kh&#244;ng &#273;&#432;&#7907;c &#273;&#7875; tr&#7889;ng'))
            return false;
        if (!checkMatchPass('M&#7853;t kh&#7849;u nh&#7853;p l&#7841;i kh&#244;ng &#273;&#250;ng'))
            return false;
        if (!emailValidator('email', 'B&#7841;n ph&#7843;i nh&#7853;p &#273;&#7883;a ch&#7881; Email'))
            return false;
        if (!madeSelection('groups', 'B&#7841;n ph&#7843;i ch&#7885;n nh&#243;m cho th&#224;nh vi&#234;n n&#224;y'))
            return false;
        return true;

    }
</script>

