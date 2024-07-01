<?php
/*
 * Huy write
 */

class FSDate
{
	function timeDiff($t1, $t2){
	   if($t1 > $t2){
	      $time1 = $t2;
	      $time2 = $t1;
	   }
	   else
	   {
	      $time1 = $t1;
	      $time2 = $t2;
	   }
	   $diff = array(
	      'years' => 0,
	      'months' => 0,
	      'weeks' => 0,
	      'days' => 0,
	      'hours' => 0,
	      'minutes' => 0,
	      'seconds' =>0
	   );
	   foreach(array('years','months','weeks','days','hours','minutes','seconds')   as $unit)
	   {
	      while(TRUE)
	      {
	         $next = strtotime("+1 $unit", $time1);
	         if($next < $time2)
	         {
	            $time1 = $next;
	            $diff[$unit]++;
	         }
	         else
	         {
	            break;
	         }
	      }
	   }
	   return($diff);
	}
	function time_diff_to_hours($started_time, $end_time){
	  	$diff = strtotime($end_time) - strtotime($started_time);
		$diff = $diff/3600;
		return $diff;
	}	
 	/*
   * Input: date 
   * Output: 12h30 ngày 2-3-2011
   */
  	function format_date($str_time){
	  	 $time = strtotime($str_time);
	  	 $hour = date('H',$time);
	  	 $minute = date('i',$time);
	  	 $date = date('d-m-Y',$time);
	  	 return $hour.'h'.$minute.' ngày '.$date;
  	}
  	
function fsdate($date='',$type = 0 )
 {
 	// format 'D, d/m/Y, H:i '
 	if($date)
 	{
 		$Day = date('D',strtotime($date));
 		$str_date =  date('d/m/Y, H:i',strtotime($date));
 	}
 	else
 	{
 		$Day = date('D');
 		$str_date =  date('d/m/Y, H:i');
 	}
 	$Day = strtoupper($Day);
 	$str = "";
	//TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
 	switch ($Day) {
 		case 'MON':
 			$str .= "Th&#7913; 2";	
 			break;
 		case 'TUE':
 			$str .= "Th&#7913; 3";	
 			break;
 		case 'WED':
 			$str .= "Th&#7913; 4";	
 			break;
 		case 'THU':
 			$str .= "Th&#7913; 5";	
 			break;
 		case 'FRI':
 			$str .= "Th&#7913; 6";	
 			break;
 		case 'SAT':
 			$str .= "Th&#7913; 7";	
 			break;
 		case 'SUN':
 			$str .= "Ch&#7911; nh&#7853;t ";	
 			break;
 	}
 	
 	if($type == 1){
 		$str .= ", ng&#224;y ".$str_date;
 	} else {
 		$str .= ", ".$str_date;
 		$str .= " GMT+7";
 	}
 	
 	return $str;
 }
 function show_datetime($date='')
 	{
	 	// format 'D, d/m/Y, H:i '
	 	if($date)
	 	{
	 		$Day = date('D',strtotime($date));
	 		$str_date =  date('d/m/Y, H:i A',strtotime($date));
	 	}
	 	else
	 	{
	 		$Day = date('D');
	 		$str_date =  date('d/m/Y, H:i A');
	 	}
	 	$Day = strtoupper($Day);
	 	$str = "";
		//TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
	 	switch ($Day) {
	 		case 'MON':
	 			$str .= "Th&#7913; 2";	
	 			break;
	 		case 'TUE':
	 			$str .= "Th&#7913; 3";	
	 			break;
	 		case 'WED':
	 			$str .= "Th&#7913; 4";	
	 			break;
	 		case 'THU':
	 			$str .= "Th&#7913; 5";	
	 			break;
	 		case 'FRI':
	 			$str .= "Th&#7913; 6";	
	 			break;
	 		case 'SAT':
	 			$str .= "Th&#7913; 7";	
	 			break;
	 		case 'SUN':
	 			$str .= "Ch&#7911; nh&#7853;t ";	
	 			break;
	 	}
	 	$str .= ", ".$str_date;
	 	return $str;
 	}
}