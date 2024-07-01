<?php
class TiktokControllersTiktok extends Controllers
{

    function __construct()
    {
        $this->view = 'tiktok';
        parent::__construct();
    }

    function display()
    {
        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
         
        $list = $model->get_data(''); 
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $model = $this->model;
        
        

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
   
        $data = $model->get_record_by_id($id);
     
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
 

}

?>