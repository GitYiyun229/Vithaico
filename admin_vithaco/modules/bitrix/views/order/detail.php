<!-- HEAD -->
<?php
$title = @$order ? FSText:: _('Xem đơn hàng ') . 'DH' . str_pad($log->order_id, 8, "0", STR_PAD_LEFT) : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
//$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
//$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
//$toolbar->addButton('', FSText:: _('Print'), '', 'print.png', 0, 1);
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');
?>
<!-- END HEAD-->

<!-- BODY-->
<form action="index.php?module=<?php echo $this->module; ?>&view=<?php echo $this->view; ?>" name="adminForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-cog"></i>
                    Mã đơn hàng: <strong><?php echo 'DH' . str_pad($log->order_id, 8, "0", STR_PAD_LEFT); ?></strong>
                </div>
                <div class="panel-body">
                    <pre>
                        <?php print_r($order->bitrix_false) ?>
                    </pre>
                </div>
            </div>
        </div>
    </div>
    <?php if (@$log->id) { ?>
        <input type="hidden" value="<?php echo $log->id; ?>" name="id">
    <?php } ?>
    <input type="hidden" value="<?php echo $this->module; ?>" name="module">
    <input type="hidden" value="<?php echo $this->view; ?>" name="view">
    <input type="hidden" value="" name="task">
    <input type="hidden" value="0" name="boxchecked">
    <div style="clear: both"></div>

</form>
<script type="text/javascript" language="javascript">
    print_page();

    function print_page() {
        var width = 800;
        var centerWidth = (window.screen.width - width) / 2;
//	    var centerHeight = (window.screen.height - windowHeight) / 2;
        $('.Print').click(function () {
            link = window.location.href;
            link += '&print=1';
            window.open(link, "", "width=" + width + ",menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0',left=" + centerWidth + ",top=0");
        });
    }

    function submitbutton(pressbutton) {
        alert(pressbutton);
        if (pressbutton == 'remove') {
            if (confirm('Bạn có chắc chắn muốn xóa?'))
                submitform(pressbutton);
        } else {
            submitform(pressbutton);
        }
    }

    /**
     * Submit the admin form
     */
    function submitform(pressbutton) {
        if (pressbutton == 'export') {
            url_current = window.location.href;
            url_current = url_current.replace('#', '');
            window.open(url_current + '&task=export');
            return;
        }
        alert(pressbutton);
        if (pressbutton) {
            document.adminForm.task.value = pressbutton;
        }
        if (typeof document.adminForm.onsubmit == "function") {
            document.adminForm.onsubmit();
        }

        if (document.adminForm.task.value != 'cancel') {

        }

        document.adminForm.submit();
    }

</script>
