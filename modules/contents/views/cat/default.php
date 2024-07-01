<?php
	global $tmpl;
$tmpl->addStylesheet('detail', 'modules/contents/assets/css');
?>
<main>
    <div class="breadcrumbs">
        <div class="container">
            <?php echo $tmpl->load_direct_blocks('breadcrumbs', array('style' => 'simple')); ?>
        </div>
    </div>
    <?php if ($tmpl->count_block('top_default')) { ?>
        <?php echo $tmpl->load_position('top_default'); ?>
    <?php } ?>
    <div class="container">
        <h2 class="h2_c" id="h2_c"><?php echo $cat->name ?></h2>

        <div class="main-content" id="main_content">
            <div class="menu-left">
                <ul class="list ul-grid">
                    <?php foreach ($list as $i=>$item) {?>
                        <li class="item <?php echo $i == 0 ? 'active' : ''?>">
                            <a href="<?php echo FSRoute::_('index.php?module=contents&view=content&code='.$item->alias.'&id='.$item->id) ?>">
                                <?php echo $item->title ?>
                            </a>
                        </li> 
                    <?php } ?>
                </ul>
            </div>
            <div class="content-right">
                <?php echo $list[0]->content ?> 
            </div>
        </div>
    </div>
</main>

