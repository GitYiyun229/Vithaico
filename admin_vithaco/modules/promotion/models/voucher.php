<?php

class PromotionModelsVoucher extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        parent::__construct();
        $this->limit = 20;
        $this->view = 'voucher';

        $this->arr_img_paths = array(array('resized', 102, 152, 'resize_image_fix_height'));
        $this->table_name = 'fs_promotion_voucher';
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

        $row['type'] = FSInput::get('type');

        if (!$row['type']) {
            Errors::_('Vui lòng chọn loại voucher', 'alert');
            return false;
        }

        if (!$id) {
            $row['created_time'] = date('Y-m-d H:i:s');
        }

        $row['updated_time'] = date('Y-m-d H:i:s');

        $row['min_amount'] = $this->standart_money(FSInput::get("min_amount"), 0);
        $row['price'] = $this->standart_money(FSInput::get("price"), 0);
        $row['percent'] = $row['price'] != 0 ? 0 : FSInput::get("percent", 0);

        $product = FSInput::get('product_id', [], 'array');
        $row['product_id'] = implode(',', $product);

        $member = FSInput::get('member_id', [], 'array');
        $row['member_id'] = implode(',', $member);

        $code = FSInput::get('code');

        if (!$id) {
            // if ($this->voucherCodeExistsInDatabase($code, $id)) {
            //     Errors::_('Mã Voucher đã tồn tại', 'alert');
            //     return false;
            // }

            $row['code'] = $code ?: $this->createUniqueVoucherCode();
        }

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

    public function generateVoucherCode($length)
    {
        // $voucherCode = uniqid('', true) . bin2hex(random_bytes($length));
        // return strtoupper(substr($voucherCode, 0, $length));
        return substr(str_shuffle(str_repeat($x = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789', ceil($length / strlen($x)))), 1, $length);
    }

    public function createUniqueVoucherCode($length = 8)
    {
        $voucherCode = $this->generateVoucherCode($length);

        // Kiểm tra xem mã voucher đã tồn tại chưa
        while ($this->voucherCodeExistsInDatabase($voucherCode)) {
            // Nếu mã voucher đã tồn tại, tạo lại mã mới
            $voucherCode = $this->generateVoucherCode($length);
        }

        return $voucherCode;
    }

    // Kiểm tra mã voucher đã tồn tại hay chưa trong cơ sở dữ liệu
    public function voucherCodeExistsInDatabase($voucherCode, $idEdit = 0)
    {
        $exist = $this->get_records("code = '$voucherCode' AND id != $idEdit", $this->table_name);

        $existingVouchers = array_map(function ($item) {
            return $item->code;
        }, $exist);
        // $existingVouchers = array('ABC123', 'XYZ789'); // Giả định danh sách mã voucher đã tồn tại

        return in_array($voucherCode, $existingVouchers);
    }
}
