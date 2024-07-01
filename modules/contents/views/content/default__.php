<?php
global $tmpl;
//$tmpl->addStylesheet('flickity', 'modules/contents/assets/css');
$tmpl->addStylesheet('slick', 'modules/contents/assets/css');
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');
//$tmpl->addScript('flickity.pkgd.min', 'modules/contents/assets/js');
$tmpl->addScript('slick.min', 'modules/contents/assets/js');
$tmpl->addScript('default', 'modules/contents/assets/js');

?>
<main>
    <div class="container">
        <div class="breadcrumbs">
            <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
        </div>

        <div class="main-content" id="main_content">
            <?php echo $data->content ?>
        </div>
    </div>
    </div>
</main>