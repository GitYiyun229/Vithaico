<?php foreach ($list as $item) {
    $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
    ?>
    <a class="item-banner position-relative" href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
        <img class="img-fluid img-banner" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
        <div class="name-banner position-absolute text-white text-uppercase fw-bold"><?= $item->name?></div>
    </a>
<?php } ?>    

 