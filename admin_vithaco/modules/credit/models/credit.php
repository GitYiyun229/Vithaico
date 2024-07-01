<?php

class CreditModelsCredit extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 20;
        $this->view = 'credit';
        $this->table_name = 'fs_credit';
//        $this->arr_img_paths = array(array('resized', 170, 170, 'resize_image_fix_height_webp'), array('small', 100, 100, 'resize_image_fix_height_webp'));
        $this->img_folder = 'images/credit';
        $this->field_img = 'image';
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
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";

        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.title LIKE '%" . $keysearch . "%' ";
            }
        }

        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
            $where .
            $ordering . " ";
        return $query;
    }


    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $id = FSInput::get('id', 0, 'int');

//            $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
//            if (!$user_id)
//                return false;
//            $user = $this->get_record_by_id($user_id, 'fs_users', 'username');
//
//            if ($id) {
//                $row['author_last'] = $user->username;
//                $row['author_last_id'] = $user_id;
//            } else {
//                $row['author'] = $user->username;
//                $row['author_id'] = $user_id;
//            }
//
//
        $price = FSInput::get('price');
//            echo $price;
        $row ['price'] = $price = $this->standart_money($price, 0);
        //hồ sơ
//            $str_profile = FSInput::get('profile', array(), 'array');
//            if (!empty($str_profile)) {
//                $str_profile = implode($str_profile, ',');
//                $str_profile = ',' . $str_profile . ',';
//            }
//        $row['profile']= $str_profile;

        $id = parent::save($row, 1);

        if (!$id) {
            Errors::setError('Not save');
            return false;
        } else {
            $list_credit = $this->get_records('credit_id =' . $id, 'fs_tenor');
            $rs = $this->save_edit($id, $list_credit);
        }

        session_regenerate_id();
        return $id;
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

    function save_edit($id, $list_credit)
    {
        global $db;

        $tablename = 'fs_tenor';

//        var_dump($tablename); die;

        // remove field
//            if (!$this->remove_exist_field($tablename, $id)) {
//                return false;
//            }
        if (isset($list_credit) && count($list_credit)) {
            // save exist field
            if (!$this->save_exist_field($tablename)) {
                return false;
            }
        } else {
            // save new field
            if (!$this->save_new_field($tablename, $id)) {
                return false;
            }
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

    function save_exist_field($table_name)
    {
        global $db;

        // EXIST FIELD
        $field_extend_exist_total = FSInput::get('new_field_total');

        $time = date("Y-m-d H:i:s");
        for ($i = 0; $i < $field_extend_exist_total; $i++) {
            $sql_update = " UPDATE " . $table_name . "
							SET ";

            $id_exist = FSInput::get('id_exist_' . $i);
            //lưu cửa hàng
//            $str_store = FSInput::get('store_exist_' . $i, array(), 'array');
//            if (!empty($str_store)) {
//                $str_store = implode($str_store, ',');
//                $str_store = ',' . $str_store . ',';
//            }
//            $store_exist = $str_store;
//            $store_exist_begin = FSInput::get('store_exist_' . $i . '_begin');

            //lưu kì hạn
            $month_id_exist = FSInput::get('month_id_exist_' . $i);
//                var_dump($month_id_exist);
            $month_id_exist_begin = FSInput::get('month_id_exist_' . $i . '_begin');
            $month = $this->get_month('id = ' . $month_id_exist, 'fs_month', 'name');
//var_dump($month);
            //lưu lãi phẳng
            $interest_rate_exist = FSInput::get('interest_rate_exist_' . $i);
            $interest_rate_exist_begin = FSInput::get('interest_rate_exist_' . $i . '_begin');

            //lưu phí bảo hiểm
            $insurrance_exist = FSInput::get('insurrance_exist_' . $i);
            $insurrance_exist_begin = FSInput::get('insurrance_exist_' . $i . '_begin');


            $published_exist = FSInput::get('is_published_exist_' . $i);
            $published_exist_begin = FSInput::get('is_published_exist_' . $i . '_begin');


            if (($month_id_exist != $month_id_exist_begin) || ($interest_rate_exist != $interest_rate_exist_begin)
                || ($published_exist != $published_exist_begin) || ($insurrance_exist != $insurrance_exist_begin)) {


                $sql_update .= " 	  
											month_id = '$month_id_exist', 
											month_name = '$month->name', 
											interest_rate = '$interest_rate_exist', 
											insurrance = '$insurrance_exist', 
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
//        echo ($table_name);
        global $db;
        $time = date("Y-m-d H:i:s");
        // NEW FIELD
        $new_field_total = FSInput::get('new_field_total');
        if ($new_field_total) {
            $row = array();
            for ($i = 0; $i < $new_field_total; $i++) {
                //lưu record_id
                $row['credit_id'] = $id;

                //lưu kì hạn
                $new_month_id = FSInput::get('new_month_id_' . $i);
                $month = $this->get_month('id = ' . $new_month_id, 'fs_month', 'name');
                $row['month_name'] = $month->name;
                $row['month_id'] = $new_month_id;


                //lưu lãi phẳng
                $interest_rate = FSInput::get('new_interest_rate_' . $i);
                $row ['interest_rate'] = $interest_rate;

                //lưu phí bảo hiểm
                $insurrance = FSInput::get('new_insurrance_' . $i);
                $row ['insurrance'] = $insurrance;


                $new_published = FSInput::get('new_published_' . $i, 0);
                $row['published'] = $new_published;

                $row['created_time'] = $time;
                $row['edited_time'] = $time;
                $id_sub = $this->_add($row, $table_name);

            }

            if (!$id_sub) {
                Errors::setError("Chưa lưu được kì hạn !");
                return false;
            }

        }
        return true;
    }

    function get_month($where = '', $table_name = '', $select = '*')
    {
        if (!$where)
            return;
        if (!$table_name)
            $table_name = $this->table_name;
        $query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE " . $where;
        echo $query;
        global $db;
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }
}

?>