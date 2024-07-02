<?php

class ProductsModelsCart extends FSModels
{
    var $limit;
    var $page;

    // fs_config Tài khoản EC 2
    var $COM_CODE_EC;
    var $USER_ID_EC;
    var $API_CERT_KEY_EC;

    function __construct()
    {
        parent:: __construct();
        $limit = 30;
        $this->limit = $limit;
        global $config;
        $this->COM_CODE_EC = $config['ec_com_code2'];
        $this->USER_ID_EC = $config['ec_user_id2'];
        $this->API_CERT_KEY_EC = $config['ec_key2'];
    }

    /*
     * if currency = 'VND' return
     * else transform.
     */
    function getPrice()
    {
        $product_id = FSInput::get('id');
        if (!$product_id)
            return -1;
        $query = " SELECT price,  discount
						FROM fs_products 
						WHERE id = $product_id
						 ";
        global $db;
        $db->query($query);
        $rs = $db->getObject('',USE_MEMCACHE);

        return array($rs->price, $rs->discount);
    }
    /*
     * get current Estore
     */

//		function getEstore($eid) {
//			if(!$eid)
//				return;
//
//			$query = " SELECT *
//						FROM fs_estores
//						WHERE  id = $eid ";
//			global $db;
//			$db -> query($query);
//			return $rs = $db->getObject();
//		}
    /*
     * get all payments methods in fs_payment_methods
     */
    function get_payment_methods($str_epayment_ids)
    {
        if (!$str_epayment_ids) {
            return;
        }
        global $db;
        $query = " SELECT *
				FROM fs_payment_methods
				WHERE 
					id IN ($str_epayment_ids)
					AND published = 1
				ORDER BY ordering
				";
        $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    /*
     * get all transfer methods in fs_transfer_methods
     */
    function get_transfer_methods($str_etransfer_ids)
    {
        if (!$str_etransfer_ids) {
            return;
        }
        global $db;
        $query = " SELECT *
				FROM fs_transfer_methods
				WHERE 
					id IN ($str_etransfer_ids)
					AND published = 1
				ORDER BY ordering
				";
        $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function getCity1($cityid)
    {
        if (!$cityid)
            return;
        $query = " SELECT *
						FROM fs_local_cities
						WHERE  id = $cityid ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    function getCity()
    {
        global $db;
        $query = '  SELECT *
                    FROM fs_local_cities 
                    WHERE published = 1
                    ORDER BY name ASC ';
        $sql = $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function getDistrict($id_Province)
    {
        global $db;
        $sql = "    SELECT *
                    FROM fs_districts
                    WHERE city_id = " . $id_Province . "
                ";
        $db->query($sql);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function getWard($districts_id)
    {
        global $db;
        $sql = " SELECT *
				    FROM fs_wards WHERE districts_id = $districts_id ORDER BY ordering";
        $db->query($sql);
        return $db->getObjectList('',USE_MEMCACHE);
    }

    /*
     * get Payment method
     */
    function get_payment_method($payment_id)
    {
        if (!$payment_id)
            return;
        $query = " SELECT name
						FROM fs_payment_methods
						WHERE  id = $payment_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getResult();
    }

    /*
     * get Payment method
     */
    function get_transfer_method($transfer_id)
    {
        if (!$transfer_id)
            return;
        $query = " SELECT name
						FROM fs_transfer_methods
						WHERE  id = $transfer_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getResult();
    }

    function getProductName($product_id)
    {
        if (!$product_id)
            return;
        $query = " SELECT name
						FROM fs_products
						WHERE  id = $product_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getResult();
    }

    function getProductById($product_id)
    {
        if (!$product_id)
            return;
        $query = " SELECT *
						FROM fs_products
						WHERE  id = $product_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    function get_color($id)
    {
        if (!$id)
            return;
        $query = " SELECT *
						FROM fs_products_price
						WHERE  id = $id ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    function get_price_by_color($record_id)
    {
        if (!$record_id)
            return;
        $limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						  FROM " . $fs_table->getTable('fs_products_price') . "
						  WHERE record_id =  $record_id
						   ORDER BY  price DESC
						 ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function getProductCategoryById($category_id)
    {
        if (!$category_id)
            return;
        $query = " SELECT name,id,alias 
						FROM fs_products_categories
						WHERE  id = $category_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    /*
     * get temporary data stored in fs_order
     * 1
     */
    function getOrder()
    {
        $session_id = session_id();
        $query = " SELECT *
						FROM fs_order
						WHERE  session_id = '$session_id' 
						AND is_temporary = 1 ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);

    }

    function getOrderById($id = 0)
    {
        if (!$id)
            $id = FSInput::get('id', 0, 'int');
        if (!$id)
            return;
        $session_id = session_id();
        $query = " SELECT *
						FROM fs_order
						WHERE  id = $id 
						AND session_id = '$session_id'
						 ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject();
    }

    function get_orderdetail_by_orderId($order_id)
    {
        if (!$order_id)
            return;
        $session_id = session_id();
        $query = " SELECT a.*
						FROM fs_order_items AS a
						WHERE  a.order_id = $order_id ";
        global $db;
        $db->query($query);
        return $rs = $db->getObjectList('',USE_MEMCACHE);
    }

    function get_products_from_orderdetail($str_product_ids)
    {
        if (!$str_product_ids)
            return false;
        $query = " SELECT a.*
						FROM fs_products AS a
						WHERE id IN ($str_product_ids) ";
        global $db;
        $db->query($query);
        $products = $db->getObjectListByKey('id');
        return $products;
    }

    function getDiscount()
    {
        $discount = 200000;
        return $discount;
    }

    /*
     * function data into fs_order
     */
    function eshopcart2_save()
    {
        return $this->eshopcart2_save_new();
    }

    function eshopcart2_save_cb()
    {
        return $this->eshopcart2_save_new_cb();
    }


    function get_discount_4_guest($email, $discount_code)
    {
        $discount = $this->get_record('code = "' . $discount_code . '" AND email = "' . $email . '" AND published = 1 and is_used = 0', 'fs_discount_members');
        return $discount;
    }

    /*
     * Save data into fs_order_items
     */
    function save_order_items($order_id)
    {
        if (!$order_id)
            return false;

        global $db, $config;

        // remove before update or inser
        $sql = " DELETE FROM fs_order_items
					WHERE order_id = '$order_id'";

        //$db->query($sql);
        $rows = $db->affected_rows($sql);


        // insert data
        $prd_id_array = array();
        // Repeat estores
        if (!isset($_SESSION['cart']))
            return false;

        $product_list = $_SESSION['cart'];
        //			$sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,color_id,color_name,color_price,memory_id,memory_name,memory_price,warranty_id,warranty_name,warranty_price,origin_id,origin_name,origin_price,species_id,species_name,species_price)
        //					VALUES ";
        $sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,color_id,color_name,color_price,warranty_id,warranty_name,warranty_price,species_id,species_name,species_price,origin_id,origin_name,origin_price)
			VALUES ";

        $array_insert = array();

        // Repeat products
        for ($i = 0; $i < count($product_list); $i++) {

            $prd = $product_list[$i];
        //				var_dump($prd);
            $total_money = $prd[1];

            // calculator color
            $color_name = '';
            $color_price = '';
            if ($prd[2]) {
                $color = $this->get_record_by_id($prd[2], 'fs_products_colors');
                $color_name = $color->name;
            }

            // calculator status
            //                $memory_name='';
            //                $memory_price='';
            //                if ($prd[3]){
            //                    $memory = $this->get_record_by_id($prd[3], 'fs_memory');
            //                    $memory_name=$memory->name;
            //                }

            // calculator status
            $warranty_name = '';
            $warranty_price = '';
            if ($prd[3]) {
                $warranty = $this->get_record_by_id($prd[3], 'fs_warranty');
                $warranty_name = $warranty->name;
            }


            $species_name = '';
            $species_price = '';
            if ($prd[4]) {
                $species = $this->get_record_by_id($prd[4], 'fs_species');
                $species_name = $species->name;
            }
            $origin_name = '';
            $origin_price = '';
            if ($prd[5]) {
                $origin = $this->get_record_by_id($prd[5], 'fs_origin');
                $origin_name = $origin->name;
            }
            //				$array_insert[] = "('$order_id','$prd[0]','','$prd[2]','$total_money','$prd[2]','$color_name','$color_price','$prd[3]','$memory_name','$warranty_price','$prd[4]','$warranty_name','$warranty_price','$prd[5]','$origin_name','$origin_price','$prd[6]','$species_name','$species_price') ";
            $array_insert[] = "('$order_id','$prd[0]','','1','$total_money','$prd[2]','$color_name','$color_price','$prd[3]','$warranty_name','$warranty_price','$prd[4]','$species_name','$species_price','$prd[5]','$origin_name','$origin_price') ";
        }
        //        var_dump($array_insert);die;
        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            //                echo $sql;die;
            //                $db->query($sql);
            $rows = $db->affected_rows($sql);
            return true;
        } else {
            return;
        }

    }


    function save_order_items_cb($order_id)
    {
        //			var_dump($order_id);die;
        if (!$order_id)
            return false;

        global $db, $config;

        // remove before update or inser
        $sql = " DELETE FROM fs_order_items
					WHERE order_id = '$order_id'";

        //$db->query($sql);
        $rows = $db->affected_rows($sql);


        // insert data
        $prd_id_array = array();
        // Repeat estores
        if (!isset($_SESSION['cart_cb']))
            return false;

        $product_list = $_SESSION['cart_cb'];
        //        var_dump($product_list);die;
        $price_prd_main = $product_list[0][1];
        $color_id = $product_list[0][2];
        $warranty_id = $product_list[0][3];
        $species_id = $product_list[0][4];
        $origin_id = $product_list[0][7];
        //         calculator color
        $color_name = '';
        $color_price = '';
        if ($product_list[0][2]) {
            $color = $this->get_record_by_id($product_list[0][2], 'fs_products_colors');
            $color_name = $color->name;
        }

        // calculator status
        $warranty_name = '';
        $warranty_price = '';
        if ($product_list[0][3]) {
            $warranty = $this->get_record_by_id($product_list[0][3], 'fs_warranty');
            $warranty_name = $warranty->name;
        }

        $species_name = '';
        $species_price = '';
        if ($product_list[0][4]) {
            $species = $this->get_record_by_id($product_list[0][4], 'fs_species');
            $species_name = $species->name;
        }
        $origin_name = '';
        $origin_price = '';
        if ($product_list[0][7]) {
            $origin = $this->get_record_by_id($product_list[0][7], 'fs_origin');
            $origin_name = $origin->name;
        }
        //var_dump($origin_name);die;
        $list_prd_cb = $product_list['0']['6'];
        $list_prd_cb_arr = explode(',', $list_prd_cb);
        //        var_dump($list_prd_cb_arr);die;

        $sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,color_id,color_name,color_price,warranty_id,warranty_name,warranty_price,species_id,species_name,species_price,origin_id,origin_name,origin_price)
			VALUES ";
        $array_insert = array();
        for ($i = 0; $i < count($list_prd_cb_arr); $i++) {
            $prd = $list_prd_cb_arr[$i];
            $prd_detail = $this->get_record('id=' . $prd, 'fs_products', 'name,code,alias,category_id,category_id_wrapper,category_alias,category_alias_wrapper,price,price_old,price_compare');
            if ($prd_detail->price_compare) {
                $detail_prd = $prd_detail->price_compare;
            } else {
                $detail_prd = $prd_detail->price;
            }
            if ($i == 0) {
                $array_insert[] = "('$order_id','$prd','','','$price_prd_main','$color_id','$color_name','$color_price','$warranty_id','$warranty_name','$warranty_price','$species_id','$species_name','$species_price','$origin_id','$origin_name','$origin_price') ";
                //                var_dump($product_list[0][1]);
                //                var_dump($array_insert);
                //                die;
            } else {
                $array_insert[] = "('$order_id','$prd','','','$detail_prd','$color_id','$color_name','$color_price','$warranty_id','$warranty_name','$warranty_price','$species_id','$species_name','$species_price','$origin_id','$origin_name','$origin_price') ";
            }
        }
        //        var_dump($array_insert);
        //        die;

        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
        //                echo $sql;die;
        //                $db->query($sql);
            $rows = $db->affected_rows($sql);
            return true;
        } else {
            return;
        }

    }

    function save_order_items_member($order_id)
    {
        //			var_dump($order_id);die;
        if (!$order_id)
            return false;

        global $db, $config;

        // remove before update or inser
        $sql = " DELETE FROM fs_order_items
					WHERE order_id = '$order_id'";

        //$db->query($sql);
        $rows = $db->affected_rows($sql);


        // insert data
        $prd_id_array = array();
        // Repeat estores
        if (!isset($_SESSION['cart']))
            return false;

        $product_list = $_SESSION['cart'];
        //        var_dump($product_list);

        $sql = " INSERT INTO fs_order_items (order_id,product_id,price,count,total,warranty_id,warranty_name,warranty_price,id_sub,list_gift,aspect)
			VALUES ";
        $array_insert = array();
        for ($i = 0; $i < count($product_list); $i++) {
            $prd = $product_list[$i];
            $price = $prd[1];
            $total = $price * $prd[3];

            // calculator status
            $warranty_name = '';
            $warranty_price = '';
            if ($prd[2]) {
                $warranty = $this->get_record_by_id($prd[2], 'fs_warranty_price');
                $warranty_name = $warranty->warranty_name;
                $warranty_price = $warranty->price;
            }
            $list_gift = '';
            if ($prd[6]) {
                $list_gift = trim($prd[6],',');
            }

            $array_insert[] = "('$order_id','$prd[0]','$price','$prd[3]','$total','$prd[2]','$warranty_name','$warranty_price','$prd[4]','$list_gift','$prd[7]') ";

        }
        //var_dump($array_insert);die;
        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            //                echo $sql;die;
            //                $db->query($sql);
            $rows = $db->affected_rows($sql);
            return true;
        } else {
            return;
        }

    }

    /*
     * Save new data into fs_order
     * For 1 case: member buy
     */
    function eshopcart2_save_new()
    {
        if (!isset($_SESSION['cart']))
            return false;
        $product_list = $_SESSION['cart'];

        $prd_id_array = array();
        $total_before_discount = 0;
        $total_after_discount = 0;
        $products_count = 0;
        // 	Repeat products

        global $config;
        for ($i = 0; $i < count($product_list); $i++) {

            $prd = $product_list[$i];
            $prd_id_array[] = $prd[0];
            $total_before_discount += $prd[1];

            // $total_before_discount += $prd[1]*$prd[2];

            // calculator color
            if ($prd[2]) {
                $color = $this->get_record_by_id($prd[2], 'fs_products_colors');
            }
            // calculator memory
            //                if ($prd[3]) {
            //                    $memory = $this->get_record_by_id($prd[3], 'fs_memory');
            //                }

            // calculator memory
            if ($prd[3]) {
                $warranty = $this->get_record_by_id($prd[3], 'fs_warranty');
            }


            // calculator memory
            if ($prd[4]) {
                $species = $this->get_record_by_id($prd[4], 'fs_species');
            }
            // calculator memory
            if ($prd[5]) {
                $origin = $this->get_record_by_id($prd[5], 'fs_origin');
            }

            // calculator warranty

        }
        $total_after_discount = $prd[1];
        $prd_id_str = implode(',', $prd_id_array);
        $session_id = session_id();

        $row = array();

        $row['products_id'] = $prd_id_str;
        $row['is_temporary'] = 0;
        $row['session_id'] = $session_id;
        $row['total_after_discount'] = $total_after_discount;
        $row['products_count'] = $products_count;
        $row['sender_name'] = FSInput::get('sender_name');
        $row['sender_sex'] = FSInput::get('sender_sex');
        $row['sender_telephone'] = FSInput::get('sender_telephone');
        $row['sender_email'] = FSInput::get('sender_email');
        $row['sender_city'] = FSInput::get('sender_city');
        $row['sender_district'] = FSInput::get('sender_district');
        $row['sender_address'] = FSInput::get('sender_address');
        $row['sender_comments'] = FSInput::get('sender_note');
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['edited_time'] = date("Y-m-d H:i:s");


        //            var_dump($row);die;
        $id = $this->_add($row, 'fs_order');

        // update
        $this->save_order_items($id);

        if ($id) {
            unset($_SESSION['cart']);
        }
        return $id;
    }

    //lưu thông tin đặt hàng combo
    function eshopcart2_save_new_cb()
    {
        if (!isset($_SESSION['cart_cb']))
            return false;
        $product_list = $_SESSION['cart_cb'];
        //        var_dump($product_list['0']['0']);
        //        var_dump($_SESSION['cart_cb']);die;
        $prd_id_array = '';
        $total_before_discount = 0;
        $total_after_discount = 0;
        $products_count = 0;
        // 	Repeat products

        global $config;
        for ($i = 0; $i < count($product_list); $i++) {

            $prd = $product_list[$i];
            $prd_id_array = $prd[6];
            $total_before_discount += $prd[5];

            // $total_before_discount += $prd[1]*$prd[2];

            // calculator color
            if ($prd[2]) {
                $color = $this->get_record_by_id($prd[2], 'fs_products_colors');
            }
            // calculator memory
            //                if ($prd[3]) {
            //                    $memory = $this->get_record_by_id($prd[3], 'fs_memory');
            //                }

            // calculator memory
            if ($prd[3]) {
                $warranty = $this->get_record_by_id($prd[3], 'fs_warranty');
            }


            // calculator memory
            if ($prd[4]) {
                $species = $this->get_record_by_id($prd[4], 'fs_species');
            }
            // calculator memory
            if ($prd[7]) {
                $origin = $this->get_record_by_id($prd[7], 'fs_origin');
            }

            // calculator warranty

        }
        $total_after_discount = $prd[5];
        $list_prd_cb = $prd_id_array;
        $session_id = session_id();

        $row = array();

        $row['products_id'] = $list_prd_cb;
        $row['is_temporary'] = 0;
        $row['session_id'] = $session_id;
        $row['total_after_discount'] = $total_after_discount;
        $row['products_count'] = $products_count;
        $row['sender_name'] = FSInput::get('sender_name_cb');
        $row['sender_sex'] = FSInput::get('sender_sex_cb');
        $row['sender_telephone'] = FSInput::get('sender_telephone_cb');
        $row['sender_email'] = FSInput::get('sender_email_cb');
        $row['sender_city'] = FSInput::get('sender_city_cb');
        $row['sender_district'] = FSInput::get('sender_district_cb');
        $row['sender_address'] = FSInput::get('sender_address_cb');
        $row['sender_comments'] = FSInput::get('sender_note_cb');
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['edited_time'] = date("Y-m-d H:i:s");


        //            var_dump($row);die;
        $id = $this->_add($row, 'fs_order');

        // update
        $this->save_order_items_cb($id);

        if ($id) {
            unset($_SESSION['cart_cb']);
        }
        return $id;
    }

    function save_member()
    {
        $csrf = FSInput::get('csrf');
        if(!$csrf)
            return false;
        $csrf = explode('-',base64_decode($csrf));
        if($csrf[1] != $_SESSION["order_security"]){
            return false;
        }
        if (!isset($_SESSION['cart']))
            return false;
        $info_guest = $_SESSION['info_guest'];
        $product_list = $_SESSION['cart'];
        //        var_dump($info_guest);
        //        var_dump($product_list);
        $prd_id_array = array();
        $prd_sub_id_array = array();

        //        $total_before_discount = 0;
        //        $total_after_discount = 0;
        $products_count = 0;
        // 	Repeat products

        global $config,$user;
        for ($i = 0; $i < count($product_list); $i++) {
            $prd = $product_list[$i];
            if (in_array($prd[0], $prd_id_array)) {
            } else {
                $prd_id_array[] = $prd[0];
            }
            $prd_sub_id_array[] = $prd[4];
            $aspect_id_array[] = $prd[7];
            //            $total_before_discount += $prd[5];
            //            $total_before_discount += $prd[1] * $prd[3];
            // calculator warranty
            $products_count += $prd[3];
        }
        $fee = FSInput::get('fee');
        if ($fee == '') {
            $fee = 0;
        }

        $discount_admin = 0;
        if($user->userID){
            $discount_admin = FSInput::get('discount_admin',0);
        }

        $total_before_discount = FSInput::get('before_discount');
        $total_after_discount = FSInput::get('total_price');
        $total_end = $total_after_discount + $fee - $discount_admin;

        $prd_id_str = implode(',', $prd_id_array);
        $prd_sub_id_str = implode(',', $prd_sub_id_array);
        $aspect_id_str = implode(',', $aspect_id_array);
        $session_id = session_id();
        //var_dump($prd_id_str);
        //var_dump($prd_sub_id_str);die;
        $row = array();

        if($user->userID){
            $row['user_id'] = $user->userID;
            $row['username'] = $user->userInfo->username;
            $row['email'] = $user->userInfo->email;
            $row['user_is_admin'] = $user->userInfo->is_admin;
        }
        $row['admin_discount'] = $discount_admin;

        $row['products_id'] = $prd_id_str;
        $row['products_id_sub'] = $prd_sub_id_str;
        $row['aspects'] = $aspect_id_str;
        $row['is_temporary'] = 0;
        $row['session_id'] = $session_id;
        $row['total_before_discount'] = $total_before_discount;
        $row['total_after_discount'] = $total_after_discount;
        $row['total_end'] = $total_end;
        $row['fee'] = $fee;
        $row['discount_money'] = $total_before_discount - $total_after_discount;
        if (FSInput::get('inputcode', 'int') == 1) {
            $row['discount_code'] = FSInput::get('name_discount');
        }
        $row['products_count'] = $products_count;
        $row['shipping'] = $info_guest['shipping'];
        $row['sender_comments'] = $info_guest['sender_comments'];
        $row['sender_name'] = $info_guest['sender_name'];
        $row['sender_sex'] = $info_guest['sender_sex'];
        $row['sender_telephone'] = $info_guest['sender_telephone'];
        $row['sender_email'] = $info_guest['sender_email'];

        //        $info_guest['sender_email'] = FSInput::get('sender_email');
        if ($info_guest['shipping'] == 1) {
            $row['sender_city'] = $info_guest['sender_city'];
            $row['sender_district'] = $info_guest['sender_district'];
            $row['sender_ward'] = $info_guest['sender_ward'];
            $row['sender_address'] = $info_guest['sender_address'];


            $row['address_detail'] = $info_guest['sender_address'] . ', ' . $info_guest['ward_name'] . ', ' . $info_guest['district_name'] . ', ' . $info_guest['city_name'];
            $row['update_data'] = $info_guest['update'];
        } else {
            $row['store'] = $info_guest['store'];
            $row['address_detail'] = $info_guest['store'];
            $row['sender_address'] = $info_guest['ward_name'].','.$info_guest['district_name'].','.$info_guest['city_name'];

        }
        $row['city_name'] = $info_guest['city_name'];
        $row['district_name'] = $info_guest['district_name'];
        $row['ward_name'] = $info_guest['ward_name'];
        if (FSInput::get('company') == 1) {
            $row['com_name'] = $info_guest['com_name'];
            $row['com_address'] = $info_guest['com_address'];
            $row['com_tax'] = $info_guest['com_tax'];
        }
        if (FSInput::get('same_address') == 1) {
            $row['re_name'] = $info_guest['re_name'];
            $row['re_telephone'] = $info_guest['re_telephone'];
            $row['re_sex'] = $info_guest['re_sex'];
        }
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['edited_time'] = date("Y-m-d H:i:s");
//                var_dump($row);
//                die;
        $id = $this->_add($row, 'fs_order');
        // update
        $this->save_order_items_member($id);

        $this->add_bitrix_deal($row, $id);
        //die;
        if ($id) {
        //            if(!empty($row['discount_code'])){
        //                $this->update_code($row['discount_code']);
        //            }
            unset($_SESSION['cart']);
            //            unset($_SESSION['info_guest']);
        }
        return $id;
    }

    function save_payment($payment_method, $order_id)
    {
        $row = array();
        $row['payment_method'] = $payment_method;
        if ($row['payment_method'] == 20) {
            $row['payment_name'] = 'Thanh toán khi giao hàng (COD)';
        } elseif ($row['payment_method'] == 1) {
            $row['payment_name'] = 'Sử dụng thẻ ATM nội địa';
        } elseif ($row['payment_method'] == 2) {
            $row['payment_name'] = 'Sử dụng thẻ Visa/Master card(Bảo Kim)';
        } elseif ($row['payment_method'] == 2950) {
            $row['payment_name'] = 'Chuyển khoản ngân hàng';
        } elseif ($row['payment_method'] == 295) {
            $row['payment_name'] = 'Chuyển khoản ngân hàng qua cổng Bảo Kim';
        } elseif ($row['payment_method'] == 297) {
            $row['payment_name'] = 'Thanh toán qua VNPAY-QR(Bảo Kim)';
        } elseif ($row['payment_method'] == 311) {
            $row['payment_name'] = 'Ví điện tử Momo(Bảo Kim)';
        } elseif ($row['payment_method'] == 316) {
            $row['payment_name'] = 'Ví điện tử ViettelPay(Bảo Kim)';
        } elseif ($row['payment_method'] == 21) {
            $row['payment_name'] = 'Thanh toán tại cửa hàng';
        } elseif ($row['payment_method'] == 500) {
            $row['payment_name'] = 'Thanh toán qua cổng Kredivo';
        }

        //        $info_guest['sender_email'] = FSInput::get('sender_email');
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['edited_time'] = date("Y-m-d H:i:s");
        //        var_dump($row);
        //        die;

        $id = $this->_update($row, 'fs_order', 'id = ' . $order_id, 0);
        //        echo $id;
        // update
        $this->update_bitrix_deal($row['payment_name'], $order_id);
        //        $this->add_bitrix_deal($row, $id);
        //die;
        $this->add_EC_deal($row['payment_name'], $order_id);
        // echo 1;die;
        return $id;
    }

    function add_EC_deal($payment_name, $order_id)
    {
         // $zone_record = $this->get_record('id = 1', 'fs_api_login', 'id,name');
        // $session_id_record = $this->get_record('id = 2', 'fs_api_login', 'id,name,created_time');
        // $zone = $zone_record->name;
        // $session_id = $session_id_record->name;

        $login = $this->get_record('name = "'.$this->USER_ID_EC.'"', 'fs_api_login');
        $zone = $login->zone;
        $session_id = $login->session;
        $time1 = strtotime($login->created_time);
        $time2 = strtotime(date('Y-m-d H:i:s'));
        $difference = abs($time2 - $time1) / 3600;
        if($difference > 1){
            $log = $this->api_login($login->zone,$this->COM_CODE_EC,$this->API_CERT_KEY_EC);
            $zone = $log[0];
            $session_id = $log[1];
        }
        // print_r($log);
        $order = $this->get_record('id = ' . $order_id, 'fs_order');
        $order_item = $this->get_records('order_id = '.$order_id,'fs_order_items');
        $this->add_EC_customer($zone, $session_id, $order);
        global $user;
        // ADD_CD_02
        // Mã 	Tên trường 	Ghi chú
        // 01	Đã Thanh Toán	Đã Thanh Toán
        // 02	Chưa thanh toán	Chưa thanh toán
        // 03	Thanh Toán Một Phần	Khách hàng đã thanh toán 1 phần đặt cọc
        $url = 'https://oapi' . $zone . '.ecount.com/OAPI/V2/SaleOrder/SaveSaleOrder?SESSION_ID=' . $session_id . '';
        $list_order = [];
        $receive = '';
        if($order->re_name){
            $receive .= '
Gọi người khác nhận: '.$order->re_name.' - '.$order->re_telephone;
        }
        $company = '';
        if($order->com_name){
            $company .= '
Xuất hóa đơn công ty: '.$order->com_name.' - '.$order->com_address.' - '.$order->com_tax;
        }
        $update_data = '';
        if($order->update_data){
            $update_data .= '
Chuyển danh bạ, dữ liệu qua máy mới.';
        }
        foreach($order_item as $item){
            $sub = $this->get_record('id = '.$item->id_sub,'fs_products_sub');
            $pro = $this->get_record('id='.$item->product_id,'fs_products');
            $cat = $this->get_record('id = '.$pro->category_id,'fs_products_categories','id,accessories');
            if(!$pro->accessories)
                $accessories = $cat->accessories;
            else
                $accessories = $pro->accessories;
            $item_sale = '';
            if($user->userID && $user->userInfo->is_admin == 1)
                $item_sale .= '
- Nhân viên đặt.                
                ';
            else
                $item_sale .= '
- Khách đặt.                
                ';
            $item_sale .= '
- '.count($order_item).' sản phẩm. Tổng giá: '.format_money_0($order->total_end,'đ').'    
            ';

            $item_sale .= '
- Khuyến mại: '.strip_tags($accessories).'      
            ';
            $list_order[] = [
                "Line" => "0",
                "BulkDatas" => [
                    "IO_DATE" => "",
                    "CUST" => $order->sender_telephone,
                    "CUST_DES" => $order->sender_name,
                    "EMP_CD" => $user->userID && $user->userInfo->is_admin == 1 ? $user->userInfo->nv_code : "ThangTC",
                    "WH_CD" => $user->userID && $user->userInfo->is_admin == 1 ? $user->userInfo->nv_store : "01OL",
                    "DOC_NO" => $order->id,
                    "REF_DES" => $order->id,
                    "U_TXT1" => $user->userID && $user->userInfo->is_admin == 1 ? "Đơn hàng tại Shop" : "Đơn hàng lập tại Website" . $item_sale, //thêm KM sp nếu có
                    "PROD_CD" => $sub->code,
                    "PROD_DES" => $pro->name.' '.$sub->name,
                    "QTY" => $item->count,
                    "PRICE" => $item->price,
                    "SUPPLY_AMT" => $item->total,
                    "ADD_CD_01" => "02",
                    "ADD_CD_02" => "02",
                    "ADD_LTXT_02_T" => $order->sender_address,
                    "ADD_LTXT_01_T" => $order->sender_comments.$receive.$company,
                    "ADD_CD_NM_01" => "Website",
                    "ADD_CD_NM_03" => "Chưa thanh toán",
                    "ADD_LTXT_03_T" => $payment_name
                ]
            ];
        }
        $field = [
            "SaleOrderList" => $list_order
        ];
        // echo $url;
        // print_r(json_encode($field));die;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900); //timeout in seconds
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($ch);
        $rs = json_decode($result);
        // print_r($rs);die;
        return;
    }

    function add_EC_deal_view()
    {
        $payment_name = 'Thanh toán test';
        $order_id = 6962;
        // $zone_record = $this->get_record('id = 1', 'fs_api_login', 'id,name');
        // $session_id_record = $this->get_record('id = 2', 'fs_api_login', 'id,name,created_time');
        // $zone = $zone_record->name;
        // $session_id = $session_id_record->name;

        $login = $this->get_record('name = "TieuKim"', 'fs_api_login');
        $zone = $login->zone;
        $session_id = $login->session;
        $time1 = strtotime($login->created_time);
        $time2 = strtotime(date('Y-m-d H:i:s'));
        $difference = abs($time2 - $time1) / 3600;
        if($difference > 1){
            $log = $this->api_login();
            $zone = $log[0];
            $session_id = $log[1];
        }

        // print_r($log);
        $order = $this->get_record('id = ' . $order_id, 'fs_order');
        $order_item = $this->get_records('order_id = '.$order_id,'fs_order_items');
        $this->add_EC_customer($zone, $session_id, $order);
        global $user;
        // ADD_CD_02
        // Mã 	Tên trường 	Ghi chú
        // 01	Đã Thanh Toán	Đã Thanh Toán
        // 02	Chưa thanh toán	Chưa thanh toán
        // 03	Thanh Toán Một Phần	Khách hàng đã thanh toán 1 phần đặt cọc
        $url = 'https://oapi' . $zone . '.ecount.com/OAPI/V2/SaleOrder/SaveSaleOrder?SESSION_ID=' . $session_id . '';
        $list_order = [];
        $receive = '';
        if($order->re_name){
            $receive .= '
Gọi người khác nhận: '.$order->re_name.' - '.$order->re_telephone;
        }
        $company = '';
        if($order->com_name){
            $company .= '
Xuất hóa đơn công ty: '.$order->com_name.' - '.$order->com_address.' - '.$order->com_tax;
        }
        $update_data = '';
        if($order->update_data){
            $update_data .= '
Chuyển danh bạ, dữ liệu qua máy mới.';
        }
        foreach($order_item as $item){
            $sub = $this->get_record('id = '.$item->id_sub,'fs_products_sub');
            $pro = $this->get_record('id='.$item->product_id,'fs_products');
            $item_sale = '
Khuyến mại: '.strip_tags($pro->accessories).'            
            ';
            $list_order[] = [
                "Line" => "0",
                "BulkDatas" => [
                    "IO_DATE" => "",
                    "CUST" => $order->sender_telephone,
                    "CUST_DES" => $order->sender_name,
                    "EMP_CD" => $user->userID && $user->userInfo->is_admin == 1 ? $user->userInfo->nv_code : "ThangTC",
                    "WH_CD" => $user->userID && $user->userInfo->is_admin == 1 ? $user->userInfo->nv_store : "01OL",
                    "DOC_NO" => $order->id,
                    "REF_DES" => $order->id,
                    "U_TXT1" => $user->userID && $user->userInfo->is_admin == 1 ? "Đơn hàng tại shop" : "Đơn hàng Online" . $item_sale, //thêm KM sp nếu có
                    "PROD_CD" => $sub->code,
                    "PROD_DES" => $pro->name.' '.$sub->name,
                    "QTY" => $item->count,
                    "PRICE" => $item->price,
                    "SUPPLY_AMT" => $item->total,
                    "ADD_CD_01" => "02",
                    "ADD_CD_02" => "02",
                    "ADD_LTXT_02_T" => $order->sender_address,
                    "ADD_LTXT_01_T" => $order->sender_comments.$receive.$company,
                    "ADD_CD_NM_01" => "Website",
                    "ADD_CD_NM_03" => "Chưa thanh toán",
                    "ADD_LTXT_03_T" => $payment_name
                ]
            ];
        }
        $field = [
            "SaleOrderList" => $list_order
        ];
        // echo $url;
        // print_r(json_encode($field));die;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900); //timeout in seconds
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($ch);
        $rs = json_decode($result);
        print_r($rs);die;
        return;
    }

    // add Customer to EC
    function add_EC_customer($zone, $session_id, $order)
    {
        $url = 'https://oapi' . $zone . '.ecount.com/OAPI/V2/AccountBasic/SaveBasicCust?SESSION_ID=' . $session_id . '';
        $field = [
            "CustList" => [
                [
                    "Line" => "0",
                    "BulkDatas" => [
                        "BUSINESS_NO" => $order->sender_telephone,
                        "CUST_NAME" => $order->sender_name,
                        "TEL" => $order->sender_telephone,
                        "EMAIL" => "",
                        "ADDR" => $order->sender_address
                    ]
                ]
            ]
        ];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900); //timeout in seconds
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($ch);
        $rs = json_decode($result);
        return;
    }

    //get zone to login EC
    function api_get_zone()
    {
        $url = 'https://oapi.ecount.com/OAPI/V2/Zone';
        $field = array(
            'COM_CODE' => $this->COM_CODE_EC,
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900); //timeout in seconds
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($ch);
        $rs = json_decode($result);
        // print_r($rs);die;
        if ($rs->Status == '200') {
            $row['zone'] = $rs->Data->ZONE;
            $row['created_time'] = date('Y-m-d H:i:s');
            $this->_update($row, 'fs_api_login', 'name = "'.$this->USER_ID_EC.'"', 0);
            return $rs->Data->ZONE;
        } else
            return false;
    }

    //login EC
    function api_login()
    {
        $zone = $this->api_get_zone();
        if ($zone == false) {
            return false;
        }
        $url = 'https://oapi' . $zone . '.ecount.com/OAPI/V2/OAPILogin';
        $field = array(
            "COM_CODE" => $this->COM_CODE_ECde,
            "USER_ID" => $this->USER_ID_EC,
            // "API_CERT_KEY" => "2ae181cf075c14a2bba982de4b76f5d4b0",
            // "API_CERT_KEY" => "23b965aa52ed64b9d850fe029b27d70d40",
            "API_CERT_KEY" => $this->API_CERT_KEY_EC,
            "LAN_TYPE" => "vi-VN",
            "ZONE" => $zone
        );
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($field));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 900); //timeout in seconds
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
        ));
        $result = curl_exec($ch);
        $rs = json_decode($result);
        // print_r($rs);die;
        if ($rs->Status == '200') {
            $row['session'] = $rs->Data->Datas->SESSION_ID;
            $row['created_time'] = date('Y-m-d H:i:s');
            $this->_update($row, 'fs_api_login', 'name = "TieuKim"', 0);
            $arr[0] = $zone;
            $arr[1] = $rs->Data->Datas->SESSION_ID;
            return $arr;
        } else
            return false;
    }

    function update_code($code)
    {
        global $db;
        $sql = " UPDATE fs_discount_code 
						SET count = count - 1
						WHERE  name = '" . $code . "'
					 ";
        //            echo $sql;die;
        $db->query($sql);
        $up = $db->affected_rows();
    }

    function update_bitrix_deal($payment_name,$id){
        $order = $this->get_record_by_id($id, 'fs_order', 'id,bitrix_id,sender_comments,user_is_admin');
        $text_admin = '';
        if($order->user_is_admin == 1)
            $text_admin = ' tại shop. Đã thanh toán';
        if ($order->bitrix_id != '' && $order->bitrix_id != null) {
            require_once PATH_BASE . 'libraries/bitrix/src/crest.php';
            $list = $this->get_records('order_id = '.$id,'fs_order_items','id,product_id,id_sub,count');
            // print_r($list);die;
            foreach ($list as $item){
                $product = $this->get_record('id='.$item->product_id,'fs_products','id,name');
                $sub = $this->get_record('id = '.$item->id_sub,'fs_products_sub','id,name');
                $arr[] = "$product->name - $sub->name - SL $item->count";
            }
            $str = implode(' | ',$arr);
            $rs = CRest::call('crm.deal.update',
                [
                    'id' => $order->bitrix_id,
                    'fields' => [
                        "COMMENTS" => "
- Loại: Đơn hàng$text_admin.
- Loại thanh toán: $payment_name.
- Ghi chú: $order->sender_comments.
- $str
                    "
                    ]
                ]
            );
        }
        return;
    }

    function update_baokim_bitrix_deals($order_id)
    {
        global $db;
        $order = $this->get_record_by_id($order_id, 'fs_order', 'id,bitrix_id');
        if ($order->bitrix_id != '' && $order->bitrix_id != null) {
            require_once PATH_BASE . 'libraries/bitrix/src/crest.php';
            $rs = CRest::call('crm.deal.update',
                [
                    'id' => $order->bitrix_id,
                    'fields' => [
                        "UF_CRM_1644995613" => 782 //trạng thái thanh toán - thanh toán toàn bộ
                    ]
                ]
            );
        }

        return;
    }

    function add_bitrix_deal($row, $order_id)
    {
        require_once PATH_BASE . 'libraries/bitrix/src/crest.php';

        $store_id = '';
        if ($row['store']) {
            $rs_store = CRest::call('crm.deal.userfield.get',
                [
                    'id' => 394 //id trường danh sách cửa hàng bitrix
                ]
            );
            $store_name = $this->get_record_by_id($row['store'], 'fs_address', 'id,name')->name;
            if (!empty($store_name)) {
                foreach ($rs_store['result']['LIST'] as $item) {
                    if ($store_name == $item['VALUE']) {
                        $store_id = $item['ID'];
                        break;
                    }
                }
            }
            $store_status = 570; //nhận tại cửa hàng
        } else
            $store_status = 568; //nhận hàng từ xa

        $contact_tel = $row['sender_telephone'];
        $rs_contact = CRest::call('crm.contact.list',
            [
                "filter" => [
                    "PHONE" => $contact_tel
                ],
                "select" => ["ID", "NAME", "PHONE", "EMAIL", "ADDRESS", "ADDRESS_CITY", "ADDRESS_REGION", "ADDRESS_PROVINCE", "ADDRESS_COUNTRY", "TYPE_ID", "SOURCE_ID", "ASSIGNED_BY_ID", "MODIFY_BY_ID"]
            ]
        );
        if (empty($rs_contact['result']))
            $rs_contact = CRest::call('crm.contact.list',
                [
                    "filter" => [
                        "PHONE" => '+' . $contact_tel
                    ],
                    "select" => ["ID", "NAME", "PHONE", "EMAIL", "ADDRESS", "ADDRESS_CITY", "ADDRESS_REGION", "ADDRESS_PROVINCE", "ADDRESS_COUNTRY", "TYPE_ID", "SOURCE_ID", "ASSIGNED_BY_ID", "MODIFY_BY_ID"]
                ]
            );
        if (empty($rs_contact['result']))
            $rs_contact = CRest::call('crm.contact.list',
                [
                    "filter" => [
                        "PHONE" => '+84' . substr($contact_tel, 1)
                    ],
                    "select" => ["ID", "NAME", "PHONE", "EMAIL", "ADDRESS", "ADDRESS_CITY", "ADDRESS_REGION", "ADDRESS_PROVINCE", "ADDRESS_COUNTRY", "TYPE_ID", "SOURCE_ID", "ASSIGNED_BY_ID", "MODIFY_BY_ID"]
                ]
            );

        $user_sign = 1;
        if ($rs_contact['total'] > 0) {
            $contat_id = $rs_contact['result'][0]['ID'];
            $user_sign = $rs_contact['result'][0]['ASSIGNED_BY_ID'];
            $rs_add = CRest::call('crm.contact.update',
                [
                    "id" => $contat_id,
                    "fields" => [
                        "NAME" => $row['sender_name'],
                        "ADDRESS" => $row['address_detail'],
                        "ADDRESS_CITY" => $row['district_name'],
                        "ADDRESS_REGION" => $row['ward_name'],
                        "ADDRESS_PROVINCE" => $row['city_name'],
                        "ADDRESS_COUNTRY" => 'Việt Nam',
                        "EMAIL" => [
                            [
                                "VALUE" => $row['sender_email'],
                                "VALUE_TYPE" => "WORK"
                            ]
                        ],
                    ]
                ]
            );
        } else {
            $rs_add = CRest::call('crm.contact.add',
                [
                    "fields" => [
                        "NAME" => $row['sender_name'],
                        "OPENED" => "Y",
                        "ASSIGNED_BY_ID" => $user_sign,
                        "TYPE_ID" => "CLIENT",
                        "SOURCE_ID" => "SELF",
                        "PHONE" => [
                            [
                                "VALUE" => $row['sender_telephone'],
                                "VALUE_TYPE" => "WORK"
                            ]
                        ],
                        "EMAIL" => [
                            [
                                "VALUE" => $row['sender_email'],
                                "VALUE_TYPE" => "WORK"
                            ]
                        ],
                        "ADDRESS" => $row['address_detail'],
                        "ADDRESS_CITY" => $row['district_name'],
                        "ADDRESS_REGION" => $row['ward_name'],
                        "ADDRESS_PROVINCE" => $row['city_name'],
                        "ADDRESS_COUNTRY" => 'Việt Nam',
                    ]
                ]
            );
            $contat_id = $rs_add['result'];
        }

        //        $type_payment = $row['payment_name'];
        $note = $row['sender_comments'];
        $list_cart = $_SESSION['cart'];

        $str_cat = "";
        $check = 0;
        foreach ($list_cart as $c => $cart) {
            $prd_name = $this->get_record_by_id($cart[0], 'fs_products', 'id,name')->name;
            $prd_sub = $this->get_record_by_id($cart[4], 'fs_products_sub', 'id,name,code');
            $type_name = $prd_sub->name;
            if ($c == 0)
                $str_cat .= "$prd_name - $type_name - SL $cart[3]";
            else
                $str_cat .= " --- $prd_name - $type_name - SL $cart[3]";

            $prd_bitrix = CRest::call('crm.product.list',
                [
                    'filter' => [
                        'XML_ID' => $prd_sub->code
                    ]
                ]
            );
            if ($prd_bitrix['total'] > 0)
                $check++;
            else $check--;

            $row_prd[] = [
                "PRODUCT_ID" => $prd_bitrix['result'][0]['ID'],
                "PRICE" => $cart[1],
                "QUANTITY" => $cart[3]
            ];
        }

        $text_admin = '';
        if(@$row['user_is_admin'] == 1)
            $text_admin = ' tại shop. Đã thanh toán';

        $result = CRest::call('crm.deal.add',
            [
                "fields" => [
                    "TITLE" => $row['sender_name'] . ' - Từ Website',
                    "STAGE_ID" => "C4:NEW",
                    "CATEGORY_ID" => 4,
                    "CURRENCY_ID" => "VND",
                    "OPPORTUNITY" => $row['total_end'],
                    "ASSIGNED_BY_ID" => $user_sign,
                    "CONTACT_ID" => $contat_id,
                    "UF_CRM_61DA484985CB2" => $order_id,        //id đơn hàng trên web
                    "UF_CRM_620AF42D903F7" => $store_status,    //nhận tại cửa hàng hay từ xa
                    "UF_CRM_61ECAD7FC4455" => $store_id,        //id cửa hàng
                    "UF_CRM_1644995613" => 778,                 //trạng thái thanh toán - chưa thanh toán
                    "UF_CRM_1645066604" => 860,                 //loại phiếu web - Đơn hàng
                    "COMMENTS" => "
- Loại: Đơn hàng$text_admin.
- Loại thanh toán: Chưa chọn thanh toán.
- Ghi chú: $note.
- $str_cat
                    "
                ]
            ]
        );
        $deal_id = $result['result'];
        if ($check > 0) {
            $add_prd = CRest::call('crm.deal.productrows.set',
                [
                    "id" => $deal_id,
                    "rows" => $row_prd
                ]
            );
        }
        if ($deal_id == 0 || $deal_id == '') {
            $this->_update(array('bitrix_false' => json_encode($result)), 'fs_order', 'id = ' . $order_id, 0);
            $result = CRest::call('crm.deal.add',
                [
                    "fields" => [
                        "TITLE" => $row['sender_name'] . ' - Từ Website',
                        "STAGE_ID" => "C4:NEW",
                        "CATEGORY_ID" => 4,
                        "CURRENCY_ID" => "VND",
                        "OPPORTUNITY" => $row['total_end'],
                        "ASSIGNED_BY_ID" => $user_sign,
                        "CONTACT_ID" => $contat_id,
                        "UF_CRM_61DA484985CB2" => $order_id,        //id đơn hàng trên web
                        "UF_CRM_620AF42D903F7" => $store_status,    //nhận tại cửa hàng hay từ xa
                        "UF_CRM_61ECAD7FC4455" => $store_id,        //id cửa hàng
                        "UF_CRM_1644995613" => 778,                 //trạng thái thanh toán
                        "UF_CRM_1645066604" => 860,                 //loại phiếu web - Đơn hàng
                        "COMMENTS" => "
- Loại: Đơn hàng$text_admi.
- Loại thanh toán: Chưa chọn thanh toán.
- Ghi chú: $note.
- $str_cat
                    "
                    ]
                ]
            );
            $deal_id = $result['result'];
            $this->_update(array('bitrix_id' => $deal_id,'bitrix_log'=>1), 'fs_order', 'id = ' . $order_id, 0);
        } else
            $this->_update(array('bitrix_id' => $deal_id,'bitrix_log'=>1), 'fs_order', 'id = ' . $order_id, 0);

        return;
    }

    function getProduct_main($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						FROM fs_products  
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject('',USE_MEMCACHE);
        return $result;
    }
    function getProduct_gift($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        }
        $query = " SELECT price_new, product_gift_id
						FROM fs_accompanying_detail  
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject('',USE_MEMCACHE);
        return $result;
    }
    function get_gift($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        }
        $query = " SELECT id, name, alias, price, price_old, image
						FROM fs_products  
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject('',USE_MEMCACHE);
        return $result;
    }
    function getCat_main($id)
    {
        if ($id) {
            $where = " id = '$id' ";
        } else {
            die('Not exist this url');
        }
        $query = " SELECT id, name, accessories 
						FROM fs_products_categories  
						WHERE published = 1 AND 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject('',USE_MEMCACHE);
        return $result;
    }
    function getSub_main($id)
    {
        if ($id) {
            $where = " product_id = '$id' ";
        } else {
            die('Not exist this url');
        }
        $query = " SELECT id, name, code, product_id, image, quantity  
						FROM fs_products_sub  
						WHERE published = 1 AND 
						" . $where . " ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }
    function get_codebyqty($id)
    {
        global $db;
        $query = "  SELECT sub_id, product_code, id ,SUM(quantity) as quan
                    FROM fs_products_price_store 
                    WHERE product_id = $id GROUP BY sub_id HAVING SUM(quantity) > 0";
        $db->query($query);
        $total = $db->getObjectList('',USE_MEMCACHE);
        return $total;
    }
    function get_stores_quan($id, $code, $transport)
    {
        global $db;
        $query = "  SELECT sum(quantity) as quan
                    FROM fs_products_price_store 
                    WHERE area_id = " . $id . " AND product_code = '" . $code . "' AND is_transport = $transport";
        $db->query($query);
        $total = $db->getResult('',USE_MEMCACHE);
        return $total;
    }
    function get_estore_type($eid)
    {
        if (!$eid)
            return;
        $query = " SELECT estore_type
						FROM fs_estores
						WHERE  id = $eid ";
        global $db;
        $db->query($query);
        return $rs = $db->getResult();
    }
    function get_orderItem($id)
    {
        $query = " SELECT a.price, a.total, a.count, b.alias, b.id, b.code, b.name, b.category_name  
						FROM fs_order_items as a INNER JOIN fs_products as b 
						ON a.product_id = b.id  
						WHERE a.order_id =".$id;
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    /*
     * Save data from eshopcart form
     * Data: sim_number of member
     */
    function eshopcart_save()
    {

        // check exist:
        $order_temporary = $this->getOrder();

        $username = FSInput::get('member_number');
        $session_id = session_id();
        if (!$username)
            return false;

        $time = date("Y-m-d H:i:s");

        // insert if not exist
        if (!$order_temporary) {
            $sql = " INSERT INTO 
						fs_order (`username`,is_temporary,session_id
									,created_time,edited_time,is_activated)
						VALUES ('$username','1','$session_id',
									'$time','$time','0');
						";
            global $db;
//				$db->query($sql);
            $id = $db->insert($sql);
            return $id;

        } // update if exist
        else {

            $sql = " UPDATE  fs_order SET 
			 				`username` = '$username',
							edited_time = '$time'
						WHERE  session_id = '$session_id' 
							AND is_temporary = 1 
					";
            global $db;
            //$db->query($sql);
            $rows = $db->affected_rows($sql);
            return $rows;
        }
    }

    /*
     * Display fulname from sim_number
     */
    function get_member_by_username($username)
    {
        if (!$username)
            return;
        $query = " SELECT fname,lname,mname
						FROM fs_members 
						WHERE  username = '$username' ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    function get_user()
    {
        if (!isset($_SESSION['username']))
            return false;
        $username = $_SESSION['username'];
        if (!$username)
            return;
        $query = " SELECT *
						FROM fs_members 
						WHERE  username = '$username' ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }

    function get_user_id()
    {
        $username = $_SESSION['username'];
        if (!$username)
            return;
        $query = " SELECT id
						FROM fs_members 
						WHERE  username = '$username' ";
        global $db;
        $db->query($query);
        return $rs = $db->getResult();
    }

    /*
     * For ajax
     * Display fulname from sim_number
     */
    function ajax_get_member()
    {
        $sim_number = FSInput::get('sim_number');
        if (!$sim_number)
            return;
        $query = " SELECT fname,lname,mname
						FROM fs_members 
						WHERE  sim_number = '$sim_number' ";
        global $db;
        $db->query($query);
        return $rs = $db->getObject('',USE_MEMCACHE);
    }


    /*
     * update into fs_order
     * change payment_method
     */
    function shipping_save()
    {
        $eid = FSInput::get('eid', 0, 'int');
        $payment_method = FSInput::get('payment', 0, 'int');
        $transfer_method = FSInput::get('transfer_method');
//			if(!$eid || !$payment_method || !$transfer_method)
        if (!$eid)
            return false;
        $session_id = session_id();
        $time = date("Y-m-d H:i:s");

        // if buy by adress: status = 0
        // if buy direct : status = 4: finished
        $status = $payment_method ? 0 : 4;
        $sql = " UPDATE  fs_order SET 
							payment_method = '$payment_method',
							edited_time = '$time',
							status = $status
						WHERE  session_id = '$session_id' 
							AND estore_id = $eid
							AND is_temporary = 1 
							
					";
        global $db;
        // $db->query($sql);
        $rows = $db->affected_rows($sql);
        return 1;
    }

    /*
     * finished paymenent
     */
    function order_save()
    {
        $session_id = session_id();
        $time = date("Y-m-d H:i:s");
        global $db;

        // get order_id to return
        $query = " SELECT * 
						FROM fs_order
						WHERE  session_id = '$session_id' 
							AND is_temporary = 1 
					";
        $db->query($query);
        $order = $db->getObject('',USE_MEMCACHE);
        $order_id = $order->id;
        if (!$order_id)
            return false;
        $fsstring = FSFactory::getClass('FSString');
        $random_string = $fsstring->generateRandomString(8);
        $code_order = $random_string;

        $sql_u = '';
        if (!$order->payment_method) {
            $sql_u .= ", total_after_discount =  '" . $order->total_after_discount . "'";
        } else {
        }
        $sql = " UPDATE  fs_order SET 
							is_temporary = '0',
							code_order = '$code_order',
							edited_time = '$time'" . $sql_u . "
						WHERE  id = $order_id 
					";
        // $db->query($sql);
        $rows = $db->affected_rows($sql);
        if ($rows) {
            unset($_SESSION['cart']);
        }
        return $rows ? $order_id : 0;
    }

    /*
         * Check pr
         */
    function check_enough_money($money_pr, $username)
    {
        // check money
        if (!$username)
            return false;
        $query = " SELECT count(*)
					FROM fs_members
					WHERE username = '$username'
					ANd money >= $money_pr ";
        global $db;
        $db->query($query);
        $result = $db->getResult();
        if (!$result) {
            FSFactory::include_class('errors');
            Errors:: setError("Tài khoản của bạn không đủ để thực hiện giao dịch này. Bạn có thể nạp tiền để thanh toán sau.");
            return false;
        }
        return true;
    }

    function subtraction_money($money_pr, $username)
    {
        // minus money
        global $db;
        if (!$username)
            return false;
        $sql = "UPDATE fs_members SET `money` = money - " . $money_pr . " WHERE username = '" . $username . "' ";
        // $db->query($sql);
        $rows = $db->affected_rows($sql);
        if (!$rows)
            return false;
    }

    function save_into_history($money_pr, $username)
    {
        if (!$username)
            return false;
        $time = date("Y-m-d H:i:s");
        $row3['money'] = $money_pr;
        $row3['type'] = 'buy';
        $row3['username'] = $username;
        $row3['created_time'] = $time;
        $row3['description'] = 'Đặt hàng';
        $row3['service_name'] = 'Đặt hàng';
        if (!$this->_add($row3, 'fs_history'))
            return false;
    }

    /*
     * Gửi mail cho khách ngay sau khi đặt hàng
     */
    function mail_to_buyer($id)
    {
        if (!$id)
            return;
        global $db;

        //config
        global $config;
        $site_name = isset($config['site_name']) ? $config['site_name'] : '';

        // get order
        $query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' 
							AND is_temporary = 0 
					";
        $db->query($query);
        $order = $db->getObject('',USE_MEMCACHE);
//var_dump($order->sender_district);
        $data = $this->get_orderdetail_by_orderId($id);
        $city = $this->getCity($order->sender_city);

        $district = $this->getDistrict($order->sender_district);
//var_dump($district);
        if (count($data)) {
            $i = 0;
            $str_prd_ids = '';
            foreach ($data as $item) {
                if ($i > 0)
                    $str_prd_ids .= ',';
                $str_prd_ids .= $item->product_id;
                $i++;
            }
            $arr_product = $this->get_products_from_orderdetail($str_prd_ids);

        }

        if (!$order)
            return;

        // send Mail()
        $mailer = FSFactory::getClass('Email', 'mail');
        $global = new FsGlobal();
        $admin_name = $global->getConfig('admin_name');
        $admin_email = $global->getConfig('admin_email');
        $mail_order_body = $global->getConfig('mail_order_body');
        $mail_order_subject = $global->getConfig('mail_order_subject');
        $mailer->isHTML(true);
        $mailer->setSender(array($admin_email, $admin_name));
        $mailer->AddBCC($admin_email, $admin_name);
        $mailer->AddAddress($order->sender_email, $order->sender_name);
        $mailer->setSubject($mail_order_subject);

        // body
        $body = $mail_order_body;
        $body = str_replace('{name}', $order->sender_name, $body);
        $body = str_replace('{ma_don_hang}', 'MSDH' . str_pad($order->id, 8, "0", STR_PAD_LEFT), $body);

        // SENDER
        $sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
        $sender_info .= '	<tbody>';
        $sender_info .= ' <tr>';
        $sender_info .= '<td width="173px">Tên người đặt hàng </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_name . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Giới tính</td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>';

        if (trim($order->sender_sex) == 'female')
            $sender_info .= "N&#7919;";
        else
            $sender_info .= "Nam";
        $sender_info .= '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Địa chỉ  </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_address . ' , ' . @$district->name . ', ' . $city->name . ' </td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Email </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_email . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Điện thoại </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_telephone . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= ' </tbody>';
        $sender_info .= '</table>';

        $order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
        $order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
        $order_detail .= '			<tr>';
        $order_detail .= '				<th width="30">STT</th>';
        $order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
        $order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
        $order_detail .= '			</tr>';
        $order_detail .= '		</thead>';
        $order_detail .= '		<tbody>';


        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];

            $link_view_product = FSRoute::_('index.php?module=products&view=product&pcode=' . @$arr_product[$item->product_id]->alias . '&id=' . $item->product_id . '&ccode=' . @$arr_product[$item->product_id]->category_alias . '&Itemid=5');


            $order_detail .= '				<tr>';
            $order_detail .= '					<td align="center">';
            $order_detail .= '						<strong>' . ($i + 1) . '</strong><br/>';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<a href="' . $link_view_product . '">';
            $order_detail .= @$arr_product[$item->product_id]->name;
            $order_detail .= '						</a> ';
            $order_detail .= '						<p>';

            if ($item->color_id) {
                $order_detail .= ' Màu:<b>' . $item->color_name . '</b>';
            }
            if ($item->memory_id) {
                $order_detail .= ' / Bộ nhớ: <b>' . $item->memory_name . '</b>';
            }
            if ($item->species_id) {
                $order_detail .= ' / Ram: <b>' . $item->species_name . '</b>';
            }
            if ($item->origin_id) {
                $order_detail .= ' / Tình trạng: <b>' . $item->origin_name . '</b>';
            }
            if ($item->warranty_id) {
                $order_detail .= ' / Bảo hành: <b>' . $item->warranty_name . '</b>';
            }

            $order_detail .= '						</p>';

            $order_detail .= '					</td>';

            //		PRICE
            $order_detail .= '					<td> ';
            $order_detail .= '						<span >';
            $order_detail .= format_money($item->total, "");
            $order_detail .= '						</span> VND';
            $order_detail .= '					</td>';
            $order_detail .= '				</tr>';
        }

        if (isset($order->discount_money) && $order->discount_money) {
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá:</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->discount_money) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Phải thanh toán:</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->total_after_discount) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
        }

        $order_detail .= '		</tbody>';
        $order_detail .= '	</table>	';


        $body = str_replace('{chi_tiet_don_hang}', $sender_info, $body);
//				$body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
        $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

//			 	var_dump($sender_info);
//            	var_dump($order_detail);
//				print_r($body);die();

        $mailer->setBody($body);
//				print_r($mailer);
        if (!$mailer->Send())
            return false;
        return true;
    }

    // gửi mail khi mua combo
    function mail_to_buyer_cb($id)
    {
        if (!$id)
            return;
        global $db;

        //config
        global $config;
        $site_name = isset($config['site_name']) ? $config['site_name'] : '';

        // get order
        $query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' 
							AND is_temporary = 0 
					";
//        echo $query;die;
        $db->query($query);
        $order = $db->getObject('',USE_MEMCACHE);
//var_dump($order);die;
        $data = $this->get_orderdetail_by_orderId($id);
//        var_dump($data);
        $city = $this->getCity($order->sender_city);

        $district = $this->getDistrict($order->sender_district);
//var_dump($district);
        if (count($data)) {
            $i = 0;
            $str_prd_ids = '';
            foreach ($data as $item) {
                if ($i > 0)
                    $str_prd_ids .= ',';
                $str_prd_ids .= $item->product_id;
                $i++;
            }
            $arr_product = $this->get_products_from_orderdetail($str_prd_ids);

        }

        if (!$order)
            return;

        // send Mail()
        $mailer = FSFactory::getClass('Email', 'mail');
        $global = new FsGlobal();
        $admin_name = $global->getConfig('admin_name');
        $admin_email = $global->getConfig('admin_email');
        $mail_order_body = $global->getConfig('mail_order_body');
        $mail_order_subject = $global->getConfig('mail_order_subject');
        $mailer->isHTML(true);
        $mailer->setSender(array($admin_email, $admin_name));
        $mailer->AddBCC($admin_email, $admin_name);
        $mailer->AddAddress($order->sender_email, $order->sender_name);
        $mailer->setSubject($mail_order_subject);
//print_r($mailer);die;
        // body
        $body = $mail_order_body;
        $body = str_replace('{name}', $order->sender_name, $body);
        $body = str_replace('{ma_don_hang}', 'MSDH' . str_pad($order->id, 8, "0", STR_PAD_LEFT), $body);

        // SENDER
        $sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
        $sender_info .= '	<tbody>';
        $sender_info .= ' <tr>';
        $sender_info .= '<td width="173px">Tên người đặt hàng </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_name . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Giới tính</td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>';

        if (trim($order->sender_sex) == 'female')
            $sender_info .= "N&#7919;";
        else
            $sender_info .= "Nam";
        $sender_info .= '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Địa chỉ  </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_address . ' , ' . @$district->name . ', ' . $city->name . ' </td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Email </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_email . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Điện thoại </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_telephone . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= ' </tbody>';
        $sender_info .= '</table>';

        $order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
        $order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
        $order_detail .= '			<tr>';
        $order_detail .= '				<th width="30">STT</th>';
        $order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
        $order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
        $order_detail .= '			</tr>';
        $order_detail .= '		</thead>';
        $order_detail .= '		<tbody>';


        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];

            $link_view_product = FSRoute::_('index.php?module=products&view=product&pcode=' . @$arr_product[$item->product_id]->alias . '&id=' . $item->product_id . '&ccode=' . @$arr_product[$item->product_id]->category_alias . '&Itemid=5');


            $order_detail .= '				<tr>';
            $order_detail .= '					<td align="center">';
            $order_detail .= '						<strong>' . ($i + 1) . '</strong><br/>';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<a href="' . $link_view_product . '">';
            $order_detail .= @$arr_product[$item->product_id]->name;
            $order_detail .= '						</a> ';
            $order_detail .= '						<p>';
            if ($i == 0) {
                if ($item->color_id) {
                    $order_detail .= ' Màu:<b>' . $item->color_name . '</b>';
                }
                if ($item->memory_id) {
                    $order_detail .= ' / Bộ nhớ: <b>' . $item->memory_name . '</b>';
                }
                if ($item->species_id) {
                    $order_detail .= ' / Ram: <b>' . $item->species_name . '</b>';
                }
                if ($item->origin_id) {
                    $order_detail .= ' / Tình trạng: <b>' . $item->origin_name . '</b>';
                }
                if ($item->warranty_id) {
                    $order_detail .= ' / Bảo hành: <b>' . $item->warranty_name . '</b>';
                }
            }
            $order_detail .= '						</p>';

            $order_detail .= '					</td>';

            //		PRICE
            $order_detail .= '					<td> ';
            $order_detail .= '						<span >';
            $order_detail .= format_money($item->total, "");
            $order_detail .= '						</span> VND';
            $order_detail .= '					</td>';
            $order_detail .= '				</tr>';
        }
        $order_detail .= '<tr>
            <td></td>
			<td  align="right"><strong>T&#7893;ng ti&#7873;n:</strong></td>
			<td><strong class="red">' . format_money($order->total_after_discount, "") . ' VND </strong>
			</td>
		</tr>';

        if (isset($order->discount_money) && $order->discount_money) {
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá:</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->discount_money) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Phải thanh toán:</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->total_after_discount) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
        }

        $order_detail .= '		</tbody>';
        $order_detail .= '	</table>	';


        $body = str_replace('{chi_tiet_don_hang}', $sender_info, $body);
//				$body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
        $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

//			 	var_dump($sender_info);
//            	var_dump($order_detail);
//        print_r($body);
//        die();

        $mailer->setBody($body);
//				print_r($mailer);
        if (!$mailer->Send())
            return false;
        return true;
    }

    function mail_to_buyer_member($id)
    {
        if (!$id)
            return;
        global $db;

        //config
        global $config;
        $site_name = isset($config['site_name']) ? $config['site_name'] : '';

        // get order
        $query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' ";
//        echo $query;die;
        $db->query($query);
        $order = $db->getObject('',USE_MEMCACHE);
        $data = $this->get_orderdetail_by_orderId($id);
//        var_dump($data);
//        $city = $this->getCity1($order->sender_city);
//        $district = $this->getDistrict($order->sender_district);
        if (count($data)) {
            $i = 0;
            $str_prd_ids = '';
            foreach ($data as $item) {
                if ($i > 0)
                    $str_prd_ids .= ',';
                $str_prd_ids .= $item->product_id;
                $i++;
            }
            $arr_product = $this->get_products_from_orderdetail($str_prd_ids);

        }

        if (!$order)
            return;

        // send Mail()
//        $mailer = FSFactory::getClass('Email', 'mail');
        $global = new FsGlobal();
//        $admin_name = $global->getConfig('admin_name');
//        $admin_email = $global->getConfig('admin_email');

        $mail_order_body = $global->getConfig('mail_order_body');
        $mail_order_subject = $global->getConfig('mail_order_subject');

//        $mailer->isHTML(true);
//        $mailer->setSender(array($admin_email, $admin_name));
//        $mailer->AddBCC($admin_email, $admin_name);
//        $mailer->AddAddress($order->sender_email, $order->sender_name);
//        $mailer->setSubject($mail_order_subject);
//print_r($mailer);die;
        // body
        $body = $mail_order_body;
        $body = str_replace('{name}', $order->sender_name, $body);
        $body = str_replace('{ma_don_hang}', 'MSDH' . str_pad($order->id, 8, "0", STR_PAD_LEFT), $body);

        // SENDER
        $sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
        $sender_info .= '	<tbody>';
        $sender_info .= ' <tr>';
        $sender_info .= '<td width="173px">Tên người đặt hàng </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_name . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Giới tính</td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>';

        if (trim($order->sender_sex) == '0')
            $sender_info .= "N&#7919;";
        else
            $sender_info .= "Nam";
        $sender_info .= '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Địa chỉ  </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->address_detail . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Email </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_email . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Điện thoại </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_telephone . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= ' </tbody>';
        $sender_info .= '</table>';

        $order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
        $order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
        $order_detail .= '			<tr>';
        $order_detail .= '				<th width="30">STT</th>';
        $order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
        $order_detail .= '				<th width="200">Giá tiền</th>';
        $order_detail .= '			</tr>';
        $order_detail .= '		</thead>';
        $order_detail .= '		<tbody>';


        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];

            $link_view_product = FSRoute::_('index.php?module=products&view=product&ccode=' . @$arr_product[$item->product_id]->alias);


            $order_detail .= '				<tr>';
            $order_detail .= '					<td align="center">';
            $order_detail .= '						<strong>' . ($i + 1) . '</strong><br/>';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<a href="' . $link_view_product . '">';
            $order_detail .= @$arr_product[$item->product_id]->name;
            $order_detail .= '						</a> ';
            $order_detail .= '						<p>';
//            if ($i == 0) {
            if ($item->id_sub) {
                $sub = $this->get_record('id = ' . $item->id_sub, 'fs_products_sub', 'name');
                $order_detail .= ' Màu:<b>' . $sub->name . '</b>';
            }
            if ($item->warranty_id) {
                $order_detail .= ' / Bảo hành: <b>' . $item->warranty_name . '</b>';
            }
//            }
            $order_detail .= '						</p>';

            $order_detail .= '					</td>';

            //		PRICE
            $order_detail .= '					<td> ';
            $order_detail .= '						<span >';
            $order_detail .= format_money_0($item->total, "", "Liên hệ");
            $order_detail .= '						</span> VND';
            $order_detail .= '					</td>';
            $order_detail .= '				</tr>';
        }
        $order_detail .= '<tr>
            <td></td>
			<td  align="right">';
        if (isset($order->discount_money) && $order->discount_money) {
            $order_detail .= '<span>Giảm giá:</span></br>';
        }
        $order_detail .= '<strong>T&#7893;ng ti&#7873;n:</strong>
			</td>
			<td>';
        if (isset($order->discount_money) && $order->discount_money) {
            $order_detail .= '<span >' . format_money_0($order->discount_money, " VND", "Liên hệ") . '</span> </br>';
        }
        $order_detail .= '<strong class="red">' . format_money_0($order->total_end, " VND", "Liên hệ") . ' </strong>
			</td>
		</tr>';
        $order_detail .= '		</tbody>';
        $order_detail .= '	</table>	';


        $body = str_replace('{chi_tiet_don_hang}', $sender_info, $body);
//				$body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
        $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);
//			 	var_dump($sender_info);
//            	var_dump($order_detail);
        print_r($body);
        die();
        $rs = $this->send_email1($mail_order_subject, $body, $order->sender_name, $order->sender_email, '', 1);
        return true;
//        $mailer->setBody($body);
////				print_r($mailer);die;
//        if (!$mailer->Send())
//            return false;
//        return true;
    }


    /*
     * Gửi mail cho khách ngay sau khi đơn hàng thanh toán thành công ( qua cổng thanh toán online)
     */
    function mail_to_buyer_after_successful($id)
    {
        if (!$id)
            return;
        global $db;

        //config
        global $config;
        $site_name = isset($config['site_name']) ? $config['site_name'] : '';

        // get order
        $query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' 
							AND is_temporary = 0 
					";
        $db->query($query);
        $order = $db->getObject('',USE_MEMCACHE);
//			$estore = $this -> getEstore($order -> estore_id);
        $data = $this->get_orderdetail_by_orderId($id);
        if (count($data)) {
            $i = 0;
            $str_prd_ids = '';
            foreach ($data as $item) {
                if ($i > 0)
                    $str_prd_ids .= ',';
                $str_prd_ids .= $item->product_id;
                $i++;
            }
            $arr_product = $this->get_products_from_orderdetail($str_prd_ids);

        }

        if (!$order)
            return;

        // send Mail()
        $mailer = FSFactory::getClass('Email', 'mail');
        $global = new FsGlobal();
        $admin_name = $global->getConfig('admin_name');
        $admin_email = $global->getConfig('admin_email');
        $mail_order_body = $global->getConfig('mail_order_successful_body');
        $mail_order_subject = $global->getConfig('mail_order_successful_subject');

        $mailer->isHTML(true);
        $mailer->setSender(array($admin_email, $admin_name));
        $mailer->AddBCC('phamhuy@finalstyle.com', 'pham van huy');
        $mailer->AddAddress($order->recipients_email, $order->recipients_name);
        $mailer->setSubject($mail_order_subject);

        // body
        $body = $mail_order_body;
        $body = str_replace('{name}', $order->sender_name, $body);
        $body = str_replace('{ma_don_hang}', 'MSDH' . str_pad($order->id, 8, "0", STR_PAD_LEFT), $body);


        // order common
//				$body .= '<div style="background: none repeat scroll 0 0 #55AEE7;color: #FFFFFF;font-weight: bold;height: 27px;padding-left: 10px;line-height: 25px; margin: 2px;">
//				Thông tin về đơn đặt hàng của bạn	</div>';
//				$body .= 	'<div style="padding: 10px">';
//				$body .= 	'<div>Mã đơn hàng: <strong> DH'.str_pad($order -> id, 8 , "0", STR_PAD_LEFT).'</strong></div>';
////				$body .= 	'<div>Sau khi bạn nhận được hàng, hãy vào :<a href=\''.FSRoute::_('index.php?module=sale&view=finished&Itemid=78').'\'><strong>'. FSRoute::_('index.php?module=sale&view=finished&Itemid=78').'</strong></a> để xác nhận hoàn tất việc mua hàng</div>';
//				$body .= '</div>';
//				$body .= '<br/>';

        // table
//				$body .= '<table width="100%" border="2" bordercolor="#ffffff" style="border-collapse: collapse;border-style:solid;border-color: #FFFFFF;">';
//				$body .= 	'<thead style="background: none repeat scroll 0 0 #55AEE7;color: #FFFFFF;font-weight: bold;height: 25px;padding-left: 10px;">';
//				$body .= 		'<tr>';
//				$body .= 			'<td >';
//				$body .= 				'<strong style="padding-left: 10px;">Thông tin người đặt hàng </strong>';
//				$body .= 			'</td>';
//				$body .= 			'<td >';
//				$body .= 				'<strong style="padding-left: 10px;">Thông tin người nhận hàng </strong>';
//				$body .= 			'</td>';
//
//				$body .= 		'</tr>';
//				$body .= 	'</thead>';
//
//				$body .= 	'<tbody>';
//				$body .= 		'<tr>';


        // SENDER
        $sender_info .= '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
        $sender_info .= '	<tbody>';
        $sender_info .= ' <tr>';
        $sender_info .= '<td width="173px">Tên người đặt hàng </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_name . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Giới tính</td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>';
        if (trim($order->sender_sex) == 'female')
            $sender_info .= "N&#7919;";
        else
            $sender_info .= "Nam";
        $sender_info .= '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Địa chỉ  </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_address . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Email </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_email . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= '<tr>';
        $sender_info .= '<td>Điện thoại </td>';
        $sender_info .= '<td width="5px">:</td>';
        $sender_info .= '<td>' . $order->sender_telephone . '</td>';
        $sender_info .= '</tr>';
        $sender_info .= ' </tbody>';
        $sender_info .= '</table>';
//				$sender_info .= 			'</td>';
        // end SENDER

        // RECIPIENT
        $recipient_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
        $recipient_info .= '	<tbody> ';
        $recipient_info .= '<tr>';
        $recipient_info .= '<td width="173px">Tên người nhận hàng</td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>' . $order->recipients_name . '</td>';
        $recipient_info .= '</tr>';
        $recipient_info .= '<tr>';
        $recipient_info .= '<td>Giới tính </td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>';
        if (trim($order->recipients_sex) == 'female')
            $recipient_info .= "N&#7919;";
        else
            $recipient_info .= "Nam";
        $recipient_info .= '</td>';
        $recipient_info .= ' </tr>';
        $recipient_info .= ' <tr>';
        $recipient_info .= '<td>Địa chỉ  </td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>' . $order->recipients_address . '</td>';
        $recipient_info .= '</tr>';
        $recipient_info .= ' <tr>';
        $recipient_info .= '<td>Email </td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>' . $order->recipients_email . '</td>';
        $recipient_info .= '</tr>';
        $recipient_info .= '<tr>';
        $recipient_info .= '<td>Điện thoại </td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>' . $order->recipients_telephone . '</td>';
        $recipient_info .= '</tr>';
        $recipient_info .= '<tr>';

        $recipient_info .= '<td>Thời gian đặt hàng</td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>';
        $hour = date('H', strtotime($order->received_time));
        if ($hour)
            $recipient_info .= $hour . " h, ";
        $recipient_info .= "ng&#224;y " . date('d/m/Y', strtotime($order->received_time));
        $recipient_info .= '</td>';
        $recipient_info .= '</tr>';

        $recipient_info .= '<td>Địa điểm nhân hàng </b></td>';
        $recipient_info .= '<td width="5px">:</td>';
        $recipient_info .= '<td>';
        $recipient_info .= $order->recipients_here ? 'Đặt lấy tại nhà hàng' : 'Nhận tại địa chỉ người nhận';
        $recipient_info .= '</td>';
        $recipient_info .= '</tr>';

        $recipient_info .= '</tbody>';
        $recipient_info .= '</table>';
        // end RECIPIENT

        $order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
        $order_detail .= '		<thead style=" background: #E7E7E7;line-height: 12px;">';
        $order_detail .= '			<tr>';
        $order_detail .= '				<th width="30">STT</th>';
        $order_detail .= '				<th>T&#234;n s&#7843;n ph&#7849;m</th>';
        $order_detail .= '				<th width="117" >Giá</th>';
        $order_detail .= '				<th width="117">S&#7889; l&#432;&#7907;ng</th>';
        $order_detail .= '				<th width="117">T&#7893;ng gi&#225; ti&#7873;n</th>';
        $order_detail .= '			</tr>';
        $order_detail .= '		</thead>';
        $order_detail .= '		<tbody>';

        $total_discount = 0;
        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];

            $link_view_product = FSRoute::_('index.php?module=products&view=product&pcode=' . @$arr_product[$item->product_id]->alias . '&id=' . $item->product_id . '&ccode=' . @$arr_product[$item->product_id]->category_alias . '&Itemid=5');

            $order_detail .= '				<tr>';
            $order_detail .= '					<td align="center">';
            $order_detail .= '						<strong>' . ($i + 1) . '</strong><br/>';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<a href="' . $link_view_product . '">';
            $order_detail .= @$arr_product[$item->product_id]->name;
            $order_detail .= '						</a> ';
            $order_detail .= '					</td>';

            //		PRICE
            $order_detail .= '					<td> ';
            $order_detail .= '						<strong>';
            $order_detail .= format_money($item->price);
            $order_detail .= '						</strong> VND';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<strong>';
            $order_detail .= $item->count ? $item->count : 0;
            $order_detail .= '						</strong>';
            $order_detail .= '					</td>';
            $order_detail .= '					<td> ';
            $order_detail .= '						<span >';
            $order_detail .= format_money($item->total);
            $order_detail .= '						</span> VND';
            $order_detail .= '					</td>';
            $order_detail .= '				</tr>';
        }
        $order_detail .= '				<tr>';
        $order_detail .= '					<td colspan="4"  align="right"><strong>Tổng:</strong></td>';
        $order_detail .= '					<td ><strong >' . format_money($order->total_before_discount) . '</strong> VND</td>';
        $order_detail .= '				</tr>';
        if ($order->payment_method) {
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá (khi mua qua address):</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->total_before_discount - $order->total_after_discount) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Thành tiền:</strong></td>';
            $order_detail .= '					<td ><strong >' . format_money($order->total_after_discount) . '</strong> VND</td>';
            $order_detail .= '				</tr>';
        }
        $order_detail .= '		</tbody>';
        $order_detail .= '	</table>	';

        $body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
        // $body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
        $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

        $mailer->setBody($body);

        // var_dump($mailer);die();
        if (!$mailer->Send())
            return false;
        return true;
    }

    function get_incenty_accessory($product_id)
    {
        $accessory_ids = FSInput::get('add');
        if (!$accessory_ids || !$product_id)
            return;
        $query = " SELECT * FROM fs_products_incentives
						WHERE product_id =  " . $product_id . "
						AND product_incenty_id IN (" . $accessory_ids . ") ";
        global $db;
        $db->query($query);
        return $rs = $db->getObjectList('',USE_MEMCACHE);
    }

    function getProvince()
    {
        global $db;
        $sql = "    SELECT *
                    FROM fs_cities ORDER BY name ASC
                ";
        $db->query($sql);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function get_store()
    {
        global $db;
        $sql = "    SELECT *
                    FROM fs_address WHERE published = 1 ORDER BY ordering ASC
                ";
        $db->query($sql);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function list_products_add($id_products)
    {
        global $db;
        $query = " SELECT id,name,alias, category_id,image,category_alias,created_time,discount,price,price_old, price_compare
                                FROM fs_products 
                                WHERE id IN (0" . $id_products . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $id_products . "0')
                                ";
        $db->query($query);
        $result = $db->getObjectList('',USE_MEMCACHE);
        return $result;
    }

    function checkCode()
    {
        global $db;
        $code = FSInput::get('discount');
        $sql = "SELECT id FROM fs_discount_code 
                WHERE name='".$code."' AND published=1  
                 AND count > 0 AND count_total > 0 FOR UPDATE";
        $rs = $db->getObject($sql);
        return $rs;
    }
}

?>
