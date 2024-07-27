<?php
global $tmpl;
$tmpl->addStylesheet('default', 'blocks/product_categories/assets/css');
$cat_id = FSInput::get('id');
$icon = [
    $icon1 = [
        'img' => '../../assets/images/icon-nuoc.svg',
    ],
    $icon2 = [
        'img' => '../../assets/images/icon-thach.svg',
    ],
    $icon3 = [
        'img' => '../../assets/images/icon-keo-deo.svg',
    ]

];
?>
<div class="list_product_categories">
    <?php foreach ($list as $item) {
        $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id");

    ?>
    <div class="box_item">
        <a href="<?php echo $link ?>" title="<?php echo $item->name ?>"
            class="item <?php echo $cat_id == $item->id ? 'active' : '' ?>">

            <?php if ($item->level > 0) { ?>
            <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'smaller')  ?>"
                alt="<?php echo $item->name ?>" class="img-fluid img-icon">
            <?php } else { ?>
            <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'smaller')  ?>"
                alt="<?php echo $item->name ?>" class="img-fluid img-icon">
            <?php } ?>

            <p class="item_name"> <?php echo $item->name ?></p>
        </a>
    </div>
    <?php } ?>
</div>