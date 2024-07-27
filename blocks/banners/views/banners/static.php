<?php global $tmpl;
	$tmpl -> addStylesheet('banners_wrapper','blocks/banners/assets/css');
?>
<div class='banners  banners-<?php echo $style; ?> block_inner block_banner<?php echo $suffix;?>'  >  	
	<?php foreach($list as $item){?>
		<div class="banner_static">
			<a href="<?php echo $item -> link;?>" title='<?php echo $item -> name;?>'  id="banner_item_<?php echo $item ->id; ?>">
				<img class="img-old img-responsive"  alt="<?php echo $item -> name; ?>" src="<?php echo URL_ROOT.str_replace('/original/', '/original/', $item->image); ?>">
			</a>
		</div>
	<?php }?>	  	
</div>   	

 