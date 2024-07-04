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
        if (isset($document_word) && !empty($document_word)) {
            foreach ($document_word as $item) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" value="<?php echo $item->id; ?>" name="id_exist_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="text" size="30" value="<?php echo $item->name; ?>" name="name_exist_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="hidden" value="<?php echo $item->name; ?>" name="name_exist_<?php echo $i; ?>_original"/>
                        <span style="color: red;">(auto)</span>
                    </td>
                    <td>
                        <?php 
                            $html = '<div class="sort_word_exist_' . $i . '">';
                            $html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="' . URL_ROOT . $item->content . '">' . $item->content . '</a>';
                            $html .= '</div>';
                            echo $html;
                        ?>
                        <div class="fileUpload btn btn-primary ">
                            <span><i class="fa fa-cloud-upload"></i> Upload</span>
                            <input type="file" class="upload" id ="word_exist_<?php echo $i; ?>" name="word_exist_<?php echo $i; ?>"  />
                            <input type="hidden" name="word_exist_<?php echo $i; ?>_begin" value="<?php echo $item->content; ?>" />
                            <input type="hidden" id="check_word_exist_<?php echo $i; ?>" value="1" />                        
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" onclick="remove_word(this.checked);" value="<?php echo $item->id; ?>"  name="other_word[]" id="other_word<?php echo $i; ?>" />
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <?php for ($i = 0; $i < 20; $i ++) { ?>
            <tr id='new_word_<?php echo $i ?>' class='new_record closed'>
                <td>
                    <input placeholder="Tên file..." type="text" size="30" id="new_name_<?php echo $i; ?>" name="new_name_<?php echo $i; ?>"/>
                    <span style="color: red;">(auto)</span>
                </td>

                <td>
                     <div class="fileUpload btn btn-primary ">
                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                        <input type="file" class="upload" id ="new_file_word_<?php echo $i; ?>" name="new_file_word_<?php echo $i; ?>"  />
                        <input type="hidden" id="check_new_word_<?php echo $i; ?>" value="0" />                        
                    </div>
                </td>
                <td>
                    <input type="checkbox" onclick="remove_word(this.checked);" value="<?php echo $item->id; ?>"  name="other_word[]" id="other_word<?php echo $i; ?>" />
                </td>
            </tr>
        <?php } ?>
    </tbody>		
</table>
<div class='add_record'>
    <a href="javascript:add_word()"><strong class='red'><?php echo FSText::_("Thêm file"); ?></strong></a>
</div>
<input type="hidden" value="<?php echo isset($document_word) ? count($document_word) : 0; ?>" name="exist_total" id="exist_total" />

<script type="text/javascript" >
    function remove_word(isitchecked) {
        if (isitchecked == true) {
            document.adminForm.otherprices_remove.value++;
        } else {
            document.adminForm.otherprices_remove.value--;
        }
    }
    function add_word() {
        for (var i = 0; i < 20; i++) {
            tr_current = $('#new_word_' + i);
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