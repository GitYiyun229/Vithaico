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
</style>

<div>
    <table id="table_extend_fields" class="table table-bordered" style="background-color: #f5f5f5">
        <thead>

        <tr class="table-primary">
            <th class="text-center" colspan="5">Khoảng giá</th>
        </tr>

        <tr>
            <th width="30%"> Giá min</th>
            <th width="30%"> Giá max</th>
            <th width="30%"> Giá gói bảo hành</th>
<!--            <th width="10%"> Published</th>-->
            <th width="10%" class='text-center'> X&#243;a</th>
        </tr>
        </thead>
        <tbody>

        <?php $i = 0; ?>
        <?php if (isset($products) && count($products)) {
            foreach ($products as $field) {
                ?>
                <input type="hidden" name="id_exist_<?php echo $i; ?>" value="<?php echo $field->id; ?>">
                <tr id="extend_field_exist_<?php echo $i; ?>">
                    <td valign="center" class="left_col">
                        <input type="text"  class='form-control' name='price_min_exist_<?php echo $i; ?>'
                               value="<?php echo format_money_0($field->price_min); ?>"/>
                        <input type="hidden" name='price_min_exist_<?php echo $i; ?>_begin'
                               value="<?php echo $field->price_min; ?>"/>
                    </td>
                    <td valign="center" class="left_col">
                        <input type="text" class='form-control' name='price_max_exist_<?php echo $i; ?>' value="<?php echo format_money_0($field->price_max); ?>"/>
                        <input type="hidden" name='price_max_exist_<?php echo $i; ?>_begin'
                               value="<?php echo $field->price_max; ?>"/>
                    </td>
                    <td valign="center" class="left_col">
                        <input type="text" class='form-control' name='price_exist_<?php echo $i; ?>'
                               value="<?php echo format_money_0($field->price); ?>"/>
                        <input type="hidden" name='price_exist_<?php echo $i; ?>_begin'
                               value="<?php echo $field->price_old; ?>"/>
                    </td>
<!--                    <td valign="center" class="left_col">-->
<!--                        <select name="is_published_exist_--><?php //echo $i; ?><!--" id='is_published_exist_--><?php //echo $i; ?><!--'-->
<!--                                class='is_config_exist form-control'>-->
<!--                            <option value="1" --><?php //if (@$field->published) echo "selected='selected'"; ?><!-- > Có</option>-->
<!--                            <option value="0" --><?php //if (!@$field->published) echo "selected='selected'"; ?><!-- >Không-->
<!--                            </option>-->
<!--                        </select>-->
<!--                        <input type="hidden" name='is_published_exist_--><?php //echo $i; ?><!--_begin'-->
<!--                               value="--><?php //echo @$field->published; ?><!--"/>-->
<!--                    </td>-->
                    <td valign="center" class='text-center'>
                        <a href="javascript: void(0)"
                           onclick="javascript: remove_extend_field(<?php echo $i ?>,'<?php echo $field->id; ?>')">
                            <i class="fa fa-trash-o"></i>
                        </a>
                    </td>
                </tr>
                <?php $i++; ?>
            <?php } ?>
        <?php } ?>

        <?php for ($i = 0; $i < 100; $i++) { ?>
            <tr id="tr<?php echo $i; ?>"></tr>
        <?php } ?>
        <tbody>
        <tfoot>
        <tr>
            <td colspan="5" class="text-center">
                <a class="btn btn-success" href="javascript:void(0)" onclick="addField();">Thêm mới
                    <i class="fa fa-plus-square" aria-hidden="true"></i>
                </a>
            </td>
        </tr>
        </tfoot>
    </table>
<!--    <a style="color: #73c5fa;" href="javascript:void(0);" onclick="addField()"> --><?php //echo FSText:: _("Thêm"); ?>
    <!--        <i class="fa fa-plus-square" aria-hidden="true"></i>-->
    <!--    </a>-->

    <!--	end FIELD	-->
    <input type="hidden" value="" name="field_remove" id="field_remove"/>
    <input type="hidden" value="<?php echo isset($data) ? count($products) : 0; ?>" name="field_extend_exist_total"
           id="field_extend_exist_total"/>
    <input type="hidden" value="" name="new_field_total" id="new_field_total"/>

    <input type="hidden" value="0" name="boxchecked"/>
    <!--        <input type="hidden" value="-->
    <?php //echo $max_ordering?><!--" name="max_ordering" id = "max_ordering" />-->
    <!-- END BODY-->
</div>
<script>

    var i = 0;

    function addField() {
        area_id = "#tr" + i;

        htmlString = "<td>";
        htmlString += "<input type=\"text\" class='form-control' name='new_price_min_" + i + "' id='new_price_min_" + i + "'  />";
        htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<input type=\"text\" class='form-control'  name='new_price_max_" + i + "' id='new_price_max_" + i + "'  />";
        htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<input type=\"text\" class='form-control'  name='new_price_" + i + "' id='new_price_" + i + "'  />";
        htmlString += "</td>";

        // htmlString += "<td>";
        // htmlString += "<select name='new_published_" + i + "' id='new_published_" + i + "' class='new_published form-control'>";
        // htmlString += "<option value=\"1\"  >Có</option>";
        // htmlString += "<option value=\"0\" selected='selected' >Không</option>";
        // htmlString += "</select>";
        // htmlString += "</td>";

        htmlString += "<td valign=\"center\" class='text-center'>";
        htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field(" + i + ")\" >" + "<i class=\"fa fa-trash-o\"></i>" + "</a>";
        htmlString += "</td>";

        $(area_id).html(htmlString);
        i++;
        $("#new_field_total").val(i);
    }

    //remove extend field exits
    function remove_extend_field(area, fieldid) {
        if (confirm("You certain want remove this fiels")) {
            remove_field = "";
            remove_field = $('#field_remove').val();
            remove_field += "," + fieldid;
            $('#field_remove').val(remove_field);
            $('#extend_field_exist_' + area).html("");
        }
        return false;
    }

    //remove new extend field
    function remove_new_field(area) {
        if (confirm("You certain want remove this fiels")) {
            area_id = "#tr" + area;
            $(area_id).html("");
        }
        return false;
    }

    function change_ftype(element) {
        type_id = $(element).attr('id');
        foreign_id = type_id.replace("ftype", "foreign_id");
        val = $(element).val();
        if (val == 'foreign_one' || val == 'foreign_multi') {
            $('#' + foreign_id).show();
        } else {
            $('#' + foreign_id).hide();
        }
    }

</script>
