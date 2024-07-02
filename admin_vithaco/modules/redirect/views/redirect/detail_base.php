<?php $url = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/" ?>
<div class="col-md-8 col-xs-12">
	<div class="panel-heading" style="margin-bottom: 15px"><i class="fa fa-edit"></i> Sửa Alias Link</div>
    <?php if(FSInput::get('task') == 'edit') {?>
        <div style="margin-bottom:20px;">
            <a target="_blank" href="<?php echo FSRoute::_('index.php?module='.@$data->module.'&view='.@$data->view.'&ccode='.@$data->alias) ?>">Link hiện tại</a>
        </div>
        <input type="hidden" name="record_id" value="<?php echo @$data->record_id ?>">
        <input type="hidden" name="module_record" value="<?php echo @$data->module ?>">
        <input type="hidden" name="view_record" value="<?php echo @$data->view ?>">
    <?php } ?>
    <?php
    TemplateHelper::dt_edit_text(FSText:: _('Đường Link'), 'old_alias', @$data->old_alias ? $url.@$data->old_alias : '');
    TemplateHelper::dt_edit_text('Chuyển đến Link', 'alias', $url.@$data->alias);
    ?>
</div>

