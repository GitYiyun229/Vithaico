<?php
/**
 * @author ndson
 * @category controller
 */
class UsersControllersGoogle extends FSControllers{
    function __construct(){
    	$model = $this -> model;
        parent::__construct();
	}
    
    function google_login(){ 
    	$model = $this -> model;
        $strHTML = '';
        require(PATH_BASE.'libraries'.DS.'google-api-php'.DS.'config.php');
        //$redirect_uri = URL_ROOT.'oauth2callback1';
        $client = new Google_Client();
        $client->setClientId($client_id);
        $client->setClientSecret($client_secret);
        $client->setRedirectUri($redirect_uri);
        $client->setScopes('email');
        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']);
            $_SESSION['access_token']  = $client->getAccessToken();          
            $access_token = json_decode($_SESSION['access_token']);
            //$client->refreshToken($access_token->refresh_token);
            $token_url = 'https://www.googleapis.com/oauth2/v1/userinfo?alt=json&access_token='.$access_token->access_token;
            $token_data = file_get_contents($token_url);
            $guser = json_decode($token_data);
            if (!empty($guser)){            	 
            	 $data = $model->check_exits_email($guser->email);
				if ($data){
				    $model->loginMailOnly($guser->email);
					$return['error'] 	= true;
					$return['url']		=  URL_ROOT;                           
                    $return['msg']		=  "Bạn đã đăng nhập thành công";
					$strHTML  = '<script type="text/javascript">';
					$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
					$strHTML .= '	window.close();';
					$strHTML .= '</script>';
				}else{
                    $row['full_name'] = $guser->name;
                    $row['email'] = $guser->email;
                    $row['username'] = $guser->email;
                    $row['password'] = '123456';
//                    $row['type'] = '2';
					$id = $model->insertUser($row);
					if($id){
                        $model->_update(array('code' => 'CVN'.str_pad($id, 6, "0", STR_PAD_LEFT) ,'published' => 1),'fs_members',' id = '.$id.' ');
                        $model->loginMailOnly($guser->email);
						$return['error'] 	= true;
						$return['url']		=  URL_ROOT;
						$return['msg']		=  "Lưu Thành viên thành công";
						$strHTML  = '<script type="text/javascript">';
						$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
						$strHTML .= '	window.close();';
						$strHTML .= '</script>';
					}//end: if($id)
				}//end: if ($data)
            }else{
            	 echo "kk";
      			  die;
        
                unset($_SESSION['access_token']);
            }//end: if (!empty($guser))
        }//end: if (isset($_GET['code']))
        if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
            /* $client->setAccessToken($_SESSION['access_token']);
            unset($_SESSION['access_token']);
            $this->google_login(); */
            unset($_SESSION['access_token']);
        } else {
            $authUrl = $client->createAuthUrl();
            $strHTML  = '<script type="text/javascript">';
			$strHTML .= '	top.location.href="'.$authUrl.'"';
			$strHTML .= '</script>';
        }
        echo $strHTML;
    }
    
} 
?>