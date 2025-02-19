<?php 
	class UsersModelsUsers extends FSModels
	{
		function __construct()
		{
		}
		function getConfig($name)
		{
			global $db;
			$sql = " SELECT value FROM fs_config 
				WHERE name = '$name' ";
			return $db->getResult($sql);
		}
		
		
		/********** REGISTER ***********/
		/*
		 * save register
		 */
		function save()
		{
			global $db;
			$row = array();
			$row['username'] = FSInput::get("username");
			$password_de = FSInput::get("password");
			if(!$row['username'] && !$password_de)
				return;
			$time = date("Y-m-d H:i:s");	
			$row['password'] = md5($password_de);
			$row['full_name'] =   FSInput::get("full_name");
			$row['email'] =   FSInput::get("email");
			$birth_day =   FSInput::get("birth_day");
			$birth_month =   FSInput::get("birth_month");
			$birth_year =   FSInput::get("birth_year");
			$row['birthday'] = date("Y-m-d",mktime(0, 0, 0, $birth_day, $birth_month,$birth_year));
			$row['sex'] =   FSInput::get("sex");
			$row['mobilephone'] =   FSInput::get("mobilephone");
			$row['telephone'] =   FSInput::get("telephone");
//		
			$row['block'] =  0;
			$row['published'] =  0;
			$fstring = FSFactory::getClass('FSString','','../');
			$row['activated_code'] =  $fstring->generateRandomString(32);
		
			$row['mobilephone']  = FSInput::get("mobilephone");
			$row['address']      =  FSInput::get("address");
			$row['job']      =  FSInput::get("job");
			
			$row['created_time']  = $time;
			$row['edited_time']  = $time;

		
			$id = $this -> _add($row, 'fs_members');
			if($id){
				$this -> send_mail_activated_user($row['full_name'],$row['username'],$password_de,$row['activated_code'],$id,$row['email']);
			}
			return $id;	
		}
		
		function update_account($username,$user_id,$address_book_id){
			$row = array('user_id' => $user_id, 'username' => $username);
			$this -> _update($row, 'fs_address_book', 'WHERE id = '.$address_book_id);
		}
		
		/*
		 * Register addressbook
		 */
		function register_address_book(){
			$time = date("Y-m-d H:i:s");	
			$data_address = array(
				'category_id'=>FSInput::get('cat_code'),
				'name'=>FSInput::get('name_address'),
				'business_license'=>FSInput::get('business_license'),
				'activity_filed'=>FSInput::get('activity_filed'),
				'main_areas'=>FSInput::get('main_areas'),
				'partner'=>FSInput::get('partner'),
				'partner_country_id'=>FSInput::get('partner_country_id'),
				'revenue'=>FSInput::get('revenue'),
				'quantity_staff'=>FSInput::get('quantity_staff'),
				'working_time_from'=>FSInput::get('working_time_from'),
				'working_time_to'=>FSInput::get('working_time_to'),
				'lunch_break_from'=>FSInput::get('lunch_break_from'),
				'lunch_break_to'=>FSInput::get('lunch_break_to'),
				'holiday_week'=>FSInput::get('holiday_week'),
				'country_id'=>FSInput::get('address_country_id'),
				'city_id'=>FSInput::get('address_city_id'),
				'district_id'=>FSInput::get('address_district_id'),
				'commune_id'=>FSInput::get('address_commune_id'),
				'street'=>FSInput::get('address_street'),
				'house'=>FSInput::get('address_house'),
				'region_phone'=>FSInput::get('address_region_phone'),
				'phone'=>FSInput::get('address_phone'),
				'region_fax'=>FSInput::get('address_region_fax'),
				'fax'=>FSInput::get('address_fax'),
				'hotline'=>FSInput::get('address_hotline'),
				'email_baokim'=>FSInput::get('email_baokim'),
				'website'=>FSInput::get('address_website'),
				'published'=>1,
				'created_time'=>$time,
				'edited_time'=>$time,
			);
			$certificate = FSInput::get('certificate',array(),'array');
			$object_service = FSInput::get('object_service',array(),'array');
			if(!empty($certificate) && is_array($certificate)){
				$data_address['certificate'] = ','.implode(',',$certificate).',';
			}
			if(!empty($object_service) && is_array($object_service)){
				$data_address['object_service'] = ','.implode(',',$object_service).',';
			}
			// Lấy thông tin bổ sung về danh mục (loại hình hoạt động)
			$categories = $this->get_record_by_id(FSInput::get('cat_code'),'fs_address_book_categories');
			$category_name = $categories->name;
			$data_address['category_name'] = $categories->name;
			$data_address['category_alias'] = $categories->alias;
			$data_address['category_alias_wrapper'] = $categories->alias_wrapper;
			$data_address['category_id_wrapper'] = $categories->list_parents;
			
			// partner country
			$detail = $this->get_record_by_id(FSInput::get('partner_country_id',0,'int'),'fs_countries');
			$data_address['partner_country_name'] = $detail->name;
			$data_address['partner_country_flag'] = $detail->flag;
			
			// country for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_country_id'),'fs_countries')){
				$country_name = $detail->name;
				$data_address['country_name'] = $country_name;
				$data_address['country_flag'] = $detail->flag;
			}
			//	city for address book
			if($detail = $this->get_record_by_id(FSInput::get('address_city_id',0,'int'),'fs_cities')){
				$city_name = $detail->name;
				$data_address['city_name'] = $city_name;
			}
			//	district for address book			
			if($detail = $this->get_record_by_id(FSInput::get('address_district_id',0,'int'),'fs_districts')){
				$district_name = $detail->name;
				$data_address['district_name'] = $district_name;
			}
			//	commune for address book	
			if($detail = $this->get_record_by_id(FSInput::get('address_commune_id',0,'int'),'fs_commune')){
				$commune_name = $detail->name;
				$data_address['commune_name'] = $commune_name;
			}
			// Kiểm tra xem đăng ký mới hay sửa danh bạ
			$address_book_id = FSInput::get('address_book_id');
			if(!empty($address_book_id)){ 
				return $address_book_id;
			}else{
				//update content_search
				$fsstring = FSFactory::getClass('FSString','');	
				$content_search = $fsstring -> removeHTML($category_name.' '.FSInput::get('name_address').' '.FSInput::get('main_areas').' '.FSInput::get('activity_filed').' '.$country_name.' '.$city_name.' '.$district_name.' '.$commune_name);	
				
				$data_address['content_search'] =  $fsstring ->convert_utf8_to_telex($content_search).' '.$fsstring ->remove_viet_sign($content_search);
				$address_book_id = $this->_add($data_address,'fs_address_book');
				return $address_book_id;
			}
		}
		
		function upload_avatar(){
			$avatar = $_FILES["avatar"]["name"];
			if(!$avatar)
				return ;
			$fsFile = FSFactory::getClass('FsFiles');
			$img_folder = 'images/avatar/original/';
			$path = str_replace('/', DS, $img_folder);
			$path = PATH_BASE.$path;
			
			$avatar = $fsFile -> uploadImage('avatar', $path ,2000000, '_'.time());
			if(!$avatar)
				return;
			// resize avatar : 50x50
			$path_resize = str_replace(DS.'original'.DS, DS.'resized'.DS, $path);
			if(!$fsFile ->resized_not_crop($path.$avatar, $path_resize.$avatar,50, 50))
				return false;
			return	$img_folder.$avatar;
		}
		
		function save_estore($user_id)
		{
			if(!$user_id)
			     return false;
			global $db;
			$username = FSInput::get("username");
			$cpn_name = FSInput::get("cpn_name");
			$estore_name = $cpn_name;
			
			$fsstring = FSFactory::getClass('FSString','');	
			$estore_alias = $fsstring -> stringStandart($cpn_name);	
			$estore_name_not_sign = $fsstring -> remove_viet_sign($cpn_name);
			
			$cpn_telephone = FSInput::get("cpn_telephone");
			$cpn_mobilephone = FSInput::get("cpn_mobilephone");
			$cpn_fax = FSInput::get("cpn_fax");
			$cpn_website = FSInput::get("cpn_website");
			$cpn_province = FSInput::get("province");
			$cpn_district = FSInput::get("district");
			$cpn_address = FSInput::get("cpn_address");
			$cpn_intro = strip_tags($_POST["cpn_intro"]);
			
			
			$time = date("Y-m-d H:i:s");
			$published = 0;
			$activated = 0;
			
			$sql = " INSERT INTO 
						fs_estores (user_id,`username`,estore_name,estore_alias,estore_name_not_sign,telephone,mobilephone,fax,website
						,created_time,edited_time,published,`activated`,`address`,`estore_intro`,`city_id`,`district_id`,`etemplate`)
						VALUES ('$user_id','$username','$cpn_name','$estore_alias','$estore_name_not_sign','$cpn_telephone','$cpn_mobilephone','$cpn_fax','$cpn_website',
						'$time','$time','$published','$activated','$cpn_address','$cpn_intro','$cpn_province','$cpn_district','default') 
					";
			
			$id = $db->insert($sql);
			
			return $id;
		}
		
		
		function edit_save()
		{
			global $db;
			$password = FSInput::get("password");
			if($password)
			{
				$password = md5($password);
				$sql_pwd  = "password = '$password' ,";
			}
			else
				$sql_pwd = "";
			$update="";	
			
			$full_name      =  FSInput::get("full_name");
			$full_name=( !empty($full_name))?"full_name = '$full_name'":"";
			$update=$full_name;
			
			$birth_day      =  FSInput::get("birth_day");
			$birth_month      =  FSInput::get("birth_month");
			$birth_year      =  FSInput::get("birth_year");
			if(!empty($birth_day) && !empty($birth_month) && !empty($birth_year)){
				$birthday = date("Y-m-d",mktime(0, 0, 0, $birth_month, $birth_day, $birth_year));
			}
			$birthday=( !empty($birthday))?"birthday = '$birthday'":"";
			$update=(!empty($birthday) && !empty($update))?"$update,$birthday":$update.$birthday;
			
			$address =  FSInput::get("address");
			$address=( !empty($address))?"address = '$address'":"";
			$update=(!empty($address) && !empty($update))?"$update,$address":$update.$address;
			
			$job =  FSInput::get("job");
			$job=( !empty($job))?"job = '$job'":"";
			$update=(!empty($job)  && !empty($update))?"$update,$job":$update.$job;
			
			$email      =  FSInput::get("email");
			$email=( !empty($email))?"email = '$email'":"";
			$update=(!empty($email) && !empty($update))?"$update,$email":$update.$email;
			
			$phone      =  FSInput::get("mobilephone");
			$phone=( !empty($phone))?"mobilephone = '$phone'":"";
			$update=(!empty($phone) && !empty($update))?"$update,$phone":$update.$phone;
			
			if(!empty($update)){
				$sql = " UPDATE  fs_members SET 
								".$update."
								
							WHERE username = 	'".$_SESSION['username']."' 
					";
				// $db->query($sql);
				$rows = $db->affected_rows($sql);
				if($rows)
				{
					return $rows;
				}
			}
			else{
				return false;
			}
		}
		/*
		 * check exist username
		 * Sim must active
		 * published == 1: OK.  not use
		 * published != 1: not OK
		 */
		function checkUsername($username)
		{
			global $db ;
			$username = FSInput::get("username");
			if(!$username )
			{
				Errors::setError("H&#227;y nh&#7853;p s&#7889; username");
				return false;
			}
			$sql = " SELECT count(*)
					FROM fs_members
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				Errors::setError("Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ tÃƒÂ¡Ã‚Â»Ã¢â‚¬Å“n tÃƒÂ¡Ã‚ÂºÃ‚Â¡i");
				return false;
			}
			return true;
			
		}
		
		/*
		 * function login 
		 */
		function login()
		{
			global $db;
			$username = FSInput::get('username');	
			$password = md5(FSInput::get('password'));

			$sql = " SELECT id, username, full_name,block, published 
					FROM fs_members
					WHERE username = '$username'
					 AND password = '$password' 
					 AND block <> 1
					 ";
			$db -> query($sql);
			return $db -> getObject();
		}
		/*
		/*
		 * function forget
		 */
		function forget()
		{
			global $db;
			$email = FSInput::get('email');	
			if(!$email)
				return false;
			$sql = " SELECT email, username, id ,full_name
					FROM fs_members
					WHERE email = '$email'
					 ";
			$db -> query($sql);
			return $db -> getObject();
		}
		
		function resetPass($userid)
		{
			$fstring = FSFactory::getClass('FSString','','../');
			$newpass =  $fstring->generateRandomString(8);
			$newpass_encode = md5($newpass);
			global $db;
			$sql = " UPDATE  fs_members SET 
						password = '$newpass_encode'
						WHERE 
						id = $userid
				";
			//$db->query($sql);
			$rows = $db->affected_rows($sql);
			if(!$rows)
			{
				return false;
			}
			return $newpass;
		}
		
	 /* save building */
        function save_changepass()
		{
			global $db;
            $text_pass_new = FSInput::get("text_pass_new");
            if(!$text_pass_new)
                return false;
                
            $username = $_SESSION['username'];
            
            $password_old_buid = md5(FSInput::get("text_pass_old"));
            $password_new_buid = md5(FSInput::get("text_pass_new"));
  	       
            $sql= "UPDATE fs_members SET password='".$password_new_buid."'  WHERE `username`='".$username."' and password='".$password_old_buid."'";
            
            // $db->query($sql);
			$rows = $db->affected_rows($sql);
			return $rows;
		
        }
        
        /*
         * check duplicate email
         */
		function check_change_pass(){
			global $db ;
			$password_old_buid = FSInput::get("text_pass_old");
			if(!$password_old_buid)
				return false;
			$password_old_buid = md5($password_old_buid);
			
			$username = $_SESSION['username'];
			$sql = "SELECT count(*) as count FROM fs_members
				WHERE `username` = '".$username."'
						ANd `password` = '$password_old_buid' ";
			
			// $db->query($sql);
			$rs =  $db->getResult($sql);
			return $rs;
		}
		
		/*
		 * check old pass
		 * 
		 */
		function checkOldpass($old_pass)
		{
			global $db ;
			$username = $_SESSION['username'];
			$old_pass = md5($old_pass);
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
						AND password   = '$old_pass'
					";
			$db -> query($sql);
			$count =  $db->getResult();
			if(!$count)
			{
				return false;
			}
			return true;
		}
		/*
		 * check exist email and identify card.
		 */
		function checkExistUsers()
		{
			global $db ;
			$email      =  FSInput::get("email");
			$username      =  FSInput::get("username");
			if(!$email ||  !$username)
			{
				Errors::setError("BÃƒÂ¡Ã‚ÂºÃ‚Â¡n phÃƒÂ¡Ã‚ÂºÃ‚Â£i nhÃƒÂ¡Ã‚ÂºÃ‚Â­p Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚ÂºÃ‚Â§y Ãƒâ€žÃ¢â‚¬ËœÃƒÂ¡Ã‚Â»Ã‚Â§ thÃƒÆ’Ã‚Â´ng tin vÃƒÆ’Ã‚Â o trÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã¯Â¿Â½ng email vÃƒÆ’Ã‚Â  username");
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
						OR username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count)
			{
				Errors::setError("Email hoÃƒÂ¡Ã‚ÂºÃ‚Â·c Username Ãƒâ€žÃ¢â‚¬ËœÃƒÆ’Ã‚Â£ Ãƒâ€žÃ¢â‚¬ËœÃƒâ€ Ã‚Â°ÃƒÂ¡Ã‚Â»Ã‚Â£c sÃƒÂ¡Ã‚Â»Ã‚Â­ dÃƒÂ¡Ã‚Â»Ã‚Â¥ng");
				return false;
			}
			return true;
			
		}
		
		/*
		 * check exist email .
		 */
		function check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Email này đã có người sử dụng');
				return false;
			}
			return true;
		}
		/*
		 * check exist username .
		 */
		function check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				$this -> alert_error('Username này đã có người sử dụng');
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_username()
		{
			global $db ;
			$username      =  FSInput::get("username");
			if(!$username){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						username = '$username'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
		function ajax_check_exits_email()
		{
			global $db ;
			$email      =  FSInput::get("email");
			if(!$email){
				return false;
			}
			$sql = " SELECT count(*) 
					FROM fs_members 
					WHERE 
						email = '$email'
					";
			$db -> query($sql);
			$count = $db->getResult();
			if($count){
				return false;
			}
			return true;
		}
		
		/************ LOGGED **************/
		/*
		 * get menu have group = usermenu
		 */
		function getMenusUser()
		{
			global $db ;
			$sql = " SELECT id,link, name, images 
					FROM fs_menus_items
					WHERE published  = 1
						AND group_id = 5 
					ORDER BY ordering";
			// $db->query($sql);
			return $db->getObjectList($sql);
		}
		
		
		/********** DETAIL INFORMATION OF MEMBER **/
		function getMember()
		{
			global $db ;
			$username = $_SESSION['username'];
			$sql = " SELECT username, id, email, district_id, full_name, sex, city_id,birthday, mobilephone, telephone,job,address
					FROM fs_members
					WHERE username  = '$username' ";
			// $db->query($sql);
			return $db->getObject($sql);
		}
		function getProvince($provinceid)
		{
			global $db ;
			$sql = " SELECT name
					FROM fs_cities
					WHERE id   = '$provinceid' ";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		function getDistrict($districtid)
		{
			global $db ;
			$sql = " SELECT name
					FROM fs_districts
					WHERE id   = '$districtid'";
			// $db->query($sql);
			return $db->getResult($sql);
		}
		
		function getUserByUsername($username)
		{
			global $db ;
			
			$sql = " SELECT full_name, id FROM fs_members WHERE username = '$username'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		function getUserById($userid)
		{
			global $db ;
			
			$sql = " SELECT full_name,id 
					FROM fs_members WHERE id = '$userid'";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * get estore_id,estore_name
		 * After login
		 */
		function get_estore($username){
			if(!$username)
				return ;
			global $db ;
			$sql = " SELECT id,is_buy FROM fs_estores 
						WHERE username = '$username'
						AND activated  = 1
						AND published = 1";
					// $db->query($sql);
			return $db->getObject($sql);
		}
		
		/*
		 * Createa folder when create user
		 */
		function create_folder_upload($id){
			$fsFile = FSFactory::getClass('FsFiles','');
			$path = PATH_BASE.'uploaded'.DS.'estores'.DS.$id;
			return $fsFile->create_folder($path);
		}
		
		
		function send_mail_activated_user($name,$username,$password_de,$activated_code,$user_id,$email){
//			include 'libraries/errors.php';
			// send Mail()
			$mailer = FSFactory::getClass('Email','mail');
			$global = new FsGlobal();
			$admin_name = $global -> getConfig('admin_name');
			$admin_email = $global -> getConfig('admin_email');
			$mail_register_subject = $global -> getConfig('mail_register_subject');
			$mail_register_body = $global -> getConfig('mail_register_body');

//			global $config;
			// config to user gmail
			
			$mailer -> isHTML(true);
//			$mailer -> IsSMTP();
			$mailer -> setSender(array($admin_email,$admin_name));
			$mailer -> AddAddress($email,$name);
			$mailer -> AddBCC('phamhuy@finalstyle.com','pham van huy');
			$mailer -> setSubject($mail_register_subject);
			$url_activated = FSRoute::_('index.php?module=users&view=users&task=activate&code='.$activated_code.'&id='.$user_id);
			// body
			$body = $mail_register_body;
			$body = str_replace('{name}', $name, $body);
			$body = str_replace('{username}', $username, $body);
			$body = str_replace('{password}', $password_de, $body);
			$body = str_replace('{url_activated}', $url_activated, $body);
			
//			$body .= '<div>Chào bạn!</div>';
//			$body .= '<br/>';
//			$body .= '<div>Cảm ơn bạn đã đăng ký làm thành viên của <a href="'.URL_ROOT.'">'.URL_ROOT.'</a>';
//			$body .= '<div>Tài khoản của bạn đã được tạo và bạn phải kích hoạt trước khi sử dụng.</div>';
//			$body .= '<div>Để <strong>kích hoạt</strong> bạn hãy click vào link dưới đây:</div>';
			
//			$body .= '<a href="'.$url_activated.'">'.$url_activated.'</a>';
//			$body .= '<br/><br/>';
//			$body .= '<div>Thông tin tài khoản của bạn:</div>';
//			$body .= '<div>Tài khoản: <strong>'.$username.'</strong></div>';
//			$body .= '<div>Mật khẩu: <strong>'.$password_de.'</strong></div>';
//			$body .= '<br/><br/>';
//			$body .= '<div>Chân thành cảm ơn!</div>';
//			$body .= '<div><img src="http://pandabooks.vn/images/logos/logo_panda.jpg" alt="Pandabooks.vn logo"></div>';
											
			$mailer -> setBody($body);
			
			if(!$mailer ->Send()){
				Errors::_('Có lỗi khi gửi mail');
				return false;
			}
			return true;
			
			//en
		}
	/*
		/*
		 * function forget
		 */
		function activate(){
			global $db;
			$code = FSInput::get('code');	
			$id = FSInput::get('id',0,'int');
			if(!$code || !$id)
				return false;
					
			$sql = " SELECT username,id,published
					FROM fs_members
					WHERE 
						id = '$id'
						 AND activated_code = '$code'
						 AND block <> 1
					 ";
			$db -> query($sql);
			$rs =  $db -> getObject();
			include 'libraries/errors.php';
			if(!$rs){
				Errors::_('Không kích hoạt tài khoản thành công');
				return false;
			}
			if($rs -> published){
				Errors::_('Tài khoản này đã kích hoạt từ trước.');
				return false;
			}
			$time = date("Y-m-d H:i:s");
			$row['published'] = 1;
			$row['published_time'] = $time;
			if(!$this -> _update($row,'fs_members',' id = "'.$id.'" AND activated_code = "'.$code.'" ')){
				Errors::_('Không kích hoạt tài khoản thành công.');
				return false;
			}
			return true;
		}	
			
		/* ==================================================
		 * ================== ADDRESS BOOK  =================
		  ==================================================*/
		function get_address_book_by_key(){
			$key = FSInput::get('key');
			if(!$key)
				return;
			$sql = "SELECT id,name,country_name,category_alias,alias
					FROM fs_address_book
					WHERE published = 1
					AND content_search like '%$key%'
					ORDER BY hits DESC,created_time DESC
					LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
		function get_address_book_properties(){
			$sql = "SELECT id,name,type
					FROM fs_address_book_property
					WHERE published = 1
					ORDER BY type ASC ,ordering ASC
					LIMIT 60	";	
			global $db ;
			// $db->query($sql);
			return $db->getObjectList($sql);
		} 
	}
	
?>