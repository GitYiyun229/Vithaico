<?php
$tmpl->addStylesheet('category', 'modules/products/assets/css');
$tmpl->addScript('category', 'modules/products/assets/js');
?>

<div class="container">
    <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
    <form action="<?php echo $canonical ?>" method="GET" class="page-products-category d-flex flex-wrap">

        <!-- <div class="section-filter">

            <a class="button_filter">
                <span><?php echo FSText::_('Bộ lọc') ?></span>
                <i class="fa-solid fa-filter"></i> 
            </a> 
            <div class="section-item bg-white ">
                <div class="filter-group">
                    <div class="filter-title"><?php echo $categoriesWrap[0]->name ?></div>
                    <?php foreach ($catList as $item) { ?>
                        <div class="filter-item pt-1 pb-1">
                            <a class="filter-action d-inline-block <?php echo $item->id == $cat->id ? 'filter-active' : '' ?>" href="<?php echo FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id") ?>" title="<?php echo $item->name ?>">
                                <?php echo $item->name ?>
                            </a>
                        </div>
                    <?php } ?>
                </div>

                <?php if (!empty($priceFilter)) { ?>
                    <div class="filter-group">
                        <div class="filter-title"><?php echo FSText::_('Giá') ?></div>
                        <?php foreach ($priceFilter as $i => $item) {
                            $checked = in_array("$item->min:$item->max", explode(',', $getPrice)) ? 'checked' : '';
                        ?>
                            <div class="form-check filter-item pt-1 pb-1 mb-0 <?php echo $i > 4 ? 'd-none' : '' ?>">
                                <input class="form-check-input filter-check" filter="price" type="checkbox" <?php echo $checked ?> value="<?php echo "$item->min:$item->max" ?>" id="price<?php echo $item->id ?>">
                                <label class="form-check-label" for="price<?php echo $item->id ?>">
                                    <?php echo $item->name ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if (count($priceFilter) > 5) { ?>
                            <div class="filter-item">
                                <a href="" class="filter-more fw-semibold">
                                    <?php echo FSText::_('Xem thêm') ?>
                                    <i class="fa-solid fa-angle-down"></i>
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>

                <?php if (!empty($catFilter)) { ?>
                    <?php foreach ($catFilter as $group) { ?>
                        <div class="filter-group">
                            <div class="filter-title"><?php echo $group->field_name_display ?></div>
                            <?php foreach ($group->filterItem as $i => $item) {
                                $checked = in_array($item->id, explode(',', $getFilter)) ? 'checked' : '';
                            ?>
                                <div class="form-check filter-item pt-1 pb-1 mb-0 <?php echo $i > 4 ? 'd-none' : '' ?>">
                                    <input class="form-check-input filter-check" filter="filter" type="checkbox" <?php echo $checked ?> value="<?php echo $item->id ?>" id="filter<?php echo $item->id ?>">
                                    <label class="form-check-label" for="filter<?php echo $item->id ?>">
                                        <?php echo $item->name ?>
                                    </label>
                                </div>
                            <?php } ?>

                            <?php if (count($group->filterItem) > 5) { ?>
                                <div class="filter-item">
                                    <a href="" class="filter-more fw-semibold">
                                        <?php echo FSText::_('Xem thêm') ?>
                                        <i class="fa-solid fa-angle-down"></i>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>

        </div> -->

        <div class="section-main">
            <div class="section-item section-padding bg-white">
                <h1 class="cat-h1"><?php echo $cat->name ?></h1>
                <div class="section-banner">
                    <?php echo $tmpl->load_direct_blocks('banners', ['product_category_id' => $cat->id, 'style' => 'category']); ?>
                </div>
            </div>

            <div class="section-item section-padding bg-white section-filter-sort d-flex align-items-center gap-4">
                <?php foreach ($arrSort as $i => $item) {
                    $active = $i == $getSort ? 'active' : '';
                ?>
                    <a class="filter-sort position-relative <?php echo $active ?>" data="<?php echo $i ?>">
                        <?php echo $item ?>
                    </a>
                <?php } ?>
            </div>

            <div class="section-item section-products d-flex flex-wrap">
                <?php foreach ($products as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>

            <div class="section-item loading-scroll w-100" category="<?php echo $cat->id ?>" limit="<?php echo $this->model->limit ?>" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
        </div>

        <input type="hidden" name="sort" value="<?php echo $getSort ?>">
        <input type="hidden" name="filter" value="<?php echo $getFilter ?>">
        <input type="hidden" name="price" value="<?php echo $getPrice ?>">
    </form>
</div>