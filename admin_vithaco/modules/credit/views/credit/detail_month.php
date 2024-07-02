<style>
    .select2 {
        width: 200px !important;
    }

    .field_tbl select {
        width: 60px;
    }

    .field_tbl select.ftype_exist, .field_tbl select.new_ftype {
        width: 90px;
    }

    .field_tbl select.is_main_exist, .field_tbl select.new_is_main,
    .field_tbl select.is_filter_exist, .field_tbl select.new_is_filter,
    .field_tbl select.is_config_exist, .field_tbl select.new_is_config {
        width: 60px;
    }

    #table-color tr {
        transition: all 0.3s;
        -webkit-transform: translateZ(0) scale(1, 1);
        -webkit-backface-visibility: hidden;
    }

    #table-color tr:hover {
        background-color: #33333310;
        /* transform: scale(1.02); */
        transition: all 0.3s;

        box-shadow: 0px 0px 11px 0px rgba(0, 0, 0, 0.2);
    }

    .save-color:hover {
        cursor: pointer
    }

    .color-picture {
        height: 60px !important;
    }

    input[type=checkbox] {
        transform: scale(1.5);
    }
    .form_body tr td {
        padding: 10px;
    }
</style>

<!-- BODY-->
<div class="form_body">

    <!--	FIELD	-->
    <fieldset>
        <legend>Danh sách kì hạn</legend>
        <div id="tabs">
            <p class="notice blue"></p>
            <table cellpadding="5" class="field_tbl" id="table-color" width="100%" border="1" bordercolor="red">
                <tr>
                    <!--                        <td> Id</td>-->
                    <td class="text-center"> Kì hạn</td>
                    <td class="text-center"> Lãi suất phẳng</td>
                    <td class="text-center"> Phí bảo hiểm</td>
                    <td class="text-center">Áp dụng</td>
                </tr>
                <?php $i = 0; ?>
                <?php if (isset($list_credit) && count($list_credit)) {
                    foreach ($list_credit as $field) {
                        ?>
                        <input type="hidden" name="id_exist_<?php echo $i; ?>" value="<?php echo $field->id; ?>">
                        <tr id="extend_field_exist_<?php echo $i; ?>">
                            <td class="right_col">
                                <?php $month_compare = isset($field->month_id)?$field->month_id:0; ?>
                                <select name="month_id_exist_<?php echo $i;?>"  id="month_id" >
                                    <option value="0" >Chọn kì hạn</option>
                                    <?php
                                    foreach ($month as $item)
                                    {
                                        $checked = "";
                                        if($month_compare == $item->id )
                                            $checked = "selected=\"selected\"";
                                        ?>
                                        <option value="<?php echo $item->id; ?>" <?php echo $checked; ?> ><?php echo $item->name;  ?> </option>
                                        <?php
                                    }?>
                                </select>

                                <input type="hidden" name='month_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->month_id; ?>" />
                            </td>

                            <td valign="center" class="left_col">
                                <input type="text" name='interest_rate_exist_<?php echo $i; ?>'
                                       value="<?php echo @$field->interest_rate; ?>"/>
                                <input type="hidden" name='interest_rate_exist_<?php echo $i; ?>_begin'
                                       value="<?php echo @$field->interest_rate; ?>"/>
                            </td>
                            <td valign="center" class="left_col">
                                <input type="text" name='insurrance_exist_<?php echo $i; ?>'
                                       value="<?php echo @$field->insurrance; ?>"/>
                                <input type="hidden" name='insurrance_exist_<?php echo $i; ?>_begin'
                                       value="<?php echo @$field->insurrance; ?>"/>
                            </td>
                            <td valign="center" class="left_col text-center">
                                <input type="checkbox" name="is_published_exist_<?php echo $i; ?>" <?=@$field->published==1?'checked=checked':''?> value="1">
                                <input type="hidden" name='is_published_exist_<?php echo $i; ?>_begin'
                                       value="<?php echo @$field->published; ?>"/>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                <?php } else { ?>
                    <?php for ($i = 0; $i < count($month); $i++) { ?>
                        <tr id="extend_field_new_<?php echo $i; ?>">
                            <td class="right_col">
                                <select name="new_month_id_<?php echo $i;?>"  id="month_id" >
                                    <option value="0" >Chọn kì hạn</option>
                                    <?php
                                    foreach ($month as $item)
                                    { ?>
                                        <option value="<?php echo $item->id; ?>"><?php echo $item->name;  ?> </option>
                                        <?php
                                    }?>
                                </select>
                            </td>
                            <td valign="center" class="left_col">
                                <input type="text" name='new_interest_rate_<?php echo $i; ?>' id="new_interest_rate_<?php echo $i; ?>" value=""/>
                            </td>
                            <td valign="center" class="left_col">
                                <input type="text" name='new_insurrance_<?php echo $i; ?>' id="new_insurrance_<?php echo $i; ?>" value=""/>
                            </td>
                            <td valign="center" class="text-center">
                                <input type="checkbox" name="new_published_<?php echo $i; ?>" checked  value="1">
                            </td>
                        </tr>
                    <?php } ?>
                <?php } ?>

            </table>
        </div>
    </fieldset>
    <input type="hidden" value="<?=count($month)?>" name="new_field_total" id="new_field_total" />

</div>
<!-- END BODY-->

