<?php
class AjaxModelsAjax extends FSModels{
    function __construct(){
        parent::__construct();
    }

    function load_extend_fields(){
        global $db;
        $extend_category_id = intval(FSInput::get('extend_category_id', ''));
        $where = '';
        if($extend_category_id) {
            $cat = $this->get_record('id=' . $extend_category_id, 'fs_products_categories');
            if($cat)
                $where = ' OR category_id IN(0'.$cat->list_parents.'0)';
        }
        $db->query('SELECT *
                    FROM fs_products_extend_fields
                    WHERE category_id='.$extend_category_id.' OR temp=\''.session_id().'\''.$where.' and category_id != 0 and childs = 1 ORDER BY ordering ASC, id DESC');
        return $db->getObjectList();
    }

    function load_extends_groups(){
        global $db;
        $db->query('SELECT *
                    FROM fs_extends_groups
                    WHERE published = 1 
                    ORDER BY ordering ASC');
        return $db->getObjectList();
    }

    function load_field_tables(){
        global $db;
        $db->query('SELECT * FROM fs_extends_groups ORDER BY ordering ASC ');
        return $db->getObjectList();
    }

    function load_filter_price(){
        global $db;
        $price_category_id = intval(FSInput::get('price_category_id', ''));
        $where = '';
        if($price_category_id) {
            $cat = $this->get_record('id=' . $price_category_id, 'fs_products_categories');
            if($cat)
                $where = ' OR category_id IN(0'.$cat->list_parents.'0)';
        }
        $db->query('SELECT *
                    FROM fs_products_filter_price
                    WHERE category_id='.$price_category_id.' OR temp=\''.session_id().'\''.$where.' ORDER BY ordering ASC, id DESC');
        return $db->getObjectList();
    }
}