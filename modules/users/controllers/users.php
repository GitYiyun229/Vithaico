<?php
/*
 * 
 */

// controller
class UsersControllersUsers extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        // call models
        $model = $this->model;
        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/log.php';
    }

//		check sđt có tồn tại trên htsoft không
    function check_htsoft()
    {
//        echo 1;die;
        $model = $this->model;
        $telephone = FSInput::get('telephone');
        $products = $this->getProductsFromHtsoft($telephone);
        $email = FSInput::get('email');
//        $_SESSION['email_user'] = $email;
        if (@$products['mobile']) {
            $_SESSION['user_phone'] = $products['mobile'];
            $_SESSION['full_name'] = $products['name'];
            $fstring = FSFactory::getClass('FSString', '', '../');
            $otp = $fstring->generateRandomin(5);
            $_SESSION['otp'] = $otp;
            $send_mail = $model->mail_to_buyer($otp, $email);

//            $link = FSRoute::_('index.php?module=users&task=logged&Itemid=37');
//            setRedirect($link);
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/default_otp.php';
    }

    function accumulation()
    {
        if (!@$_SESSION['user_phone'] && !@$_SESSION['status']) {
            $msg = "Bạn chưa đăng nhập";
            setRedirect(URL_ROOT, $msg);
        }
        $model = $this->model;
        $telephone = $_SESSION['user_phone'];
        $data = $model->get_data_();

        $products = $this->getProductsFromHtsoft($telephone);
//        $_SESSION['email_user'] = $email;
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Chi tiêu tích lũy', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/accumulation.php';
    }

    function management()
    {
        if (!@$_SESSION['user_phone'] && !@$_SESSION['status']) {
            $msg = "Bạn chưa đăng nhập";
            setRedirect(URL_ROOT, $msg);
        }
        $model = $this->model;
        $telephone = $_SESSION['user_phone'];
        $products = $this->getProductssaleFromHtsoft($telephone);
        $list_product = $products['SaleHistoryDetail'];
//        var_dump($list_product);
        $list_bill = array();
        foreach ($list_product as $item) {
//            $date = str_replace('/Date(', '', $item['NgayHD']);
//            $date = str_replace('+0700)/', '', $date);
            if (!isset($list_bill[$item['NgayHD']])) {
                $list_bill[$item['NgayHD']] = array();
            }
            $list_bill[$item['NgayHD']][] = $item;

//            var_dump($list_bill[$item['NgayHD']]);
        }
//        var_dump($list_bill);
        foreach ($list_bill as $item=>$value){
            $max_price='';
            $main_item[$item]='';
            $total1[$item]=0;
            foreach ($value as $key){
                $total1[$item] += $key['ThanhTien'];
                if ($max_price == '') {
                    $max_price = $key['ThanhTien'];
                    $main_item[$item] = $key;
                } elseif ($key['ThanhTien'] > $max_price) {
                    $max_price = $key['ThanhTien'];
                    $main_item[$item] = $key;
                }
            }
//            var_dump($item);
//            var_dump($max_price);
//            var_dump($value);
//            var_dump($total1[$item]);
        }
//        die;
//        foreach ($list_product as $item){
//        $time = str_replace(['/Date(','+0700)/'],['',''],$list_product[0]['NgayHD']);
//        }
//        $lastday = date("Y-m-d H:i:s", strtotime('1594092933517'));
//        var_dump($lastday);
//        $_SESSION['email_user'] = $email;
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Quản lý đơn hàng', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/management.php';
    }

    function warranty()
    {
        if (!@$_SESSION['user_phone'] && !@$_SESSION['status']) {
            $msg = "Bạn chưa đăng nhập";
            setRedirect(URL_ROOT, $msg);
        }
        $model = $this->model;
        $telephone = $_SESSION['user_phone'];
        $products = $this->getProductsbhFromHtsoft($telephone);
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Tra cứu bảo hành', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/warranty.php';
    }

    function repair()
    {
        if (!@$_SESSION['user_phone'] && !@$_SESSION['status']) {
            $msg = "Bạn chưa đăng nhập";
            setRedirect(URL_ROOT, $msg);
        }
        $model = $this->model;
        $telephone = $_SESSION['user_phone'];
        $products = $this->getProductsrepairFromHtsoft($telephone);
        if ($products) {
            $list = $products['WarrantyHistoryDetail'];
        }
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Tra cứu sửa chữa', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/repair.php';
    }

    function getProductsFromHtsoft($phone)
    {
        if (!is_null($phone) && isset($phone) && !empty($phone)) {

            $dataSend = json_encode(array("callerid" => $phone));

            $url = 'http://24h.htsoft.vn:9024/ActionService.svc/GetCustomerInfoByCallerID';

            return $this->sendDataBizman($url, $dataSend);
        }
        return array();
    }

    function sendDataBizman($url, $data)
    {
        $ch = curl_init($url);
        # Setup request to send json via POST.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_PROXY, "118.69.61.57:8888");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'ClientTag:24h20042017',
            'Content-Length: ' . strlen($data)
        ));

        # Return response instead of printing.

        # Send request.
        $result = curl_exec($ch);
//        var_dump($result);die;
        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        # Print response.
        return json_decode($result, true);
    }

    function sendDataBizmanbh($url, $data)
    {
        $ch = curl_init($url);
        # Setup request to send json via POST.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
//        curl_setopt($ch, CURLOPT_PROXY, "118.69.61.57:8888");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type:application/json',
            'ClientTag:24bh20181130',
            'Content-Length: ' . strlen($data)
        ));

        # Return response instead of printing.

        # Send request.
        $result = curl_exec($ch);
//        var_dump($result);die;
        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        # Print response.
        return json_decode($result, true);
    }

    function getProductssaleFromHtsoft($phone)
    {
        if (!is_null($phone) && isset($phone) && !empty($phone)) {

            $dataSend = json_encode(array("callerid" => $phone));

            $url = 'http://24h.htsoft.vn:9024/ActionService.svc/GetSaleHistoryByCallerID';

            return $this->sendDataBizman($url, $dataSend);
        }
        return array();
    }

    function getProductsrepairFromHtsoft($phone)
    {
        if (!is_null($phone) && isset($phone) && !empty($phone)) {

            $dataSend = json_encode(array("callerid" => $phone));

            $url = 'http://24bh.htsoft.vn:9034/ActionService.svc/GetWarrantyHistoryByCallerID';

            return $this->sendDataBizmanbh($url, $dataSend);
        }
        return array();
    }

    function getProductsbhFromHtsoft($phone)
    {
        if (!is_null($phone) && isset($phone) && !empty($phone)) {

            $dataSend = json_encode(array("Imei" => $phone));

            $url = 'http://24h.htsoft.vn:9024/ActionService.svc/GetInfoImeiByImei';

            return $this->sendDataBizman($url, $dataSend);
        }
        return array();
    }

    /*
     * View information of member
     */
    function detail()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $data = $model->getMember();
        $province = $model->getProvince($data->province);
        $district = $model->getDistrict($data->district);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    /*
     * View information of member
     */
    function edit()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $data = $model->getMember();
        $cities = $model->get_cities();
        $districts = $model->get_districts($data->city_id);
        $config_person_edit = $model->getConfig('person_edit');
        include 'modules/' . $this->module . '/views/' . $this->view . '/edit.php';
    }

    function user_info()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $data = $model->getMember();

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thông tin tài khoản', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/user_info.php';
    }

    function login()
    {
//			echo 1;die;
        $model = $this->model;
        if (isset($_SESSION['user_phone']) && isset($_SESSION['status'])) {
            $link = FSRoute::_('index.php?module=users&task=logged&Itemid=37');
            setRedirect($link);
        }
        $config_person_login_info = $model->getConfig('login_info');
        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng nhập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

//			$config_person_register_info  = $model -> getConfig('person_register_info');
        include 'modules/' . $this->module . '/views/' . $this->view . '/login_register.php';
    }


    function login_save()
    {
        $model = $this->model;
        $Itemid = FSInput::get('Itemid', 11, 'int');
        $otp = FSInput::get('otp');
        if ($otp == $_SESSION['otp']) {
            $_SESSION['status'] = 1;
            $link = FSRoute::_("index.php?module=users&view=users&task=logged&Itemid=39");
            setRedirect($link, 'Đăng nhập thành công!');
        } else {
            $link = FSRoute::_("index.php?module=users&view=users&task=check_htsoft");
            setRedirect($link, 'Bạn đã nhập sai mã OTP');
        }
    }

    function login_save_2($username, $password)
    {
        $model = $this->model;
        $Itemid = FSInput::get('Itemid', 11, 'int');

        $link = FSRoute::_("index.php?module=users&task=login");
        echo $password;
        $user = $model->login_2($username, $password);
        // logged
        $_SESSION['fullname'] = $user->full_name;
        $_SESSION['username'] = $user->username;
        $_SESSION['user_id'] = $user->id;

        $msg = "Bạn đã đăng ký thành công";
        setRedirect($link, $msg);
    }

    /*
     * Display form forget
     */
    function forget()
    {
        if (isset($_SESSION['username'])) {
            if ($_SESSION['username']) {
                $Itemid = 37;
                $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
                setRedirect($link);
            }
        }
        $model = $this->model;
        $config_person_forget = $model->getConfig('person_forget');

        //breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Quên mật khẩu', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/forget.php';
    }

    function activate()
    {
        $model = $this->model;
        $url = FSRoute::_('index.php?module=users&task=login&Itemid=11');
        if ($model->activate()) {
            setRedirect($url, 'Tài khoản của bạn đã được kích hoạt thành công');
        } else {
            setRedirect($url);
        }
    }

    function forget_save()
    {
        if (!$this->check_captcha()) {
            $msg = "Mã hiển thị không đúng";
            setRedirect("index.php?module=users&task=forget&Itemid=38", $msg, 'error');
        }

        $model = $this->model;

        $user = $model->forget();
        if (@$user->email) {
            $resetPass = $model->resetPass($user->id);
            if (!$resetPass) {
                $msg = "Lỗi hệ thống khi reset Password";
                setRedirect("index.php?module=users&task=login&Itemid=11", $msg, 'error');
            }
            include 'modules/' . $this->module . '/controllers/emails.php';
            // send Mail()
            $user_emails = new  UsersControllersEmail();
            if (!$user_emails->sendMailForget($user, $resetPass)) {
                $msg = "Lỗi hệ thống khi send mail";
                setRedirect("index.php?module=users&task=login&Itemid=11", $msg, 'error');
            }
            $msg = "Mật khẩu của bạn đã được thay đổi. Vui lòng kiểm tra email của bạn";
            setRedirect("index.php?module=users&task=login&Itemid=11", $msg);
        } else {
            $msg = "Email của bạn không tồn tại trong hệ thống. Vui lòng kiểm tra lại!";
            setRedirect("index.php?module=users&task=forget&Itemid=38", $msg, 'error');
        }
    }

    function logout()
    {
//        echo 1;die;
        unset($_SESSION['user_phone']);
        unset($_SESSION['full_name']);
        unset($_SESSION['otp']);
        unset($_SESSION['status']);
        unset($_SESSION['info_guest']);

        setRedirect(URL_ROOT);
    }

    /*
     * After login
     */
    function logged()
    {
//        echo 1;die;
//        $fssecurity = FSFactory::getClass('fssecurity');
//        $fssecurity->checkLogin();
        if (!@$_SESSION['user_phone']) {
            $msg = "Bạn chưa đăng nhập";
            setRedirect(URL_ROOT, $msg);
        }

        $model = $this->model;
//        $data = $model->getMember();
//			$menus_user = $model -> getMenusUser();
// breadcrumbs
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Thành viên', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/logged.php';
    }

    /**************** EDIT ***********/
    function edit_save()
    {
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        if (!$this->check_edit_save()) {
            $link = FSRoute::_("index.php?module=users&view=users&task=logged&Itemid=$Itemid");
            $msg = FSText::_("Không thay đổi được!");
            setRedirect($link, $msg, 'error');
        }
        $id = $model->edit_save();
        // if not save
        if ($id) {
            $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
            $msg = FSText::_("Bạn đã cập nhật thành công");
            setRedirect($link, $msg);
        } else {
            $link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
            $msg = FSText::_("Không cập nhật thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function views_select_birthday()
    {
        include 'modules/' . $this->module . '/views/' . $this->view . '/select_birthday.php';
    }

    function check_edit_save()
    {

        $model = $this->model;
        // check pass
//			$old_password = FSInput::get("old_password");
//			$password = FSInput::get("password");
//			$re_password = FSInput::get("re-password");
//
//			if($re_password)
//			{
//				if(!$model -> checkOldpass($old_password))
//				{
//					Errors::setError(FSText::_("M&#7853;t kh&#7849;u c&#361; kh&ocirc;ng &#273;&uacute;ng"));
//					return false;
//				}
//				if($password && ($password != $re_password))
//				{
//					Errors::setError(FSText::_("M&#7853;t kh&#7849;u kh&ocirc;ng tr&ugrave;ng nhau"));
//					return false;
//				}	
//			}
//			$email = FSInput::get("email");
//			$re_email = FSInput::get("re-email");
//			if($re_email)
//			{
//				if($email != $re_email)
//				{
//					Errors::setError(FSText::_("Email kh&ocirc;ng tr&ugrave;ng nhau"));
//					return false;
//				}	
//			}

        return true;
    }
    /**************** REGISTER ***********/
    /*
     * Resigter
     */
    function register()
    {

        $model = $this->model;

        $config_register_rules = $model->getConfig('register_rules');
        $config_register_info = $model->getConfig('register_info');

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng nhập - Đăng ký', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/login_register.php';
    }

    function register_save()
    {
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->save();
        $email = FSInput::get("email");
        $password = FSInput::get("r_password");
        if ($id) {
            $this->login_save_2($email, $password);
        } else {
            $link = FSRoute::_("index.php?module=users&view=users&task=login_register");
            $msg = FSText::_("Xin lỗi. Bạn chưa đăng ký thành công.");
            setRedirect($link, $msg, 'error');
        }
    }

    function check_register_save()
    {
        // check pass
        $username = FSInput::get("username");
        FSFactory::include_class('errors');
        if (!$username) {
            Errors::setError(FSText::_("Chưa nhập username"));
            return false;
        }

        $password = FSInput::get("password");
        $re_password = FSInput::get("re_password");
        if (!$password || !$re_password) {
            Errors::setError(FSText::_("Chưa nhập mật khẩu"));
            return false;
        }
        if ($password != $re_password) {
            Errors::setError(FSText::_("Mật khẩu không trùng nhau"));
            return false;
        }

        $email = FSInput::get("email");
        $re_email = FSInput::get("re-email");
        if (!$email || !$re_email) {
            Errors::setError(FSText::_("Chưa nhập email"));
            return false;
        }
        if ($email != $re_email) {
            Errors::setError(FSText::_("Email nhập lại không khớp"));
            return false;
        }

        // check captcha
        if (!$this->check_captcha()) {
//				Errors::setError(FSText::_("Mã hiển thị chưa đúng"));
            $this->alert_error('Mã hiển thị chưa đúng');
            return false;
        }

        $model = $this->model;
        // check email and identify card
        if (!$model->check_exits_email()) {
            return false;
        }
        if (!$model->check_exits_username()) {
            return false;
        }

        return true;
    }


    function check_exits_email()
    {
        $model = $this->model;
        if (!$model->check_exits_email())
            return false;
        return true;
    }

    function ajax_check_exist_username()
    {
        $model = $this->model;
        if (!$model->ajax_check_exits_username()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    function ajax_check_exist_email()
    {
        $model = $this->model;
        if (!$model->ajax_check_exits_email()) {
            echo 0;
            return false;
        }
        echo 1;
        return true;
    }

    /*
     * load District by city id.
     * Use Ajax
     */

    function destination()
    {
        $model = $this->model;

        $cid = FSInput::get('cid');
        $did = FSInput::get('did');
        if ($cid) {
            $rs = $model->getDestination($cid);
        }
        if ($did) {
            $rs = $model->getDestination1($did);
        }
        $json = '[{id: 0,name: "Điểm đến"},'; // start the json array element
        $json_names = array();
        foreach ($rs as $item) {
            $json_names[] = "{id: $item->id, name: '$item->name'}";
        }
        $json .= implode(',', $json_names);
        $json .= ']'; // end the json array element
        echo $json;
    }

    /*
     * check valid Sim
     */
//		function check_valid_sim()
//		{
//		// check SIM
//			$model = $this -> model;
//			if(!$model->checkSimByAjax())
//			{
//				echo 0;
//				return;
//			}
//			echo 1;
//			return;
//		}
    function changepass()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        include 'modules/' . $this->module . '/views/' . $this->view . '/changepass.php';

    }

    function edit_save_changepass()
    {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=user_info&Itemid=40");
        $check = $model->check_change_pass();
        if (!$check) {
            setRedirect($link, 'Mật khẩu cũ chưa chính xác', 'error');
        }

        $rs = $model->save_changepass();
        // if not save

        if ($rs) {
            $msg = FSText::_("Bạn đã thay đổi thành công");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin lỗi. Bạn chưa thay đổi thành công!");
            setRedirect($link, $msg, 'error');
        }
    }

    function change_email_save()
    {
        // check logged
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);

        $link = FSRoute::_("index.php?module=users&task=changepass&Itemid=$Itemid");
        $email_new = FSInput::get('email_new');
        if ($email_new) {

            $re_email_new = FSInput::get('re_email_new');
            if ($email_new != $re_email_new) {
                $msg = FSText::_("Email nh&#7853;p ch&#432;a kh&#7899;p!");
                setRedirect($link, $msg, 'error');
            }
            $check = $model->check_change_pass();
            if (!$check) {
                setRedirect($link, 'Email m&#7899;i c&#7911;a b&#7841;n &#273;&#227; t&#7891;n t&#7841;i trong h&#7879; th&#7889;ng. B&#7841;n ch&#432;a thay &#273;&#7893;i &#273;&#432;&#7907;c th&#244;ng tin', 'error');
            }
        }

        $rs = $model->save_changepass();
        // if not save


        if ($rs) {
            $msg = FSText::_("B&#7841;n &#273;&#227; thay &#273;&#7893;i th&#224;nh c&#244;ng");
            setRedirect($link, $msg);
        } else {
            $msg = FSText::_("Xin l&#7895;i, b&#7841;n &#273;&#227; thay &#273;&#7893;i kh&#244;ng th&#224;nh c&#244;ng!");
            setRedirect($link, $msg, 'error');
        }
    }

    /*
     * * Load list addbook
     * Get address book for search
     */
    function ajax_get_address_book_by_key()
    {
        $model = $this->model;
        $list = $model->get_address_book_by_key();
        $total = count($list);
        if (!$total) {
            $add_property = $model->get_address_book_properties();
            // convert to array
            $other_properties = array();
            foreach ($add_property as $item) {
                if (!isset($other_properties[$item->type]))
                    $other_properties[$item->type] = array();
                $other_properties[$item->type][] = $item;
            }
            // location
            $countries = $model->get_countries();
            $country_current = isset($data->coutry_id) ? $data->coutry_id : 66; // default: VietNam
            $cities = $model->get_cities($country_current);
            $city_id_first = $cities[0]->id;
            $city_current = isset($data->city_id) ? $data->city_id : $city_id_first;
            $districts = $model->get_districts($city_current);
            $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
            $communes = $model->get_communes($district_current);
            $commune_current = isset($communes[0]->id) ? $communes[0]->id : 0;
            $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_address_book.php';
    }

    function ajax_add_address_book_form()
    {
        $model = $this->model;
        $add_property = $model->get_address_book_properties();
        // convert to array
        $other_properties = array();
        foreach ($add_property as $item) {
            if (!isset($other_properties[$item->type]))
                $other_properties[$item->type] = array();
            $other_properties[$item->type][] = $item;
        }

        // location
        $countries = $model->get_countries();
        $country_current = 66; // default: VietNam
        $cities = $model->get_cities($country_current);
        $city_current = isset($cities[0]->id) ? $cities[0]->id : 0;
        $districts = $model->get_districts($city_current);
        $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
        $communes = $model->get_communes($district_current);
        $commune_current = isset($communes[0]->id) ? $communes[0]->id : 0;
        $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');
        include 'modules/' . $this->module . '/views/' . $this->view . '/register_add_addressbook.php';
    }

    /*
     * Get address book for search
     */
    function ajax_load_address_book_by_id()
    {
        $model = $this->model;
        $id = FSInput::get('id', 'int', 0);
        if (!$id)
            return;
        $data = $model->get_record_by_id($id, 'fs_address_book');
        if (!$data)
            return;
        $add_property = $model->get_address_book_properties();
        // convert to array
        $other_properties = array();
        foreach ($add_property as $item) {
            if (!isset($other_properties[$item->type]))
                $other_properties[$item->type] = array();
            $other_properties[$item->type][] = $item;
        }
        // location
        $countries = $model->get_countries();
        $country_current = isset($data->coutry_id) ? $data->coutry_id : 66; // default: VietNam
        $cities = $model->get_cities($country_current);
        $city_id_first = $cities[0]->id;
        $city_current = isset($data->city_id) ? $data->city_id : $city_id_first;
        $districts = $model->get_districts($city_current);
        $district_current = isset($data->district_id) ? $data->district_id : $districts[0]->id;
        $communes = $model->get_communes($district_current);
        $commune_current = isset($data->commune_id) ? $data->commune_id : $communes[0]->id;
        $categories = $model->get_records('published = 1', 'fs_address_book_categories', $select = 'id,name,parent_id', $ordering = ' ordering,id ');

        include 'modules/' . $this->module . '/views/' . $this->view . '/register_load_address_book.php';
    }

    function login_register()
    {
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Đăng ký - đăng nhập', 1 => '');
        global $tmpl;
        $tmpl->assign('breadcrumbs', $breadcrumbs);

        include 'modules/' . $this->module . '/views/' . $this->view . '/login_register.php';
    }

    function address_book()
    {
        $fssecurity = FSFactory::getClass('fssecurity');
        $fssecurity->checkLogin();
        $model = $this->model;
        $data = $model->getMember();
        $address_book = $model->get_address_book();
        $cities = $model->get_cities();
        $districts = $model->get_districts($data->city_id);
        $config_person_edit = $model->getConfig('person_edit');
        include 'modules/' . $this->module . '/views/' . $this->view . '/address_book.php';
    }

    function add_address()
    {
        include 'modules/' . $this->module . '/views/' . $this->view . '/add_address.php';
    }

    function add_address_save()
    {
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->add_address_save();
        // if not save
        if ($id) {
            $link = FSRoute::_("index.php?module=users&task=logged");
            $msg = FSText::_("Thêm thành công");
            setRedirect($link, $msg);
        } else {
            $link = FSRoute::_("index.php?module=users&task=logged");
            $msg = FSText::_("Không thể thêm !");
            setRedirect($link, $msg, 'error');
        }
    }

    function edit_address()
    {
        $model = $this->model;
        $address = $model->get_address_book_by_id();
        include 'modules/' . $this->module . '/views/' . $this->view . '/edit_address_book.php';
    }

    function edit_address_save()
    {
        $model = $this->model;
        $Itemid = FSInput::get("Itemid", 1);
        $id = $model->edit_address_save();
        // if not save
        if ($id) {
            $link = FSRoute::_("index.php?module=users&task=logged");
            $msg = FSText::_("Thêm thành công");
            setRedirect($link, $msg);
        } else {
            $link = FSRoute::_("index.php?module=users&task=logged");
            $msg = FSText::_("Không thể thêm !");
            setRedirect($link, $msg, 'error');
        }
    }
}

?>
