<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';

class MembersControllersAddress extends MembersControllersMembers
{
    public function display()
    {
        global $tmpl, $user, $config;

        $tmpl->addTitle(FSText::_('Sổ địa chỉ'));

        $province = $this->model->get_records('', 'fs_provinces', 'code, name, code_name', 'code_name ASC');
        $list = $this->model->get_records("member_id = $user->userID", 'fs_members_address', '*', '`default` DESC, id DESC');
        if (!empty($list)) {
            foreach ($list as $item) {
                $arrProvince[] = $item->province_id;
            }
            $arrProvince = implode(',', $arrProvince);
            $district = $this->model->get_records("province_code IN ($arrProvince)", 'fs_districts', 'code, name, code_name, province_code', 'code_name ASC');

            foreach ($district as $item) {
                $arrDistrict[] = $item->code;
            }
            $arrDistrict = implode(',', $arrDistrict);
            $ward = $this->model->get_records("district_code IN ($arrDistrict)", 'fs_wards', 'code, name, code_name, district_code', 'code_name ASC');

            foreach ($list as $item) {
                foreach ($province as $provinceItem) {
                    if ($item->province_id == $provinceItem->code) {
                        $item->province_name = $provinceItem->name;
                        break;
                    }
                }
                foreach ($district as $districtItem) {
                    if ($item->district_id == $districtItem->code) {
                        $item->district_name = $districtItem->name;
                        break;
                    }
                }
                foreach ($ward as $wardItem) {
                    if ($item->ward_id == $wardItem->code) {
                        $item->ward_name = $wardItem->name;
                        break;
                    }
                }
            }
        }

        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }

    public function saveAddress()
    {
        $this->auth('POST');
        global $user;

        $id = FSInput::get('id');
        $name = FSInput::get('name');
        $telephone = FSInput::get('telephone');
        $address = FSInput::get('address');
        $province_id = FSInput::get('province');
        $district_id = FSInput::get('district');
        $ward_id = FSInput::get('ward');
        $default = FSInput::get('default', 0, 'int');
        $member_id = $user->userID;
        $redirect = FSInput::get('redirect');

        if (!$name || !$telephone || !$address || !$province_id || !$district_id || !$ward_id) {
            $response = [
                'error' => true,
                'message' => 'Các trường không được bỏ trống!'
            ];
            echo json_encode($response);
            exit;
        }

        $row = compact('name', 'telephone', 'address', 'province_id', 'district_id', 'ward_id', 'default', 'member_id');          
         
        if ($default != 0 && $default != false) {
            $this->model->_update(['default' => 0], 'fs_members_address', "member_id = $user->userID");
        }

        if ($id) {
            $rs = $this->model->_update($row, 'fs_members_address', "id = $id");
        } else {
            $rs = $this->model->_add($row, 'fs_members_address');
        }

        $messageSuccess = $id ? 'Chỉnh sửa địa chỉ thành công!' : 'Thêm địa chỉ thành công!';
        $messageError = $id ? 'Chỉnh sửa địa chỉ không thành công!' : 'Thêm địa chỉ không thành công!';

        $row['id'] = $rs;

        if (!$redirect) {
            $province = $this->model->get_records('', 'fs_provinces', 'code, name, code_name', 'code_name ASC');
            $district = $this->model->get_records('province_code = "'.$province_id.'"', 'fs_districts', 'code, name, code_name', 'code_name ASC');
            $ward = $this->model->get_records('district_code = "'.$district_id.'"', 'fs_wards', 'code, name, code_name', 'code_name ASC');

            $row['province'] = $province;
            $row['district'] = $district;
            $row['ward'] = $ward;
        }

        $response = [
            'error' => false,
            'message' => $messageSuccess,
            'data' => $row
        ];

        if (!$rs) {
            $response = [
                'error' => true,
                'message' => $messageError
            ];
        }

        if ($redirect) {
            setRedirect($redirect, $response['message'], $response['error'] ? 'error' : 'success');
        }
        
        echo json_encode($response);
        exit;
    }

    public function removeAddress()
    {
        $this->auth('POST');
        $id = FSInput::get('id');

        $response = [
            'error' => false,
            'message' => 'Xóa địa chỉ không thành công!'
        ];
        $sql = "DELETE FROM fs_members_address WHERE id = $id";

		global $db;
		$rows = $db->affected_rows($sql);

        if (!$rows) {
            $response = [
                'error' => true,
                'message' => 'Xóa địa chỉ không thành công!'
            ];
        }

        echo json_encode($response);
        exit;
    }
}
