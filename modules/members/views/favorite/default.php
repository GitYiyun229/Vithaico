<?php
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('favorite', 'modules/members/assets/css');
$tmpl->addScript('favorite', 'modules/members/assets/js');
?>

<div class="container">
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Sản phẩm yêu thích') ?></div>
            <div class="page-content page-favorite">
                <?php if (empty($list)) { ?>
                    <p class="fw-medium fs-6">Quý khách chưa có sản phẩm yêu thích nào!</p>
                <?php } else { ?>
                    <div class="section-more d-flex flex-wrap">
                        <?php foreach ($list as $item) { ?>
                            <?php echo $this->layoutProductItem($item) ?>
                        <?php } ?>
                    </div>
                    <div class="loading-scroll w-100" items="<?php echo $productFavoriteId ?>" limit="<?php echo $this->model->limit ?>" total-current="<?php echo count($list) ?>" total="<?php echo @$total ?>" page="1"></div>
                <?php } ?>    
            </div>
        </div>
    </div>
</div>
