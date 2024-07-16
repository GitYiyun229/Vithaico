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
        global $user;
        if ($user->userID)
            setRedirect('index.php?module=members&view=dashboard', FSText::_('Bạn đã đăng nhập thành công !'), '');

        include "modules/$this->module/views/$this->view/login.php";
    }
    
    public function register()
    {
        global $user;
        if ($user->userID)
            setRedirect('index.php?module=members&view=dashboard', FSText::_('Bạn đã đăng nhập thành công !'), '');
        
        include  "modules/$this->module/views/$this->view/register.php";
    }
}
