<?php
$text_search = FSText::_('Điền từ...');
if(FSInput::get('keyword'))
    $text_search = FSInput::get('keyword');
?>
<?php $no_img = "this.src='/images/not_picture.png'"; ?>
    <div class="news_search_body center">
        <input type="text" class="form-control" name="news_search_mb" id="news_search_mb" placeholder="<?php echo $text_search ?>">
        <input type="hidden" id="link_news_search_mb" value="<?php echo FSRoute::_('index.php?module=news&view=search') ?>">
        <a href="javascript:void(0)" id="btn_search_news_mb" class="btn_search_news"><i class="fa fa-search"></i></a>
    </div>
<?php if ($total_news_list) {
    for ($i = 0; $i < $total_news_list; $i++) {
        $news = $news_list[$i];
        $link_news = FSRoute::_('index.php?module=news&view=news&ccode='.$news->alias);
        $images_first = URL_ROOT . str_replace('/original/', '/large/', $news->image);
        $images = URL_ROOT . str_replace('/original/', '/resize/', $news->image);
        $image_webp = str_replace(['.jpg', '.png'], ['.webp', '.webp'], $news->image);
        $image_webp_first = URL_ROOT . str_replace('/original/', '/large/', $image_webp);
        $image_webp = URL_ROOT . str_replace('/original/', '/resize/', $image_webp);
        ?>
        <?php if ($i == 0) { ?>
            <div class="col-sm-8 item-large">
                <a href="<?php echo $link_news ?>">
                    <picture>
                        <source srcset="<?php echo $image_webp_first ?>" type="image/webp">
                        <source srcset="<?php echo $images_first ?>">
                        <img class="img-responsive org_img" data-src="<?php echo $images_first; ?>" width="580" height="330" onerror="<?php echo $no_img ?>" alt="<?php echo $news->title; ?>"/>
                    </picture>
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
<!--                        <picture>-->
<!--                            <source srcset="--><?php //echo $image_webp ?><!--" type="image/webp">-->
<!--                            <source srcset="--><?php //echo $images ?><!--">-->
<!--                            <img class="img-responsive org_img" data-src="--><?php //echo $images; ?><!--" width="280" height="188" onerror="--><?php //echo $no_img ?><!--" alt="--><?php //echo $news->title; ?><!--"/>-->
<!--                        </picture>-->
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
        <?php } ?>
    <?php }
} ?>