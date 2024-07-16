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
                    <img src="<?php echo URL_ROOT . $config['logo'] ?>" alt="<?php echo $config['site_name'] ?>" class="img-fluid img-logo">
                </a>
                <div class="menu-header">
                    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'home', 'group' => 1)) ?>
                </div>
                <div class="block-members_cart_lang d-flex align-items-center gap-3 position-relative">
                    <div class="search_header">
                        <a href="" class="btn-guest btn-search">
                            <div>
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 21L17.5001 17.5M20 11.5C20 16.1944 16.1944 20 11.5 20C6.80558 20 3 16.1944 3 11.5C3 6.80558 6.80558 3 11.5 3C16.1944 3 20 6.80558 20 11.5Z" stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
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
                                    <div class="cart-quantity cart-text-quantity  d-flex align-items-center justify-content-center fw-bold">
                                        <?php echo $totalCart ?></div>
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
                                    <?php foreach ($cartList as $i => $item) {
                                        $total_money_cart +=  $total_money_cart + ($item['price'] * $item['quantity']);
                                    ?>
                                        <div class="cart-hover-item position-relative">
                                            <a href="<?php echo $item['url'] ?>" class=""><img src="<?php echo $item['image'] ?>" alt="<?php echo $item['product_name'] ?>" class="img-fluid"></a>
                                            <div>
                                                <a href="<?php echo $item['url'] ?>">
                                                    <div class="mb-2"><?php echo $item['product_name'] ?></div>
                                                    <p class="mb-2"><?php echo 'x ' . ($item['quantity']) ?></p>
                                                    <div class="item-price d-flex flex-wrap align-items-center justify-content-between">
                                                        <p class="mb-0"><?php echo format_money($item['price']) ?>/<span><?= $item['coin'] ?>VT-Coin</span></p>
                                                    </div>
                                                </a>
                                            </div>
                                            <a href="" class="delete-cart position-absolute top-0 end-0" data-id="<?php echo $i ?>">
                                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.6201 2.38L2.38013 11.62M2.38013 2.38L11.6201 11.62" stroke="#757575" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                        </div>
                                    <?php } ?>

                                <?php } else { ?>
                                    <div class="text-center w-100">
                                        <img src="<?php echo URL_ROOT . 'images/no-cart.svg' ?>" alt="<?php echo FSText::_('Chưa có sản phẩm nào trong giỏ hàng!') ?>" class="img-fluid opacity-25">
                                        <div class="fw-medium mt-4 mb-4"><?php echo FSText::_('Chưa có sản phẩm nào?') ?></div>
                                        <a href="<?php echo URL_ROOT ?>" class="btn-no-cart"><?php echo FSText::_('Tiếp tục mua sắm để khám phá thêm.') ?></a>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class=" cart-hover-footer">
                                <?php if (!empty($cartList)) { ?>
                                    <div class="text-tamtinh text-center mb-3"><span>Tạm tính</span><b class="cart-text-quantity-2 "><?= format_money($total_money_cart) ?></b></div>
                                    <!-- <p class="mt-3 mb-3 text-center">Mã vận chuyển, thuế và giảm giá được tính khi thanh toán.
                                    </p> -->
                                    <a class="text-center" href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>"><?php echo FSText::_('Thanh toán') ?></a>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="members_header">
                        <?php if ($user->userID) { ?>
                            <div class="user_login_btn">
                                <?php if ($userImage) { ?>
                                    <img src="<?php echo URL_ROOT . $userImage ?>" alt="user" class="img-fluid">
                                <?php } ?>
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
                    </div>


                </div>
            </div>


        </header>
        <main>
            <?php echo $main_content ?>
        </main>

        <footer class="position-relative">
            <img src="/images/footer-left.svg" alt="" class="position-absolute top-0 start-0">

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
            <img src="/images/footer-right.svg" alt="" class="position-absolute bottom-0 end-0">
        </footer>

        <div class="side-left_btn">
            <a class="circle-tel d-flex align-items-center justify-content-center" href="tel:<?php echo $config['hotline'] ?>">
                <svg width="30" height="30" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.9597 13.5093C15.9597 13.808 16.1997 14.0427 16.4931 14.0427C17.1011 14.0427 17.5917 14.5387 17.5917 15.1413C17.5917 15.4347 17.8317 15.6747 18.125 15.6747C18.4184 15.6747 18.6584 15.4347 18.6584 15.1413C18.6584 13.9467 17.6877 12.976 16.4931 12.976C16.1997 12.976 15.9597 13.216 15.9597 13.5093ZM24.6424 15.6747C24.9411 15.6747 25.1757 15.4347 25.1757 15.1413C25.1757 10.352 21.2824 6.45868 16.4931 6.45868C16.1997 6.45868 15.9597 6.69865 15.9597 6.99201C15.9597 7.28534 16.1997 7.52535 16.4931 7.52535C20.6957 7.52535 24.1091 10.944 24.1091 15.1413C24.1091 15.4347 24.349 15.6747 24.6424 15.6747Z" fill="white"></path>
                    <path d="M20.8503 15.1414C20.8503 15.4347 21.0903 15.6747 21.3836 15.6747C21.677 15.6747 21.9169 15.4347 21.9169 15.1414C21.9169 12.1494 19.4849 9.71736 16.4929 9.71736C16.1996 9.71736 15.9596 9.95737 15.9596 10.2507C15.9596 10.5494 16.1996 10.784 16.4929 10.784C18.8983 10.784 20.8503 12.7414 20.8503 15.1414ZM16.4929 3.20001C16.1996 3.20001 15.9596 3.44002 15.9596 3.73335C15.9596 4.0267 16.1996 4.26668 16.4929 4.26668C22.4929 4.26668 27.373 9.14669 27.373 15.1414C27.373 15.4347 27.6076 15.6747 27.9063 15.6747C28.1996 15.6747 28.4396 15.4347 28.4396 15.1414C28.4396 8.5547 23.0796 3.20001 16.4929 3.20001ZM21.7036 20.7627L21.005 21.1414C19.8263 21.7867 18.333 21.568 17.3783 20.6134L11.7463 14.9814C10.7916 14.0267 10.573 12.5333 11.2183 11.3494L11.5969 10.656C12.0236 9.86668 12.1783 8.98136 12.0503 8.09601C11.9276 7.21069 11.5276 6.40535 10.8876 5.76534C10.109 4.9867 9.07429 4.56004 7.97029 4.56004C6.86628 4.56004 5.82628 4.9867 5.0476 5.76534L4.77563 6.04269C3.33562 7.48269 3.17029 9.96268 4.30629 13.0347C5.37826 15.968 7.53829 19.1467 10.3756 21.984C14.701 26.3094 19.5169 28.8 22.973 28.8C24.3383 28.8 25.4956 28.4107 26.3169 27.5894L26.5943 27.312C27.3676 26.5387 27.7996 25.504 27.805 24.3894C27.7996 23.3013 27.3569 22.2347 26.5943 21.472C25.309 20.1867 23.2983 19.8987 21.7036 20.7627Z" fill="white"></path>
                </svg>
            </a>
        </div>
        <div class="side-right_btn">
            <a href="<?php echo $config['zalo'] ?>" id="zalo">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#0068FF" />
                    <g clip-path="url(#clip0_3_83)">
                        <path d="M40 23.9971C39.9989 26.7112 39.308 29.3804 37.9921 31.7541C36.6762 34.1277 34.7786 36.1277 32.4775 37.5663C30.1765 39.0049 27.5475 39.8347 24.8377 39.9778C22.1279 40.1209 19.4262 39.5727 16.9864 38.3845L9.54 39.3159C9.41679 39.3312 9.29169 39.3177 9.17462 39.2763C9.05754 39.235 8.9517 39.1669 8.86547 39.0776C8.77923 38.9882 8.71498 38.88 8.67779 38.7615C8.6406 38.643 8.6315 38.5175 8.6512 38.3949L9.784 31.3464C8.67246 29.1938 8.0641 26.8169 8.0048 24.3949C7.94549 21.9728 8.43678 19.569 9.44163 17.3645C10.4465 15.1601 11.9386 13.2126 13.8056 11.6689C15.6726 10.1253 17.8656 9.02577 20.2193 8.45329C22.573 7.8808 25.0259 7.8503 27.3931 8.36409C29.7603 8.87788 31.98 9.92254 33.8847 11.4193C35.7895 12.9161 37.3296 14.8258 38.3889 17.0046C39.4482 19.1834 39.9991 21.5743 40 23.9971H40Z" fill="white" />
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M24.4568 22.3152V21.896H25.7136V27.796H24.9936C24.8516 27.796 24.7153 27.7398 24.6146 27.6397C24.5139 27.5395 24.4569 27.4036 24.456 27.2616C23.9993 27.5952 23.4591 27.7958 22.8954 27.8413C22.3316 27.8867 21.7663 27.7752 21.262 27.5191C20.7578 27.263 20.3343 26.8722 20.0384 26.3902C19.7426 25.9081 19.586 25.3536 19.586 24.788C19.586 24.2224 19.7426 23.6679 20.0384 23.1858C20.3343 22.7038 20.7578 22.313 21.262 22.0569C21.7663 21.8008 22.3316 21.6892 22.8954 21.7347C23.4591 21.7801 23.9993 21.9808 24.456 22.3144L24.4568 22.3152ZM19.2576 19.9984V20.1896C19.2772 20.5423 19.1789 20.8916 18.9784 21.1824L18.9504 21.2144C18.9 21.272 18.7808 21.4064 18.724 21.48L14.688 26.5424H19.2576V27.2624C19.2574 27.405 19.2006 27.5418 19.0996 27.6426C18.9987 27.7434 18.8619 27.8 18.7192 27.8H12.8V27.4584C12.7831 27.1756 12.8655 26.8958 13.0328 26.6672L17.3344 21.3424H12.9792V19.9984H19.2576ZM27.2384 27.796C27.1197 27.7958 27.0058 27.7485 26.9219 27.6645C26.8379 27.5806 26.7906 27.4667 26.7904 27.348V19.9984H28.136V27.796H27.2384ZM32.1136 21.688C32.7237 21.6883 33.32 21.8695 33.8271 22.2087C34.3342 22.5479 34.7293 23.0298 34.9625 23.5936C35.1957 24.1573 35.2566 24.7776 35.1373 25.3759C35.018 25.9742 34.724 26.5237 34.2924 26.9549C33.8609 27.3861 33.3111 27.6797 32.7127 27.7985C32.1143 27.9173 31.4942 27.856 30.9306 27.6224C30.367 27.3887 29.8854 26.9932 29.5466 26.4859C29.2078 25.9785 29.0271 25.3821 29.0272 24.772C29.0276 23.9538 29.353 23.1692 29.9318 22.5909C30.5106 22.0126 31.2954 21.6878 32.1136 21.688ZM22.6488 26.5904C23.0051 26.5905 23.3535 26.485 23.6499 26.2872C23.9462 26.0894 24.1773 25.8081 24.3138 25.479C24.4503 25.1498 24.4861 24.7876 24.4168 24.4381C24.3474 24.0886 24.1759 23.7675 23.9241 23.5154C23.6723 23.2634 23.3513 23.0916 23.0019 23.022C22.6524 22.9523 22.2902 22.9878 21.9609 23.124C21.6316 23.2602 21.3502 23.491 21.1521 23.7872C20.954 24.0834 20.8482 24.4317 20.848 24.788C20.848 25.2657 21.0377 25.7239 21.3754 26.0619C21.713 26.3999 22.1711 26.59 22.6488 26.5904ZM32.1136 26.5904C32.4726 26.5904 32.8235 26.484 33.122 26.2845C33.4205 26.0851 33.6531 25.8017 33.7906 25.47C33.928 25.1384 33.964 24.7734 33.894 24.4214C33.824 24.0693 33.6512 23.7458 33.3974 23.4919C33.1437 23.238 32.8203 23.0651 32.4682 22.995C32.1162 22.9248 31.7512 22.9607 31.4195 23.0979C31.0878 23.2352 30.8043 23.4677 30.6047 23.7661C30.4052 24.0645 30.2986 24.4154 30.2984 24.7744C30.299 25.2555 30.4905 25.7166 30.8309 26.0567C31.1712 26.3967 31.6325 26.5878 32.1136 26.588V26.5904Z" fill="#0068FF" />
                    </g>
                    <defs>
                        <clipPath id="clip0_3_83">
                            <rect width="32" height="32" fill="white" transform="translate(8 8)" />
                        </clipPath>
                    </defs>
                </svg>

            </a>
            <a href="<?php echo $config['messenger'] ?>" id="messenger">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#1778F2" />
                    <g clip-path="url(#clip0_3_76)">
                        <path d="M24 8C15.1773 8 8 14.8787 8 23.3333C8 27.692 9.94 31.8333 13.3333 34.7467V39.3333C13.334 39.5099 13.4045 39.6791 13.5294 39.804C13.6542 39.9288 13.8234 39.9993 14 40C14.125 40.0003 14.2475 39.9652 14.3533 39.8987L18.0693 37.5773C19.9573 38.3 21.9507 38.6667 24 38.6667C32.8227 38.6667 40 31.788 40 23.3333C40 14.8787 32.8227 8 24 8ZM25.5653 27.84L21.5973 24.4387C21.4951 24.3502 21.3683 24.2952 21.2339 24.2809C21.0995 24.2666 20.9639 24.2937 20.8453 24.3587L14.32 27.9187C14.1786 27.9933 14.0154 28.0154 13.8592 27.9813C13.7031 27.9471 13.564 27.8588 13.4667 27.732C13.3712 27.6034 13.325 27.4448 13.3365 27.285C13.348 27.1253 13.4164 26.975 13.5293 26.8613L21.5293 18.8613C21.7347 18.656 22.0347 18.4853 22.4347 18.8267L26.4027 22.228C26.505 22.3163 26.6318 22.3712 26.7662 22.3855C26.9005 22.3998 27.0361 22.3728 27.1547 22.308L33.68 18.7493C33.8215 18.6753 33.9846 18.6534 34.1406 18.6875C34.2966 18.7217 34.4357 18.8096 34.5333 18.936C34.6288 19.0646 34.675 19.2232 34.6635 19.383C34.652 19.5427 34.5836 19.693 34.4707 19.8067L26.4707 27.8067C26.2653 28.0093 25.9653 28.1813 25.5653 27.84Z" fill="white" />
                    </g>
                    <defs>
                        <clipPath id="clip0_3_76">
                            <rect width="32" height="32" fill="white" transform="translate(8 8)" />
                        </clipPath>
                    </defs>
                </svg>

            </a>
            <a class="" href="#" id="go-top">
                <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="48" height="48" rx="24" fill="#EA212D" />
                    <path d="M24.1472 20.262C24.1937 20.2763 24.2424 20.286 24.2874 20.3048C24.4097 20.3557 24.4307 20.385 24.5312 20.4675L30.5342 26.4712C30.5964 26.547 30.6594 26.6243 30.6969 26.7143C30.8289 27.0323 30.7082 27.4335 30.4209 27.6255C30.1749 27.7897 29.8329 27.7897 29.5869 27.6255C29.5457 27.5985 29.5112 27.5633 29.4729 27.5325L24.0002 22.0598L18.5282 27.5325L18.4142 27.6255C18.3707 27.6488 18.3294 27.6758 18.2844 27.6945C17.9672 27.8265 17.5682 27.7095 17.3732 27.4185C17.2089 27.1725 17.2089 26.8305 17.3732 26.5845C17.4009 26.544 17.4354 26.5088 17.4669 26.4713L23.4699 20.4675C23.5082 20.4368 23.5427 20.4015 23.5839 20.3745C23.6657 20.3198 23.7572 20.2815 23.8539 20.262C23.9499 20.2433 24.0489 20.253 24.1472 20.262Z" fill="white" />
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
<?php if (!$user->userID) { ?>
    <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-grid">
                        <div class="p-5 grid-content">
                            <div class="layout-modal layout-register-success" style="display: none;">
                                <div class="text-center mb-5">
                                    <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.0837 28.0001L24.687 34.6034L37.917 21.3967M28.0003 51.3334C40.8337 51.3334 51.3337 40.8334 51.3337 28.0001C51.3337 15.1667 40.8337 4.66675 28.0003 4.66675C15.167 4.66675 4.66699 15.1667 4.66699 28.0001C4.66699 40.8334 15.167 51.3334 28.0003 51.3334Z" stroke="#3BA500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="fs-4 register-success-message mb-5 text-center"></div>
                                <div class="mb-4 text-center">
                                    Bạn đã tạo thành công tài khoản với email <br>
                                    <b class="register-success-telephone register-success-email"></b>
                                </div>
                                <div class="mb-4 text-center">
                                    Bạn sẽ được chuyển hướng đến trang đăng nhập trong <p class="re-send-count-down-callback"></p> giây.
                                </div>
                                <a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Đăng nhập') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>