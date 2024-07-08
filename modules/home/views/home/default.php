 <?php
    $tmpl->addStylesheet('slick', 'libraries/slick-js');
    // $tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
    // $tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
    $tmpl->addStylesheet('default', 'modules/home/assets/css');

    // $tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
    $tmpl->addScript('slick', 'libraries/slick-js');
    $tmpl->addScript('default', 'modules/home/assets/js');
    ?>
 <div class="page-home">
     <div class="d-flex gap-3 section-top mb-3">
         <div class="section-top-center">
             <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>
         </div>
     </div>
     <div class="container">
         <div class="section-top">

         </div>
     </div>
     <div class="section-mid sec-mar">
         <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '2', 'style' => 'default']); ?>
     </div>

     <div class=" section-product-categories sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Sản phẩm') ?></p>
             <h4 class="title-2 mb-3 mt-3"><?= FSText::_('Danh mục sản phẩm') ?></h4>
             <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu_home']); ?>
         </div>

     </div>

     <div class="section-feedback sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Cảm nhận') ?></p>
             <h4 class="title-2 mb-3 mt-3"><?= FSText::_('Hội viên nói về Vithaico') ?></h4>
         </div>

     </div>

     <div class="section-jdo sec-mar">

     </div>

     <div class="section-news sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Tin tức') ?></p>
             <h4 class="title-2 mb-3 mt-3"><?= FSText::_('Tin tức & Sự kiện') ?></h4>
             <?php if (!empty($list_hot_news)) { ?>
             <div class="mb-4 list_grid_news <?php echo count($list_hot_news) > 4 ? 'slider-hot-news ' : '' ?>">
                 <?php foreach ($list_hot_news as $i => $item) {
                            echo $tmpl->newItem($i + 1, $item);
                        } ?>
             </div>
             <?php } ?>

             <div class="show-all">
                 <a class="all" href="<?= FSRoute::_('index.php?module=news&view=home') ?>">Xem tất cả</a>
             </div>
         </div>
     </div>
 </div>