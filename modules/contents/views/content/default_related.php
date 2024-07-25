<!--	RELATE CONTENT		-->
<?php
$total_content_relate = count($relate_news_list);
if ($total_content_relate) { ?>
    <h4 class="relate_title">
        <span><?php echo FSText::_('Tin tức liên quan'); ?></span>
    </h4>
    <div class="relate_cat row-item">
        <?php
        for ($i = 0; $i < $total_content_relate; $i++) {
            $item = $relate_news_list[$i];
            $link = FSRoute::_('index.php?module=contents&view=content&code=' . $item->alias . '&ccode=' . $item->category_alias . '&id=' . $item->id);
        ?>
            <h3 class="relate_content">
                <a class="img_news" href='<?php echo $link; ?>' title='<?php echo $item->title; ?>'><?php echo getWord(30, $item->title); ?></a>
            </h3>
        <?php } ?>
    </div>
<?php } ?>
<!--	end RELATE CONTENT		-->