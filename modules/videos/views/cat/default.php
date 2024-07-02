<?php
	global $tmpl;
	$tmpl -> addTitle('Videos');
	$tmpl -> addStylesheet('video','modules/videos/assets/css');

?>	

	<div class="video-list">
		<h3>Danh sách video 24hstore</h3>
		
		<div class="list row">
			<?php foreach ($list as $data) { ?>
			<?php
			  $url = $data ->file_flash;
			  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
			 
			  if (!empty($matches)) {
			    $video_id = $matches[1];
			  }

			  $link = FSRoute::_("index.php?module=videos&view=video&code=".$data->alias."&id=".$data->id);
			?>
			<div class="col-sm-3 item">
			 	<a href="<?php echo $link;?>" title="<?php echo $data->title;?>">
			    	<img  class="img-responsive" src='https://img.youtube.com/vi/<?php echo $video_id;?>/hqdefault.jpg' alt='<?php echo $data->title;?>' />
			    </a>
			    <a class="title" href="<?php echo $data ->file_flash;?>" target="_blank" title="<?php echo $data->title;?>">
			    	<?php echo $data->title;?>
			    </a>
			</div>
			<?php } ?>

		<?php 
			if($pagination) echo $pagination->showPagination(3);
		?>
		</div>
	</div>