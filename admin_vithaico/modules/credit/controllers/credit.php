<?php

class CreditControllersCredit extends Controllers
{
    function __construct()
    {
        $this->view = 'credit';
        parent::__construct();
        $profile = [
            1 => 'CMND + Hộ Khẩu',
            2 => 'CMND/CCCD',
            3 => 'CMND + Bằng lái xe / hộ khẩu',
            4 => 'CMND + Hộ Khẩu + Hóa đơn điện',
            5 => 'CMND + Hộ Khẩu + Hóa đơn điện',
            6 => 'CMND + Bằng lái /Hộ khẩu + Hóa đơn điện',
            7 => 'CMND + Bằng lái xe'
        ];
//        $this->profile = $profile;

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
        $model = $this -> model;
        $month = $model->get_records('published = 1','fs_month');
        // data from fs_contents_categories
        $maxOrdering = $model->getMaxOrdering();
//        $arr_profile = $this->profile;
//        $array_obj_profile = array();
//        foreach ($arr_profile as $key => $name) {
//            $array_obj_profile[] = (object)array('id' => ($key), 'title' => $name);
//        }

        include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
    }
    function edit()
    {
        $ids = FSInput::get('id',array(),'array');
        $id = $ids[0];
        $model = $this -> model;
//			$tags_categories = $model->get_tags_categories();
        $data = $model->get_record_by_id($id);
        $list_credit = $model->get_records('credit_id ='.$id,'fs_tenor');
        $month = $model->get_records('published = 1','fs_month');
//        $arr_profile = $this->profile;
//        $array_obj_profile = array();
//        foreach ($arr_profile as $key => $name) {
//            $array_obj_profile[] = (object)array('id' => ($key), 'title' => $name);
//        }
        // data from fs_news_categories
        include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
    }


}

?>