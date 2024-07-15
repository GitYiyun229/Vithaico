<?php
global $tmpl;
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');
$cat_id = $cat->id;
?>
<main>
    <!-- <div class="breadcrumbs">
        <div class="container">
            <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
        </div>
    </div> -->
    <div class="section-banner">
        <?php if ($cat_id == 3) {
            echo $tmpl->load_direct_blocks('banners', ['category_id' => '7', 'style' => 'default']);
        } else {
            echo $tmpl->load_direct_blocks('banners', ['category_id' => '6', 'style' => 'default']);
        } ?>
    </div>

    <div class="container">
        <div class="main-content" id="main_content">
            <div class="menu-left">
                <div class="cat-group mb-3">
                    <h2 class="h2_c" id="h2_c"><?php echo $cat->name ?></h2>
                    <ul class="list ul-grid">
                        <?php foreach ($list as $i => $item) { ?>
                            <li class="item <?php echo $i == 0 ? 'active' : '' ?>">
                                <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=' . $item->alias . '&id=' . $item->id) ?>">
                                    <?php echo $item->title ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                    <?php foreach ($dataSame as $item_same) { ?>
                    <div class="cat-group mb-3 mt-4">
                        <h3 class="h2_c" id="h2_c"><?php echo $item_same->name ?></h3>
                        <ul class="list ul-grid">
                            <?php foreach ($item_same->list_item as $item) { ?>
                            <!-- </?php foreach ($list_item as $item) { ?> -->
                                <li class="item <?php echo $item->id == $data->id ? 'active' : '' ?>">
                                    <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=' . $item->alias . '&id=' . $item->id) ?>">
                                        <?php echo $item->title ?>
                                    </a>
                                </li>
                            <?php } ?>

                        </ul>
                    </div>

                    <?php } ?>
                </div>
            </div>
            <div class="content-right">
                <div class="top">
                    <h2><?php echo $list[0]->title ?></h2>
                </div>
                <div class="content__">
                    <?php echo $list[0]->content ?>
                </div>
            </div>
</main>