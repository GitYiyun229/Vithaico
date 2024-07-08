<?php
// controller
class ContactControllersContact extends FSControllers
{

    function display()
    {
        $model = $this->model;
        // $city = $model->get_city();
        // $training_center = $model->get_training_center();
        $title_home_everywhere = FSText::_('Liên hệ');
        $breadcrumbs = [];
        $breadcrumbs[] = array(0 => FSText::_('Trang chủ'), 1 => FSRoute::_('index.php?module=home&view=home'));
        $breadcrumbs[] = array(0 => FSText::_('Liên hệ'), 1 => '');

        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->assign('title_home_everywhere', $title_home_everywhere);
        $tmpl->set_seo_special();
        include 'modules/' . $this->module . '/views/' . $this->view . '/' . 'default.php';
    }

    function my_array_unique($array, $keep_key_assoc = false)
    {
        $duplicate_keys = array();
        $tmp = array();

        foreach ($array as $key => $val) {
            if (is_object($val))
                $val = (array)$val;

            if (!in_array($val, $tmp))
                $tmp[] = $val;
            else
                $duplicate_keys[] = $key;
        }

        foreach ($duplicate_keys as $key)
            unset($array[$key]);

        return $keep_key_assoc ? $array : array_values($array);
    }
    /*
     * save contact
     */
    function save()
    {
        $model = $this->model;

        $name = FSInput::get('c_name');
        $phone = FSInput::get('c_telephone');
        $email = FSInput::get('c_email');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $content = FSInput::get('c_content');
            $address = FSInput::get('c_address');
            $title = FSInput::get('c_title');
            // $city = FSInput::get('c_city');
            // $city_name = $this->model->get_record('id = ' . $city, 'fs_cities', 'name,id')->name;
            $row = array();
            $row['fullname'] = $name;
            $row['telephone'] = $phone;
            $row['email'] = $email;
            $row['content'] = $content;
            $row['address'] = $address;
            // $row['title'] = $title;
            // $row['city'] = $city;
            // $row['city_name'] = $city_name;
            $row['created_time'] = date('Y-m-d H:i:s');
            $row['published'] = 1;
            $id = $model->_add($row, 'fs_contact');

            if ($id) {
                setRedirect(FSRoute::_('index.php?module=contact&view=default'), 'Gửi liên hệ thành công', 'success');
            } else {
                setRedirect(URL_ROOT, 'Lỗi. Vui lòng thử lại', 'error');
            }

            // $rs = $this->sendMailFS($row);
            // if ($rs == 1) {
            //     setRedirect(FSRoute::_('index.php?module=contact&view=default'), 'Gửi liên hệ thành công', 'success');
            // } else {
            //     setRedirect(URL_ROOT, 'Lỗi. Vui lòng thử lại', 'error');
            // }
        } else {
            setRedirect(FSRoute::_('index.php?module=contact&view=default'), 'Cảm ơn bạn đã gửi thông tin liên hệ!', 'success');
        }
    }

    function save_email()
    {
        $model = $this->model;

        $email = FSInput::get('email-contact');

        $row['email'] = $email;
        $row['published'] = 1;
        $row['created_time'] = date('Y-m-d H:i:s');
        // print_r($row);die;
        $id = $model->_add($row, 'fs_contact');
        // $rs = $this->sendMailFS($email);

        if ($id) {
            setRedirect(URL_ROOT, 'Cảm ơn bạn đã gửi thông tin liên hệ!', 'success');
        } else {
            setRedirect(URL_ROOT, 'Lỗi. Vui lòng thử lại', 'error');
        }
    }

    function sendMailFS($row)
    {
        global $config, $tmpl;

        global $config, $tmpl;

        $body = '';
        $body .= '<p align="left">Bạn nhận được Liên hệ từ ' . $row['fullname'] . '</p>';
        $body .= '<p align="left">Họ tên: <span>' . $row['fullname'] . '</span></p>';
        $body .= '<p align="left">Số điện thoại: <span>' . $row['telephone'] . '</span></p>';
        $body .= '<p align="left">Email: <span>' . $row['email'] . '</span></p>';
        $body .= '<p align="left">Địa chỉ: <span>' . $row['address'] . '</span></p>';
        $body .= '<p align="left">Chủ đề: <span>' . $row['title'] . '</span></p>';
        $body .= '<p align="left">Nội dung: <span>' . $row['content'] . '</span></p>';

        $this->model->send_email1('Liên hệ ' . $row['fullname'], $body, $config['email'], $config['email'], $config['admin_email'], 0);
        return true;
    }

    function check_captcha()
    {
        $captcha = FSInput::get('txtCaptcha');

        if ($captcha == $_SESSION["security_code"]) {
            return true;
        } else {
        }
        return false;
    }

    function getmap()
    {
        $id = FSInput::get("id");
        $model = new ContactModelsContact();
        $list = $model->get_address_list2($id);
        $latitude = $list[0]->latitude;
        $longitude = $list[0]->longitude;
        $address = $model->get_address_list();
        $list_city_name = array();
        foreach ($address as $item) {
            if (!empty($item->city_id)) {
                $item->city_name = $model->get_record_by_id($item->city_id, 'fs_local_cities')->name;
            }
            if (!empty($item->city_id) && !empty($item->city_name)) {
                $list_city_name[] = array(
                    "id" => $item->city_id,
                    "name" => $item->city_name
                );
            }
        }
        $list_city_name = $this->my_array_unique($list_city_name);

        include 'modules/' . $this->module . '/views/' . $this->view . '/' . 'filter_city.php';
    }
}