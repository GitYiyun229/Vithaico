<?php

    class ProductsControllersManufactor extends Controllers{
         function display()
         {
             parent::display();
             $sort_field = $this -> sort_field;
             $sort_direct = $this -> sort_direct;

             $model  = $this -> model;
             $list = $this -> model->get_categories_tree();

             $pagination = $model->getPagination('');
             include 'modules/'.$this->module.'/views/'.$this->view.'/list.php';
         }
        function add()
        {
            $model = $this -> model;
            $categories = $model->get_categories_tree();
            $maxOrdering = $model->getMaxOrdering();

            include 'modules/'.$this->module.'/views/'.$this -> view.'/detail.php';
        }

        function edit()
        {
            $ids = FSInput::get('id',array(),'array');
            $id = $ids[0];
            $model = $this -> model;
            $data = $model->get_record_by_id($id);
            $categories = $model->get_categories_tree();

            include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
        }

        function show_in_homepage() {
            $this->is_check('show_in_homepage', 1, 'show home');
        }

        function unshow_in_homepage() {
            $this->unis_check('show_in_homepage', 0, 'un home');
        }
    }


	
?>