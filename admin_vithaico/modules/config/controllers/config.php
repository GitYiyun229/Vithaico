<?php

class ConfigControllersConfig extends Controllers
{
    function __construct()
    {

        parent::__construct();
    }

    function display()
    {
        $model = $this->model;
        $data = $model->getData();
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    function save()
    {
        $model = $this->model;

        // call Models to save
        $cid = $model->save();
        if ($cid) {
            setRedirect('index.php?module=config', FSText:: _('Saved'));
        } else {
            setRedirect("index.php?module=config", FSText:: _('Not save'), 'error');
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