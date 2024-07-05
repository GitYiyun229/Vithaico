<?php
global $tmpl, $config;
$tmpl->addStylesheet('detail', 'modules/news/assets/css');
$tmpl->addScript('detail', 'modules/news/assets/js');
?>
<input id="news_id" type="hidden" value="<?php echo $data->id ?>">

<div class="container d-grid gap-5">
    <div class="grid_detail_new border-bottom">
        <div class="detail_new-left">
            <h2 class="title_new">
                <?php echo $data->title ?>
            </h2>
            <div class="created_share">
                <div class="created_catname">
                    <p class="created_time">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M10.666 10C10.566 10 10.464 9.97734 10.3687 9.93002L7.70203 8.59665C7.47602 8.48337 7.3334 8.25268 7.3334 7.99999V3.33342C7.3334 2.96545 7.63206 2.66679 8.00003 2.66679C8.368 2.66679 8.66666 2.96545 8.66666 3.33342V7.58799L10.9647 8.73734C11.294 8.90196 11.4273 9.30262 11.2627 9.63197C11.146 9.86534 10.9107 9.99994 10.666 9.99994L10.666 10ZM8 16C3.58857 16 0 12.4114 0 8C0 3.58857 3.58857 0 8 0C12.4114 0 16 3.58857 16 8C16 12.4114 12.4114 16 8 16ZM8 1.33343C4.324 1.33343 1.33343 4.324 1.33343 8C1.33343 11.676 4.324 14.6666 8 14.6666C11.676 14.6666 14.6666 11.676 14.6666 8C14.6666 4.324 11.676 1.33343 8 1.33343Z" fill="#A3A3A3" />
                        </svg>
                        <?php echo date('d/m-Y, H:i', strtotime($data->created_time)) . FSText::_(' (GMT+7)') ?>
                    </p>

                    <p class="cat_name">
                        <svg width="5" height="6" viewBox="0 0 5 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="2.5" cy="3" r="2.5" fill="#A3A3A3" />
                        </svg>
                        <?php echo $data->category_name ?>
                    </p>
                </div>
                <?php include('share_box.php') ?>
            </div>
            <div class="content_box">
                <?php echo $data->content ?>
            </div>
            <div class="created_share">
                <a href="<?php echo FSRoute::_('index.php?module=news&view=home') ?>" class="back_home_news">
                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="30" height="30" rx="15" fill="white" />
                        <path d="M17 19L13 15L17 11" stroke="black" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <?php echo FSText::_('Vể trang trước') ?>
                </a>
                <?php include('share_box.php') ?>
            </div>
        </div>
        <div class="block_right">
            <h3 class="h3_title_block">
                <?php echo FSText::_('Tin nổi bật') ?>
            </h3>
            <div class="list_new_small">
                <?php foreach ($list_hot_news as $item) {
                    $image = str_replace(['.jpg', '.png'], ['.webp', '.webp'], $item->image);
                    $image = str_replace('original/', 'small/', $image);
                ?>
                    <a href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id . '') ?>" class="item_new_small">
                        <div class="img_box">
                            <img src="<?php echo URL_ROOT . $image ?>" alt="">
                        </div>
                        <div>
                            <p class="title_new">
                                <?php echo $item->title ?>
                            </p>
                        </div>
                    </a>
                <?php } ?>
            </div>
            <h3 class="h3_title_block">
                <?php echo FSText::_('Tin khuyến mại') ?>
            </h3>
            <div class="list_new_small">
                <?php foreach ($list_promotion_news as $item) {
                    $image = str_replace(['.jpg', '.png'], ['.webp', '.webp'], $item->image);
                    $image = str_replace('original/', 'small/', $image);
                ?>
                    <a href="<?php echo FSRoute::_('index.php?module=news&view=news&code=' . $item->alias . '&id=' . $item->id . '') ?>" class="item_new_small">
                        <div class="img_box">
                            <img src="<?php echo URL_ROOT . $image ?>" alt="">
                        </div>
                        <div>
                            <p class="title_new">
                                <?php echo $item->title ?>
                            </p>
                        </div>
                    </a>
                <?php } ?>
            </div>

        </div>
    </div>
    <div class="grid_news_related ">
        <h2 class="h2_title_block">
            <?php echo FSText::_('Có thể bạn quan tâm') ?>
        </h2>
        <div class="list_grid_news">
            <?php foreach ($relate_news_list as $i => $item) { ?>
                <?php echo $tmpl->newItem($i + 1, $item) ?>
            <?php } ?>
        </div>
    </div>
</div>