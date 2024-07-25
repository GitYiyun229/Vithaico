<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addScript('default', 'modules/members/assets/js');

?>

<div class="container">
    <div class="page-member">
        <div class="mb-3">
            <?php include PATH_BASE . 'modules/members/views/level.php' ?>
        </div>
        <div class="page-side">
            <div class="page-sidebar">
                <?php require_once('sidebar.php'); ?>
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
                            <input type="date" class="form-control" name="birthday" id="birthday" value="<?php echo date('Y-m-d', strtotime($user->userInfo->birthday)) ?>">
                        </div>
                    </div>

                    <div class="mb-3 mt-5 fs-6 text-body-tertiary "><?php echo FSText::_('Thông tin đăng nhập') ?></div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="textgrey col-2"><?php echo FSText::_('Số điện thoại') ?></span>
                        <span class="col-8"><?php echo $user->userInfo->telephone ?></span>
                        <a href="" data-bs-toggle="modal" data-bs-target="#modalTelephone" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="textgrey col-2"><?php echo FSText::_('Email') ?></span>
                        <span class="col-8"><?php echo $user->userInfo->email ?></span>
                        <a href="" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="textgrey col-2"><?php echo FSText::_('Mật khẩu') ?></span>
                        <span class="col-8">****************</span>
                        <a href="" class="text-red col-1"><?php echo FSText::_('Thay đổi') ?></a>
                    </div>
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
                <input type="hidden" name="view" value="members">
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

                <h4 class="fs-4 mb-3"><?php echo FSText::_('Đổi số điện thoại') ?></h4>
                <div class="mb-5"><?php echo FSText::_('Để đảm bảo tính bảo mật, vui lòng làm theo các bước sau để đổi số điện thoại.') ?></div>
                <form action="" method="POST" id="form-register">
                    <div class="mb-4">
                        <input type="text" class="form-control" name="tel_change" id="tel_change" autocomplete placeholder="<?php echo FSText::_('Nhập số điện thoại của bạn') ?>">
                    </div>
                    <div class="">
                        <a href="" id="btn-submit-register-telephone" class="form-submit text-uppercase d-flex align-items-center justify-content-center fw-medium"><?php echo FSText::_('Tiếp theo') ?></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>