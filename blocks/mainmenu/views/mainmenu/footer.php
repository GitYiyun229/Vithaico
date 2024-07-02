<?php foreach ($list as $item) { ?>
    <div class="mb-2">
        <a href="<?php echo $item->link ?: 'javascript:void(0)' ?>" title="<?php echo $item->name ?>">
            <?php echo $item->name ?>
        </a>
    </div>
<?php } ?>    