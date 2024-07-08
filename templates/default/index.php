<?php
global $config, $tmpl, $module, $user;
$tmpl->addStylesheet('register', 'modules/members/assets/css');
$Itemid = FSInput::get('Itemid', 1, 'int');
$totalCart = 0;
if (!empty($_SESSION['cart'])) {
    $totalCart = count($_SESSION['cart']);
}
if (!$user->userID) {
    $tmpl->addScript('no-user');
}

$userImage = 'images/user-icon.svg';

if ($user->userID) {
    $userImage = $user->userInfo->image ?: 'images/user-customer-icon.svg';
}
$total_money_cart = 0;
$cart = new FSControllers();
$cartList = $cart->calculateCartPrice();
$alert = array(
    0 => FSText::_('Bạn chưa nhập họ và tên'),
    1 => FSText::_('Bạn chưa nhập mật khẩu'),
    2 => FSText::_('Bạn chưa nhập email'),
    3 => FSText::_('Email không đúng định dạng'),
    4 => FSText::_('Nhập mật khẩu của bạn'),
    5 => FSText::_('Nhập lại mật khẩu của bạn'),
    6 => FSText::_('Mật khẩu chưa đúng, vui lòng nhập lại'),
    8 => FSText::_('Mật khẩu có ít nhất 8 ký tự'),
    9 => FSText::_('Bạn chưa nhập phone'),
    10 => FSText::_('Phone không đúng định dạng'),
    11 => FSText::_('Vui lòng đồng ý điều khoản để đăng ký thành viên'),
);


?>

<?php if ($Itemid == 50) { ?>
    <?php include_once './indexAmp.php'; ?>
<?php } else { ?>
    <div id="app">
        <input type="hidden" id="alert_member" value='<?php echo json_encode($alert) ?>' />
        <header class="bg-white">
            <div class="container header-container d-flex align-items-center justify-content-between">
                <button class="btn-menu_mobile" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 12H21M3 6H21M3 18H15" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <a href="<?php echo URL_ROOT ?>" title="<?php echo $config['site_name'] ?>">
                    <img src="<?php echo URL_ROOT . $config['logo'] ?>" width="100" height="48.5" alt="<?php echo $config['site_name'] ?>" class="img-fluid img-logo">
                </a>
                <div class="menu-header">
                    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'home', 'group' => 1)) ?>
                </div>
                <div class="block-members_cart_lang d-flex align-items-center gap-3 position-relative">
                    <div class="search_header">
                        <a href="" class="btn-guest btn-search">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M21 21L17.5001 17.5M20 11.5C20 16.1944 16.1944 20 11.5 20C6.80558 20 3 16.1944 3 11.5C3 6.80558 6.80558 3 11.5 3C16.1944 3 20 6.80558 20 11.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>
                    <div class="cart_header d-flex align-items-center justify-content-end">
                        <a href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>" title="<?php echo FSText::_('Giỏ hàng') ?>" class="header-cart position-relative">
                            <div class="cart-session d-grid position-relative">
                                <div class="cart-session-left">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.0004 9V6C16.0004 3.79086 14.2095 2 12.0004 2C9.79123 2 8.00037 3.79086 8.00037 6V9M3.59237 10.352L2.99237 16.752C2.82178 18.5717 2.73648 19.4815 3.03842 20.1843C3.30367 20.8016 3.76849 21.3121 4.35839 21.6338C5.0299 22 5.94374 22 7.77142 22H16.2293C18.057 22 18.9708 22 19.6423 21.6338C20.2322 21.3121 20.6971 20.8016 20.9623 20.1843C21.2643 19.4815 21.179 18.5717 21.0084 16.752L20.4084 10.352C20.2643 8.81535 20.1923 8.04704 19.8467 7.46616C19.5424 6.95458 19.0927 6.54511 18.555 6.28984C17.9444 6 17.1727 6 15.6293 6L8.37142 6C6.82806 6 6.05638 6 5.44579 6.28984C4.90803 6.54511 4.45838 6.95458 4.15403 7.46616C3.80846 8.04704 3.73643 8.81534 3.59237 10.352Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="cart-session-right position-absolute">
                                    <div class="cart-quantity cart-text-quantity  d-flex align-items-center justify-content-center fw-bold"><?php echo $totalCart ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="cart-hover">
                            <div class="cart-hover-header d-flex flex-wrap align-items-center justify-content-between">
                                <h3 class="title_cart ">
                                    <?php echo FSText::_('Giỏ hàng') ?>
                                </h3>
                                <p class="quantity_cart">
                                    <?php if (!empty($cartList)) { ?>
                                        <span><?= count($cartList) . ' ' ?></span> <?= FSText::_('sản phẩm') ?>
                                    <?php } ?>
                                </p>
                            </div>

                            <div class="cart-hover-body">
                                <?php if (!empty($cartList)) { ?>
                                    <?php foreach ($cartList as $item) {
                                        $total_money_cart +=  $total_money_cart + ($item['price'] * $item['quantity']);
                                    ?>
                                        <div class="cart-hover-item position-relative">
                                            <a href="<?php echo $item['url'] ?>" class=""><img src="<?php echo $item['image'] ?>" alt="<?php echo $item['product_name'] ?>" class="img-fluid"></a>
                                            <div>
                                                <a href="<?php echo $item['url'] ?>">
                                                    <div class="mb-1"><?php echo $item['product_name'] ?></div>
                                                    <div class="sub-name"><?php echo @$item['sub_name'] ?></div>
                                                    <div class="item-price d-flex flex-wrap align-items-center justify-content-between">
                                                        <p><?php echo format_money($item['price']) ?>
                                                            <span class="span-price-origin"><?php echo format_money($item['price_old']) ?></span>
                                                        </p>
                                                        <p><?php echo 'x ' . ($item['quantity']) ?></p>
                                                    </div>
                                                </a>
                                            </div>
                                            <a href="" class="delete-cart position-absolute top-0 end-0" data-id="<?php echo $item['product_id'] ?>">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.6201 2.38L2.38013 11.62M2.38013 2.38L11.6201 11.62" stroke="#757575" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class=" cart-hover-footer">
                                <div class="text-tamtinh text-center"><span>Tạm tính</span><b class="cart-text-quantity"><?= format_money($total_money_cart) ?></b></div>
                                <p class="mt-3 mb-3 text-center">Mã vận chuyển, thuế và giảm giá được tính khi thanh toán.
                                </p>
                                <a class="text-center" href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>"><?php echo FSText::_('Thanh toán') ?></a>
                            </div>
                        </div>
                    </div>
                    <div class="members_header">
                        <?php if ($user->userID) { ?>
                            <div class="user_login_btn">
                                <?php if ($userImage) { ?>
                                    <img src="<?php echo URL_ROOT . $userImage ?>" alt="user" class="img-fluid">
                                <?php } ?>
                                <span>
                                    <?php echo FSText::_('Hi,') . ' ' . $user->userInfo->full_name ?: '' ?>
                                </span>
                            </div>
                        <?php } else { ?>
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 20C5.33579 17.5226 8.50702 16 12 16C15.493 16 18.6642 17.5226 21 20M16.5 7.5C16.5 9.98528 14.4853 12 12 12C9.51472 12 7.5 9.98528 7.5 7.5C7.5 5.01472 9.51472 3 12 3C14.4853 3 16.5 5.01472 16.5 7.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                        <?php } ?>
                        <div class="box_members_click">
                            <?php if (!$user->userID) { ?>
                                <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="btn-guest btn-login" title="<?php echo FSText::_('Đăng nhập') ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M7.41675 6.29995C7.67508 3.29995 9.21675 2.07495 12.5917 2.07495H12.7001C16.4251 2.07495 17.9167 3.56662 17.9167 7.29162V12.725C17.9167 16.45 16.4251 17.9416 12.7001 17.9416H12.5917C9.24175 17.9416 7.70008 16.7333 7.42508 13.7833M1.66675 9.99995H12.4001M10.5417 7.20828L13.3334 9.99995L10.5417 12.7916" stroke="#3B3B3B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <span>
                                        <?php echo FSText::_('Đăng nhập') ?>
                                    </span>
                                </a>
                                <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=register') ?>" class="btn-guest btn-register" title="<?php echo FSText::_('Đăng ký') ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.0834 9.41662V5.86663C17.0834 2.5083 16.3001 1.66663 13.1501 1.66663H6.85008C3.70008 1.66663 2.91675 2.5083 2.91675 5.86663V15.2499C2.91675 17.4666 4.13342 17.9916 5.60842 16.4083L5.61674 16.4C6.30007 15.675 7.34174 15.7333 7.93341 16.5249L8.77508 17.65M6.66675 5.83329H13.3334M7.50008 9.16663H12.5001M14.7494 12.7335C14.9994 13.6335 15.6994 14.3335 16.5994 14.5835M15.1759 12.3085L12.2259 15.2585C12.1093 15.3752 12.0009 15.5919 11.9759 15.7502L11.8176 16.8752C11.7593 17.2835 12.0426 17.5669 12.4509 17.5085L13.5759 17.3502C13.7343 17.3252 13.9593 17.2169 14.0676 17.1002L17.0176 14.1502C17.5259 13.6419 17.7676 13.0502 17.0176 12.3002C16.2759 11.5585 15.6843 11.8002 15.1759 12.3085Z" stroke="#3B3B3B" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <span>
                                        <?php echo FSText::_('Đăng ký') ?>
                                    </span>
                                </a>
                            <?php } else { ?>
                                <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=dashboard") ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.6668 17.5C16.6668 16.337 16.6668 15.7555 16.5233 15.2824C16.2001 14.217 15.3664 13.3834 14.3011 13.0602C13.828 12.9167 13.2465 12.9167 12.0835 12.9167H7.91683C6.75386 12.9167 6.17237 12.9167 5.69921 13.0602C4.63388 13.3834 3.8002 14.217 3.47703 15.2824C3.3335 15.7555 3.3335 16.337 3.3335 17.5M13.7502 6.25C13.7502 8.32107 12.0712 10 10.0002 10C7.92909 10 6.25016 8.32107 6.25016 6.25C6.25016 4.17893 7.92909 2.5 10.0002 2.5C12.0712 2.5 13.7502 4.17893 13.7502 6.25Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>
                                        <?php echo FSText::_('Thông tin tài khoản') ?>
                                    </span>
                                </a>
                                <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=orders") ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M11.6668 1.89124V5.33335C11.6668 5.80006 11.6668 6.03342 11.7577 6.21168C11.8376 6.36848 11.965 6.49596 12.1218 6.57586C12.3001 6.66669 12.5335 6.66669 13.0002 6.66669H16.4423M13.3335 10.8333H6.66683M13.3335 14.1666H6.66683M8.3335 7.49996H6.66683M11.6668 1.66663H7.3335C5.93336 1.66663 5.2333 1.66663 4.69852 1.93911C4.22811 2.17879 3.84566 2.56124 3.60598 3.03165C3.3335 3.56643 3.3335 4.26649 3.3335 5.66663V14.3333C3.3335 15.7334 3.3335 16.4335 3.60598 16.9683C3.84566 17.4387 4.22811 17.8211 4.69852 18.0608C5.2333 18.3333 5.93336 18.3333 7.3335 18.3333H12.6668C14.067 18.3333 14.767 18.3333 15.3018 18.0608C15.7722 17.8211 16.1547 17.4387 16.3943 16.9683C16.6668 16.4335 16.6668 15.7334 16.6668 14.3333V6.66663L11.6668 1.66663Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>
                                        <?php echo FSText::_('Đơn hàng của tôi') ?>
                                    </span>
                                </a>
                                <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=promotion") ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M8.33317 6.66671V5.83337M8.33317 10.4167V9.58337M8.33317 14.1667V13.3334M4.33317 3.33337H15.6665C16.5999 3.33337 17.0666 3.33337 17.4232 3.51503C17.7368 3.67482 17.9917 3.92979 18.1515 4.24339C18.3332 4.59991 18.3332 5.06662 18.3332 6.00004V7.08337C16.7223 7.08337 15.4165 8.38921 15.4165 10C15.4165 11.6109 16.7223 12.9167 18.3332 12.9167V14C18.3332 14.9335 18.3332 15.4002 18.1515 15.7567C17.9917 16.0703 17.7368 16.3253 17.4232 16.4851C17.0666 16.6667 16.5999 16.6667 15.6665 16.6667H4.33317C3.39975 16.6667 2.93304 16.6667 2.57652 16.4851C2.26292 16.3253 2.00795 16.0703 1.84816 15.7567C1.6665 15.4002 1.6665 14.9335 1.6665 14V12.9167C3.27733 12.9167 4.58317 11.6109 4.58317 10C4.58317 8.38921 3.27733 7.08337 1.6665 7.08337V6.00004C1.6665 5.06662 1.6665 4.59991 1.84816 4.24339C2.00795 3.92979 2.26292 3.67482 2.57652 3.51503C2.93304 3.33337 3.39975 3.33337 4.33317 3.33337Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>
                                        <?php echo FSText::_('Ưu đãi của tôi') ?>
                                    </span>
                                </a>
                                <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=favorite") ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_1626_40229)">
                                            <path d="M9.99984 4.99996V18.3333M9.99984 4.99996H7.05341C6.61927 4.99996 6.20292 4.82436 5.89594 4.5118C5.58896 4.19924 5.4165 3.77532 5.4165 3.33329C5.4165 2.89127 5.58896 2.46734 5.89594 2.15478C6.20292 1.84222 6.61927 1.66663 7.05341 1.66663C9.34508 1.66663 9.99984 4.99996 9.99984 4.99996ZM9.99984 4.99996H12.9463C13.3804 4.99996 13.7968 4.82436 14.1037 4.5118C14.4107 4.19924 14.5832 3.77532 14.5832 3.33329C14.5832 2.89127 14.4107 2.46734 14.1037 2.15478C13.7968 1.84222 13.3804 1.66663 12.9463 1.66663C10.6546 1.66663 9.99984 4.99996 9.99984 4.99996ZM16.6665 9.16663V15.6666C16.6665 16.6 16.6665 17.0668 16.4848 17.4233C16.3251 17.7369 16.0701 17.9918 15.7565 18.1516C15.4 18.3333 14.9333 18.3333 13.9998 18.3333L5.99984 18.3333C5.06642 18.3333 4.59971 18.3333 4.24319 18.1516C3.92958 17.9918 3.67462 17.7369 3.51483 17.4233C3.33317 17.0668 3.33317 16.6 3.33317 15.6666V9.16663M1.6665 6.33329L1.6665 7.83329C1.6665 8.3 1.6665 8.53336 1.75733 8.71162C1.83723 8.86842 1.96471 8.9959 2.12151 9.0758C2.29977 9.16663 2.53313 9.16663 2.99984 9.16663L16.9998 9.16663C17.4665 9.16663 17.6999 9.16663 17.8782 9.0758C18.035 8.9959 18.1624 8.86842 18.2423 8.71162C18.3332 8.53336 18.3332 8.3 18.3332 7.83329V6.33329C18.3332 5.86658 18.3332 5.63323 18.2423 5.45497C18.1624 5.29817 18.035 5.17068 17.8782 5.09079C17.6999 4.99996 17.4665 4.99996 16.9998 4.99996L2.99984 4.99996C2.53313 4.99996 2.29977 4.99996 2.12151 5.09079C1.96471 5.17068 1.83723 5.29817 1.75733 5.45497C1.6665 5.63323 1.6665 5.86658 1.6665 6.33329Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1626_40229">
                                                <rect width="20" height="20" fill="white" />
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span>
                                        <?php echo FSText::_('Đổi quà') ?>
                                    </span>
                                </a>
                                <a class="btn-guest" href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.3333 14.1667L17.5 10M17.5 10L13.3333 5.83333M17.5 10H7.5M7.5 2.5H6.5C5.09987 2.5 4.3998 2.5 3.86502 2.77248C3.39462 3.01217 3.01217 3.39462 2.77248 3.86502C2.5 4.3998 2.5 5.09987 2.5 6.5V13.5C2.5 14.9001 2.5 15.6002 2.77248 16.135C3.01217 16.6054 3.39462 16.9878 3.86502 17.2275C4.3998 17.5 5.09987 17.5 6.5 17.5H7.5" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span>
                                        <?php echo FSText::_('Đăng xuất') ?>
                                    </span>
                                </a>
                            <?php } ?>
                        </div>
                    </div>


                </div>
            </div>


        </header>
        <main>
            <?php echo $main_content ?>
        </main>

        <footer>
            <div class="container">
                <div class="grid_footer grid_footer-top">
                    <div class="grid_footer-col">
                        <h3 class="site_name-footer">
                            <img src="<?php echo URL_ROOT . $config['logo'] ?>" alt="">
                        </h3>
                        <div class="site_name-footer">
                            <p><?php echo  $config['name_company'] ?></p>
                        </div>
                        <div class="info_company">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.00046 8.95301C9.14921 8.95301 10.0805 8.02176 10.0805 6.87301C10.0805 5.72426 9.14921 4.79301 8.00046 4.79301C6.8517 4.79301 5.92046 5.72426 5.92046 6.87301C5.92046 8.02176 6.8517 8.95301 8.00046 8.95301Z" stroke="#A3A3A3" />
                                <path d="M2.41379 5.65968C3.72712 -0.113657 12.2805 -0.106991 13.5871 5.66634C14.3538 9.05301 12.2471 11.9197 10.4005 13.693C9.06046 14.9863 6.94046 14.9863 5.59379 13.693C3.75379 11.9197 1.64712 9.04634 2.41379 5.65968Z" stroke="#A3A3A3" />
                            </svg>
                            <p>
                                <?php echo FSText::_('Địa chỉ: ') . $config['address'] ?>
                            </p>
                        </div>
                        <div class="info_company">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6473 12.2197C14.6473 12.4597 14.594 12.7063 14.4807 12.9463C14.3673 13.1863 14.2207 13.413 14.0273 13.6263C13.7007 13.9863 13.3407 14.2463 12.934 14.413C12.534 14.5797 12.1007 14.6663 11.634 14.6663C10.954 14.6663 10.2273 14.5063 9.46065 14.1797C8.69398 13.853 7.92732 13.413 7.16732 12.8597C6.40065 12.2997 5.67398 11.6797 4.98065 10.993C4.29398 10.2997 3.67398 9.57301 3.12065 8.81301C2.57398 8.05301 2.13398 7.29301 1.81398 6.53967C1.49398 5.77967 1.33398 5.05301 1.33398 4.35967C1.33398 3.90634 1.41398 3.47301 1.57398 3.07301C1.73398 2.66634 1.98732 2.29301 2.34065 1.95967C2.76732 1.53967 3.23398 1.33301 3.72732 1.33301C3.91398 1.33301 4.10065 1.37301 4.26732 1.45301C4.44065 1.53301 4.59398 1.65301 4.71398 1.82634L6.26065 4.00634C6.38065 4.17301 6.46732 4.32634 6.52732 4.47301C6.58732 4.61301 6.62065 4.75301 6.62065 4.87967C6.62065 5.03967 6.57398 5.19967 6.48065 5.35301C6.39398 5.50634 6.26732 5.66634 6.10732 5.82634L5.60065 6.35301C5.52732 6.42634 5.49398 6.51301 5.49398 6.61967C5.49398 6.67301 5.50065 6.71967 5.51398 6.77301C5.53398 6.82634 5.55398 6.86634 5.56732 6.90634C5.68732 7.12634 5.89398 7.41301 6.18732 7.75967C6.48732 8.10634 6.80732 8.45967 7.15398 8.81301C7.51398 9.16634 7.86065 9.49301 8.21398 9.79301C8.56065 10.0863 8.84732 10.2863 9.07398 10.4063C9.10732 10.4197 9.14732 10.4397 9.19398 10.4597C9.24732 10.4797 9.30065 10.4863 9.36065 10.4863C9.47398 10.4863 9.56065 10.4463 9.63398 10.373L10.1407 9.87301C10.3073 9.70634 10.4673 9.57967 10.6207 9.49967C10.774 9.40634 10.9273 9.35967 11.094 9.35967C11.2207 9.35967 11.354 9.38634 11.5007 9.44634C11.6473 9.50634 11.8007 9.59301 11.9673 9.70634L14.174 11.273C14.3473 11.393 14.4673 11.533 14.5407 11.6997C14.6073 11.8663 14.6473 12.033 14.6473 12.2197Z" stroke="#A3A3A3" stroke-miterlimit="10" />
                            </svg>
                            <p>
                                <?php echo FSText::_('Hotline: ') . $config['hotline'] ?>
                            </p>
                        </div>
                        <div class="info_company">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.334 5.99967L9.24731 7.66634C8.56065 8.21301 7.43398 8.21301 6.74731 7.66634L4.66732 5.99967M11.334 13.6663H4.66732C2.66732 13.6663 1.33398 12.6663 1.33398 10.333V5.66634C1.33398 3.33301 2.66732 2.33301 4.66732 2.33301H11.334C13.334 2.33301 14.6673 3.33301 14.6673 5.66634V10.333C14.6673 12.6663 13.334 13.6663 11.334 13.6663Z" stroke="#A3A3A3" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p>
                                <?php echo FSText::_('Email: ') . $config['email'] ?>
                            </p>
                        </div>
                        <div class="info_company">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0_2024_5691)">
                                    <path d="M8.00065 1.33301C9.66817 3.15858 10.6158 5.5277 10.6673 7.99967C10.6158 10.4717 9.66817 12.8408 8.00065 14.6663M8.00065 1.33301C6.33313 3.15858 5.38548 5.5277 5.33398 7.99967C5.38548 10.4717 6.33313 12.8408 8.00065 14.6663M8.00065 1.33301C4.31875 1.33301 1.33398 4.31778 1.33398 7.99967C1.33398 11.6816 4.31875 14.6663 8.00065 14.6663M8.00065 1.33301C11.6826 1.33301 14.6673 4.31778 14.6673 7.99967C14.6673 11.6816 11.6826 14.6663 8.00065 14.6663M1.66733 5.99967H14.334M1.66732 9.99967H14.334" stroke="#A3A3A3" stroke-linecap="round" stroke-linejoin="round" />
                                </g>
                                <defs>
                                    <clipPath id="clip0_2024_5691">
                                        <rect width="16" height="16" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                            <p>
                                <?php echo FSText::_('Website: ') .  $config['website'] ?>
                            </p>
                        </div>
                    </div>
                    <div class="grid_footer-col">
                        <h3 class="site_name-footer">
                            <?php echo FSText::_('Về Vithaico') ?>
                        </h3>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'footer', 'group' => 2)) ?>
                    </div>
                    <div class="grid_footer-col">
                        <h3 class="site_name-footer">
                            <?php echo FSText::_('Chính sách hoa hồng') ?>
                        </h3>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'footer', 'group' => 3)) ?>
                    </div>
                </div>
                <div class="footer-bot">
                    <div class="info">
                        <a href="">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12.808 4.65602H14.312V2.11202C13.5838 2.0363 12.8521 1.99892 12.12 2.00002C9.94399 2.00002 8.456 3.32802 8.456 5.76002V7.85601H6V10.704H8.456V18H11.4V10.704H13.848L14.216 7.85601H11.4V6.04002C11.4 5.20002 11.624 4.65602 12.808 4.65602Z" fill="#A3A3A3" />
                            </svg>
                        </a>
                        <a href=""><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.6009 2.77002H17.0544L11.6943 8.8962L18 17.2326H13.0627L9.19565 12.1766L4.77085 17.2326H2.31595L8.04903 10.6799L2 2.77002H7.06261L10.5581 7.39136L14.6009 2.77002ZM13.7399 15.7641H15.0993L6.32391 4.16139H4.86504L13.7399 15.7641Z" fill="#A3A3A3" />
                            </svg>
                        </a>
                        <a href=""><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M14.2048 4.94253C13.6865 4.94253 13.2685 5.3605 13.2685 5.87879C13.2685 6.39708 13.6865 6.81505 14.2048 6.81505C14.7231 6.81505 15.1411 6.39708 15.1411 5.87879C15.1411 5.3605 14.7231 4.94253 14.2048 4.94253ZM10.0251 6.14629C7.85162 6.14629 6.07941 7.9185 6.07941 10.092C6.07941 12.2654 7.85162 14.0376 10.0251 14.0376C12.1985 14.0376 13.9707 12.2654 13.9707 10.092C13.9707 7.9185 12.1985 6.14629 10.0251 6.14629ZM10.0251 12.6332C8.62069 12.6332 7.50052 11.4963 7.50052 10.1087C7.50052 8.70429 8.63741 7.58412 10.0251 7.58412C11.4295 7.58412 12.5496 8.72101 12.5496 10.1087C12.5496 11.4963 11.4127 12.6332 10.0251 12.6332ZM18 6.81505C18 4.15674 15.8433 2 13.185 2H6.81505C4.15674 2 2 4.15674 2 6.81505V13.185C2 15.8433 4.15674 18 6.81505 18H13.1682C15.8265 18 17.9833 15.8433 17.9833 13.185V6.81505H18ZM16.4786 13.1682C16.4786 14.9906 14.9906 16.4786 13.1682 16.4786H6.81505C4.99269 16.4786 3.5047 14.9906 3.5047 13.1682V6.81505C3.5047 4.97597 4.97597 3.5047 6.81505 3.5047H13.1682C14.9906 3.5047 16.4786 4.99269 16.4786 6.81505V13.1682Z" fill="#A3A3A3" />
                            </svg>
                        </a>
                        <a href="">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.9963 7.96236C18.0323 6.92204 17.8047 5.8895 17.3349 4.96062C17.0161 4.57948 16.5737 4.32226 16.0848 4.2338C14.0625 4.0503 12.0317 3.97509 10.0014 4.00849C7.97838 3.97357 5.95498 4.04636 3.93973 4.22654C3.54131 4.29901 3.17259 4.48589 2.87858 4.76438C2.22445 5.36763 2.15177 6.39971 2.07909 7.27189C1.97364 8.84003 1.97364 10.4135 2.07909 11.9816C2.10012 12.4725 2.17321 12.9598 2.29713 13.4353C2.38477 13.8024 2.56207 14.142 2.81317 14.4237C3.10918 14.717 3.48648 14.9145 3.89612 14.9906C5.46307 15.1841 7.04193 15.2642 8.62041 15.2305C11.1643 15.2668 13.3956 15.2305 16.0339 15.027C16.4536 14.9555 16.8415 14.7577 17.1459 14.4601C17.3494 14.2565 17.5014 14.0073 17.5893 13.7333C17.8492 12.9357 17.9769 12.1009 17.9672 11.2621C17.9963 10.8551 17.9963 8.39845 17.9963 7.96236ZM8.35876 11.6982V7.1992L12.6615 9.4596C11.455 10.1283 9.86327 10.8842 8.35876 11.6982Z" fill="#A3A3A3" />
                            </svg>

                        </a>
                        <a href=""><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M16 9.36635V15.0099C16 15.1485 15.8812 15.2674 15.7426 15.2674H12.8317C12.6931 15.2674 12.5743 15.1485 12.5743 15.0099V9.76239C12.5743 8.37624 12.0792 7.42575 10.8317 7.42575C9.88118 7.42575 9.32672 8.05941 9.06929 8.67328C8.97028 8.8911 8.95048 9.20793 8.95048 9.50496V15.0099C8.95048 15.1485 8.83167 15.2674 8.69305 15.2674H5.80195C5.66334 15.2674 5.54453 15.1485 5.54453 15.0099C5.54453 13.604 5.58413 6.81188 5.54453 5.22772C5.54453 5.0891 5.66334 4.97029 5.80195 4.97029H8.71286C8.85147 4.97029 8.97028 5.0891 8.97028 5.22772V6.43564C8.97028 6.45545 8.95048 6.45544 8.95048 6.47525H8.97028V6.43564C9.42573 5.74257 10.2376 4.73267 12.0594 4.73267C14.3168 4.73267 16 6.21782 16 9.36635V9.36635ZM0.4752 15.2872H3.3861C3.52472 15.2872 3.64353 15.1684 3.64353 15.0297V5.22772C3.64353 5.0891 3.52472 4.97029 3.3861 4.97029H0.4752C0.336586 4.97029 0.217773 5.0891 0.217773 5.22772V15.0297C0.237575 15.1684 0.336586 15.2872 0.4752 15.2872Z" fill="#A3A3A3" />
                                <path d="M1.84159 3.68318C2.85867 3.68318 3.68318 2.85867 3.68318 1.84159C3.68318 0.824509 2.85867 0 1.84159 0C0.824508 0 0 0.824509 0 1.84159C0 2.85867 0.824508 3.68318 1.84159 3.68318Z" fill="#A3A3A3" />
                            </svg>
                        </a>
                    </div>
                    <div class="copyright">
                        <p><?php echo  $config['copyright'] ?></p>
                    </div>
                </div>
            </div>
        </footer>

        <div class="side-left_btn">
            <a class="circle-tel d-flex align-items-center justify-content-center" href="tel:<?php echo $config['hotline'] ?>">
                <svg width="30" height="30" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.9597 13.5093C15.9597 13.808 16.1997 14.0427 16.4931 14.0427C17.1011 14.0427 17.5917 14.5387 17.5917 15.1413C17.5917 15.4347 17.8317 15.6747 18.125 15.6747C18.4184 15.6747 18.6584 15.4347 18.6584 15.1413C18.6584 13.9467 17.6877 12.976 16.4931 12.976C16.1997 12.976 15.9597 13.216 15.9597 13.5093ZM24.6424 15.6747C24.9411 15.6747 25.1757 15.4347 25.1757 15.1413C25.1757 10.352 21.2824 6.45868 16.4931 6.45868C16.1997 6.45868 15.9597 6.69865 15.9597 6.99201C15.9597 7.28534 16.1997 7.52535 16.4931 7.52535C20.6957 7.52535 24.1091 10.944 24.1091 15.1413C24.1091 15.4347 24.349 15.6747 24.6424 15.6747Z" fill="white"></path>
                    <path d="M20.8503 15.1414C20.8503 15.4347 21.0903 15.6747 21.3836 15.6747C21.677 15.6747 21.9169 15.4347 21.9169 15.1414C21.9169 12.1494 19.4849 9.71736 16.4929 9.71736C16.1996 9.71736 15.9596 9.95737 15.9596 10.2507C15.9596 10.5494 16.1996 10.784 16.4929 10.784C18.8983 10.784 20.8503 12.7414 20.8503 15.1414ZM16.4929 3.20001C16.1996 3.20001 15.9596 3.44002 15.9596 3.73335C15.9596 4.0267 16.1996 4.26668 16.4929 4.26668C22.4929 4.26668 27.373 9.14669 27.373 15.1414C27.373 15.4347 27.6076 15.6747 27.9063 15.6747C28.1996 15.6747 28.4396 15.4347 28.4396 15.1414C28.4396 8.5547 23.0796 3.20001 16.4929 3.20001ZM21.7036 20.7627L21.005 21.1414C19.8263 21.7867 18.333 21.568 17.3783 20.6134L11.7463 14.9814C10.7916 14.0267 10.573 12.5333 11.2183 11.3494L11.5969 10.656C12.0236 9.86668 12.1783 8.98136 12.0503 8.09601C11.9276 7.21069 11.5276 6.40535 10.8876 5.76534C10.109 4.9867 9.07429 4.56004 7.97029 4.56004C6.86628 4.56004 5.82628 4.9867 5.0476 5.76534L4.77563 6.04269C3.33562 7.48269 3.17029 9.96268 4.30629 13.0347C5.37826 15.968 7.53829 19.1467 10.3756 21.984C14.701 26.3094 19.5169 28.8 22.973 28.8C24.3383 28.8 25.4956 28.4107 26.3169 27.5894L26.5943 27.312C27.3676 26.5387 27.7996 25.504 27.805 24.3894C27.7996 23.3013 27.3569 22.2347 26.5943 21.472C25.309 20.1867 23.2983 19.8987 21.7036 20.7627Z" fill="white"></path>
                </svg>
            </a>
        </div>
    </div>
    <input type="hidden" value="<?php echo URL_ROOT ?>" id="root" />
    <input type="hidden" value="<?php echo $_SESSION['token'] ?>" id="csrf-token">
<?php } ?>

<div id="flash-message-container" class="w-100 h-100 position-fixed left-0 top-0 flash-message-container">
    <div class="d-flex align-items-center justify-content-center w-100 h-100 ">
        <div id="flash-message" class="p-4 text-center flash-message">
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg-success">
                <rect width="52" height="52" rx="26" fill="#3BA500" fill-opacity="0.08" />
                <rect x="6" y="6" width="40" height="40" rx="20" fill="#3BA500" fill-opacity="0.08" />
                <path d="M21.75 26L24.58 28.83L30.25 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#3BA500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg-error">
                <rect width="52" height="52" rx="26" fill="#E81B2B" fill-opacity="0.08" />
                <rect x="6" y="6" width="40" height="40" rx="20" fill="#E81B2B" fill-opacity="0.08" />
                <path d="M23.17 28.83L28.83 23.17M28.83 28.83L23.17 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#E81B2B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <div class="message mt-3"></div>
        </div>
    </div>
</div>

<div class="offcanvas offcanvas-top" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'home', 'group' => 1)) ?>

    </div>
</div>