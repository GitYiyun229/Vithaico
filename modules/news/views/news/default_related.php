<?php if($category -> display_related ){?>
	<?php if(count($relate_news_list)){?>
		<section id="related_posts">
			<div class="post-listing">
				<?php foreach ($relate_news_list as $item) {?>
					<?php $link_news = FSRoute::_("index.php?module=news&view=news&code=".$item->alias."&id=".$item->id."&ccode=".$content_category_alias[$item -> category_id]."&Itemid=$Itemid"); ?>
					<div class="related-item">
							<a href="<?php echo $link_news; ?>" rel="bookmark"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i> <?php echo $item->title; ?>	</a>
					</div>
				<?php } ?>
				<div class="clear"></div>
			</div>
		</section>		
	<?php } ?>
<?php } ?>