<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('dashboard', 'modules/members/assets/css');
$tmpl->addStylesheet('introduce', 'modules/members/assets/css');
?>

<div class="container">
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar p-4 pb-2">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Thống kê danh sách F1') ?></div>
            <div class="page-content page-address p-4 bg-white page-border-radius <?php echo empty($list) ? 'page-address-empty' : '' ?>">
            </div>
            
        </div>

    </div>
</div>