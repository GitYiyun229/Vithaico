<?php global $tmpl;
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');

$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('banner', 'blocks/banners/assets/js');
?>

<div class="banner-carousel banner-<?php echo $style ?> owl-carousel owl-theme">
	<?php foreach ($list as $item) { 
		$src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
		?>
		<div class="item">
			<a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name; ?>">
				<img class="img-fluid" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
			</a>
		</div>
	<?php } ?>
</div>
