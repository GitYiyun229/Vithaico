<?php
/**
 * @author vangiangfly
 * @category controller
 */ 
class PointsControllersPoints
{
    var $module;
    var $view;
    function __construct()
    {
        $this->module = 'points';
        $this->view = 'points';
        include 'modules/' . $this->module . '/models/' . $this->view . '.php';
    }
    function display()
    {
        $model = new PointsModelsPoints();
        $submitbt = FSInput::get('submitbt');
        $msg = '';
        $data = $model->get_data_();
        $slide = $model->get_slide();
//        var_dump($slide);
        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => FSText::_('Liên hệ'), 1 => '');
        global $tmpl;
        $tmpl -> set_seo_special();
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        include 'modules/' . $this->module . '/views/' . $this->view . '/' .'default.php';
    }
    function save(){
        $_SESSION['contact'] = $_REQUEST;
        if (!$this->check_captcha()){
            
            $this->display();
            echo "<script type='text/javascript'>alert('Bạn nhập sai mã hiển thị'); </script>";
            return;
        }
        $model = new PointsModelsPoints();
        $id = $model->save();
        if ($id){
            $link = FSRoute::_("index.php?module=connect&Itemid=14");
            $msg = "Cám ơn bạn đã gửi liên hệ cho chúng tôi";
            setRedirect($link, $msg);
            return;
        } else{
            echo "<script type='text/javascript'>alert('Xin lỗi bạn không thể gửi được cho BQT'); </script>";
            $this->display();
            return;
        }
    }
    function check_captcha()
    {
        $captcha = FSInput::get('txtCaptcha');
        if ($captcha == $_SESSION["security_code"])
        {
            return true;
        } else
        {
        }
        return false;
    }
}
?>