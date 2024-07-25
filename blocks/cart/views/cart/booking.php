<?php
global $tmpl, $user;
$tmpl->addStylesheet('booking', 'blocks/cart/assets/css');
?>
<div class="discount_box">
    <div class="title_discount">
        <p class="text_bold">
            <?php echo FSText::_('Mã giảm giá') ?>
        </p>
        <?php if (!$user->userID) { ?>
            <a class="login_discount btn-login">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.66634 5.33335V4.66669M6.66634 8.33335V7.66669M6.66634 11.3334V10.6667M3.46634 2.66669H12.533C13.2797 2.66669 13.6531 2.66669 13.9383 2.81201C14.1892 2.93984 14.3932 3.14382 14.521 3.3947C14.6663 3.67992 14.6663 4.05328 14.6663 4.80002V5.66669C13.3777 5.66669 12.333 6.71136 12.333 8.00002C12.333 9.28868 13.3777 10.3334 14.6663 10.3334V11.2C14.6663 11.9468 14.6663 12.3201 14.521 12.6053C14.3932 12.8562 14.1892 13.0602 13.9383 13.188C13.6531 13.3334 13.2797 13.3334 12.533 13.3334H3.46634C2.7196 13.3334 2.34624 13.3334 2.06102 13.188C1.81014 13.0602 1.60616 12.8562 1.47833 12.6053C1.33301 12.3201 1.33301 11.9468 1.33301 11.2V10.3334C2.62167 10.3334 3.66634 9.28868 3.66634 8.00002C3.66634 6.71136 2.62167 5.66669 1.33301 5.66669V4.80002C1.33301 4.05328 1.33301 3.67992 1.47833 3.3947C1.60616 3.14382 1.81014 2.93984 2.06102 2.81201C2.34624 2.66669 2.7196 2.66669 3.46634 2.66669Z" stroke="#1CAF47" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <?php echo FSText::_('Đăng nhập để xem thêm') ?>
            </a>
        <?php } else { ?>
            <div></div>
        <?php } ?>
    </div>
    <div class="input_btn_discount">
        <div class="input_discount">
            <?php
            $html = '';
            $html .= '
                <input readonly type="text" id="discount_code" name="discount_code" value="" placeholder="' . FSText::_('Nhập mã giảm giá') . ' " />
            
            ';
            echo $html;
            ?>
            <p class="label_error">

            </p>
        </div>
        <a class="btn_apply_discount">
            <?php echo FSText::_('Áp dụng') ?>
        </a>
    </div>
    <div class="list_discount_box">
        <?php foreach ($list_discount_all as $item) { ?>
            <?php echo $tmpl->discountItem($item) ?>
        <?php } ?>
    </div>
</div>

<?php if ($user->userID) { ?>
    <div class="level_point_member">
        <div class="line_level_point">
            <p>
                <?php echo FSText::_('Hạng thành viên') ?>
            </p>
            <p>
                <img src="<?php echo URL_ROOT . $level_member->image ?>" alt="">
            </p>
        </div>
        <?php if ($user->userInfo->g_point > 0) { ?>
            <div class="line_level_point">
                <p>
                    <?php echo FSText::_('G-Point') ?>
                    <label class="switch">
                        <input type="checkbox" id="mySwitch" value="<?php echo $user->userInfo->g_point ?>">
                        <span class="slider round"></span>
                    </label>
                </p>
                <p>
                    <?php echo formatNumber($user->userInfo->g_point) . ' ' . FSText::_('G-Point') ?>
                </p>
            </div>
        <?php } ?>
    </div>
<?php } ?>