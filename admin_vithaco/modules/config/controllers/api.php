<?php

class ConfigControllersApi extends Controllers
{
    function __construct()
    {

        parent::__construct();
    }

    function display()
    {
        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if($user_id == 1 || $user_id == 9){
            $model = $this->model;
            $data = $model->getData();
            include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
        } else {
            echo "You have no permission!";
        }
    }

    function save()
    {
        $model = $this->model;
       
        // call Models to save
        $cid = $model->save();
        if ($cid) {
            setRedirect('index.php?module=config&view=api', FSText:: _('Saved'));
        } else {
            setRedirect("index.php?module=config&view=api", FSText:: _('Not save'), 'error');
        }

    }

    function del_cache(){
        $memcache = new Memcache();
        $memcache->addServer('127.0.0.1', 11211);
        $memcache->flush();
        setRedirect('index.php?module=config&view=config', FSText::_('Xóa cache thành công!'));
    }
}

?>