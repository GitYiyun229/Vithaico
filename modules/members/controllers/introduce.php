<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';

class MembersControllersIntroduce extends MembersControllersMembers
{
    public function display()
    {
        global $tmpl, $user, $config;

        $tmpl->addTitle(FSText::_('Thành viên giới thiệu'));

      

        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }


}
