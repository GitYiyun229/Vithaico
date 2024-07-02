<?php
global $tmpl, $user, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default', 'blocks/botmenumobile/assets/css');
$tmpl->addScript('default', 'blocks/botmenumobile/assets/js');
//var_dump($list_menu);
?>

<div class="menu_cat">
    <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu']); ?>
</div>
<div class="member_menu">
    <a href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
        <?php echo FSText::_('Tài khoản của tôi') ?>
    </a>
    <a href="<?php echo FSRoute::_("index.php?module=members&view=orders") ?>">
        <?php echo FSText::_('Đơn hàng của tôi') ?>
    </a>
    <a href="<?php echo FSRoute::_("index.php?module=members&view=level") ?>">
        <?php echo FSText::_('Hạng thành viên') ?>
    </a>
    <a href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>">
        <?php echo FSText::_('Đăng xuất') ?>
    </a>
</div>

<ul class="list_menu_mobile">
    <li>
        <a href="<?php echo URL_ROOT ?>">
            <i class="fa-solid fa-house"></i>
            <span>Trang chủ</span>
        </a>
    </li>
    <li>
        <a class="cat_prd" href="javascript:void(0)">
            <i class="fa-solid fa-list"></i>
            <span>Danh mục</span>
        </a>
    </li>
    <li>
        <?php if ($user->userID) { ?>
            <a class="member" href="javascript:void(0)">
                <i class="fa-solid fa-user"></i>
                <?php if ($user->userInfo->full_name) { ?>
                    <span><?php echo $user->userInfo->full_name ?></span>
                <?php } else { ?>
                    <span>Thành viên</span>
                <?php } ?>
            </a>
        <?php } else { ?>
            <a class="btn-login" href="javascript:void(0)">
                <i class="fa-solid fa-user"></i> 
                <span>Thành viên</span>
            </a>
        <?php } ?>



    </li>
</ul>