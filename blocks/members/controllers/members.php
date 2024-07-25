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
    $benefits = $dieukien_lenrank->member_benefits - $rank_hientai->member_benefits . '%';
    $image = URL_ROOT . ($dieukien_lenrank->image);
    $condition_1 = $dieukien_lenrank->condition_1;
    $condition_2 = $dieukien_lenrank->condition_2;
    $condition_3 = format_money($dieukien_lenrank->condition_3, 'đ');
    $current_image = URL_ROOT . ($rank_hientai->image);

    $due_time_month = $user_member->due_time_month;
    $level = $user_member->level;
    $total_member_coin = $this->get_total_member_coin($user_member->id);

    $interval = $this->interval($total_member_coin, $user_member->end_time, $level, $due_time_month);

    if ($level == 1 && $total_member_coin == 0) {
      $start_time = date('Y-m-d H:i:s', strtotime($user_member->end_time));
    } else {
      $start_time = date('Y-m-d H:i:s', strtotime($due_time_month));
    }



    include 'blocks/members/views/members/default.php';
  }

  function interval($total_member_coin, $end_time, $level, $due_time_month)
  {
    if ($level == 1 && $total_member_coin == 0) {
      $start_time = date('Y-m-d H:i:s', strtotime($end_time));
    } else {
      $start_time = date('Y-m-d H:i:s', strtotime($due_time_month));
    }

    $now = new DateTime();
    $start_date = new DateTime($start_time);
 
    if ($start_date > $now) {
      // $start_date lớn hơn $now, trả về số ngày dương
      $interval = $now->diff($start_date)->days;
    } else {
      // $start_date nhỏ hơn $now, trả về số ngày âm
      $interval = - ($start_date->diff($now)->days);
    }
    return $interval;
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

  function calculateMemberCheckToMonth($id)
  {
    $model = new MembersBModelsMembers();
    $total_month = $model->get_record("user_id = '" . $id . "' AND due_time_month >= DATE_FORMAT(NOW() ,'%Y-%m-01') AND due_time_month < DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'), INTERVAL 1 MONTH ) ", 'fs_order', 'SUM(total_before) AS total_before_sum');
    if ($total_month && $total_month->total_before_sum >= 2600000) {
      return true;
    }
    return false;
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

    $array_id = [
      'array_ids' => [],
      'string_ids' => '',
      'count_ids' => 0,
      'count_total_daily' => 0,
      'total_price_order_F1' => 0,
    ];

    if (!empty($ref_code)) {
      $members = $model->get_records('ref_by = ' . $ref_code, 'fs_members', 'id,level');
      if (!empty($members)) {
        $string_ids = [];
        foreach ($members as $item) {
          $array_id['array_ids'][] =  $item->id;
          $string_ids[] = $item->id;
          if ($item->level >= 2) {
            $array_id['count_total_daily'] += 1;
          }
        }
        $array_id['string_ids'] = implode(',', $string_ids);
        $array_id['count_ids'] = count($members);

        $total = $model->get_records("user_id IN (" . $array_id['string_ids'] . ")", 'fs_order', 'SUM(total_before) AS total_before_sum');
        if (!empty($total) && isset($total[0]->total_before_sum)) {
          $array_id['total_price_order_F1'] = $total[0]->total_before_sum;
        }
      }
    }
    return $array_id;
  }
}
