<?php
global $config, $tmpl, $module, $user;
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
?>

<?php if ($Itemid == 50) { ?>
    <?php include_once './indexAmp.php'; ?>
<?php } else { ?>
    <div id="app">
        <header class="bg-white">
            <div class="container header-container d-flex align-items-center justify-content-between">
                <a href="<?php echo URL_ROOT ?>" title="<?php echo $config['site_name'] ?>">
                    <img src="<?php echo URL_ROOT . $config['logo'] ?>" width="100" height="48.5" alt="<?php echo $config['site_name'] ?>" class="img-fluid img-logo">
                </a>

                <div class="heder-center">
                    <?php echo $tmpl->load_direct_blocks('search', ['style' => 'default']); ?>
                </div>
                <div class="Login d-grid align-items-center gap-1">
                    <?php if ($user->userID) { ?>
                        <div class="p-2 bg-white d-flex align-items-center justify-content-between user-level">
                            <span><?php echo FSText::_('Hạng thành viên') ?></span>
                            <div class="icon d-flex align-items-center text-uppercase icon-<?php echo $user->userInfo->level ?>">
                                <img src="/images/user-level.svg" alt="level" class="img-fluid">
                                <?php echo $userLevel[$user->userInfo->level] ?>
                            </div>
                        </div>
                        <a href="<?php echo FSRoute::_("index.php?module=members&view=log&task=logout") ?>" class="text-center p-2 btn-guest btn-logout" title="<?php echo FSText::_('Đăng xuất') ?>"><?php echo FSText::_('Đăng xuất') ?></a>
                    <?php } else { ?>
                        <img src="/images/user_home.svg" alt="level" class="img-fluid">
                        <div>
                            <p class="mb-0 font-size-12"><?php echo FSText::_('Xin chào ') ?></p>
                            <span></span>
                            <a href="" class="text-center fw-600 py-1 btn-guest btn-login" title="<?php echo FSText::_('Đăng nhập') ?>"><?php echo FSText::_('Đăng nhập') ?></a>/
                            <a href="" class="text-center fw-600 py-1 btn-guest btn-register" title="<?php echo FSText::_('Đăng ký') ?>"><?php echo FSText::_('Đăng ký') ?></a>
                        </div>

                    <?php } ?>
                </div>
                <div class="header-right d-flex align-items-center justify-content-end">
                    <a href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>" title="<?php echo FSText::_('Giỏ hàng') ?>" class="header-cart position-relative">
                        <div class="cart-session d-grid">
                            <div class="cart-session-left">
                                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2.16663 2.16667H3.58164C3.84816 2.16667 3.98142 2.16667 4.08866 2.21568C4.18316 2.25887 4.26325 2.32833 4.31937 2.41577C4.38306 2.515 4.4019 2.64693 4.43959 2.91077L4.95234 6.5M4.95234 6.5L6.09189 14.8757C6.2365 15.9386 6.3088 16.47 6.5629 16.87C6.7868 17.2225 7.1078 17.5028 7.48726 17.6772C7.91789 17.875 8.45423 17.875 9.52691 17.875H18.7979C19.819 17.875 20.3296 17.875 20.7468 17.6913C21.1147 17.5293 21.4303 17.2682 21.6583 16.9371C21.9168 16.5616 22.0123 16.0601 22.2034 15.057L23.6373 7.52883C23.7046 7.17579 23.7382 6.99927 23.6895 6.86129C23.6467 6.74025 23.5624 6.63832 23.4515 6.57369C23.325 6.5 23.1454 6.5 22.786 6.5H4.95234ZM10.8333 22.75C10.8333 23.3483 10.3483 23.8333 9.74996 23.8333C9.15165 23.8333 8.66663 23.3483 8.66663 22.75C8.66663 22.1517 9.15165 21.6667 9.74996 21.6667C10.3483 21.6667 10.8333 22.1517 10.8333 22.75ZM19.5 22.75C19.5 23.3483 19.0149 23.8333 18.4166 23.8333C17.8183 23.8333 17.3333 23.3483 17.3333 22.75C17.3333 22.1517 17.8183 21.6667 18.4166 21.6667C19.0149 21.6667 19.5 22.1517 19.5 22.75Z" stroke="#3B3B3B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="cart-session-right">
                                <div class="cart-quantity cart-text-quantity  d-flex align-items-center justify-content-center fw-bold"><?php echo $totalCart ?></div>
                                <span></span>
                                <p class="mb-0">Cart</p>
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
                            <p class="mt-3 mb-3 text-center">Mã vận chuyển, thuế và giảm giá được tính khi thanh toán.</p>
                            <a class="text-center" href="<?php echo FSRoute::_('index.php?module=products&view=cart') ?>"><?php echo FSText::_('Thanh toán') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-top bg-white">
                <!-- <div class="container d-flex align-items-center justify-content-between"> -->
                <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu_home']); ?>
                <!-- </div> -->
            </div>

        </header>

        <div class="app-main-content pt-3 pb-3"><?php echo $main_content; ?></div>
        <div id="menu_mobile">
            <?php echo $tmpl->load_direct_blocks('botmenumobile', ['style' => 'default']); ?>
            <?php //echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu']); 
            ?>

        </div>
        <footer>
            <div class="container bg-white">
                <div class="footer-top">
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Hỗ trợ khách hàng') ?></p>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', ['style' => 'footer', 'group' => '2']); ?>
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Về chúng tôi') ?></p>
                        <?php echo $tmpl->load_direct_blocks('mainmenu', ['style' => 'footer', 'group' => '3']); ?>

                        <p class="fw-semibold fs-6 mb-2 mt-4 title"><?php echo FSText::_('Tổng đài hỗ trợ') ?></p>
                        <div>Hotline: <a href="tel:<?php echo $config['hotline'] ?>"><b><?php echo $config['hotline'] ?></b></a> <br> (1000đ/phút, 8-21h kể cả T7, CN)</div>
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Phương thức thanh toán') ?></p>
                        <img src="<?php echo URL_ROOT ?>images/phuong-thuc-thanh-toan.svg" alt="<?php echo FSText::_('Phương thức thanh toán') ?>" class="img-responsive">
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Chứng nhận') ?></p>
                        <img src="<?php echo URL_ROOT ?>images/chung-nhan.jpg" alt="Chứng nhận" class="img-fluid">
                    </div>
                    <div class="item">
                        <p class="fw-semibold fs-6 mb-2 title"><?php echo FSText::_('Kết nối với chúng tôi') ?></p>
                        <div class="mb-2">
                            <a href="<?php echo $config['facebook'] ?>" title="Facebook" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/facebook-circle-icon.svg" alt="Facebook" class="img-fluid">
                                Fanpage
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['shopee'] ?>" title="Shopee" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/shopee-circle-icon.svg" alt="Shopee" class="img-fluid">
                                Shopee
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['tiktok'] ?>" title="Tiktok" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/tiktok-circle-icon.svg" alt="Tiktok" class="img-fluid">
                                Tiktok
                            </a>
                        </div>
                        <div class="mb-2">
                            <a href="<?php echo $config['youtube'] ?>" title="Youtube" class="d-inline-flex align-items-center gap-2">
                                <img src="<?php echo URL_ROOT ?>images/youtube-circle-icon.svg" alt="Youtube" class="img-fluid">
                                Youtube
                            </a>
                        </div>
                    </div>
                </div>
                <div class="footer-bottom text-center">
                    <p class="mb-1"><?php echo $config['company'] ?></p>
                    <p class="mb-1"><?php echo $config['address'] ?></p>
                    <p class="mb-0"><?php echo $config['copyright'] ?></p>
                </div>
            </div>
        </footer>
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

<?php if (!$user->userID) { ?>
    <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="d-grid">
                        <div class="p-5 grid-content">
                            <div class="layout-modal layout-login">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <h4 class="fs-4 m-0"><?php echo FSText::_('Đăng nhập') ?></h4>
                                    <!-- <a href="" class="fs-4 modal-member-tab opacity-50" data="register-telephone"><?php echo FSText::_('Đăng ký') ?></a> -->
                                </div>
                                <div class="mb-5 text-center"><?php echo FSText::_('Chào mừng bạn đến với ShopUSA !') ?></div>
                                <form action="" method="POST" id="form-login">
                                    <div class="mb-4">
                                        <input type="text" class="form-control" name="userlog" id="userlog" autocomplete placeholder="<?php echo FSText::_('Email/Số điện thoại') ?>">
                                    </div>
                                    <div class="mb-4 position-relative d-flex align-items-center">
                                        <input type="password" class="form-control" name="passlog" id="passlog" autocomplete placeholder="********">
                                        <a href="" class="toggle-password">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="mb-4">
                                        <a href="" id="btn-submit-login" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Đăng nhập') ?></a>
                                    </div>
                                    <?php echo csrf::displayToken(); ?>
                                    <input type="hidden" name="module" value="members">
                                    <input type="hidden" name="view" value="log">
                                    <input type="hidden" name="task" value="login">
                                    <input type="hidden" name="redirect" value="<?php echo $Itemid == 1 ? URL_ROOT : URL_ROOT . substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT_REDUCE)) ?>" />
                                </form>
                                <div class="mb-4 wrap position-relative d-flex align-items-center justify-content-center">
                                    <span><?php echo FSText::_('Hoặc') ?></span>
                                </div>
                                <div class="mb-5 d-flex gap-3">
                                    <a href="<?php echo FSRoute::_("index.php?module=members&view=facebook") ?>" class="btn-log-with w-100 d-flex align-items-center justify-content-center gap-2">
                                        Facebook
                                        <img src="/images/facebook.svg" alt="facebook" class="img-fluid">
                                    </a>
                                    <a href="<?php echo FSRoute::_("index.php?module=members&view=google") ?>" class="btn-log-with w-100 d-flex align-items-center justify-content-center gap-2">
                                        Google
                                        <img src="/images/google.svg" alt="google" class="img-fluid">
                                    </a>
                                </div>
                                <div class="d-flex align-items-center justify-content-between">
                                    <div><?php echo FSText::_('Bạn là khách hàng mới?') ?> <a href="" class="fw-bold modal-member-tab text-red" data="register-telephone"><?php echo FSText::_('Đăng ký') ?></a></div>
                                    <a href="" class="modal-member-tab text-blue" data="password"><?php echo FSText::_('Quên mật khẩu?') ?></a>
                                </div>
                            </div>

                            <div class="layout-modal layout-register-telephone" style="display: none;">
                                <div class="d-flex align-items-center justify-content-center mb-2">
                                    <h4 class="fs-4 m-0"><?php echo FSText::_('Đăng ký') ?></h4>
                                     <a href="" class="fs-4 modal-member-tab opacity-50" data="login"><?php echo FSText::_('Đăng nhập') ?></a> 
                                </div>
                                <div class="mb-5 text-center"><?php echo FSText::_('Tạo tài khoản ShopUSA !') ?></div>
                                <div class="form-register-container">
                                    <form action="" method="POST" id="form-register">
                                        <div class="mb-4">
                                            <input type="text" class="form-control" name="telregister" id="telregister" autocomplete placeholder="<?php echo FSText::_('Nhập số điện thoại của bạn') ?>">
                                        </div>
                                        <div class="mb-4">
                                            <a href="" id="btn-submit-register-telephone" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Tiếp theo') ?></a>
                                        </div>
                                        <?php echo csrf::displayToken(); ?>
                                    </form>
                                </div>
                                <div class="mb-4 wrap position-relative d-flex align-items-center justify-content-center">
                                    <span><?php echo FSText::_('Hoặc') ?></span>
                                </div>
                                <div class="mb-5 d-flex gap-3">
                                    <a href="<?php echo FSRoute::_("index.php?module=members&view=facebook") ?>" class="btn-log-with w-100 d-flex align-items-center justify-content-center gap-2">
                                        Facebook
                                        <img src="/images/facebook.svg" alt="facebook" class="img-fluid">
                                    </a>
                                    <a href="<?php echo FSRoute::_("index.php?module=members&view=google") ?>" class="btn-log-with w-100 d-flex align-items-center justify-content-center gap-2">
                                        Google
                                        <img src="/images/google.svg" alt="google" class="img-fluid">
                                    </a>
                                </div>
                                <div class="text-center mb-4">
                                    <div><?php echo FSText::_('Bằng việc đăng kí, bạn đã đồng ý với ShopUSA về') ?></div>
                                    <div>
                                        <a href="" class="text-red"><?php echo FSText::_('Điều khoản dịch vụ') ?></a>
                                        &
                                        <a href="" class="text-red"><?php echo FSText::_('Chính sách bảo mật') ?></a>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <?php echo FSText::_('Bạn đã có tài khoản?') ?> <a href="" class="fw-bold modal-member-tab text-red" data="login"><?php echo FSText::_('Đăng nhập') ?></a>
                                </div>
                            </div>

                            <div class="layout-modal layout-register-otp" style="display: none;">
                                <a href="" class="modal-member-tab" data="register-telephone">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.9998 19.92L8.47984 13.4C7.70984 12.63 7.70984 11.37 8.47984 10.6L14.9998 4.07996" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-2 mt-5">
                                    <h4 class="fs-4 m-0"><?php echo FSText::_('Nhập mã xác minh') ?></h4>
                                </div>
                                <div class="mb-5">
                                    Số điện thoại <b class="register-otp-tel"></b> chưa có tài khoản tại ShopUSA. <br>
                                    Vui lòng xác thực để tạo tài khoản!
                                </div>
                                <div class="form-register-container">
                                    <form action="" method="POST" id="form-register-otp">
                                        <div class="mb-2 d-flex align-items-center justify-content-center gap-4">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                            <input type="number" class="form-control form-otp" name="otp[]" maxlength="1">
                                        </div>
                                        <div class="mb-4 otp-message text-red"></div>
                                        <div class="mb-4">
                                            <a href="" id="btn-submit-register-otp" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Xác minh') ?></a>
                                        </div>
                                        <?php echo csrf::displayToken(); ?>
                                    </form>
                                    <div class="mt-4">
                                        <div class="re-send-otp">
                                            <div class="otp-text">
                                                <?php echo FSText::_('Gửi lại mã sau') ?> <span class="re-send-count-down text-blue"></span>
                                            </div>
                                            <div class="otp-btn">
                                                <?php echo FSText::_('Bạn không nhận đc mã?') ?> <a href="" id="btn-re-send-otp" class="fw-medium text-blue"><?php echo FSText::_('Gửi lại mã') ?></a>
                                            </div>
                                        </div>
                                        <div><?php echo FSText::_('Mã xác minh có hiệu lực trong 15 phút') ?></div>
                                    </div>
                                </div>
                            </div>

                            <div class="layout-modal layout-register-password" style="display: none;">
                                <a href="" class="modal-member-tab" data="register-telephone">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.9998 19.92L8.47984 13.4C7.70984 12.63 7.70984 11.37 8.47984 10.6L14.9998 4.07996" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-2 mt-5">
                                    <h4 class="fs-4 m-0"><?php echo FSText::_('Thiết lập mật khẩu') ?></h4>
                                </div>
                                <div class="mb-5">
                                    <?php echo FSText::_('Bước cuối!') ?> <br>
                                    <?php echo FSText::_('Thiết lập mật khẩu để hoàn tất việc đăng ký') ?>
                                </div>
                                <form action="" method="POST" id="form-register-password">
                                    <div class="mb-2 d-flex align-items-center justify-content-center gap-4 position-relative">
                                        <input type="password" class="form-control" name="passwordregister" autocomplete placeholder="<?php echo FSText::_('Mật khẩu') ?>">
                                        <a href="" class="toggle-password">
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="mb-2 mt-3 password-rule lowercase-rule">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Ít nhất một ký tự viết thường.
                                    </div>
                                    <div class="mb-2 password-rule uppercase-rule">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        Ít nhất một ký tự viết hoa.
                                    </div>
                                    <div class="mb-2 password-rule min-rule">
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        8 ký tự trở lên.
                                    </div>
                                    <div class="mt-4">
                                        <a href="" id="btn-submit-register-password" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium">
                                            <?php echo FSText::_('Đăng ký') ?>
                                        </a>
                                    </div>
                                    <?php echo csrf::displayToken(); ?>
                                </form>
                            </div>

                            <div class="layout-modal layout-register-success" style="display: none;">
                                <div class="text-center mb-5">
                                    <svg width="56" height="56" viewBox="0 0 56 56" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.0837 28.0001L24.687 34.6034L37.917 21.3967M28.0003 51.3334C40.8337 51.3334 51.3337 40.8334 51.3337 28.0001C51.3337 15.1667 40.8337 4.66675 28.0003 4.66675C15.167 4.66675 4.66699 15.1667 4.66699 28.0001C4.66699 40.8334 15.167 51.3334 28.0003 51.3334Z" stroke="#3BA500" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <div class="fs-4 register-success-message mb-5 text-center"></div>
                                <div class="mb-4 text-center">
                                    Bạn đã tạo thành công tài khoản ShopUSA với số <br>
                                    <b class="register-success-telephone"></b>
                                </div>
                                <div class="mb-4 text-center">
                                    Bạn sẽ được chuyển hướng đến ShopUSA trong 10 giây.
                                </div>
                                <a href="<?php echo URL_ROOT ?>" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Quay lại trang chủ') ?></a>
                            </div>

                            <div class="layout-modal layout-password" style="display: none;">
                                <a href="" class="modal-member-tab" data="login">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.9998 19.92L8.47984 13.4C7.70984 12.63 7.70984 11.37 8.47984 10.6L14.9998 4.07996" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>
                                <div class="d-flex align-items-center justify-content-between mb-2 mt-5">
                                    <h4 class="fs-4 m-0"><?php echo FSText::_('Quên mật khẩu?') ?></h4>
                                </div>
                                <div class="mb-5"><?php echo FSText::_('Vui lòng nhập thông tin tài khoản để lấy lại mật khẩu') ?></div>
                                ádasd
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>