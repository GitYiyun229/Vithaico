<?php
    class OrderModelsFindinfor extends FSModels
    {
        public $limit;
        public $prefix ;
        public function __construct()
        {
            $this -> limit = 40;
            $this -> view = 'service';
            $this -> table_name = 'fs_order_3';
            $this -> table_name_item = 'fs_order_3_item';
            parent::__construct();
        }


        public function setQuery()
        {

            // ordering
            $ordering = "";
            $where = "  ";
            if (isset($_SESSION[$this -> prefix.'sort_field'])) {
                $sort_field = $_SESSION[$this -> prefix.'sort_field'];
                $sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
                $sort_direct = $sort_direct?$sort_direct:'asc';
                $ordering = '';
                if ($sort_field) {
                    $ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
                }
            }

            // from
            if (isset($_SESSION[$this -> prefix.'text0'])) {
                $date_from = $_SESSION[$this -> prefix.'text0'];
                if ($date_from) {
                    $date_from = strtotime($date_from);
                    $date_new = date('Y-m-d H:i:s', $date_from);
                    $where .= ' AND a.created_time >=  "'.$date_new.'" ';
                }
            }

            // to
            if (isset($_SESSION[$this -> prefix.'text1'])) {
                $date_to = $_SESSION[$this -> prefix.'text1'];
                if ($date_to) {
                    $date_to = $date_to . ' 23:59:59';
                    $date_to = strtotime($date_to);
                    $date_new = date('Y-m-d H:i:s', $date_to);
                    $where .= ' AND a.created_time <=  "'.$date_new.'" ';
                }
            }

            // userid
            if (isset($_SESSION[$this -> prefix.'text2'])) {
                $userid = $_SESSION[$this -> prefix.'text2'];
                $userid  = intval($userid);
                if ($userid) {
                    $where .= ' AND a.user_id =  '.$userid ;
                }
            }

            if (!$ordering) {
                $ordering .= " ORDER BY id DESC ";
            }


//			if(isset($_SESSION[$this -> prefix.'filter0'])){
//				$filter = $_SESSION[$this -> prefix.'filter0'];
//				if($filter){
//					$where .= ' AND b.id =  "'.$filter.'" ';
//				}
//			}

//			if(isset($_SESSION[$this -> prefix.'filter1'])){
//				$filter = $_SESSION[$this -> prefix.'filter1'];
//				if($filter){
//					$where .= ' AND a.user_id =  "'.$filter.'" ';
//				}
//			}
            if (isset($_SESSION[$this -> prefix.'filter0'])) {
                $filter = $_SESSION[$this -> prefix.'filter0'];
                if ($filter) {
                    $filter = (int)$filter - 1;
                    $where .= ' AND a.status =  "'.$filter.'" ';
                }
            }
            
            if (isset($_SESSION[$this -> prefix.'filter1'])) {
                $filter = $_SESSION[$this -> prefix.'filter1'];
                if ($filter) {
                    $filter = (int)$filter - 1;
                    $where .= ' AND a.form_of_payment =  "'.$filter.'" ';
                }
            }
            
            if (isset($_SESSION[$this -> prefix.'filter2'])) {
                $filter = $_SESSION[$this -> prefix.'filter2'];
                if ($filter) {
                    $filter = (int)$filter - 1;
                    $where .= ' AND a.status_use =  "'.$filter.'" ';
                }
            }

            if (isset($_SESSION [$this->prefix . 'keysearch'])) {
                if ($_SESSION [$this->prefix . 'keysearch']) {
                    $keysearch = $_SESSION [$this->prefix . 'keysearch'];
                    $where .= " AND ( a.code LIKE '%" . $keysearch . "%' OR a.id = '".$keysearch."')";
                }
            }

            $query = ' SELECT a.*
						  FROM '.$this -> table_name.' AS a
						   WHERE 1 = 1
						    '
                          .$where .$ordering;
            return $query;
        }


        public function getOrderById()
        {
            $id = FSInput::get('id', 0, 'int');
            global $db;
            $query = '  SELECT *
					FROM '.$this -> table_name.' AS a
					WHERE
						id = '.$id
                    ;
            $db->query($query);
            $result = $db->getObject();
            return $result;
        }

        public function save($row = array(), $use_mysql_real_escape_string = 0)
        {
            $id = FSInput::get('id', 0, 'int');

            $row['user_admin'] = $user_id;
            $row['user_admin_name'] = $username;

            $published = FSInput::get('published');
            //$end = date('Y-m-d H:i:s', strtotime('+1 years'));
    //        $row['date_end'] = $end;
            $order = $this->get_record_by_id($id, $this -> table_name);
            if($order && $order->user_edited == '' && $published == 1 ){
                $row['time_edited'] = date('Y-m-d H:i:s');
                $row['user_edited'] = $username;
            }
            
            $row['status'] = FSInput::get('status');
            if ($row['status'] && $row['status'] == 1) {
                $row['date_start'] = date('Y-m-d H:i:s');
                $end = date('Y-m-d H:i:s', strtotime('+1 years'));
                $row['date_end'] = $end;
                $row['time_approval'] = date('Y-m-d H:i:s');
                $row['user_approval'] = $username;
            }

            $ids = parent::save($row, 1);
            if (! $ids) {
                Errors::setError('Not save');
                return false;
            }

            $global_class = FSFactory::getClass('FsGlobal');
            $payment_array = array(
                        1=>FSText::_('Thanh toán Thẻ tín dụng/Thẻ ghi nợ'),
                        2=>FSText::_('Thanh toán Thẻ ATM'),
                        3=>FSText::_('Thanh toán chuyển khoản'),
                        4=>FSText::_('Thanh toán trực tiếp'),
                    );

            $array_status = array(
                        1 => FSText::_('Đã hoàn tất'),
                        2 => FSText::_('Đã thanh toán online'),
                        3 => FSText::_('Chưa hoàn tất'),
                        4 => FSText::_('Đã hủy')
                    );
            $html = '';

            if ($id && $row['status'] == 1) {
                //$order = $this->get_record_by_id($id, $this -> table_name);
                if ($order) {
                    //$setSubject = FSText::_('Thông tin xác nhận kích hoạt dịch vụ đơn hàng  E-marketing từ ketnoigiaoduc.vn').' - '.$order->code;
                    $setSubject = $global_class->getConfig_email('subject_comfim_service_post');
                    $setSubject = str_replace('{code}', 'Tìm kiếm thông tin thí sinh  -'.$order->code, $setSubject);

                    $body = $global_class->getConfig_email('email_published');
                    $body = str_replace('{username}', $order->name, $body);
                    $body = str_replace('{service}', 'Đăng tuyển', $body);
                    $body = str_replace('{count}', 1, $body);
                    $body = str_replace('{code}', $order->code, $body); //hình thức thanh toán
                    $body = str_replace('{type_order}', $payment_array[$order->form_of_payment], $body); //Tình trạng thanh toán
                    $body = str_replace('{status}', $array_status[$order->status], $body);
                    //$body = str_replace('{price}', format_money($order->total,' VNĐ'), $body);
                    $body = str_replace('{date_start}', date('d-m-Y', strtotime($row['date_start'])), $body);
                    $body = str_replace('{date_end}', date('d-m-Y', strtotime($row['date_end'])), $body);

                    $title = FSText::_('Tìm thông tin thí sinh 30 ngày');
                    $html .= '<table style="width:100%;background-color: transparent;border-spacing: 0;border-collapse: collapse;text-align: center;line-height: 22px;">
                                <thead>
                                  <tr>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('STT').'</th>
                                    <th style="border-bottom: 1px solid #ddd;"> '.FSText::_('Tên').'</th>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('Số lượng').'</th>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('Tiết kiệm').'</th>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('Giá').'</th>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('VAT(10%)').'</th>
                                    <th style="border-bottom: 1px solid #ddd;">'.FSText::_('Tổng cộng').'</th>
                                  </tr>
                                </thead>
                                <tbody>
                            ';
                    // danh sach dich vu da mua
                    $total = $total >= 0? $total:0;
                    $html .= '
                                <tr>
                                    <td style="border: 1px solid #ddd;">1</td>
                                    <td style="border: 1px solid #ddd;">
                                        <h4 style="color:#006cc6;margin-bottom: 5px;text-align: left;">'.$title.'</h4>
                                    </td>
                                    <td style="border: 1px solid #ddd;"><strong style="color: #e83e28;">'.$order->quantity.'</strong></td>
                                    <td style="border: 1px solid #ddd;"><strong style="color: #e83e28;">'.$order->discount.'</strong></td>
                                    <td style="border: 1px solid #ddd;"><strong style="color: #e83e28;">'.format_money($order->total_, ' VNĐ', '0').'</strong></td>
                                    <td style="border: 1px solid #ddd;"><strong style="color: #e83e28;">'.format_money($order->total_vat, ' VNĐ', '0').'</strong></td>
                                    <td style="border: 1px solid #ddd;"><strong style="color: #e83e28;">'.format_money($order->total_rs, ' VNĐ', '0').'</strong></td>
                                </tr>
                            ';
                    // tong gia tri don hang
                    $html .= '<div style="font-size:20px;text-align:center;margin-bottom:10px;margin-top: 20px;">'.FSText::_('Tổng giá trị đơn hàng').': <strong style="color: #e83e28;">'.format_money($order->total, ' VNĐ', '0').'</strong></div>';

                    $body = str_replace('{content}', $html, $body);

                    $link = FSRoute::_('index.php?module=service&view=order_management');
                    $body = str_replace('{order_management}', '<a href="'.$link.'" style="display:block;text-align: center">'.FSText::_('Đi tới trang quản lý đơn hàng của bạn').'</a>', $body);
                    $this->send_email1($setSubject, $body, $order->name, $order->email);
                }
            }

            return $ids;
        }

        public function cancel_order()
        {
            $cancel_people = $_SESSION['ad_username'];
            $id = FSInput::get('id', 0, 'int');
            $time = date("Y-m-d H:i:s");
            if (!$id) {
                return;
            }
            global $db;

            // get order_id to return
            $query = " SELECT *
						FROM fs_order
						WHERE
							id = $id
							AND is_temporary = 1
					";

            $db -> query($query);
            $order = $db -> getObject();


            $order_id = $order -> id;

            //print_r($order_id);die;

            if (!$order_id) {
                return false;
            }


            if ($order ->  status) {
                return false;
            }

            $row['status'] = 2;
            $row['edited_time'] = $time;
            $row['cancel_people'] = $cancel_people;
            $row['cancel_time'] = $time;
            $row['cancel_is_penalty'] = 1;
            $row['cancel_is_compensation'] = 1;
            $row['status_before_cancel'] = 0;
            $row['is_dispute'] = 0;
            $rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);


            return $rs;
            return;
        }

        public function finished_order()
        {
            $cancel_people = $_SESSION['ad_username'];
            $id = FSInput::get('id', 0, 'int');
            $time = date("Y-m-d H:i:s");
            if (!$id) {
                return;
            }

            global $db;
            // get order_id to return
            $query = " SELECT *
						FROM fs_order
						WHERE
							id = $id
							AND is_temporary = 1
					";
            $db -> query($query);
            $order = $db -> getObject();
            $order_id = $order -> id;
            if (!$order_id) {
                return false;
            }
            if ($order ->  status >= 1) {
                return false;
            }
            if (!$order ->  status) {
                $row['status'] = 1;
                $row['edited_time'] = $time;
                $row['status_before_cancel'] = 0;
                $rs = $this -> _update($row, 'fs_order', ' id = '.$order -> id);
                if (!$rs) {
                    return false;
                }

                // cộng tiền thanh toán vào bảng thành viên
                $this -> add_money_to_member($order -> total_after_discount, $order -> user_id);
                $this -> add_buy_number_to_product($order -> id);
                $this -> change_status_oder($order -> id);
                // send email after payment successful
                $this -> mail_to_buyer_after_successful($order -> id);
                return $rs;
            }
            return;
        }

        public function mail_to_buyer_after_successful($id)
        {
            if (!$id) {
                return;
            }
            global $db;


            // get order
            $query = " SELECT *
						FROM fs_order
						WHERE  id = '$id'
							AND is_temporary = 1
					";
            $db -> query($query);
            $order = $db->getObject();
//			$estore = $this -> getEstore($order -> estore_id);
            $data = $this -> get_orderdetail_by_orderId($id);
            if (count($data)) {
                $i = 0;
                $str_prd_ids = '';
                foreach ($data as $item) {
                    if ($i > 0) {
                        $str_prd_ids .= ',';
                    }
                    $str_prd_ids .= $item -> product_id;
                    $i ++;
                }
                $arr_product = $this -> get_products_from_orderdetail($str_prd_ids);
            }

            if (!$order) {
                return;
            }

                // send Mail()
                $mailer = FSFactory::getClass('Email', 'mail');

            $select = 'SELECT * FROM fs_config WHERE published = 1';
            global $db;
            $db -> query($select);
            $config = $db->getObjectListByKey('name');
            $admin_name  = $config['admin_name']-> value;
            $admin_email  = $config['admin_email']-> value;
            $mail_order_body  = $config['mail_order_successful_body']-> value;
            $mail_order_subject  = $config['mail_order_successful_subject']-> value;

//				$admin_name = $global -> getConfig('admin_name');
//				$admin_email = $global -> getConfig('admin_email');
//				$mail_order_body = $global -> getConfig('mail_order_successful_body');
//				$mail_order_subject = $global -> getConfig('mail_order_successful_subject');
//				echo $mail_order_body;
//				die;
                $mailer -> isHTML(true);
            $mailer -> setSender(array($admin_email,$admin_name));
            $mailer -> AddBCC('phamhuy@finalstyle.com', 'pham van huy');
            $mailer -> AddAddress($order->recipients_email, $order->recipients_name);
            $mailer -> setSubject($mail_order_subject);

                // body
                $body = $mail_order_body;
            $body = str_replace('{name}', $order-> sender_name, $body);
            $body = str_replace('{ma_don_hang}', 'DH'.str_pad($order -> id, 8, "0", STR_PAD_LEFT), $body);

                // SENDER
                $sender_info = '<table cellspacing="0" cellpadding="6" border="0" width="100%" class="tabl-info-customer">';
            $sender_info .= '	<tbody>';
            $sender_info .= ' <tr>';
            $sender_info .= '<td width="173px">Tên người đặt hàng </td>';
            $sender_info .= '<td width="5px">:</td>';
            $sender_info .= '<td>'.$order-> sender_name.'</td>';
            $sender_info .= '</tr>';
            $sender_info .= '<tr>';
            $sender_info .= '<td>Giới tính</td>';
            $sender_info .= '<td width="5px">:</td>';
            $sender_info .= '<td>';
            if (trim($order->sender_sex) == 'female') {
                $sender_info .= "N&#7919;";
            } else {
                $sender_info .= "Nam";
            }
            $sender_info .= '</td>';
            $sender_info .= '</tr>';
            $sender_info .= '<tr>';
            $sender_info .= '<td>Địa chỉ  </td>';
            $sender_info .= '<td width="5px">:</td>';
            $sender_info .= '<td>'.$order-> sender_address.'</td>';
            $sender_info .= '</tr>';
            $sender_info .= '<tr>';
            $sender_info .= '<td>Email </td>';
            $sender_info .= '<td width="5px">:</td>';
            $sender_info .= '<td>'.$order-> sender_email.'</td>';
            $sender_info .= '</tr>';
            $sender_info .= '<tr>';
            $sender_info .= '<td>Điện thoại </td>';
            $sender_info .= '<td width="5px">:</td>';
            $sender_info .= '<td>'. $order-> sender_telephone .'</td>';
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
            $recipient_info .= '<td>'.$order-> recipients_name.'</td>';
            $recipient_info .= '</tr>';
            $recipient_info .= '<tr>';
            $recipient_info .= '<td>Giới tính </td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>';
            if (trim($order->recipients_sex) == 'female') {
                $recipient_info .= "N&#7919;";
            } else {
                $recipient_info .= "Nam";
            }
            $recipient_info .=    '</td>';
            $recipient_info .= ' </tr>';
            $recipient_info .= ' <tr>';
            $recipient_info .= '<td>Địa chỉ  </td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>'.$order-> recipients_address .'</td>';
            $recipient_info .= '</tr>';
            $recipient_info .= ' <tr>';
            $recipient_info .= '<td>Email </td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>'.$order-> recipients_email .'</td>';
            $recipient_info .= '</tr>';
            $recipient_info .= '<tr>';
            $recipient_info .= '<td>Điện thoại </td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>'.$order-> recipients_telephone .'</td>';
            $recipient_info .= '</tr>';
            $recipient_info .= '<tr>';

            $recipient_info .= '<td>Thời gian đặt hàng</td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>';
            $hour = date('H', strtotime($order-> received_time));
            if ($hour) {
                $recipient_info .= $hour." h, ";
            }
            $recipient_info .=  "ng&#224;y ". date('d/m/Y', strtotime($order-> received_time));
            $recipient_info .= '</td>';
            $recipient_info .= '</tr>';

            $recipient_info .= '<td>Địa điểm nhân hàng </b></td>';
            $recipient_info .= '<td width="5px">:</td>';
            $recipient_info .= '<td>';
            $recipient_info .=  $order->recipients_here ? 'Đặt lấy tại nhà hàng':'Nhận tại địa chỉ người nhận';
            $recipient_info .= '</td>';
            $recipient_info .= '</tr>';

            $recipient_info .= '</tbody>';
            $recipient_info .= '</table>';
                // end RECIPIENT


//				$body .= '<br/>';
//				$body .= '<div style="background: none repeat scroll 0 0 #55AEE7;color: #FFFFFF;font-weight: bold;height: 27px;padding-left: 10px;line-height: 25px; margin: 2px;">Chi tiết đơn hàng</div>';
//				$body .= '<div style="padding: 10px">';
                // detail
                $order_detail = '	<table width="964" cellspacing="0" cellpadding="6" bordercolor="\#CCC" border="1" align="center" style="border-style:solid;border-collapse:collapse;margin-top:2px">';
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

//				$total_money = 0;
                $total_discount = 0;
            for ($i = 0 ; $i < count($data); $i ++) {
                $item = $data[$i];
//					$link_view_product = FSRoute::_('index?module=products&view=product&ename='.@$estore->estore_url.'&id='.$item->product_id.'&code='.@$arr_product[$item->product_id] -> alias.'&Itemid=6');
                    $link_view_product = FSRoute::_('index.php?module=products&view=product&pcode='.@$arr_product[$item->product_id] -> alias.'&id='.$item->product_id.'&ccode='.@$arr_product[$item->product_id] ->category_alias.'&Itemid=5');
//					$total_money += $item -> total;
//					$total_discount += $item -> discount * $item -> count;

                    $order_detail .= '				<tr>';
                $order_detail .= '					<td align="center">';
                $order_detail .= '						<strong>'.($i+1).'</strong><br/>';
                $order_detail .= '					</td>';
                $order_detail .= '					<td> ';
                $order_detail .= '						<a href="'.$link_view_product.'">';
                $order_detail .=                            @$arr_product[$item -> product_id] -> name;
                $order_detail .= '						</a> ';
                $order_detail .= '					</td>';

                                        //		PRICE
                    $order_detail .= '					<td> ';
                $order_detail .= '						<strong>';
                $order_detail .=                            format_money($item -> price);
                $order_detail .= '						</strong> VND';
                $order_detail .= '					</td>';
                $order_detail .= '					<td> ';
                $order_detail .= '						<strong>';
                $order_detail .=                            $item -> count?$item -> count:0;
                $order_detail .= '						</strong>';
                $order_detail .= '					</td>';
                $order_detail .= '					<td> ';
                $order_detail .= '						<span >';
                $order_detail .=                            format_money($item -> total);
                $order_detail .= '						</span> VND';
                $order_detail .= '					</td>';
                $order_detail .= '				</tr>';
            }
            $order_detail .= '				<tr>';
            $order_detail .= '					<td colspan="4"  align="right"><strong>Tổng:</strong></td>';
            $order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount).'</strong> VND</td>';
            $order_detail .= '				</tr>';
            if ($order -> payment_method) {
                $order_detail .= '				<tr>';
                $order_detail .= '					<td colspan="4"  align="right"><strong>Giảm giá (khi mua qua address):</strong></td>';
                $order_detail .= '					<td ><strong >'.format_money($order -> total_before_discount - $order -> total_after_discount).'</strong> VND</td>';
                $order_detail .= '				</tr>';
                $order_detail .= '				<tr>';
                $order_detail .= '					<td colspan="4"  align="right"><strong>Thành tiền:</strong></td>';
                $order_detail .= '					<td ><strong >'.format_money($order -> total_after_discount).'</strong> VND</td>';
                $order_detail .= '				</tr>';
            }
            $order_detail .= '		</tbody>';
            $order_detail .= '	</table>	';

//				$body .= '	<br/><br/>	';
//				$body .= '<div style="padding: 10px;font-weight: bold;margin-bottom: 30px;">';
//				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';
//				$body .=  '<div> '.$site_name.' (<a href="'.URL_ROOT.'" target="_blank">'.URL_ROOT.'</a>)</div>';
//				$body .= '	</div>	';
//				$body .= '</div>';
                $body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
            $body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
            $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

            $mailer -> setBody($body);
            if (!$mailer ->Send()) {
                return false;
            }
            return true;
        }


        public function change_status_oder($oder_id)
        {
            global $db;
            $sql = 'UPDATE fs_order_items SET status = 1
						WHERE order_id = '.$oder_id    ;
            $db->query($sql);
            $rows = $db->affected_rows();
        }
        /*
         * Repay the money after cancel order for guest
         */
        public function repay($money, $guest_username, $str_penaty = '')
        {
            // SAVE FS_MEMBERS
            // add money
            global $db;
            if (!$guest_username) {
                return false;
            }
            $sql = "UPDATE fs_members SET `money` = money + ".$money." WHERE username = '".$guest_username."' ";
            $db->query($sql);
            $rows = $db->affected_rows();
            if (!$rows) {
                return false;
            }

            // SAVE HISTORY
            $time = date("Y-m-d H:i:s");
            $row3['money'] = $money;
            $row3['type'] = 'deposit';
            $row3['username'] = $guest_username;
            $row3['created_time'] = $time;
            $row3['description'] = $str_penaty;
            $row3['service_name'] = 'Trả lại tiền';
            if (!$this -> _add($row3, 'fs_history')) {
                return false;
            }
        }


        public function pay_penalty()
        {
            $cancel_people = $_SESSION['ad_username'];
            $id = FSInput::get('id', 0, 'int');
            $time = date("Y-m-d H:i:s");
            if (!$id) {
                return;
            }

            $row['edited_time'] = $time;
            $row['cancel_is_penalty'] = 1;
            $rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
            return $rs;
        }
        public function pay_compensation()
        {
            $cancel_people = $_SESSION['ad_username'];
            $id = FSInput::get('id', 0, 'int');
            $time = date("Y-m-d H:i:s");
            if (!$id) {
                return;
            }

            $row['edited_time'] = $time;
            $row['cancel_is_compensation'] = 1;
            $rs = $this -> _update($row, 'fs_order', ' id = '.$id. ' AND status = 6 ');
            return $rs;
        }
        public function get_orderdetail_by_orderId($order_id)
        {
            if (!$order_id) {
                return;
            }
            $session_id = session_id();
            $query = " SELECT a.*
						FROM fs_order_items AS a
						WHERE  a.order_id = $order_id ";
            global $db;
            $db -> query($query);
            return $rs = $db->getObjectList();
        }

        public function get_products_from_orderdetail($str_product_ids)
        {
            if (!$str_product_ids) {
                return false;
            }
            $query = " SELECT a.*
						FROM fs_products AS a
						WHERE id IN ($str_product_ids) ";
            global $db;
            $db -> query($query);
            $products = $db->getObjectListByKey('id');
            return $products;
        }

        public function get_member_info($start = 0, $end = 0)
        {
            global $db;
            $query = $this->setQuery();
            if (!$query) {
                return array();
            }
            $sql = $db->query_limit_export($query, $start, $end);
            $result = $db->getObjectList();
            if (isset($_POST['filter'])) {
                $_SESSION[$this -> prefix.'filter']  =  $_POST['filter'] ;
            }

            return $result;
        }
    }
