<?php
global $tmpl;
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');

?>
<main>


    <div class="container">
        <div class="main-content" id="main_content">
            <div class="menu-left">
                <?php foreach ($cat as $item_cat) { ?>

                    <h2 class="h2_c" id="h2_c"><?php echo $item_cat->name ?></h2>
                    <ul class="list ul-grid">
                        <?php foreach ($item_cat->list_item as $item) { ?>
                            <li class="item <?php echo $item->id == $data->id ? 'active' : '' ?>">
                                <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code=' . $item->alias . '&id=' . $item->id) ?>">
                                    <?php echo $item->title ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>

            </div>
            <div class="content-right">
                <div class="top">
                    <h2><?php echo $data->title ?></h2>
                    <a class="see_more" href="#footer-top">Xem thêm</a>
                </div> 
                <div class="content__">
                    <?php echo $data->content ?>
                </div>
            </div>
        </div>
    </div>
</main>