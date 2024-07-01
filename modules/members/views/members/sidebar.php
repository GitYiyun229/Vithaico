<?php
$task = FSInput::get('task');
// $tmpl->addScript('scroll', 'modules/members/assets/js');
?>

<div class="d-flex align-items-center gap-2 mb-3 user-name-sidebar">
    <img src="<?php echo URL_ROOT . $this->userImage ?>" alt="user" class="img-fluid">
    <div>
        <div class="text-grey"><?php echo FSText::_('Tài khoản của') ?></div>
        <div class="fw-semibold"><?php echo $user->userInfo->full_name ?></div>
    </div>
</div>



<div class="user-menu-sidebar mb-3 pb-3">
    <a href="<?php echo FSRoute::_('index.php?module=members&view=members') ?>" class="<?php echo !$task  ? 'active' : '' ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.1585 18.3333C17.1585 15.1083 13.9501 12.5 10.0001 12.5C6.05013 12.5 2.8418 15.1083 2.8418 18.3333M14.1668 5.83332C14.1668 8.13451 12.3013 9.99999 10.0001 9.99999C7.69894 9.99999 5.83346 8.13451 5.83346 5.83332C5.83346 3.53214 7.69894 1.66666 10.0001 1.66666C12.3013 1.66666 14.1668 3.53214 14.1668 5.83332Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Tài khoản của tôi
    </a>
    <a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=orders') ?>" class="<?php echo $task == 'orders'  ? 'active' : '' ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M6.66667 10.1667H12.5M6.66667 13.5H10.3167M13.3333 3.34999C16.1083 3.49999 17.5 4.52499 17.5 8.33332V13.3333C17.5 16.6667 16.6667 18.3333 12.5 18.3333H7.5C3.33333 18.3333 2.5 16.6667 2.5 13.3333V8.33332C2.5 4.53332 3.89167 3.49999 6.66667 3.34999M8.33333 4.99999H11.6667C13.3333 4.99999 13.3333 4.16666 13.3333 3.33332C13.3333 1.66666 12.5 1.66666 11.6667 1.66666H8.33333C7.5 1.66666 6.66667 1.66666 6.66667 3.33332C6.66667 4.99999 7.5 4.99999 8.33333 4.99999Z" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Đơn hàng của tôi
    </a>
    <a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=level') ?>" class="<?php echo $task == 'level'  ? 'active' : '' ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M11.4421 2.92501L12.9087 5.85835C13.1087 6.26668 13.6421 6.65835 14.0921 6.73335L16.7504 7.17501C18.4504 7.45835 18.8504 8.69168 17.6254 9.90835L15.5587 11.975C15.2087 12.325 15.0171 13 15.1254 13.4833L15.7171 16.0417C16.1837 18.0667 15.1087 18.85 13.3171 17.7917L10.8254 16.3167C10.3754 16.05 9.63375 16.05 9.17541 16.3167L6.68375 17.7917C4.90041 18.85 3.81708 18.0583 4.28375 16.0417L4.87541 13.4833C4.98375 13 4.79208 12.325 4.44208 11.975L2.37541 9.90835C1.15875 8.69168 1.55041 7.45835 3.25041 7.17501L5.90875 6.73335C6.35041 6.65835 6.88375 6.26668 7.08375 5.85835L8.55041 2.92501C9.35041 1.33335 10.6504 1.33335 11.4421 2.92501Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Hạng thành viên
    </a>
    <a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=address') ?>" class="<?php echo $task == 'address'  ? 'active' : '' ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.0001 11.1917C11.436 11.1917 12.6001 10.0276 12.6001 8.59166C12.6001 7.15572 11.436 5.99166 10.0001 5.99166C8.56414 5.99166 7.40008 7.15572 7.40008 8.59166C7.40008 10.0276 8.56414 11.1917 10.0001 11.1917Z" stroke="currentColor" stroke-width="1.5"/><path d="M3.01675 7.07499C4.65842 -0.141675 15.3501 -0.133341 16.9834 7.08333C17.9417 11.3167 15.3084 14.9 13.0001 17.1167C11.3251 18.7333 8.67508 18.7333 6.99175 17.1167C4.69175 14.9 2.05842 11.3083 3.01675 7.07499Z" stroke="currentColor" stroke-width="1.5"/></svg>
        Sổ địa chỉ
    </a>
    <a href="<?php echo FSRoute::_('index.php?module=members&view=members&task=favorite') ?>" class="<?php echo $task == 'favorite'  ? 'active' : '' ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.517 17.3417C10.2337 17.4417 9.76699 17.4417 9.48366 17.3417C7.06699 16.5167 1.66699 13.075 1.66699 7.24168C1.66699 4.66668 3.74199 2.58334 6.30033 2.58334C7.81699 2.58334 9.15866 3.31668 10.0003 4.45001C10.842 3.31668 12.192 2.58334 13.7003 2.58334C16.2587 2.58334 18.3337 4.66668 18.3337 7.24168C18.3337 13.075 12.9337 16.5167 10.517 17.3417Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Sản phẩm yêu thích
    </a>
    <a href="<?php echo FSRoute::_('index.php?module=members&view=log&task=logout') ?>">
        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.41634 6.30001C7.67467 3.30001 9.21634 2.07501 12.5913 2.07501H12.6997C16.4247 2.07501 17.9163 3.56668 17.9163 7.29168V12.725C17.9163 16.45 16.4247 17.9417 12.6997 17.9417H12.5913C9.24134 17.9417 7.69967 16.7333 7.42467 13.7833M12.4997 10H3.01634M4.87467 7.20835L2.08301 10L4.87467 12.7917" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
        Đăng xuất
    </a>
</div>

<div>
    <div class="text-grey fw-semibold"><?= FSText::_('Bạn cần hỗ trợ?')?></div>
    <div><span class="text-grey"><?= FSText::_('Vui lòng gọi')?></span> <a href="tel:<?php echo $config['hotline'] ?>"><b><?php echo $config['hotline'] ?></b></a></div>
    <div class="text-grey"><?= FSText::_('(miễn phí cước gọi)')?></div>
</div>