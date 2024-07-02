<?php

class ProductsModelsSearch extends FSModels
{
    protected $tableProduct = 'fs_products';
    function __construct()
    {
        parent::__construct();
        $this->limit = FSInput::get('limit', 50);
    }

    public function setQueryBody($keyword, $price, $filter, $sort)
    {
        $sql = "FROM $this->tableProduct WHERE published = 1 AND `name` LIKE '%$keyword%' ";

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
        $sql = "SELECT id, alias, name, image, price, price_old, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time, data_extends
                $query
        ";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }

    public function getAllProducts()
    {
        global $db;
        $sql = "SELECT id, alias, name, image, price, price_old, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time, data_extends
                FROM $this->tableProduct
                WHERE published = 1 ORDER BY ordering ASC
        ";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }

    public function getAllTotal()
    {
        global $db;
        $query = "SELECT count(*) FROM $this->tableProduct WHERE published = 1"; 
        return $db->getResult($query, USE_MEMCACHE);
    }

    public function getAjaxSearch()
    {
        global $db;
        $where = ''; 
        $query = FSInput::get('query', '');
        $keyword = $query;
        $keyword = " name LIKE '%$keyword%'";
        $arr_tags = explode(' ', $query);
        $total_tags = count($arr_tags);
        if ($total_tags) {
            $j = 0;
            for ($i = 0; $i < $total_tags; $i++) {
                $item = trim($arr_tags [$i]);
                if ($item) {
                    $where .= "AND `name` LIKE '%" . $item . "%'";
                    $j++;
                }
            }
        }

        $sql = "SELECT id, alias, `name`, `image`, price, price_old, sold_out, is_gift, freeship, promotion_end_time, promotion_start_time, data_extends
                FROM fs_products 
                WHERE published = 1 $where OR `code` = '$query'
                ORDER BY CASE
                    WHEN $keyword THEN 1
                    ELSE 2
                END,
                show_in_home DESC, price ASC
                LIMIT 16
        ";

        $sql = $db->query($sql);
        $result = $db->getObjectList('', USE_MEMCACHE);
        return $result;
    }

    public function getAjaxSearchAdmin()
    {
        global $db;
        $where = ''; 
        $query = FSInput::get('query', '');
        $keyword = $query;
        $keyword = " name LIKE '%$keyword%'";
        $arr_tags = explode(' ', $query);
        $total_tags = count($arr_tags);
        if ($total_tags) {
            $j = 0;
            for ($i = 0; $i < $total_tags; $i++) {
                $item = trim($arr_tags [$i]);
                if ($item) {
                    $where .= "AND `name` LIKE '%" . $item . "%'";
                    $j++;
                }
            }
        }

        $sql = "SELECT id, alias, `name`, `image`, price, price_old, promotion_end_time, promotion_start_time, quantity, status_prd, code
                FROM fs_products 
                WHERE published = 1 $where OR `code` = '$query'
                ORDER BY CASE
                    WHEN $keyword THEN 1
                    ELSE 2
                END,
                quantity DESC, price ASC
        "; 

        $sql = $db->query($sql);
        $result = $db->getObjectList();
        return $result;
    }
}