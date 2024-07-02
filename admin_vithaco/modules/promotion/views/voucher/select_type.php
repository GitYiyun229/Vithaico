<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/products.css" />
<!--<link type="text/css" rel="stylesheet" media="all" href="../ddtm_admin/templates/default/css/select2.min.css"/>-->
<!--<script type="text/javascript" src="../ddtm_admin/templates/default/js/select2.min.js"></script>-->
<?php
$title = FSText::_('Chọn 1 Danh mục để tiếp tục');
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png');
$toolbar->addButton('back', FSText::_('Cancel'), '', 'cancel.png');
?>

<div class="row">
    <div class="col-md-6 col-xs-12" style="float: none;margin:auto">
        <select name="" id="select2-cat" class="select2-temp">
            <option value="0" selected hidden disabled>Chọn loại voucher</option>
            <option value="1">Voucher freeship</option>
            <option value="2">Voucher sản phẩm</option>
        </select>
        <script>
            $(document).ready(function() {
                // $('#select2-cat').select2();
                $('#select2-cat').on('change', function() {
                    let cid = $(this).select2('val');
                    url_current = window.location.href;
                    url_current = url_current.replace('#', '');
                    if (cid != 0)
                        window.location.href = url_current + '&task=add&type=' + cid;
                    else
                        alert('Bạn chưa chọn danh mục!');
                    // window.location.href=url_current+'&task=add';
                })
            })
        </script>
    </div>
</div>


<script type='text/javascript'>
    function submitbutton_(pressbutton, cid) {
        submitform_(pressbutton, cid);
    }
    /**
     * Submit the admin form
     */
    function submitform_(pressbutton, cid) {
        if (pressbutton) {
            url_current = window.location.href;
            url_current = url_current.replace('#', '');
            if (cid)
                window.location.href = url_current + '&task=' + pressbutton + '&cid=' + cid;
            else
                window.location.href = url_current + '&task=' + pressbutton;
            return;
        }
    }
</script>