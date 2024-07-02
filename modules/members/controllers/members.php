<?php

class MembersControllersMembers extends FSControllers
{
    protected $table = 'fs_members';
    public $userImage = 'images/user-icon.svg';
    public $userLevel = [
        'Đồng', 
        'Bạc', 
        'Vàng', 
        'Bạch kim'
    ];

    public function __construct()
    {
        parent::__construct();

        global $user;
        if (!$user->userID)
            setRedirect(URL_ROOT, FSText::_('Vui lòng đăng nhập!'), 'error');

        $userImage = $user->userInfo->image ?: 'images/user-customer-icon.svg';
        
        $this->userImage = $userImage;
    }

    public static function auth($method)
    { 
        if (($_SERVER['REQUEST_METHOD'] != $method) || !csrf::authenticationToken()) {
            echo json_encode([
                'error' => true,
                'message' => "Lỗi", 
            ]);
            exit();
        }
        
        return true;
    }
}
