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
			$list_order = $this->model->get_records("user_id = $data->id", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
			$data->total_list_order = count($list_order);
			// số lượng đơn hàng thành viên f1 mua
			$list_order_f1 = $this->model->get_records("user_id IN ( $data->orderIdF1) ", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
			$data->total_list_orderf1 = count($list_order_f1);
			// số lượng coin nhận
			$list_coin = $this->model->get_records("user_id = ( $data->id) ", 'fs_coin_log', 'after_coin,total_coin,before_coin,after_coin,percent,percent_add,order_id', 'id DESC');
			if (!empty($list_coin)) {
				$total_coin = array_map(function ($item) {
					return $item->after_coin;
				}, $list_coin);
				$total_coin += $total_coin;
			}
			$data->total_coin_member = $total_coin[0] ? $total_coin[0] : '0';
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
		// print_r($data);
		if (!$data)
			die('Not found url');
		// tổng số lượng đã giới thiệu
		$list_f1 = $this->model->get_records("ref_by = $data->ref_code", 'fs_members_register_log', '*', 'id DESC');
		if (!empty($list_f1)) {
			$orderIdF1 = array_map(function ($item) {
				return $item->user_id;
			}, $list_f1);

			$orderIdF1 = implode(',', $orderIdF1);
		}
		// số lượng đơn hàng thành viên mua
		$list_order = $this->model->get_records("user_id = $data->id", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
		// số lượng đơn hàng thành viên f1 mua
		$list_order_f1 = $this->model->get_records("user_id IN ( $orderIdF1) ", 'fs_order', 'id, user_id, created_time, member_coin,products_count,created_time,total_before, ship_price, member_discount_price, code_discount_price, total_end, status', 'id DESC');
		// số lượng coin nhận
		$list_coin = $this->model->get_records("user_id = ( $data->id) ", 'fs_coin_log', 'after_coin,total_coin,before_coin,after_coin,percent,percent_add,order_id', 'id DESC');
		if (!empty($list_coin)) {
			$total_coin = array_map(function ($item) {
				return $item->after_coin;
			}, $list_coin);

			$total_coin += $total_coin;
		}
		$data_f0 = $this->model->get_record("ref_code = $data->ref_by", 'fs_members', '*', 'id DESC');
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
