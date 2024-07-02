<?php

class OrderControllersPre_order extends Controllers
{
    function __construct()
    {
        $this->view = 'pre_order';
        parent::__construct();
        $array_status = array(
            1 => FSText::_('Mới'),
            2 => FSText::_('Đã hoàn thành')
        );
        $this->arr_status = $array_status;
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
        // print_r($list);die;
        $array_status = $this->arr_status;
        $array_obj_status = array();
        $array_obj = array();
        foreach ($array_status as $key => $name) {
            $array_obj_status[] = (object)array('id' => ($key), 'name' => $name);
//            $array_obj[] = (object)array('id' => ($key), 'name' => $name);
        }
        //var_dump($array_obj);die;
        $pagination = $this->model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function showStatus($status)
    {
        $arr_status = $this->arr_status;
        echo @$arr_status[$status];
    }

    function edit()
    {
        $model = $this->model;
//        $order = $model->getOrderById();
        $data = $model->get_data_order();
        $city = $model->get_city();
        $district = $model->get_district();
//			var_dump($order);
//			$wards=$model->get_record_by_id($order->recipients_wards,'fs_wards')->name;
//			$sender_wards=$model->get_record_by_id($order->sender_wards,'fs_wards')->name;
//			$district=$model->get_record_by_id($order->recipients_district,'fs_districts')->name;
//			$sender_district=$model->get_record_by_id($order->sender_district,'fs_districts')->name;
//			$province=$model->get_record_by_id($order->recipients_province,'fs_cities')->name;
//			$sender_province=$model->get_record_by_id($order->sender_province,'fs_cities')->name;

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
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
            setRedirect($link . '&task=edit&id=' . $id, FSText:: _('Saved'));
        } else {
            setRedirect($link, FSText:: _('Not save'), 'error');
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
            setRedirect($link, FSText:: _('Saved'));
        } else {
            setRedirect($link, FSText:: _('Not save'), 'error');
        }
    }

    function cancel_order()
    {
        $model = $this->model;

        $rs = $model->cancel_order();

        $Itemid = 61;
        $id = FSInput::get('id');
        $link = 'index.php?module=order&view=order&task=edit&id=' . $id;
        if (!$rs) {
            $msg = 'Không hủy được đơn hàng';
            setRedirect($link, $msg, 'error');
        } else {
            $msg = 'Đã hủy được đơn hàng';
            setRedirect($link);
        }
    }

    function finished_order()
    {
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

?>