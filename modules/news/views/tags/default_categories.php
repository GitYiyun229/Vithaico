<?php if ($total_news_list) {
    for ($i = 0; $i < $total_news_list; $i++) {
        $news = $news_list[$i];
        $link_news = FSRoute::_('index.php?module=news&view=news&ccode='.$news->alias);
        $images_first = URL_ROOT . str_replace('/original/', '/large/', $news->image);
        $images = URL_ROOT . str_replace('/original/', '/resize/', $news->image);
        ?>

        <div class="col-sm-12 item-full">
            <div class="item-news item-news-tags">
                <div class="row">
                    <a class="item-images col-sm-4" href="<?php echo $link_news ?>">
                        <img data-src="<?php echo $images ?>" alt='<?php echo $news->title; ?>'>
                    </a>
                    <div class="col-sm-8">
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
                </div>
            </div>
        </div>
    <?php }
} ?>