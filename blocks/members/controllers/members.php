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
      return;
    }

    $total_member_coin = $this->get_total_member_coin($user_member->id);
    $thong_ke_f1 = $this->GetArrayInfoF1($user_member->ref_code);
    $level = $user_member->level;
    $table_level = $model->get_records('', 'fs_members_group', '*', ' id asc');
    $rank_hientai = $this->get_current_rank($table_level, $level);
    $dieukien_lenrank = $this->get_next_rank($table_level, $level);
    $timeline = $this->calculate_timeline($level, $total_member_coin, $thong_ke_f1);

    include 'blocks/members/views/members/default.php';
  }

  function get_total_member_coin($user_id)
  {
    $model = new MembersBModelsMembers();
    $orderInfo = $model->get_records("user_id = '" . $user_id . "'", 'fs_order', 'member_coin');
    $total_member_coin = array_reduce($orderInfo, function ($carry, $item) {
      return $carry + $item->member_coin;
    }, 0);
    return $total_member_coin;
  }

  function get_current_rank($table_level, $level)
  {
    foreach ($table_level as $value) {
      if ($level == $value->level) {
        return $value;
      }
    }
    return [];
  }

  function get_next_rank($table_level, $level)
  {
    foreach ($table_level as $value) {
      if (($level + 1) == $value->level || $level == 6) {
        return $value;
      }
    }
    return [];
  }

  function calculate_timeline($level, $total_member_coin, $thong_ke_f1)
  {
    $timeline = 0;
    $tinhtheoF1 = 0;
    $tinhtheodanhso = 0;
    $limits = [3 => [50000000, 10, 40], 4 => [200000000, 50, 60], 5 => [1000000000, 200, 80]];
    
    if ($level == 1) {
      $timeline = ($total_member_coin / 99) * 20;
    } elseif ($level == 2) {
      $timeline = 20 + ($total_member_coin / 300) * 20;
    } elseif ($level >= 3 && $level <= 5) {
      list($price_limit, $count_limit, $base_timeline) = $limits[$level];
      $thong_ke_f1['total_price_order_F1'] = min($thong_ke_f1['total_price_order_F1'], $price_limit);
      $thong_ke_f1['count_total_daily'] = min($thong_ke_f1['count_total_daily'], $count_limit);
      $tinhtheoF1 = ($thong_ke_f1['total_price_order_F1'] / $price_limit) * 20;
      $tinhtheodanhso = ($thong_ke_f1['count_total_daily'] / $count_limit) * 20;
      $timeline = $base_timeline + max($tinhtheoF1, $tinhtheodanhso);
    } elseif ($level == 6) {
      $timeline = 100;
    }

    return $timeline;
  }
  public function GetArrayInfoF1($ref_code)
  {
    $model = new MembersBModelsMembers();
    $members = $model->get_records('ref_by = ' . $ref_code, 'fs_members', 'id,level'); // lấy thông tin danh sách F1
    $array_id = [
      'array_ids' => [],
      'string_ids' => '',
      'count_ids' => '',
      'count_total_daily' => '',
      'total_price_order_F1' => '',
    ];

    $total_daily = 0;

    if (!empty($members)) {
      $string_ids = [];
      foreach ($members as $item) {
        $array_id['array_ids'][] =  $item->id; // lấy danh sách id theo mảng
        $string_ids[] = $item->id;
        if ($item->level >= 2) //tính tổng F1 của member có bao nhiêu đại lý
        {
          $total_daily += 1;
        }
      }
      $array_id['string_ids'] = implode(',', $string_ids);  // lấy danh sách id theo chuỗi
      $array_id['count_ids'] = count($members);  // đếm số lượng f1
      $array_id['count_total_daily'] = $total_daily;
    }

    if (!empty($array_id['string_ids'])) { // lấy tổng doanh số nhóm 
      $total = $model->get_records("user_id IN (" . $array_id['string_ids'] . ")", 'fs_order', 'SUM(total_before) AS total_before_sum');
      if (!empty($total) && isset($total[0]->total_before_sum)) {
        $array_id['total_price_order_F1'] = $total[0]->total_before_sum;
      } else {
        $array_id['total_price_order_F1'] = 0;
      }
    }

    return $array_id;
  }
}
