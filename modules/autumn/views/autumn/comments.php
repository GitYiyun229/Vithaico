<?php foreach ($list_parent as $item){ ?>
	<?php echo  display_comment_item($item,$list_children,0,3);?>
<?php }?>

<?php
function display_comment_item($item,$childdren,$level,$max_level = 2){
	$html='';
	$sub = ($level >= $max_level) ? ($max_level % 2) : ($level % 2);
	$html .= '<div class="cf comment-item comment-item-125  comment_level_0 comment_sub_0">';
//	$html .= '<img class="img-cm fl " src="'.URL_ROOT.'images/user.png">';
//	$html .= '<div class="star-detail fl" data-rating="'.ceil(($item ->rating)).'"></div>';
	$html .= '<div class="wrapper_comment_content fl ">
		<div class="info_cm "> 
			<span class="name ">';
	$html .= '<strong class="text_b_cm">'.$item -> name.'</strong>';
	$html .= '</div> 
	</div>
	<div class="comment_content ">'.$item->comment.'</div>
	<span class="rep">Trả lời</span> <i class="fa fa-circle" aria-hidden="true"></i> <span class="date"> '. date('d/m/Y',strtotime($item ->created_time)).' </span>

	<div class="wrapper-admin-rep">';
	if (count(@$childdren[$item->id])){
        foreach($childdren[$item->id] as $ad_cm){
            $html .= '<div class="wrapper_comment_content "> ';
            $html .= '<div class="info_cm "> ';
            $html .= '<span class="name "><span class="text_b_cm">'.$ad_cm ->name.'</span></span>';
            $html .= '<span class="date "> ('. date('d/m/Y',strtotime($ad_cm ->created_time)).')</span> ';
            $html .= '</div> ';
            $html .= '<div class="comment_content "> ';
            $html .=  $ad_cm -> comment;
            $html .= '</div>';
            $html .= '</div>';

		}}
	$html .= '</div>';
	$html .= '</div>';
	return $html;
}
?>

