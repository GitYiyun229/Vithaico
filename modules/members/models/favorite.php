<?php

class MembersModelsFavorite extends FSModels
{
    public function __construct()
    {
        parent::__construct();
        $this->limit = FSInput::get('limit', 20);
    }

    public function getDataMore($productFavoriteId)
    {
        global $db;
        $sql = "SELECT id, name, image, alias, quantity, price, price_old, promotion_id, promotion_end_time, promotion_start_time, sold_out, is_gift, freeship
                FROM fs_products
                WHERE id IN ($productFavoriteId) AND published = 1
                ORDER BY ordering ASC
        ";
        $db->query_limit($sql, $this->limit, $this->page);
        return $db->getObjectList('', USE_MEMCACHE);
    }
}
