<?php
	/*
	 * Huy write
	 */
	// controller
class ContactControllersContact extends FSControllers {
	
		function display(){
		$model = $this->model;
			
			$submitbt = FSInput::get('submitbt');
			$msg = '';
            $data = $this->model->get_data();
//            var_dump($data);die;
			$city = $this->model->get_city(); 
			$array_breadcrumb[] = array(0=> array('name'=> 'Hệ thống cửa hàng', 'link'=>'','selected' => 0));

			// breadcrumbs
			$breadcrumbs = array ();
			$breadcrumbs [] = array (0 => FSText::_ ( 'Hệ thống cửa hàng' ), 1 => '' );
			global $tmpl;
			$tmpl->assign ( 'breadcrumbs', $breadcrumbs );
			 $tmpl -> set_seo_special();
			// call views
			include 'modules/'.$this->module.'/views/'.$this->view.'/'.'default.php';
		}
		    function save(){
        $_SESSION['contact'] = $_REQUEST;
        if (!$this->check_captcha()){
            echo "<script type='text/javascript'>smoke.alert('Bạn nhập sai mã hiển thị'); </script>";
            
            $this->display();
            return;
        }
        $model = new ContactModelsContact();
        $id = $model->save();
        if ($id){
            $link = FSRoute::_("index.php?module=contact&Itemid=14");
            $msg = "Cám ơn bạn đã gửi liên hệ cho chúng tôi";
            setRedirect($link, $msg);
            return;
        } else{
            echo "<script type='text/javascript'>smoke.alert('Xin lỗi bạn không thể gửi được cho BQT'); </script>";
            $this->display();
            return;
        }
    }

    function ajax_address(){



        $json = array(

            'error' => true,

            'html' => '',


            );
        $id = FSInput::get('id');
        $city = $this->model->get_city_ajax($id);

        foreach ($city as $item){
        $active='';
        if ($item->ordering == 1) {
            $active= "active";
        }

        $json['html']  .= '
                    <div  class="maps-info mt10 " onclick="clickActive('.$item->id.',true)" value="<?php echo $item->id; ?>" >
                        <p id="'.$active.'" class="panel-title"><a class="info-window" href="javascript:void(0)">'.$item->name.'</a></p>
                        <p class="addressApc">'.$item->address.'</p>
                        <p class="phoneApc">Tell: '.$item->phone.'</p>
                    </div>
        ';
        }
        $json['error'] = false;

        echo json_encode($json);

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