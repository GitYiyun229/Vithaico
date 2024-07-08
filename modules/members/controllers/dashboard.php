<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';

class MembersControllersDashboard extends MembersControllersMembers
{
    public function display()
    {
        global $tmpl, $user, $config;
     
        // $breadcrumbs = array(array(0 => FSText::_('Trang cá nhân'), 1 => ''));
        // $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->addTitle(FSText::_('Trang cá nhân'));

        $userInfo=$user->userInfo;
        $where_province= $userInfo->city_id ? $userInfo->city_id : '';
        $province = $this->model->get_records($where_province, 'fs_provinces', 'code, name, code_name', 'code_name ASC');
        @$where_bank = $userInfo->bank_code ? $userInfo->bank_code : '';
        $banks = $this->model->get_records("", 'fs_banks', 'id, bank_name, bank_code', 'id ASC');

        $where_district = $userInfo->district_id ? $userInfo->district_id : '';
        $district = $this->model->get_records("province_code = '$where_province'", 'fs_districts', 'code, name, code_name, province_code');

        @$where_ward = $userInfo->ward_id ? $userInfo->ward_id : '';
        $ward = $this->model->get_records("district_code = '$where_district'", 'fs_wards', 'code, name, code_name, district_code');
        // print_r($ward);

        $sex = [
            FSText::_('Nam'),
            FSText::_('Nữ'),
            FSText::_('Khác'),
        ];

        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }

    public function saveDashboard()
    {
        $this->auth('POST');

        $id = FSInput::get('id');
        $full_name = FSInput::get('name');
        $birthday = FSInput::get('birthday');
        $sex = FSInput::get('sex');

        $city_id = FSInput::get('province');
        $district_id = FSInput::get('district');
        $ward_id = FSInput::get('ward');
        $address = FSInput::get('address');



        $bank_code = FSInput::get('bank');
        $bank_stk = FSInput::get('stk');
        $bank_name = FSInput::get('chustk');

        $return = FSRoute::_('index.php?module=members&view=dashboard');

        $member = $this->model->get_record("id = $id", $this->table);

        if (!$member) {
            setRedirect($return, "Thành viên không tồn tại!", 'error');
        }

        $row = compact('full_name', 'birthday', 'sex', 'city_id' , 'district_id', 'ward_id', 'address', 'bank_code', 'bank_name', 'bank_stk');

        $id = $this->model->_update($row, $this->table, "id = $id");

        if ($id) {
            setRedirect($return, "Cập nhật thành công!", 'success');
        } else {
            setRedirect($return, "Cập nhật không thành công!", 'error');
        }
    }
    public function saveDashboard_image()
    {
        $this->auth('POST');

        $id = FSInput::get('id');
        $return = FSRoute::_('index.php?module=members&view=dashboard');

        $member = $this->model->get_record("id = $id", $this->table);

        if (!$member) {
            setRedirect($return, "Thành viên không tồn tại!", 'error');
        }
        // print_r($_FILES['image']["name"]);die;
        if ($_FILES['image']["name"]) {
            $fsFile = FSFactory::getClass('FsFiles');
    
            $path = 'images' . DS . 'members' . DS . 'original' . DS;
    
            if (!$fsFile->create_folder($path)) {
                setRedirect($return, "Không thể tạo folder", 'error');
            } 

            if ($member->image) {
                @unlink(PATH_BASE . $member->image);
                @unlink(PATH_BASE . str_replace('.jpg', '.webp', $member->image));
                @unlink(PATH_BASE . str_replace('.png', '.webp', $member->image));
                @unlink(PATH_BASE . str_replace('.jpeg', '.webp', $member->image));
            }

            $img = $fsFile->uploadImage('image', PATH_BASE . $path, 1000000, time());
		
            $image = str_replace(DS, '/', $path) . $img;

            $row['image'] = $image;
        }       

        $id = $this->model->_update($row, $this->table, "id = $id");

        if ($id) {
            setRedirect($return, "Cập nhật thành công!", 'success');
        } else {
            setRedirect($return, "Cập nhật không thành công!", 'error');
        }
    }

    public function getChangeOTP()
    {
        $this->auth('POST');
        global $user;
        
        $telephone = FSInput::get('telephone');
        $email = FSInput::get('email');

        $response = [
            'error' => false,
            'message' => 'Thành công!'
        ];

        if (!$telephone && !$email) {
            $response = [
                'error' => true,
                'message' => 'Số điện thoại hoặc Email không được để trống!'
            ];
            goto exitFunc;
        }

        $row = array_filter(compact('telephone', 'email'));

        $member = $this->model->get_record(array_keys($row)[0] . " = '" . array_values($row)[0] . "'", $this->table);
        if ($member) {
            $response = [
                'error' => true,
                'message' => $telephone ? "Số điện thoại $telephone đã được đăng ký trước đó!" : "Email $email đã được đăng ký trước đó!"
            ];
            goto exitFunc;
        }
        
        $sessionName = $telephone ? 'changeTelephone' : 'changeEmail';
        $otp = '123456';
        $created_time = date('Y-m-d H:i:s');

        $this->sendOTP($telephone, $email, $otp);

        $_SESSION[$sessionName] = compact('otp', 'created_time');

        exitFunc:
        echo json_encode($response);
        exit;
    }

    public function saveChangeInfoDashboard()
    {
        $this->auth('POST');
        global $user;

        $telephone = FSInput::get('telephone');
        $email = FSInput::get('email');
        $otp = FSInput::get('otp', [], 'array');
        $otp = implode('', $otp);

        $response = $this->validateSaveChangeInfoDashboard($telephone, $email, $otp);

        if (!$response['error']) {
            $_SESSION['have_redirect'] = 1;
            $_SESSION["msg_success"] = [$response['message']];
        }      

        echo json_encode($response);
        exit;
    }

    public function validateSaveChangeInfoDashboard($telephone, $email, $otp)
    {
        $response = [
            'error' => false,
            'message' => 'Cập nhật thông tin thành công!'
        ];       

        if (!$telephone && !$email) {
            $response = [
                'error' => true,
                'message' => 'Số điện thoại hoặc Email không được để trống!'
            ];
            goto exitFunc;
        }

        $sessionName = $telephone ? 'changeTelephone' : 'changeEmail';

        $currentTime = time();
        $created_time = strtotime($_SESSION[$sessionName]['created_time']);

        if (!$otp || empty($_SESSION[$sessionName]) || $otp != $_SESSION[$sessionName]['otp']) {
            $response = [
                'error' => true,
                'message' => 'OTP không đúng. Vui lòng nhập lại!'
            ];
            goto exitFunc;
        }

        if ($currentTime - $created_time > 900) {
            $response = [
                'error' => true,
                'message' => 'OTP đã quá hạn. Vui lòng bấm gửi lại mã để nhận OTP mới!'
            ];
            goto exitFunc;
        }

        $row = array_filter(compact('telephone', 'email'));

        $member = $this->model->get_record(array_keys($row)[0] . " = '" . array_values($row)[0] . "'", $this->table);

        if ($member) {
            $response = [
                'error' => true,
                'message' => $telephone ? "Số điện thoại $telephone đã được đăng ký trước đó!" : "Email $email đã được đăng ký trước đó!"
            ];
            goto exitFunc;
        }

        global $user;
        if (!$this->model->_update($row, $this->table, "id = $user->userID")) {
            $response = [
                'error' => true,
                'message' => 'Cập nhật thông tin không thành công!'
            ];
        }

        exitFunc:
        return $response;
    }

    public function sendOTP($telephone, $email, $otp)
    {
        if ((!$telephone && !$email) || !$otp) {
            return false;
        }

        # send otp with $telephone & $otp

        return true;
    }

    public function reSendOTP()
    {
        
    }

    public function updatePassword()
    {
        $this->auth('POST');
        global $user;

        $password = FSInput::get('password');
        $new_password = FSInput::get('new_password');
        $re_new_password = FSInput::get('re_new_password');

        $response = [
            'error' => false,
            'message' => 'Cập nhật mật khẩu mới thành công!',
            'return' => URL_ROOT
        ];

        if (!$password || !$new_password || !$re_new_password) {
            $response = [
                'error' => true,
                'message' => 'Mật khẩu không được bỏ trống!'
            ];
            goto exitFunc;
        }

        if ($user->userInfo->password != md5($password)) {
            $response = [
                'error' => true,
                'message' => 'Mật khẩu hiện tại không đúng!'
            ];
            goto exitFunc;
        }

        if ($new_password != $re_new_password) {
            $response = [
                'error' => true,
                'message' => 'Mật khẩu nhập lại không đúng!'
            ];
            goto exitFunc;
        }

        $password = md5($new_password);
        $row = compact('password');

        if (!$this->model->_update($row, $this->table, "id = $user->userID")) {
            $response = [
                'error' => true,
                'message' => 'Cập nhật mật khẩu mới không thành công!'
            ];
        } else {
            $_SESSION['have_redirect'] = 1;
            $_SESSION["msg_success"] = [$response['message']];
            $user->logouts();
        }
        
        exitFunc:

        echo json_encode($response);
        exit;
    }
}
