<?php
$tmpl->addStylesheet('category', 'modules/products/assets/css');
$tmpl->addScript('category', 'modules/products/assets/js');
$tmpl->addStylesheet('default', 'blocks/product_categories/assets/css');
// print_r($getSort);
?>
<div class="section-banner">
    <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '3', 'style' => 'default']); ?>
</div>

<div class="section-menu">
    <div class="container">
        <?php echo $tmpl->load_direct_blocks('product_categories', ['style' => 'menu']); ?>
    </div>
</div>
<div class="container">
    <form action="<?php echo $canonical ?>" method="GET" class="page-products-category">
        <div class="section-main">
            <div class="section-filter d-flex flex-wrap align-items-center justify-content-between mb-4">
                <div class="title_cat">
                    <p><?= $cat->name ?></p>
                </div>
                <div class="select-menu position-relative">
                    <span>
                        <?= FSText::_('Sắp xếp theo') ?>
                    </span>
                    <div class="select">
                        <div>
                            <?php foreach ($arrSort as $i => $item) { ?>
                                <span><?= $active = $i == $getSort ? $item : ''; ?></span>
                            <?php } ?>
                        </div>
                        <i class="fas fa-angle-down"></i>
                    </div>
                    <div class="options-list position-absolute">
                        <?php foreach ($arrSort as $i => $item) {
                            $active = $i == $getSort ? 'active' : '';
                        ?>
                            <div class="filter-div">
                                <a class="filter-sort position-relative option <?php echo $active ?>" data="<?php echo $i ?>">
                                    <?php echo $item ?>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="list-products_grid mb-4">
                <?php foreach ($products as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>
            <?php if ($pagination) {
                echo $pagination->showPagination(6);
            }
            ?>

            <!-- <div class="section-item loading-scroll w-100" category="<?php echo $cat->id ?>" limit="<?php echo $this->model->limit ?>" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div> -->
        </div>

        <input type="hidden" name="sort" value="<?php echo $getSort ?>">
        <input type="hidden" name="filter" value="<?php echo $getFilter ?>">
        <input type="hidden" name="price" value="<?php echo $getPrice ?>">
    </form>
</div>