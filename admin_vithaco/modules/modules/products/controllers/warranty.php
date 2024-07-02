<?php
class ProductsControllersWarranty extends Controllers
{
    function __construct()
    {
        $this->view = 'warranty';
        parent::__construct();
    }
    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;
        $model = $this->model;
        $list = $this -> model->get_data("");
        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }
    function add()
    {
        $model = $this->model;
        $maxOrdering = $model->getMaxOrdering();
        $categories = $model->get_categories_tree();
        $products_add = $model->get_all_products();

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $data = $model->get_record_by_id($id);
        $products = $model->get_records('record_id =' . $id, 'fs_warranty_price');
        $products_add = $model->get_all_products();
        $categories = $model->get_categories_tree();

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
}
?>