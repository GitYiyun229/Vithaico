<?php

class PolicyModelsPolicy extends FSModels
{
	var $limit;
	var $prefix;

	function __construct()
	{
		$this->limit = 40;
		$this->view = 'policy';
		$this->table_name = 'fs_agency';
		parent::__construct();
	}


	function setQuery()
	{

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
		if (isset($_SESSION[$this->prefix . 'filter0'])) {
			$filter = $_SESSION[$this->prefix . 'filter0'];
			if ($filter) {
				$filter = (int)$filter - 1;
				$where .= ' AND a.status =  "' . $filter . '" ';
			}
		}
		if (isset($_SESSION[$this->prefix . 'keysearch'])) {
			if ($_SESSION[$this->prefix . 'keysearch']) { {
					$keysearch = $_SESSION[$this->prefix . 'keysearch'];
					$where .= " AND a.name LIKE '%" . $keysearch . "%' ";
				}
			}
		}
		$query = " SELECT a.*
						  FROM fs_agency AS a  
						   WHERE 1 = 1 
						    "
			. $where . $ordering;
		//echo $query;die;
		return $query;
	}
	function get_data_agency()
	{
		$id = FSInput::get('id', 0, 'int');
		global $db;
		$query = "  SELECT *
					FROM fs_agency AS a
					";
		$db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	function getAgencyById()
	{
		$id = FSInput::get('id', 0, 'int');
		global $db;
		$query = "  SELECT *
					FROM fs_agency AS a
					WHERE
						id = $id
					";
		$db->query($query);
		$result = $db->getObject();
		return $result;
	}

	function save($row = array(), $use_mysql_real_escape_string = 1)
	{
		global $db, $config;
		$row = array();
		$row['status'] = FSInput::get('status');
		$id = FSInput::get('id', 0, 'int');
		$ord = $this->get_record_by_id($id, 'fs_order');
		//var_dump($config['mail_stt_change']);
		if ($row['status'] == 4) {
			$stt = $ord->status;
			$dt = $ord->diem_thuong;
			$dg = $ord->diem_gop;
			if ($stt != 4) {
				if ($dt || $dg) {
					$t = '"Đã giao hàng và thanh toán thành công"';
					$rowh = array();
					$dtus = $this->get_record_by_id($ord->user_id, 'fs_members', 'diem_thuong,diem_gop');
					if ($dt) {
						$sql = 'UPDATE fs_members SET diem_thuong=diem_thuong+' . $dt . ' WHERE id=' . $ord->user_id;
						$db->affected_rows($sql);

						$finish = $dtus->diem_thuong + $dt;
						$rowh['surplus'] = $finish;
						$rowh['plus'] = $dt;
						$rowh['user_id'] = $ord->user_id;
						$rowh['order_id'] = $ord->id;
						$rowh['is_diem_thuong'] = 1;
						$rowh['content'] = 'Mua hàng cộng điểm';
						$rowh['published'] = 1;
						$time = date("Y-m-d H:i:s");
						$rowh['created_time'] = $time;
						$this->_add($rowh, 'fs_point');
					}
					if ($dg) {
						$sql = 'UPDATE fs_members SET diem_gop=diem_gop+' . $dg . ' WHERE id=' . $ord->user_id;
						$db->affected_rows($sql);

						$finish = $dtus->diem_gop + $dg;
						$rowh['surplus'] = $finish;
						$rowh['plus'] = $dg;
						$rowh['user_id'] = $ord->user_id;
						$rowh['order_id'] = $ord->id;
						$rowh['is_diem_thuong'] = 0;
						$rowh['content'] = 'Mua hàng cộng điểm';
						$rowh['published'] = 1;
						$time = date("Y-m-d H:i:s");
						$rowh['created_time'] = $time;
						$this->_add($rowh, 'fs_point');

						$sqlcf = 'UPDATE fs_config SET `value`=`value`+' . $dg . ' WHERE `name`="points"';
						$db->affected_rows($sqlcf);
					}

					$rowst['message'] = addslashes('Đơn hàng <a href="' . FSRoute::_('index.php?module=users&view=order&task=show_order&id=' . $ord->id) . '" >DH' . str_pad($ord->id, 8, "0", STR_PAD_LEFT) . '</a> ' . $t);
					$kq = $this->_add($rowst, 'fs_notify');
					if ($kq) {
						$body = '';
						$body .= $config['mail_stt_change'];
						$body = str_replace('{name_pay}', $ord->recipients_name, $body);
						$body = str_replace('{status}', $t, $body);
						$body = str_replace('{time}', $ord->created_time, $body);
						$body = str_replace('{mail_pay}', $ord->recipients_email, $body);
						$body = str_replace('{phone_pay}', $ord->recipients_telephone, $body);
						$body = str_replace('{id_order}', 'DH' . str_pad($id, 8, "0", STR_PAD_LEFT), $body);
						$body = str_replace('{name_re}', $ord->sender_name, $body);
						$body = str_replace('{mail_re}', $ord->sender_email, $body);
						$body = str_replace('{add_re}', $ord->sender_address . ', ' . $ord->sender_wards . ', ' . $ord->sender_district . ', ' . $ord->sender_province, $body);
						$body = str_replace('{phone_re}', $ord->sender_telephone, $body);
						$body = str_replace('{link}', FSRoute::_('index.php?module=users&view=order&task=show_order&id=' . $ord->id), $body);
						if ($ord->ord_payment_type == 1) {
							$payType = 'Giao hàng - nhận tiền (COD)';
						} elseif ($ord->ord_payment_type == 3) {
							$payType = 'Thanh toán qua VNPAY';
						}
						if ($ord->fee) {
							$fee = format_money($ord->fee);
						} else
							$fee = '0 đ';
						$body = str_replace('{pay_type}', $payType, $body);
						$body = str_replace('{fee}', $fee, $body);

						if ($ord->total_after_discount && $ord->fee) {
							$money = format_money($ord->total_after_discount + (float)$ord->fee);
						} elseif (!$ord->total_after_discount && $ord->fee)
							$money = format_money((float)$ord->fee);
						elseif ($ord->total_after_discount && !$ord->fee)
							$money = format_money($ord->total_after_discount);
						elseif (!$ord->total_after_discount && !$ord->fee)
							$money = "0 đ";

						$body = str_replace('{fee}', $fee, $body);
						$body = str_replace('{total}', format_money($ord->total_before_discount), $body);

						if ($ord->discount_money) {
							$dis_mon = format_money($ord->discount_money);
						} else
							$dis_mon = '0 đ';
						$body = str_replace('{dis}', $dis_mon, $body);
						$body = str_replace('{money}', $money, $body);

						$this->send_email1('Lovegifts thông báo -' . $t, $body, $ord->recipients_name, trim($ord->recipients_email), '');
					}
				}
			}
		} else {

			$rowst = array();
			$time = date("Y-m-d H:i:s");
			$rowst['created_time'] = $time;
			$rowst['action_user_id'] = $ord->user_id;
			$rowst['user_id'] = $ord->user_id;
			$rowst['type'] = 'status_order_change';
			$rowst['record_id'] = $id;


			if ($row['status'] == 1) {
				$t = '"Đã xác nhận đặt hàng thành công"';
			} elseif ($row['status'] == 2) {
				$t = '"Sản phẩm đã hết, chúng tôi sẽ thông tin đến quý khách ngay khi có sản phẩm mới"';
			} elseif ($row['status'] == 3) {
				$t = '"Đang vận chuyển"';
			} elseif ($row['status'] == 4) {
				$t = '"Đã giao hàng và thanh toán thành công"';
			} elseif ($row['status'] == 5) {
				$t = '"Đã hủy đơn hàng"';
			}
			$rowst['message'] = addslashes('Đơn hàng <a href="' . FSRoute::_('index.php?module=users&view=order&task=show_order&id=' . $ord->id) . '" >DH' . str_pad($ord->id, 8, "0", STR_PAD_LEFT) . '</a> ' . $t);
			$kq = $this->_add($rowst, 'fs_notify');
			if ($kq) {
				$body = '';
				$body .= $config['mail_stt_change'];
				$body = str_replace('{name_pay}', $ord->recipients_name, $body);
				$body = str_replace('{status}', $t, $body);
				$body = str_replace('{time}', $ord->created_time, $body);
				$body = str_replace('{mail_pay}', $ord->recipients_email, $body);
				$body = str_replace('{phone_pay}', $ord->recipients_telephone, $body);
				$body = str_replace('{id_order}', 'DH' . str_pad($id, 8, "0", STR_PAD_LEFT), $body);
				$body = str_replace('{name_re}', $ord->sender_name, $body);
				$body = str_replace('{mail_re}', $ord->sender_email, $body);
				$body = str_replace('{add_re}', $ord->sender_address . ', ' . $ord->sender_wards . ', ' . $ord->sender_district . ', ' . $ord->sender_province, $body);
				$body = str_replace('{phone_re}', $ord->sender_telephone, $body);
				$body = str_replace('{link}', FSRoute::_('index.php?module=users&view=order&task=show_order&id=' . $ord->id), $body);
				if ($ord->ord_payment_type == 1) {
					$payType = 'Giao hàng - nhận tiền (COD)';
				} elseif ($ord->ord_payment_type == 3) {
					$payType = 'Thanh toán qua VNPAY';
				}
				if ($ord->fee) {
					$fee = format_money($ord->fee);
				} else
					$fee = '0 đ';
				$body = str_replace('{pay_type}', $payType, $body);
				$body = str_replace('{fee}', $fee, $body);

				if ($ord->total_after_discount && $ord->fee) {
					$money = format_money($ord->total_after_discount + (float)$ord->fee);
				} elseif (!$ord->total_after_discount && $ord->fee)
					$money = format_money((float)$ord->fee);
				elseif ($ord->total_after_discount && !$ord->fee)
					$money = format_money($ord->total_after_discount);
				elseif (!$ord->total_after_discount && !$ord->fee)
					$money = "0 đ";

				$body = str_replace('{fee}', $fee, $body);
				$body = str_replace('{total}', format_money($ord->total_before_discount), $body);

				if ($ord->discount_money) {
					$dis_mon = format_money($ord->discount_money);
				} else
					$dis_mon = '0 đ';
				$body = str_replace('{dis}', $dis_mon, $body);
				$body = str_replace('{money}', $money, $body);

				$this->send_email1('Lovegifts thông báo -' . $t, $body, $ord->recipients_name, trim($ord->recipients_email), '');
			}
		}


		$row['note_adc'] = addslashes(FSInput::get('note_adc'));
		return parent::save($row, 0);
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
}
