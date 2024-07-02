<?php
/*
 * Huy write
 */
	// controller
	
	class ContentsControllersContents extends FSControllers
	{
		var $module;
		var $view;
	
		function display()
		{
			// call models
			$model = new ContentsModelsContents();

			$redirect = $model->get_redirect();
			$code = substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT_REDUCE));
			if (@$redirect) {
				$data_prd = $model->get_product_re($redirect->record_id);
				$linh_rec = FSRoute::_('index.php?module=contents&view=contents&ccode=' . $data_prd->alias);
				if ($code != $data_prd->alias) {
					header("HTTP/1.1 301 Moved Permanently");
					header("Location: " . $linh_rec);
					exit();
				}
			}

			$data = $model->getContents();
			global $tmpl,$module_config;
			$tmpl -> set_data_seo($data);

            $ccode = FSInput::get('ccode');
			$category_id = $data -> category_id;
			$category = $model -> get_category_by_id($category_id);
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			$link = FSRoute::_("index.php?module=contents&view=contents&ccode=".$data->alias);
        	$tmpl -> assign ( 'canonical',$link);
			$tmpl -> set_data_seo($data);
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/default.php';
		}
		
		
		/* Save comment */
		function save_comment(){
			$return = FSInput::get('return');
			$url = base64_decode($return);
			
			if(!$this -> check_captcha()){
				$msg = 'Mã hiển thị không đúng';
				setRedirect($url,$msg,'error');
			}
			$model = new ContentsModelsContents();
			if(!$model -> save_comment()){
				$msg =  'Chưa lưu thành công comment!';
				setRedirect($url,$msg,'error');
			} else {
				setRedirect($url,'Cảm ơn bạn đã gửi comment');
			}
			
		}
		/* Save comment */
		function save_comment_ajax(){
			if(!$this -> check_captcha()){
				echo 0;
				return;
			}
			$model = new ContentsModelsContents();
			if(!$model -> save_comment()){
				echo 0;
				return;
			} else {
				echo 1;
				return;
			}
			
		}
		
		// check captcha
		function ajax_check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			if ( $captcha == $_SESSION["security_code"]){
				echo 1;
				return;
			} else {
				echo 0;
				return;
			}
		}
		// check captcha
		function check_captcha(){
			$captcha = FSInput::get('txtCaptcha');
			if ( $captcha == $_SESSION["security_code"]){
				return true;
			} 
			return false;
		}
		
		function rating(){
			$model = new ContentsModelsContents();
			if(!$model -> save_rating()){
				echo '0';
				return;
			} else {
				echo '1';
				return;
			}
		}
		function get_tags_seo_from_config($field_config,$value_need_articulation){
			global $module_config;
			$fields_seo_h2 = isset($module_config -> $field_config)?$module_config -> $field_config:'';
			if(!$fields_seo_h2){
				return true;
			}else{
				if(strpos($fields_seo_h2, $value_need_articulation) !== false){
					return true;	
				}else{	
					return false;
				}
			}
		}
	}
	
?>