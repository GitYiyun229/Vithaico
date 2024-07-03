<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('dashboard', 'modules/members/assets/css');
$tmpl->addScript('default', 'modules/members/assets/js');
?>
<div class="container">
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Tài khoản của tôi') ?></div>
            <form class="page-content page-dashboard p-4 bg-white page-border-radius d-flex" method="POST" enctype="multipart/form-data">
                <div class="col-9 pe-4">
                    <div class="mb-3 fs-6 text-body-tertiary "><?php echo FSText::_('Thông tin tài khoản') ?></div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="name" class="col-3"><?php echo FSText::_('Họ và tên') ?></label>
                        <div class="col-9">
                            <input type="text" class="form-control" placeholder="<?php echo FSText::_('Họ và tên') ?>" name="name" id="name" value="<?php echo $user->userInfo->full_name ?>">
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="sex" class="col-3"><?php echo FSText::_('Giới tính') ?></label>
                        <div class="col-9 d-flex align-items-center gap-4">
                            <?php foreach ($sex as $i => $item) { ?>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="sex" id="sex<?php echo $i ?>" value="<?php echo $i ?>" <?php echo $i == $user->userInfo->sex ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="sex<?php echo $i ?>">
                                        <?php echo $item ?>
                                    </label>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="birthday" class="col-3"><?php echo FSText::_('Ngày sinh') ?></label>
                        <div class="col-9">
                            <input type="date" class="form-control" name="birthday" id="birthday" value="<?php echo $user->userInfo->birthday ? date('Y-m-d', strtotime($user->userInfo->birthday)) : '' ?>">
                        </div>
                    </div>

                    <div class="mb-3 mt-5 fs-6 text-body-tertiary "><?php echo FSText::_('Thông tin đăng nhập') ?></div>

                    <div class="d-flex align-items-center justify-content-between mb-3 custom">
                        <span class="textgrey col-2"><?php echo FSText::_('Số điện thoại') ?></span>
                        <span class="col-8"><?php echo $user->userInfo->telephone ?></span>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalTelephone" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3 custom">
                        <span class="textgrey col-2"><?php echo FSText::_('Email') ?></span>
                        <span class="col-8"><?php echo $user->userInfo->email ?></span>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalEmail" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                    </div>
                    <?php if (!$user->userInfo->type) { ?>
                        <div class="d-flex align-items-center justify-content-between mb-3 custom">
                            <span class="textgrey col-2"><?php echo FSText::_('Mật khẩu') ?></span>
                            <span class="col-8">****************</span>
                            <a href="" data-bs-toggle="modal" data-bs-target="#modalPassword" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                        </div>
                    <?php } ?>
                    <div class="text-end mt-5">
                        <a href="" class="btn-submit submit-dashboard d-inline-block"><?php echo FSText::_('Lưu thay đổi') ?></a>
                    </div>
                </div>
                <div class="col-3 ps-4">
                    <div class="">
                        <img src="<?php echo URL_ROOT . $this->userImage ?>" alt="user" class="img-fluid img-image">
                        <input type="file" class="input-upload-image d-none" name="image" id="image" accept=".png, .jpg, .jpeg" data-img="img-image">
                        <a href="" class="btn-upload-image"><?php echo FSText::_('Chọn ảnh') ?></a>
                        <div class="text-body-tertiary">Dụng lượng file tối đa 1 MB <br> Định dạng:.JPEG, .PNG</div>
                    </div>
                </div>
                <?php echo csrf::displayToken() ?>
                <input type="hidden" name="module" value="members">
                <input type="hidden" name="view" value="dashboard">
                <input type="hidden" name="task" value="saveDashboard">
                <input type="hidden" name="id" value="<?php echo $user->userID ?>">
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-change" id="modalTelephone" tabindex="-1" aria-labelledby="modalTelephoneLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-step modal-step-1">
                    <h4 class="fs-4 mb-3"><?php echo FSText::_('Đổi số điện thoại') ?></h4>
                    <div class="mb-5"><?php echo FSText::_('Để đảm bảo tính bảo mật, vui lòng làm theo các bước sau để đổi số điện thoại.') ?></div>
                    <div class="mb-4">
                        <input type="text" class="form-control" name="telephone" id="telephone" autocomplete placeholder="<?php echo FSText::_('Nhập số điện thoại của bạn') ?>">
                    </div>
                    <div class="">
                        <a href="" id="btn-submit-telephone" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Nhận mã xác minh') ?></a>
                    </div>
                </div>

                <div class="modal-step modal-step-2" style="display: none;">
                    <div class="mb-5">
                        <a href="" class="modal-back">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9998 19.92L8.47984 13.4C7.70984 12.63 7.70984 11.37 8.47984 10.6L14.9998 4.07996" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                    <h4 class="fs-4 mb-3"><?php echo FSText::_('Nhập mã xác minh') ?></h4>
                    <div class="mb-5">Để xác minh số điện thoại là của bạn, nhập mã xác minh gồm 6 số vừa được gửi đến <b class="telephone-change-text"></b></div>
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
                        <a href="" id="btn-submit-telephone-otp" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Xác minh') ?></a>
                    </div>
                    <div class="mt-4">
                        <div class="re-send-otp">
                            <div class="otp-text">
                                <?php echo FSText::_('Gửi lại mã sau') ?> <span class="re-send-count-down text-blue"></span>
                            </div>
                            <div class="otp-btn">
                                <?php echo FSText::_('Bạn không nhận đc mã?') ?> <a href="" class="btn-re-send-otp fw-medium text-blue"><?php echo FSText::_('Gửi lại mã') ?></a>
                            </div>
                        </div>
                        <div><?php echo FSText::_('Mã xác minh có hiệu lực trong 15 phút') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-change" id="modalEmail" tabindex="-1" aria-labelledby="modalEmailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-5">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-step modal-step-1">
                    <h4 class="fs-4 mb-3"><?php echo FSText::_('Đổi email') ?></h4>
                    <div class="mb-5"><?php echo FSText::_('Để đảm bảo tính bảo mật, vui lòng làm theo các bước sau để đổi email.') ?></div>
                    <div class="mb-4">
                        <input type="email" class="form-control" name="email" id="email" autocomplete placeholder="<?php echo FSText::_('Nhập email của bạn') ?>">
                    </div>
                    <div class="">
                        <a href="" id="btn-submit-email" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Nhận mã xác minh') ?></a>
                    </div>
                </div>

                <div class="modal-step modal-step-2" style="display: none;">
                    <div class="mb-5">
                        <a href="" class="modal-back">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M14.9998 19.92L8.47984 13.4C7.70984 12.63 7.70984 11.37 8.47984 10.6L14.9998 4.07996" stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                    <h4 class="fs-4 mb-3"><?php echo FSText::_('Nhập mã xác minh') ?></h4>
                    <div class="mb-5">Để xác minh email là của bạn, nhập mã xác minh gồm 6 số vừa được gửi đến <b class="email-change-text"></b></div>
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
                        <a href="" id="btn-submit-email-otp" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Xác minh') ?></a>
                    </div>
                    <div class="mt-4">
                        <div class="re-send-otp">
                            <div class="otp-text">
                                <?php echo FSText::_('Gửi lại mã sau') ?> <span class="re-send-count-down text-blue"></span>
                            </div>
                            <div class="otp-btn">
                                <?php echo FSText::_('Bạn không nhận đc mã?') ?> <a href="" class="btn-re-send-otp fw-medium text-blue"><?php echo FSText::_('Gửi lại mã') ?></a>
                            </div>
                        </div>
                        <div><?php echo FSText::_('Mã xác minh có hiệu lực trong 15 phút') ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!$user->userInfo->type) { ?>
    <div class="modal fade modal-change" id="modalPassword" tabindex="-1" aria-labelledby="modalPasswordLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-5">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <form class="modal-step" method="POST" action="">
                        <h4 class="fs-4 mb-3"><?php echo FSText::_('Đổi mật khẩu') ?></h4>
                        <div class="mb-5"><?php echo FSText::_('Để bảo mật tài khoản, vui lòng không chia sẻ mật khẩu cho người khác.') ?></div>
                        <div class="mb-3 d-flex flex-wrap align-items-center position-relative">
                            <input type="password" class="form-control" name="current_password" id="current_password" autocomplete placeholder="<?php echo FSText::_('Nhập mật khẩu hiện tại') ?>">
                            <a href="" class="toggle-password">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                        <div class="mb-3 d-flex flex-wrap align-items-center position-relative">
                            <input type="password" class="form-control" name="new_password" id="new_password" autocomplete placeholder="<?php echo FSText::_('Nhập mật khẩu mới') ?>">
                            <a href="" class="toggle-password">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div>
                        <div class="mb-3 d-flex flex-wrap align-items-center position-relative">
                            <input type="password" class="form-control" name="re_new_password" id="re_new_password" autocomplete placeholder="<?php echo FSText::_('Nhập lại mật khẩu mới') ?>">
                            <a href="" class="toggle-password">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/><path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </a>
                        </div> 
                        <div class="mb-5">
                            <div class="mb-2 mt-3 password-rule lowercase-rule">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Ít nhất một ký tự viết thường.
                            </div>
                            <div class="mb-2 password-rule uppercase-rule">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Ít nhất một ký tự viết hoa.
                            </div>
                            <div class="password-rule min-rule">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                8 ký tự trở lên.
                            </div>
                        </div>
                        <div class="">
                            <a href="" id="btn-submit-password" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Lưu thay đổi') ?></a>
                        </div>
                        <input type="hidden" name="module" value="members">
                        <input type="hidden" name="view" value="members">
                        <input type="hidden" name="task" value="updatePassword">
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>