<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('dashboard', 'modules/members/assets/css');
$tmpl->addStylesheet('introduce', 'modules/members/assets/css');
?>

<div class="container">
    <div class="mb-3">
        <?php include PATH_BASE . 'modules/members/views/level.php' ?>
    </div>
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar p-4 pb-2">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Thống kê danh sách F1') ?></div>
            <div class="page-content page-address p-4 bg-white page-border-radius <?php echo empty($list) ? 'page-address-empty' : '' ?>">
                <div class="user_f1">
                    <div class="user_f1_title d-flex justify-content-between">
                        <div class="user_f1_title_item"><?php echo FSText::_('stt') ?></div>
                        <div class="user_f1_title_item"><?php echo FSText::_('Họ tên') ?></div>
                        <div class="user_f1_title_item"><?php echo FSText::_('Số điện thoại') ?></div>
                        <div class="user_f1_title_item"><?php echo FSText::_('Email') ?></div>
                        <div class="user_f1_title_item"><?php echo FSText::_('Ngày đăng ký') ?></div>
                    </div>
                    <?php if (!empty($list_members)) : ?>
                        <?php $sequenceNumber = 1; ?>
                        <?php foreach ($list_members as $item) : ?>
                            <div class="user_f1_item d-flex justify-content-between">
                                <div class="user_f1_item_item"> <?= $sequenceNumber++; ?></div>
                                <div class="user_f1_item_item"><?= htmlspecialchars($item->user_name) ?></div>
                                <div class="user_f1_item_item"><?= htmlspecialchars($item->telephone) ?></div>
                                <div class="user_f1_item_item"><?= htmlspecialchars($item->email) ?></div>
                                <div class="user_f1_item_item"><?= htmlspecialchars($item->created_time) ?></div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="user_f1_empty"><?= FSText::_('Chưa có ai đăng ký') ?></div>
                    <?php endif; ?> <?php if ($pagination) {
                                        echo $pagination->showPagination(6);
                                    }
                                    ?>
                </div>

            </div>
        </div>
    </div>
</div>