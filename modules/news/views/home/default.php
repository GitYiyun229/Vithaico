<?php
global $tmpl;
$tmpl->addStylesheet('home', 'modules/news/assets/css');
$class='img-2';
?>

<div class="section-banner">
    <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '4', 'style' => 'default']); ?>
</div>
<div class="section-cat-news">
    <div class="container list_cat_news">
        <a href="<?php echo FSRoute::_('index.php?module=news&view=home') ?>" class="item_cat_new active_cat">
            <img src="/images/cat-news0.svg" alt="" class="img-icon" width="32px" height="32px">
            <div class="item-name">
                <?php echo FSText::_('Tất cả') ?>
            </div>
        </a>
        <?php foreach ($list_cat as $item) { ?>
        <a href="<?php echo FSRoute::_('index.php?module=news&view=cat&ccode=' . $item->alias . '&id=' . $item->id . ' ') ?>"
            class="item_cat_new">
            <img src="<?php echo URL_ROOT . image_replace_webp($item->image, 'original')  ?>"
                alt="<?php echo $item->name ?>" class="img-fluid img-icon">
            <div class="item-name"><?php echo $item->name ?></div>
        </a>
        <?php } ?>
    </div>

</div>

<div class="container news_home_main">
    <div class="list_grid_news grid_hot_news">
        <?php foreach ($list_hot_news as $i => $item) {
            echo $tmpl->newItem($i, $item,$class);
        } ?>
    </div>
    <div class="top_h3_cat">
        <h3 class="h3_title_new h3_bor_right">
            <?php echo FSText::_('Mới nhất') ?>
        </h3>
        <div class="color-box">

        </div>
    </div>
    <div class="list_grid_news">
        <?php foreach ($list_news as $i => $item) { ?>
        <?php echo $tmpl->newItem($i + 1, $item,$class) ?>
        <?php } ?>
    </div>
</div>

<?php if ($pagination) echo $pagination->showPagination(3); ?>