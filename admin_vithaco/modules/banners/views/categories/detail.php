<!-- HEAD -->
<?php

$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png', 1);
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png', 1);
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');

echo ' 	<div class="alert alert-danger" style="display:none" >
                    <span id="msg_error"></span>
            </div>';

$this->dt_form_begin(1, 4, $title . ' ' . FSText::_('Danh mục'));

TemplateHelper::dt_edit_text(FSText:: _('Tên nhóm Banner'), 'name', @$data->name);
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Chiều rộng ảnh'), 'width', @$data->width, 0, '20');
TemplateHelper::dt_edit_text(FSText:: _('Chiều cao ảnh'), 'height', @$data->height, 0, '20');
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');

$this->dt_form_end(@$data, 1, 0);
?>
<script type="text/javascript">
    $('.form-horizontal').keypress(function (e) {
        if (e.which == 13) {
            formValidator();
            return false;
        }
    });

    function formValidator() {
        $('.alert-danger').show();

        if (!notEmpty('name', 'Nhập tên danh mục'))
            return false;

        $('.alert-danger').hide();
        return true;
    }


</script>

