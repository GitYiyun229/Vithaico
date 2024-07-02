<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
class ProductsControllersProducts extends Controllers
{
    function __construct()
    {
        $limit = FSInput::get('limit', 20, 'int');
        $this->limit = $limit;
        $this->view = 'products';
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
//			$list = $model->get_data();
        $categories = $model->get_categories_tree();
//			$categories = $model->get_product_categories_tree_by_permission();

        $str_cat_id = '';
        foreach ($categories as $item) {
            $str_cat_id .= ',' . $item->id;
        }
        $str_cat_id .= ',';

        $list = $model->get_data($str_cat_id);
        // print_r($list);die;

        $type = $model->get_type();
        
        $pagination = $model->getPagination($str_cat_id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function view_name($data)
    {
        $link = FSRoute::_('index.php?module=products&view=product&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias);
        return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">' . $data->name . '</a>';
    }

    function save_color()
    {
        $name = $_POST['name_color'];
        $record_id = $_POST['record_id'];
        $code = $_POST['code_color'];
        $price_co = $_POST['price'];
        $code = str_replace('#', '', $code);
        $stock = FSInput::get('stock');
        $store = FSInput::get('store', array(), 'array');
        if (!empty($store)) {
            $store = implode($store, ',');
            $store = ',' . $store . ',';
        }
        if (!$name) {
            echo 'Bạn chưa nhập tên màu';
            return;
        }

        $fsstring = FSFactory::getClass('FSString', '', '../');
        $row_color = array();
        $row_color['name'] = $name;
        $row_color['alias'] = $fsstring->stringStandart($name);
        $row_color['code'] = $code;
        $row_color['published'] = 1;
        $row_color['created_time'] = date('Y-m-d H:m:s');
        $result = $this->model->_add($row_color, 'fs_products_colors');

        $row2 = array();
        $row2 ['record_id'] = $record_id;
        $row2 ['color_id'] = $result;
        $row2 ['color_code'] = $code;
        $row2 ['color_name'] = $name;
        $row2['price'] = $price_co;
        $row2['is_stock'] = $stock ? 1 : 0;
        $row2['store'] = $store;
        $row2['alias'] = $row_color['alias'];
        $row2['cat_id'] = $this->model->get_record('id = ' . $record_id, 'fs_products')->category_id;
        if (!empty($_FILES['file'])) {
            if (0 < @$_FILES['file']['error']) {
                echo 'Error: ' . @$_FILES['file']['error'] . '<br>';
            } else {
                $field_width = isset($this->field_width) ? $this->field_width : '';
                $arr_img_paths_other = array(array('large', 465, 440, 'resize_image'), array('tiny', 47, 35, 'resize_image'), array('small', 180, 180, 'resize_image'));
                $image = @$_FILES['file']['name'];
                if ($image) {
                    $image = $this->model->upload_image('file', '_' . time(), 2000000, $arr_img_paths = array(), 'images/colors');
                    $row2['image'] = $image;
                    if (!isset($row['image']) && $field_width) {
                        // tính chiều rộng để thêm vào admin
                        list($root_width, $root_height) = getimagesize(URL_ROOT . $image);
                        $arr_img_paths = $arr_img_paths_other;
                        $get_height = $arr_img_paths[0][2];
                        $new_width = ceil($root_width * $get_height / $root_height);
                        $row2[$field_width] = $new_width;
                    }
                }
            }
            $rs = $this->model->_add($row2, 'fs_products_price_colors');
        } else {
            $rs = $this->model->_add($row2, 'fs_products_price_colors');
        }
        $res = array(
            'message' => 'Đã lưu màu mới',
            'input' => '<input class="select-checkbox" type="checkbox" value="' . $result . '" name="other_color[]" id="other_color' . $result . '" disabled="disabled">',
            'id' => $result
        );
        echo json_encode($res);
    }

    function save_sizes()
    {
        $name = $_POST['name_size'];
        $category_id = $_POST['category_id'];
        $record_id = $_POST['record_id'];
        if (!$name) {
            echo 'Bạn chưa nhập kích thước';
            return;
        }
        $fsstring = FSFactory::getClass('FSString', '', '../');
        $row_size = array();
        $row_size['name'] = $name;
        $row_size['alias'] = $fsstring->stringStandart($name);
        $row_size['published'] = 1;
        $row_size['created_time'] = date('Y-m-d H:m:s');
        $row_size['category_id'] = $category_id;
        $result = $this->model->_add($row_size, 'fs_products_sizes');

        $row = array();
        $row ['record_id'] = $record_id;
        $row ['size_id'] = $result;
        $row ['name'] = $name;

        if (!empty($_FILES['file'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error: ' . $_FILES['file']['error'] . '<br>';
            } else {
                $field_width = isset($this->field_width) ? $this->field_width : '';
                $arr_img_paths_other = array(array('large', 465, 440, 'resize_image'), array('tiny', 47, 35, 'resize_image'), array('small', 180, 180, 'resize_image'));
                $image = $_FILES['file']['name'];
                if ($image) {
                    $image = $this->model->upload_image('file', '_' . time(), 2000000, $arr_img_paths = array(), 'images/sizes');
                    $row['image'] = $image;
                    if (!isset($row['image']) && $field_width) {
                        // tính chiều rộng để thêm vào admin
                        list($root_width, $root_height) = getimagesize(URL_ROOT . $image);
                        $arr_img_paths = $arr_img_paths_other;
                        $get_height = $arr_img_paths[0][2];
                        $new_width = ceil($root_width * $get_height / $root_height);
                        $row[$field_width] = $new_width;
                    }
                }
            }
            $rs = $this->model->_add($row, 'fs_products_price_sizes');
        }
        echo 'Đã lưu kích thước mới';

    }

    function remove_old_image($sts_ids, $field = 'image', $table_name = '')
    {
        if (!$sts_ids)
            return;
        $sql = " SELECT " . $field . "
                    FROM " . $table_name . "
					WHERE  id IN (" . $sts_ids . ") ";
        $array = ["id" => $sts_ids];
        global $db;
        $builder = $db->table($table_name);
        $builder->where($array);
        $query = $builder->get();
        $list = $query->getResult();
        foreach ($list as $item) {
            $image = $item->$field;
            if (!empty($image)) {
                $image = PATH_BASE . str_replace('/', DS, $image);
                if (!@unlink($image)) {
                    Errors::_('Không thể xóa ảnh' . $image);
                }
            }
        }
        return true;
    }

    function add()
    {
        $model = $this->model;
        $cid = FSInput::get('cid');
        $list_products = $model->get_records('published = 1','fs_products','id, name');
        if ($cid) {
            $category = $model->get_record_by_id($cid, 'fs_products_categories');
//            $list_trade = explode(',', $category->list_trademark);
            $tablename = @$category->tablename;
            $relate_categories = $model->getRelatedCategories(@$category->tablename);
            $manufactories = $model->getManufactories(@$category->tablename);

//            for ($i = 1; $i < count($list_trade) - 1; $i++) {
//                $list_producer[$i] = $model->get_record_by_id($list_trade[$i], 'fs_products_thuong_hieu');
//            }
//                $list_producer = $model->get_records('published = 1','fs_products_thuong_hieu');

            // types
            $types = $model->get_records('published = 1', 'fs_products_types');
            $store_categories = $model->get_store();

            // extend field
            $extend_fields = $model->getExtendFields($tablename);
            $data_foreign = $model->get_data_foreign($extend_fields);

            // $extend_fields_new = $model->getExtendFieldsNew($cid);
            $extend_fields_new = $model->getExtendFieldsNew2($tablename);

            $maxOrdering = $model->getMaxOrdering();

            // all categories
            $categories = $model->get_categories_tree();

            // news related
            $news_categories = $model->get_news_categories_tree();

            $cities = $model->get_records('published = 1', 'fs_cities', 'id,name,alias', ' ordering ASC ');
            $district = array();
            /*
             * Lấy tham số cấu hình module
             */
            $module_params = $model->module_params;
            FSFactory::include_class('parameters');
            $current_parameters = new Parameters($module_params);
            $use_manufactory = $current_parameters->getParams('use_manufactory');
            $use_model = $current_parameters->getParams('use_model');

            if ($use_manufactory) {
                $manufactories = $model->getManufactories($tablename);
                if ($use_model)
                    $product_models = $model->get_product_models($manufactories[0]->id);
            }
            $uploadConfig = base64_encode('add|' . session_id());
            $sizes = $model->get_records('category_id = ' . $cid . ' and published = 1', 'fs_products_sizes');
            $tre = $model->get_records('published = 1', 'fs_products_tre_em');
            $thanh_nien = $model->get_records('published = 1', 'fs_products_thanh_nien');
            $nam = $model->get_records('published = 1', 'fs_products_nam');
            $nu = $model->get_records('published = 1', 'fs_products_nu');
            $ngay_le = $model->get_records('published = 1', 'fs_products_ngay_le');
            $su_kien = $model->get_records('published = 1', 'fs_products_su_kien');
            include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
        } else {
            $categories = $model->get_categories_tree();
            include 'modules/' . $this->module . '/views/' . $this->view . '/select_categories.php';
        }
    }

    function add1()
    {
        $model = $this->model;
        $cid = FSInput::get('cid');

        $category = $model->get_record_by_id($cid, 'fs_products_categories');
        $list_trade = explode(',', $category->list_trademark);
        $tablename = @$category->tablename;
        $relate_categories = $model->getRelatedCategories(@$category->tablename);
        $manufactories = $model->getManufactories(@$category->tablename);
        for ($i = 1; $i < count($list_trade) - 1; $i++) {
            $list_producer[$i] = $model->get_record_by_id($list_trade[$i], 'fs_products_thuong_hieu');
        }
//            $list_producer = $model->get_records('published = 1','fs_products_thuong_hieu');

        // types
        $types = $model->get_records('published = 1', 'fs_products_types');

        // extend field
        $extend_fields = $model->getExtendFields($category->tablename);
        $data_foreign = $model->get_data_foreign($extend_fields);
        $maxOrdering = $model->getMaxOrdering();

        // all categories
        $categories = $model->get_categories_tree();

        // news related
        $news_categories = $model->get_news_categories_tree();

        $cities = $model->get_records('published = 1', 'fs_cities', 'id,name,alias', ' ordering ASC ');
        $district = array();
        /*
         * Lấy tham số cấu hình module
         */
        $module_params = $model->module_params;
        FSFactory::include_class('parameters');
        $current_parameters = new Parameters($module_params);
        $use_manufactory = $current_parameters->getParams('use_manufactory');
        $use_model = $current_parameters->getParams('use_model');

        if ($use_manufactory) {
            $manufactories = $model->getManufactories($tablename);
            if ($use_model)
                $product_models = $model->get_product_models($manufactories[0]->id);
        }
        $uploadConfig = base64_encode('add|' . session_id());
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
//			}
//			else{
//				$categories = $model->get_categories_tree();
//				include 'modules/'.$this->module.'/views/'.$this -> view.'/select_categories.php';
//			}
    }


    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $data = $model->get_record_by_id($id);

        $category = $model->get_record_by_id($data->category_id, 'fs_products_categories');
//        $list_trade = explode(',', $category->list_trademark);
        $tablename = $category->tablename;
//        for ($i = 1; $i < count($list_trade) - 1; $i++) {
//            $list_producer[$i] = $model->get_record_by_id($list_trade[$i], 'fs_products_thuong_hieu');
//        }
        $products = $model->get_records('product_id ='.$id,'fs_products_sub');

        $manufactories = $model->getManufactories(@$category->tablename);
        // $list_producer = $model->get_records('published = 1', 'fs_products_thuong_hieu');

        $origin = $model->get_records('published = 1', 'fs_products_origin');
        // extend field
        $extend_fields = $model->getExtendFields($tablename);
        // print_r($extend_fields);

        $relate_categories = $model->getRelatedCategories();
        $store_categories = $model->get_store();

        // $extend_fields_new = $this->getExtendFieldsNew($data->category_id);
        $extend_fields_new = $this->getExtendFieldsNew2($tablename);
        
        // print_r($relate_categories);die;
//			echo "<pre>";
//			var_dump($extend_fields);
        // products related
        $categories = $model->get_categories_tree();
        $products_related = $model->get_products_related($data->products_related);
        $products_compatable = $model -> get_products_compatable($data -> products_compatable);
        $list_products = $model->get_records('published = 1','fs_products','id, name');

        // print_r($data);die;
        // news related
        $news_categories = $model->get_news_categories_tree();
        $news_related = $model->get_news_related($data->news_related);

        // city
        //$cities = $model -> get_records('published = 1','fs_cities','id,name,alias',' ordering ASC ');
        //$district = $model -> get_records(' city_id = '.$data->city_id,'fs_districts');
        // types
        $types = $model->get_records('published = 1', 'fs_products_types');



        $sizes = $model->get_records('category_id = ' . $data->category_id . ' and published = 1', 'fs_products_sizes', '*');
        foreach (@$sizes as $item) {
            $data_by_size = $model->get_data_by_size($item->id, $data->id);
            if (count(array($data_by_size))) {
                $array_data_by_size [$item->id] = $data_by_size;
            }
        }
        $tre = $model->get_records('published = 1', 'fs_products_tre_em');
        $thanh_nien = $model->get_records('published = 1', 'fs_products_thanh_nien');
        $nam = $model->get_records('published = 1', 'fs_products_nam');
        $nu = $model->get_records('published = 1', 'fs_products_nu');
        $ngay_le = $model->get_records('published = 1', 'fs_products_ngay_le');
        $su_kien = $model->get_records('published = 1', 'fs_products_su_kien');
//			 foreach (@$sizes as $item)
//			 {
//			 	$data_by_size = $model -> get_data_by_size($item->id,$data->id );
//			 	if(count($data_by_size)){
//			 		$array_data_by_size [$item->id] = $data_by_size;
//			 	}
//			 }

        $data_ext = $model->getProductExt($data->tablename, $data->id);
        if (!empty($extend_fields)) {
            $data_foreign = $model->get_data_foreign($extend_fields);
        }
        // together
        $products_incentives = $model->get_products_incentives($data->id);
        /*
         * Lấy tham số cấu hình module
         */
        $module_params = $model->module_params;
        FSFactory::include_class('parameters');
        $current_parameters = new Parameters($module_params);
        $use_manufactory = $current_parameters->getParams('use_manufactory');
        $use_model = $current_parameters->getParams('use_model');
        if ($use_manufactory) {
            $manufactories = $model->getManufactories($tablename);
        }

        // add hidden input tag : ext_id into detail form
        $this->params_form = array('ext_id' => @$data_ext->id);
        $uploadConfig = base64_encode('edit|' . $id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function ajax_get_product_district()
    {
        $model = $this->model;
        $cid = FSInput::get('cid');
        $rs = $model->ajax_get_product_district($cid);

        $json = '['; // start the json array element
        $json_names = array();
        foreach ($rs as $item) {
            $json_names[] = "{id: $item->id, name: '$item->name'}";
        }
        $json .= implode(',', $json_names);
        $json .= ']'; // end the json array element
        echo $json;
    }

    function ajax_get_product_models()
    {
        $model = $this->model;
        $cid = FSInput::get('cid');
        $rs = $model->get_product_models($cid);

        $json = '['; // start the json array element
        $json_names = array();
        foreach ($rs as $item) {
            $json_names[] = "{id: $item->id, name: '$item->name'}";
        }
        $json .= implode(',', $json_names);
        $json .= ']'; // end the json array element
        echo $json;
    }

    function export()
    {
        setRedirect('index.php?module=' . $this->module . '&view=' . $this->view . '&task=export_file&raw=1');
    }

    function export_file()
    {
        FSFactory::include_class('excel', 'excel');
//			require_once 'excel.php';
        $model = $this->model;
        $filename = 'product-export';
        $list = $model->get_data_for_export();
        $categories = $model->get_records('', 'fs_products_categories', 'id,code,alias,name,tablename', '', '', 'id');
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

            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('H')->setWidth(60);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('I')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('K')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
            $excel->obj_php_excel->getActiveSheet()->getColumnDimension('L')->setWidth(30);


            $excel->obj_php_excel->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('B')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('D')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('E')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('G')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('H')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('I')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('J')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
            $excel->obj_php_excel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


            $excel->obj_php_excel->getActiveSheet()->setCellValue('A1', 'Id');
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Category');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Name');
            //	$excel->obj_php_excel->getActiveSheet()->setCellValue('B1', 'Image');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('C1', 'Code');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('D1', 'Partnumber');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('E1', 'Summary');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('F1', 'Specs'); // overview
            $excel->obj_php_excel->getActiveSheet()->setCellValue('G1', 'Description'); // Specs
            $excel->obj_php_excel->getActiveSheet()->setCellValue('H1', 'Driver');// ProDescription
            $excel->obj_php_excel->getActiveSheet()->setCellValue('I1', 'Short_sumary'); // driverLink
            $excel->obj_php_excel->getActiveSheet()->setCellValue('J1', 'RetailPrice');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('K1', 'DealerPrice');
            $excel->obj_php_excel->getActiveSheet()->setCellValue('L1', 'Published');
            $i = 0;
            $total_money = 0;
            $total_quantity = 0;
            foreach ($list as $item) {
                $key = isset($key) ? ($key + 1) : 2;
                $excel->obj_php_excel->getActiveSheet()->setCellValue('A' . $key, $item->id);
//					$excel->obj_php_excel->getActiveSheet()->setCellValue('B'.$key, @$categories[$item->category_id]->code);		
                $excel->obj_php_excel->getActiveSheet()->setCellValue('B' . $key, $item->name);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('C' . $key, $item->code);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('D' . $key, $item->partnumber);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('E' . $key, $item->summary);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('F' . $key, $item->description);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('G' . $key, ''); // đang làm
                $excel->obj_php_excel->getActiveSheet()->setCellValue('H' . $key, $item->driver);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('I' . $key, $item->promotion_info);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('J' . $key, $item->price);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('K' . $key, $item->dealer_price);
                $excel->obj_php_excel->getActiveSheet()->setCellValue('L' . $key, $item->published);
                $excel->obj_php_excel->getActiveSheet()->getRowDimension($i + 2)->setRowHeight(20);
                $i++;
            }
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('D'.($i+2), 'Tổng');
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('E'.($i+2), $total_quantity);
//				$excel->obj_php_excel->getActiveSheet()->setCellValue('F'.($i+2), $total_money);

            $excel->obj_php_excel->getActiveSheet()->getRowDimension(1)->setRowHeight(20);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(12);
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getFont()->setName('Arial');
            $excel->obj_php_excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
            $excel->obj_php_excel->getActiveSheet()->duplicateStyle($excel->obj_php_excel->getActiveSheet()->getStyle('A1'), 'B1:L1');

//				$excel->obj_php_excel->getActiveSheet()->getStyle('A1')->getAlignment()->setIndent(1);// padding cell

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

    // remove products_together
    function remove_incentives()
    {
        $model = $this->model;
        if ($model->remove_incentives()) {
            echo '1';
            return;
        } else {
            echo '0';
            return;
        }
    }
    //phụ kiện mua kèm

    function ajax_get_products_compatable()
    {
        $model = $this->model;
        $data = $model->ajax_get_products_related();
        $html = $this->products_compatable_related($data);
        echo $html;
        return;
    }
    
    //sản phẩm liên quan

    function ajax_get_products_related()
    {
        $model = $this->model;
        $data = $model->ajax_get_products_related();
        $html = $this->products_genarate_related($data);
        echo $html;
        return;
    }

    function products_genarate_related($data)
    {
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<div class="products_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red products_related_item  products_related_item_' . $item->id . '" onclick="javascript: set_products_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->name . '<br/>';
                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            } else {
                $html .= '<div class="products_related_item  products_related_item_' . $item->id . '" onclick="javascript: set_products_related(' . $item->id . ')">';
                $html .= $item->name . '<br/>';
                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
    function products_compatable_related($data)
    {
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<div class="products_compatable">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')" style="display:none" >';
                $html .= $item->name . '<br/>';
                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            } else {
                $html .= '<div class="products_compatable_item  products_compatable_item_' . $item->id . '" onclick="javascript: set_products_compatable(' . $item->id . ')">';
                $html .= $item->name . '<br/>';
                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }

    /***********
     * NEWS RELATED
     ************/
    function ajax_get_news_related()
    {
        $model = $this->model;
        $data = $model->ajax_get_news_related();
        $html = $this->news_genarate_related($data);
        echo $html;
        return;
    }

    function news_genarate_related($data)
    {
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<div class="news_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->title;
                $html .= '</div>';
            } else {
                $html .= '<div class="news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')">';
                $html .= $item->title;
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
    /***********
     * end NEWS RELATED.
     ************/
    /***********
     * ADVICES RELATED
     ************/
    function ajax_get_advices_related()
    {
        $model = $this->model;
        $data = $model->ajax_get_advices_related();
        $html = $this->advices_genarate_related($data);
        echo $html;
        return;
    }

    function advices_genarate_related($data)
    {
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<div class="advices_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red advices_related_item  advices_related_item_' . $item->id . '" onclick="javascript: set_advices_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->title;
                $html .= '</div>';
            } else {
                $html .= '<div class="advices_related_item  advices_related_item_' . $item->id . '" onclick="javascript: set_advices_related(' . $item->id . ')">';
                $html .= $item->title;
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }

    /***********
     * end ADVICES RELATED.
     ************/


    function ajax_stt()
    {
        $model = $this->model;
        $type = FSInput::get('type');
        $name = FSInput::get('name');
        $id = FSInput::get('id');
        $rs = $model->change_ajax_stt($id, $type, $name);

        if ($type == 1) {
            $html = '<a title="Disable item" onclick=\' ajax_stt("' . $id . '","1","' . $name . '")\' href="javascript:void(0);"><img border="0" alt="Enabled status" src="templates/default/images/unpublished.png"></a>';
        } else
            $html = '<a title="Disable item" onclick=\' ajax_stt("' . $id . '","0","' . $name . '")\' href="javascript:void(0);"><img border="0" alt="Enabled status" src="templates/default/images/published.png"></a>';
        if ($rs)
            echo $rs;
    }

    function ajax_unstt()
    {
        $model = $this->model;
        $type = FSInput::get('type');
        $rs = $model->change_ajax_stt(0, $type);
        echo $html = '<a title="Disable item" onclick=\' ajax_unstt("' . FSInput::get('id') . '","unshow_in_home")\' href="javascript:void(0);"><img border="0" alt="Enabled status" src="templates/default/images/published.png"></a>';
        if ($rs)
            echo $html . $rs;
    }

    function is_new()
    {
        $this->is_check('is_new', 1, 'is_new');
    }

    function unis_new()
    {
        $this->unis_check('is_new', 0, 'un_new');
    }

    function is_hot()
    {
        $this->is_check('is_hot', 1, 'is_hot');
    }

    function unis_hot()
    {
        $this->unis_check('is_hot', 0, 'un_hot');
    }

    function is_sell()
    {
        $this->is_check('is_sell', 1, 'is_sell');
    }

    function unis_sell()
    {
        $this->unis_check('is_sell', 0, 'is_sell');
    }

    function is_sale()
    {
        $this->is_check('is_sale', 1, 'is_sale');
    }

    function unis_sale()
    {
        $this->unis_check('is_sale', 0, 'is_sale');
    }

    function show_in_home()
    {
        $this->is_check('show_in_home', 1, 'show_in_home');
    }

    function unshow_in_home()
    {
        $this->unis_check('show_in_home', 0, 'show_in_home');
    }

    function format_money($row)
    {
        if ($row)
            return format_money($row, 'VNĐ');
        else
            return $row;
    }



    function getExtendFieldsNew($category_id)
    {
        $extend = $this->model->getExtendFieldsNew($category_id);
        if ($extend)
            foreach ($extend as $key => $val) {
                $extend[$key]->select_option = array();
                if (($val->field_type == 'select' || $val->field_type == 'multi_select') && $val->field_table != '') {
                    $extend[$key]->select_option = $this->model->get_records('group_id=' . intval($val->field_table), 'fs_extends_items');
                }
            }
        return $extend;
    }

    function getExtendFieldsNew2($table_name)
    {
        $extend = $this->model->getExtendFieldsNew2($table_name);
        if ($extend)
            foreach ($extend as $key => $val) {
                $extend[$key]->select_option = array();
                if (($val->field_type == 'foreign_one' || $val->field_type == 'foreign_multi') && $val->foreign_id != '') {
                    $extend[$key]->select_option = $this->model->get_records('group_id=' . intval($val->foreign_id), 'fs_extends_items');
                }
            }
        return $extend;
    }

    function gs()
    {
        $this->is_check('gs', 1, 'gs');
    }

    function ungs()
    {
        $this->unis_check('gs', 0, 'gs');
    }
}