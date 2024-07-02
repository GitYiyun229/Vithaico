<?php
/**
 * @author ndson
 * @category controller
 */
class UsersControllersFace extends FSControllers{
    function __construct(){
        parent::__construct();
	}
    
    function face_login(){
		$strHTML = '';
		// api habit
		$app_id = "556605527807172";
		$app_secret = "01a6b4a5b7efde39670cf5d40690a257";
		$my_url = FSRoute::_('index.php?module=users&view=face&task=face_login&Itemid=10');	
		
		// app ndson
		//$app_id = '696175593741822';
		//$app_secret = 'e788871f2652ba7be5d9497a85f401a5';
		$permission = "email,public_profile,user_friends";
		$code = isset($_REQUEST['code'])?$_REQUEST['code']:'';
		if(empty($code)) {			
			$strHTML = '';
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			$strHTML  = '<script type="text/javascript">';
			$strHTML .= '	top.location.href="'.$dialog_url.'"';
			$strHTML .= '</script>';
		}

		$S_State =isset($_SESSION['state'])?$_SESSION['state']:'';
		$R_State = isset($_REQUEST['state'])?$_REQUEST['state']:'';
		if( $S_State && ($S_State == $R_State)) {
    		$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='.$app_id.'&redirect_uri='.urlencode($my_url).'&client_secret='.$app_secret.'&code='.$code;
     		$response = file_get_contents($token_url);
     		$params = null;
     	 	parse_str($response, $params);
     		$_SESSION['access_token'] = $params['access_token'];
     		$graph_url = "https://graph.facebook.com/me?access_token=" . $params['access_token'];
	 		$data = file_get_contents($graph_url);
     		$user = json_decode($data);
			//testVar($user); echo 'xxx';die;
			if (!empty($user)){
				$data = $this->model->checkExitsEmail($user->email);
				//testVar($data); echo 'xxx';die;
				if ($data)
				{
				    // neu ton tai thi cho dang nhap luon, ko quan tam tk mail nay dang ky thu cong hay bang face
						$_SESSION['face'] = 1;
						$_SESSION['fullname'] = $data->full_name;
						$_SESSION['email'] 		= $data->email;
						$_SESSION['username'] = $data->email;
						$_SESSION['user_id'] = $data->id;
						$_SESSION['user'] = $data;
							$return['error'] 	= true;
							$return['url']		=  URL_ROOT;                           
                            $return['msg']		=  "Bạn đã đăng nhập thành công";
                               
                            
							$strHTML  = '<script type="text/javascript">';
							$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
							$strHTML .= '	window.close();';
							$strHTML .= '</script>';
							//echo $strHTML;
							$link = URL_ROOT;
							$msg = "Bạn đã đăng nhập thành công";
							setRedirect($link, $msg);
				}else{
						$id = $this->model->save($user);
						if($id){
							$_SESSION['face'] = 1;
							$_SESSION['fullname'] = $user->last_name.' '.$user->first_name;
							$_SESSION['username'] = $data->email;
							$_SESSION['email'] 		= $user->email;
							$_SESSION['user_id'] = $id;
                            $_SESSION['avatar'] = 'https://graph.facebook.com/'. $user->id .'/picture?type=square';
							$_SESSION['user'] = $user;
							$return['error'] 	= true;
							$return['url']		=  URL_ROOT;
							$return['msg']		=  "Lưu Thành viên thành công";
							$strHTML  = '<script type="text/javascript">';
							$strHTML .= '	window.opener.login_facebook('.json_encode($return).');';
							$strHTML .= '	window.close();';
							$strHTML .= '</script>';
						}
						$link = URL_ROOT;
                        //$msg = "Không lưu thành công";
						//setRedirect($link, $msg);
				}
			}else {
				$strHTML = '';
				$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
				$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
				$strHTML  = '<script type="text/javascript">';
				$strHTML .= 'top.location.href="'.$dialog_url.'"';
				$strHTML .= '</script>';
			}
   		}else {
    		$strHTML = '';
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			$dialog_url = "http://www.facebook.com/dialog/oauth?client_id=".$app_id."&redirect_uri=".urlencode($my_url) ."&scope=".$permission."&state=" . $_SESSION['state'];
			$strHTML  = '<script type="text/javascript">';
			$strHTML .= 'top.location.href="'.$dialog_url.'"';
			$strHTML .= '</script>';
   		}
		echo $strHTML;
		//require(PATH_BASE.'modules/'.$this->module.'/views/face/login-face.php');
     }
} 
?>