<?php

class AutogetModelsAutoget extends FSModels {

    var $limit;
    var $prefix;

    function __construct() {
        $this->limit = 10;
        $this->view = 'autoget';
        $this->table_name = 'fs_autoget';
        $this->table_category_name = 'fs_products_categories';
        parent::__construct();
    }

    function get_categories_tree() {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
    function save($row = array(), $use_mysql_real_escape_string = 1) {
        $title = FSInput::get('title');
        if (!$title)
            return false;
        $category_id = FSInput::get('category_id', 0, 'int');
        if (!$category_id) {
            Errors::_('Bạn phải chọn danh mục');
            return;
        }
        $id = FSInput::get('id');
        if(!$id){
            $url_link = FSInput::get('url');
            $check_link = $this->check_link_exits($url_link);
            if(!$check_link){
                Errors::_('Link đã tồn tại');
                return;
            }
        }

        $cat = $this->get_record_by_id($category_id, $this->table_category_name);
        $row['category_id_wrapper'] = $cat->list_parents;
        $row['category_alias_wrapper'] = $cat->alias_wrapper;
        $row['category_name'] = $cat->name;
        $row['category_alias'] = $cat->alias;
        
        $rs = parent::save($row);
        return $rs;
    }
    
    function check_link_exits($link) {
        global $db;
        $sql = " SELECT count(*) 
					FROM " . $this->table_name . "
					WHERE url = '$link' ";
        $db->query($sql);
        $count = $db->getResult();
        if ($count) {
            return false;
        } else {
            return true;
        }
    }

}

?>