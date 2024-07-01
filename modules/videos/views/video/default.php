<?php  	global $tmpl;
$tmpl -> addStylesheet('video','modules/videos/assets/css');
FSFactory::include_class('fsstring');

$tmpl -> addTitle($data ->title);
?>
<div class="video_detail">
	<h1 class='content_title'>
		<?php	echo $data ->title; ?>
	</h1>
	<?php
	  $url = $data ->file_flash;
	  preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $matches);
	 
	  if (!empty($matches)) {
	    $video_id = $matches[1];
	  }
//	  var_dump($matches);

	  $link = FSRoute::_("index.php?module=videos&view=video&code=".$data->alias."&id=".$data->id);
	?>
	<iframe src="https://www.youtube.com/embed/<?php echo $video_id ?>" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
</div>

