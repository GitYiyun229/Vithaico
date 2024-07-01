<?php
$max_ordering = 1;
$i = 0;
?>
<table border="1" class="tbl_form_contents" width="100%" cellspacing="4" cellpadding="4" bordercolor="#CCC">
    <thead>
        <tr>
            <th align="center" >
                <?php echo FSText::_("Tên"); ?>
            </th>
            <th align="center" >
                <?php echo FSText::_("Thông tin"); ?>
            </th>
            <th align="center"  width="15" >
                <?php echo FSText::_("Remove"); ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (isset($document_excel) && !empty($document_excel)) {
            foreach ($document_excel as $item) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" value="<?php echo $item->id; ?>" name="id_exist_excel_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="text" size="30" value="<?php echo $item->name; ?>" name="name_exist_excel_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="hidden" value="<?php echo $item->name; ?>" name="name_exist_excel_<?php echo $i; ?>_original"/>
                        <span style="color: red;">(auto)</span>
                    </td>
                    <td>
                        <?php 
                            $html = '<div class="sort_excel_exist_' . $i . '">';
                            $html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="' . URL_ROOT . $item->content . '">' . $item->content . '</a>';
                            $html .= '</div>';
                            echo $html;
                        ?>
                        <div class="fileUpload btn btn-primary ">
                            <span><i class="fa fa-cloud-upload"></i> Upload</span>
                            <input type="file" class="upload" id ="excel_exist_<?php echo $i; ?>" name="excel_exist_<?php echo $i; ?>"  />
                            <input type="hidden" name="excel_exist_<?php echo $i; ?>_begin" value="<?php echo $item->content; ?>" />
                            <input type="hidden" id="check_excel_exist_<?php echo $i; ?>" value="1" />                        
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" onclick="remove_excel(this.checked);" value="<?php echo $item->id; ?>"  name="other_excel[]" id="other_excel<?php echo $i; ?>" />
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <?php for ($i = 0; $i < 20; $i ++) { ?>
            <tr id='new_excel_<?php echo $i ?>' class='new_record closed'>
                <td>
                    <input placeholder="Tên file..." type="text" size="30" id="new_name_excel_<?php echo $i; ?>" name="new_name_excel_<?php echo $i; ?>"/>
                    <span style="color: red;">(auto)</span>
                </td>

                <td>
                     <div class="fileUpload btn btn-primary ">
                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                        <input type="file" class="upload" id ="new_file_excel_<?php echo $i; ?>" name="new_file_excel_<?php echo $i; ?>"  />
                        <input type="hidden" id="check_new_excel_<?php echo $i; ?>" value="0" />                        
                    </div>
                </td>
                <td>
                    <input type="checkbox" onclick="remove_excel(this.checked);" value="<?php echo $item->id; ?>"  name="other_excel[]" id="other_excel<?php echo $i; ?>" />
                </td>
            </tr>
        <?php } ?>
    </tbody>		
</table>
<div class='add_record'>
    <a href="javascript:add_excel()"><strong class='red'><?php echo FSText::_("Thêm file"); ?></strong></a>
</div>
<input type="hidden" value="<?php echo isset($document_excel) ? count($document_excel) : 0; ?>" name="exist_total_excel" id="exist_total_excel" />

<script type="text/javascript" >
    function remove_excel(isitchecked) {
        if (isitchecked == true) {
            document.adminForm.otherprices_remove.value++;
        } else {
            document.adminForm.otherprices_remove.value--;
        }
    }
    function add_excel() {
        for (var i = 0; i < 20; i++) {
            tr_current = $('#new_excel_' + i);
            if (tr_current.hasClass('closed')) {
                tr_current.addClass('opened').removeClass('closed');
                return;
            }
        }
    }


</script>
<style>
    .closed{
        display:none;
    }
</style>