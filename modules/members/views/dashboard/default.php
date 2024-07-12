<?php

$tmpl->addStylesheet('select2.min');
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('dashboard', 'modules/members/assets/css');
$tmpl->addScript('select2.min');
$tmpl->addScript('default', 'modules/members/assets/js');
?>
<div class="container">
    <div>
        <?php echo $tmpl->load_direct_blocks('members', array('style' => 'default')); ?>
    </div>
    <div class="page-member">

        <div class="page-side">
            <div class="page-sidebar p-4 pb-2">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side bg-white">
            <div class="page-title mb-3 fs-5 text-uppercase"><?php echo FSText::_('Thông tin tài khoản') ?></div>
            <form class="page-content page-dashboard p-4 page-border-radius d-flex" method="POST" enctype="multipart/form-data">
                <div class="col-12 pe-4">
                    <div class="mb-3 fs-6 text-body-tertiary text-uppercase "><?php echo FSText::_('Thông tin cá nhân') ?></div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="name" class="col-3"><?php echo FSText::_('Họ và tên') ?></label>
                        <div class="col-9">
                            <input type="text" class="form-control" placeholder="<?php echo FSText::_('Họ và tên') ?>" name="name" id="name" value="<?php echo $user->userInfo->full_name ?>">
                        </div>
                    </div>

                    <div class="d-flex align-items-center mb-3 ">
                        <label for="address" class="col-3"><?php echo FSText::_('Địa chỉ') ?></label>
                        <div class="col-9 d-flex align-items-center mb-3 gap-2 address-dashboard">
                            <div class="col-4">
                                <select name="province" class="form-control form-select2 form-province">
                                    <option value="0"><?php echo FSText::_('Tỉnh/TP') ?></option>
                                    <?php foreach ($province as $item) { ?>
                                        <option value="<?php echo $item->code ?>" <?php echo $where_province == $item->code ? 'selected'  : '' ?>><?php echo $item->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-4 ">
                                <select name="district" class="form-control form-select2 form-district">
                                    <?php if (empty($where_province)) { ?>
                                        <option value="0"><?php echo FSText::_('Quận/Huyện') ?></option>
                                    <?php } else { ?>
                                        <?php foreach ($district as $districtItem) {
                                        ?>
                                            <option value="<?php echo $districtItem->code ?>" <?php echo $where_district == $districtItem->code ? 'selected' : '' ?>><?php echo $districtItem->name ?></option>
                                        <?php }
                                        ?>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-4">
                                <select name="ward" class="form-control form-select2 form-ward">
                                    <?php if (empty($where_province)) { ?>
                                        <option value="0"><?php echo FSText::_('Phường/Xã') ?></option>
                                    <?php } else { ?>
                                        <?php foreach ($ward as $wardItem) {
                                        ?>
                                            <option value="<?php echo $wardItem->code ?>" <?php echo $wardItem->code == $where_ward ? 'selected' : '' ?>><?php echo $wardItem->name ?></option>
                                        <?php }
                                        ?>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                    </div>
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="address" class="col-3"><?php echo FSText::_('') ?></label>
                        <div class="col-9">
                            <div class="col">
                                <input type="text" class="form-control" name="address" placeholder="Địa chỉ (Ví dụ: Số 23, ngõ 66, hồ tùng mậu)">
                            </div>
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
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <label for="link_aff" class="col-3"><?php echo FSText::_('Link giới thiệu') ?></label>
                        <div class="col-9">
                            <div class="col ref_code copy position-relative">
                                <input type="text" value="<?php echo FSRoute::_('index.php?module=members&view=user&task=register') . '?affpiliate=' . $user->userInfo->ref_code ?>" class="form-control link_aff_copy" id="link_aff" name="link_aff">
                                <div onclick="myFunction()" class="position-absolute top-50 end-0 translate-middle-y px-4">
                                    <img src="/modules/members/assets/images/icon-copy.svg" alt="img-copy">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-bottom mt-5 d-flex align-items-center mb-3 flex-wrap">
                        <div class="col-6 pe-5">
                            <div class="mb-3 fs-6 text-body-tertiary text-uppercase"><?php echo FSText::_('Thông tin nhận hoa hồng') ?></div>
                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <label for="bank" class="col-3"><?php echo FSText::_('Ngân hàng') ?></label>
                                <div class="col-9">
                                    <select name="bank" class="form-control form-select2 form-bank">

                                        <?php if (empty($where_province)) { ?>
                                            <option value="0"><?php echo FSText::_('Chọn ngân hàng ') ?></option>
                                        <?php } else { ?>
                                            <?php foreach ($banks as $bank) {
                                            ?>
                                                <option value="<?php echo $bank->bank_code ?>" <?php echo $bank->bank_code == $where_bank ? 'selected' : '' ?>><?php echo $bank->bank_name ?></option>
                                            <?php }
                                            ?>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <label for="stk" class="col-3"><?php echo FSText::_('Số tài khoản') ?></label>
                                <div class="col-9">
                                    <input type="text" class="form-control" placeholder="<?php echo FSText::_('Số tài khoản') ?>" name="stk" id="stk" value="">
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-3 flex-wrap">
                                <label for="chutk" class="col-3"><?php echo FSText::_('Chủ tài khoản') ?></label>
                                <div class="col-9">
                                    <input type="text" class="form-control" placeholder="<?php echo FSText::_('Họ và tên STK') ?>" name="chutk" id="chutk" value="">
                                </div>
                            </div>
                        </div>
                        <div class="col-6 ps-5">
                            <div class="mb-3 fs-6 text-body-tertiary text-uppercase "><?php echo FSText::_('Thông tin đăng nhập') ?></div>
                            <div class="d-flex align-items-center  mb-3 flex-wrap custom">
                                <label for="stk_telephone" class="col-3"><?php echo FSText::_('Số điện thoại') ?></label>
                                <span class="col-9"><?php echo $user->userInfo->telephone ?></span>
                            </div>
                            <div class="d-flex align-items-center  mb-3 flex-wrap custom">
                                <label for="email" class="col-3"><?php echo FSText::_('Email') ?></label>
                                <span class="col-9"><?php echo $user->userInfo->email ?></span>
                            </div>
                            <?php if (!$user->userInfo->type) { ?>
                                <div class="d-flex align-items-center  mb-3  custom">
                                    <label for="email" class="col-3"><?php echo FSText::_('Mật khẩu') ?></label>
                                    <span class="col-7">****************</span>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#modalPassword" class="text-red col-3"><?php echo FSText::_('Thay đổi') ?></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="text-end mt-5">
                        <a href="" class="btn-submit submit-dashboard d-inline-block"><?php echo FSText::_('Cập nhật') ?></a>
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
                            <a href="" class="toggle-password position-absolute end-0">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="mb-3 d-flex flex-wrap align-items-center position-relative">
                            <input type="password" class="form-control" name="new_password" id="new_password" autocomplete placeholder="<?php echo FSText::_('Nhập mật khẩu mới') ?>">
                            <a href="" class="toggle-password position-absolute end-0">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="mb-3 d-flex flex-wrap align-items-center position-relative">
                            <input type="password" class="form-control" name="re_new_password" id="re_new_password" autocomplete placeholder="<?php echo FSText::_('Nhập lại mật khẩu mới') ?>">
                            <a href="" class="toggle-password position-absolute end-0">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.68634 6.31337L6.31301 9.68671M9.68634 6.31337C9.25301 5.88004 8.65967 5.61337 7.99967 5.61337C6.67967 5.61337 5.61301 6.68004 5.61301 8.00004C5.61301 8.66004 5.87967 9.25337 6.31301 9.68671M9.68634 6.31337L14.6663 1.33337M6.31301 9.68671L1.33301 14.6667M11.8797 3.84671C10.713 2.96671 9.37967 2.48671 7.99967 2.48671C5.64634 2.48671 3.45301 3.87337 1.92634 6.27337C1.32634 7.21337 1.32634 8.79337 1.92634 9.73337C2.45301 10.56 3.06634 11.2734 3.73301 11.8467M5.61301 13.02C6.37301 13.34 7.17967 13.5134 7.99967 13.5134C10.353 13.5134 12.5463 12.1267 14.073 9.72671C14.673 8.78671 14.673 7.20671 14.073 6.26671C13.853 5.92004 13.613 5.59337 13.3663 5.28671M10.3397 8.46671C10.1663 9.40671 9.39967 10.1734 8.45967 10.3467" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg style="display: none;" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M10.3866 7.99998C10.3866 9.31998 9.3199 10.3866 7.9999 10.3866C6.6799 10.3866 5.61323 9.31998 5.61323 7.99998C5.61323 6.67998 6.6799 5.61331 7.9999 5.61331C9.3199 5.61331 10.3866 6.67998 10.3866 7.99998Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M7.9999 13.5133C10.3532 13.5133 12.5466 12.1266 14.0732 9.72665C14.6732 8.78665 14.6732 7.20665 14.0732 6.26665C12.5466 3.86665 10.3532 2.47998 7.9999 2.47998C5.64656 2.47998 3.45323 3.86665 1.92656 6.26665C1.32656 7.20665 1.32656 8.78665 1.92656 9.72665C3.45323 12.1266 5.64656 13.5133 7.9999 13.5133Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </div>
                        <div class="mb-5">
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
                            <div class="password-rule min-rule">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.52116 6.99996L6.17199 8.65079L9.47949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#3BA500" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M5.34949 8.65079L8.65116 5.34913M8.65116 8.65079L5.34949 5.34913M7.00033 12.8333C10.2087 12.8333 12.8337 10.2083 12.8337 6.99996C12.8337 3.79163 10.2087 1.16663 7.00033 1.16663C3.79199 1.16663 1.16699 3.79163 1.16699 6.99996C1.16699 10.2083 3.79199 12.8333 7.00033 12.8333Z" stroke="#E71313" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                8 ký tự trở lên.
                            </div>
                        </div>
                        <div class="">
                            <a href="" id="btn-submit-password" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Lưu thay đổi') ?></a>
                        </div>
                        <!-- <input type="hidden" name="module" value="members">
                        <input type="hidden" name="view" value="members">
                        <input type="hidden" name="task" value="updatePassword"> -->
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<script>
    function myFunction() {
        var copyText = document.getElementById("link_aff");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value);
        flashMessage('', 'Copy link thành công !');
    }
</script>