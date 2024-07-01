<?php
require_once PATH_BASE . 'vendor/autoload.php';

class MembersControllersFacebook extends FSControllers
{ 
    public function display()
    { 
        $fb = new Facebook\Facebook([
            'app_id' => '362075553016626',
            'app_secret' => 'c0fe49b967b43e7bd969ba64f4a9ac5b',
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        // $permissions = ['email']; // Optional permissions
        $loginUrl = $helper->getLoginUrl(FSRoute::_("index.php?module=members&view=facebook&task=callback&raw=1"));
        
        header("Location: $loginUrl");
    }

    public function callback()
    {
        $fb = new Facebook\Facebook([
            'app_id' => '362075553016626',
            'app_secret' => 'c0fe49b967b43e7bd969ba64f4a9ac5b',
            'default_graph_version' => 'v2.10',
        ]);

        $helper = $fb->getRedirectLoginHelper();

        try {
            $accessToken = $helper->getAccessToken();
        } catch(\Facebook\Exceptions\FacebookResponseException $e) {
            // When Graph returns an error
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(\Facebook\Exceptions\FacebookSDKException $e) {
            // When validation fails or other local issues
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }
        
        if (!isset($accessToken)) {
            if ($helper->getError()) {
                header('HTTP/1.0 401 Unauthorized');
                echo "Error: " . $helper->getError() . "\n";
                echo "Error Code: " . $helper->getErrorCode() . "\n";
                echo "Error Reason: " . $helper->getErrorReason() . "\n";
                echo "Error Description: " . $helper->getErrorDescription() . "\n";
            } else {
                header('HTTP/1.0 400 Bad Request');
                echo 'Bad request';
            }
            exit;
        }

        $response = $fb->get('/me', $accessToken);
        $userFb = $response->getGraphUser();

        // Hiển thị thông tin người dùng
        // echo 'ID: ' . $userFb['id'] . '<br>';
        // echo 'Name: ' . $userFb['name'] . '<br>';
        // echo 'Email: ' . $userFb['email'] . '<br>';

        $email = @$userFb['email'];
        $userID = @$userFb['id']; 

        $sql = "facebook_id = $userID";
        if ($email) {
            $sql .= " OR email = '$email'";
        }

        global $user;

        $data = $this->model->get_record($sql, "fs_members");

        if (!$data) {
            $row = [
                'created_time' => date('Y-m-d H:i:s'),
                'facebook_id' => $userID,
                'email' => $email,
                'full_name' => $userFb['name'],
                'type' => 2,
                'published' => 1,
                'block' => 0
            ];
            $id = $this->model->_add($row, "fs_members"); 
            $data = $this->model->get_record("id = $id", "fs_members");
        }

        $user->loginUser($data); 
        setRedirect(URL_ROOT, "Đăng nhập thành công!", 'success');
    }
}
