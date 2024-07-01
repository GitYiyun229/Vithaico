<style>
    #table-aspect tr td {
        vertical-align: baseline;
    }
</style>
<div class="form_body">

    <!--	FIELD	-->
    <fieldset>
        <legend>Danh Sách</legend>
        <div id="tabs_aspect">
            <table cellpadding="5" class="field_tbl" id="table-aspect" width="100%" border="1">
                <tr>
                    <td width="40%" class="text-center"><b>Chọn khu vực</b></td>
                    <td width="40%" class="text-center"><b>Giá trị</b></td>
                    <td width="10%" class="text-center"><b>X&#243;a</b></td>
                </tr>
                <?php if (!empty($priceByCitys)) {
                    $as = 0;
                    foreach ($priceByCitys as $key => $price) {
                        ?>
                        <tr id="item-price-<?php echo $as ?>">
                            <td>
                                <select name="city_price[]">
                                    <option value="">Chọn khu vực</option>
                                    <?php foreach ($cities as $city) {
                                        ?>
                                        <option value="<?= $city->city_id ?>" <?= $city->city_id == $price['city_id'] ? 'selected' : null ?>><?= $city->city_name ?></option>
                                    <?php } ?>
                                </select>
                            </td>

                            <td>
                                <input type="text" class="form-control" name="price_city[]"
                                       value="<?php echo format_money_0($price['price']); ?>">
                            </td>

                            <td class="text-center">
                                <a href="javascript:void(0)"
                                   onclick="remove_extend_aspect(<?php echo $as ?>,'<?php echo $price['city_id']; ?>',<?php echo $data->id ?>)">
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
           value="<?php echo !empty($priceByCitys) ? count($priceByCitys) : 0 ?>"/>
</div>
<script type="text/javascript">
    let count = $('#count_item').val();
    function remove_extend_aspect(area, id, id_cad) {
        if (confirm("You certain want remove this fiels")) {
            $('#item-price-' + area).html("");
            if (id != 0) {
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: 'index2.php?module=products&view=categories&raw=1&task=ajax_delete_price',
                    data: {id: id, id_cad: id_cad},
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
            count--;
            $('#count_item').val(count);
        }
        return false;
    }

    function addField_aspect() {
        let html = '';
        let optionCity = '';
        <?php
        foreach ($cities as $city) { ?>
        optionCity += `<option value="<?= $city->city_id ?>"><?= $city->city_name ?></option>`
        <?php } ?>
        console.log(optionCity);
        html += `<tr id="item-price-${count}">
                            <td>
                                <select name="city_price[]">
                                    <option value="">Chọn khu vực</option>
                                    ${optionCity}
                                </select>
                            </td>

                            <td>
                                <input type="text" class="form-control" name="price_city[]"
                                        value="">
                            </td>

                            <td class="text-center">
                                <a href="javascript:void(0)"
                                   onclick="remove_extend_aspect(${count},0,0)">
                                    <i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>`;

        $('#table-aspect').append(html);
        count++;
        $('#count_item').val(count);
    }

</script>
