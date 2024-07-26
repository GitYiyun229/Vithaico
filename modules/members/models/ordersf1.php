<<<<<<< HEAD
<?php

class MembersModelsOrdersf1 extends FSModels
{
    function __construct()
    {
        parent::__construct();
        global $module_config;
        $this->limit = 10;
    }
    function set_query_body($arr)
    {
        $query_ordering = '';
        $where = "";
        $query = ' FROM fs_order
						  WHERE user_id IN ( ' . $arr . ' )
                            ORDER BY  id DESC 
                            ';
        return $query;
    }
    function get_list($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id, user_id,recipients_name,recipients_telephone,email, created_time, total_before, ship_price, member_discount_price, code_discount_price, total_end, status,member_coin";
        $query .= $query_body;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    function getTotal($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
}
=======
<?php

class MembersModelsOrdersf1 extends FSModels
{
    function __construct()
    {
        parent::__construct();
        global $module_config;
        $this->limit = 10;
    }
    function set_query_body($arr)
    {
        $query_ordering = '';
        $where = "";
        $query = ' FROM fs_order
						  WHERE user_id IN ( ' . $arr . ' )
                            ORDER BY  id DESC 
                            ';
        return $query;
    }
    function get_list($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id, user_id,recipients_name,recipients_telephone,email, created_time, total_before, ship_price, member_discount_price, code_discount_price, total_end, status,member_coin";
        $query .= $query_body;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        return $db->getObjectList();
    }
    function getTotal($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = "SELECT count(*)";
        $query .= $query_body;
        $sql = $db->query($query);
        $total = $db->getResult();
        return $total;
    }

    function getPagination($total)
    {
        FSFactory::include_class('Pagination');
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }
}
>>>>>>> 1654bf992e11181694e8b7fccf380335c943753e
