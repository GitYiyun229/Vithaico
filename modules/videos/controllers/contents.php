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
			
			$data = $model->getContents();

//            if (! $data){
//                $link = URL_ROOT.'404.html';
//                setRedirect($link);
//            }
			global $tmpl,$module_config;
			$tmpl -> set_data_seo($data);

            $ccode = FSInput::get('ccode');
			$category_id = $data -> category_id;
			$category = $model -> get_category_by_id($category_id);
//			if(!$category)
//				die('Kh&#244;ng th&#7845;y Category');
//			$Itemid = 7;
//			if($ccode){
//				if(trim($ccode) != trim($category-> alias )){
//					$link_contents = FSRoute::_("index.php?module=contents&view=contents&code=".trim($data->alias)."&ccode=".trim($category-> alias)."&Itemid=$Itemid");
//					setRedirect($link_contents);
//				}
//			}
			$relate_contents_list = $model->getRelateContentList($category_id);
			//$relate_contents_list = $model->get_relate_by_tags($data -> tags,$data -> id);
			$total_content_relate  = count($relate_contents_list);
			$str_ids = '';
			for($i = 0; $i < $total_content_relate; $i ++){
				$item = $relate_contents_list[$i];
				if($i > 0) $str_ids .= ',';
				$str_ids .= $item -> category_id;
			}
			$content_category_alias = $model->get_content_category_ids($str_ids);
			$breadcrumbs = array();
			//$breadcrumbs[] = array(0=>$category -> name, 1 => FSRoute::_('index.php?module=contents&view=cat&id='.$data -> category_id.'&ccode='.$data -> category_alias));	
			$breadcrumbs[] = array(0=>$category ->name, 1 => '');
			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			// seo
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
		
		/*
		 * Trả về thẻ h2 (true) hay h3 (false)
		 * @$field_config: trường cần lấy từ module_config
		 * @$value_need_articulation: giá trị cần khớp để trả về đúng h2
		 */
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