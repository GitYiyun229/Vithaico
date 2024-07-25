<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('order_f1', 'modules/members/assets/css');
$tmpl->addScript('order_f1', 'modules/members/assets/js');
?>
<div class="container">
    <div class="mb-3">
        <?php include PATH_BASE . 'modules/members/views/level.php' ?>
    </div>
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar  p-4 pb-2">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side p-4 bg-white">
            <div class="page-title mb-3 fs-5 fw-bold text-uppercase"><?php echo FSText::_('Thống kê đơn hàng f1') ?></div>
            <div class="page-content page-orders">
                <div class="user_f1_title d-flex justify-content-between">
                    <div class="user_f1_title_item"><?php echo FSText::_('stt') ?></div>
                    <div class="user_f1_title_item"><?php echo FSText::_('Mã đơn hàng') ?></div>
                    <div class="user_f1_title_item"><?php echo FSText::_('Tên Thành viên') ?></div>
                    <div class="user_f1_title_item"><?php echo FSText::_('Điện thoại') ?></div>
                    <!-- <div class="user_f1_title_item"></?php echo FSText::_('email') ?></div> -->
                    <div class="user_f1_title_item"><?php echo FSText::_('Trạng thái') ?></div>
                    <div class="user_f1_title_item"><?php echo FSText::_('VT-coin') ?></div>
                    <div class="user_f1_title_item"><?php echo FSText::_('Chi tiết') ?></div>
                </div>
                <?php $sequenceNumber = 1; ?>
                <?php foreach ($list as $item) { ?>
                    <div class="item-order mb-3" status="<?php echo $item->status ?>">
                        <div class="user_f1_item d-flex justify-content-between">
                            <div class="user_f1_item_item"> <?= $sequenceNumber++; ?></div>
                            <div class="user_f1_item_item"><?= htmlspecialchars($item->id) ?></div>
                            <div class="user_f1_item_item"><?= htmlspecialchars($item->recipients_name) ?></div>
                            <div class="user_f1_item_item"><?= htmlspecialchars($item->recipients_telephone) ?></div>
                            <!-- <div class="user_f1_item_item"></.?= htmlspecialchars($item->email) ?></div> -->
                            <div class="user_f1_item_item"><?php echo $this->status[$item->status] ?></div>
                            <div class="user_f1_item_item"><?= htmlspecialchars($item->member_coin) ?></div>
                            <div class="user_f1_item_item">
                                <a href="<?php echo FSRoute::_("index.php?module=members&view=ordersf1&task=detail&id=$item->id") ?>">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.3866 8.00047C10.3866 9.32047 9.3199 10.3871 7.9999 10.3871C6.6799 10.3871 5.61323 9.32047 5.61323 8.00047C5.61323 6.68047 6.6799 5.6138 7.9999 5.6138C9.3199 5.6138 10.3866 6.68047 10.3866 8.00047Z" stroke="#2476FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M7.9999 13.5138C10.3532 13.5138 12.5466 12.1271 14.0732 9.72714C14.6732 8.78714 14.6732 7.20714 14.0732 6.26714C12.5466 3.86714 10.3532 2.48047 7.9999 2.48047C5.64656 2.48047 3.45323 3.86714 1.92656 6.26714C1.32656 7.20714 1.32656 8.78714 1.92656 9.72714C3.45323 12.1271 5.64656 13.5138 7.9999 13.5138Z" stroke="#2476FF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Xem
                                </a>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                 <?php if ($pagination) {
                    echo $pagination->showPagination(6);
                }?>
            </div>
        </div>
    </div>
</div>