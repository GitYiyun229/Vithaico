<?php global $tmpl;
//$tmpl->addStylesheet('owl.carousel.min', 'libraries/jquery/owlcarousel/assets');
//$tmpl->addStylesheet('owl.theme.default.min', 'libraries/jquery/owlcarousel/assets');
//$tmpl->addScript('owl.carousel.min', 'libraries/jquery/owlcarousel');

$tmpl -> addStylesheet('banner','blocks/banners/assets/css');
$tmpl -> addScript('banner_home','blocks/banners/assets/js');
?>
<!--<script language="javascript" type="text/javascript"-->
<!--        src="--><?php //echo URL_ROOT ?><!--libraries/jquery/jquery-1.11.0.min.js"></script>-->
<div class=" block_<?php echo $style ?>">
    <div class="slide_s1 owl-carousel owl-theme" id="slide_s">
        <?php foreach ($list as $item) {
            if (IS_VERSION == 0) {
                $image = URL_ROOT . str_replace('original', 'banner_large', $item->image);
            } else {
                $image = URL_ROOT . str_replace('original', 'banner_large', $item->image_webp);


            }
            ?>
            <a href="<?php echo $item->link ?>" title="<?php echo $item->name ?>">
<!--                <div class="item">-->
                    <img src="<?php echo $image ?>"
                         alt="<?php echo $item->name; ?>" style="width: 377px; height: 185px;" class="img-responsive">
<!--                </div>-->
            </a>
        <?php } ?>
    </div>
</div>
	<div class="clear"></div>     	

 