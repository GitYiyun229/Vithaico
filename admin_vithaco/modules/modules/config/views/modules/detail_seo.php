<?php 
$arr_conjugate = array(0=>'NOT',1=>'AND',2=>'OR');
?>
<fieldset>
	<legend>Cấu hình SEO</legend>
	<table class="table table-hover table-striped table-bordered">
		<?php include 'detail_seo_title.php';?>
		<?php include 'detail_seo_keyword.php';?>
		<?php include 'detail_seo_description.php';?>
		<?php include 'detail_seo_h1.php';?>
		<?php include 'detail_seo_h2.php';?>
		<?php include 'detail_seo_image_alt.php';?>
		<?php include 'detail_seo_special.php';?>
	</table>
</fieldset>