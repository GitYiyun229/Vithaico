<?php foreach ($list as $item) {
    $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
?>

    <div class="item-banner position-relative">
        <div class="mw-100"><img class="img-banner" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>"></div>
        <h3 class="name-banner position-absolute text-white text-uppercase fw-bold"><?= $item->name ?></h3>
    </div>

<?php } ?>