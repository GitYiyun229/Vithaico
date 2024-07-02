<?php
class HomeControllersHome extends Controllers{
    public function __construc(){
        $this->view = 'home';
        parent::__construct();
    }
    public function display(){
        parent::display();
        $model  = $this -> model;
        $list = $model->get_menu_modules();
        $site_name = $model->get_site_name();
		require('modules/'.$this->module.'/views/'.$this->view.'.php');
    }
}