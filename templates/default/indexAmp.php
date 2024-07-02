<header id="amp-header">
    <div class='amp-container'>
        <div class="header-logo fl-left row-item">
            <a class="logo-image" href="<?php echo URL_ROOT; ?>" title="<?php echo $config['site_name'] ?>">
                <amp-img src="<?php echo URL_ROOT . $config['logo'] ?>" alt="<?php echo $config['site_name'] ?>" width="132" height="36" style="background: #FF6700"></amp-img>
            </a>
        </div>
    </div>
</header>
<section>
    <div class='amp-container'>
        <?php echo $main_content; ?>
        <a class="navButton" tabindex="0">&#9776;</a>
        <span class="navClose" tabindex="0">&#9776;</span>
        <div class="navFrame">
            <div class="block_scoll_menu">
                <ul class="list_item_panel">
                    <?php echo $tmpl->load_direct_blocks('mainmenu', array('style' => 'amp', 'group' => '21')); ?>
                </ul>
            </div>
        </div>
    </div>
</section>
<footer id="footer" class="row-content">
    <div class='amp-container'>
        <?php if ($config['info_footer_amp']) { ?>
            <div class="footer-info row-item">
                <?php
                $description = $config['info_footer_amp'];

                $description = preg_replace(
                    '/<img src="([^"]*)"\s*\/?>/',
                    '<amp-img src="$1" layout="responsive"></amp-img>',
                    $description
                );

                $description = preg_replace(
                    '/<img alt="([^"]*)" src="([^"]*)"\s*\/?>/',
                    '<amp-img alt="$1" src="$2" layout="responsive"></amp-img>',
                    $description
                );

                $description = preg_replace(
                    '/<img alt="([^"]*)" src="([^"]*)"\s*\/?>/',
                    '<amp-img src="$2" alt="$1" layout="responsive"></amp-img>',
                    $description
                );

                $description = preg_replace(
                    '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)"\s*\/?>/',
                    '<amp-img src="$2" style="$3" alt="$1" layout="responsive"></amp-img>',
                    $description
                );

                $description = preg_replace(
                    '/<img alt="([^"]*)" src="([^"]*)" style="([^"]*)" title="([^"]*)"\s*\/?>/',
                    '<amp-img src="$2" style="$3" alt="$1" alt="$4" layout="responsive"></amp-img>',
                    $description
                );

                echo html_entity_decode($description);
                ?>
            </div>
        <?php } ?>
    </div>
</footer>