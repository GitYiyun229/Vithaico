<?php
global $tmpl, $user, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default_home', 'blocks/product_categories/assets/css');
$tmpl->addScript('default', 'blocks/product_categories/assets/js');
?>
<div class="category_list container d-flex align-items-center justify-content-between position-relative">
    <?php foreach ($list as $item) {
        $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
    ?>
        <?php if ($item->level > 0) { ?>
            <div class="box-items">
                <a class="items d-grid" href="<?= $link?>">
                    <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'large')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
                    <p class="mega-links-item" data-id="<?= $item->id ?>"><?php echo $item->name ?></p>
                </a>
            </div>
        <?php } ?>
    <?php } ?>
</div>