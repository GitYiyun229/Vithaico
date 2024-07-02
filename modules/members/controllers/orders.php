<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';

class MembersControllersOrders extends MembersControllersMembers
{
    public $status = [
        'Đang xử lý',
        'Đang giao hàng',
        'Hoàn thành',
        'Đã hủy',
    ];

    public $paymentStatus = [
        'Chưa thanh toán',
        'Thanh toán thành công',
        'Thanh toán thất bại',
    ];

    public $paymentMethod = [
        'Thanh toán tiền mặt khi nhận hàng',
    ];

    public $dateAllowRate = 7 * 24 * 60 * 60;

    public function display()
    {
        global $tmpl, $user, $config;

        $tmpl->addTitle(FSText::_('Đơn hàng của tôi'));
  
        $list = $this->model->get_records("user_id = $user->userID", 'fs_order', 'id, user_id, created_time, total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');

        if (!empty($list)) {
            $orderId = array_map(function($item) {
                return $item->id;
            }, $list);

            $orderId = implode(',', $orderId);
            $orderDetail = $this->getOrderDetail($orderId, $user);

            $rate = $this->model->get_records("user_id = $user->userID", "fs_products_comments");

            foreach ($list as $item) {
                foreach ($orderDetail as $detail) {
                    if ($item->id == $detail->order_id) {
                        $item->orderDetail[] = $detail;
                    }
                }
            }
        }

        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }

    public function detail()
    {
        global $tmpl, $user, $config;
        $id = FSInput::get('id');
        $return = FSRoute::_('index.php?module=members&view=orders');
      
        if (!$id) {
            setRedirect($return);
        }

        $order = $this->model->get_record("id = $id", 'fs_order');

        if (!$order || $order->user_id != $user->userID) {
            setRedirect($return, 'Đơn hàng không tồn tại!', 'error');
        }
       
        $detail = $this->getOrderDetail($order->id, $user);
        $province = $this->model->get_record("code = $order->recipients_province", 'fs_provinces', 'code, name')->name;
        $district = $this->model->get_record("code = $order->recipients_district", 'fs_districts', 'code, name')->name;
        $ward = $this->model->get_record("code = $order->recipients_ward", 'fs_wards', 'code, name')->name;

        $tmpl->addTitle(FSText::_('Chi tiết đơn hàng'));

        require PATH_BASE . "modules/$this->module/views/$this->view/detail.php";
    }

    public function getOrderDetail($orderId, $user)
    {
        $orderDetail = $this->model->get_records("order_id IN ($orderId)", 'fs_order_items');

        foreach ($orderDetail as $detail) {
            $productId[] = $detail->product_id;

            if ($detail->id_sub) {
                $subId[] = $detail->id_sub;
            }                
        }
      
        $productId = implode(',', $productId);
        $products = $this->model->get_records("id IN ($productId)", 'fs_products', 'id, name, alias, image');

        if (!empty($subId)) {
            $subId = implode(',', $subId);
            $sub = $this->model->get_records("id IN ($subId)", 'fs_products_sub', 'id, name, product_id');
            $subImage = $this->model->get_records("sub_id IN ($subId)", 'fs_products_images', 'id, image, sub_id');

            foreach ($sub as $subItem) {
                $subItem->image = '';
                foreach ($subImage as $image) {
                    if ($subItem->id == $image->sub_id) {
                        $subItem->image = $image->image;
                    }
                }
            }
        }
        
        $orderRateId = array_column(array_filter($orderDetail, function ($item) {
            return $item->rate;
        }), 'id');

        if (!empty($orderRateId)) {
            $orderRateId = implode(',', $orderRateId);
            $rate = $this->model->get_records("user_id = $user->userID AND order_item_id IN ($orderRateId)", 'fs_products_comments', 'id, product_id, comment, order_item_id');
            
            $rateId = array_map(function($item) {
                return $item->id;
            }, $rate);

            $rateId = implode(',', $rateId);

            $rateImage = $this->model->get_records("record_id IN ($rateId)", 'fs_products_comments_images', 'record_id, image');

            foreach ($rate as $rateItem) {
                $rateItem->image = [];
                foreach ($rateImage as $image) {
                    if ($image->record_id == $rateItem->id) {
                        $rateItem->image[] = $image;
                    }
                }
            }
        }     

        foreach ($orderDetail as $detail) {
            foreach ($products as $product) {
                if ($detail->product_id == $product->id) {
                    $detail->productInfo = $product;
                }
            }

            if (!empty($sub)) {
                foreach ($sub as $subItem) {
                    if ($detail->id_sub == $subItem->id) {
                        $detail->subInfo = $subItem;   
                    }
                }
            }

            if ($detail->rate) {
                foreach ($rate as $rateItem) {
                    if ($detail->id == $rateItem->order_item_id) {
                        $detail->rateInfo = $rateItem;
                    }
                }
            }
        }

        return $orderDetail;
    }

    public function rate()
    {
        $this->auth('POST');
        global $user;

        $return = FSRoute::_('index.php?module=members&view=orders');
        $order_id = FSInput::get('order_id');
        $order_item_id = FSInput::get('order_item_id');
        $product_id = FSInput::get('product_id');
        $sub_id = FSInput::get('sub_id');
        $rating = FSInput::get('rate', 1);
        $comment = FSInput::get('comment');
        $user_id = $user->userID;
        $name = $user->userInfo->full_name;
        $created_time = date('Y-m-d H:i:s');
        $edited_time = date('Y-m-d H:i:s');
        $published = 1;

        $row = compact('order_id', 'order_item_id', 'product_id', 'sub_id', 'rating', 'comment', 'user_id', 'created_time', 'edited_time', 'published', 'name');
        
        $rs = $this->model->_add($row, 'fs_products_comments');

        if (!$rs) {
            setRedirect($return, 'Đánh giá sản phẩm không thành công!', 'error');
        }

        if (!empty($_FILES['image']['name'])) {
            $fsFile = FSFactory::getClass('FsFiles');
    
            $path = 'images' . DS . 'products' . DS . 'rate-comment' . DS;
    
            if (!$fsFile->create_folder($path)) {
                setRedirect($return, "Không thể tạo folder", 'error');
            }

            foreach ($_FILES['image']['name'] as $i => $item) {
                $img = $fsFile->uploadImageMultiple($i, 'image', PATH_BASE . $path, 10000000, time());

                if ($img && is_string($img)) {
                    $img = str_replace(DS, '/', $path) . $img;
    
                    $arrImage[] = [
                        'record_id' => $rs,
                        'image' => $img,
                        'published' => 1,
                        'file_type' => $_FILES['image']["type"][$i]
                    ];
                }               
            } 

            $this->model->_add_multiple($arrImage, 'fs_products_comments_images');
        }

        $this->model->_update(['rate' => $rating], 'fs_order_items', "id = $order_item_id");

        setRedirect($return, 'Đánh giá sản phẩm thành công!', 'success');
    }
}
