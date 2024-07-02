<?php

use function PHPSTORM_META\map;

class PromotionControllersVoucher extends Controllers
{
    function __construct()
    {
        parent::__construct();
        $this->view = 'voucher';
    }

    function display()
    {
        parent::display();
        $list = $this->model->get_data('');
        $pagination = $this->model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $ids = FSInput::get('id', array(), 'array');

        $model = $this->model;
        $categories = $model->get_categories_tree_all();
        $type = FSInput::get('type', 0);
 
        // switch ($type) {
        //     case 0:
        //         include 'modules/' . $this->module . '/views/' . $this->view . '/select_type.php';
        //         break;
        //     case 1:
        //         include 'modules/' . $this->module . '/views/' . $this->view . '/detail_ship.php';
        //         break;
        //     case 2:
                include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
                // break;
        // }
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree_all();

        $data = $model->get_record_by_id($id);
        
        $members = $this->model->get_records("id IN ($data->member_id)", "fs_members");

        $products = $this->model->get_records("id IN ($data->product_id)", "fs_products");

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
}
