<?php
$title = @$data ? FSText:: _('Edit') : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('Save', FSText:: _('Save'), '', 'save.png');
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'back.png');

$this->dt_form_begin();

TemplateHelper::dt_edit_text(FSText:: _('Title'), 'title', @$data->title);
TemplateHelper::dt_edit_text(FSText:: _('Alias'), 'alias', @$data->alias, '', 60, 1, 0, FSText::_("Can auto generate"));
//	TemplateHelper::dt_edit_text(FSText :: _('Link youtube '),'file_flash',@$data -> file_flash,'',100,3);
?>
<div class="form-group">
    <label class="col-md-3 col-xs-12 control-label">Upload video</label>
    <div class="col-md-9 col-xs-12">
        <input type="text" class="form-control" name="video"
               id="video" value="<?php echo @$data->video ?>">
        <a style="color: white !important; margin-top: 10px; background-color: #17456e" class="btn btn-primary btn-pdf"
           href="javascript:void(0)" data-id="video">Chọn tệp</a>
    </div>
</div>
<?php
//TemplateHelper::dt_edit_image(FSText:: _('Image'), 'image', str_replace('/original/', '/small/', URL_ROOT . @$data->image));
TemplateHelper::dt_checkbox(FSText::_('Published'), 'published', @$data->published, 1);
TemplateHelper::dt_edit_text(FSText:: _('Ordering'), 'ordering', @$data->ordering, @$maxOrdering, '20');
TemplateHelper::dt_edit_text(FSText:: _('Số lượt like'), 'hits', @$data->hits, '');
TemplateHelper::dt_edit_selectbox(FSText::_('Sản phẩm'), 'product_id', @$data->product_id, 0, $products, $field_value = 'id', $field_label = 'name', $size = 1, 0, 1, '', '', '', 'col-md-3 left', 'col-md-9', '', 1, '');

//	TemplateHelper::dt_edit_text(FSText :: _('Summary'),'summary',@$data -> summary,'',100,9);
$this->dt_form_end(@$data, 1, 0);

?>
<script type="text/javascript">
    $(document).on('click', ".btn-pdf", function () {
        let id = $(this).attr('data-id');
        selectFileCKFinder(id);
    })


    function selectFileCKFinder(elementId) {
        CKFinder.popup({
            chooseFiles: true,
            width: 800,
            height: 600,
            onInit: function (finder) {
                console.log(finder);
                finder.on('files:choose', function (evt) {
                    var file = evt.data.files.first();
                    var output = document.getElementById(elementId);
                    output.value = file.getUrl();
                });

                finder.on('file:choose:resizedImage', function (evt) {
                    var output = document.getElementById(elementId);
                    output.value = evt.data.resizedUrl;
                });
            }
        });
    }

</script>
