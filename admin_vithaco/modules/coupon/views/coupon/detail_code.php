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
                <?php echo FSText::_("Mã"); ?>
            </th>
            <th align="center" >
                <?php echo FSText::_("Link"); ?>
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
                        <div class="fileUpload ">
                            <input type="hidden" value="<?php echo $item->id; ?>" name="id_exist_<?php echo $i; ?>"/>
                            <input placeholder="Tên mã" type="text" size="30" value="<?php echo $item->name; ?>" name="name_exist_<?php echo $i; ?>"/>
                            <input placeholder="Tên mã" type="hidden" value="<?php echo $item->name; ?>" name="name_exist_<?php echo $i; ?>_original"/>
                        </div>
                    </td>
                    <td>
                        <div class="fileUpload ">
                            <input type="text" class="price_add" value="<?php echo $item->content; ?>" id ="word_exist_<?php echo $i; ?>" name="word_exist_<?php echo $i; ?>"  />
                            <input type="hidden" name="word_exist_<?php echo $i; ?>_begin" value="<?php echo $item->content; ?>" />
<!--                            <input type="hidden" id="check_word_exist_<?php echo $i; ?>" value="0" />                        -->
                        <input type="hidden" name="created_time_exis_<?php echo $i; ?>_begin" value="<?php echo $item->published_time; ?>" />
                        <?php 
                        TemplateHelper::dt_date_pick ( FSText :: _('' ), 'created_time_exis_'.$i, $item->published_time?$item->published_time:date('Y-m-d H:i:s'), '', '','','col-md-12','col-md-12','col-md-10');
                        ?>
                        </div>
                    </td>

                    <td>
                        <div class="fileUpload">
                        <?php 
                            $html = '<div class="sort_word_exist_' . $i . '">';
                            $html .= '<a target="_blank" style="color: rgba(255, 153, 0, 0.79);" href="' . URL_ROOT . $item->link . '">' . $item->link . '</a>';
                            $html .= '</div>';
                            echo $html;
                        ?>
                        <!--<input type="hidden" value="<?php echo $item->link; ?>" name="link_exist_<?php echo $i; ?>"/>-->
                        <input placeholder="Link" type="text" size="30" value="<?php echo $item->link; ?>" name="nm_link_exist_<?php echo $i; ?>"/>
                        <input placeholder="Link" type="hidden" value="<?php echo $item->link; ?>" name="nm_link_exist_<?php echo $i; ?>_begin"/>
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
        <?php for ($i = 0; $i < 50; $i ++) { ?>
            <tr id='new_word_<?php echo $i ?>' class='new_record closed'>
                <td>
                    <div class="fileUpload ">
                    <input placeholder="Tên mã" type="text" size="30" id="new_name_<?php echo $i; ?>" name="new_name_<?php echo $i; ?>"/>
                    </div>
                </td>

                <td>
                     <div class="fileUpload ">
                         <input type="text" class="price_add" id ="new_file_word_<?php echo $i; ?>" name="new_file_word_<?php echo $i; ?>" value="0" />
                        <input type="hidden" id="check_new_word_<?php echo $i; ?>" value="0" />    
                    <?php 
                    TemplateHelper::dt_date_pick ( FSText :: _('' ), 'created_time_'.$i, date('Y-m-d H:i:s'), '', '','','col-md-12','col-md-12','col-md-10');
                    ?>						
                    </div>
                </td>
                <td>
                    <div class="fileUpload ">
                        <input type="text" placeholder="link" class="price_add" id ="new_link_<?php echo $i; ?>" name="new_link_<?php echo $i; ?>" />
                    <input type="hidden" id="check_new_link_<?php echo $i; ?>" value="0" />    
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
    <a href="javascript:add_word()"><strong class='red'><?php echo FSText::_("Thêm mã"); ?></strong></a>
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
        for (var i = 0; i < 50; i++) {
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