<?php
global $tmpl;
$tmpl->setTitle("Chi tiêu tích lũy");
$tmpl->addStylesheet("accumulation", "modules/users/assets/css");
//var_dump($_SESSION);
?>
<div class="frame_body row">
    <div class='col-lg-3'>
        <?php include_once 'left_user.php' ?>
    </div>
    <div class='col-lg-9'>
        <div class="chitieu">
            <h1>Chi tiêu tích lũy</h1>
<!--            <div class="info_tichluy">-->
                <?php
                //            if (!@$products['mobile']) { ?>
                <!--                <h3 class="title_user" style="text-align: center;text-transform: uppercase;">Bạn chưa là thành viên</h3>-->
                <!--            --><?php //} elseif (@$products['mobile']) {
                $gif = trim($products['extraData'], ';');
                $gif_arr = explode(';', $gif);
                ?>

                <div class="item">
                    <p class="name_user"><b>Họ và tên</b> : <?php echo $products['name'] ?></p>
                    <p class="phone_user"><b>Số điện thoại</b> : <?php echo $products['mobile'] ?></p>
                    <p class="total_user"><b>Tổng số tiền đã mua</b>
                        : <?php echo format_money($products['totalAmount']) ?></p>
                    <p class="memberCard"><b>Hạng thẻ</b> : 24hStore <?php echo $products['memberCard'] ?></p>
                    <p class="gif_user"><b>Ưu đãi của bạn</b> :</p>
                    <div class="list_gif">
                        <ul>
                            <?php
                            foreach ($gif_arr as $key) {
                                $key_arr = explode(':', $key);
                                ?>
                                <li>
                                    <?php
                                    $i = 0;
                                    foreach ($key_arr as $v) {
                                        ?>
                                        <span class=" <?php if ($i != 0) {
                                            echo 'weigt';
                                        } ?>"><?php echo $v ?><?php if ($i == 0) {
                                                echo ' : ';
                                            } ?></span>
                                        <?php $i++;
                                    } ?>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>
                    <div class="note_ text-center">
                        <span><?php echo $data->summary; ?></span>
                    </div>
                </div>
                <!--            --><?php //} ?>
            </div>
        </div>
<!--    </div>-->
</div>

        