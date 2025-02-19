 <?php
    $tmpl->addStylesheet('slick', 'libraries/slick-js');
    $tmpl->addStylesheet('default', 'modules/home/assets/css');
    $tmpl->addScript('slick', 'libraries/slick-js');
    $tmpl->addScript('default', 'modules/home/assets/js');
    $words = explode(" ", $content->title);
    // Tách chuỗi thành hai phần
    $word1 = implode(" ", array_slice($words, 0, ceil(count($words) / 2)));
    $word2 = implode(" ", array_slice($words, ceil(count($words) / 2)));
    ?>
 <div class="page-home">
     <div class="d-flex gap-3 section-top mb-3">
         <div class="section-top-center">
             <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>
         </div>
     </div>
     <div class="container sec-mar">
         <div class="section-description row align-items-center">
             <div class="col-6">
                 <img src="<?php echo URL_ROOT . $content->image ?>" alt="">
             </div>
             <div class="col-6 d-grid gap-4">
                 <div class="title text-uppercase">
                     <div class="title-first">
                         Giới thiệu
                     </div>
                     <h3 class="title-second fw-bold">
                         về <span>Vithaico</span>
                     </h3>
                 </div>
                 <div class="content"> <?php echo $content->summary ?></div>
                 <div class="show-more">
                     <a class="all" href="<?= FSRoute::_('index.php?module=contents&view=content&code=gioi-thieu-ve-vithaico-1-1&id=4') ?>">Tìm
                         hiểu thêm</a>
                 </div>
             </div>
         </div>
     </div>
     <div class="section-mid sec-mar">
         <div class="position-relative">
             <div class="banner">
                 <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '2', 'style' => 'default3']); ?>
             </div>
             <div class="container">
                 <div class="list-commit position-absolute d-grid">
                     <div class="commit-box ">
                         <div class="commit-img">
                             <img src="/images/home-commit1.svg" alt="">
                         </div>
                         <div class="commit-title"><?= FSText::_('CAM KẾT CHẤT LƯỢNG') ?></div>
                         <div class="commit-content"><?= FSText::_('Chúng tôi cam kết mang đến cho quý khách những sản phẩm chất lượng tốt nhất, đáp ứng đầy đủ các tiêu chuẩn về an toàn của sản phẩm.') ?></div>
                     </div>
                     <div class="commit-box">
                         <div class="commit-img">
                             <img src="/images/home-commit2.svg" alt="">
                         </div>
                         <div class="commit-title"><?= FSText::_('KHÔNG NGỪNG ĐỔI MỚI') ?></div>
                         <div class="commit-content"><?= FSText::_('Chúng tôi không ngừng đầu tư nâng cấp dây chuyền sản xuất, chất lượng sản phẩm để bắt kịp xu hướng sản phẩm và khẩu vị khách hàng.') ?></div>
                     </div>
                     <div class="commit-box">
                         <div class="commit-img">
                             <img src="/images/home-commit3.svg" alt="">
                         </div>
                         <div class="commit-title"><?= FSText::_('HÌNH ẢNH THƯƠNG HIỆU') ?></div>
                         <div class="commit-content"><?= FSText::_('Chúng tôi xây dựng hình ảnh công ty với chất lượng sản phẩm và uy tín đặt lên hàng đầu. Những điều này là thước đo để đánh giá thành công và vị trí của công ty trên thị trường.') ?></div>
                     </div>
                 </div>
             </div>

         </div>
     </div>

     <div class="section-product-categories sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Sản phẩm') ?></p>
             <h3 class="title-2 mb-3 mt-3"><?= FSText::_('Danh mục sản phẩm') ?></h3>
             <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu_home']); ?>
         </div>

     </div>

     <div class="section-feedback sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Cảm nhận') ?></p>
             <h3 class="title-2 mb-3 mt-3"><?= FSText::_('Hội viên nói về Vithaico') ?></h3>
             <div class="icon_feedback text-center mb-4">
                 <img src="/images/icon-feedback.svg" alt="">
             </div>
             <div class="list-feedback">
                 <div class="slider-for" id="animated-thumbnails">
                     <?php foreach ($contents_feedbacks as $item) { ?>
                         <div class="item">
                             <?php echo $item->content ?>
                         </div>
                     <?php } ?>
                 </div>
                 <div class="text-center mb-4">
                     <img src="/images/break.svg" alt="">
                 </div>
                 <div class="slider-nav">
                     <?php foreach (@$contents_feedbacks as $item) { ?>
                         <div class="item d-flex gap-3">
                             <div class="feeback-img">
                                 <img src="<?php echo URL_ROOT . $item->image ?>" alt="">
                             </div>
                             <div class="feedback-info">
                                 <div class="title fw-bold"><?php echo $item->title ?></div>
                                 <div class="summary fst-italic"><?= $item->summary ?></div>
                             </div>
                         </div>
                     <?php } ?>
                 </div>
             </div>
         </div>

     </div>

     <div class="container sec-mar">
         <div class="section-register row position-relative align-items-center ">
             <img src="<?php echo URL_ROOT . $content_register->image ?>" alt="" class="col-8">
             <div class="sec-content position-absolute end-0 col-6">
                 <div class="cat-title">
                     <?= $content_register->category_name ?>
                 </div>
                 <div class="title">
                     <?= $content_register->title ?>
                 </div>
                 <div class="summary">
                     <?= $content_register->summary ?>
                 </div>
                 <div class="content">
                     <?= $content_register->content ?>
                 </div>
                 <div class="show-more">
                     <a class="all" href="<?= FSRoute::_('index.php?module=members&view=user&task=register') ?>">
                         Đăng ký thành viên
                         <span class="ms-1">
                             <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <path d="M2.5 16.6667C4.44649 14.6021 7.08918 13.3333 10 13.3333C12.9108 13.3333 15.5535 14.6021 17.5 16.6667M13.75 6.25C13.75 8.32107 12.0711 10 10 10C7.92893 10 6.25 8.32107 6.25 6.25C6.25 4.17893 7.92893 2.5 10 2.5C12.0711 2.5 13.75 4.17893 13.75 6.25Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                             </svg>
                         </span>
                     </a>

                 </div>
             </div>
         </div>

     </div>

     <div class="section-news sec-mar">
         <div class="container">
             <p class="title-1"> <?= FSText::_('Tin tức') ?></p>
             <h3 class="title-2 mb-3 mt-3"><?= FSText::_('Tin tức & Sự kiện') ?></h3>
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