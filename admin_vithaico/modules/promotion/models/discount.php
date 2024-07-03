<?php

class PromotionModelsDiscount extends FSModels
{
    public $table_detail_name;

    function __construct()
    {
        parent::__construct();
        $this->limit = 20;
        $this->view = 'discount';

        $this->arr_img_paths = array(array('resized', 102, 152, 'resize_image_fix_height'));
        $this->table_name = 'fs_promotion_discount';
        $this->table_detail_name = 'fs_promotion_discount_detail';
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

        $query = " SELECT a.* FROM  $this->table_name  AS a WHERE 1=1 AND `type` = 0 $where $ordering ";
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

        if (!$id) {
            $row['created_time'] = date('Y-m-d H:i:s');
        }

        $row['updated_time'] = date('Y-m-d H:i:s');

        /**
         * Kiểm tra trùng sp các chương trình khác
         * Tìm các chương trình khác cùng thời điểm
         */
        $promotion = $this->getPromotionExist($row['date_start'], $row['date_end'], $id);
        $promotionId = array_map(function ($item) {
            return $item->id;
        }, $promotion);

        $promotionDetail = $this->get_records("published = 1 AND promotion_id IN (" . implode(',', $promotionId) . ")", 'fs_promotion_discount_detail');
        
        $productExist = array_map(function ($item) {
            return $item->product_id;
        }, $promotionDetail);

        
        $total = count(FSInput::get('_product_id', [], 'array'));
        $exist = 0;
        for ($i = 0; $i < $total; $i++) {
            $idProduct = FSInput::get("_product_id", [], 'array')[$i];
            if (in_array($idProduct, $productExist)) {
                $exist++;
                Errors::setError(FSInput::get("_product_name", [], 'array')[$i] . " đang nằm trong chương trình khác cùng thời gian!", 'error');
            }
        }
     
        if ($exist == $total) {
            return $id;
        }

        $all = FSInput::get('all');
        $priceAll = FSInput::get('priceAll');
        $percentAll = FSInput::get('percentAll');
        
        unset($row['all']);
        unset($row['priceAll']);
        unset($row['percentAll']);

        $row['type'] = 0;

        $id = parent::save($row, 1);

        if (!$id) {
            Errors::setError('Not save');
            return false;
        }

        if ($id) {
            $rowDetail = [];
            for ($i = 0; $i < $total; $i++) {
                $idProduct = FSInput::get("_product_id", [], 'array')[$i];
                if (!in_array($idProduct, $productExist)) {
                    $percent = $all ? $percentAll : FSInput::get("_percent", [], 'array')[$i];
                    $rowDetail[] = [
                        'promotion_id' => $id,
                        'product_id' => $idProduct,
                        'sold' => FSInput::get("_sold", [], 'array')[$i],
                        'quantity' => FSInput::get("_quantity", [], 'array')[$i],
                        'quantity_user' => FSInput::get("_quantity_user", [], 'array')[$i],
                        'price' =>  $this->standart_money($all ? $priceAll : FSInput::get("_price", [], 'array')[$i], 0),
                        'percent' => $percent ?: 0,
                        'date_start' => $row['date_start'],
                        'date_end' => $row['date_end'],
                        'type' => $row['type'],
                        'published' => FSInput::get('published'),
                    ];
                } else {
                    Errors::setError(FSInput::get("_product_name", [], 'array')[$i] . " đang nằm trong chương trình khác cùng thời gian!", 'error');
                }
            }

            $this->_remove("promotion_id = $id", $this->table_detail_name);
            $this->_add_multi($rowDetail, $this->table_detail_name);
        }

        return $id;
    }

    public function getDetail($id)
    {
        global $db;
        $sql = "SELECT a.*, b.name, b.image, b.price AS origin_price, b.quantity AS product_quantity, b.code, b.status_prd
                FROM $this->table_detail_name AS a 
                INNER JOIN fs_products as b ON a.product_id = b.id 
                WHERE a.promotion_id = $id ORDER BY a.id ASC";
        $db->query($sql);
        return $db->getObjectList();
    }

    public function getPromotionExist($start, $end, $promotionId = 0)
    {
        $now = date('Y-m-d H:i:s');
        global $db;
        // $sql = "SELECT id
        //         FROM $this->table_name 
        //         WHERE (DATE('$start') >= DATE(date_start) AND DATE('$end') <= DATE(date_end)) AND DATE('$now') <= DATE(date_end) AND id != $promotionId"; 

        $sql = "SELECT id
        FROM $this->table_name 
        WHERE id != $promotionId AND published = 1 AND
        (
            DATE(date_start) BETWEEN '$start' AND '$end'
            OR DATE(date_end) BETWEEN '$start' AND '$end'
            OR ('$start' BETWEEN DATE(date_start) AND DATE(date_end) AND '$end' BETWEEN DATE(date_start) AND DATE(date_end))
        )"; 
        
        // echo $sql;die;
        $db->query($sql);
        return $db->getObjectList();
    }

    public function removeChild($ids)
    {
        return $this->_remove("promotion_id IN ($ids)", $this->table_detail_name);
    }

    public function standart_money($money, $method)
    {
        $money = str_replace(',', '', trim($money));
        $money = str_replace(' ', '', $money);
        $money = str_replace('.', '', $money);
        // $money = intval($money);
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

    public function published($value)
    {
        $ids = FSInput::get('id', [], 'array'); 
        if (count($ids)) {
            $str_ids = implode(',',$ids);
            if ($value == 1) {
                $record = $this->get_records("id iN ($str_ids)", $this->table_name);
                $recordId = array_map(function ($item) {
                    return $item->id;
                }, $record);
                $recordId = implode(',', $recordId);
                $recordDetail = $this->get_records("promotion_id IN($recordId)", $this->table_detail_name);
                foreach ($record as $item) {
                    $item->detail = [];
                    foreach ($recordDetail as $detail) {
                        if ($item->id == $detail->promotion_id) {
                            $item->detail[] = $detail;
                        }
                    }
                }

                $recordPublished = 0;

                foreach ($record as $item) {
                    if (date('Y-m-d H:i:s') > $item->date_end) {
                        Errors::setError("$item->title Thời gian khuyến mại đã quá hạn! Vui lòng chỉnh sửa trong chi tiết!", 'error');
                        continue;
                    }

                    if ($item->date_start > $item->date_end) {
                        Errors::setError("$item->title Thời gian bắt đầu phải nhỏ hơn thời gian kết thúc! Vui lòng chỉnh sửa trong chi tiết!", 'error');
                        continue;
                    }

                    $promotion = $this->getPromotionExist($item->date_start, $item->date_end, $item->id);
                    $promotionId = array_map(function ($item) {
                        return $item->id;
                    }, $promotion);
            
                    $promotionDetail = $this->get_records("published = 1 AND promotion_id IN (" . implode(',', $promotionId) . ")", 'fs_promotion_discount_detail');
                    
                    $productExist = array_map(function ($item) {
                        return $item->product_id;
                    }, $promotionDetail);

                    $exist = 0;

                    foreach ($item->detail as $detail) {
                        if (in_array($detail->product_id, $productExist)) {
                            $exist++; 
                        }
                    } 
                 
                    if ($exist) {
                        Errors::setError("$item->title có sản phẩm đang nằm trong chương trình khác cùng thời gian! Vui lòng chỉnh sửa trong chi tiết!", 'error');
                    } else {
                        $this->_update(['published' => $value], $this->table_detail_name, "promotion_id = $item->id");
                        $this->_update(['published' => $value], $this->table_name, "id = $item->id");
                        $recordPublished ++;
                    }
                }
                return $recordPublished;
            } else {
                $this->_update(['published' => $value], $this->table_detail_name, "promotion_id IN ($str_ids)");
            }
        }   

        return parent::published($value);
    }
}
