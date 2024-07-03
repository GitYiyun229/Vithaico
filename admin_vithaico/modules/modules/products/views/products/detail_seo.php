<table cellspacing="1" class="admintable">
<?php
TemplateHelper::dt_edit_text(FSText:: _('SEO title'), 'seo_title', @$data->seo_title, '', 100, 1, 0, '', '');
?>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label"></label>
        <div class="col-md-9 col-xs-12">
            Đã nhập: <span id="count_seo_title">0</span> ký tự
        </div>
    </div>
    <?php
    TemplateHelper::dt_edit_text(FSText::_('Alias'), 'alias', @$data->alias, '', 255, 1, 0, FSText::_("Để trống sẽ tự động lấy tiêu đề sản phẩm"), '', 'col-md-3', 'col-md-9');

    TemplateHelper::dt_edit_text(FSText:: _('SEO meta keyword'), 'seo_keyword', @$data->seo_keyword, '', 100, 1, 0, '', '');
    ?>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label"></label>
        <div class="col-md-9 col-xs-12">
            Đã nhập: <span id="count_seo_keyword">0</span> ký tự
        </div>
    </div>
    <?php
TemplateHelper::dt_edit_text(FSText:: _('SEO meta description'), 'seo_description', @$data->seo_description, '', 100, 9, 0, '', '');
    ?>
    <div class="form-group">
        <label class="col-md-3 col-xs-12 control-label"></label>
        <div class="col-md-9 col-xs-12">
            Đã nhập: <span id="count_seo_description">0</span> ký tự
        </div>
    </div>
    <?php
?>
</table>

<script>
    $(document).ready(function () {
        $('#seo_title').keyup(function () {
            $('#count_seo_title').text(this.value.length);
        });
        $('#seo_keyword').keyup(function () {
            $('#count_seo_keyword').text(this.value.length);
        });
        $('#seo_description').keyup(function () {
            $('#count_seo_description').text(this.value.length);
        });
    })
</script>
