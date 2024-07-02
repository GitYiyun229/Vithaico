<?php

class PromotionModelsHotsale extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 20;
        $this->view = 'hotsale';

        $this->arr_img_paths = array(array('resized', 258, 152, 'resized_not_crop'), array('small', 80, 80, 'resized_not_crop'));
        $this->table_name = 'fs_hotsale';

        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $this->img_folder = 'images/promotion/' . $cyear . '/' . $cmonth . '/' . $cday;
        $this->check_alias = 0;
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

        // estore
        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.category_id_wrapper like  "%,' . $filter . ',%" ';
            }
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

    /*
     * select in category of home
     */
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

    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $id = FSInput::get('id', 0, 'int');

//			//time promotion
//			$date_start = FSInput::get('date_start');
//			$published_hour_start = FSInput::get('published_hour_start',date('H:i'));
//			$date_end = FSInput::get('date_end');
//			$published_hour_end = FSInput::get('published_hour_end',date('H:i'));

        $arr_promotion_products = FSInput::get('promotion_products', array(), 'array');
        if (count($arr_promotion_products)) {
            $str_values = implode(',', $arr_promotion_products);
            $row['promotion_products'] = count($arr_promotion_products) ? ',' . $str_values . ',' : '';
        }
        //lưu danh mục
        $multi_categories = FSInput::get('multi_categories', array(), 'array');
        $str_multi_categories = implode(',', $multi_categories);
        if ($str_multi_categories) {
            $str_multi_categories = ',' . $str_multi_categories . ',';
        }
        $row['multi_categories'] = $str_multi_categories;

        $discount = FSInput::get('discount');
        $row ['discount'] = $discount = $this->standart_money($discount, 0);
        $discount_unit = FSInput::get('discount_unit', 1, 'int');
//        $row ['bonus1'] = FSInput::get('bonus1');
//        $row ['bonus2'] = FSInput::get('bonus2');
//        $row ['from1'] = FSInput::get('from1');
//        $row ['from2'] = FSInput::get('from2');
        if ($discount_unit == 3) {
            $row ['price'] = $discount;
        }
//            switch ($discount_unit){
//                case '1':
//                    $row ['discount_unit'] = 'price';
//                case '2':
//                     $row ['discount_unit'] = 'percent';
//                case '3':
//                     $row ['discount_unit'] = 'outlet';
//
//            }


//        $row['price'] = $price = FSInput::get('price');
//        if ($discount_unit == 1) {
//            if ($discount > 100 || $discount < 0) {
//                $row['price_new'] = $price;
//                $row['price'] = $price;
//                $row['discount'] = 0;
//            } else {
//                $row['price_new'] = $price * (100 - $discount) / 100;
//            }
//        } else {
//            if ($discount > $price || $discount < 0) {
//                $row['price_new'] = $price;
//                $row['price'] = $price;
//                $row['discount'] = 0;
//            } else {
//                $row['price_new'] = $price - $discount;
//            }
//        }


//            $row['date_start']      =  date('Y-m-d H:i:s',convertDateTime(FSInput::get('date_start'), '00:00'));
//            $row['date_end'] = date('Y-m-d H:i:s', convertDateTime(FSInput::get('date_end'), '23:59'));
        $row['date_start'] = FSInput::get('date_start');
        $row['date_end'] = FSInput::get('date_end');
//var_dump($row);die;
        if (date('Y-m-d H:i:s') > $row['date_end']) {
            Errors::_('Thời gian khuyến mại đã quá hạn', 'alert');
        }
        if ($row['date_start'] > $row['date_end']) {
            Errors::_('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc', 'alert');
        }

        $id = parent::save($row, 1);
        if (!$id) {
            Errors::setError('Not save');
            return false;
        }
//			if($id){
//				$this -> save_promotion_products($id);
//			}
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

    function save_promotion_products($product_id)
    {
        if (!$product_id)
            return;
        global $db;
        $query = ' SELECT id,product_incenty_id,product_id 
							FROM fs_hotsale_products
							WHERE product_id =  ' . $product_id;
        $db->query($query);
        $list = $db->getObjectList();
        if (count($list)) {
            foreach ($list as $item) {
                $product_incenty_id = $item->product_incenty_id;
                $price_new = FSInput::get('price_new_' . $product_incenty_id);
                $price_new_begin = FSInput::get('price_new_' . $product_incenty_id . "_begin");
                if ($price_new != $price_new_begin) {
                    $sql = ' UPDATE  fs_hotsale_products SET ';
                    $sql .= ' `price_new` =  "' . $price_new . '"';
                    $sql .= ' WHERE product_id =    ' . $product_id . ' ';
                    $sql .= ' AND product_incenty_id = ' . $product_incenty_id . ' ';

                    $db->query($sql);
                    $db->affected_rows();
                }
                $inf_promotion = FSInput::get('inf_promotion_' . $product_incenty_id);
                $inf_promotion_begin = FSInput::get('inf_promotion_' . $product_incenty_id . "_begin");
                if ($inf_promotion != $inf_promotion_begin) {
                    $sql = ' UPDATE  fs_hotsale_products SET ';
                    $sql .= ' `inf_promotion` =  "' . $inf_promotion . '"';
                    $sql .= ' WHERE product_id =    ' . $product_id . ' ';
                    $sql .= ' AND product_incenty_id = ' . $product_incenty_id . ' ';

                    $db->query($sql);
                    $db->affected_rows();
                }
            }
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

    function get_promotion_products($product_id)
    {

        $query = " SELECT id,name,alias,image
						 FROM fs_products 
						 WHERE id in (0" . $product_id . "0)";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function remove_promotion_product()
    {

        $id = FSInput::get('id', 0, 'int');
        $promotion_product_id = FSInput::get('promotion_product_id', 0, 'int');
        if (!$id || !$promotion_product_id)
            return;

        $sql = " SELECT promotion_products 
				FROM fs_hotsale 
				WHERE id = $id
					";
        global $db;
        $db->query($sql);
        $rs = $db->getResult();
        if (!$rs)
            return;

        $arr = explode(',', $rs);
        if (!count($arr))
            return;
        $str = '';
        $i = 0;
        foreach ($arr as $item) {
            if ($item != $promotion_product_id) {
                if ($i > 0)
                    $str .= ',';
                $str .= $item;
                $i++;
            }
        }
        $row['promotion_products'] = $str;
        print_r($row);

        // remove from fs_products_incentives
        $this->remove_from_promotion_products($id, $promotion_product_id);
        return $this->_update($row, 'fs_hotsale', 'id = ' . $id . '');
    }

    function remove_from_promotion_products($id, $promotion_product_id)
    {
        $sql = " DELETE FROM fs_hotsale_products
						WHERE product_id = $id
							AND product_incenty_id = $promotion_product_id ";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
    }

    function update_product($id)
    {
        global $db;
        $rs = 0;
        $promotion_products = $this->get_records('product_id = ' . $id, 'fs_hotsale_products');
        $promotion = $this->get_record_by_id($id, 'fs_hotsale');
        if (count($promotion_products)) {
            foreach ($promotion_products as $item) {
                $product_incenty_id = $item->product_incenty_id;
                $product = $this->get_record_by_id($product_incenty_id, 'fs_products', 'tablename');

                $sql = ' UPDATE fs_products SET ';
                $sql .= ' `promotion_price` =  "' . $item->price_new . '",';
                $sql .= ' `date_start` =  "' . $promotion->date_start . '",';
                $sql .= ' `date_end` =  "' . $promotion->date_end . '",';
                $sql .= ' `promotion_title` =  "' . $promotion->title . '",';
                $sql .= ' `promotion_info` =  "' . $item->inf_promotion . '",';
                $sql .= ' `promotion_published` =  "' . $promotion->published . '"';
                $sql .= ' WHERE id =    ' . $product_incenty_id . ' ';
                $db->query($sql);
                $result = $db->affected_rows();
                if ($result) {
                    $rs++;
                }

                $sql_ext = ' UPDATE ' . $product->tablename . ' SET ';
                $sql_ext .= ' `promotion_price` =  "' . $item->price_new . '",';
                $sql_ext .= ' `date_start` =  "' . $promotion->date_start . '",';
                $sql_ext .= ' `date_end` =  "' . $promotion->date_end . '",';
                $sql_ext .= ' `promotion_title` =  "' . $promotion->title . '",';
                $sql_ext .= ' `promotion_info` =  "' . $item->inf_promotion . '",';
                $sql_ext .= ' `promotion_published` =  "' . $promotion->published . '"';
                $sql_ext .= ' WHERE record_id =    ' . $product_incenty_id . ' ';
                $db->query($sql_ext);
                $db->affected_rows();
            }
        }
        return $rs;
    }

    function ajax_get_products_related()
    {
        $news_id = FSInput::get('product_id', 0, 'int');
        $category_id = FSInput::get('category_id', 0, 'int');
        $keyword = FSInput::get('keyword');
        $where = ' WHERE published = 1 ';
        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
        }
        $where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";

        $query_body = ' FROM fs_products ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,category_id,name,category_name,image' . $query_body . $ordering . ' LIMIT 40 ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
}

?>