<?php
global $tmpl;
$tmpl->addStylesheet("login", "modules/users/assets/css");
$tmpl->addScript('form');
$tmpl->addScript('users_login_register', 'modules/users/assets/js');
?>
<div id="login-register" class="mt40">
    <div class="frame_body">
        <div class=" col-signin">
            <h1 class="title_form">Đăng nhập số điện thoại </br>
                Để xem lịch sử mua hàng và chi tiêu tích lũy của bạn
            </h1>
            <form action="" name="login_form" class="form"
                  method="post">
                <div class="fieldset_item_row">
                    <div class="form_name">
                        Số điện thoại
                    </div>
                    <div class="value">
                        <input class="txtinput" id="telephone" type="tel" size="30" name="telephone" value=""/>
                    </div>
                </div>
                <div class="fieldset_item_row">
                    <div class="form_name">
                        Email
                    </div>
                    <div class="value">
                        <input class="txtinput" id="email" type="email" size="30" name="email" value="">
                    </div>
                </div>
                <div class="fieldset_item_row">
                    <div class="form_name">
                    </div>
                    <div class="value">
                        <a class="submitbt btn  signin-submit" href="javascript: void(0)">
                            <span><?php echo FSText::_("Tiếp tục"); ?></span>
                        </a>
                    </div>
                </div>
                <input type="hidden" name="module" value="users"/>
                <input type="hidden" name="view" value="users"/>
                <input type="hidden" name="task" value="check_htsoft"/>
            </form>
        </div>
    </div>
</div>

