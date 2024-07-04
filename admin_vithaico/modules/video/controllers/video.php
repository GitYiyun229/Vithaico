<?php

class VideoControllersVideo extends Controllers
{
    function __construct()
    {
        $this->module = 'video';
        $this->view = 'video';
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $list = $model->get_data("");

        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $model = $this->model;
        $products = $model->get_records("published = 1", "fs_products", "id, name", "id DESC");
        include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';

    }

    function edit()
    {
        $model = $this->model;
        $ids = FSInput::get('id',array(),'array');
        $id = $ids[0];
        $model = $this -> model;
        $data = $model->get_record_by_id($id);
        $products = $model->get_records("published = 1", "fs_products", "id, name", "id DESC");
        include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';

    }
}

?>
