<?php

// models 

class AutogetControllersAutoget extends Controllers {

    function __construct() {
        $this->view = 'autoget';
        parent::__construct();
    }

    function display() {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $model->get_data();
        $pagination = $model->getPagination();
        $categories = $model->get_product_categories_tree_by_permission();

        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add() {
        $model = $this->model;
        $categories = $model->get_categories_tree();
        $list_key = array();
        $maxOrdering = $model->getMaxOrdering();

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit() {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_product_categories_tree_by_permission();
 
        $data = $model->get_record_by_id($id);

        // data from fs_news_categories
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

}

?>