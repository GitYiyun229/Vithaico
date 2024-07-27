<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/members/assets/css');
if ($interval <= 0) {
    $active_interval = 'active_interval';
} else {
    $active_interval = '';
}
$arow = '<svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2.33203 7H11.6654M11.6654 7L8.16536 3.5M11.6654 7L8.16536 10.5" stroke="#ea212d" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
         </svg>';
?>
<div class="box-fff p-3">
    <div class="level_point_box grid_box">
        <div class="level_box">
            <h3>
                <span>
                    <?php echo FSText::_('Hi, ') ?>
                    <?php echo $user_member->full_name ?>
                    <?php echo FSText::_(' hạng ') ?>
                </span>
                <img src="<?= URL_ROOT . ($rank_hientai->image) ?>" alt="image rank member">
                <?php echo ($level == 1 && $total_member_coin == 0) ? 'tạm thời' : 'Hưởng <span class="hoa_hong">' . FSText::_($rank_hientai->member_benefits . '%/VT-Coin F1') . '</span> phát sinh'; ?>
                <?php if ($total_member_coin < 0) { ?> Phát sinh đơn hàng để duy trì tài khoản 1 năm <?php } ?>
            </h3>
            <div class="bottom_center">
                <div class="text_center">
                    <?php if ($total_member_coin > 100) { ?>
                        <p>
                            Mỗi tháng phát sinh đơn hàng <span class="fw-bold">2.800.000đ</span> để duy trì hạng của mình. Hạng của bạn còn duy trì đến hết ngày
                            <span class="fw-bold">
                                <?= $start_time = date('d-m-Y', strtotime($due_time_month)); ?>
                            </span>
                        </p>
                    <?php } elseif ($total_member_coin > 0 && $total_member_coin < 100) { ?>
                        <p>
                            Bạn cần thêm <?php echo 100 - $total_member_coin ?> VT-Coin để đạt mức rank đại lý .
                        </p>
                    <?php } ?>
                </div>
            </div>
            <div class="bottom_text">
                <div class="text_top_progress">
                    <div>
                        <?php
                        if ($level == 1) {
                            echo "<p>Tích luỹ mua hàng đạt từ <span>" . $condition_1 . "VT-Coin </span> đến <span>" . $condition_2 . "VT-Coin</span> để trở thành<img src='$image' alt='image rank member'>để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 2) {
                            echo "<p>Tích luỹ mua hàng đạt từ <span>$condition_1</span> để trở thành <img src='$image' alt='image rank member'> để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 3 || $level == 4 || $level == 5) {
                            echo "<p>Tuyến được <span>$condition_2</span> đại lý F1 hoặc phát sinh doanh số nhóm đạt mức $condition_3 để trở thành <img src='$image' alt='image rank member'> để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 6) {
                            echo "<p>Bạn đang là <img src='$current_image' alt='image rank member'> hãy nhớ duy trì hạng tài khoản và phí thành viên để nhận thêm hoa hồng nhé!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="box_coin d-flex flex-column align-items-end justify-content-end flex-wrap align-content-end">
            <p>Bạn đang có </p>
            <p class="fw-bold">Coin hoa hồng : <img src="/images/vt-coin.svg" alt=""> <?= $user_member->vt_coin ?> <span class="fw-light">VT-Coin</span></p>
            <p class="fw-bold"><span class="fw-light">Coin F1 : </span> <?= $thong_ke_f1['total_coin_order_F1'] ?> <span class="fw-light">VT-Coin</span></p>
            <p class="fw-bold"><span class="fw-light">Coin của bạn : </span> <?= $thong_ke_f1['total_coin_order'] ?> <span class="fw-light">VT-Coin</span></p>
        </div>
    </div>
    <div class="progress_golfplus grid_box">
        <div class="progress_golfplus ">
            <div class="progress_box">
                <div class="progress_bar">
                    <div class="progress_background"></div>
                    <div class="progress_timeline " style="width:<?php echo $timeline ?>% ">
                        <div class="position-relative progress_timeline_pos">
                            <p class="progress_precent  m-0  position-absolute progress_color_<?= $user_member->level ?>"><?= number_format($timeline , 2) . '%' ?></p>
                        </div>
                    </div>
                    <div class="list_item_progress">
                        <?php foreach ($table_level as $item) { ?>
                            <div class="item_bar ">
                                <?php if ($item->time_update_rank) { ?>
                                    <p class="time-rank m-0  position-absolute"><?= date('d/m/Y', strtotime($item->time_update_rank)) ?></p>

                                <?php } ?>
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="6" cy="6" r="5" fill="#FAB731" stroke="white" stroke-width="2" />
                                </svg>

                            </div>
                        <?php } ?>
                    </div>
                    <div class="list_item_progress mt-2">
                        <?php foreach ($table_level as $item) { ?>
                            <div class="item_bar ">

                                <img src="<?php echo URL_ROOT . $item->icon ?>" alt="">
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php include('time.php') ?>
    </div>
</div>