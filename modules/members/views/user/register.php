<?php
global $tmpl, $config;
$tmpl->addStylesheet('register', 'modules/members/assets/css');
$ref_code = FSInput::get('affpiliate');

?>
<div class="container py-4">
    <div class="box-main-register m-auto">
        <div class="box-img-register text-center">
            <img src="<?php echo URL_ROOT . "/images/login.svg" ?>" alt="">
        </div>
        <div class="text-dk my-4">
            <h4 class="fs-4 m-0 pb-3 text-uppercase text-center"><?php echo FSText::_('Đăng ký') ?></h4>
            <p class="summary-aff text-center">
                <?php echo FSText::_('Đăng ký tham gia xây dựng hệ thống Affiliate của Vithaico, bạn sẽ được các khoản tiền thưởng, hoa hồng, lợi ích kinh tế theo Kế hoạch trả thưởng từ hoạt động kinh doanh của mình') ?>
            </p>
        </div>
        <div class="form-register-container">
            <form action="" method="POST" id="form-register">
                <div class="mb-2  position-relative">
                    <div class="input-conflix mb-3">
                        <input type="text" class="form-control" name="nameregister" id="nameregister" autocomplete placeholder="<?php echo FSText::_('Tên đầy đủ') ?>">
                    </div>
                    <div class="input-conflix mb-3">
                        <input type="tel" class="form-control" name="phoneregister" id="phoneregister" autocomplete="tel" placeholder="<?php echo FSText::_('Số điện thoại'); ?>">
                    </div>
                    <div class="input-conflix mb-3">
                        <input type="text" class="form-control" name="emailregister" id="emailregister" autocomplete placeholder="<?php echo FSText::_('Email') ?>">
                    </div>
                    <div class="mb-3 d-flex align-items-center justify-content-center w-100 position-relative">
                        <div class="w-100">
                            <input type="password" class="form-control w-100" name="passregister" id="passregister" autocomplete placeholder="<?php echo FSText::_('Mật khẩu') ?>">
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
                    </div>
                    <div class="mb-4 d-flex align-items-center justify-content-center  position-relative w-100">
                        <div class="w-100">
                            <input type="text" class="form-control w-100" name="repassregister" id="repassregister" autocomplete placeholder="<?php echo FSText::_('Nhập lại mật khẩu') ?>">
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
                    </div>
                </div>
                <div class="dieu-khoan-thanh-vien mb-3">
                    <?php echo $config['dieu_khoan'] ?>
                </div>
                <div>
                    <label class="checkbox style-c">
                        <input type="checkbox" class="check-dieukhoan" name="checkregister_text" id="checkregister_text">
                        <div class="checkbox__checkmark"></div>
                        <div class="checkbox__body">Tôi đã đọc và đồng ý các điều khoản thành viên </div>
                    </label>
                </div>
                <input type="hidden" name="affpiliate" id="affpiliate" value="<?= $ref_code ? $ref_code : ''  ?>">
                <div class="submit-register mt-3 mb-3">
                    <a href="javascript:void(0)" id="btn-submit-register" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium">
                        <?php echo FSText::_('Đăng ký') ?>
                    </a>
                </div>
                <?php echo csrf::displayToken(); ?>
            </form>
            <div class="login-res text-center d-flex gap-2 align-items-center justify-content-center">
                <p class="m-0"><?php echo FSText::_('Bạn đã có tài khoản?') ?></p> <a href="" class="fw-bold modal-member-tab text-red"><?php echo FSText::_('Đăng nhập') ?></a>
            </div>
        </div>
    </div>
</div>