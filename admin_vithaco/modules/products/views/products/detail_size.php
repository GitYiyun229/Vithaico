<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Size'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->size_id)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_size_item = explode(',', @$data->size_id);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('size') ?>" name="size_id[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($sizes as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_size_item)) {
                            $html_check = "' selected='selected' ";
                        }
                    }
                }
                ?>
                <option value="<?php echo $item->id ?>" <?php echo $html_check; ?>><?php echo $item->name; ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php
TemplateHelper::dt_edit_text(FSText:: _('Bảng size'), 'size_tb', @$data->size_tb, '', 100, 6,1);
/**
 * Created by PhpStorm.
 * User: Lucky Boy
 * Date: 17/01/2019
 * Time: 10:13
 */