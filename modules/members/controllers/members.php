<?php

class MembersControllersMembers extends FSControllers
{
    protected $table = 'fs_members';
    public $userImage = '/modules/members/assets/images/no_image_user.svg.svg';
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
        $userInfo = $user->userInfo;
        $now = time();

        // if (isset($_SESSION['update_rank_log_time']) && $_SESSION['update_rank_log_time'] > $now) {

            // Process has been completed, skip or perform other actions
        // } else {
            if (isset($userInfo) && isset($userInfo->level) && isset($userInfo->id)) {
                $level_noempty = $this->model->get_record('level = ' . $userInfo->level . ' AND user_id =' . $userInfo->id, 'fs_update_rank_log', '*');
                if ($level_noempty) {
                    for ($i = 1; $i <= ($userInfo->level - 1); $i++) {
                        $levelempty = $this->model->get_record('level = ' . $i . ' AND user_id =' . $userInfo->id, 'fs_update_rank_log', '*');
                        if (empty($levelempty)) {
                            $row_empty = [
                                'level' => $i,
                                'user_id' => $userInfo->id,
                                'created_time' => $level_noempty->created_time,
                            ];
                            $this->model->_add($row_empty, 'fs_update_rank_log');
                        }
                        if ($i == 1 && strtotime($userInfo->created_time) < strtotime($level_noempty->created_time)) {
                            $row_empty = [
                                'created_time' => $userInfo->created_time,
                            ];
                            $this->model->_update($row_empty, 'fs_update_rank_log', 'level = 1 AND user_id =' . $userInfo->id . ' AND level =1');
                        }
                    }
                }
                // $_SESSION['update_rank_log_time'] = $now + (2 * 60 * 60);
            }
        // }
// print_r($_SESSION);

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
