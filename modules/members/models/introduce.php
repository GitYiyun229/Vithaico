<?php

class MembersModelsIntroduce extends FSModels
{

    function __construct()
    {
        parent::__construct();
        global $module_config;
        $this->limit = 8;
    }
    function set_query_body($id)
    {
        $query_ordering = '';
        $where = "";
        $query = ' FROM fs_members
						  WHERE ref_code = ' . $id . ' 
						  	AND published = 1 
                            ORDER BY created_time DESC, id DESC 
                            ';
        return $query;
    }
    function get_list($query_body)
    {
        if (!$query_body)
            return;

        global $db;
        $query = " SELECT id ,full_name, created_time,telephone,email";
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
