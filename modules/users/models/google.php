<?php
class UsersModelsGoogle extends FSModels{
    function __construct()
    {   
        parent::__construct();
        $this->table_name = 'fs_members';
    }
//    function check_exits_email($email)
//    {
//        global $db;
//
//        if (!$email)
//        {
//            return false;
//        }
//        $sql = 'SELECT *
//    			FROM '.$this->table_name.' 
//    			WHERE email = \''.$email.'\'';
//        $db->query($sql);
//		return $db->getObject();
//    }
    function save($user)
    {
        global $db;
        //$file = $this->upload_avatar();
        $row = array();
        $row['email'] = $user->email;
//        $row['password'] = md5(FSInput::get("rpassword"));
//        if (!$row['email'] && !FSInput::get("rpassword"))
//            return;
        $row['full_name'] = $user->last_name.' '.$user->first_name;
        $row['sex'] = $user->gender;
        $row['published'] = 1;
        $row['face'] = 1;
        $row['created_time'] = date("Y-m-d H:i:s");
        $id = $this->_add($row, $this->table_name);
        return $id;
    }
    
    function edit()
    {
        global $db;
        
        $file = $this->upload_avatar();
        
        $row = array();
        $row['full_name'] = FSInput::get("full_name");
        $row['avatar'] = $file;
        //$row['lastname'] = FSInput::get("lastname");        
        $row['sex'] = FSInput::get("sex");
		$row['show_sex'] = FSInput::get("show_sex");
		$row['days'] = FSInput::get("days");
		$row['month'] = FSInput::get("month");
		$row['year'] = FSInput::get("year");
		$row['birthday'] = $row['days'].'/'.$row['month'].'/'.$row['year'];
		$row['show_birthday'] = FSInput::get("show_birthday");
		$row['city_id'] = FSInput::get("city_id");		
		$row['show_city'] = FSInput::get("show_city");		 
        $row['mobile'] = FSInput::get("mobile");
		
		$row['contactname'] = FSInput::get("contactname");
		$row['contactaddress'] = FSInput::get("contactaddress");
		$row['contactphone'] = FSInput::get("contactphone");
		$row['contactemail'] = FSInput::get("contactemail");
		$row['is_newsletter'] = FSInput::get("is_newsletter");		
        $row['published'] = 1;
        $fstring = FSFactory::getClass('FSString', '', '../');
        $id = $this->_update($row, $this->table_name, 'id='.$_SESSION['user_id']);
        return $id;
    }
    
    function checkExitsUsername()
    {
        global $db;
        if(isset($_SESSION['user_id'])) /* S?a th�ng tin */
            return true;
        $email = FSInput::get("email");
        if (!$email)
        {
            return false;
        }
        $sql = 'SELECT count(id) 
    			FROM  '.$this->table_name.'
                WHERE email = \''.$email.'\'';
        // $db->query($sql);
        $count = $db->getResult($sql);
        if ($count)
        {
            $this->alert_error('Tên đăng nhập này đã có người dùng');
            return false;
        }
        return true;
    }
    function check_exits_email($email)
    {
    	if(!$email)
    		return;
        global $db;
        $sql = 'SELECT count(id) 
    			FROM  '.$this->table_name.'
                WHERE email = \''.$email.'\'';
        // $db->query($sql);
        $count = $db->getResult($sql);
        return $count;
    }
    
/**
    * Đăng nhập
    * @param string $uname
    * @param string $password
    * @param bool $loadUser
    * @return bool
    */
    function loginMailOnly($email, $remember = false, $loadUser = true){
        global $db;
    	$email    = get_magic_quotes_gpc()?stripslashes($email):$email;
    	 $sql = 'SELECT *
    			FROM  '.$this->table_name.'
                WHERE email = \''.$email.'\' AND block <> 1 ';
        // $db->query($sql);
        $user = $db -> getObject($sql);
        if(!$user)
        	return;
        $_SESSION['fullname'] = $user->full_name ;
		$_SESSION['username'] = $user->email ;
		$_SESSION['user_id'] = $user->id ;
        
    	return true;
    }
   
    
    /**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function insertUser($data){
        global $db;
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
        switch(strtolower($this->passMethod)){
            case 'sha1':
                $password = "SHA1('".$data['password']."')"; break;
            case 'md5' :
                $password = "MD5('".$data['password']."')";break;
            case 'nothing':
                $password = $data[$this->tbFields['pass']];
    	}
        $data['password'] = $password;
        $id = $this -> _add($data,$this->table_name,1);
        return $id;
    }
 	/**
    * Thêm tài khoản: 'database field' => 'value'
    * @param array $data
    * @return int
    */ 
    function updateUser($data, $user_id = 0){
        global $db;
        $row = array();
        $row[''] = 
        $strUpdate = "published = '1'";
        foreach ($data as $k => $v )
            $strUpdate .= ",".$k."='".$this->escape($v)."'";
        if($this->userID)
            $user_id = $this->userID;
        $db->query("UPDATE `".$this->tbStore.'` SET '.$strUpdate.' WHERE id = \''.$user_id.'\'');
        $id = $db->affected_rows();
        return $id;
    }
}
?>