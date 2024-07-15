<?php

class ProductsModelsProduct extends FSModels
{
    protected $table = 'fs_products';
    protected $tableCategories = 'fs_products_categories';
    protected $tableImage = 'fs_products_images';
    protected $tableType = 'fs_products_sub';
    protected $tableRate = 'fs_products_comments';

    public function __construct()
    {
        parent::__construct();
        $this->limit = FSInput::get('limit', 12);
    }

    public function getData()
    {
        $id = FSInput::get('id', 0);
        $code = FSInput::get('code', '');
        global $db;
        $sql = "SELECT id, name, image, category_id, alias, code, quantity, summary, text_buy,coin, category_id_wrapper, tablename,category_name, price, price_discount, coin, price_old, seo_title, seo_keyword, seo_description, `description`, status_prd, promotion_id, promotion_end_time, promotion_start_time, subtitle, sold_out, trademark, sale_brief, products_same, nick_name, products_related, comments_total
                FROM $this->table
                WHERE published = 1 AND id = $id AND alias = '$code'
        ";

        return $db->getObject($sql, USE_MEMCACHE);
    }

    public function getDataCategories($id)
    {
        global $db;
        $sql = "SELECT id, name, alias
                FROM $this->tableCategories
                WHERE published = 1 AND id IN (0 " . $id . " 0)
                ORDER BY `level` ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataImage($id)
    {
        global $db;
        $sql = "SELECT id, title, image, sub_id, file_type
                FROM $this->tableImage
                WHERE record_id = $id
                ORDER BY ordering ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataType($id)
    {
        global $db;
        $sql = "SELECT id, name, code, price, price_old, product_id, quantity,price_discount
                FROM $this->tableType
                WHERE product_id = $id AND published = 1
                ORDER BY price ASC
        ";

        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    // public function getDataSame($id)
    // {
    //     global $db;
    //     $sql = "SELECT id, name, alias, nick_name, quantity
    //             FROM $this->table
    //             WHERE id IN (0" . $id . "0) AND published = 1
    //             ORDER BY price ASC
    //     ";
    //     return $db->getObjectList($sql, USE_MEMCACHE);
    // }
    public function getDataSame($id, $product_id)
    {
        global $db;
        $sql = "SELECT id, name, image, coin, quantity, alias, price, price_old, promotion_id, promotion_end_time, promotion_start_time, sold_out, is_gift, freeship
                FROM $this->table
                WHERE category_id_wrapper LIKE '%,$id,%' AND published = 1 AND id <> $product_id
                
        ";
        // print_r($sql);
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataRelated($id, $dataId)
    {
        global $db;
        $sql = "SELECT id, name, image, quantity, alias, price, price_old, promotion_id, promotion_end_time, promotion_start_time, sold_out, is_gift, freeship
                FROM $this->table
                WHERE published = 1 AND id IN (0" . $id . "0) AND id <> $dataId
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataExtend($table)
    {
        global $db;
        $sql = "SELECT field_name, field_name_display, field_type, foreign_id
                FROM fs_products_tables
                WHERE is_main = 1 AND table_name = '$table' ORDER BY ordering ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataExtendValue($table, $select, $id)
    {
        global $db;
        $sql = "SELECT $select
                FROM $table
                WHERE record_id = $id
        ";
        return $db->getObject($sql, USE_MEMCACHE);
    }

    public function getDataExtendSelect($id)
    {
        global $db;
        $sql = "SELECT id, name
                FROM fs_extends_items
                WHERE id IN ($id) AND published = 1
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataSell($id)
    {
        global $db;
        $sql = "SELECT id, name, image, alias, quantity, price, price_old, promotion_id, promotion_end_time, promotion_start_time, sold_out, is_gift, freeship
                FROM $this->table
                WHERE published = 1 AND is_sell = 1 AND id <> $id
                ORDER BY ordering ASC LIMIT 10
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getDataMore()
    {
        global $db;
        $sql = "SELECT id, name, image, alias, quantity, price, price_old, promotion_id, promotion_end_time, promotion_start_time, sold_out, is_gift, freeship
                FROM $this->table
                WHERE published = 1
                ORDER BY ordering ASC
        ";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }

    public function getDataRate($id)
    {
        global $db;
        $sql = "SELECT id, name, phone, email, comment, created_time, rating, user_id, parent_id, product_id, product_name, sub_id, sub_name
                FROM $this->tableRate
                WHERE published = 1 AND product_id = $id
                ORDER BY id DESC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }
}
