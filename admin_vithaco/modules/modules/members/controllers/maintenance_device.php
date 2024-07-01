<?php
	
	class MembersControllersMembers extends Controllers
	{
		function __construct()
		{
			$this->view = 'members' ; 
			parent::__construct(); 
		}
		
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;
			
			if(	isset($_POST['city'])){
				$_SESSION[$this -> prefix.'city']  =  $_POST['city'] ;
				$ss_city =  $_POST['city'] ;
			}
			if(	isset($_POST['published'])){
				$_SESSION[$this -> prefix.'published']  =  $_POST['published'] ;
				$ss_published = $_SESSION[$this -> prefix.'published'];
			}
		     
			$model  = $this -> model;
            //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
			//$cities = $model-> get_cities_name();
			$list = $model->getMembers();
			$arr_level = $model -> get_level();
			$pagination = $model->getPagination();
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
		function add()
		{
			$model = $this -> model;
            //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
			$maxOrdering = $model->getMaxOrdering();
			$arr_level = $model -> get_level();
			
			
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
		function edit()
		{
			$model  = $this -> model;
			$data = $model->getMemberById();
			if(!$data)
				die('Not found url');
            //$group = $model -> get_records('published = 1','fs_members_group','*','ordering DESC');
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}
        
        function view_title($data){
			$link = URL_ROOT.$data->username;
			return '<a target="_blink" href="' . $link . '" title="view font-end">'.$data -> username.'</a>';
		}
        
		function apply()
		{
			$model  = $this -> model;
			if(! $this -> check_save())
			{
				$link = "index.php?module=members";
				$msg = FSText::_("Sorry! You do not save");
				setRedirect($link,$msg,'error');
			}
			else
			{
				$id = $model->save();
				if($id)
				{
					// create folder
//	            	$model -> create_folder_upload($id);
	            	
					$link ="index.php?module=members&view=members&task=edit&id=$id";
					$msg = " You have successfully saved ";
					setRedirect($link,$msg);
				}
				else
				{
					$link = "index.php?module=members&view=members";
					$msg = FSText::_("Sorry! You can not change infomation");
					setRedirect($link,$msg,'error');
				}
			}
			
		}
		function save()
		{
			$model  = $this -> model;
			
			if(! $this -> check_save())
			{
				$link = "index.php?module=members&view=members";
				$msg = FSText::_("Sorry! You do not save");
				setRedirect($link,$msg,'error');
			}
			else
			{
				$id = $model->save();
				
				if($id)
				{
					$link = "index.php?module=members&view=members";
					$msg = " You have successfully saved ";
					setRedirect($link,$msg);
				}
				else
				{
					$link = "index.php?module=members&view=members";
					$msg = FSText::_("Sorry! You can not change infomation");
					setRedirect($link,$msg,'error');
				}
			}
			
		}
		
		function check_save()
		{
			$id = FSInput::get('cid');
			$model  = $this -> model;
			$edit_pass = FSInput::get('edit_pass');
			
			if($edit_pass){
				// check pass
				$password = FSInput::get("password1");
				$re_password = FSInput::get("re-password1");
				if(!$id && !$password){
					Errors::setError("Asked to enter password");
					return false;
				}
				if($password)
				{
					if($password != $re_password)
					{
						Errors::setError("Password not match Re-password");
						return false;
					}
				}
			}
			// edit
			return true;
		}
	
		// Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}	
		function export_file(){
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'member-export';
			$list = $model->get_member_info();
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = FSExcel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.$filename.'.xls','out_put_xlsx'=>'export/excel/'.$filename.'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'ffff00'),
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
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->full_name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				
				$path_file =   PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Cache-Control: private",false);			
				header("Content-type: application/force-download");			
				header("Content-Disposition: attachment; filename=\"".$filename.'.xls'."\";" );			
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: ".filesize($path_file));
				readfile($path_file);
			}
		}	
				
		// Excel toàn bộ danh sách copper ra excel
		function export_excel(){
			require_once 'excel.php';
			$model  = $this -> model;
			$start = FSInput::get('start');
			$start=(isset($start) && !empty($start))?$start:1;
			$start=$start-1;
			$end = FSInput::get('end');
			$end=(isset($end) && !empty($end))?$end:10;
			$list = $model->get_member_info($start,$end);
			if(empty($list)){
				echo 'error';exit;
			}else {
				$excel = V_Excel();
				$excel->set_params(array('out_put_xls'=>'export/excel/'.'danh_sach_'.date('H-i_j-n-Y',time()).'.xls','out_put_xlsx'=>'export/excel/'.'danh_sach_'.date('j-n-Y',time()).'.xlsx'));
				$style_header = array(
					'fill' => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb'=>'ffff00'),
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
				foreach ($list as $item){
					$key = isset($key)?($key+1):2;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $item->username);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->fullname);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->address);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->email);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->mobilephone);
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				echo URL_ROOT.'ione_admin/'.$output['xls'];
			}
		}	
		function quality_export(){
			$html='<form id="form1" name="form1" method="post" >';
			$html.='<h1 style="color:#FF0000; text-align:center">Bạn hãy điền số thứ tự của bản ghi muốn export</h1>';
			$html.='<p style="text-align:center"><label>Bắt đầu :</label>';
			$html.='<input type="text" name="start_at" id="start_at" /><br />';
			$html.='<label>Kết thúc: </label><input type="text" name="end_at" id="end_at" /><br><span>Nếu bạn không nhập số thứ tự thì hệ thống sẽ tự export từ 1 - 10</span></p>';
			$html.='<p style="text-align:center">';
			$html.='<label>';
			$html.='<input onclick="javascript:configClickExport();" type="submit" name="submit_quality" id="submit_quality" value="Ok" />';
			$html.='</label>';
			$html.='</p>';
			$html.='</form>';
			print_r($html);		
		}
	}
?>