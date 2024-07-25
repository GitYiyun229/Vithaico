<?php

class PromotionModelsGift extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        parent::__construct();
        $this->limit = 20;
        $this->view = 'gift';

        $this->arr_img_paths = array(array('resized', 102, 152, 'resize_image_fix_height'));
        $this->table_name = 'fs_promotion_gift';
        $this->table_category_name = 'fs_products_categories';
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

    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $id = FSInput::get('id', 0, 'int');
        $row['date_start'] = FSInput::get('date_start');
        $row['date_end'] = FSInput::get('date_end');

        if (date('Y-m-d H:i:s') > $row['date_end']) {
            Errors::_('Thời gian khuyến mại đã quá hạn', 'alert');
            return $id;
        }
        if ($row['date_start'] > $row['date_end']) {
            Errors::_('Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc', 'alert');
            return $id;
        }

        /**
         * Kiểm tra trùng sp các chương trình khác
         * Tìm các chương trình khác cùng thời điểm
         */
        $promotion = $this->get_exist_gift($row['date_start'], $row['date_end'], $id);
        $promotionId = array_map(function ($item) {
            return $item->product_id;
        }, $promotion);

        $productExist = explode(',', implode(',', $promotionId));

        
        $total = count(FSInput::get('product_id', [], 'array'));
        $exist = 0;
        for ($i = 0; $i < $total; $i++) {
            $idProduct = FSInput::get("product_id", [], 'array')[$i];
            if (in_array($idProduct, $productExist)) {
                $exist++;
                Errors::setError(FSInput::get("product_name", [], 'array')[$i] . " đang nằm trong chương trình khác cùng thời gian!", 'error');
            }
        }
     
        if ($exist == $total) {
            return $id;
        }

        if (!$id) {
            $row['created_time'] = date('Y-m-d H:i:s');
        }

        $row['updated_time'] = date('Y-m-d H:i:s');
        
        $product = FSInput::get('product_id', [], 'array');
        $row['product_id'] = implode(',', $product);

        $quantity = FSInput::get('quantity', [], 'array');
        $gift = FSInput::get('gift_id', [], 'array');

        $json = [];
        for ($i = 0; $i < count($quantity); $i++) {
            if ($gift[$i] && $quantity[$i]) {
                $json[] = [
                    "quantity" => $quantity[$i],
                    "gift" => $gift[$i],
                ];
            }
        }

        if (empty($json)) {
            Errors::_('Vui lòng nhập quà tặng!', 'error');
            return $id;
        }

        $row['gift'] = json_encode($json);

        $id = parent::save($row, 1);

        if (!$id) {
            Errors::setError('Not save');
            return false;
        }

        return $id;
    } 

    function standart_money($money, $method)
    {
        $money = str_replace(',', '', trim($money));
        $money = str_replace(' ', '', $money);
        $money = str_replace('.', '', $money);
        //		$money = intval($money);
        $money = (float)($money);
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

    public function get_exist_gift($date_start, $date_end, $id)
    {
        $now = date('Y-m-d H:i:s');
        global $db; 

        $sql = "SELECT id, product_id
        FROM $this->table_name 
        WHERE id != $id AND
        (
            DATE(date_start) BETWEEN '$date_start' AND '$date_end'
            OR DATE(date_end) BETWEEN '$date_start' AND '$date_end'
            OR ('$date_start' BETWEEN DATE(date_start) AND DATE(date_end) AND '$date_end' BETWEEN DATE(date_start) AND DATE(date_end))
        )"; 
        
        // echo $sql;die;
        $db->query($sql);
        return $db->getObjectList();
    }
}
