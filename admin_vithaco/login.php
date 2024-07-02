<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

function login()
{
    $db = new FS_PDO();
    if (isset($_COOKIE['adLog'])) {
        $u = unserialize(base64_decode($_COOKIE['adLog']));
        $password = $u['password'];
        $username = $u['uname'];
        $query = 'SELECT u.id, u.username, u.email
                FROM fs_users AS u
                WHERE published = 1 AND  u.username = \'' . $username . '\' AND u.password = \'' . $password . '\'
                LIMIT 1';
        $user = $db->getObject($query);
        if (!$user) {
            return false;
        }
        $_SESSION['ad_logged']     = 1;
        $_SESSION['ad_userid']     = $user->id;

        $_SESSION['ad_username']   = $user->username;
        $_SESSION['ad_useremail']  = $user->email;
        return true;
    } else {
        $password = md5(FSInput::get('password'));
        $username = FSInput::get2('username');

        $query = 'SELECT u.id, u.username, u.email
                    FROM fs_users AS u
                    WHERE published = 1 AND  u.username = \'' . $username . '\' AND u.password = \'' . $password . '\'
                    LIMIT 1';

        $user = $db->getObject($query);
        if (!$user) {
            return false;
        }
        $_SESSION['ad_logged']     = 1;
        $_SESSION['ad_userid']     = $user->id;
        $_SESSION['ad_username']   = $user->username;
        $_SESSION['ad_useremail']  = $user->email;

        $cookie = base64_encode(serialize(array('uname' => $user->username, 'password' => $password, 'ad_userid' => $user->id, 'ad_useremail' => $user->email)));
        setcookie('adLog', $cookie, time() + 2592000, '/');
        return true;
    }
}

require_once("../includes/config.php");
require_once('../libraries/database/pdo.php');
require_once("includes/defines.php");
require_once("../libraries/fsinput.php");

require_once("../includes/functions.php");


session_start();
// if(isset($_SESSION['ad_logged']) && $_SESSION['ad_logged']==1)
//     header("Location: index.php");

if (isset($_COOKIE['adLog'])) {
    login();
    header("Location: index.php");
}

$action        = FSInput::get('action');
if ($action == "login") {
    if (!login()) {
        echo '<script type="text/javascript">alert(\'Thông tin đăng nhập không đúng hoặc tài khoản của bạn chưa được kích hoạt!\')</script>';
    } else {
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="copyright" content="© 2013 FinalStyle, Thiết kế website Phong Cách Số" />
    <meta name="robots" content="noindex, nofollow" />

    <!-- Bootstrap Core CSS -->
    <link href="templates/default/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="templates/default/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="templates/default/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="templates/default/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript" src="templates/default/js/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="templates/default/js/helper.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#usermane').focus();
            init_position_box($('#login-from'));
            $(window).resize(function() {
                init_position_box($('#login-from'));
            });
        });
    </script>
    <style>
        .btn-primary {
            color: #fff;
            background-color: #fe6d02;
            border-color: #f8f8f8;
        }

        .panel-default>.panel-heading {
            color: #fff;
            background-color: #61bb23;
            border-color: #ddd;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row text-center ">
            <div class="col-md-12">
                <br /><br />
                <img src="/images/user-icon.svg" />
                <h3>
                    Hệ quản trị nội dung CMS
                </h3>
            </div>
        </div>
        <div class="row ">

            <div class="col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <strong> <?php echo 'Đăng nhập' ?></strong>
                    </div>
                    <div class="panel-body">
                        <form role="form" action="login.php" method="post" name="frm_login" id="frm_login">
                            <br />
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                <input type="text" class="form-control" placeholder="username" name="username" id="username" value="" />
                            </div>
                            <div class="form-group input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input class="form-control" placeholder="Password" name="password" id="password" type="password" value="" />
                            </div>
                            <input class="btn btn-primary btn-block" type="submit" value="<?php echo 'Đăng nhập ngay bây giờ'; ?>" />
                            <input name="action" type="hidden" value="login" />
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Core JavaScript -->
    <script src="templates/default/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="templates/default/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="templates/default/dist/js/sb-admin-2.js"></script>

</body>

</html>