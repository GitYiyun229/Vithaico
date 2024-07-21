<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';
class MembersControllersIntroduce extends MembersControllersMembers
{
    public function display()
    {
        global $tmpl, $user, $config;
        $model=$this->model;
        $User_by = $user->userInfo;
        $tmpl->addTitle(FSText::_('Thành viên giới thiệu'));
        $CountMember =count( $this->model->getCountMember($User_by->ref_code));

        $query_body = $model->set_query_body($User_by->ref_code);
        $list_members = $model->get_list($query_body);
        $total = $model->getTotal($query_body);
        $pagination = $model->getPagination($total);
        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }
}
