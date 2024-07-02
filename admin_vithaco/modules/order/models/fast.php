<?php

class OrderModelsFast extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 40;
        $this->view = 'fast';
        $this->table_name = 'fs_fast_order';
        parent::__construct();
    }


    function setQuery()
    {

        // ordering
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, id DESC ";
        }

        // from
        if (isset($_SESSION[$this->prefix . 'text0'])) {
            $date_from = $_SESSION[$this->prefix . 'text0'];
            if ($date_from) {
                $date_from = strtotime($date_from);
                $date_new = date('Y-m-d H:i:s', $date_from);
                $where .= ' AND a.created_time >=  "' . $date_new . '" ';
            }
        }

        // to
        if (isset($_SESSION[$this->prefix . 'text1'])) {
            $date_to = $_SESSION[$this->prefix . 'text1'];
            if ($date_to) {
                $date_to = $date_to . ' 23:59:59';
                $date_to = strtotime($date_to);
                $date_new = date('Y-m-d H:i:s', $date_to);
                $where .= ' AND a.created_time <=  "' . $date_new . '" ';
            }
        }

        // userid
        if (isset($_SESSION[$this->prefix . 'text2'])) {
            $userid = $_SESSION[$this->prefix . 'text2'];
            $userid = intval($userid);
            if ($userid) {
                $where .= ' AND a.user_id =  ' . $userid;
            }
        }

        if (!$ordering)
            $ordering .= " ORDER BY id DESC ";

        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.status =  "' . $filter . '" ';
            }
        }
        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {

                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
//                if (strpos($keysearch, 'DH') === 0) {
//                    $keysearch_id = str_replace('DH', '', $keysearch);
//                    $keysearch_id = (int)$keysearch_id;
//                }
                $where .= " AND ( name LIKE  '%" . $keysearch . "%' OR telephone LIKE  '%" . $keysearch . "%' ";
//                if (isset($keysearch_id))
//                    $where .= "	OR a.id LIKE '%" . $keysearch_id . "%' ";
                $where .= "	)";
            }
        }
        $query = " SELECT a.*
						  FROM fs_fast_order AS a  
						   WHERE 1 = 1 and published=1 
						    "
            . $where . $ordering;
//			echo $query;
        return $query;
    }

    function get_data_order()
    {
        $id = FSInput::get('id', 0, 'int');
        global $db;
        $query = "  SELECT * 
					FROM fs_fast_order
					WHERE
						id = $id
					";
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getOrderById()
    {
        $id = FSInput::get('id', 0, 'int');
        global $db;
        $query = "  SELECT *
					FROM fs_order AS a
					WHERE
						id = $id
					";
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1){
//        $row['city_name'] = $this->get_record('id = '.FSInput::get('city_id'),'fs_cities')->name;
//        $row['district_name'] = $this->get_record('id = '.FSInput::get('district_id'),'fs_districts')->name;
        $rs = parent::save($row);
        return $rs;
    }

    function cancel_order()
    {
        $cancel_people = $_SESSION['ad_username'];
        $id = FSInput::get('id', 0, 'int');
        $time = date("Y-m-d H:i:s");
        if (!$id)
            return;
        global $db;

        // get order_id to return
        $query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
						  
					";

        $db->query($query);
        $order = $db->getObject();


        $order_id = $order->id;

        //print_r($order_id);die;

        if (!$order_id)
            return false;


        if ($order->status)
            return false;

        $row['status'] = 2;
        $row['edited_time'] = $time;
        $row['cancel_people'] = $cancel_people;
        $row['cancel_time'] = $time;
        $row['cancel_is_penalty'] = 1;
        $row['cancel_is_compensation'] = 1;
        $row['status_before_cancel'] = 0;
        $row['is_dispute'] = 0;
        $rs = $this->_update($row, 'fs_order', ' id = ' . $order->id);


        return $rs;
        return;
    }

    function finished_order()
    {
        $cancel_people = $_SESSION['ad_username'];
        $id = FSInput::get('id', 0, 'int');
        $time = date("Y-m-d H:i:s");
        if (!$id)
            return;

        global $db;
        // get order_id to return
        $query = " SELECT * 
						FROM fs_order
						WHERE   
							id = $id 
						  
					";
        $db->query($query);
        $order = $db->getObject();
        $order_id = $order->id;
        if (!$order_id)
            return false;
        if ($order->status >= 1)
            return false;
        if (!$order->status) {
            $row['status'] = 1;
            $row['edited_time'] = $time;
            $row['status_before_cancel'] = 0;
            $rs = $this->_update($row, 'fs_order', ' id = ' . $order->id);
            if (!$rs)
                return false;

            // cộng tiền thanh toán vào bảng thành viên
            $this->add_money_to_member($order->total_after_discount, $order->user_id);
            $this->add_buy_number_to_product($order->id);
            $this->change_status_oder($order->id);
            // send email after payment successful
//				$this -> mail_to_buyer_after_successful($order -> id);
            return $rs;
        }
        return;
    }

    function mail_to_buyer_after_successful($id)
    {
        if (!$id)
            return;
        global $db;


        // get order
        $query = " SELECT * 
						FROM fs_order
						WHERE  id = '$id' 
							AND is_temporary = 1 
					";
        $db->query($query);
        $order = $db->getObject();
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

        $select = 'SELECT * FROM fs_config WHERE published = 1';
        global $db;
        $db->query($select);
        $config = $db->getObjectListByKey('name');
        $admin_name = $config['admin_name']->value;
        $admin_email = $config['admin_email']->value;
        $mail_order_body = $config['mail_order_successful_body']->value;
        $mail_order_subject = $config['mail_order_successful_subject']->value;

//				$admin_name = $global -> getConfig('admin_name');
//				$admin_email = $global -> getConfig('admin_email');
//				$mail_order_body = $global -> getConfig('mail_order_successful_body');
//				$mail_order_subject = $global -> getConfig('mail_order_successful_subject');
//				echo $mail_order_body;
//				die;
        $mailer->isHTML(true);
        $mailer->setSender(array($admin_email, $admin_name));
        $mailer->AddBCC('phamhuy@finalstyle.com', 'pham van huy');
        $mailer->AddAddress($order->recipients_email, $order->recipients_name);
        $mailer->setSubject($mail_order_subject);

        // body
        $body = $mail_order_body;
        $body = str_replace('{name}', $order->sender_name, $body);
        $body = str_replace('{ma_don_hang}', 'DH' . str_pad($order->id, 8, "0", STR_PAD_LEFT), $body);

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
        for ($i = 0; $i < count($data); $i++) {
            $item = $data[$i];
//					$link_view_product = FSRoute::_('index?module=products&view=product&ename='.@$estore->estore_url.'&id='.$item->product_id.'&code='.@$arr_product[$item->product_id] -> alias.'&Itemid=6');
            $link_view_product = FSRoute::_('index.php?module=products&view=product&pcode=' . @$arr_product[$item->product_id]->alias . '&id=' . $item->product_id . '&ccode=' . @$arr_product[$item->product_id]->category_alias . '&Itemid=5');
//					$total_money += $item -> total;
//					$total_discount += $item -> discount * $item -> count;

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

//				$body .= '	<br/><br/>	';
//				$body .= '<div style="padding: 10px;font-weight: bold;margin-bottom: 30px;">';
//				$body .= '<div>Ch&acirc;n th&agrave;nh c&#7843;m &#417;n!</div>';
//				$body .=  '<div> '.$site_name.' (<a href="'.URL_ROOT.'" target="_blank">'.URL_ROOT.'</a>)</div>';
//				$body .= '	</div>	';
//				$body .= '</div>';
        $body = str_replace('{thong_tin_nguoi_dat}', $sender_info, $body);
        $body = str_replace('{thong_tin_nguoi_nhan}', $recipient_info, $body);
        $body = str_replace('{thong_tin_don_hang}', $order_detail, $body);

        $mailer->setBody($body);
        if (!$mailer->Send())
            return false;
        return true;
    }


    /*
     * Add điểm vào bảng thành viên
     */
    function add_money_to_member($money, $user_id)
    {
        if (!$money || !$user_id)
            return;
        $sql = 'UPDATE fs_members SET money = money + ' . $money . '
						WHERE id = ' . $user_id;
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }

    /*
     * Thêm số lần mua vào bảng sản phẩm
     */
    function add_buy_number_to_product($oder_id)
    {
        $order_items = $this->get_records('order_id = ' . $oder_id, 'fs_order_items', '*');
        if (!count($order_items))
            return;
        global $db;
        foreach ($order_items as $item) {
            $sql = 'UPDATE fs_products SET sale_count = sale_count + ' . $item->count . '
						WHERE id = ' . $item->product_id;
            $db->query($sql);
            $rows = $db->affected_rows();
        }
    }

    function change_status_oder($oder_id)
    {
        global $db;
        $sql = 'UPDATE fs_order_items SET status = 1
						WHERE order_id = ' . $oder_id;
        $db->query($sql);
        $rows = $db->affected_rows();
    }

    /*
     * Repay the money after cancel order for guest
     */
    function repay($money, $guest_username, $str_penaty = '')
    {
        // SAVE FS_MEMBERS
        // add money
        global $db;
        if (!$guest_username)
            return false;
        $sql = "UPDATE fs_members SET `money` = money + " . $money . " WHERE username = '" . $guest_username . "' ";
        $db->query($sql);
        $rows = $db->affected_rows();
        if (!$rows)
            return false;

        // SAVE HISTORY
        $time = date("Y-m-d H:i:s");
        $row3['money'] = $money;
        $row3['type'] = 'deposit';
        $row3['username'] = $guest_username;
        $row3['created_time'] = $time;
        $row3['description'] = $str_penaty;
        $row3['service_name'] = 'Trả lại tiền';
        if (!$this->_add($row3, 'fs_history'))
            return false;
    }


    function pay_penalty()
    {
        $cancel_people = $_SESSION['ad_username'];
        $id = FSInput::get('id', 0, 'int');
        $time = date("Y-m-d H:i:s");
        if (!$id)
            return;

        $row['edited_time'] = $time;
        $row['cancel_is_penalty'] = 1;
        $rs = $this->_update($row, 'fs_order', ' id = ' . $id . ' AND status = 6 ');
        return $rs;
    }

    function pay_compensation()
    {
        $cancel_people = $_SESSION['ad_username'];
        $id = FSInput::get('id', 0, 'int');
        $time = date("Y-m-d H:i:s");
        if (!$id)
            return;

        $row['edited_time'] = $time;
        $row['cancel_is_compensation'] = 1;
        $rs = $this->_update($row, 'fs_order', ' id = ' . $id . ' AND status = 6 ');
        return $rs;
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
        return $rs = $db->getObjectList();
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

    function get_member_info($start = 0, $end = 0)
    {
        global $db;
        $query = $this->setQuery();
        if (!$query)
            return array();
        $sql = $db->query_limit_export($query, $start, $end);
        $result = $db->getObjectList();

        if (isset($_POST['filter'])) {
            $_SESSION[$this->prefix . 'filter'] = $_POST['filter'];
        }

        return $result;
    }

    function _update($row, $table_name, $where = '', $use_mysql_real_escape_string = 1)
    {
        global $db;
        $total = count($row);
        if (!$total || !$table_name)
            return;
        $sql = 'UPDATE ' . $table_name . ' SET ';
        $i = 0;

        foreach ($row as $key => $value) {
            if ($use_mysql_real_escape_string) {
                if ($value == 0) {
                    $sql .= "`" . $key . "` = '" . $value . "'";
                } else {
                    $sql .= "`" . $key . "` = '" . $db->escape_string($value) . "'";
                }
            } else {
                $sql .= "`" . $key . "` = '" . $value . "'";
            }
            if ($i < $total - 1)
                $sql .= ',';
            $i++;

        }
        if ($where)
            $where = ' WHERE ' . $where;
        $sql .= $where;
        //$rows = $db->affected_rows($sql);
        $db->query($sql);
        $rows = $db->affected_rows();
        //print_r($rows);die;
        return $rows;
    }

    function get_city(){
        $query = " SELECT name, id
						FROM fs_cities WHERE published = 1";
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_district(){
        $query = " SELECT name, id
						FROM fs_districts WHERE published = 1";
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
}

?>
