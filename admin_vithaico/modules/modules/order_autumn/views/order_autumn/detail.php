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
    <p style="font-weight: bold;font-size: 16px">Sản phẩm cũ của khách hàng</p>
    <table class="table_order" cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE" width='100%'>
        <thead>
        <tr>
            <!--                <th width="">STT</th>-->
            <th width="30%">Tên sản phẩm</th>

            <th width="50%"><?php echo "Chi tiết"; ?></th>
            <th width="20%"><?php echo "Giá thu vào"; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_money = 0;
        $total_discount = 0;
        //		for($i = 0 ; $i < count($data); $i ++ ){
        ?>
        <?php
        $item = $data;
        $link_view_product = FSRoute::_('index.php?module=products&view=product&ccode=' . $product_old->alias);
        $total_money += $item->total_after_discount;
        //			 $total_discount += $item->discount * $item->count;
        ?>
        <tr>

            <td>
                <a href="<?php echo $link_view_product; ?>" target="_blank"><?php echo $product_old->name; ?></a>
            </td>

            <!--		PRICE 	-->
            <td>
                <?php
                if ($item->autumn_id) {
                    echo '<div>Ngoại hình : ' . $item->autumn_name . '</div>';
                }
                if ($item->combo_id) {
                    echo '<div>Phụ kiện và bảo hành : ' . $item->combo_name . '</div>';
                }
                ?>
            </td>
            <td>
                <span class='red'><?php echo format_money_0($item->price_cu,'đ','liên hệ'); ?> </span>
            </td>
        </tr>
        <!--		--><?php //}
        ?>
        </tbody>
    </table>
    <p style="font-weight: bold;font-size: 16px">Sản phẩm của cửa hàng</p>
    <table class="table_order" cellpadding="6" cellspacing="0" border="1" bordercolor="#CECECE" width='100%'>
        <thead>
        <tr>
            <!--                <th width="">STT</th>-->
            <th width="30%">Tên sản phẩm</th>

            <th width="50%"><?php echo "Chi tiết"; ?></th>
            <th width="20%"><?php echo "Giá tiền"; ?></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $total_money = 0;
        $total_discount = 0;
        //		for($i = 0 ; $i < count($data); $i ++ ){
        ?>
        <?php
        $item = $data;
        $link_view_product = FSRoute::_('index.php?module=products&view=product&ccode=' . $product_new->alias);
        $total_money += $item->total_after_discount;
        //			 $total_discount += $item->discount * $item->count;
        ?>
        <tr>
            <td>
                <a href="<?php echo $link_view_product; ?>" target="_blank"><?php echo $product_new->name; ?></a>
            </td>

            <!--		PRICE 	-->
            <td >
                <?php
                if ($item->color_id) {
                    echo '<div>Màu sắc : Màu ' . $item->color_name . '</div>';
                }
                if ($item->origin_id) {
                    echo '<div>Tình trạng : ' . $item->origin_name . '</div>';
                }
                if ($item->species_id) {
                    echo '<div>RAM : ' . $item->species_name . '</div>';
                }
                ?>
            </td>
            <td>
                <span class='red'><?php echo format_money_0($item->price,'đ','liên hệ'); ?> </span>
            </td>
        </tr>
        <!--		--><?php //}
        ?>
        <tr>
            <td colspan="2" align="right"><strong>Số tiền cần bù thêm:</strong></td>
            <td><strong class='red'><?php echo format_money($total_money); ?> </strong>
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
<style>
    .table_order{
        margin-bottom: 20px;
    }
    .table_order tr th{
        padding: 10px;
        text-align: center;
    }
    .table_order tr td{
        padding: 10px;
    }
    .table_order tr td a{
        color: #337ab7;
    }
</style>
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
