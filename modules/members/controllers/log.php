<?php 

class MembersControllersLog extends FSControllers
{
    public static function auth($method)
    { 
        if (($_SERVER['REQUEST_METHOD'] != $method) || !csrf::authenticationToken()) {
            echo json_encode([
                'error' => true,
                'message' => "Lỗi", 
            ]);
            exit();
        }

        global $user;
        if ($user->userID) {
            echo json_encode([
                'error' => true,
                'message' => "Vui lòng đăng xuất để sử dụng chức năng!", 
            ]);
            exit();
        }


        return true;
    }

    public function login()
    {
        $this->auth('POST');

        $response = [
            'error' => false,
            'message' => FSText::_('Đăng nhập tài khoản thành công!')
        ];

        $userlog = FSInput::get('userlog');
        $passlog = FSInput::get('passlog');
        $redirect = FSInput::get('redirect');

        if (!$userlog || !$passlog) {
            $response = [
                'error' => true,
                'message' => FSText::_('Số điện thoại, Mật khẩu không được bỏ trống!')
            ];
            goto exitFUnc;
        }
        global $user;

        if (!$user->login($userlog, $passlog)) {
            $response = [
                'error' => true,
                'message' => FSText::_('Tài khoản hoặc mật khẩu không chính xác!')
            ];
        }

        $_SESSION['have_redirect'] = 1;
        $_SESSION["msg_success"] = [FSText::_('Đăng nhập tài khoản thành công!')];
        $response['redirect'] = $redirect;

        exitFUnc:
        echo json_encode($response);
        exit;
    }

    public function logout()
    {
        global $user;
        $_SESSION['have_redirect'] = 1;
        $_SESSION["msg_success"] = [FSText::_('Đăng xuất tài khoản thành công!')];
        $user->logouts(URL_ROOT);
    }
}