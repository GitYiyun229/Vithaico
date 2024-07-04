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

        global $tmpl, $user;
        $tmpl->addTitle('Giỏ hàng');
        
        $cart = $this->calculateCartPrice();

        $cartPrice = 0;
        $shipPrice = 30000;
        $promotionDiscountPrice = 0;
      
        foreach ($cart as $item) {
            $cartPrice += $item['quantity'] * $item['price'];
            $promotionDiscountPrice += $item['promotion_discount'];
        }

        $totalPayment = $cartPrice + $shipPrice - $promotionDiscountPrice;

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
        $id_sub = FSInput::get('sub', 0);
        $quantity = FSInput::get('quantity', 1);
        $price = FSInput::get('price');
        $price_old = FSInput::get('price_old', 0);
        $price_origin = FSInput::get('price_origin', 0);
        // $image = FSInput::get('image');
        $image = $_POST['image'];

        $product = $this->model->get_record("id = $id AND published = 1", 'fs_products', 'id, name, quantity, alias, price, price_old, code, nhanh_id');

        $quantity = $quantity > 0 ? $quantity : 1 ;

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

        if ($id_sub) {
            $sub = $this->model->get_record("id = $id_sub AND published = 1", 'fs_products_sub', 'id, name, price, quantity, price_old, code, nhanh_id');
            
            if (!$sub->quantity) {
                $response = [
                    'message' => FSText::_('Sản phẩm đã hết hàng!'),
                    'error' => true,
                ];
    
                goto exitFunc;
            }
        }

        $itemNew = [
            // 'nhanh_id' => $id_sub ? $sub->nhanh_id : $product->nhanh_id,
            'product_id' => $id,
            'product_name' => $product->name,
            'sub_id' => $id_sub,
            'sub_name' => $id_sub ? $sub->name : '',
            'quantity' => $quantity,
            'price' => $price,
            'price_origin' => $price_origin,
            // 'price_old' => $price_old && $price_old > $price ? $price_old : 0,
            'image' => $image,
            // 'code' => $id_sub ? $sub->code : $product->code,
            // 'url' => FSRoute::_("index.php?module=products&view=product&code=$product->alias&id=$id")
        ];

        $exist = 0;
        $session = @$_SESSION['cart'] ?: [];

        foreach ($session as $i => $item) {
            if ($item['product_id'] == $id && $item['sub_id'] == $id_sub) {
                $session[$i]['quantity'] += $quantity;
                $exist = 1;
                break;
            }
        }

        if (!$exist) {
            $session[] = $itemNew;
        }
       
        $_SESSION['cart'] = $session;

        $response = [
            'message' => FSText::_('Sản phẩm đã được thêm vào giỏ hàng!'),
            'error' => false,
            'total' => count($session),
            'newItem' => !$exist ? $itemNew : null,
            'image' => $image
        ];

        exitFunc:
        echo json_encode($response);
        exit();
    }

    public function updateCart()
    {
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

        foreach ($cart as $item) {
            $product_id[] = $item['product_id'];
            $product_count += $item['quantity'];
            $product_sub_id[] = $item['sub_id'];
            $total_before += $item['quantity'] * $item['price'];
            $promotion_discount_price += $item['promotion_discount'];
        }

        global $user;

        $member_discount_price = 0;
        $ship_price = 30000;
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
            'products_id_sub' => implode(',', $product_sub_id),
            'products_count' => $product_count,

            'member_level' => 0,
            'member_discount_price' => $member_discount_price,

            'ship_price' => $ship_price,
            'ship_method' => 0,
            
            'code_discount' => FSInput::get('discount'),
            'code_discount_price' => $code_discount_price,

            'promotion_discount_price' => $promotion_discount_price,

            'total_before' => $total_before,
            'total_end' => $total_before + $ship_price - $member_discount_price - $code_discount_price - $promotion_discount_price,
           
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
                'id_sub' => $item['sub_id'],
                'price_old' => $item['price_old'],
                'price' => $item['price'],
                'count' => $item['quantity'],
                'total' => $item['price'] * $item['quantity'] - $item['promotion_discount'],
                'promotion_discount_id' => $item['promotion_discount_id'],
                'promotion_discount_quantity' => $item['promotion_discount_quantity'],
            ];
        }

        $this->model->_add_multiple($rowDetail, 'fs_order_items');

        $rowOrder['orderID'] = $orderId;
        $_SESSION['orderInfo'] = $rowOrder;

        $rowOrder['province_name'] = $this->model->get_record("code = '".$rowOrder['recipients_province']."'" , 'fs_provinces', 'code, name')->name;
        $rowOrder['district_name'] = $this->model->get_record("code = '".$rowOrder["recipients_district"]."'", 'fs_districts', 'code, name, full_name')->full_name;
        $rowOrder['ward_name'] = $this->model->get_record("code = '".$rowOrder['recipients_ward']."'", 'fs_wards', 'code, name, full_name')->full_name;

        foreach ($rowDetail as $i => $item) {
            $rowDetail[$i]['product_name'] = $cart[$i]['product_name']; 
            $rowDetail[$i]['code'] = $cart[$i]['code'];
            $rowDetail[$i]['nhanh_id'] = $cart[$i]['nhanh_id'];
        }

        $ssc = ApiControllersSsc::createOrder($rowOrder, $rowDetail);
        $this->model->_update(["ssc_id" => $ssc->success ? $ssc->data[0]->tracking_id : 0], "fs_order", "id = $orderId");

        if (!$ssc->data[0]->tracking_id) {
            $_SESSION['have_redirect'] = 1;
            $_SESSION["msg_error"] = [];
            foreach ($ssc->errors[0]->errors as $item) {
                $_SESSION["msg_error"][] = $item;
            }
            $this->model->_remove("id = $orderId", "fs_order");
            $this->model->_remove("order_id = $orderId", "fs_order_items");
            setRedirect(FSRoute::_("index.php?module=products&view=cart"));
        }

        $nhanh = ApiControllersNhanh::addOrder($rowOrder, $rowDetail, $ssc->data[0]->tracking_id);
        $this->model->_update(["nhanh_id" => $nhanh->code ? $nhanh->data->orderId : 0], "fs_order", "id = $orderId");

        $_SESSION['cartCalculated'] = $cart;

        foreach ($cart as $item) {
            if ($item['promotion_discount_id']) {
                $sold = $item['promotion_discount_quantity'];
                $this->model->_update(['sold' => "sold + $sold"], 'fs_promotion_discount_detail', "promotion_id = " . $item["promotion_discount_id"] . " AND product_id = " . $item['product_id']);
            }
        }

        setRedirect(FSRoute::_("index.php?module=products&view=cart&task=orderSuccess"));
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

    public function orderSuccess(){
        $cart = $_SESSION['cart'] ?: [];

        if (empty($cart)) {
            setRedirect(URL_ROOT, FSText::_('Quý khách chưa có sản phẩm nào trong giỏ hàng'), 'error');
        }

        $cart = $_SESSION['cartCalculated'];
        $order = $_SESSION['orderInfo'];
        $orderID = $order['orderID'];

        $promotionDiscountPrice = 0;
      
        foreach ($cart as $item) {
            $promotionDiscountPrice += $item['promotion_discount'];
        }

        $province = $this->model->get_record("code = '".$order['recipients_province']."'" , 'fs_provinces', 'code, name');
        $district = $this->model->get_record("code = '".$order["recipients_district"]."'", 'fs_districts', 'code, name');
        $ward = $this->model->get_record("code = '".$order['recipients_ward']."'", 'fs_wards', 'code, name');

        unset($_SESSION['cart']);
        unset($_SESSION['cartCalculated']);
        unset($_SESSION['orderInfo']);

        global $tmpl;
        $tmpl->addTitle('Đặt hàng thành công');

        include 'modules/' . $this->module . '/views/' . $this->view . '/success.php';
    }
}
