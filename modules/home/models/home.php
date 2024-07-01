<?php

class HomeModelsHome extends FSModels
{
    public $tableProductCat;
    public $tableProduct;
    public $tableFlashSale;

    function __construct()
    {
        parent::__construct();

        $this->tableProductCat = 'fs_products_categories';
        $this->tableProduct = 'fs_products';
        $this->tableProductFlashSale = 'fs_flash_sale_detail';
        $this->tableFlashSale = 'fs_promotion_discount';
        $this->limit = FSInput::get('limit', 24);
    }

    public function setQuery()
    {
        $sql = "FROM $this->tableProduct WHERE published = 1 AND show_in_home = 1";
        return $sql;
    }

    public function getProductCategories()
    {
        global $db;
        $sql = "SELECT id, alias, name FROM $this->tableProductCat WHERE published = 1 AND level = 0 AND show_in_homepage = 1 ORDER BY ordering ASC";

        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function get_tiktok()
    {
        global $db;
        $sql = "SELECT id, tiktok FROM fs_tiktok WHERE published = 1 ORDER BY ordering ASC LIMIT 10";

        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getProducts($query)
    {
        global $db;
        $sql = "SELECT id, alias, name, image, price, price_old, quantity, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time $query ORDER BY ordering ASC";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }

    public function getTotal($query_body)
    {
        global $db;
        $query = "SELECT count(*) ";
        $query .= $query_body;
        return $db->getResult($query, USE_MEMCACHE);
    }

    public function getFlashProducts()
    {
        $now = date('Y-m-d H:i:s');
        global $db;
        $sql = "SELECT a.id, a.name, a.alias, a.image, a.quantity, a.price, b.product_id, b.promotion_id, b.quantity AS discount_quantity, b.quantity_user, b.sold AS discount_sold, b.price AS discount_price, b.percent, b.`type`, b.date_end, b.date_start 
                FROM $this->tableProduct AS a INNER JOIN fs_promotion_discount_detail AS b ON a.id = b.product_id 
                WHERE b.published = 1 AND a.published = 1 AND a.price > 0 AND DATE(b.date_end) >= DATE('$now') AND ((b.quantity > 0 AND b.sold < b.quantity) OR (b.quantity = 0))
                ORDER BY a.ordering DESC, a.id DESC 
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }
    public function  GetDateFlashSale()
    {
        global $db;
        $sql = "SELECT * FROM $this->tableFlashSale WHERE published = 1   ORDER BY ordering ASC limit 1";
        return $db->getObject($sql, USE_MEMCACHE);
    }
}
