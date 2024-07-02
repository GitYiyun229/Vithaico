<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 5/19/2021
 * Time: 10:59 AM
 */
global $tmpl;
$tmpl->setTitle("Tra cứu sửa chữa");
$tmpl->addStylesheet("repair", "modules/users/assets/css");
//$tmpl -> addScript('users_logged','modules/users/assets/js');

?>
<div class="frame_body row">
    <div class='col-lg-3'>
        <?php include_once 'left_user.php' ?>
    </div>
    <div class='col-lg-9'>
        <div class="chitieu">
            <h1>Thông tin sửa chữa của bạn</h1>
            <?php if (!@$products) { ?>
                <div class="not_prd">
                    <span>!</span>
                    <h2>Bạn không có sản phẩm nào đang sửa chữa</h2>
                </div>
            <?php } else { ?>
                <div class="list_prd scrollbar" id="style-44">
                    <?php
                    $i = 0;
                    foreach ($list as $item) {
                        $i++;
                        $strnhan = $item['NgayNhan'];
                        $strnhan = str_replace('/Date(', '', $strnhan);
                        $strnhan = str_replace('+0700)/', '', $strnhan);
                        $strtra = $item['NgayTra'];
                        $strtra = str_replace('/Date(', '', $strtra);
                        $strtra = str_replace('+0700)/', '', $strtra);
                        $Sua = 'Chưa xử lý';
                        $SuaOK = 'Chưa sửa xong';
                        $Test = 'Chưa test xong';
                        if ($item['Sua'] == true) {
                            $Sua = 'Đã xử lý';
                        }
                        if ($item['SuaOK'] == true) {
                            $SuaOK = 'Đã sửa xong';
                        }
                        if ($item['Test'] == true) {
                            $Test = 'Đã test xong';
                        }
                        ?>
                        <div class="item_dh row" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                            <div class="col-md-4">
                                <p>Số biên nhận: <span><?php echo $item['SoPhieuBH'] ?></span></p>
                            </div>
                            <div class="col-md-4">
                                <p>Ngày nhận: <span><?php echo date("d-m-Y", ($strnhan / 1000)); ?></span></p>
                            </div>
                            <div class="col-md-4 text-center view1">
                                <span>Xem chi tiết ></span>
                            </div>
                        </div>
                        <?php if (count($list) > 1) { ?>
                            <img src="<?php echo URL_ROOT . 'templates/default/images/boder_bot.svg' ?>" alt="boder"
                                 class="boder_bot">
                        <?php } ?>
                        <div class="modal fade" id="myModal<?php echo $i; ?>" role="dialog">
                            <div class="modal-dialog size">
                                <div class="modal-content size1">
                                    <div class="header-modal">
                                        <div class="modal-header">
                                            <h4 class="modal-title"><?php echo FSText::_("Thông tin bảo hành của bạn") ?></h4>
                                            <button type="button" class="close"
                                                    data-dismiss="modal"><span aria-hidden="true">&times;</span>
                                                <span class="sr-only">Close</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p><b>Số biên nhận</b> : <?php echo $item['SoPhieuBH'] ?></p>
                                            <p><b>Tên khách hàng</b> : <?php echo $item['TenKhachHang'] ?></p>
                                            <p><b>Số điện thoại</b> : <?php echo $item['DiDong'] ?></p>
                                            <p><b>Ngày nhận</b> : <?php echo date("d-m-Y", ($strnhan / 1000)); ?></p>
                                            <p><b>Model Máy</b> : <?php echo $item['MaHang'] ?></p>
                                            <p><b>Imei</b> : <?php echo $item['Imei'] ?></p>
                                            <p><b>Tình trạng bệnh</b> : <?php echo $item['MoTaBenh'] ?></p>
                                            <p><b>Xử lý</b> : <?php echo $Sua ?></p>
                                            <p><b>Giá Sửa chữa</b> : <?php echo format_money($item['GiaSuaChua']) ?></p>
                                            <p><b>Trạng thái </b> : <?php echo $SuaOK ?></p>
                                            <p><b>QA </b> : <?php echo $Test ?></p>
                                            <p><b>Tên sản phẩm</b> : <?php echo $item['TenHang'] ?></p>
                                            <p><b>Địa điểm</b> : <?php echo $item['DiaDiem'] ?></p>
                                            <p><b>Diễn giải</b> : <?php echo $item['DienGiai'] ?></p>
                                            <p><b>Ngày hẹn trả</b> : <?php echo $item['NgayHenTra']; ?></p>
                                            <p><b>Ngày trả</b> : <?php echo $item['NgayTra']; ?></p>
                                            <!-- <p><b>Số phiếu bảo hành</b> : <?php echo $item['SoPhieuBH'] ?></p> -->
                                        </div>
                                        <div class="modal-footer">Cảm ơn quý khách đã mua hàng ở 24hstore</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>

            <!--            <h3 class="thank">Cảm ơn quý khách đã mua hàng ở 24hstore!</h3>-->
        </div>
    </div>
</div>
