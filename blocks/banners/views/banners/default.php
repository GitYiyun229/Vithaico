<?php foreach ($list as $item) {
    $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
    ?>
    <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
        <img class="img-fluid" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
    </a>
<?php } ?>    

 