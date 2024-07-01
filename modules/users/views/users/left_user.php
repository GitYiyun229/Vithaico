<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 5/18/2021
 * Time: 2:25 PM
 */
global $tmpl;
$tmpl->addStylesheet("left_user", "modules/users/assets/css");
$task = FSInput::get('task');
$class = "";
//if ($task == 'accumulation'){
//    $class = 'active';
//}
?>
<div class="name_user">
    <img src="<?php echo URL_ROOT . 'templates/default/images/Asset 3.png' ?>" alt="thành viên">
    <p>
        Chào bạn <span><?php echo $_SESSION['full_name']; ?></span>
    </p>
</div>
<div class="list_menu1">
    <?php if ($task == 'logged') {?>
<!--        <a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=eshopcart2') ?><!--"-->
<!--           class="cart --><?php //echo $class ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'modules/users/assets/images/cart.svg' ?><!--" alt="Giỏ hàng">-->
<!--            <span>Giỏ hàng</span></a>-->
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=management') ?>"
           class="order <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/qldh.svg' ?>" alt="Quản lý đơn hàng">
            <span>Quản lý đơn hàng</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=accumulation') ?>"
           class="accumulation <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/tichluy.svg' ?>" alt="Chi tiêu tích lũy">
            <span>Chi tiêu tích lũy</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=warranty') ?>"
           class="guarantee <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/bh.svg' ?>" alt="Tra cứu bảo hành">
            <span>Tra cứu bảo hành</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=repair') ?>"
           class="setting <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/suachua.svg' ?>" alt="Tra cứu sửa chữa">
            <span>Tra cứu sửa chữa</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>"
           class="logout <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/logout.svg' ?>" alt="Đăng xuất">
            <span>Đăng xuất</span></a>
    <?php }?>

    <?php if ($task == 'management') { ?>
<!--        <a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=eshopcart2') ?><!--"-->
<!--           class="cart --><?php //echo $class ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'modules/users/assets/images/cart.svg' ?><!--" alt="Giỏ hàng">-->
<!--            <span>Giỏ hàng</span></a>-->
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=management') ?>"
           class="order <?php echo $class ?> active">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/qldh_a.svg' ?>" alt="Quản lý đơn hàng">
            <span>Quản lý đơn hàng</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=accumulation') ?>"
           class="accumulation <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/tichluy.svg' ?>" alt="Chi tiêu tích lũy">
            <span>Chi tiêu tích lũy</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=warranty') ?>"
           class="guarantee <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/bh.svg' ?>" alt="Tra cứu bảo hành">
            <span>Tra cứu bảo hành</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=repair') ?>"
           class="setting <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/suachua.svg' ?>" alt="Tra cứu sửa chữa">
            <span>Tra cứu sửa chữa</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>"
           class="logout <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/logout.svg' ?>" alt="Đăng xuất">
            <span>Đăng xuất</span></a>
    <?php } ?>
    <?php if ($task == 'accumulation') { ?>
<!--        <a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=eshopcart2') ?><!--"-->
<!--           class="cart --><?php //echo $class ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'modules/users/assets/images/cart.svg' ?><!--" alt="Giỏ hàng">-->
<!--            <span>Giỏ hàng</span></a>-->
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=management') ?>"
           class="order <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/qldh.svg' ?>" alt="Quản lý đơn hàng">
            <span>Quản lý đơn hàng</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=accumulation') ?>"
           class="accumulation <?php echo $class ?> active">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/tichluy_a.svg' ?>" alt="Chi tiêu tích lũy">
            <span>Chi tiêu tích lũy</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=warranty') ?>"
           class="guarantee <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/bh.svg' ?>" alt="Tra cứu bảo hành">
            <span>Tra cứu bảo hành</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=repair') ?>"
           class="setting <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/suachua.svg' ?>" alt="Tra cứu sửa chữa">
            <span>Tra cứu sửa chữa</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>"
           class="logout <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/logout.svg' ?>" alt="Đăng xuất">
            <span>Đăng xuất</span></a>
    <?php } ?>
    <?php if ($task == 'warranty') { ?>
<!--        <a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=eshopcart2') ?><!--"-->
<!--           class="cart --><?php //echo $class ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'modules/users/assets/images/cart.svg' ?><!--" alt="Giỏ hàng">-->
<!--            <span>Giỏ hàng</span></a>-->
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=management') ?>"
           class="order <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/qldh.svg' ?>" alt="Quản lý đơn hàng">
            <span>Quản lý đơn hàng</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=accumulation') ?>"
           class="accumulation <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/tichluy.svg' ?>" alt="Chi tiêu tích lũy">
            <span>Chi tiêu tích lũy</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=warranty') ?>"
           class="guarantee <?php echo $class ?> active">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/bh_a.svg' ?>" alt="Tra cứu bảo hành">
            <span>Tra cứu bảo hành</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=repair') ?>"
           class="setting <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/suachua.svg' ?>" alt="Tra cứu sửa chữa">
            <span>Tra cứu sửa chữa</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>"
           class="logout <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/logout.svg' ?>" alt="Đăng xuất">
            <span>Đăng xuất</span></a>
    <?php } ?>
    <?php if ($task == 'repair') { ?>
<!--        <a href="--><?php //echo FSRoute::_('index.php?module=products&view=cart&task=eshopcart2') ?><!--"-->
<!--           class="cart --><?php //echo $class ?><!--">-->
<!--            <img src="--><?php //echo URL_ROOT . 'modules/users/assets/images/cart.svg' ?><!--" alt="Giỏ hàng">-->
<!--            <span>Giỏ hàng</span></a>-->
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=management') ?>"
           class="order <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/qldh.svg' ?>" alt="Quản lý đơn hàng">
            <span>Quản lý đơn hàng</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=accumulation') ?>"
           class="accumulation <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/tichluy.svg' ?>" alt="Chi tiêu tích lũy">
            <span>Chi tiêu tích lũy</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=warranty') ?>"
           class="guarantee <?php echo $class ?> ">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/bh.svg' ?>" alt="Tra cứu bảo hành">
            <span>Tra cứu bảo hành</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=repair') ?>"
           class="setting <?php echo $class ?> active">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/suachua_a.svg' ?>" alt="Tra cứu sửa chữa">
            <span>Tra cứu sửa chữa</span></a>
        <a href="<?php echo FSRoute::_('index.php?module=users&view=users&task=logout'); ?>"
           class="logout <?php echo $class ?>">
            <img src="<?php echo URL_ROOT . 'modules/users/assets/images/logout.svg' ?>" alt="Đăng xuất">
            <span>Đăng xuất</span></a>
    <?php } ?>
</div>
