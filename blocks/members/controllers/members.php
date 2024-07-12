<?php
include 'blocks/members/models/members.php';
class MembersBControllersMembers
{
  function __construct()
  {
  }
  function display($parameters, $title)
  {

    $model = new MembersBModelsMembers();
    global $tmpl, $user, $config;
    $user_member = $user->userInfo;
    if (!$user_member) {
      setRedirect(URL_ROOT, 'Đăng nhập để sử dụng tính năng này', 'error');
    }
    $level = $user_member->level;

    $table_level = $model->get_record('level=' . $level, 'fs_members_group', '*');
    print_r($table_level);

    // $time_add_point = date('d-m-Y', strtotime($user_member->time_add_point));
    // $group = $model->get_record('id = ' . $user_member->group_id . '', FSTable::_('fs_members_group'));
    // $groups = $model->get_records('published = 1', FSTable::_('fs_members_group'),'*','level ASC');
    // $time_maintain = $group->maintain;

    // $date = DateTime::createFromFormat('d-m-Y', $time_add_point);

    // // Kiểm tra nếu việc tạo đối tượng DateTime thành công
    // if ($date && $user_member->group_id != 41) {
    //     // Cộng thêm số ngày cần duy trì
    //     $date->add(new DateInterval('P' . $time_maintain . 'D'));

    //     // Định dạng lại ngày thành định dạng mong muốn
    //     $new_date = $date->format('d-m-Y');

    //     $today = new DateTime();

    //     // Tính toán số ngày còn lại
    //     $interval = $today->diff($date);
    // }

    // $level_mem = $user_member->level;
    // $next_level = $model->get_record('level = ' . ($level_mem + 1) . '', FSTable::_('fs_members_group'));
    // $max_level = $model->get_record('level = (SELECT MAX(level) FROM ' . FSTable::_('fs_members_group') . ')', FSTable::_('fs_members_group'));

    // $tich_luy_them = (($next_level->price) - ($user_member->money)) / 1000;
    // // print_r($level_mem);
    // $timeline = ceil((($user_member->money) / ($max_level->price)) * 100);

    // $currentDate = new DateTime();
    // $expirationDate = new DateTime($user_member->end_golfplus);

    // $interval_gp = $currentDate->diff($expirationDate);
    // $daysRemaining = $interval_gp->days;

    include 'blocks/members/views/members/default.php';
  }
}
