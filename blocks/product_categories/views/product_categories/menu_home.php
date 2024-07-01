<?php
global $tmpl, $user, $config;
$Itemid = FSInput::get('Itemid', 16, 'int');
$tmpl->addStylesheet('default', 'blocks/product_categories/assets/css');
$tmpl->addScript('default', 'blocks/product_categories/assets/js');
?>
<div class="container d-flex align-items-center justify-content-between position-relative menu--tagets" id="menu-header-usa">
    <ul class="mega-menu d-flex align-items-center justify-content-between list-unstyled">
        <li class="mega-links-item menu-hearder-0 menu-header-top" data-id="0">
            <a class="ps-3 pe-3 d-flex align-items-center w-100 gap-2 position-relative">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M2.5 10H17.5M2.5 5H17.5M2.5 15H12.5" stroke="#3B3B3B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                <p class="menu-name"><?= FSText::_('Tất cả') ?> </p>
            </a>
        </li>
        <?php foreach ($list as $item) {
            $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
        ?>
            <?php if ($item->level == 0) { ?>
                <li class="mega-links-item menu-hearder-<?= $item->id ?> menu-header-top" data-id="<?= $item->id ?>">
                    <a href="<?php echo $link ?>" title="<?php echo $item->name ?>" class="ps-3 pe-3 d-flex align-items-center w-100 gap-2 position-relative">
                        <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'small')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
                        <p class="menu-name"><?php echo $item->name ?></p>
                    </a>
                </li> <?php } ?>
        <?php } ?>
    </ul>
    <div class="menu-hover position-absolute " id="menu-hover">
        <div class="menu-hover-item d-flex">
            <div class="menu">
                <div class="taget-menu menu0-0" data-id="0">
                    <a href="#" class="link-href-menu  mega-links-item menu0-0 d-grid  align-items-center justify-content-between" data-id="0">
                        <p>
                            <?php echo FSText::_('Tất cả') ?>
                        </p>
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.45496 9.96004L7.71496 6.70004C8.09996 6.31504 8.09996 5.68504 7.71496 5.30004L4.45496 2.04004" stroke="#3B3B3B" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </a>
                </div>
                <?php foreach ($list as $item) {
                    $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
                ?>
                    <?php if ($item->level == 0) { ?>
                        <div class="taget-menu menu0-<?= $item->id ?>" data-id="<?= $item->id ?>">
                            <a href="<?= $link ?>" class="link-href-menu  mega-links-item menu0-<?= $item->id ?> d-grid  align-items-center justify-content-between" data-id="<?= $item->id ?>">
                                <p>
                                    <?php echo $item->name ?>
                                </p>
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M4.45496 9.96004L7.71496 6.70004C8.09996 6.31504 8.09996 5.68504 7.71496 5.30004L4.45496 2.04004" stroke="#3B3B3B" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="menu--all  mega-links-item" id="menu--all" data-id="0">
                <?php foreach ($list as $item) {
                    $link = FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
                ?>
                    <?php if ($item->level > 0) { ?>
                        <div class="box-menu-hover menu-item-<?= $item->parent_id ?> menu-item-0" data-id="<?= $item->parent_id ?>">
                            <a class="item-menu d-grid mega-links-item " href="<?= $link ?>">
                                <img src="<?php echo URL_ROOT . image_replace_webp($item->icon, 'resized')  ?>" alt="<?php echo $item->name ?>" class="img-fluid img-icon">
                                <p class="mega-links-item" data-id="<?= $item->id ?>"><?php echo $item->name ?></p>
                            </a>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>