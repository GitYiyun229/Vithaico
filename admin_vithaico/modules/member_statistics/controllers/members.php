<?php

class Member_statisticsControllersMembers extends Controllers
{
	function __construct()
	{
		$this->view = 'members';
		parent::__construct();
	}

	function display()
	{
		parent::display();
		$sort_field = $this->sort_field;
		$sort_direct = $this->sort_direct;

		$model  = $this->model;
		$list = $model->get_data('');

		// print_r($list);
		foreach ($list as $key => $data) {
			$data->hoa_hong = $data->hoa_hong ? $data->hoa_hong : 0;
			$data->list_f1 = $this->model->get_records("ref_by = $data->ref_code", 'fs_members_register_log', '*', 'id DESC');
			if (!empty($data->list_f1)) {
				$data->orderIdF1 = array_map(function ($item) {
					return $item->user_id;
				}, $data->list_f1);

				$data->orderIdF1 = implode(',', $data->orderIdF1);
			}
			$data->count_f1 = count($data->list_f1) ? count($data->list_f1) : 0;
			// số lượng đơn hàng thành viên mua
			$data->list_order = $this->model->get_records("user_id = $data->id", 'fs_order', '*', 'id DESC');
			// print_r( $data->list_order);
			$data->total_list_order = count($data->list_order);
			$data->total_coin_list_order = 0; // Initialize total_coin
			if (!empty($data->list_order)) {
				foreach ($data->list_order as $item) {
					$data->total_coin_list_order += $item->member_coin; // Sum up the after_coin values
				}
			}
			// số lượng đơn hàng thành viên f1 mua
			$list_order_f1 = $this->model->get_records("user_id IN ( $data->orderIdF1) ", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
			$data->total_list_orderf1 = count($list_order_f1);
			// số lượng coin nhận
			$list_coin = $this->model->get_records("user_id = ( $data->id) ", 'fs_coin_log', 'dieu_kien_nhan,created_time,after_coin,total_coin,before_coin,after_coin,percent,percent_add,order_id', 'id DESC');
			$total_coin = 0; // Initialize total_coin
			if (!empty($list_coin)) {
				foreach ($list_coin as $item) {
					if ($item->dieu_kien_nhan == 1) {
						$total_coin += $item->after_coin; // Sum up the after_coin values
					}
				}
			}
			$data->total_coin_member = $total_coin > 0 ? $total_coin : '0'; // Assign total_coin to total_coin_member, ensuring it's at least '0'
		}
		$pagination = $model->getPagination('');
		include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
	}
	function add()
	{
		$model = $this->model;
		$maxOrdering = $model->getMaxOrdering();
		$list_store = $model->get_records('published = 1', 'fs_store_location');
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}
	function edit()
	{
		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$model  = $this->model;
		$data = $model->get_record_by_id($id);

		if (!$data)
			die('Not found url');
		$rank_member = $model->get_record('level = ' . $data->level, 'fs_members_group', 'image');
		// tổng số lượng đã giới thiệu
		$list_f1 = $this->model->get_records("ref_by = $data->ref_code", 'fs_members', 'id,full_name,telephone,created_time,level,email', 'id DESC');
		if (!empty($list_f1)) {
			// Giả sử mỗi member có một level và mỗi level tương ứng với một image trong fs_members_group
			// Lấy tất cả images từ fs_members_group một lần để tránh query trong vòng lặp
			$rank_level = $this->model->get_records('', 'fs_members_group', 'name,level');
			$name_by_level = [];
			foreach ($rank_level as $rank) {
				$name_by_level[$rank->level] = $rank->name;
			}
			// Ánh xạ mỗi member với image tương ứng dựa trên level
			$orderIdF1 = array_map(function ($item) use ($name_by_level) {
				// Gán image tương ứng với level của member, nếu không có sẽ gán null
				$item->name_rank = $name_by_level[$item->level] ?? null;
				return $item->id;
			}, $list_f1);

			// Chuyển mảng ID thành chuỗi
			$orderIdF1 = implode(',', $orderIdF1);
		}
		// số lượng đơn hàng thành viên mua
		$list_order = $this->model->get_records("user_id = $data->id", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
		$total_list_order = 0; // Initialize total_coin
		$total_coin_list_order = 0; // Initialize total_coin
		if (!empty($list_order)) {
			foreach ($list_order as $item) {
				$total_list_order += $item->total_end; // Sum up the after_coin values
				$total_coin_list_order += $item->member_coin; // Sum up the after_coin values
			}
		}
		// số lượng đơn hàng thành viên f1 mua
		$list_order_f1 = $this->model->get_records("user_id IN ( $orderIdF1) ", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');

		$total_coin_f1 = 0;
		// print_r($list_coin);
		if (!empty($list_order_f1)) {
			foreach ($list_order_f1 as $item) {
				$total_coin_f1 += $item->member_coin;
			}
		}

		// số lượng coin nhận
		$list_coin = $this->model->get_records("user_id =$data->id", 'fs_coin_log', 'status_chi_tra,created_time,after_coin,total_coin,before_coin,after_coin,percent,percent_add,order_id,dieu_kien_nhan', 'id DESC');
		$total_coin = 0;
		// print_r($list_coin);
		if (!empty($list_coin)) {
			foreach ($list_coin as $item) {
				if ($item->dieu_kien_nhan == 1) {
					$total_coin += $item->after_coin;
				}
			}
		}
		$data_f0 = $this->model->get_record("ref_code = $data->ref_by", 'fs_members', '*', 'id DESC');
		$rank_member_f0 = $model->get_record('level = ' . $data_f0->level, 'fs_members_group', 'image');

		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}

	function view_title($data)
	{
		$link = URL_ROOT . $data->username;
		return '<a target="_blink" href="' . $link . '" title="view font-end">' . $data->username . '</a>';
	}

	// Excel toàn bộ danh sách copper ra excel
	function export()
	{
		setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
	}


	function filter_time_hoa_hong()
	{
		$time_hoahong_1 = FSInput::get('time_hoahong_0');
		$time_hoahong_2 = FSInput::get('time_hoahong_1');
		$hoahong_status = FSInput::get('hoahong_status');
		$id = FSInput::get('id');
		$query = 'user_id = ' . $id;
		if ($hoahong_status == 0) {
			$query .= ' AND (status_chi_tra = 0 or status_chi_tra  is null) ';
		} else {
			$query .= ' AND status_chi_tra = 1 ';
		}
		if ($time_hoahong_1 && $time_hoahong_2) {
			if ($time_hoahong_1) {
				$date_from = strtotime($time_hoahong_1);
				$date_new = date('Y-m-d H:i:s', $date_from);
				$query .= ' AND created_time >=  "' . $date_new . '" ';
			}
			if ($time_hoahong_2) {
				$date_to = $time_hoahong_2 . ' 23:59:59';
				$date_to = strtotime($date_to);
				$date_new = date('Y-m-d H:i:s', $date_to);
				$query .= ' AND created_time <=  "' . $date_new . '" ';
			}
		}
	
		$list_coin = $this->model->get_records($query, 'fs_coin_log', 'dieu_kien_nhan,created_time,after_coin,total_coin,before_coin,after_coin,percent,percent_add,order_id', 'id DESC');

		$total_coin = 0; // Initialize total_coin
		$html = ''; // Initialize HTML string
		if (!empty($list_coin)) {
			foreach ($list_coin as $item) {
				if ($item->dieu_kien_nhan == 1) {
					$total_coin += $item->after_coin; // Sum up the after_coin values
				}
				$html .= $this->filter_time_hoa_hong_controller($item); // Append HTML for each item
			}
		}

		echo json_encode(
			[
				'html' => $html,
				'total_coin' => $total_coin . ' VT-Coin',
				'total_vnd' => format_money($total_coin * 4500, 'đ'),
				'status' => $hoahong_status,
			]
		);
		exit;
	}
	function filter_time_order()
	{
		$time_order_0 = FSInput::get('time_order_0');
		$time_order_1 = FSInput::get('time_order_1');
		$array_f1 = FSInput::get('array_f1');
		$id = FSInput::get('id');
		$query = 'user_id = ' . $id;
		if ($time_order_0 && $time_order_1) {
			if ($time_order_0) {
				$date_from = strtotime($time_order_0);
				$date_new = date('Y-m-d H:i:s', $date_from);
				$query .= ' AND created_time >=  "' . $date_new . '" ';
			}
			if ($time_order_1) {
				$date_to = $time_order_1 . ' 23:59:59';
				$date_to = strtotime($date_to);
				$date_new = date('Y-m-d H:i:s', $date_to);
				$query .= ' AND created_time <=  "' . $date_new . '" ';
			}
		}
		$list_order = $this->model->get_records($query, 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
		$html = ''; // Initialize HTML string
		$total_list_order = 0; // Initialize total_coin
		$total_coin_list_order = 0; // Initialize total_coin
		if (!empty($list_order)) {
			foreach ($list_order as $item) {
				$total_list_order += $item->total_end; // Sum up the after_coin values
				$total_coin_list_order += $item->member_coin; // Sum up the after_coin values
				$html .= $this->filter_time_order_controller($item); // Append HTML for each item
			}
		}



		echo json_encode(
			[
				'html' => $html,
				'total_coin' => $total_coin_list_order . ' VT-Coin',
				'total_vnd' => format_money($total_list_order, 'đ'),
			]
		);
		exit;
	}
	function filter_time_orderf1()
	{
		$time_orderf1_0 = FSInput::get('time_orderf1_0');
		$time_orderf1_1 = FSInput::get('time_orderf1_1');
		$array_f1 = FSInput::get('array_f1');
		$id = FSInput::get('id');
		$query = 'user_id in ( ' . $array_f1 . ') ';
		if ($time_orderf1_0 && $time_orderf1_1) {
			if ($time_orderf1_0) {
				$date_from = strtotime($time_orderf1_0);
				$date_new = date('Y-m-d H:i:s', $date_from);
				$query .= ' AND created_time >=  "' . $date_new . '" ';
			}
			if ($time_orderf1_1) {
				$date_to = $time_orderf1_1 . ' 23:59:59';
				$date_to = strtotime($date_to);
				$date_new = date('Y-m-d H:i:s', $date_to);
				$query .= ' AND created_time <=  "' . $date_new . '" ';
			}
		}
		$list_orderf1 = $this->model->get_records($query, 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
		$html = ''; // Initialize HTML string

		if (!empty($list_orderf1)) {
			$total_list_order = array_reduce($list_orderf1, function ($carry, $item) {
				return $carry + $item->total_end;
			}, 0);

			$total_coin_list_order = array_reduce($list_orderf1, function ($carry, $item) {
				return $carry + $item->member_coin;
			}, 0);

			$html = implode('', array_map([$this, 'filter_time_orderf1_controller'], $list_orderf1));
		} else {
			$total_list_order = 0;
			$total_coin_list_order = 0;
		}



		echo json_encode(
			[
				'html' => $html,
				'total_coin' => $total_coin_list_order . ' VT-Coin',
				'total_vnd' => format_money($total_list_order, 'đ'),
			]
		);
		exit;
	}
	function export_file()
	{
		FSFactory::include_class('excel', 'excel');
		$model  = $this->model;
		$filename = 'member-export';
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
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
			foreach ($list as $item) {
				$key = isset($key) ? ($key + 1) : 2;
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->full_name);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->address);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->mobilephone);
			}
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
			$excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
			$output = $excel->write_files();

			$path_file =   PATH_ADMINISTRATOR . DS . str_replace('/', DS, $output['xls']);
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

	// Excel toàn bộ danh sách copper ra excel
	function export_excel()
	{
		require_once 'excel.php';
		$model  = $this->model;
		$start = FSInput::get('start');
		$start = (isset($start) && !empty($start)) ? $start : 1;
		$start = $start - 1;
		$end = FSInput::get('end');
		$end = (isset($end) && !empty($end)) ? $end : 10;
		$list = $model->get_member_info($start, $end);
		if (empty($list)) {
			echo 'error';
			exit;
		} else {
			$excel = V_Excel();
			$excel->set_params(array('out_put_xls' => 'export/excel/' . 'danh_sach_' . date('H-i_j-n-Y', time()) . '.xls', 'out_put_xlsx' => 'export/excel/' . 'danh_sach_' . date('j-n-Y', time()) . '.xlsx'));
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
			$excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
			$excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Tên truy cập');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Họ và tên');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Địa chỉ');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Email');
			$excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Điện thoại');
			foreach ($list as $item) {
				$key = isset($key) ? ($key + 1) : 2;
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->username);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->fullname);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->address);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->email);
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->mobilephone);
			}
			$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
			$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
			$excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1');
			$output = $excel->write_files();
			echo URL_ROOT . 'ione_admin/' . $output['xls'];
		}
	}
	function quality_export()
	{
		$html = '<form id="form1" name="form1" method="post" >';
		$html .= '<h1 style="color:#FF0000; text-align:center">Bạn hãy điền số thứ tự của bản ghi muốn export</h1>';
		$html .= '<p style="text-align:center"><label>Bắt đầu :</label>';
		$html .= '<input type="text" name="start_at" id="start_at" /><br />';
		$html .= '<label>Kết thúc: </label><input type="text" name="end_at" id="end_at" /><br><span>Nếu bạn không nhập số thứ tự thì hệ thống sẽ tự export từ 1 - 10</span></p>';
		$html .= '<p style="text-align:center">';
		$html .= '<label>';
		$html .= '<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
		$html .= '</label>';
		$html .= '</p>';
		$html .= '</form>';
		print_r($html);
	}
}
