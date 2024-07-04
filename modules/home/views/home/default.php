 <?php
    $tmpl->addStylesheet('slick', 'libraries/slick-js');
    $tmpl->addStylesheet('slick.theme', 'libraries/slick-js');
    $tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
    $tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
    $tmpl->addStylesheet('default', 'modules/home/assets/css');
    $tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
    $tmpl->addScript('default', 'modules/home/assets/js');
    $tmpl->addScript('slick.min', 'libraries/slick-js');
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
         <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '3', 'style' => 'default']); ?>
     </div>

     <div class="container section-product-categories sec-mar ">
         <p class="title-1"> <?= FSText::_('Sản phẩm') ?></p>
         <h4 class="title-2 mb-3 mt-3"><?= FSText::_('Danh mục sản phẩm') ?></h4>
         <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu_home']); ?>
     </div>

     <div class="section-feedback sec-mar">
         <p class="title-1"> <?= FSText::_('Cảm nhận') ?></p>
         <h4 class="title-2 mb-3 mt-3"><?= FSText::_('Hội viên nói về Vithaico') ?></h4>
     </div>


     <!--     <div class="section-product bg-white mb-3">
            <div class="mb-4 section-title fw-bold"><?php echo FSText::_('Gợi ý cho bạn') ?></div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="nav-0" role="tabpanel" aria-labelledby="nav-0-tab" tabindex="0">
                    <div class="products d-flex flex-wrap product-gap">
                        <?php foreach ($products as $item) { ?>
                            <?php echo $this->layoutProductItem($item) ?>
                        <?php } ?>
                    </div>
                    <div class="loading-scroll w-100" limit="20" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
                </div>

                <?php foreach ($categories as $item) { ?>
                    <div class="tab-pane fade" id="nav-<?php echo $item->id ?>" role="tabpanel" aria-labelledby="nav-<?php echo $item->id ?>-tab" tabindex="0">
                        <div class="d-flex flex-wrap product-gap">
                            <?php foreach ($item->products as $prd) { ?>
                                <?php echo $this->layoutProductItem($prd) ?>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div> -->