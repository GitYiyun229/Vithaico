<?php
/*
 * 
 */
	// controller
	class UsersControllersUsers extends FSControllers
	{
		var $module;
		var $view;
		function display()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			// call models
			$model = $this -> model;
			// call views			
			include 'modules/'.$this->module.'/views/'.$this->view.'/log.php';
		}
		
		/*
		 * View information of member
		 */
		function detail()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			$province = $model -> getProvince($data -> province);
			$district = $model -> getDistrict($data -> district);
			include 'modules/'.$this->module.'/views/'.$this->view.'/detail.php';
		}
		/*
		 * View information of member
		 */
		function edit()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			$cities  = $model -> get_cities();
			$districts  = $model -> get_districts($data -> city_id);
			$config_person_edit  = $model -> getConfig('person_edit');
			include 'modules/'.$this->module.'/views/'.$this->view.'/edit.php';
		}
		function user_info(){
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$data  = $model -> getMember();
			
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Thông tin tài khoản', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/user_info.php';
		}
		
		function login()
		{
			$model = $this -> model;
			if(isset($_SESSION['username'])){
				$link = FSRoute::_('index.php?module=users&task=logged&Itemid=37');
				setRedirect($link);
			}
			$config_person_login_info  = $model -> getConfig('login_info');
			
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Đăng nhập', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
//			$config_person_register_info  = $model -> getConfig('person_register_info');
			include 'modules/'.$this->module.'/views/'.$this->view.'/login.php';
		}
		
			
		function login_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get('Itemid',11,'int');
			
			$redirect = FSInput::get('redirect');
			if(!$redirect)
                $link = FSRoute::_("index.php?module=users&task=login&Itemid=11");
            else 
                $link = FSRoute::_("index.php?module=users&task=login&redirect=$redirect&Itemid=$Itemid");
                
                    
			$username = FSInput::get('username');
			$password = FSInput::get('password');
			
			if(!$username || !$password){
				setRedirect($link,'Bạn phải nhập đầy đủ thông tin','error');
			}
			$user = $model -> login();
			// not exist
			if(!$user){
				$msg = FSText::_("Username hoặc password của bạn không chính xác");
				setRedirect($link,$msg,'error');
			}
			
			// unactived
			if(!$user->published)
			{
				$msg = "Tài khoản của bạn chưa kích hoạt";
				setRedirect($link,$msg,'error');
			}
			// unactived
			if($user->block)
			{
				$msg = "Tài khoản của bạn đang bị khóa";
				setRedirect($link,$msg,'error');
			}
						
			// logged
			$_SESSION['fullname'] = $user->full_name ;
			$_SESSION['username'] = $user->username ;
			$_SESSION['user_id'] = $user->id ;
			
			// estore
//			$estore = $model -> get_estore($user->username);
//			if($estore){
//				$estore_id = $estore ->id;
//				if($estore_id){
//					$_SESSION['estore_id'] = $estore_id ;
//					$_SESSION['estore_is_buy'] = $estore -> is_buy ;
//				}
//			}else{
//				unset($_SESSION['estore_id']);
//				unset($_SESSION['estore_is_buy']);
//			}
			
			if($redirect)
				$link = base64_decode($redirect);
			else {
				$Itemid = 93;
//				$link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
				$link = URL_ROOT;
			}
			$msg ="Bạn đã đăng nhập thành công";
			setRedirect($link,$msg);
		}
		/*
		 * Display form forget
		 */
		function forget()
		{
			if(isset($_SESSION['username']))
			{
				if($_SESSION['username'])
				{
					$Itemid = 37;
					$link = FSRoute::_("index.php?module=users&task=logged&Itemid=$Itemid");
					setRedirect($link);
				}
			}
			$model = $this -> model;
			$config_person_forget  = $model -> getConfig('person_forget');
			
			//breadcrumbs
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Quên mật khẩu', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/forget.php';
		}
		
		function activate(){
			$model = $this -> model;
			$url = FSRoute::_('index.php?module=users&task=login&Itemid=11');
			if($model->activate()){
				setRedirect($url,'Tài khoản của bạn đã được kích hoạt thành công');	
			}else{
				setRedirect($url);
			}
		}
		
		function forget_save()
		{
			if(!$this->check_captcha())
			{
				$msg = "Mã hiển thị không đúng";
				setRedirect("index.php?module=users&task=forget&Itemid=38",$msg,'error');
			}
			
			$model = $this -> model;
			
			$user = $model->forget();
			if(@$user->email)
			{
				$resetPass = $model->resetPass($user->id);
				if(!$resetPass)
				{
					$msg = "Lỗi hệ thống khi reset Password";
					setRedirect("index.php?module=users&task=login&Itemid=11",$msg,'error');	
				}
				include 'modules/'.$this->module.'/controllers/emails.php';
				// send Mail()
				$user_emails = new  UsersControllersEmail();
				if(!$user_emails -> sendMailForget($user,$resetPass))
				{
					$msg = "Lỗi hệ thống khi send mail";
					setRedirect("index.php?module=users&task=login&Itemid=11",$msg,'error');	
				}
				$msg = "Mật khẩu của bạn đã được thay đổi. Vui lòng kiểm tra email của bạn";
				setRedirect("index.php?module=users&task=login&Itemid=11",$msg);	
			}
			else{
				$msg = "Email của bạn không tồn tại trong hệ thống. Vui lòng kiểm tra lại!";
				setRedirect("index.php?module=users&task=forget&Itemid=38",$msg,'error');
			}
		}
		
		function logout()
		{
			unset($_SESSION['fullname'] );
			unset($_SESSION['username']);
			
			setRedirect(URL_ROOT);
		}
		
		/*
		 * After login
		 */
		function logged()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
			$fssecurity -> checkLogin();
			$model = $this -> model;
//			$menus_user = $model -> getMenusUser();
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/logged.php';	
		}
		/**************** EDIT ***********/
		function edit_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			if(! $this -> check_edit_save())
			{
				$link = FSRoute::_("index.php?module=users&view=users&task=user_info&Itemid=$Itemid");
				$msg = FSText::_("Không thay đổi được!");
				setRedirect($link,$msg,'error');
			}
			$id = $model->edit_save();
			// if not save
			if($id)
			{
				$link = FSRoute::_("index.php?module=users&task=user_info&Itemid=$Itemid");
				$msg = FSText::_("Bạn đã cập nhật thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$link = FSRoute::_("index.php?module=users&task=user_info&Itemid=$Itemid");
				$msg = FSText::_("Không cập nhật thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		
		function views_select_birthday(){
			include 'modules/'.$this->module.'/views/'.$this->view.'/select_birthday.php';	
		}
		function check_edit_save()
		{
		
			$model = $this -> model;
			// check pass
//			$old_password = FSInput::get("old_password");
//			$password = FSInput::get("password");
//			$re_password = FSInput::get("re-password");
//
//			if($re_password)
//			{
//				if(!$model -> checkOldpass($old_password))
//				{
//					Errors::setError(FSText::_("M&#7853;t kh&#7849;u c&#361; kh&ocirc;ng &#273;&uacute;ng"));
//					return false;
//				}
//				if($password && ($password != $re_password))
//				{
//					Errors::setError(FSText::_("M&#7853;t kh&#7849;u kh&ocirc;ng tr&ugrave;ng nhau"));
//					return false;
//				}	
//			}
//			$email = FSInput::get("email");
//			$re_email = FSInput::get("re-email");
//			if($re_email)
//			{
//				if($email != $re_email)
//				{
//					Errors::setError(FSText::_("Email kh&ocirc;ng tr&ugrave;ng nhau"));
//					return false;
//				}	
//			}
			
			return true;
		}
		/**************** REGISTER ***********/
		/*
		 * Resigter
		 */
		function register()
		{
			
			$model = $this -> model;
			$config_register_rules  = $model -> getConfig('register_rules');
			$config_register_info  = $model -> getConfig('register_info');
//			$cities  = $model -> getCity();
//			$city_id_first = $cities[0] ->id;
//			$city_current = FSInput::get('province',$city_id_first,'int');
//			$districts  = $model -> getDistricts($city_current);
//			$district_current = FSInput::get('district',$districts[0] ->id,'int');
			
			$breadcrumbs = array();
			$breadcrumbs[] = array(0=>'Đăng ký thành viên', 1 => '');	
			global $tmpl;	
			$tmpl -> assign('breadcrumbs', $breadcrumbs);
			
			include 'modules/'.$this->module.'/views/'.$this->view.'/register.php';
		}
		
		function register_save()
		{
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			$use_estore = FSInput::get('use_estore',0,'int');
			if(! $this -> check_register_save()){
//				$link = FSRoute::_("index.php?module=users&view=users&task=register&Itemid=$Itemid");
//				$msg = "Bạn đăng ký công thành công. Kiểm tra lại các trường bạn đã nhập";
//				setRedirect($link,$msg,'error');
//				setRedirect($link);
				$this -> register();
				return;
			}
			$id = $model->save();
			
			// if not save
			if($id){
				// save estore
//				if($use_estore){
//	                $model->save_estore($id);
//	            }
	            
	            // create folder
//	            $model -> create_folder_upload($id);
	            
				$link = FSRoute::_("index.php?module=users&view=users&task=login&Itemid=11");
//				$msg = "Bạn đã đăng ký thành công. Có thể bạn phải đợi trong vòng 24 giờ để chúng tôi kiểm tra và kích hoạt. Nếu bạn cần gấp xin vui lòng liên hệ theo số điện thoại 0993743816";
				$msg = "Bạn đã đăng ký tài khoản thành công!Để sử dụng tài khoản này, hãy truy cập vào email của bạn để kích hoạt tài khoản. (Nếu trong hộp thư đến không có, bạn hãy vào Spam hay Bulk Mail để kiểm tra)";
				setRedirect($link,$msg);
			}
			else
			{
				$link = FSRoute::_("index.php?module=users&view=users&task=register&Itemid=$Itemid");
				$msg = FSText::_("Xin lỗi. Bạn chưa đăng ký thành công.");
				setRedirect($link,$msg,'error');
			}
		}
		
		function check_register_save(){
			// check pass
			$username = FSInput::get("username");
			FSFactory::include_class('errors');
			if(!$username){
				Errors::setError(FSText::_("Chưa nhập username"));
                return false;
			}
			     
			$password = FSInput::get("password");
			$re_password = FSInput::get("re-password");
			if(!$password || !$re_password)
			{
				Errors::setError(FSText::_("Chưa nhập mật khẩu"));
				return false;
			}
			if($password != $re_password)
			{
				Errors::setError(FSText::_("Mật khẩu không trùng nhau"));
				return false;
			}	
			
			$email = FSInput::get("email");
			$re_email = FSInput::get("re-email");
			if(!$email || !$re_email)
			{
				Errors::setError(FSText::_("Chưa nhập email"));
				return false;
			}
			if($email != $re_email)
			{
				Errors::setError(FSText::_("Email nhập lại không khớp"));
				return false;
			}
			
			// check captcha				
			if(!$this->check_captcha()){
//				Errors::setError(FSText::_("Mã hiển thị chưa đúng"));
				$this -> alert_error('Mã hiển thị chưa đúng');
				return false;
			}
			
			$model = $this -> model;
			// check email and identify card
			if(!$model->check_exits_email()){
				return false;
			}
			if(!$model->check_exits_username()){
				return false;
			}
			
			return true;
		}
		
		
		function check_exits_email(){
			$model = $this -> model;
			if(!$model -> check_exits_email())
				return false;
			return true;
		}
		
		function ajax_check_exist_username(){
			$model = $this -> model;
			if(!$model -> ajax_check_exits_username()){
				echo 0;
				return false;
			}
			echo 1;
			return true;
		}
		
		function ajax_check_exist_email(){
			$model = $this -> model;
			if(!$model -> ajax_check_exits_email()){
				echo 0;
				return false;
			}
			echo 1;
			return true;
		}
		
		/*
		 * load District by city id. 
		 * Use Ajax
		 */
		
		function destination(){
			$model = $this -> model;
			
			$cid = FSInput::get('cid');
			$did = FSInput::get('did');
			if($cid){
				$rs  = $model -> getDestination($cid);
			}
			if($did){
				$rs  = $model -> getDestination1($did);
			}
			$json = '[{id: 0,name: "Điểm đến"},'; // start the json array element
			$json_names = array();
			foreach( $rs as $item)
			{
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
			$json .= implode(',', $json_names);
			$json .= ']'; // end the json array element
			echo $json;
		}
		
		/*
		 * check valid Sim
		 */
//		function check_valid_sim()
//		{
//		// check SIM
//			$model = $this -> model;
//			if(!$model->checkSimByAjax())
//			{
//				echo 0;
//				return;
//			}
//			echo 1;
//			return;
//		}
	 function changepass()
		{
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
            $model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			include 'modules/'.$this->module.'/views/'.$this->view.'/changepass.php';
			
		}
        function edit_save_changepass()
		{
			// check logged
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			
			$link = FSRoute::_("index.php?module=users&task=user_info&Itemid=40");
			$check =  $model->check_change_pass();
			if(!$check){
				setRedirect($link,'Mật khẩu cũ chưa chính xác','error');
			}
			
			$rs = $model->save_changepass();
			// if not save
			
			if($rs) {
				$msg = FSText::_("Bạn đã thay đổi thành công");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = FSText::_("Xin lỗi. Bạn chưa thay đổi thành công!");
				setRedirect($link,$msg,'error');
			}
		}
		
        function change_email_save()
		{
			// check logged
			$fssecurity  = FSFactory::getClass('fssecurity');
            $fssecurity -> checkLogin();
			$model = $this -> model;
			$Itemid = FSInput::get("Itemid",1);
			
			$link = FSRoute::_("index.php?module=users&task=changepass&Itemid=$Itemid");
			$email_new = FSInput::get('email_new');
			if($email_new){
				
				$re_email_new = FSInput::get('re_email_new');		
				if($email_new != $re_email_new){
					$msg = FSText::_("Email nh&#7853;p ch&#432;a kh&#7899;p!");
					setRedirect($link,$msg,'error');
				}
				$check =  $model->check_change_pass();
				if(!$check){
					setRedirect($link,'Email m&#7899;i c&#7911;a b&#7841;n &#273;&#227; t&#7891;n t&#7841;i trong h&#7879; th&#7889;ng. B&#7841;n ch&#432;a thay &#273;&#7893;i &#273;&#432;&#7907;c th&#244;ng tin','error');
				}
			} 
			
			$rs = $model->save_changepass();
			// if not save
            
			
			if($rs) {
				$msg = FSText::_("B&#7841;n &#273;&#227; thay &#273;&#7893;i th&#224;nh c&#244;ng");
				setRedirect($link,$msg);
			}
			else
			{
				$msg = FSText::_("Xin l&#7895;i, b&#7841;n &#273;&#227; thay &#273;&#7893;i kh&#244;ng th&#224;nh c&#244;ng!");
				setRedirect($link,$msg,'error');
			}
		}
		/*
		 * * Load list addbook
		 * Get address book for search
		 */
		function ajax_get_address_book_by_key(){
			$model = $this -> model;
			$list = $model -> get_address_book_by_key();
			$total = count($list);
			if(!$total){
				$add_property = $model -> get_address_book_properties();
				// convert to array
				$other_properties = array();
				foreach($add_property as $item){
					if(!isset($other_properties[$item->type]))
						$other_properties[$item->type] = array();
					$other_properties[$item->type][] = $item;
				}
				// location	
				$countries  = $model -> get_countries();
				$country_current = isset($data -> coutry_id)?$data -> coutry_id:66; // default: VietNam
				$cities  = $model -> get_cities($country_current);
				$city_id_first = $cities[0] ->id;
				$city_current = isset($data -> city_id)?$data -> city_id:$city_id_first;
				$districts  = $model -> get_districts($city_current);
				$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
				$communes  = $model -> get_communes($district_current);
				$commune_current = isset($communes[0]->id)?$communes[0]->id:0;
				$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');
			}
			include 'modules/'.$this->module.'/views/'.$this->view.'/register_address_book.php';
		}
		
		function ajax_add_address_book_form(){
			$model = $this -> model;
			$add_property = $model -> get_address_book_properties();
			// convert to array
			$other_properties = array();
			foreach($add_property as $item){
				if(!isset($other_properties[$item->type]))
					$other_properties[$item->type] = array();
				$other_properties[$item->type][] = $item;
			}
				
			// location	
			$countries  = $model -> get_countries();
			$country_current = 66; // default: VietNam
			$cities  = $model -> get_cities($country_current);
			$city_current = isset($cities[0] ->id)?$cities[0] ->id:0;
			$districts  = $model -> get_districts($city_current);
			$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
			$communes  = $model -> get_communes($district_current);
			$commune_current = isset($communes[0]->id)?$communes[0]->id:0;
			$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');
			include 'modules/'.$this->module.'/views/'.$this->view.'/register_add_addressbook.php';
		}
		
		/*
		 * Get address book for search
		 */
		function ajax_load_address_book_by_id(){
			$model = $this -> model;
			$id = FSInput::get('id','int',0);
			if(!$id)
				return;
			$data = $model -> get_record_by_id($id,'fs_address_book');
			if(!$data)
				return;
			$add_property = $model -> get_address_book_properties();
			// convert to array
			$other_properties = array();
			foreach($add_property as $item){
				if(!isset($other_properties[$item->type]))
					$other_properties[$item->type] = array();
				$other_properties[$item->type][] = $item;
			}
			// location	
			$countries  = $model -> get_countries();
			$country_current = isset($data -> coutry_id)?$data -> coutry_id:66; // default: VietNam
			$cities  = $model -> get_cities($country_current);
			$city_id_first = $cities[0] ->id;
			$city_current = isset($data -> city_id)?$data -> city_id:$city_id_first;
			$districts  = $model -> get_districts($city_current);
			$district_current = isset($data -> district_id)?$data -> district_id:$districts[0]->id;
			$communes  = $model -> get_communes($district_current);
			$commune_current = isset($data -> commune_id)?$data -> commune_id:$communes[0]->id;
			$categories = $model -> get_records('published = 1','fs_address_book_categories',$select = 'id,name,parent_id',$ordering = ' ordering,id ');

			include 'modules/'.$this->module.'/views/'.$this->view.'/register_load_address_book.php';
		}
	}
	
?>
