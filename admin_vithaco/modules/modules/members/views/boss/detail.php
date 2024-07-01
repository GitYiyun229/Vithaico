<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<!-- FOR TAB -->	
 <script>
  $(document).ready(function() {
    $("#tabs").tabs();
  });
  </script>
	<?php
	$title = @$data ? FSText :: _('Edit'): FSText :: _('Add'); 
	global $toolbar;
	$toolbar->setTitle($title);
//	$toolbar->addButton('save_add',FSText :: _('Save and new'),'','save_add.png'); 
//	$toolbar->addButton('apply',FSText :: _('Apply'),'','apply.png'); 
//	$toolbar->addButton('Save',FSText :: _('Save'),'','save.png'); 
	$toolbar->addButton('back',FSText :: _('Cancel'),'','back.png');   
	
	$this -> dt_form_begin(0);
	?>
		<div id="tabs">
		    <ul>
		        <li><a href="#fragment-1"><span><?php echo FSText::_("Thông tin CTV"); ?></span></a></li>
		        <li><a href="#fragment-2"><span><?php echo FSText::_("ĐH CTV giới thiệu"); ?></span></a></li>
		        <li><a href="#fragment-3"><span><?php echo FSText::_("ĐH thành viên giới thiệu"); ?></span></a></li>
		        <li><a href="#fragment-4"><span><?php echo FSText::_("Thành viên"); ?></span></a></li>
		    </ul>
			
			<!--	BASE FIELDS    -->
		    <div id="fragment-1">
				<?php include_once 'detail_base.php';?>
			</div>
		    <!--	END BASE FIELDS    -->
		    
		    <!--	IMAGE FIELDS    -->
		    <div id="fragment-2">
		    	<?php include_once 'detail_order.php';?>
		    </div>
		     <!--	end IMAGE FIELDS    -->
		    <!--	IMAGE FIELDS    -->
		    <div id="fragment-3">
		    	<?php  include_once 'detail_orders_children.php';?>
		    </div>
		    
		    <div id="fragment-4">
		    	<?php  include_once 'detail_childrens.php';?>
		    </div>
	    </div>
<?php 
$this -> dt_form_end(@$data,0);
?>