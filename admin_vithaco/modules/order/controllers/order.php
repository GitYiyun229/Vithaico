<?php

class OrderControllersOrder extends Controllers
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

    public $sex = [
        'Nam',
        'Nữ',
        'Khác'
    ];

    function __construct()
    {
        $this->view = 'order';
        parent::__construct();
        // $array_status = array(
        //     0 => FSText::_('Chưa xử lý'),
        //     1 => FSText::_('Đã nhận đơn'),
        //     2 => FSText::_('Đang chờ xin hàng'),
        //     3 => FSText::_('Đang chờ chuyển hàng'),
        //     4 => FSText::_('Đã chuyển hàng'),
        //     5 => FSText::_('Thành công'),
        //     6 => FSText::_('Hủy đơn hàng')
        // );
        // $this->arr_status = $array_status;
        // $array_status1 = array(
        //     0 => FSText::_('Giao dịch đang xử lý'),
        //     1 => FSText::_('Giao dịch thành công'),
        //     2 => FSText::_('Giao dịch thất bại'),
        // );
        // $this->arr_status1 = $array_status1;
        // $array_status_kredivo = array(
        //     0 => FSText::_('Giao dịch khởi tạo'),
        //     1 => FSText::_('Giao dịch thành công'),
        //     2 => FSText::_('Giao dịch đã bị Kredivo từ chối'),
        //     3 => FSText::_('Giao dịch đã hủy'),
        //     4 => FSText::_('Giao dịch quá thời gian'),
        // );
        // $this->arr_status_kredivo = $array_status_kredivo;
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $text2 = FSInput::get('text2');
        if ($text2) {
            $_SESSION[$this->prefix . 'text2'] = $text2;
        }

        $model = $this->model;

        $list = $model->get_data('');

        foreach ($this->status as $key => $name) {
            $array_obj_status[] = (object)array('id' => ($key + 1), 'name' => $name);
            // $array_obj[] = (object)array('id' => ($key), 'name' => $name);
        }

        foreach ($this->paymentMethod as $key => $name) {
            $array_obj_payment_method[] = (object) ['id' => ($key + 1), 'name' => $name];
        }

        foreach ($this->paymentStatus as $key => $name) {
            $array_obj_payment_status[] = (object) ['id' => ($key + 1), 'name' => $name];
        }

        // $array_status1 = $this->arr_status1;
        // $array_obj_status1 = array();
        // foreach ($array_status1 as $key => $name) {
        //     $array_obj_status1[] = (object)array('id' => ($key + 1), 'name' => $name);
        // }

        // $array_status_kredivo = $this->arr_status_kredivo;
        // $array_obj_status_k = array();
        // foreach ($array_status_kredivo as $key => $name) {
        //     $array_obj_status_k[] = (object)array(
        //         'id'   => ($key + 1),
        //         'name' => $name
        //     );
        // }

        $pagination = $this->model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function showStatus($status)
    {
        $arr_status = $this->arr_status;
        echo @$arr_status[$status];
        //        $arr_status1 = $this->arr_status1;
        //        echo @$arr_status1[$status1];
    }

    function edit()
    {
        $model = $this->model;
        $order = $model->getOrderById();

        $detail = $this->getOrderDetail($order->id);

        $province = $this->model->get_record("code = $order->recipients_province", 'fs_provinces', 'code, name')->name;
        $district = $this->model->get_record("code = $order->recipients_district", 'fs_districts', 'code, name')->name;
        $ward = $this->model->get_record("code = $order->recipients_ward", 'fs_wards', 'code, name')->name;

        if ($order->user_id) {
            $buyer = $this->model->get_record("id = $order->user_id", 'fs_members');
        }

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    public function getOrderDetail($orderId)
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
        }

        return $orderDetail;
    }

    function apply()
    {
        $model = $this->model;
        $id = $model->save();
        // print_r($id);die;
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        if ($this->page)
            $link .= '&page=' . $this->page;
        // call Models to save
        if ($id) {
            setRedirect($link . '&task=edit&id=' . $id, FSText::_('Saved'));
        } else {
            setRedirect($link, FSText::_('Not save'), 'error');
        }
    }

    function save()
    {
        $model = $this->model;
        // check password and repass
        // call Models to save
        $id = $model->save();
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        if ($this->page)
            $link .= '&page=' . $this->page;
        if ($id) {
            setRedirect($link, FSText::_('Saved'));
        } else {
            setRedirect($link, FSText::_('Not save'), 'error');
        }
    }

    function cancel_order()
    {
        $model = $this->model;
        $id = FSInput::get('id');
        $cancel_people = $_SESSION['ad_username'];
        $time = date("Y-m-d H:i:s");
        //        $rs = $model->cancel_order($id);
        $order = $model->get_record('id = ' . $id, 'fs_order');
        //        var_dump($order);die;

        //api hủy đơn hàng trên hệ thống Kredivo
        $param = array(
            "server_key"     => "hpEeg7NHT558T8mL3RUcc6gVLupN6bk7",
            "transaction_id" => $order->transaction_id,
            "reason"         => "hủy đơn hàng",
            "cancelled_by"   => $cancel_people,
            "amount"         => (int)$order->amount_kredivo,
            "order_id"       => "DH" . str_pad(
                $order->id,
                8,
                "0",
                STR_PAD_LEFT
            )
        );
        $data_send = json_encode($param, JSON_UNESCAPED_UNICODE);
        //var_dump($data_send);die;
        $url = 'https://api-vn.kredivo.com/transaction/cancel';
        $ch = curl_init($url);
        # Setup request to send json via POST.
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt(
            $ch,
            CURLOPT_USERAGENT,
            'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6'
        );
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_send);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=UTF-8',
            'Content-Length: ' . strlen($data_send)
        ));
        $result = curl_exec($ch);
        //        var_dump($result);die;

        if ($result === false) {
            echo 'Curl error: ' . curl_error($ch);
        }
        curl_close($ch);
        # Print response.
        $respone = json_decode($result, true);
        //var_dump($respone['status']);die;
        //cập nhật vào bảng db
        if ($respone['status'] == 1) {
            $update = array();
            $update['status_kredivo'] = 'cancel';
            $update['status_kredivo_int'] = 3;
            $update['status'] = 6;
            $update['edited_time'] = $time;
            $update['cancel_people'] = $cancel_people;
            $update['cancel_time'] = $time;
            $rs = $model->_update($update, 'fs_order', ' id = ' . $id, 0);
        }

        $link = 'index.php?module=order&view=order&task=edit&id=' . $id;
        if ($respone['status'] == 1) {
            $msg = 'Đã hủy đơn hàng';
            setRedirect($link, $msg);
        } else {
            $msg = $respone['message'];
            setRedirect($link, $msg, 'error');
        }
    }

    function finished_order()
    {
        echo 1;
        die;
        $model = $this->model;

        $rs = $model->finished_order();

        $Itemid = 61;
        $id = FSInput::get('id');
        $link = 'index.php?module=order&view=order&task=edit&id=' . $id;
        if (!$rs) {
            $msg = 'Không hoàn tất được đơn hàng';
            setRedirect($link, $msg, 'error');
        } else {
            $msg = 'Đã hoàn tất được đơn hàng thành công';
            setRedirect($link);
        }
    }

    function ghtk()
    {
        global $config;
        $model = $this->model;

        //			$rs  = $model -> ghtk_order();

        //			$Itemid = 61;
        $id = FSInput::get('id');
        //			$link = 'index.php?module=order&view=order&task=edit&id='.$id;
        //			if(!$rs){
        //				$msg = 'Không hoàn tất được đơn hàng';
        //				setRedirect($link,$msg,'error');
        //			}
        //			else {
        //				$msg = 'Đã hoàn tất được đơn hàng thành công';
        //				setRedirect($link);
        //			}
        $order = $model->getOrderById();
        $data = $model->get_data_order();

        $total_price = 0;
        $proh = '[';
        foreach ($data as $key => $item) {
            $total_price += $item->price * $item->count;
            $proh .= '{';
            $proh .= '"name":"' . $item->product_name . '",';
            $wei = $item->weight / 1000;
            $proh .= '"weight":"' . $wei . '",';
            $proh .= '"quantity":"' . $item->count . '"';
            $proh .= '},';
        }
        $proh = rtrim($proh, ',');
        $proh .= '],';

        $name = $config['pick_name'];
        $tel = $config['pick_tel'];
        $ordergh = <<<HTTP_BODY
{
    "products": 
    $proh
    "order": {
        "id": "$order->id",
        "pick_name": "$name",
        "pick_province" : "Hà Nội",
        "pick_district" : "Q. Hà Đông",
        "pick_address" : "103 Phố Vạn Phúc",
       
        "pick_tel": "$tel",
        "tel": "$order->sender_telephone",
        "name": "$order->sender_name",
        "address": "$order->sender_address",
        "province": "$order->sender_province",
        "district": "$order->sender_district",
        "email": "$order->sender_email",
        "is_freeship": "0",
        "pick_money": $total_price,
        "use_return_address": 0,
        
        "transport": "fly"
    }
}
HTTP_BODY;
        //echo '<pre>';
        //        print_r($ordergh);
        //        die();
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://services.giaohangtietkiem.vn/services/shipment/order",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $ordergh,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Token:3141b949c6c17e658327Bb202Ec10AFa3A105774",
                "Content-Length: " . strlen($ordergh),
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        var_dump('Response: ' . $response);
    }

    // Excel toàn bộ danh sách copper ra excel
    function export()
    {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }

    function export_file()
    {
        FSFactory::include_class('excel', 'excel');
        //			require_once 'excel.php';
        $model = $this->model;
        $filename = 'order-export';
        $list = $model->get_member_info();
        if (empty($list)) {
            echo 'error';
            exit;
        } else {
            $excel = FSExcel();
            $excel->set_params(array('out_put_xls' => 'export/excel/' . $filename . '.xls', 'out_put_xlsx' => 'export/excel/' . $filename . '.xlsx'));
            $style_header = array(
                'fill' => array(
                    'type' => PHPExcel_Style_Fill::FILL_SOLID,
                    'color' => array('rgb' => 'ffff00'),
                ),
                'font' => array(
                    'bold' => true,
                )
            );
            $style_header1 = array(
                'font' => array(
                    'bold' => true,
                )
            );
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Mã đơn hàng');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Người mua');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Giá trị');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Ngày mua');
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, 'DH' . str_pad($item->id, 8, "0", STR_PAD_LEFT));
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->sender_name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, format_money($item->total_after_discount));
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->created_time);
            }
            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:D1');
            $output = $excel->write_files();

            $path_file = PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-type: application/force-download");
            header("Content-Disposition: attachment; filename=\"" . $filename . '.xls' . "\";");
            header("Content-Transfer-Encoding: binary");
            header("Content-Length: " . filesize($path_file));
            readfile($path_file);
        }
    }
}
