<?php

class ProductsModelsCat extends FSModels
{
    protected $tableName = 'fs_products_categories';
    protected $tableProduct = 'fs_products';
    protected $tableBanner = 'fs_banners';
    protected $tablePriceFilter = 'fs_products_filter_price';

    public function __construct()
    {
        parent::__construct();
        $this->limit = FSInput::get('limit', 50);
    }

    public function getCat()
    {
        global $db;
        $code = FSInput::get('code',);
        $id = FSInput::get('id');

        $sql = "SELECT id, alias, name, level, parent_id, list_parents, tablename, seo_title, seo_keyword, seo_description, image, og_image, price
                FROM $this->tableName 
                WHERE published = 1 AND alias = '$code' AND id = $id
        ";
        return $db->getObject($sql, USE_MEMCACHE);
    }

    public function setQueryBody($id, $price, $filter, $sort)
    {
        $sql = "FROM $this->tableProduct WHERE published = 1 AND category_id_wrapper LIKE '%,$id,%' ";

        if ($price) {
            $price = explode(',', $price);
            $sql .= " AND ( ";
            foreach ($price as $i => $item) {
                $itemPrice = explode(':', $item);
                $sql .= $i ? " OR " : "";
                $sql .= " (price >= $itemPrice[0] AND price <= $itemPrice[1])  ";
            }
            $sql .= " ) ";
        }

        if ($filter) {
            $filter = explode(',', $filter);
            $sql .= " AND ( ";
            foreach ($filter as $i => $item) {
                $sql .= $i ? " OR " : "";
                $sql .= " data_extends LIKE '%@$item,%' ";
            }
            $sql .= " ) ";
        }

        $sql .= " ORDER BY ";

        switch ($sort) {
            case 0:
                $sql .= "ordering ASC";
                break;
            case 1:
                $sql .= "is_new DESC";
                break;
            case 2:
                $sql .= "price ASC";
                break;
            case 3:
                $sql .= "price DESC";
                break;
            default:
                $sql .= "ordering ASC";
                break;
        }

        return $sql;
    }

    public function getTotal($query_body)
    {
        global $db;
        $query = "SELECT count(*) ";
        $query .= $query_body;
        return $db->getResult($query, USE_MEMCACHE);
    }

    public function getProducts($query)
    {
        global $db;
        $sql = "SELECT id, alias, name, image, quantity, price, price_old, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time, data_extends
                $query
        ";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }

    public function getCategoriesWrap($str)
    {
        global $db;
        $sql = "SELECT id, name, alias FROM $this->tableName 
                WHERE published = 1 AND id IN (0" . $str . "0)
                ORDER BY level ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getCatList($id, $level, $parent_id)
    {
        global $db;

        if ($level) {
            $where = "parent_id = $parent_id";
        } else {
            $where = "parent_id = $id";
        }

        $sql = "SELECT id, name, alias FROM $this->tableName 
                WHERE published = 1 AND $where
                ORDER BY ordering ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getPriceFilter($id)
    {
        global $db;
        $sql = "SELECT id, name, min, max FROM $this->tablePriceFilter 
                WHERE published = 1 AND id IN (0" . $id . "0)
                ORDER BY ordering ASC
        ";
        return $db->getObjectList($sql, USE_MEMCACHE);
    }

    public function getFilter($table)
    {
        global $db;
        $query = "SELECT id, field_name, field_name_display, foreign_id FROM fs_products_tables WHERE table_name = '$table' AND is_filter = 1 ORDER BY ordering ASC, id DESC";
        return $db->getObjectList($query, USE_MEMCACHE);
    }

    function getFilterItem($id)
    {
        global $db;
        $query = "SELECT id, name, group_id FROM fs_extends_items WHERE published = 1 AND group_id IN ($id) ORDER BY ordering ASC, id DESC";
        return $db->getObjectList($query, USE_MEMCACHE);
    }
}
