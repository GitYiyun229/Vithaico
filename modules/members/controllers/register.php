<?php

class MembersControllersRegister extends FSControllers
{
    public function __construct()
    {
        parent::__construct();
        $this->auth('POST');
    }

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

    public function sendOTP($telephone, $otp)
    {
        if (!$telephone || !$otp) {
            return false;
        }

        # send otp with $_SESSION['register']['telephone'] && $_SESSION['register']['otp']

        return true;
    }

    public function reSendOTP()
    {
        $response = [
            'error' => false,
            'message' => FSText::_('Thành công!'),
        ];

        if (empty($_SESSION['register'])) {
            $response = [
                'error' => true,
                'message' => FSText::_('Số điện thoại không được để trống!'),
            ];
        }

        $currentTime = time();
        $created_time = strtotime($_SESSION['register']['created_time']);

        if ($currentTime - $created_time < 60) {
            $response = [
                'error' => true,
                'message' => FSText::_('Thử lại chức năng sau 1 phút!'),
            ];
        }

        $_SESSION['register']['otp'] = '123456';

        if (!$this->sendOTP($_SESSION['register']['telephone'], $_SESSION['register']['otp'])) {
            $response = [
                'error' => true,
                'message' => FSText::_('Không gửi được OTP. Vui lòng thử lại sau!'),
            ];
        }

        echo json_encode($response);
        exit;
    }

    public function registerTelephone()
    {
        $telephone = FSInput::get('telregister');
        $otp = '123456';
        $created_time = date('Y-m-d H:i:s');

        $_SESSION['register'] = compact('telephone', 'otp', 'created_time');

        $exist = $this->model->get_records("telephone = '$telephone'", 'fs_members');

        if ($exist) {
            echo json_encode([
                'error' => true,
                'message' => "Số điện thoại $telephone đã được đăng ký trước đó!",
            ]);
        } elseif ($this->sendOTP($telephone, $otp)) {
            echo json_encode([
                'error' => false,
                'message' => FSText::_('Gửi OTP thành công!'),
                'created_time' => $created_time,
                're_send_time' => date('Y-m-d H:i:s', strtotime('+1 minute', strtotime($created_time)))
            ]);
        } else {
            echo json_encode([
                'error' => true,
                'message' => FSText::_('Không gửi được OTP. Vui lòng thử lại sau!'),
            ]);
        }

        exit;
    }

    public function registerOTP()
    {

        $otp = FSInput::get('otp', [], 'array');
        $otp = implode('', $otp);

        $currentTime = time();
        $created_time = strtotime($_SESSION['register']['created_time']);

        $error = false;
        $message = FSText::_('Thành công!');

        if (!$otp || empty($_SESSION['register']) || $otp != $_SESSION['register']['otp']) {
            $error = true;
            $message = !$otp || empty($_SESSION['register'])
                ? FSText::_('OTP hoặc số điện thoại không được để trống!')
                : FSText::_('OTP không đúng. Vui lòng nhập lại!');
        } else if ($currentTime - $created_time > 900) {
            $error = true;
            $message = FSText::_('OTP đã quá hạn. Vui lòng bấm gửi lại mã để nhận OTP mới!');
        }

        echo json_encode([
            'error' => $error,
            'message' => $message
        ]);

        exit;
    }

    public function register()
    {
        if (!csrf::authenticationToken()) {
            echo json_encode([
                'error' => true,
                'message' => "Lỗi",
            ]);
            exit();
        }

        $DataName = FSInput::get('name');
        $DataPhone = FSInput::get('phone');
        $DataEmail = FSInput::get('email');
        $DataPass = FSInput::get('password');
        $DataConfirmPass = FSInput::get('repassword');
        $affiliate = FSInput::get('affiliate');

        $response = [
            'error' => false,
            'message' => FSText::_('Đăng ký thành công!'),
        ];

        if (!$DataPass) {
            $response = [
                'type' => 'pass',
                'error' => true,
                'message' => FSText::_('Mật khẩu không được để trống!'),
            ];
            goto exitFunc;
        }

        if ($DataPass != $DataConfirmPass) {
            $response = [
                'type' => 'pass',
                'error' => true,
                'message' => FSText::_('Mật khẩu nhập lại không đúng !'),
            ];
            goto exitFunc;
        }

        $exist = $this->model->get_record("telephone = '" . $DataPhone . "' ", 'fs_members', 'id');
        if ($exist) {
            $response = [
                'type' => 'phone',
                'error' => true,
                'message' => FSText::_('Số điện thoại đã được đăng ký thành viên trước đó!'),
            ];
            goto exitFunc;
        }

        $timestamp = time();
        $row = [
            'full_name' => $DataName,
            'email' => $DataEmail,
            'telephone' => $DataPhone,
            'ref_by' => $affiliate,
            'ref_code' => $timestamp,
            'password' => md5($DataPass),
            'created_time' => date('Y-m-d H:i:s'),
            'end_time' => date('Y-m-d H:i:s', strtotime("+14 days")),
            'due_time_month' => date('Y-m-d H:i:s', strtotime("+30 days")),
            'published' => 1,
            'level' => 1,
        ];
        // print_r($row);die;
        $id = $this->model->_add($row, 'fs_members');
        if (!$id) {
            $response = [
                'error' => true,
                'message' => FSText::_('Đăng ký không thành công. Vui lòng thử lại!'),
            ];
        } else {
            $row_log = [
                'user_id' => $id,
                'user_name' => $DataName,
                'telephone' => $DataPhone,
                'email' => $DataEmail,
                'level' => 1,
                'ref_by' => $affiliate,
                'created_time' => date('Y-m-d H:i:s'),
                'end_time' => date('Y-m-d H:i:s', strtotime("+14 days")),
            ];

            $id_log = $this->model->_add($row_log, 'fs_members_register_log');
            unset($_SESSION['register']);
        }

        exitFunc:
        echo json_encode($response);
        exit;
    }
}
