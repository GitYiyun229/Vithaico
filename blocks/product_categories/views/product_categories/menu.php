<?php foreach ($list as $item) {
    $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
?>
    <a href="<?php echo $link ?>" title="<?php echo $item->name ?>" class="ps-3 pe-3 d-flex align-items-center w-100 gap-2 position-relative">
        <?php if ($item->level > 0) { ?>
            <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'resized')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
        <?php } else { ?>
            <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'small')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
        <?php } ?>
        <?php echo $item->name ?>
    </a>
<?php } ?>
