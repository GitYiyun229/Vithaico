<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 5/19/2021
 * Time: 10:59 AM
 */
global $tmpl;
$tmpl->setTitle("Tra cứu bảo hành");
$tmpl->addStylesheet("warranty", "modules/users/assets/css");
//$tmpl -> addScript('users_logged','modules/users/assets/js');
//var_dump($products);
?>
<div class="frame_body row">
    <div class='col-lg-3'>
        <?php include_once 'left_user.php' ?>
    </div>
    <div class='col-lg-9'>
        <div class="chitieu">
            <h1>Thông tin bảo hành của bạn</h1>
            <?php if (@$products) { ?>
            <!--                <div class="not_prd">-->
            <!--                    <span>!</span>-->
            <!--                    <h2>Bạn chưa có sản phẩm nào</h2>-->
            <!--                </div>-->
            <!--            --><?php //} else { ?>
            <div class="list_prd scrollbar" id="style-44">

                <?php
                $i = 0;
                foreach ($products as $item) {
                    $i++;
                    $strnhan = $item['HanBH'];
                    $strnhan = str_replace('/Date(', '', $strnhan);
                    $strnhan = str_replace('+0700)/', '', $strnhan);
//		var_dump(date("d-m-Y", ($strnhan / 1000) ));
                    $strtra = $item['NgayXuatKho'];
                    $strtra = str_replace('/Date(', '', $strtra);
                    $strtra = str_replace('+0700)/', '', $strtra);
//        		var_dump(date("d-m-Y", ($strtra / 1000) ));

//                    $arr = explode(',', $item['GhiChu']);
                    ?>
                    <?php if (@$item['GhiChu']) { ?>
                        <div class="item_dh" data-toggle="modal" data-target="#myModal<?php echo $i; ?>">
                            <p>Tên máy: <span><?php echo $item['TenMay'] ?></span></p>
                            <p>Ngày mua: <span><?php echo date("d-m-Y", ($strnhan / 1000)) ?></span></p>
                            <span>Xem chi tiết ></span>
                        </div>
                        <?php if (count($products) > 1) { ?>
                            <img src="<?php echo URL_ROOT . 'modules/products/assets/images/boder_bot.svg' ?>" alt="boder"
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
                                            <p><b>Tên máy</b> : <?php echo $item['TenMay'] ?></p>
                                            <p><b>Imei</b> : <?php echo $item['Imei'] ?></p>
                                            <p><b>Số HD</b> : <?php echo $item['SoHD'] ?></p>
                                            <p><b>Tên khách hàng</b> : <?php echo $item['TenKH'] ?></p>
                                            <p><b>Số điện thoại</b> : <?php echo $item['DiDong'] ?></p>
                                            <p><b>Mua tại</b> :
                                                <?php echo $item['DiaChi'] ?></p>
                                            <!--                                        <p><b>Gói bảo hành</b> : -->
                                            <?php //echo $arr[1] ?><!--</p>-->
                                            <p><b>Gói bảo hành</b> : <?php echo $item['GhiChu'] ?></p>
                                            <p><b>Hạn bảo hành</b> : <?php echo date("d-m-Y", ($strtra / 1000)); ?>
                                            </p>
                                            <p><b>Mã máy</b> : <?php echo $item['MaMay'] ?></p>
                                        </div>
                                        <div class="modal-footer">Cảm ơn quý khách đã mua hàng ở 24hstore</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
                <?php } ?>
            </div>

            <!--            <h3 class="thank">Cảm ơn quý khách đã mua hàng ở 24hstore!</h3>-->
        </div>
    </div>
</div>
