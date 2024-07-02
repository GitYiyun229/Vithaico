<?php
	global $tmpl;
	$tmpl -> addStylesheet('home','modules/news/assets/css');
//	$tmpl -> addScript('cat','modules/news/assets/js');	
	$total_news_list = count($news_list);
    $Itemid = 7;
	FSFactory::include_class('fsstring');	
?>
<div class="news-home clearfix">
  <div class="list-news row">
      <?php include 'default_categories.php'; ?>
   </div>
</div>
<?php if($pagination) echo $pagination->showPagination(3); ?>