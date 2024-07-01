<?php
global $tmpl;
//$tmpl->addStylesheet('cat', 'modules/news/assets/css');
//$tmpl->addScript('news_cat', 'modules/products/assets/js');
$tmpl->addStylesheet('home', 'modules/news/assets/css');

$keyword = FSInput::get('keyword');
$page = FSInput::get('page');
$title = 'Tìm kiếm với từ khóa "' . $keyword . '"';
if (!$page)
    $tmpl->addTitle($title);
else
    $tmpl->addTitle($title . ' - Trang ' . $page);

$total = count($list);

$str_meta_des = $keyword;

for ($i = 0; $i < $total; $i++) {
    $item = $list[$i];
    $str_meta_des .= ',' . $item->title;
}
$tmpl->addMetakey($str_meta_des);
$tmpl->addMetades($str_meta_des);
$Itemid = 6;
?>

    <h1 class="img-title-cat page_title" style="margin-bottom: 25px; margin-top: 0;">
        <span><?php echo FSText::_('Kết quả tìm kiếm cho từ khóa') . ' "' . $keyword . '"'; ?></span>
    </h1>
    <?php if($total_list) {?>
        <div class='news-home clearfix row'>
            <div class="list-news">
                <?php for ($i = 0; $i < $total_list; $i++) {
                    $news = $list[$i];
                    $link_news = FSRoute::_("index.php?module=news&view=news&id=" . $news->id . "&ccode=" . $news->alias . "");
                    $images_first = URL_ROOT . str_replace('/original/', '/large/', $news->image);
                    $images = URL_ROOT . str_replace('/original/', '/resize/', $news->image);
                    ?>
                    <?php if ($i == 0) { ?>
                        <div class="col-sm-8 item-large">
                            <a href="<?php echo $link_news ?>">
                                <img data-src="<?php echo $images_first ?>" alt='<?php echo $news->title; ?>'>
                            </a>
                            <a class="title title1" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
                            <div class="time-hits">
                        <span>
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <?php echo date('d/m/Y',strtotime($news->created_time)) ?>
                        </span>
                                <span>
                            <i class="fa fa-eye" aria-hidden="true"></i>
                                    <?php echo $news->hits ?>
                        </span>
                            </div>
                            <p class="summary"><?php echo getWord(100, $news->summary); ?></p>
                        </div>
                    <?php } ?>
                    <?php if ($i == 1) { ?>
                        <div class="col-sm-4">
                            <div class="item_right <?php if ($i==1){echo 'item_right1';} ?>">
                                <a href="<?php echo $link_news ?>">
                                    <img data-src="<?php echo $images ?>" alt='<?php echo $news->title; ?>'>
                                </a>
                                <a class="title title2" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
                                <div class="time-hits">
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo date('d/m/Y',strtotime($news->created_time)) ?>
                            </span>
                                    <span>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                        <?php echo $news->hits ?>
                            </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($i > 1 && $i <= 4) { ?>
                        <div class="col-sm-4">
                            <div class="item_right item-border">
                                <a class="title title3" href="<?php echo $link_news ?>"><?php echo $news->title; ?></a>
                                <div class="time-hits">
                            <span>
                                <i class="fa fa-calendar" aria-hidden="true"></i>
                                <?php echo date('d/m/Y',strtotime($news->created_time)) ?>
                            </span>
                                    <span>
                                <i class="fa fa-eye" aria-hidden="true"></i>
                                        <?php echo $news->hits ?>
                            </span>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if ($i > 4) { ?>
                        <div class="col-sm-12 item-full">
                            <div class="item-news">
                                <div class="row">
                                    <a class="item-images col-sm-4" href="<?php echo $link_news ?>">
                                        <img data-src="<?php echo $images ?>" alt='<?php echo $news->title; ?>'>
                                    </a>
                                    <div class="col-sm-8">
                                        <a class="title1 title<?php echo $news->category_id?>" href="<?php echo $link_news ?>">
                                            <?php echo $news->title; ?>
                                        </a>
                                        <div class="time-hits">
                                    <span>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <?php echo date('d/m/Y',strtotime($news->created_time)) ?>
                                    </span>
                                            <span>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                                <?php echo $news->hits ?>
                                    </span>
                                        </div>
                                        <p class="summary"><?php echo getWord(100, $news->summary); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <?php if ($pagination) echo $pagination->showPagination(3); ?>
    <?php } else {
        echo "Không có kết quả nào cho từ khóa <strong>" . $keyword . "</strong>";
    } ?>
