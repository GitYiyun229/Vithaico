<!-- HEAD -->
<?php
$title = @$order ? FSText::_('Xem đơn hàng ') . 'DH' . str_pad($order->id, 8, "0", STR_PAD_LEFT) . " - Nhanh: $order->nhanh_id - SSC: $order->ssc_id" : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('', FSText::_('Print'), '', 'print.png', 0, 1);
$toolbar->addButton('back', FSText::_('Cancel'), '', 'cancel.png');
?>

<style>
    .table-detail a{
        display: grid;
        grid-template-columns: 88px auto;
        grid-gap: 15px;
        color: #000;
    }
    .table-detail a:hover{
        color: #D53C00;
    }
    .table-detail img{
        width: 88px;
        height: 88px;
        object-fit: contain;
}
</style>

<form action="index.php?module=<?php echo $this->module; ?>&view=<?php echo $this->view; ?>" name="adminForm" method="post" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-4 col-xs-12">
            <div class="panel panel-info">
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

        <div class="col-lg-4 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-cog"></i>
                    <?php echo FSText::_('Thông tin người nhận hàng') ?>
                </div>
                <div class="panel-body">
                    <?php include_once 'detail_recipient.php'; ?>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-xs-12">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <i class="fa fa-cog"></i>
                    <?php echo FSText::_('Thông tin người mua') ?>
                </div>
                <div class="panel-body">
                    <?php include_once 'detail_buyer.php'; ?>
                </div>
            </div>
        </div>
    </div> 

    <table class="table table-striped table-bordered table-hover table-detail">
        <thead>
            <tr> 
                <th>Sản phẩm</th>
                <th>Đơn giá(VNĐ)</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($detail as $item) {
                $link = FSRoute::_("index.php?module=products&view=product&code=" . $item->productInfo->alias . "&id=" . $item->productInfo->id);
                $img = $item->subInfo->image ? URL_ROOT . image_replace_webp($item->subInfo->image, 'resized') : URL_ROOT . image_replace_webp($item->productInfo->image, 'resized');
                ?>
                <tr>
                    <td>
                        <a href="<?php echo $link ?>">
                            <img src="<?php echo $img ?>" alt="<?php echo $item->productInfo->name ?>" class="img-fluid">
                            <div>
                                <div class="fw-medium"><?php echo $item->productInfo->name ?></div>
                                <div class="text-grey"><?php echo $item->subInfo->name ?></div>
                            </div>                                           
                        </a>
                    </td>
                    <td class="fw-medium">
                        <div><?php echo format_money($item->price) ?></div>
                        <?php if ($item->price_old > $item->price) { ?>
                            <div><del class="text-grey"><?php echo format_money($item->price_old) ?></del></div>
                        <?php } ?>
                    </td>
                    <td class="text-center fw-medium">
                        <?php echo $item->count ?>
                    </td>
                    <td class="text-right fw-medium">
                        <?php echo format_money($item->total) ?>
                    </td>
                </tr>
            <?php } ?>

            <tr>
                <td colspan="3" class="text-right"><b>Tạm tính</b></td>
                <td class="text-right"><b><?php echo format_money($order->total_before) ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><b>Chiết khấu/ Flashsale</b></td>
                <td class="text-right"><b><?php echo format_money($order->promotion_discount_price) ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><b>Mã giảm giá/ Thẻ quà tặng</b></td>
                <td class="text-right"><b><?php echo format_money($order->code_discount_price, '', '₫0') ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><b>Hạng thành viên</b></td>
                <td class="text-right"><b><?php echo format_money($order->member_discount_price, '', '₫0') ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><b>Phí giao hàng</b></td>
                <td class="text-right"><b><?php echo format_money($order->ship_price, '', 'Miễn phí') ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="text-right"><b>Tổng thanh toán</b></td>
                <td class="text-right"><b><?php echo format_money($order->total_end) ?></b></td>
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
    <div style="clear: both"></div>
    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Người sửa cuối</label>
        <div class="col-md-10 col-xs-12">
            <?php echo @$order->admin_name ?>
        </div>
        <div style="clear: both"></div>
    </div>

    <div class="form-group">
        <label class="col-md-2 col-xs-12 control-label">Admin note</label>
        <div class="col-md-10 col-xs-12">
            <textarea class="form-control" name="admin_note" id="admin_note" rows="4"><?php echo @$order->admin_note ?></textarea>
        </div>
        <div style="clear: both"></div>
    </div>
</form> 

<script type="text/javascript" language="javascript">
    print_page();

    function print_page() {
        var width = 800;
        var centerWidth = (window.screen.width - width) / 2;
        //	    var centerHeight = (window.screen.height - windowHeight) / 2;
        $('.Print').click(function() {
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