<style>
    .select2 {
        width: 100% !important;
    }
    .field_tbl select{
        width: 60px;
    }
    .field_tbl select.ftype_exist,.field_tbl select.new_ftype{
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
<?php
TemplateHelper::dt_edit_text(FSText::_('Text mua hàng'), 'text_buy', @$data->text_buy, '', 255, 1, 0, '', '', 'col-md-3 left', 'col-md-9');

?>
<!-- BODY-->
<div class="form_body">

    <!--	FIELD	-->
    <fieldset>
        <legend>Danh Sách</legend>
        <div id="tabs">
            <p class="notice blue"></p>
            <table cellpadding="5" class="field_tbl" id="table-color" width="100%" border="1" bordercolor="red">
                <tr>
                    <!--                        <td> Id</td>-->
                    <!--                        <td> T&#234;n</td>-->
                    <td width="12%"> Phân loại </td>
                    <td  width="13%"> Mã</td>

                    <!--                        <td width="20%"> Màu sắc </td>-->
<!--                    <td width="8%"> Số lượng</td>-->
                    <td width="13%"> Giá thị trường</td>
                    <td width="13%"> Giá bán</td>
                    <td width="13%"> Ngày cập nhật </td>
                    <td width="15%" class="text-center"> Ảnh</td>
<!--                    <td class="text-center" width="15%"> cửa hàng</td>-->

                    <!--                        <td class="col-sm-1"> Bộ nhớ trong</td>-->
                    <!--                        <td class="col-sm-1"> Tình trạng </td>-->
<!--                    <td width="8%"> Còn hàng </td>-->
                    <td width="8%"> Published </td>
                    <td width="3%">Trạng thái</td>
                    <td width="3%"> X&#243;a</td>
                </tr>
                <?php $i = 0;?>
                <?php if(isset($products) && count($products)) {
                    $array_default = array('id','productid','categoryid','manufactory','models');
                    foreach ($products as $field) {
//                            if( !in_array(strtolower($field->field_name),$array_default) ){

                        ?>
                        <input type="hidden" name="id_exist_<?php echo $i;?>" value="<?php echo $field->id; ?>">
                        <tr id="extend_field_exist_<?php echo $i; ?>">
                            <td valign="center" class="left_col">
                                <input type="text" name='products_type_id_exist_<?php echo $i;?>' value="<?php echo $field->name; ?>" />
                                <input type="hidden" name='products_type_id_exist_<?php echo $i;?>_begin' value="<?php echo $field->name; ?>" />
                            </td>
<!--                            <td valign="center" class="left_col">-->
<!--                                <input type="text" name='quan_exist_--><?php //echo $i;?><!--' value="--><?php //echo $field->quantity; ?><!--" />-->
<!--                                <input type="hidden" name='quan_exist_--><?php //echo $i;?><!--_begin' value="--><?php //echo $field->quantity; ?><!--" />-->
<!--                            </td>-->
                            <td valign="center" class="left_col">
                                <input type="text" name='code_exist_<?php echo $i;?>' value="<?php echo $field->code; ?>" />
                                <input type="hidden" name='code_exist_<?php echo $i;?>_begin' value="<?php echo $field->code; ?>" />
                            </td>
                            <td valign="center" class="left_col">
                                <input type="text" name='price_exist_<?php echo $i;?>' value="<?php echo format_money_0($field->price_old); ?>"/>
                                <input type="hidden" name='price_exist_<?php echo $i;?>_begin' value="<?php echo $field->price_old; ?>" />
                            </td>
                            <td valign="center" class="left_col">
                                <input type="text" name='price_h_exist_<?php echo $i;?>' value="<?php echo format_money_0($field->price); ?>"/>
                                <input type="hidden" name='price_h_exist_<?php echo $i;?>_begin' value="<?php echo $field->price; ?>" />
                            </td>
                            <td valign="center" class="left_col">
                                <?php echo 'Cập nhật lúc </br> '. $field->edited_time .'</br>'; ?>
                                <?php if ($field->bitrix == 1) {echo ' từ Bitrix';}else{echo ' từ CMS web';} ?>
                            </td>
                            <td valign="center" class="left_col text-center">
                                <?php $link_img = str_replace('/original/', '/resized/', @$field->image); ?>
                                <img alt="<?php echo @$field->name; ?>" src="<?php echo URL_ROOT . $link_img; ?>" onerror="this.src='/images/not_picture1.png'" style="width: 100px;height: auto"/>
                                <input style="margin: auto;padding-top: 15px" type="file" name="other_image_<?php echo $i ?>"/>
                                <input type="hidden" id="name_image_exit_<?php echo $i; ?>"
                                       name="name_image_exist_<?php echo $i; ?>"
                                       value="<?php echo @$field->image; ?>">
                            </td>

<!--                            <td style="width: auto;padding: 10px">-->
<!--                                <select class="selectbox2" name="store_exist_--><?php //echo $i ?><!--[]" id="store_exist_--><?php //echo $i ?><!--" multiple="multiple">-->
<!--                                    --><?php //foreach ($store_categories as $store) {
//                                        $select = '';
//                                        if(!empty($field->store)){
//                                            $arr = explode(',',substr($field->store,1,-1));
//                                            if(in_array($store->id,$arr))
//                                                $select = 'selected';
//                                        }
//                                        ?>
<!--                                        <option --><?php //echo $select ?><!-- value="--><?php //echo $store->id ?><!--">--><?php //echo $store->name ?><!--</option>-->
<!--                                    --><?php //} ?>
<!--                                </select>-->
<!--                                <input type="hidden" name='store_exist_--><?php //echo $i; ?><!--_begin' value="--><?php //echo $field->store; ?><!--"/>-->
<!---->
<!--                            </td>-->

<!--                            <td valign="center" class="left_col">-->
<!--                                <select name="is_stocking_exist_--><?php //echo $i;?><!--"   id='is_stocking_exist_--><?php //echo $i;?><!--' class='is_config_exist' >-->
<!--                                    <option value="1" --><?php //if(@$field->stocking) echo "selected='selected'" ;?><!--  > Có</option>-->
<!--                                    <option value="0" --><?php //if(!@$field->stocking) echo "selected='selected'" ;?><!--  >Không</option>-->
<!--                                </select>-->
<!--                                <input type="hidden" name='is_stocking_exist_--><?php //echo $i;?><!--_begin' value="--><?php //echo @$field->is_config; ?><!--" />-->
<!--                            </td>-->
                            <td valign="center" class="left_col">
                                <select name="is_published_exist_<?php echo $i;?>"   id='is_published_exist_<?php echo $i;?>' class='is_config_exist' >
                                    <option value="1" <?php if(@$field->published) echo "selected='selected'" ;?>  > Có</option>
                                    <option value="0" <?php if(!@$field->published) echo "selected='selected'" ;?>  >Không</option>
                                </select>
                                <input type="hidden" name='is_published_exist_<?php echo $i;?>_begin' value="<?php echo @$field->is_config; ?>" />

                            </td>
                            <td>
                                <div style="display: flex; justify-content: space-between;align-items: center">
                                    <?php if(@$field->bitrix == 1) {?>
                                        Bitrix <img border="0" alt="Enabled status" src="templates/default/images/published.png">
                                    <?php } ?>
                                    <?php if(@$field->bitrix == 0) {?>
                                        Bitrix <img border="0" alt="Enabled status" src="templates/default/images/unpublished.png">
                                    <?php } ?>
                                </div>
                                <div style="display: flex; justify-content: space-between;align-items: center">
                                    <?php if(@$field->ecount == 1) {?>
                                        Ecount <img border="0" alt="Enabled status" src="templates/default/images/published.png">
                                    <?php } ?>
                                    <?php if(@$field->ecount == 0) {?>
                                        Ecount <img border="0" alt="Enabled status" src="templates/default/images/unpublished.png">
                                    <?php } ?>
                                </div>
                            </td>
                            <td>
                                <a href="javascript: void(0)" onclick="javascript: remove_extend_field(<?php echo $i?>,'<?php echo $field->id; ?>')" >
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>

                        <!--                            --><?php //} ?>

                        <?php $i ++ ;?>
                    <?php }?>
                <?php } ?>

                <?php for( $i = 0 ; $i< 100; $i ++ ) {?>
                    <tr id="tr<?php echo $i; ?>" ></tr>
                <?php }?>

            </table>
            <a style="color: #73c5fa;" href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Thêm"); ?>
                <i class="fa fa-plus-square" aria-hidden="true"></i>
            </a>
        </div>
    </fieldset>

    <!--	end FIELD	-->
    <input type="hidden" value="" name="field_remove" id="field_remove" />
    <input type="hidden" value="<?php echo isset($data)?count($products):0; ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
    <input type="hidden" value="" name="new_field_total" id="new_field_total" />

    <input type="hidden" value="0" name="boxchecked" />
    <!--        <input type="hidden" value="--><?php //echo $max_ordering?><!--" name="max_ordering" id = "max_ordering" />-->
</div>
<!-- END BODY-->

<script>
    $(document).ready(function() {
        // let arr_checkbox = $(".select-checkbox").attr("disabled", true)
        $('.selectbox2').select2();
    });

    var i = 0;
    function addField()
    {
        area_id = "#tr"+i;


        htmlString = "<td>";
        htmlString +=  "<input type=\"text\" name='new_products_type_id_"+i+"' id='new_products_type_id_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" name='new_code_"+i+"' id='new_code_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" name='new_price_"+i+"' id='new_price_"+i+"'  />";
        htmlString += "</td>";


        htmlString += "<td>" ;
        htmlString +=  "<input type=\"text\" name='new_price_h_"+i+"' id='new_price_h_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString += "</td>";

        htmlString += "<td class='text-center'>" ;
        htmlString += "<img alt=\"image\" src=\"\" onerror=\"this.src='/images/not_picture1.png'\" style='width: 60px'/>" ;
        htmlString +=  "<input style='margin: auto;padding-top: 15px' type='file' name='new_other_image_"+i+"'/>";
        htmlString += "</td>";

        //htmlString += "<td>";
        //
        //htmlString += "<select class='selectbox2' name='new_store_color_"+i+"[]' id='new_store_color"+i+"' multiple='multiple'>";
        <?php //foreach ($store_categories as $store) {?>
        //htmlString += "<option value='<?php //echo $store->id;?>//'><?php //echo $store->name;?>//</option>";
        <?php //} ?>
        //htmlString += "</select>";
        //htmlString += "<script>$(document).ready(function() {$('.selectbox2').select2();})<\/script>";
        //htmlString += "</td>";


        // htmlString += "<td>";
        // htmlString += "<select name='new_stocking_"+i+"' id='new_stocking_"+i+"' class='new_stocking'>";
        // htmlString += "<option value=\"1\"  >Có</option>";
        // htmlString += "<option value=\"0\" selected='selected' >Không</option>";
        // htmlString += "</select>";
        // htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<select name='new_published_"+i+"' id='new_published_"+i+"' class='new_published'>";
        htmlString += "<option value=\"1\"  >Có</option>";
        htmlString += "<option value=\"0\" selected='selected' >Không</option>";
        htmlString += "</select>";
        htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "</td>";

        htmlString += "<td>";
        htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ i +")\" >" + "<i class=\"fa fa-trash-o\"></i>" + "</a>";
        htmlString += "</td>";

        $(area_id).html(htmlString);
        i++;
        $("#new_field_total").val(i);
    }

    //remove extend field exits
    function remove_extend_field(area,fieldid)
    {
        if(confirm("You certain want remove this fiels"))
        {
            remove_field = "";
            remove_field = $('#field_remove').val();
            remove_field += ","+fieldid;
            $('#field_remove').val(remove_field);
            $('#extend_field_exist_'+area).html("");
        }
        return false;
    }
    //remove new extend field
    function remove_new_field(area)
    {
        if(confirm("You certain want remove this fiels"))
        {
            area_id = "#tr"+area;
            $(area_id).html("");
        }
        return false;
    }

    function change_ftype(element){
        type_id = $(element).attr('id');
        foreign_id = type_id.replace("ftype","foreign_id");
        val = $(element).val();
        if(val == 'foreign_one' || val == 'foreign_multi'){
            $('#'+foreign_id).show();
        }else{
            $('#'+foreign_id).hide();
        }
    }

</script>
