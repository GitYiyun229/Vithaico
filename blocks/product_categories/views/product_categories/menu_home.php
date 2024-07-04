<?php
global $tmpl;
$tmpl->addStylesheet('default_home', 'blocks/product_categories/assets/css');

?>
<div class="list_product_categories">
    <?php foreach ($list as $item) {
        $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
    ?>
        <div class="box_item">
            <a href="<?php echo $link ?>" title="<?php echo $item->name ?>" class="item">
                <?php if ($item->level > 0) { ?>
                    <img src="<?php echo URL_ROOT . image_replace_webp($item->image, 'original')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
                <?php } else { ?>
                    <img src="<?php echo URL_ROOT . image_replace_webp($item->image, 'original')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
                <?php } ?>
                <p class="item_name"> <?php echo $item->name ?></p>
            </a>
        </div>
    <?php } ?>
</div>