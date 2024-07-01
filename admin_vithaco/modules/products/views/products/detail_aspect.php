<?php
TemplateHelper::dt_edit_text(FSText::_('Text hàng cũ'), 'text_aspect', @$data->text_aspect, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');

?>
<div class="form_body">

    <!--	FIELD	-->
    <fieldset>
        <legend>Danh Sách</legend>
        <div id="tabs_aspect">
            <table cellpadding="5" class="field_tbl" id="table-aspect" width="100%" border="1" bordercolor="red">
                <tr>
                    <td width="40%"> Tình trạng</td>
                    <td width="20%"> Tính toán</td>
                    <td width="20%"> Giá trị</td>
                    <td width="10%"> Published</td>
                    <td width="10%"> X&#243;a</td>
                </tr>
                <?php if (!empty($aspects)) {
                    $as = 0;
                    foreach ($aspects as $aspect) {
                        ?>
                        <tr id="exits_aspect-<?php echo $as ?>">
                            <td>
                                <input type="text" class="form-control"
                                       placeholder="Tình trạng" name="name_aspect[]"
                                       value="<?php echo $aspect->name; ?>">
                                <input type="hidden" class="form-control" name="id_aspect[]"
                                       value="<?php echo $aspect->id ?>">
                            </td>
                            <td>
                                <select name="calculate_aspect[]">
                                    <option value="">Chọn</option>
                                    <option value="1" <?php if (@$aspect->calculate) echo "selected='selected'"; ?>>
                                        Tăng
                                    </option>
                                    <option value="0" <?php if (!@$aspect->calculate) echo "selected='selected'"; ?>>
                                        Giảm
                                    </option>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control"
                                       placeholder="Giá trị" name="value_aspect[]"
                                       value="<?php echo format_money_0($aspect->value); ?>">
                            </td>
                            <td>
                                <select name="published_aspect[]">
                                    <option value="">Chọn</option>
                                    <option value="1" <?php if (@$aspect->published) echo "selected='selected'"; ?>>Có
                                    </option>
                                    <option value="0" <?php if (!@$aspect->published) echo "selected='selected'"; ?>>
                                        Không
                                    </option>
                                </select>
                            </td>
                            <td>
                                <a href="javascript:void(0)"
                                   onclick="remove_extend_aspect(<?php echo $as ?>,'<?php echo $aspect->id; ?>')">
                                    <i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                        <?php $as++;
                    }
                } ?>
            </table>
            <a style="color: #73c5fa;" href="javascript:void(0);"
               onclick="addField_aspect()"> <?php echo FSText:: _("Thêm"); ?>
                <i class="fa fa-plus-square" aria-hidden="true"></i>
            </a>
        </div>
    </fieldset>

    <input type="hidden" name="count_item" id="count_item"
           value="<?php echo !empty($aspects) ? count($aspects) : 0 ?>"/>
</div>

<script>
    let count = $('#count_item').val();

    function addField_aspect() {
        let html = '';
        html = `
        <tr id="aspect-${count}">
            <td>
                <input type="text" class="form-control"
                   placeholder="Tình trạng" name="name_aspect[]" id="name_aspect-${count}">
            </td>
            <td>
                <select name="calculate_aspect[]" id="calculate_aspect-${count}">
                    <option value="">Chọn</option>
                    <option value="1">Tăng</option>
                    <option value="0">Giảm</option>
                </select>
            </td>
            <td>
                <input type="text" class="form-control"
                   placeholder="Giá trị" name="value_aspect[]" id="value_aspect-${count}">
            </td>
            <td>
                <select name="published_aspect[]" id="published_aspect-${count}">
                    <option value="">Chọn</option>
                    <option value="1">Có</option>
                    <option value="0">Không</option>
                </select>
            </td>
            <td>
                <a href="javascript:void(0)" onclick="remove_new_aspect(${count})"><i class="fa fa-trash-o"></i></a>
            </td>
        </tr>`;

        $('#table-aspect').append(html);
        count++;
    }

    function remove_new_aspect(area) {
        if (confirm("You certain want remove this fiels")) {
            area_id = "#aspect-" + area;
            $(area_id).html("");
        }
        return false;
    }

    function remove_extend_aspect(area, fieldid) {
        if (confirm("You certain want remove this fiels")) {
            $('#exits_aspect-' + area).html("");
            $.ajax({
                type: 'POST',
                dataType: 'html',
                url: 'index2.php?module=products&view=products&raw=1&task=ajax_delete_aspect',
                data: {fieldid: fieldid},
                success: function (data) {
                    let msg = '';
                    if (data == 1) {
                        msg = 'Xóa thành công';
                    } else {
                        msg = 'Xóa không thành công';
                    }
                    alert(msg);
                }
            });
        }
        return false;
    }
</script>
