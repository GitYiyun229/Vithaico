<?php
global $tmpl;
$tmpl->setTitle("Trang quản trị");
$tmpl->addStylesheet("users_logged", "modules/users/assets/css");
$tmpl->addScript('users_logged', 'modules/users/assets/js');
//var_dump($_SESSION);

?>
<div id="login-form" class="frame_large mt40">
    <!--    <div class="frame_head">-->
    <!--			<h1>Quản lý tài khoản</h1>-->
    <!--	</div>-->
    <div class="frame_body row">
        <div class='col-lg-3'>
            <?php include_once 'left_user.php' ?>
        </div>
        <div class='col-lg-9 hidden-xs'>
            <div id='tab_content' class='tab_content'>
                <h2 class='head_content'>
                    Trang quản trị
                </h2>
                <div class="tab_content_inner">
                    Chào mừng các bạn đã đăng nhập vào hệ thống.
                </div>
            </div>
        </div>
    </div>
</div>    
        
        