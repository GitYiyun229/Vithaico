

<div class="form_body">
    <fieldset>
        <legend>Danh Sách</legend>
        <div id="tabs">
            <p class="notice blue"></p>
            <table cellpadding="5" class="field_tbl" id="table-color" width="100%" border="1" bordercolor="red">
                <tr>
                    <td>Câu hỏi</td>
                    <td>Trả lời</td> 
                    <td>Xóa</td>
                </tr>
                <?php $total = 0; $faq = json_decode($data->faq); ?>
                <?php if(!empty($faq)) { 
                    $total = count($faq);
                    ?>
                    <?php foreach ($faq as $i=>$field) { ?>
                        <tr id="extend_field_exist_<?php echo $i; ?>">
                            <td valign="center" class="left_col">
                                <input type="text" name='question_<?php echo $i;?>' value="<?php echo $field->question; ?>" />
                            </td> 
                            <td>
                                <input type="text" name='answer_<?php echo $i;?>' value="<?php echo $field->answer; ?>" />
                            </td>
                            <td>
                                <a href="javascript: void(0)" onclick="javascript: remove_extend_field(<?php echo $i?>,'<?php echo $i; ?>')" >
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>
                        </tr>
                    <?php }?>
                <?php } ?>

                <?php for( $i = $total ; $i< 100; $i ++ ) {?>
                    <tr id="tr<?php echo $i; ?>" ></tr>
                <?php }?>
 
            </table>
            <a style="color: #73c5fa;" href="javascript:void(0);" onclick="addField()" > <?php echo FSText :: _("Thêm"); ?>
                <i class="fa fa-plus-square" aria-hidden="true"></i>
            </a>
        </div>
    </fieldset>

    <input type="hidden" value="" name="field_remove" id="field_remove" />
    <input type="hidden" value="<?php echo $total ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
    <input type="hidden" value="<?php echo $total ?>" name="new_field_total" id="new_field_total" />
 </div>
 

<script>
    var i = <?php echo $total ?>;
    function addField()
    {
        area_id = "#tr"+i;


        htmlString = "<td>";
        htmlString +=  "<input class='form-control' type=\"text\" name='question_"+i+"' id='question_"+i+"'  />";
        htmlString += "</td>";

        htmlString += "<td>" ;
        htmlString +=  "<input class='form-control' type=\"text\" name='answer_"+i+"' id='answer_"+i+"'  />";
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