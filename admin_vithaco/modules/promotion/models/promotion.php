<?php

class PromotionModelsPromotion extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 20;
        $this->view = 'promotion';

        $this->arr_img_paths = array(array('resized', 102, 152, 'resize_image_fix_height'));
        $this->table_name = 'fs_promotion';

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
        $row['date_start'] = FSInput::get('date_start');
        $row['date_end'] = FSInput::get('date_end');
        if (date('Y-m-d H:i:s') > $row['date_end']) {
            Errors::_('Thời gian khuyến mại đã quá hạn', 'alert');
        }
        if ($row['date_start'] > $row['date_end']) {
            Errors::_('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc', 'alert');
        }
        //lưu sp flash sale
        $row_flash = array();
        //lưu danh mục
        $multi_categories = FSInput::get('multi_categories', array(), 'array');
        $str_multi_categories = implode(',', $multi_categories);
        if ($str_multi_categories) {
            $str_multi_categories = ',' . $str_multi_categories . ',';
        }
        $row_flash['multi_categories'] = $str_multi_categories;
        $discount = FSInput::get('discount');
        $row_flash ['discount'] = $discount = $this->standart_money($discount, 0);
        $discount_unit = FSInput::get('discount_unit', 1, 'int');
        $row_flash['discount_unit'] = $discount_unit;
        $row_flash['is_shared'] = FSInput::get('is_shared');
        $row_flash['published'] = FSInput::get('published');
        $row_flash['date_start'] = FSInput::get('date_start');
        $row_flash['date_end'] = FSInput::get('date_end');
        $row_flash['record_name'] = FSInput::get('title');

        $arr_promotion_products = FSInput::get('promotion_products', array(), 'array');
        if (count($arr_promotion_products)) {
            $str_values = implode(',', $arr_promotion_products);
            $row_flash['promotion_products'] = count($arr_promotion_products) ? ',' . $str_values . ',' : '';
        }


        $id = parent::save($row, 1);
//        var_dump($id);die;
        if (!$id) {
            Errors::setError('Not save');
            return false;
        }
        if ($id) {
            $row_flash['record_id'] = $id;
            $id_flash_exit = $this->get_record('record_id = ' . $id, 'fs_flash_sale', 'id');
            if (@!$id_flash_exit) {
                $id_flash = $this->_add($row_flash, 'fs_flash_sale', 0);
            } else {
                $id_flash = $this->_update($row_flash, 'fs_flash_sale', ' record_id = "' . $id . '"', 1);
            }
            $id_flash_end = $this->get_record('record_id = ' . $id, 'fs_flash_sale', 'id');
            if (@$id_flash_end) {
                $this->save_flash_sale_items($id_flash_end->id, $row_flash);
            }

            $this->save_promotion_products($id, $row_flash['promotion_products']);

        }
        return $id;
    }

    function save_flash_sale_items($item_id, $row_flash)
    {
        if (!$item_id)
            return false;
        global $db;

        $products_related = trim($row_flash['promotion_products'], ',');
        $is_shared = $row_flash['is_shared'];
        // remove before update or inser
        $sql = "DELETE FROM fs_flash_sale_detail
					WHERE record_id = '" . $item_id . "'";
        $db->query($sql);
        $rows = $db->affected_rows();
        // insert data

        // Repeat estores

        $sql = " INSERT INTO fs_flash_sale_detail (`record_id`,`product_id`,`date_start`,`date_end`,`discount_unit`,`discount`,`total`,`ordered`,`published`)
					VALUES ";

        $array_insert = array();
      
        $arr_id = explode(',', $products_related);

        for ($i = 0; $i < count($arr_id); $i++) {
            $id = $arr_id[$i];
            if ($is_shared == 1) {
                $discount_unit = $row_flash['discount_unit'];
                $discount = $row_flash['discount'];
            } else {
                $discount_unit = FSInput::get('discount_unit_detail_' . $id);
                $discount = FSInput::get('discount_flash_' . $id);
            }
            $total = FSInput::get('total_flash_' . $id);
            $ordered = FSInput::get('ordered_flash_' . $id);
            $date_start =  $row_flash['date_start'];
            $date_end =  $row_flash['date_end'];
            $published = $row_flash['published'];
            if (!empty($discount_unit) or !empty($discount) or !empty($total)) {
                $array_insert[] = "('$item_id','$id','$date_start','$date_end','$discount_unit','$discount','$total','$ordered','$published') ";
            }
        }
        // Repeat products

        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            $db->query($sql);
            $rows = $db->affected_rows();
            return true;
        } else {
            return;
        }
    }

    function save_hot_sale_items($item_id, $row_flash)
    {
        if (!$item_id)
            return false;
        global $db;
        $products_related = trim($row_flash['promotion_products'], ',');
        $is_shared = $row_flash['is_shared'];
        // remove before update or inser
        $sql = "DELETE FROM fs_hot_sale_detail
					WHERE record_id = '" . $item_id . "'";
        $db->query($sql);
        $rows = $db->affected_rows();
        // insert data

        // Repeat estores

        $sql = " INSERT INTO fs_hot_sale_detail (`record_id`,`product_id`,`discount_unit`,`discount`,`total`,`ordered`)
					VALUES ";
        $array_insert = array();

        $arr_id = explode(',', $products_related);
        for ($i = 0; $i < count($arr_id); $i++) {
            $id = $arr_id[$i];
            if ($is_shared == 1) {
                $discount_unit = $row_flash['discount_unit_hot'];
                $discount = $row_flash['discount_hot'];
            } else {
                $discount_unit = FSInput::get('discount_unit_hot_' . $id);
                $discount = FSInput::get('discount_hot_' . $id);
            }
            $total = FSInput::get('total_hot_' . $id);
            $ordered = FSInput::get('ordered_hot_' . $id);

            if (!empty($discount_unit) or !empty($discount) or !empty($total)) {
                $array_insert[] = "('$item_id','$id','$discount_unit','$discount','$total','$ordered') ";
            }
        }
        // Repeat products

        if (count($array_insert)) {
            $sql_insert = implode(',', $array_insert);
            $sql .= $sql_insert;
            $db->query($sql);
            $rows = $db->affected_rows();
            return true;
        } else {
            return;
        }
    }
    public function remove()
    {

        $cids = FSInput::get('id', array(), 'array');
        foreach ($cids as $cid) {
            if ($cid != 1) {
                $cids[] = $cid;
            }
            $flash_id[] = $this->get_record('record_id = ' . $cid,
                'fs_flash_sale', 'id')->id;
        }
        $str_cids = implode(',', $cids);
        $sql = " DELETE FROM ".$this -> table_name." 
						WHERE id IN ( $str_cids ) " ;

        global $db;
        $rows = $db->affected_rows($sql);
        if($rows)
        {
            $str_flash = implode(',', $flash_id);
            $this->remove_flash($str_flash);
            $this->remove_flash_detail($str_flash);
            $this->update_products($cids);
            setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,$rows.' '.FSText :: _('record was deleted'));
        }
        else
        {
            setRedirect('index.php?module='.$this -> module.'&view='.$this -> view,FSText :: _('Not delete'),'error');
        }
       

    }

    public function remove_flash($id)
    {
        global $db;
        $sql = "DELETE FROM fs_flash_sale WHERE id IN ( $id )";

        $db->affected_rows($sql);
    }

    public function remove_flash_detail($id)
    {
        global $db;
        $sql = "DELETE FROM fs_flash_sale_detail WHERE record_id IN ( $id )";

        $db->affected_rows($sql);
    }

    public function update_products($cids)
    {
        foreach ($cids as $id) {
            $row_remove = array();
            $row_remove['promotion_id'] = '';
            $row_remove['promotion_name'] = '';
            $row_remove['promotion_start_time'] = '';
            $row_remove['promotion_end_time'] = '';
            $row_remove['promotion_published'] = 0;
            $this->_update($row_remove, 'fs_products', ' promotion_id=' . $id,
                1);
        }
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

    function save_promotion_products($id_promotion, $products_related)
    {
        $products_related = trim($products_related, ',');
        //xóa các thông số ở chương trình km trong bảng fs_products
        $row_remove = array();
        $row_remove['promotion_id'] = '';
        $row_remove['promotion_name'] = '';
        $row_remove['promotion_start_time'] = '';
        $row_remove['promotion_end_time'] = '';
        $row_remove['promotion_published'] = 0;
        $this->_update($row_remove, 'fs_products', ' promotion_id='.$id_promotion, 1);
        $promotion = $this->get_record('id =' . $id_promotion, 'fs_promotion', 'title,date_start,date_end,published');
        $arr_id = explode(',', $products_related);
        //lưu chương trình km vào bảng fs_products
        $row_prd = array();
        $row_prd['promotion_id'] = $id_promotion;
        $row_prd['promotion_name'] = $promotion->title;
        $row_prd['promotion_start_time'] = $promotion->date_start;
        $row_prd['promotion_end_time'] = $promotion->date_end;
        $row_prd['promotion_published'] = $promotion->published;
        for ($i = 0; $i < count($arr_id); $i++) {
            $id = $arr_id[$i];
            //lưu chương trình km vào bảng fs_products
            $this->_update($row_prd, 'fs_products', ' id = "' . $id . '"', 1);
        }
//        die;
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

    function get_flash($id, $table)
    {
        $query = " SELECT id,date_start, date_end, promotion_products, multi_categories, discount, discount_unit, is_shared, record_id 
						FROM $table
						WHERE record_id = $id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_sale_items($prod_id, $manual_id)
    {
        global $db;
        $query = " SELECT * from fs_flash_sale_detail WHERE record_id = $manual_id AND product_id = $prod_id";
        $sql = $db->query($query);
        echo $sql;
        $result = $db->getObject();
//        var_dump($result);die;
        return $result;
    }

    function get_hot_sale_items($prod_id, $manual_id)
    {
        global $db;
        $query = " SELECT * from fs_hot_sale_detail WHERE record_id = $manual_id AND product_id = $prod_id";
        $sql = $db->query($query);
        echo $sql;
        $result = $db->getObject();
//        var_dump($result);die;
        return $result;
    }

    function get_promotion_products($product_id)
    {

        $query = " SELECT id,name,alias,image, price, price_old
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
				FROM fs_promotion 
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
        return $this->_update($row, 'fs_promotion', 'id = ' . $id . '');
    }

    function remove_from_promotion_products($id, $promotion_product_id)
    {
        $sql = " DELETE FROM fs_promotion_products
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
        $promotion_products = $this->get_records('product_id = ' . $id, 'fs_promotion_products');
        $promotion = $this->get_record_by_id($id, 'fs_promotion');
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
        $query = ' SELECT id,category_id,name,category_name,image,promotion_id,promotion_name,promotion_start_time,promotion_end_time,promotion_published' . $query_body . $ordering . ' LIMIT 40 ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
}

?>