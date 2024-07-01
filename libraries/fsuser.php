<?php

/**
 * @author ndson207@gmail.com
 * @copyright 2014
 */
class FSUser
{
    /**
     * Thời gian lưu cookie
     * Int
     */
    var $remTime = 2592000; //1 tháng

    /**
     * Tên được lưu cookie
     * String
     */
    var $remCookieName = 'fsSaveUserPass';

    /**
     * Domain
     * String
     */
    var $remCookieDomain = '';

    /**
     * Tên được lưu session
     * String
     */
    var $sessionVariable = 'userSessionValueID';

    /**
     * Kiểu mã hóa pas, md5,sha1
     */
    var $passMethod = 'md5';

    /**
     * ID của user
     * Int
     */
    var $userID;

    /**
     * Toàn bộ thông tin người dùng
     * Object
     */
    var $userInfo;

    /**
     * Bảng User
     * String
     */
    var $tbStore = 'fs_members';

    /**
     * Hiển thị thông báo lỗi
     * Boolean
     */
    var $displayErrors = true;
    /**
     * Hiển thị thông báo lỗi
     * Boolean 0 = cookie
     */
    var $SaveMethod  = 0;         // Cach luu
    var $UserID_var = 0;

    function __construct()
    {

        if (!isset($_SESSION)) 
            session_start();

        if (!empty($this->sessionVariable))
            if ($this->SaveMethod) {
                $this->UserID_var = @$_SESSION[$this->sessionVariable];
            } else {
                $this->UserID_var  = @$_COOKIE[$this->sessionVariable];
            }

        $this->remCookieDomain = $this->remCookieDomain == '' ? $_SERVER['HTTP_HOST'] : $this->remCookieDomain;


        if (!empty($this->UserID_var)) {
            $this->loadUser($this->UserID_var);
        }

        //Maybe there is a cookie?
        if (isset($_COOKIE[$this->remCookieName]) && !$this->is_loaded()) {
            $u = unserialize(base64_decode($_COOKIE[$this->remCookieName]));
           
            $this->login($u['uname'], $u['password']);
        }
    }

    /**
     * Đăng nhập
     * @param string $uname
     * @param string $password
     * @param bool $loadUser
     * @return bool
     */
    function login($uname, $password, $remember = false, $loadUser = true)
    { 
        global $db;
        $uname    = $this->escape($uname);
        $password = $originalPassword = $this->escape($password);
        switch (strtolower($this->passMethod)) {
            case 'sha1':
                $password = "SHA1('$password')";
                break;
            case 'md5':
                $password = "MD5('$password')";
                break;
            case 'nothing':
                $password = "'$password'";
        }
        $sql = "SELECT * FROM `" . $this->tbStore . "` 
    	            WHERE (`email` = '$uname' OR `telephone` = '$uname') AND `password` = $password LIMIT 1";
        
        $db->query($sql);
        $user = $db->getObject();

        if (!$user)
            return false;

        if ($loadUser) {
            $this->userInfo = $user;
            $this->userID = $user->id;
            if ($this->SaveMethod)
                $_SESSION[$this->sessionVariable] = $this->userID;
            else
                setcookie($this->sessionVariable, $this->userID, time() + $this->remTime);

            if ($remember) {
                $cookie = base64_encode(serialize(array('uname' => $uname, 'password' => $originalPassword)));
                setcookie($this->remCookieName, $cookie, time() + $this->remTime, '/');
            }
        }
        
        return $user;
    }

    public function loginUser($user)
    {
        if ($user) {
            $this->userInfo = $user;
            $this->userID = $user->id;
            if ($this->SaveMethod)
                $_SESSION[$this->sessionVariable] = $this->userID;
            else
                setcookie($this->sessionVariable, $this->userID, time() + $this->remTime);

            return $user;
        }

        return false;
    }

    function loginMailOnly($email)
    {
        global $db;
        $sql = "SELECT * FROM `" . $this->tbStore . "` 
    	            WHERE `email` = '$email' and block <> 1 LIMIT 1";
        $db->query($sql);
        $user = $db->getObject();
        if (!$user)
            return false;
        else {
            $this->userInfo = $user;
            $this->userID = $user->id;
            if ($this->SaveMethod)
                $_SESSION[$this->sessionVariable] = $this->userID;
            else
                setcookie($this->sessionVariable, $this->userID, time() + $this->remTime);
        }
        return $user;
    }

    /**
     * Thoát
     * param string $redirectTo
     * @return bool
     */
    function logouts($redirectTo = URL_ROOT)
    {
        setcookie($this->remCookieName, '', -1, '/');
        setcookie($this->sessionVariable, '', -1, '/');
      
        $_SESSION[$this->sessionVariable] = 0;
        $this->userInfo = '';
        $this->UserID_var = 0;
        $this->userID = 0; 
       
        if ($redirectTo != '' && !headers_sent()) {
            header('Location: ' . $redirectTo);
            exit; //To ensure security
        }
    }

    function checkExitsEmail($email)
    {
        global $db;
        $query = "SELECT * FROM `" . $this->tbStore . "` WHERE `email` = '$email' ";
        $db->query($query);
        $user = $db->getObject();
        if ($user)
            return true;
        return false;
    }

    function checkExitsUsername($username)
    {
        global $db;
        $query = "SELECT * FROM `" . $this->tbStore . "` WHERE `username` = '$username' ";
        $db->query($query);
        $user = $db->getObject();
        if ($user)
            return true;
        return false;
    }

    function checkExitsMobileVerify($mobile)
    {
        global $db;
        $db->query("SELECT * FROM `" . $this->tbStore . "` WHERE `telephone` = '$mobile' ");
        $user = $db->getObject();
        if ($user)
            return true;
        return false;
    }

    /**
     * Thêm tài khoản: 'database field' => 'value'
     * @param array $data
     * @return int
     */
    function insertUser($data)
    {
        global $db;
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
        switch (strtolower($this->passMethod)) {
            case 'sha1':
                $password = "SHA1('" . $data['password'] . "')";
                break;
            case 'md5':
                $password = "MD5('" . $data['password'] . "')";
                break;
            case 'nothing':
                $password = $data[$this->tbFields['pass']];
        }
        foreach ($data as $k => $v) $data[$k] = "'" . $this->escape($v) . "'";
        $data['password'] = $password;
        $db->query("INSERT INTO `" . $this->tbStore . "` (`" . implode('`, `', array_keys($data)) . "`) VALUES (" . implode(", ", $data) . ")");
        $id = $db->insert();
        return $id;
    }

    /**
     * Thêm tài khoản: 'database field' => 'value'
     * @param array $data
     * @return int
     */
    function updateUser($data, $user_id = 0)
    {
        global $db;
        if (!is_array($data)) $this->error('Data is not an array', __LINE__);
        switch (strtolower($this->passMethod)) {
            case 'sha1':
                $password = SHA1(@$data['password']);
                break;
            case 'md5':
                $password = MD5(@$data['password']);
                break;
            case 'nothing':
                $password = @$data['password'];
                break;
        }
        if (@$data['password'])
            $data['password'] = @$password;

        $strUpdate = "published = '1'";
        foreach ($data as $k => $v)
            $strUpdate .= "," . $k . "='" . $this->escape($v) . "'";
        if ($this->userID)
            $user_id = $this->userID;
        $query = " UPDATE " . $this->tbStore . " SET " . $strUpdate . " 
                   WHERE id = " . $user_id . "
        ";
        //        print_r($query);die;
        $db->query($query);
        $id = $db->affected_rows();
        return $id;
    }

    /**
     * Lấy thông tin của user đã đăng nhập
     * @access private
     * @param string $userID
     * @return bool
     */
    private function loadUser($userID)
    {
        global $db;
        $sql = "SELECT * FROM `" . $this->tbStore . "` WHERE `id` = '" . $this->escape($userID) . "' LIMIT 1";
        
        $res = $db->query($sql);
        $user = $db->getObject();
        if (!$user)
            return false;

        $this->userInfo = $user;
        $this->userID = $user->id;

        if ($this->SaveMethod)
            $_SESSION[$this->sessionVariable] = $this->userID;
        else
            savecookie($this->sessionVariable, $this->userID, time() + $this->remTime);

        return true;
    }

    /**
     * Kiểm tra đã đăng nhập chưa?
     * @ return bool
     */
    function is_loaded()
    {
        return empty($this->userID) ? false : true;
    }

    /**
     * Produces the result of addslashes() with more safety
     * @access private
     * @param string $str
     * @return string
     */
    function escape($str)
    {
        $str = $str;
        return $str;
    }

    /**
     * Error holder for the class
     * @access private
     * @param string $error
     * @param int $line
     * @param bool $die
     * @return bool
     */
    function error($error, $line = '', $die = false)
    {
        if ($this->displayErrors)
            echo '<b>Error: </b>' . $error . '<br /><b>Line: </b>' . ($line == '' ? 'Unknown' : $line) . '<br />';
        if ($die) exit;
        return false;
    }
}
