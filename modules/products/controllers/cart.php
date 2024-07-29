<?php
// require_once PATH_BASE . 'modules/api/controllers/nhanh.php';
// require_once PATH_BASE . 'modules/api/controllers/ssc.php';

class ProductsControllersCart extends FSControllers
{
    public $userLevel = [
        'Đồng',
        'Bạc',
        'Vàng',
        'Bạch kim'
    ];


    public function display()
    {
        // unset($_SESSION['cart']);

        global $tmpl, $user, $config;
        $tmpl->addTitle('Giỏ hàng');

        $cart = $this->calculateCartPrice();

        $cartPrice = 0;

        $promotionDiscountPrice = 0;

        foreach ($cart as $item) {

            $cartPrice += $item['quantity'] * $item['price'];
        }

        $shipPrice = ($cartPrice <= $config['total_price_freeship'] && $config['fee']) ? $config['fee'] : 0;

        $totalPayment = $cartPrice + $shipPrice - $promotionDiscountPrice;

        //địa chỉ
        $province = $this->model->get_records('', 'fs_provinces', 'code, name, code_name', 'code_name ASC');
        if ($user->userID) {
            $address = $this->model->get_records("member_id = $user->userID", 'fs_members_address', '*', '`default` DESC');

            if (!empty($address)) {
                foreach ($address as $itemAddress) {
                    $arrProvince[] = $itemAddress->province_id;
                    if ($itemAddress->default) {
                        $addressDefault = $itemAddress;
                    }
                }

                $arrProvince = implode(',', $arrProvince);
                $district = $this->model->get_records("province_code IN ($arrProvince)", 'fs_districts', 'code, name, code_name, province_code', 'code_name ASC');

                foreach ($district as $itemDistrict) {
                    $arrDistrict[] = $itemDistrict->code;
                }
                $arrDistrict = implode(',', $arrDistrict);
                $ward = $this->model->get_records("district_code IN ($arrDistrict)", 'fs_wards', 'code, name, code_name, district_code', 'code_name ASC');

                foreach ($address as $itemAddress) {
                    foreach ($province as $provinceItem) {
                        if ($itemAddress->province_id == $provinceItem->code) {
                            $itemAddress->province_name = $provinceItem->name;
                            break;
                        }
                    }
                    foreach ($district as $districtItem) {
                        if ($itemAddress->district_id == $districtItem->code) {
                            $itemAddress->district_name = $districtItem->name;
                            break;
                        }
                    }
                    foreach ($ward as $wardItem) {
                        if ($itemAddress->ward_id == $wardItem->code) {
                            $itemAddress->ward_name = $wardItem->name;
                            break;
                        }
                    }
                }
            }
        }

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    public function addCart()
    {
        if (($_SERVER['REQUEST_METHOD'] != 'POST') || !csrf::authenticationToken()) {
            echo json_encode([
                'error' => true,
                'message' => "Lỗi",
            ]);
            exit();
        }

        $id = FSInput::get('product');
        $quantity = FSInput::get('quantity', 1);
        $price = FSInput::get('price');
        $price_old = FSInput::get('price_old', 0);
        $coin = FSInput::get('coin', 0);
        $price_origin = FSInput::get('price_origin', 0);
        $image = $_POST['image'];

        $product = $this->model->get_record("id = $id AND published = 1", 'fs_products', 'id,coin, name, quantity, alias, price, price_old, code, nhanh_id');

        $quantity = $quantity > 0 ? $quantity : 1;

        if (!$product) {
            $response = [
                'message' => FSText::_('Sản phẩm không tồn tại!'),
                'error' => true,
            ];
            goto exitFunc;
        }

        if (!$product->quantity) {
            $response = [
                'message' => FSText::_('Sản phẩm đã hết hàng!'),
                'error' => true,
            ];
            goto exitFunc;
        }



        $itemNew = [
            'product_id' => $id,
            'product_name' => $product->name,
            'quantity' => $quantity,
            'price' => $price_old,
            'coin' => $coin,
            'image' => $image,
        ];

        $exist = 0;
        $session = @$_SESSION['cart'] ?: [];

        foreach ($session as $i => $item) {
            if ($item['product_id'] == $id) {
                $session[$i]['quantity'] += $quantity;
                $exist = 1;
                break;
            }
        }
        if (!$exist) {
            $session[] = $itemNew;
        }
        $_SESSION['cart'] = $session;
        $total_money_cart = 0;
        $cart = new FSControllers();
        $cartList = $cart->calculateCartPrice();
        $cartPrice = 0;
        foreach ($cartList as $item) {
            $cartPrice += $item['quantity'] * $item['price'];
        }
        // die;
        $response = [
            'message' => FSText::_('Sản phẩm đã được thêm vào giỏ hàng!'),
            'error' => false,
            'total' => count($session),
            'total_order' => $cartPrice,
            'newItem' => !$exist ? $itemNew : null,
            'image' => $image
        ];

        exitFunc:
        echo json_encode($response);
        exit();
    }

    public function updateCart()
    {
        // die;

        $index = FSInput::get('index');
        $quantity = FSInput::get('quantity', 1);
        $remove = FSInput::get('remove', 0);

        $session = $_SESSION['cart'] ?: [];

        $session[$index]['quantity'] = $quantity;

        if ($remove) {
            unset($session[$index]);
        }

        $_SESSION['cart'] = array_values($session);

        $response = [
            'message' => FSText::_('Cập nhật giỏ hàng thành công!'),
            'error' => false,
            'total' => count($session)
        ];

        echo json_encode($response);
        exit();
    }

    public function saveCart()
    {
        $method = $_SERVER['REQUEST_METHOD'];
        if ($method != 'POST') {
            setRedirect(FSRoute::_("index.php?module=products&view=cart"), FSText::_('Invalid method!'), 'error');
        }

        $auth = csrf::authenticationToken();

        if (!$auth) {
            setRedirect(FSRoute::_("index.php?module=products&view=cart"), FSText::_('Invalid token!'), 'error');
        }

        $cart = $this->calculateCartPrice();

        if (empty($cart)) {
            setRedirect(FSRoute::_("index.php?module=products&view=cart"), FSText::_('Invalid session!'), 'error');
        }

        $product_id = [];
        $product_count = 0;
        $product_sub_id = [];
        $total_before = 0;
        $promotion_discount_price = 0;
        $member_coin = 0;

        foreach ($cart as $item) {
            $product_id[] = $item['product_id'];
            $product_count += $item['quantity'];
            $member_coin  += $item['coin'] * $item['quantity'];
            $total_before += $item['quantity'] * $item['price'];
        }

        global $user, $config;

        $member_discount_price = 0;
        $ship_price  = ($total_before <= $config['total_price_freeship'] && $config['fee']) ? $config['fee'] : 0;
        $code_discount_price = 0;

        $rowOrder = [
            'username' => $user->userID ? $user->userInfo->full_name : FSInput::get('name'),
            'user_id' => $user->userID ?: 0,
            'email' =>  $user->userID ? $user->userInfo->email : FSInput::get('email'),

            'recipients_name' => FSInput::get('name'),
            'recipients_email' => FSInput::get('email'),
            'recipients_telephone' => FSInput::get('telephone'),
            'recipients_address' => FSInput::get('address'),
            'recipients_province' => FSInput::get('province'),
            'recipients_district' => FSInput::get('district'),
            'recipients_ward' => FSInput::get('ward'),
            'recipients_comments' => FSInput::get('note'),

            'products_id' => implode(',', $product_id),
            'products_count' => $product_count,
            'member_coin' => $member_coin,

            'ship_price' => $ship_price,
            'ship_method' => 0,

            'code_discount' => FSInput::get('discount'),
            'code_discount_price' => $code_discount_price,

            'promotion_discount_price' => $promotion_discount_price,

            'total_before' => $total_before,
            'total_end' => $total_before + $ship_price  - $code_discount_price - $promotion_discount_price,

            'payment_method' => 0,
            'payment_status' => 0,

            'status' => 0,
            'created_time' => date('Y-m-d H:i:s'),
            'edited_time' => date('Y-m-d H:i:s'),
        ];

        $orderId = $this->model->_add($rowOrder, 'fs_order');


        if (!$orderId) {
            setRedirect(FSRoute::_("index.php?module=products&view=cart"), FSText::_('Có lỗi xảy ra. Vui lòng thử lại sau!'), 'error');
        }



        $rowDetail = [];
        foreach ($cart as $item) {
            $rowDetail[] = [
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'price_old' => $item['price_old'],
                'price' => $item['price'],
                'count' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'],
            ];
        }

        $this->model->_add_multiple($rowDetail, 'fs_order_items');
        $rowOrder['orderID'] = $orderId;
        $_SESSION['orderInfo'] = $rowOrder;
        $rowOrder['province_name'] = $this->model->get_record("code = '" . $rowOrder['recipients_province'] . "'", 'fs_provinces', 'code, name')->name;
        $rowOrder['district_name'] = $this->model->get_record("code = '" . $rowOrder["recipients_district"] . "'", 'fs_districts', 'code, name, full_name')->full_name;
        $rowOrder['ward_name'] = $this->model->get_record("code = '" . $rowOrder['recipients_ward'] . "'", 'fs_wards', 'code, name, full_name')->full_name;

        $_SESSION['cartCalculated'] = $cart;
        $now = time();
        //xử lý cổng thanh toán
        // $this->VNPAY($orderId);
        //end xử lý cổng 
        if ($user->userID && $orderId) {
            if ($user->userInfo->level >= 1) {
                $this->calculateMemberRankDaiLy();
            }
            $member_ref = $this->model->get_record("ref_code = '" . $user->userInfo->ref_by . "'", 'fs_members', 'id,level,full_name,vt_coin,hoa_hong,active_account,end_time,due_time_month'); // thành viên giới thiệu (F0)
            $percent = $member_coin > 300 ? 10 : 0; //cách tính số coin nhận được nếu trên 300coin nhận thêm 10% hoa hồng cho f0
            $hoa_hong = $member_ref->hoa_hong ?? $this->model->get_record('level =' . $member_ref->level, 'fs_members_group')->member_benefits;
            $coin_add_affilat =  ($member_coin * ($hoa_hong + $percent)) / 100;
            if ($coin_add_affilat) {
                $dieu_kien_nhan = $member_ref->active_account == 1 ? 1 : 0;
                if ($dieu_kien_nhan == 0) {
                    $dieu_kien_nhan = $this->check_dieu_kien_nhan_coin($member_ref->id, $member_ref->level, $member_ref->due_time_month);
                }

                if ($user->userInfo->level == 1) {
                    $count_order_member = $this->model->get_records('user_id=' . $user->userInfo->id, 'fs_order');
                    $total_records = count($count_order_member);
                    if ($total_records == 1) {
                        $row_time['active_account'] = 1;
                        $row_time['end_time'] = date('Y-m-d H:i:s', strtotime('+1 year', $now));
                        $this->model->_update($row_time, 'fs_members', 'id =' . $user->userInfo->id);
                    }
                }
                if ($user->userInfo->level > 1) {
                    $row_time['end_time'] = date('Y-m-d H:i:s', strtotime('+50 year', $now));
                    $this->model->_update($row_time, 'fs_members', 'id =' . $user->userInfo->id);
                }
                $total_coin = $coin_add_affilat + $member_ref->vt_coin;
                $RowCoin = [
                    'order_id' => $orderId,
                    'total_coin' => $member_coin, //số coin của đơn hàng 
                    'percent_add' => $hoa_hong + $percent, //số % thêm khi đơn hàng trên 300vt-coin
                    'percent' => $hoa_hong, //số % mà f0 có thể nhận được , dựa trên mức rank của họ
                    'before_coin' => $member_ref->vt_coin, //số coin của member lúc ban đầu
                    'after_coin' => $coin_add_affilat, //số coin của member sau khi cộng dựa theo % hoa hồng 
                    'total_coin_after' => $total_coin, //số coin của member sau khi cộng dựa theo % hoa hồng 
                    'user_name' =>  $member_ref->full_name, // tổng số coin sau khi được cộng vào 
                    'user_id' => $member_ref->id, //user_id nhận tiền 
                    'dieu_kien_nhan' => $dieu_kien_nhan,
                    'created_time' => date('Y-m-d H:i:s'), //ngày tạo
                ];
                if ($this->calculateMemberCoin($member_ref->id, $total_coin, $dieu_kien_nhan)) {
                    if ($id_fs_coin_log = $this->model->_add($RowCoin, 'fs_coin_log')) {
                        $status = ['status' => 1];
                        $this->model->_update($status, 'fs_coin_log', 'id =' . $id_fs_coin_log);
                        $this->calculateMemberRank($user->userInfo->id); // check rank cho thành viên mua hàng
                        if ($member_ref->level >= 1)
                            $this->calculateMemberRank($member_ref->id);
                    }
                } else {
                    $this->model->_add($RowCoin, 'fs_coin_log');
                }
            }
        }
        $_SESSION['CoinInfo'] = $RowCoin;
        setRedirect(FSRoute::_("index.php?module=products&view=cart&task=orderSuccess"));
    }
    public function return_VNPAY()
    {
        setRedirect(FSRoute::_("index.php?module=products&view=cart&task=orderSuccess"));
    }

    public function VNPAY($id)
    {
        $model = $this->model;
        $now = time();
        $order = $model->get_record('id=' . $id, 'fs_order');
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_TxnRef = 'DH' . $now . $order->id; //Mã giao dịch thanh toán tham chiếu của merchant  
        $vnp_Amount =  $order->total_end; // Số tiền thanh toán
        $vnp_Locale = 'vn'; //Ngôn ngữ chuyển hướng thanh toán
        $vnp_BankCode = ''; //Mã phương thức thanh toán
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $vnp_HashSecret = 'R34L1WK9KY068059AJFJXLJMYYY7HVA9';

        $expire = date('YmdHis', time() + 30 * 60);

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => 'VITHAICO',
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD:" . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => FSRoute::_("index.php?module=products&view=cart&task=orderSuccess"),
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        header('Location: ' . $vnp_Url);
    }
    public function loadDistrict()
    {
        $code = FSInput::get('code');

        $list = $this->model->get_records("province_code = '$code'", 'fs_districts', 'code, name, code_name, province_code');

        echo json_encode($list);
        exit();
    }

    public function loadWard()
    {
        $code = FSInput::get('code');

        $list = $this->model->get_records("district_code = '$code'", 'fs_wards', 'code, name, code_name, district_code');

        echo json_encode($list);
        exit();
    }

    public function orderSuccess()
    {
        $cart = $_SESSION['cart'] ?: [];

        if (empty($cart)) {
            setRedirect(URL_ROOT, FSText::_('Quý khách chưa có sản phẩm nào trong giỏ hàng'), 'error');
        }

        $cart = $_SESSION['cartCalculated'];
        $order = $_SESSION['orderInfo'];
        $orderID = $order['orderID'];
        $coin_log = $_SESSION['CoinInfo'];
        global $user;

        // echo "<pre >";
        // print_r($coin_log);
        // print_r($user->userInfo);
        $province = $this->model->get_record("code = '" . $order['recipients_province'] . "'", 'fs_provinces', 'code, name');
        $district = $this->model->get_record("code = '" . $order["recipients_district"] . "'", 'fs_districts', 'code, name');
        $ward = $this->model->get_record("code = '" . $order['recipients_ward'] . "'", 'fs_wards', 'code, name');


        unset($_SESSION['cart']);
        unset($_SESSION['cartCalculated']);
        unset($_SESSION['orderInfo']);
        unset($_SESSION['CoinInfo']);

        global $tmpl;
        $tmpl->addTitle('Đặt hàng thành công');

        include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
    }
}
