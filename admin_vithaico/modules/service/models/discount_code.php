<?php

class ServiceModelsDiscount_code extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 50;
        $this->view = 'discount_code';
        $this->table_name = 'fs_discount_code';
        $this->check_alias = 1;
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

        if (!$ordering)
            $ordering .= " ORDER BY ordering DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND ( a.name LIKE '%" . $keysearch . "%' )";
            }
        }
        $query = " SELECT a.*
						  FROM
						  " . $this->table_name . " AS a
						  	WHERE 1=1" .
            $where .
            $ordering . " ";

        return $query;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {

        // related projects
        $id = FSInput::get2('id', 0, 'int');
        $count_total_exits= FSInput::get2('count_total_exits', 0, 'int');
        $count_total= FSInput::get2('count_total', 0, 'int');
        if (!$id || $count_total_exits != $count_total) {
            $row['count'] = $count_total;
        }
        $price = FSInput::get('price');
        $row ['price'] = $price = $this->standart_money($price, 0);
        //lưu sp áp dụng
        $arr_prd_id = FSInput::get('products', array(), 'array');
        if (@$arr_prd_id && !empty($arr_prd_id)) {
            $str_prd_id = implode(',', $arr_prd_id);
            $row ['products'] = ',' . $str_prd_id . ',';
        }else{
            $row ['products'] = '';
        }

        //lưu danh mục
        $multi_categories = FSInput::get('multi_categories', array(), 'array');
        $str_multi_categories = implode(',', $multi_categories);
        if ($str_multi_categories) {
            $str_multi_categories = ',' . $str_multi_categories . ',';
            $row['multi_categories'] = $str_multi_categories;
        }else{
            $row['multi_categories'] = '';
        }
        $rs = parent::save($row);
        return $rs;
    }

    function get_data_for_export()
    {
        global $db;
        $query = $this->setQuery();
        if (!$query)
            return array();
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
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

}

?>
