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
        $ref_code = FSInput::get('affiliate');
        $check_code = $this->model->get_record('ref_code =' . $ref_code, 'fs_members', 'id');
        
        if (!$check_code) {
            setRedirect(URL_ROOT, FSText::_('Bạn cần link giới thiệu để thực hiện chức năng này, vui lòng thử lại !'), 'error');
        }

        if ($user->userID)
            setRedirect('index.php?module=members&view=dashboard', FSText::_('Bạn đã đăng nhập thành công !'), '');

        include  "modules/$this->module/views/$this->view/register.php";
    }
    public function forgot()
    {
       global $user ;

       

       include "modules/$this->module/views/$this->view/forgot.php";

    }
}
