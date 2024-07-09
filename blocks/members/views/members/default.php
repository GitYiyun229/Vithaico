<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/members/assets/css');

?>
<div class="box-fff">
    <div class="level_point_box grid_box">
        <div class="level_box">
            <h3>
                <span>
                    <?php echo FSText::_('Hi, ') ?>
                </span>
                <span>
                    <?php echo $user_member->full_name ?>
                </span>
            </h3>
            <div class="bottom_text">
                <img src="<?php echo URL_ROOT . $group->image ?>" alt="">
                <?php if ($user_member) { ?>
                    <p>
                        <span>
                            <?php echo FSText::_('Bạn cần phát sinh giao dịch để duy trì hạng của mình. Hạng của bạn còn duy trì trong') . ' ' ?>
                        </span>
                        <span class="bold_text">
                            <?php echo $interval->days ?>
                        </span>
                        <span>
                            <?php echo ' ' . FSText::_('ngày') ?>
                        </span>
                    </p>
                <?php } ?>
            </div>
        </div>
    </div>
</div>