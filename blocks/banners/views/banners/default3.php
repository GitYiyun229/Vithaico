<?php global $tmpl;
$tmpl->addStylesheet('default', 'blocks/banners/assets/css');


?>
<?php foreach ($list as $item) {
    $src = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
    $str = explode(" ", $item->name);

?>
    <div class="item ">
        <img class="img-fluid position-relative img-banner" alt="<?php echo $item->name; ?>" src="<?php echo $src ?>">
        <div class="info-banner position-absolute">
            <div class="name-banner">
                <?php foreach ($str as $s) { ?>
                    <span><?= $s ?></span>
                <?php } ?>
            </div>
            <div class="content-banner">
                <?= $item->content ?>
            </div>
            <div class="btn-banner">
                <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>">Gia nhập ngay
                    <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M3 16.6667C4.94649 14.6021 7.58918 13.3333 10.5 13.3333C13.4108 13.3333 16.0535 14.6021 18 16.6667M14.25 6.25C14.25 8.32107 12.5711 10 10.5 10C8.42893 10 6.75 8.32107 6.75 6.25C6.75 4.17893 8.42893 2.5 10.5 2.5C12.5711 2.5 14.25 4.17893 14.25 6.25Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

<?php } ?>