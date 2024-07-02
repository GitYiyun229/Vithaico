<?php
	class ServiceControllersDiscount_code  extends Controllers
	{
		function __construct()
		{
			$this->view = 'discount_code' ;
			parent::__construct();
		}
        
		function display()
		{
			parent::display();
			$sort_field = $this -> sort_field;
			$sort_direct = $this -> sort_direct;

			$model  = $this -> model;
			$list = $model->get_data('');

			$pagination = $model->getPagination('');
            
            //$list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
		}
        
        function add()
		{
			$model = $this -> model;
			//$categories = $model->get_categories_tree();
			//$list_key = array();
			// data from fs_news_categories
			//$categories_home  = $model->get_categories_tree();
			$maxOrdering = $model->getMaxOrdering();
            $list_products = $model->get_records('published = 1','fs_products','id, name');
            $relate_categories = $model->get_records('published = 1','fs_products_categories','id, name');

            //$uploadConfig = base64_encode('add|'.session_id());
            //$list_key = $model->get_records(' new_id = "'.$uploadConfig.'"','fs_news_keyword');
            //$list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
		}

		function edit()
		{
			$ids = FSInput::get('id',array(),'array');
			$id = $ids[0];
			$model = $this -> model;
			$data = $model->get_record_by_id($id);
            $list_products = $model->get_records('published = 1','fs_products','id, name');
            $relate_categories = $model->get_records('published = 1','fs_products_categories','id, name');

            //$list_post = $model->get_records(' published = 1 ','fs_members_service','name,id,alias',' ordering ASC ');
            
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
        
        // Excel toàn bộ danh sách copper ra excel
		function export(){
			setRedirect('index.php?module='.$this -> module.'&view='.$this -> view.'&task=export_file&raw=1');
		}
        
        function export_file(){
  
            $array_status = array( 
                        1 => FSText::_('Chờ hiển thịt trực tuyến'),
                        2 => FSText::_('Đang hiển thị trực tuyến'),
                        3 => FSText::_('Đã hết hạn'),
                        4 => FSText::_('Đã hủy')
                    );  
            $date_to = '...';  
            $date_from = '...';  
            $text_status = '';
		    // from
			if(isset($_SESSION[$this -> prefix.'text0']))
			{
				$date_from = $_SESSION[$this -> prefix.'text0'];
                if($date_from){
					$date_from = strtotime($date_from);
					$date_from = date('d/m/Y',$date_from);
                    $date_from = ' từ ngày '.$date_from;
				}
			}
			
			// to
			if(isset($_SESSION[$this -> prefix.'text1']))
			{
				$date_to = $_SESSION[$this -> prefix.'text1'];
                if($date_to){
					$date_to = strtotime($date_to);
					$date_to = date('d/m/Y',$date_to);
                    $date_to = ' đến ngày '.$date_to;
				}
			} 
            
            
            $sub = 'MGG'.$date_from.$date_to;
            
            $array_status = array(
                        1=>FSText::_('Đăng tuyển'),
                        2=>FSText::_('QUẢNG CÁO THƯƠNG HIỆU'),
                        3=>FSText::_('TÌM THÔNG TIN THÍ SINH'),
                        4=>FSText::_('E-MARKETING'),
                        5=>FSText::_('Đăng tuyển Combo'),
                        //4=>FSText::_('Tin tuyển sinh hết hạn'),
            );
            
			FSFactory::include_class('excel','excel');
//			require_once 'excel.php';
			$model  = $this -> model;
			$filename = 'MGG-export';
			//$list = $model->get_records(' estore_id = 0 ','fs_members_employer','division_position,id,full_name,name_training,email,address,link_facebook',' created_time DESC ');
			$list = $model->get_data_for_export();
            $time = date('H:i:s d/m-Y');
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
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', $sub); 
				$excel->obj_php_excel->getActiveSheet()->setCellValue('A2', 'Ngày xuất báo cáo :'.$time);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A3', 'QTV đăng nhập: '.$_SESSION['ad_username']);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A4', 'STT');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('B4', 'ID');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('C4', 'Tên MGG');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('D4', 'Mã số');
				$excel->obj_php_excel->getActiveSheet()->setCellValue('E4', 'Số lượng phát hành');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F4', 'Số lượng còn lại');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G4', 'Kiểu giảm giá 1=>%,0 => giá trị');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H4', 'Giá trị giảm');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I4', 'Giá trị tối thiểu');   
                $excel->obj_php_excel->getActiveSheet()->setCellValue('J4', 'Giá trị tối đa');
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K4', 'Dịch vụ được áp dụng'); 
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L4', 'Thời gian phát hành'); 
                $excel->obj_php_excel->getActiveSheet()->setCellValue('M4', 'Thòi gian hết hạn'); 
                $excel->obj_php_excel->getActiveSheet()->setCellValue('N4', 'Kích hoạt'); 
                $i = 1;
                $time_ = date('Y-m-d H:i:s');
				foreach ($list as $item){
				    
					$key = isset($key)?($key+1):5;
					$excel->obj_php_excel->getActiveSheet()->setCellValue('A'.$key, $i);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, $item->title);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('C'.$key, $item->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.$key, $item->name);
					$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.$key, $item->count);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('F'.$key, $item->count);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('G'.$key, $item->type);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('H'.$key, $item->val);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('I'.$key, $item->price);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('J'.$key, '');
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('K'.$key, $array_status[$item->type_service]);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('L'.$key, $item->created_time);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('M'.$key, $item->date_end);
                    $excel->obj_php_excel->getActiveSheet()->setCellValue('N'.$key, $item->published);
                    $i++;
				}
				$excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray( $style_header );
				$excel->obj_php_excel->getActiveSheet()->duplicateStyle( $excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:E1' );
				$output = $excel->write_files();
				
				$path_file = PATH_ADMINISTRATOR.DS.str_replace('/',DS, $output['xls']);
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


	}

?>
