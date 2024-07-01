<?php

class PromotionControllersDiscount extends Controllers
{
    function __construct()
    {
        parent::__construct();
        $this->view = 'discount';
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
        $model = $this->model;
        // $exist = $this->getExistProduct();
        $categories = $model->get_categories_tree_all();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $id = FSInput::get('id');
        $model = $this->model;      
        $categories = $model->get_categories_tree_all();
        $data = $model->get_record_by_id($id);
        $detail = $model->getDetail($id);

        $existOther = $this->getExistProduct($data->date_start, $data->date_end);

        $existCurrent = array_map(function($item) {
            return $item->product_id;
        }, $detail);

        $exist = [...$existOther, ...$existCurrent];

        $exist = array_unique($exist);

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    public function getExistProduct($start, $end)
    {
        $promotion = $this->model->getPromotionExist($start, $end);
        $promotionId = array_map(function($item) {
            return $item->id;
        }, $promotion);

        $promotionDetail = $this->model->get_records("published = 1 AND promotion_id IN (". implode(',', $promotionId) .")", 'fs_promotion_discount_detail');

        return array_map(function($item) {
            return $item->product_id;
        }, $promotionDetail);
    }
}
