<!-- HEAD -->
<?php
$title = @$order ? FSText:: _('Xem đơn hàng ') . 'DH' . str_pad($order->id, 8, "0", STR_PAD_LEFT) : FSText:: _('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('apply', FSText:: _('Apply'), '', 'apply.png');
$toolbar->addButton('', FSText:: _('Print'), '', 'print.png', 0, 1);
$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');
?>
<!-- END HEAD-->

<!-- BODY-->
<form action="index.php?module=<?php echo $this->module; ?>&view=<?php echo $this->view; ?>"
      name="adminForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-6 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-cog"></i>
                    Mã đơn hàng: <strong><?php echo 'DH' . str_pad($order->id, 8, "0", STR_PAD_LEFT); ?></strong>
                </div>
                <div class="panel-body">
                    <?php $print = FSInput::get('print', 0, 'int'); ?>
                    <?php if (!$print) { ?>
                        <?php include_once 'detail_status.php'; ?>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xs-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <i class="fa fa-cog"></i>
                    <?php echo FSText::_('Thông tin người mua hàng') ?>
                </div>
                <div class="panel-body">
                    <?php include_once 'detail_recipient.php'; ?>
                </div>
            </div>
        </div>

    </div>

    <div class="form_body">

    </div>
    <?php
    ?>

    <table class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <th width="30">STT</th>
            <th width="35%"><?php echo FSText::_('Tên sản phẩm') ?></th>
            <th width="25%"><?php echo "Phân loại"; ?></th>
            <th><?php echo "Giá(VNĐ)"; ?></th>
            <th width="10%"><?php echo "Số lượng"; ?></th>
            <th><?php echo "Tổng giá tiền"; ?></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td align="center"><strong>1</strong></td>
            <td>
                <a href="<?php echo FSRoute::_('index.php?module=products&view=product&ccode=' . $product_main->alias); ?>"
                   target="_blank">
                    <?php echo $product_main->name; ?>
                </a>
            </td>
            <td>
                <?php if (@$product_sub) { ?>
                    <span>Màu: <?php echo @$product_sub->name; ?></span>
                    <?php if (@$warranty) { ?>
                        <p>Gói bảo hành: <?php echo @$warranty->warranty_name.'('.format_money_0($warranty->price,'đ','liên hệ').')'; ?></p>
                    <?php } ?>

                <?php } ?>
            </td>

            <!--		PRICE 	-->
            <td>
                <!--                --><?php //if ($item->discount > 0) { ?>
                <?php echo format_money_0($order->price, ' VNĐ'); ?>
                <!--                --><?php //} else { ?>
                <!--                    --><?php //echo format_money_0($item->price, ' VNĐ'); ?>
                <!--                --><?php //} ?>
            </td>
            <td>
                <input class="form-control" id="disabledInput" type="text"
                       placeholder="<?php echo FSText::_('Số lượng'); ?>" value="<?php echo 1; ?>"
                       disabled="">
            </td>
            <td>
                        <span class='red'>
<!--                            --><?php //if ($item->discount > 0) { ?>
                            <?php echo format_money_0($order->price, ' VNĐ'); ?>
                            <!--                            --><?php //} else { ?>
                            <!--                                --><?php //echo format_money_0($item->price, ' VNĐ'); ?>
                            <!--                            --><?php //} ?>
                        </span>
            </td>
        </tr>
        <tr>
            <td colspan="5" align="right">
                <strong>T&#7893;ng ti&#7873;n:</strong>
            </td>
            <td>
                <strong class='red'><?php echo format_money_0($order->price, ' VNĐ'); ?>
            </td>
        </tr>
        <!--        <tr>-->
        <!--            <td colspan="5" align="right">-->
        <!--                <strong>Phí ship:</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <strong class='red'>-->
        <!--                    --><?php //if ($order->fee)
        //                        echo format_money_0($order->fee, ' VNĐ');
        //                    else
        //                        echo "Miễn phí";
        //                    ?>
        <!--                </strong>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td colspan="5" align="right">-->
        <!--                <strong>Đơn vị vận chuyển:</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <strong class='red'>-->
        <!--                    --><?php
        //                    echo $order->transport;
        //                    ?>
        <!--                </strong>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td colspan="5" align="right">-->
        <!--                <strong>Mã giảm giá:</strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <strong class='red'>-->
        <!--                    --><?php //echo format_money_0($order->discount_money, ' VNĐ');
        //                    ?>
        <!--                </strong>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td colspan="5" align="right">-->
        <!--                <strong>Chương trình giảm giá:-->
        <!--                </strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <strong class='red'>--><?php
        //                    if ($order->discount_title)
        //                        echo $order->discount_title;
        //                    else
        //                        echo "";
        //                    ?><!--</strong>-->
        <!--            </td>-->
        <!--        </tr>-->
        <!--        <tr>-->
        <!--            <td colspan="5" align="right">-->
        <!--                <strong>Giảm giá:-->
        <!--                </strong>-->
        <!--            </td>-->
        <!--            <td>-->
        <!--                <strong class='red'>--><?php
        //                    if ($order->discount_money)
        //                        echo format_money_0($order->discount_money, ' VNĐ');
        //                    else
        //                        echo "0 VNĐ";
        //                    ?><!--</strong>-->
        <!--            </td>-->
        <!--        </tr>-->
        <tr>
            <td colspan="5" align="right">
                <strong>Thanh toán:</strong>
            </td>
            <td>
                <strong class='red'><?php
                    if ($order->price && $order->fee)
                        echo format_money_0($order->price + $order->fee, ' VNĐ');
                    elseif (!$order->price && $order->fee)
                        echo format_money_0($order->fee, ' VNĐ');
                    elseif ($order->price && !$order->fee)
                        echo format_money_0($order->price, ' VNĐ');
                    elseif (!$order->price && !$order->fee)
                        echo '0 VNĐ';
                    ?>
                </strong>
            </td>
        </tr>
        </tbody>
    </table>
    <?php if (@$order->id) { ?>
        <input type="hidden" value="<?php echo $order->id; ?>" name="id">
    <?php } ?>
    <input type="hidden" value="<?php echo $this->module; ?>" name="module">
    <input type="hidden" value="<?php echo $this->view; ?>" name="view">
    <input type="hidden" value="" name="task">
    <input type="hidden" value="0" name="boxchecked">


    <?php
    TemplateHelper::dt_text(FSText:: _('Người sửa cuối'), @$order->author_last, '', '', '', 'col-md-2', 'col-md-10');
    ?>
    <div style="clear: both"></div>
    <?php
    TemplateHelper::dt_edit_text(FSText:: _('Admin note'), 'admin_note', @$order->admin_note, '', '', '4', 0, '', '', 'col-sm-2', 'col-sm-10');
    ?>
</form>
<!-- end FORM	MAIN - ORDER						-->

<!--  ESTORE INFO -->
<?php // include_once 'detail_estore.php'; ?>
<!--  end ESTORE INFO -->


<!--  RECIPIENT INFO -->
<?php //include_once 'detail_recipient.php'; ?>
<!--  end RECIPIENT INFO -->

<?php // include_once 'detail_payment.php'; ?>
<!-- END BODY-->

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
