<?php

class PromotionControllersGift extends Controllers
{
    function __construct()
    {
        parent::__construct();
        $this->view = 'gift';        
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
       
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
 
    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree_all();
       
        $data = $model->get_record_by_id($id);
         
        $products = $this->model->get_records("published = 1 AND id IN ($data->product_id)", "fs_products", "id, name, alias, code, image, price, price_old, quantity, status_prd");

        $giftOther = $this->model->get_exist_gift($data->date_start, $data->date_end, $data->id);
        $existOther = array_map(function ($item) {
            return $item->product_id;
        }, $giftOther);

        $existOther = explode(',', implode(',', $existOther));

        $exist = [...$existOther, ...explode(',', $data->product_id)];
        $exist = array_filter($exist); 
        $exist = array_unique($exist);

        $gift = json_decode($data->gift);
        
        $gift_id = [];
        foreach ($gift as $item) {
            $gift_id[] = $item->gift;
            $item->giftInfo = explode(',', $item->gift);
        }

        $gift_id = implode(',', $gift_id);

        $giftInfo = $this->model->get_records("published = 1 AND id IN ($gift_id)", "fs_products", "id, name, alias, code, image, price, price_old, quantity, status_prd");
        if (!empty($giftInfo)) {
            foreach ($gift as $item) {
                foreach ($item->giftInfo as $g => $giftId) {
                    foreach ($giftInfo as $info) {
                        if ($giftId == $info->id) {
                            $item->giftInfo[$g] = $info;
                        }
                    }
                }
            }
        }
         
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    } 
}
