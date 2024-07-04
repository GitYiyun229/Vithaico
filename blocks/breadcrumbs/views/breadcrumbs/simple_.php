<?php
global $config, $tmpl, $module, $user;
$tmpl->addStylesheet('breadcrumbs_simple2', 'blocks/breadcrumbs/assets/css');
?>
<?php if (!empty($breadcrumbs)) { ?>
<?php if (count($breadcrumbs) == 1) { ?>
<nav aria-label="breadcrumb"
    style="--bs-breadcrumb-divider: url(&quot;data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 14 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.19751 11.62L9.00084 7.81666C9.45001 7.3675 9.45001 6.6325 9.00084 6.18333L5.19751 2.38' stroke='%23757575' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E&quot;)">
    <ol class="breadcrumb mb-3 justify-content-center flex-column" itemscope
        itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item text-center " itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" title="<?php echo $config['site_name'] ?>" href="<?php echo URL_ROOT ?>">
                <span class="text-uppercase" itemprop="name"><?php echo FSText::_('Trang chủ') ?> /</span>
            </a>
        </li>
        <?php foreach ($breadcrumbs as $i => $item) {
				?>
        <li class=" ztext-center <?php echo ($i + 1) == count($breadcrumbs) ? 'active' : '' ?>"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" title="<?php echo $item[0] ?>"
                href="<?php echo $item[1] ? $item[1] : 'javascript:void(0)' ?>">
                <span itemprop="name" class="text-uppercase fs-4">
                    <?php echo $item[0] ?>
                </span>
            </a>
        </li>
        <?php } ?>
    </ol>
</nav>
<?php } ?>
<?php if (count($breadcrumbs) == 2) { ?>
<nav aria-label="breadcrumb"
    style="--bs-breadcrumb-divider: url(&quot;data:image/svg+xml,%3Csvg width='14' height='14' viewBox='0 0 14 14' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.19751 11.62L9.00084 7.81666C9.45001 7.3675 9.45001 6.6325 9.00084 6.18333L5.19751 2.38' stroke='%23757575' stroke-miterlimit='10' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E&quot;)">
    <ol class="breadcrumb mb-3 justify-content-center flex-column" itemscope
        itemtype="https://schema.org/BreadcrumbList">
        <li class="breadcrumb-item text-center " itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" title="<?php echo $config['site_name'] ?>" href="<?php echo URL_ROOT ?>">
                <span class="text-uppercase" itemprop="name"><?php echo FSText::_('Trang chủ') ?> /</span>
            </a>
            <?php foreach ($breadcrumbs as $i => $item) { ?>
            <?php if ($i == 0) { ?>
            <a itemprop="item" title="<?php echo $item[0] ?>"
                href="<?php echo $item[1] ? $item[1] : 'javascript:void(0)' ?>">
                <span class="text-uppercase" itemprop="name"><?php echo $item[0] ?></span>
            </a>
            <?php  } ?>
            <?php  } ?>
        </li>
        <?php foreach ($breadcrumbs as $i => $item) { ?>
        <?php if ($i !== 0) { ?>
        <li class="breadcrumb-item text-center <?php echo ($i + 1) == count($breadcrumbs) ? 'active' : '' ?>"
            itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" title="<?php echo $item[0] ?>"
                href="<?php echo $item[1] ? $item[1] : 'javascript:void(0)' ?>">
                <span class="text-uppercase fs-4" itemprop="name"><?php echo $item[0] ?></span>
            </a>
        </li>
        <?php } ?>
        <?php } ?>
    </ol>
</nav>
<?php } ?>
<?php } ?>