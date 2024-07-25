<?php
require_once PATH_BASE . 'vendor/autoload.php';

class MembersControllersGoogle extends FSControllers
{

    function display()
    { 
        global $user;
        $clientID = '27425545905-0f2k6hekem9l4te8hsn96g0j02593ctc.apps.googleusercontent.com';
        $clientSecret = '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';
        $redirectUri = FSRoute::_('index.php?module=members&view=google&raw=1');
        
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope('email');
        $client->addScope('profile');

        if (isset($_GET['code'])) {
            $client->authenticate($_GET['code']); 
            $token = $client->getAccessToken();
            $client->setAccessToken($token);

            $service = new Google_Service_Oauth2($client);
            $userInfo = $service->userinfo->get();
        
            $email = $userInfo->getEmail();
            $userID = $userInfo->getId();

            $data = $this->model->get_record("email = '$email' OR google_id = $userID", "fs_members");

            if (!$data) {
                $row = [
                    'created_time' => date('Y-m-d H:i:s'),
                    'google_id' => $userID,
                    'email' => $email,
                    'full_name' => explode('@', $email)[0],
                    'type' => 1,
                    'published' => 1,
                    'block' => 0
                ];
                $id = $this->model->_add($row, "fs_members"); 
                $data = $this->model->get_record("id = $id", "fs_members");
            }

            $user->loginUser($data); 

            unset($_SESSION['access_token']);

            setRedirect(URL_ROOT, "Đăng nhập thành công!", 'success');
        } else {
            $authUrl = $client->createAuthUrl();
            header('Location: ' . $authUrl);
        }
    }
}
