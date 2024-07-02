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
        if (isset($document_pdf) && !empty($document_pdf)) {
            foreach ($document_pdf as $item) {
                ?>
                <tr>
                    <td>
                        <input type="hidden" value="<?php echo $item->id; ?>" name="id_exist_pdf_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="text" size="30" value="<?php echo $item->name; ?>" name="name_exist_pdf_<?php echo $i; ?>"/>
                        <input placeholder="Tên file..." type="hidden" value="<?php echo $item->name; ?>" name="name_exist_pdf_<?php echo $i; ?>_original"/>
                        <span style="color: red;">(auto)</span>
                    </td>
                    <td>
                        <?php 
                            $html = '<div class="sort_pdf_exist_' . $i . '">';
                            $html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="' . URL_ROOT . $item->content . '">' . $item->content . '</a>';
                            $html .= '</div>';
                            echo $html;
                        ?>
                        <div class="fileUpload btn btn-primary ">
                            <span><i class="fa fa-cloud-upload"></i> Upload</span>
                            <input type="file" class="upload" id ="pdf_exist_<?php echo $i; ?>" name="pdf_exist_<?php echo $i; ?>"  />
                            <input type="hidden" name="pdf_exist_<?php echo $i; ?>_begin" value="<?php echo $item->content; ?>" />
                            <input type="hidden" id="check_pdf_exist_<?php echo $i; ?>" value="1" />                        
                        </div>
                    </td>
                    <td>
                        <input type="checkbox" onclick="remove_pdf(this.checked);" value="<?php echo $item->id; ?>"  name="other_pdf[]" id="other_pdf<?php echo $i; ?>" />
                    </td>
                </tr>
                <?php
                $i++;
            }
        }
        ?>
        <?php for ($i = 0; $i < 20; $i ++) { ?>
            <tr id='new_pdf_<?php echo $i ?>' class='new_record closed'>
                <td>
                    <input placeholder="Tên file..." type="text" size="30" id="new_name_pdf_<?php echo $i; ?>" name="new_name_pdf_<?php echo $i; ?>"/>
                    <span style="color: red;">(auto)</span>
                </td>

                <td>
                     <div class="fileUpload btn btn-primary ">
                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                        <input type="file" class="upload" id ="new_file_pdf_<?php echo $i; ?>" name="new_file_pdf_<?php echo $i; ?>"  />
                        <input type="hidden" id="check_new_pdf_<?php echo $i; ?>" value="0" />                        
                    </div>
                </td>
                <td>
                    <input type="checkbox" onclick="remove_pdf(this.checked);" value="<?php echo $item->id; ?>"  name="other_pdf[]" id="other_pdf<?php echo $i; ?>" />
                </td>
            </tr>
        <?php } ?>
    </tbody>		
</table>
<div class='add_record'>
    <a href="javascript:add_pdf()"><strong class='red'><?php echo FSText::_("Thêm file"); ?></strong></a>
</div>
<input type="hidden" value="<?php echo isset($document_pdf) ? count($document_pdf) : 0; ?>" name="exist_total_pdf" id="exist_total_pdf" />

<script type="text/javascript" >
    function remove_pdf(isitchecked) {
        if (isitchecked == true) {
            document.adminForm.otherprices_remove.value++;
        } else {
            document.adminForm.otherprices_remove.value--;
        }
    }
    function add_pdf() {
        for (var i = 0; i < 20; i++) {
            tr_current = $('#new_pdf_' + i);
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