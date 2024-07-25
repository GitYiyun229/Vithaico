<?php
global $tmpl, $config;
$tmpl->addStylesheet('forgot', 'modules/members/assets/css');
?>
<div class="main-forgot">
    <div class="container">
        <div class="box-main-forgot m-auto">
            <div class="box-img-register text-center mb-5">
                <img src="/modules/members/assets/images/Group 433.svg">
            </div>
            <h5 class="title-forget text-center text-uppercase fw-bold mb-4 "><?= FSText::_('Quên mật khẩu') ?></h5>
            <p class="text-center mb-4"><?= FSText::_('Nhập email của bạn để lấy lại tài khoản của bạn') ?></p>
            <form action="" method="POST" class="frmForgot" id="frmForgot">
                <div class="box mb-3">
                    <input type="text" class="form-control" name="forgot_email" id="forgot_email" placeholder="<?php echo FSText::_('Email của bạn') ?>">
                </div>
                <div class="forgot-form text-center mt-4">
                    <a href="javascript:void(0)" class="submitForgot text-uppercase">
                        <?php echo FSText::_('Tiếp tục') ?>
                    </a>
                </div>
                <input type="hidden" name="module" value="members">
                <input type="hidden" name="view" value="user">
                <input type="hidden" name="task" value="forget_save">
            </form>
        </div>
    </div>
</div>