<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Trẻ em'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->tre_em)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_tre_item = explode(',', @$data->tre_em);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('trẻ em') ?>" name="tre_em[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($tre as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_tre_item)) {
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

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Thanh niên'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->thanh_nien)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_tn_item = explode(',', @$data->thanh_nien);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('thanh niên') ?>" name="thanh_nien[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($thanh_nien as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_tn_item)) {
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

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Dành cho nam'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->nam)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_nam_item = explode(',', @$data->nam);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('Nam') ?>" name="nam[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($nam as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_nam_item)) {
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

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Dành cho nữ'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->nu)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_nu_item = explode(',', @$data->nu);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('Nữ') ?>" name="nu[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($nu as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_nu_item)) {
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

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Ngày lễ'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->ngay_le)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_nl_item = explode(',', @$data->ngay_le);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('Ngày lễ') ?>" name="ngay_le[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($ngay_le as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_nl_item)) {
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

<div class="form-group">
    <label class="col-sm-3 col-xs-12 control-label"><?php echo FSText:: _('Sự kiện'); ?></label>
    <div class="col-sm-9 col-xs-12">
        <?php

        $checked = 0;
        $checked_all = 0;

        if ((!@$data->su_kien)) {
            $checked = 0;
        } else {
            $checked = 1;
            $checked_all = 0;
            $arr_sk_item = explode(',', @$data->su_kien);
        }
        ?>
        <select data-placeholder="<?php echo FSText::_('Sự kiện') ?>" name="su_kien[]" size="8"
                multiple="multiple"
                class='form-control chosen-select-no-results listItem'>
            <?php

            foreach ($su_kien as $item) {

                $html_check = "";
                if ($checked_all) {
                    $html_check = "' selected='selected' ";
                } else {
                    if ($checked) {
                        if (in_array($item->id, $arr_sk_item)) {
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


