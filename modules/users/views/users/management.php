<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 5/19/2021
 * Time: 10:59 AM
 */
global $tmpl;
$tmpl->setTitle("Quản lý đơn hàng");
$tmpl->addStylesheet("management", "modules/users/assets/css");
$tmpl->addScript('users_logged', 'modules/users/assets/js');

?>
<div class="frame_body row">
    <div class='col-lg-3'>
        <?php include_once 'left_user.php' ?>
    </div>
    <div class='col-lg-9'>
        <div class="chitieu">
            <h1>Quản lý đơn hàng</h1>
            <div class="list_prd scrollbar" id="style-44">
                <?php
                $i = 0;
                foreach ($list_bill as $item => $value) {
                    $i++;
                    $strnhan = $item;
                    $strnhan = str_replace('/Date(', '', $strnhan);
                    $strnhan = str_replace('+0700)/', '', $strnhan);
                    ?>
                    <div class="item_dh row" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                        <div class="col-md-6">
                            <p>Mã hóa đơn: <span><?php echo $main_item[$item]['MaHang'] ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <p class="time_1">
                                Ngày: <span
                                        id="time_<?php echo $i; ?>"><?php echo date("d/m/Y", ($strnhan / 1000)) ?></span>
                            </p>
                        </div>
                    </div>
                    <div class="modal fade" id="myModal<?php echo $i; ?>" role="dialog">
                        <div class="modal-dialog size">
                            <div class="modal-content size1">
                                <div class="header-modal">
                                    <div class="modal-header">
                                        <h4 class="modal-title"><?php echo FSText::_("Thông tin quản lý đơn hàng") ?></h4>
                                        <button type="button" class="close"
                                                data-dismiss="modal"><span aria-hidden="true">&times;</span>
                                            <span class="sr-only">Close</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <!--                                        <p>Mã sản phẩm: <span>-->
                                        <?php //echo $main_item[$item]['MaHang'] ?><!--</span></p>-->
                                        <div><strong style="font-size: 16px">Sản phẩm:</strong>
                                            <?php foreach ($value as $key) { ?>
                                                <div class="item_ma">
                                                    <span class="item_prd"><?php echo $key['TenHang'] ?></span>
                                                    <span class="gia_item"><?php echo $key['ThanhTien']?format_money($key['ThanhTien'], ' vnđ'):'0 vnđ' ?></span>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <p class="total_price">Tổng hóa đơn:
                                            <span><?php echo format_money($total1[$item], ' vnđ') ?></span>
                                        </p>
                                    </div>
                                    <div class="modal-footer">Cảm ơn quý khách đã mua hàng ở 24hstore</div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <h3 class="thank">Cảm ơn quý khách đã mua hàng ở 24hstore!</h3>
        </div>
    </div>
</div>
