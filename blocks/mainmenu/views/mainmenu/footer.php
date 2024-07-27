<div class="menu-footer">
    <?php foreach ($list as $item) { ?>
    <?php if ($item->level == 0) { ?>
    <a class="menu-item"
        href="<?php echo $item->link ? FSRoute::_($item->link) : 'javascript:void(0)' ?>"><?php echo $item->name ?></a>
    <?php } ?>
    <?php } ?>
</div>