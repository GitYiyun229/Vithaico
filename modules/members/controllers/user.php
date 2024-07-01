<?php

class MembersControllersUser extends FSControllers
{
    public $module;
    public $view;


    public function __construct()
    {
        parent::__construct();
    }

    public function login()
    {
        include "modules/$this->module/views/$this->view/login.php";
    }
    public function register()
    {
        include  "modules/$this->module/views/$this->view/register.php";
    }
}
