<?php

class ProductsModelsWarranty extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 20;
        $this->view = 'warranty';
        $this->table_name = 'fs_warranty';
        $this->check_alias = 0;
        $this->img_folder = 'images/' . $this->view;

        $this->arr_img_paths = array(array('resized', 104, 128, 'resize_image'));

        parent::__construct();
    }

    function save($row = array(), $use_mysql_real_escape_string = 0)
    {

//        $price = FSInput::get('price');
//            echo $price;
//        $row ['price'] = $price = $this->standart_money($price, 0);
//lưu danh mục
        $multi_categories = FSInput::get('categories', array(), 'array');
        $str_multi_categories = implode(',', $multi_categories);
        if ($str_multi_categories) {
            $str_multi_categories = ',' . $str_multi_categories . ',';
        }
        $row['categories'] = $str_multi_categories;
        //lưu sản phẩm
        $arr_products_main = FSInput::get('products', array(), 'array');
        if (count($arr_products_main)) {
            $str_products_main = implode(',', $arr_products_main);
            $row['products'] = ',' . $str_products_main . ',';
        } else {
            $row['products'] = '';
        }
        $id = parent::save($row, 1);

        if (!$id) {
            Errors::setError('Not save');
            return false;
        }
        if ($id) {
            $rs = $this->save_edit($id);
        }
        return $id;
    }

    function save_edit($id)
    {
        global $db;

        $tablename = 'fs_warranty_price';

//        var_dump($tablename); die;

        // remove field
        if (!$this->remove_exist_field($tablename, $id)) {
            return false;
        }

        // save exist field
        if (!$this->save_exist_field($tablename,$id)) {
            return false;
        }

        // save new field
        if (!$this->save_new_field($tablename, $id)) {
            return false;
        }

        return true;
    }

    function remove_exist_field($tablename)
    {
        global $db;
        $field_remove = trim(FSInput::get('field_remove'));
        if ($field_remove) {
            $array_field_remove = explode(",", $field_remove);
            if (count($array_field_remove) > 0) {
                foreach ($array_field_remove as $item) {
                    $this->_remove('id = ' . $item, $tablename);
                }
            }
        }
        return true;
    }

    function save_exist_field($table_name, $id)
    {
        global $db;
        $warraty = $this->get_record('id =' . $id, 'fs_warranty');

        // EXIST FIELD
        $field_extend_exist_total = FSInput::get('field_extend_exist_total');

        $arr_sql_alter = array();
        $time = date("Y-m-d H:i:s");
//var_dump($api);
        for ($i = 0; $i < $field_extend_exist_total; $i++) {
            $sql_update = " UPDATE " . $table_name . "
							SET ";

            $id_exist = FSInput::get('id_exist_' . $i);

            $price_min_exist = FSInput::get('price_min_exist_' . $i);
            $price_min_exist = $this->standart_money($price_min_exist,0);
            $price_min_exist_begin = FSInput::get('price_min_exist_' . $i . '_begin');
            $price_min_exist_begin = $this->standart_money($price_min_exist_begin,0);

            $price_max_exist = FSInput::get('price_max_exist_' . $i);
            $price_max_exist = $this->standart_money($price_max_exist,0);
            $price_max_exist_begin = FSInput::get('price_max_exist_' . $i . '_begin');
            $price_max_exist_begin = $this->standart_money($price_max_exist_begin,0);

            //lưu giá
            $price_exist = FSInput::get('price_exist_' . $i);
            $price_exist = $this->standart_money($price_exist,0);
            $price_exist_begin = FSInput::get('price_exist_' . $i . '_begin');
            $price_exist_begin = $this->standart_money($price_exist_begin,0);


            $published_exist = $warraty->published;
//            $published_exist_begin = FSInput::get('is_published_exist_' . $i . '_begin');

            if (($price_exist != $price_exist_begin) || ($price_min_exist != $price_min_exist_begin)
                 || ($price_max_exist != $price_max_exist_begin)) {


                $sql_update .= " 	  
											price_min = '$price_min_exist', 
											price = '$price_exist', 
											price_max = '$price_max_exist', 
											published = '$published_exist',
											edited_time = '$time'
											";
                $sql_update .= " WHERE id = $id_exist ";

//                    print_r($sql_update);die();

                $db->query($sql_update);
                $rows = $db->affected_rows();

            }
//            }
        }
//die;
        return true;

        // END EXIST FIELD
    }

    function save_new_field($table_name, $id)
    {
        $warraty = $this->get_record('id =' . $id, 'fs_warranty');
        global $db;
        $time = date("Y-m-d H:i:s");
        // NEW FIELD
        $new_field_total = FSInput::get('new_field_total');
//        var_dump($new_field_total);die();
        if ($new_field_total) {
            $row = array();
            for ($i = 0; $i < $new_field_total; $i++) {
                //lưu record_id
                $row['record_id'] = $id;
                $row['warranty_name'] = $warraty->name;

                //lưu giá gói bảo hành
                $price = FSInput::get('new_price_' . $i);
                $row ['price'] = $price = $this->standart_money($price, 0);

                //lưu giá min
                $new_price_min = FSInput::get('new_price_min_' . $i);
                $row ['price_min'] = $this->standart_money($new_price_min, 0);

                //lưu giá max
                $new_price_max = FSInput::get('new_price_max_' . $i);
                $row ['price_max'] = $this->standart_money($new_price_max, 0);

                //lưu trạng thái
//                $new_published = FSInput::get('new_published_' . $i);
                $row['published'] = $warraty->published;

                $row['created_time'] = $time;
                $row['edited_time'] = $time;
//                var_dump($row);die;
                $id_sub = $this->_add($row, $table_name);

            }

            if (!$id_sub) {
                Errors::setError("Không thể thêm mới sản phẩm phụ !");
                return false;
            }

        }
        return true;
    }

    function standart_money($money, $method)
    {
        $money = str_replace(',', '', trim($money));
        $money = str_replace(' ', '', $money);
        $money = str_replace('.', '', $money);
//		$money = intval($money);
        $money = (double)($money);
        if (!$method)
            return $money;
        if ($method == 1) {
            $money = $money * 1000;
            return $money;
        }
        if ($method == 2) {
            $money = $money * 1000000;
            return $money;
        }
    }
    function get_all_products()
    {

        $query = " SELECT a.id,a.name
						FROM fs_products AS a
						WHERE a.published = 1
						ORDER BY a.ordering DESC,a.id DESC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_categories_tree()
    {
        global $db;
        $query = " SELECT a.*
					   FROM fs_products_categories AS a
					   ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
}

?>