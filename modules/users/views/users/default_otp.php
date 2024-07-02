<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 5/17/2021
 * Time: 1:54 PM
 */
global $tmpl;
$tmpl->addStylesheet("otp", "modules/users/assets/css");
$tmpl->addStylesheet("login", "modules/users/assets/css");
$tmpl->addScript('users_login_register', 'modules/users/assets/js');
//var_dump($_SESSION['otp']);
?>
<?php
if (!@$_SESSION['user_phone']) { ?>
    <div class="popup_erro">
        <div class="top_pop">
            <span>!</span>
        </div>
        <div class="body_pop">
            <h1>Bạn chưa là thành viên của 24hstore</h1>
        </div>
    </div>
<?php } elseif (@$_SESSION['user_phone']) {?>
    <div class="frame_body">
        <div class=" col-signin">
            <h1 class="title_form">Mã xác nhận sẽ được gửi đến email của bạn</h1>
            <form action="" name="otp_form" class="form"
                  method="post">
                <div class="fieldset_item_row">
                    <div class="form_name">
                        Nhập mã xác nhận
                    </div>
                    <div class="value">
                        <input class="txtinput" id="otp" type="tel" size="30" name="otp" value=""/>
                    </div>
                </div>
                <div class="fieldset_item_row">
                    <div class="form_name">
                    </div>
                    <div class="value">
                        <a class="submitbt btn  sbm_otp" href="javascript: void(0)">
                            <span><?php echo FSText::_("Tiếp tục"); ?></span>
                        </a>
                    </div>
                </div>
                <input type="hidden" name="module" value="users"/>
                <input type="hidden" name="view" value="users"/>
                <input type="hidden" name="task" value="login_save"/>
<!--                <input type="hidden" name="otp1" value="--><?php //echo $otp ?><!--"/>-->
            </form>
        </div>
    </div>
<?php } ?>
