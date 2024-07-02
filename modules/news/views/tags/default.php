<?php
global $tmpl;
$tmpl->addStylesheet('home', 'modules/news/assets/css');
//	$tmpl -> addScript('cat','modules/news/assets/js');	
$total_news_list = count($news_list);
$Itemid = 7;
FSFactory::include_class('fsstring');
?>
    <div class="news-home clearfix row">
        <div class="list-news col-md-9">
            <?php include 'default_categories.php'; ?>
        </div>
        <div class="col-md-3">
            <div class="block_newslist">
                <?php echo $tmpl -> load_direct_blocks('newslist',array('style'=>'default','limit'=>'5')); ?>
            </div>
            <?php echo $tmpl -> load_direct_blocks('newslist',array('style'=>'sale','limit'=>'5')); ?>
        </div>
    </div>
<?php
if ($pagination) echo $pagination->showPagination(3);
?>