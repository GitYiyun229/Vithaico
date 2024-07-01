<?php
global $tmpl, $config, $user;
$tmpl->addStylesheet('sidebar', 'blocks/sidebar/assets/css');
$url_current = $_SERVER['REQUEST_URI'];
$url_current = substr(URL_ROOT, 0, strlen(URL_ROOT) - 1) . $url_current;

$sidebar = [
    [
        'name' => FSText::_('Tài khoản của tôi'),
        'image' => '/images/user-member-header.svg',
        'link' =>  FSRoute::_('index.php?module=members&view=dashboard'),
    ],
    [
        'name' => FSText::_('Đơn hàng của tôi'),
        'image' => '/images/order-member-header.svg',
        'link' =>  FSRoute::_('index.php?module=members&view=orders'),
    ],
    [
        'name' => FSText::_('Địa chỉ giao hàng'),
        'image' => '/images/address-member-header.svg',
        'link' =>  FSRoute::_(''),
    ],
    [
        'name' => FSText::_('Sản phẩm yêu thích'),
        'image' => '/images/favourite-member-header.svg',
        'link' =>  FSRoute::_('index.php?module=members&view=favorite'),
    ],
    [
        'name' => FSText::_('Đăng xuất'),
        'image' => '/images/logout-member-header.svg',
        'link' =>  FSRoute::_('index.php?module=members&view=log&task=logout'),
    ],

];
?>
<div class="dropdown_members">
    <button class="dropdown-toggle  fw-bold button-member d-flex align-items-center " type="button" id="box_user" data-bs-toggle="dropdown" aria-expanded="false">
        <?= FSText::_('Tài khoản') ?>
    </button>
    <ul class="dropdown-menu" aria-labelledby="box_user">
        <?php foreach ($sidebar as $item) : ?>
            <li class="mb-2">
                <a class="dropdown-item d-flex gap-2" href="<?= $item['link'] ?>">
                    <img src="<?= $item['image'] ?>" alt="">
                    <p><?= $item['name'] ?></p>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>