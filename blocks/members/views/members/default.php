<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/members/assets/css');
$benefits = $dieukien_lenrank->member_benefits - $rank_hientai->member_benefits . '%';
$image = URL_ROOT . ($dieukien_lenrank->image);
$condition_1 = $dieukien_lenrank->condition_1;
$condition_2 = $dieukien_lenrank->condition_2;
$condition_3 = format_money($dieukien_lenrank->condition_3, 'đ');
$current_image = URL_ROOT . ($rank_hientai->image);
print_r($timeline);
?>
<div class="box-fff p-3">
    <div class="level_point_box grid_box">
        <div class="level_box">
            <h3>
                <span>
                    <?php echo FSText::_('Hi, ') ?>
                    <?php echo $user_member->full_name ?>
                </span>
                <img src="<?= URL_ROOT . ($rank_hientai->image) ?>" alt="image rank member">
                <?php echo ($level == 1 && $total_member_coin == 0) ? 'tạm thời' : 'Hưởng <span class="hoa_hong">' . FSText::_($rank_hientai->member_benefits . '%/VT-Coin F1') . '</span> phát sinh'; ?>
            </h3>

            <div class="bottom_text">
                <div class="text_top_progress">
                    <div>
                        <?php
                        if ($level == 1 ) {
                            echo "<p>Tích luỹ mua hàng đạt từ <span>" . $condition_1 . "VT-Coin </span> đến <span>" . $condition_2 . "VT-Coin</span> để trở thành<img src='$image' alt='image rank member'>để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 2) {
                            echo "<p>Tích luỹ mua hàng đạt từ <span>$condition_1</span> để trở thành <img src='$image' alt='image rank member'> để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 3 || $level == 4|| $level == 5) {
                            echo "<p>Tuyến được <span>$condition_2</span> đại lý F1 hoặc phát sinh doanh số nhóm đạt mức $condition_3 để trở thành <img src='$image' alt='image rank member'> để nhận thêm <span>$benefits</span> VT-Coin F1 phát sinh</p>";
                        } elseif ($level == 6) {
                            echo "<p>Bạn đang là <img src='$current_image' alt='image rank member'> hãy nhớ duy trì hạng tài khoản và phí thành viên để nhận thêm hoa hồng nhé!</p>";
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="progress_golfplus ">
                <div class="progress_box">
                    <div class="progress_bar">
                        <div class="progress_background"></div>
                        <div class="progress_timeline" style="width:<?php echo $timeline ?>% "></div>
                        <div class="list_item_progress">
                            <?php foreach ($table_level as $item) { ?>
                                <div class="item_bar">
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="6" cy="6" r="5" fill="#006798" stroke="white" stroke-width="2" />
                                    </svg>
                                    <img src="<?php echo $item->icon ?>" alt="">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>