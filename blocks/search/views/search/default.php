<?php

$tmpl->addStylesheet('search', 'blocks/search/assets/css');
$tmpl->addScript("jquery.autocomplete", "blocks/search/assets/js");
$tmpl->addScript("search", "blocks/search/assets/js");

// $link = FSRoute::_('index.php?module=products&view=search');
$keyword = FSInput::get('keyword', '');
?>

<form action="" id="site-search" method="POST" class="position-relative d-flex align-items-center">
	<input type="text" class="form-control" name="keyword" placeholder="<?php echo $keyword ?: FSText::_('Tìm kiếm sản phẩm') ?>" required>
	<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M18.3333 18.3333L16.6666 16.6667M17.5 9.58333C17.5 13.9556 13.9555 17.5 9.58329 17.5C5.21104 17.5 1.66663 13.9556 1.66663 9.58333C1.66663 5.21108 5.21104 1.66667 9.58329 1.66667C13.9555 1.66667 17.5 5.21108 17.5 9.58333Z" stroke="#004692" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
	</svg>

	<!-- <button class="btn fw-semibold" type="submit"><?php echo FSText::_('Tìm kiếm') ?></button> -->
	<?php echo csrf::displayToken() ?>
	<input type="hidden" name="module" value="products">
	<input type="hidden" name="view" value="search">
	<input type="hidden" name="task" value="validate">
</form>