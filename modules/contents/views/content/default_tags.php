<!--	TAGS		-->
<?php 
//if($category -> display_tags){
	if($data -> tags){
		$arr_tags = explode(',',$data -> tags);
		$total_tags = count($arr_tags);
		if($total_tags){
			//echo '<div class="news_tags row-item">';
			echo '<h4 class="tags_title fl-left">'.FSText::_('Tags').': </h4>';
			//echo '<div class="content_tags">';
			for($i = 0; $i < $total_tags; $i ++){
				$item = trim($arr_tags[$i]);
				if($item){
					//if($i > 0)
						//echo '<font>, </font>';
					$link = FSRoute::_("index.php?module=search&view=search&keyword=".str_replace(' ','+',$item)."&Itemid=9");
					echo '<h3 class="item-tag fl-left"><a href="'.$link.'" title="'.$item .'">'.$item.'</a></h3>';
				}
			}
			//echo "<div class='clear'></div>";
			//echo '</div>';
			//echo '</div>';
			//echo "<div class='clear'></div>";
		}
	}
//}
?>
<!--	end TAGS		-->	