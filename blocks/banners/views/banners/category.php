<?php global $tmpl;
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');

$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('category', 'blocks/banners/assets/js');
?>

<?php if (count($list) == 1) { ?>
    <?php foreach ($list as $item) { 
        $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
        ?>
        <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
            <img class="img-fluid" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
        </a>
    <?php } ?>
<?php } else if (count($list) == 2) { ?>
    <div class="owl-banner-item d-flex flex-wrap">
        <?php foreach ($list as $item) { 
            $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
            ?>
            <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
                <img class="img-fluid" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
            </a>
        <?php } ?>
    </div>
<?php } else { ?>
    <div class="owl-banner owl-carousel owl-theme">
        <?php foreach ($list as $item) { 
            $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
            ?>
            <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
                <img class="img-fluid" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
            </a>
        <?php } ?>  
    </div>
<?php } ?>    
