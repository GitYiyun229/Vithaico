<?php
global $tmpl, $user, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default', 'blocks/botmenumobile/assets/css');
$tmpl->addScript('default', 'blocks/botmenumobile/assets/js');
//var_dump($list_menu);
$userImage = 'images/user-icon.svg';

if ($user->userID) {
    $userImage = $user->userInfo->image ?: 'images/user-customer-icon.svg';
}
?>

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
            <a class="btn-login" href="<?= FSRoute::_('index.php?module=members&view=user&task=login') ?>">
                <i class="fa-solid fa-user"></i>
                <span>Login</span>
            </a>
        <?php } ?>
    </li>
    <div class="menu_cat">
        <?php echo $tmpl->load_direct_blocks('product_categories', array('style' => 'menu_mobi', 'group' => 1)) ?>
    </div>
</ul>
<div class="member_menu">
    <?php if ($user->userID) { ?>
        <div class="user_login_btn user_header_btn d-flex gap-2">
            <?php if ($userImage) { ?>
                <img src="<?php echo URL_ROOT . $userImage ?>" alt="user" class="img-fluid">
            <?php } ?>
            <div>
                <span>
                    <?php
                    $name_parts = explode(' ', $user->userInfo->full_name);
                    $first_name = $name_parts[0]; ?>
                    <?php echo FSText::_('Xin chào,') . ' ' . $first_name ?: '' ?>

                </span> </br>
                <a class="btn-guest-2" href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>">
                    <span>
                        <?php echo FSText::_('Đăng xuất') ?>
                    </span>
                </a>
            </div>
        </div>
        <div class="row-p"></div>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15.1167 18.0167C14.3834 18.2334 13.5167 18.3334 12.5001 18.3334H7.50008C6.48341 18.3334 5.61675 18.2334 4.88342 18.0167M15.1167 18.0167C14.9334 15.85 12.7084 14.1417 10.0001 14.1417C7.29175 14.1417 5.06675 15.85 4.88342 18.0167M15.1167 18.0167C17.3834 17.375 18.3334 15.65 18.3334 12.5V7.50002C18.3334 3.33335 16.6667 1.66669 12.5001 1.66669H7.50008C3.33341 1.66669 1.66675 3.33335 1.66675 7.50002V12.5C1.66675 15.65 2.61675 17.375 4.88342 18.0167M10.0001 11.8083C8.35008 11.8083 7.01675 10.4667 7.01675 8.8167C7.01675 7.1667 8.35008 5.83335 10.0001 5.83335C11.6501 5.83335 12.9834 7.1667 12.9834 8.8167C12.9834 10.4667 11.6501 11.8083 10.0001 11.8083Z" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Thông tin tài khoản') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="18" height="20" viewBox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M5.66667 10.1667H11.5M5.66667 13.5H9.31667M12.3333 3.35002C15.1083 3.50002 16.5 4.52502 16.5 8.33335V13.3334C16.5 16.6667 15.6667 18.3334 11.5 18.3334H6.5C2.33333 18.3334 1.5 16.6667 1.5 13.3334V8.33335C1.5 4.53335 2.89167 3.50002 5.66667 3.35002M7.33333 5.00002H10.6667C12.3333 5.00002 12.3333 4.16669 12.3333 3.33335C12.3333 1.66669 11.5 1.66669 10.6667 1.66669H7.33333C6.5 1.66669 5.66667 1.66669 5.66667 3.33335C5.66667 5.00002 6.5 5.00002 7.33333 5.00002Z" stroke="#757575" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Thống kê danh sách F1') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17.0443 10.744C16.8128 12.919 15.5805 14.9571 13.5413 16.1344C10.1534 18.0904 5.8213 16.9296 3.86529 13.5417L3.65696 13.1808M2.95506 9.25596C3.18656 7.08105 4.41888 5.04294 6.45804 3.86564C9.84595 1.90963 14.178 3.07041 16.1341 6.45832L16.3424 6.81916M2.91089 15.055L3.52093 12.7783L5.79764 13.3883M14.2018 6.61167L16.4785 7.22171L17.0885 4.945M9.99971 6.24998V9.99998L12.083 11.25" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Lịch sử giao dịch') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12.55 15.1583C15.15 15.4083 16.5334 14.1917 17.2334 11.1833L18.05 7.69999C18.8667 4.21665 17.8 2.49165 14.3084 1.67499L12.9167 1.34999C10.1334 0.691653 8.47504 1.23332 7.50004 3.24999M12.55 15.1583C12.1334 15.125 11.6834 15.05 11.2 14.9333L9.80004 14.6C6.32504 13.775 5.25004 12.0583 6.06671 8.57499L6.88337 5.08332C7.05004 4.37499 7.25004 3.75832 7.50004 3.24999M12.55 15.1583C12.0334 15.5083 11.3834 15.8 10.5917 16.0583L9.27504 16.4917C5.96671 17.5583 4.22504 16.6667 3.15004 13.3583L2.08337 10.0667C1.01671 6.75832 1.90004 5.00832 5.20837 3.94165L6.52504 3.50832C6.86671 3.39999 7.19171 3.30832 7.50004 3.24999M10.5334 6.10832L14.575 7.13332M9.71671 9.33332L12.1334 9.94999" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Thống kê đơn hàng F1') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.95974 14.0503V15.742C8.95974 17.1753 7.6264 18.3337 5.98473 18.3337C4.34306 18.3337 3.00138 17.1753 3.00138 15.742V14.0503M8.95974 14.0503C8.95974 15.4753 7.6264 16.5003 5.98473 16.5003M8.95974 14.0503V11.7583C8.95974 11.0417 8.62642 10.3917 8.09309 9.925C7.55142 9.45833 6.80973 9.16669 5.98473 9.16669C4.33473 9.16669 3.00138 10.325 3.00138 11.7583V14.0503M8.95974 14.0503C8.95974 15.4836 7.6264 16.5003 5.98473 16.5003M3.00138 14.0503C3.00138 15.4836 4.33473 16.5003 5.98473 16.5003M3.00138 14.0503C3.00138 15.4753 4.34306 16.5003 5.98473 16.5003M17.5001 11.7083C17.9668 11.6917 18.3334 11.3167 18.3334 10.8584V9.14166C18.3334 8.68333 17.9668 8.30836 17.5001 8.2917M17.5001 11.7083H15.8668C14.9668 11.7083 14.1418 11.05 14.0668 10.15C14.0168 9.62501 14.2168 9.13334 14.5668 8.79168C14.8751 8.47501 15.3001 8.2917 15.7668 8.2917H17.5001M17.5001 11.7083L17.5001 12.9167C17.5001 15.4167 15.8334 17.0834 13.3334 17.0834H11.2501M17.5001 8.2917L17.5001 7.08335C17.5001 4.80002 16.1084 3.20834 13.9584 2.95834C13.7584 2.92501 13.5501 2.91669 13.3334 2.91669H5.83341C5.60008 2.91669 5.37508 2.93335 5.15842 2.96668C3.03342 3.23335 1.66675 4.81669 1.66675 7.08335V8.75002M8.95842 11.7583C8.95842 12.175 8.84174 12.5583 8.64174 12.8917C8.15008 13.7 7.14173 14.2083 5.97507 14.2083C4.8084 14.2083 3.80006 13.6917 3.30839 12.8917C3.10839 12.5583 2.99177 12.175 2.99177 11.7583C2.99177 11.0417 3.32509 10.4 3.85842 9.93334C4.40009 9.45834 5.14173 9.17503 5.96673 9.17503C6.79173 9.17503 7.53342 9.46667 8.07508 9.93334C8.62508 10.3917 8.95842 11.0417 8.95842 11.7583Z" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Thống kê hoa hồng') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7.91675 11.4584C7.91675 12.2667 8.54176 12.9167 9.30843 12.9167H10.8751C11.5417 12.9167 12.0834 12.35 12.0834 11.6417C12.0834 10.8834 11.7501 10.6084 11.2584 10.4334L8.75008 9.55836C8.25842 9.38336 7.92509 9.11669 7.92509 8.35002C7.92509 7.65002 8.46674 7.07503 9.13341 7.07503H10.7001C11.4667 7.07503 12.0918 7.72503 12.0918 8.53336M10.0001 6.25002V13.75M18.3334 10C18.3334 14.6 14.6001 18.3334 10.0001 18.3334C5.40008 18.3334 1.66675 14.6 1.66675 10C1.66675 5.40002 5.40008 1.66669 10.0001 1.66669M18.3334 5.00002V1.66669M18.3334 1.66669H15.0001M18.3334 1.66669L14.1667 5.83335" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Chi trả hoa hồng') ?>
            </span>
        </a>
        <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M6.41658 5.30001C6.67492 2.30001 8.21658 1.07501 11.5916 1.07501H11.6999C15.4249 1.07501 16.9166 2.56668 16.9166 6.29168V11.725C16.9166 15.45 15.4249 16.9417 11.6999 16.9417H11.5916C8.24158 16.9417 6.69992 15.7333 6.42492 12.7833M11.4999 9.00001H2.01659M3.87492 6.20835L1.08325 9.00001L3.87492 11.7917" stroke="#757575" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <span>
                <?php echo FSText::_('Đăng xuất') ?>
            </span>
        </a>
    <?php } ?>
</div>