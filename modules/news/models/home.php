<?php

class NewsModelsHome extends FSModels
{
    function __construct()
    {
        parent::__construct();
        global $module_config;
        // FSFactory::include_class('parameters');
        // $current_parameters = new Parameters($module_config->params);
        // $limit = $current_parameters->getParams('limit');
        // $limit = 6;
        // $fstable = FSFactory::getClass('fstable');
        $this->table_news = FSTable::_('fs_news', 1);
        $this->table_category = FSTable::_('fs_news_categories', 1);
        $this->limit = 8;
    }

    function set_query_body()
    {
        $query = "  FROM " . $this->table_news . "
        WHERE published = 1 AND is_hot = 0 ORDER BY created_time desc";
        return $query;
    }

    function get_list_categories()
    {
        global $db;
        $query = "SELECT id, name, alias, image
                  FROM " . $this->table_category . "
                  WHERE published = 1
                  ORDER BY ordering ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_list_hot()
    {
        global $db;
        $query = "SELECT id, title, alias, image, summary, category_name, created_time
                  FROM " . $this->table_news . "
                  WHERE published = 1 AND is_hot = 1
                  ORDER BY created_time DESC, ordering ASC LIMIT 5";
        $sql = $db->query($query);
        // print_r($sql);
        // die;
        $result = $db->getObjectList();
        return $result;
    }

    function get_list_new($query_body)
    {
        if (!$query_body)
            return;
        global $db;
        $query = " SELECT id, title, alias, image, icon, summary, category_name, created_time ";
        $query .= $query_body;
        $sql = $db->query_limit($query, $this->limit, $this->page);
        // print_r($sql);
        // die;
        $result = $db->getObjectList();
        return $result;
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
        // print_r($pagination) ;
        return $pagination;
    }

    function getLoadmore($total, $pagecurrent, $detect)
    {
        FSFactory::include_class('Loadmore');
        $loadmore = new Loadmore($pagecurrent, 15, $total, $this->page);
        return $loadmore;
    }
}
