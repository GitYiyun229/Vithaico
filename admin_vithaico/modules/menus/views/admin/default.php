<?php 
include_once '../libraries/tree/tree.php';
$list = Tree::indentRows($list);
$root_total = 0;
$root_last = 0;
$url = $_SERVER['REQUEST_URI'];
foreach ($list as $item){
	if(!@$item->parent_id){
		$root_total ++ ;
		$root_last = $item->id;
	}
}
?>
<div class="sidebar-search">
    <div class="input-group custom-search-form">
        <input type="text" class="form-control" id="myInput" onkeyup="myFunction()" placeholder="<?php echo FSText::_('Search') ?>..." />
        <span class="input-group-btn">
        <button class="btn btn-default" type="button">
            <i class="fa fa-search"></i>
        </button>
    </span>
    </div>
    <!-- /input-group -->
</div>
<ul class="nav" id="side-menu">
    <?php 
	$num_child = array();
	$parant_close = 0;
	foreach ($list as $item){
		$class = '';
        $collapse = '';
        $icon = '';
		if($item->link){
			$link = trim($item->link);
			if(strpos($url,$link) !== false)
				$class .= ' actives ';
		}else{
			$link = "javascript:void(0)";
            $collapse =  '<span class="fa arrow"></span>';
		}
        if($item->icon){
            $icon = '<i class="'.$item->icon.'"></i> ';
        }
        $has_child = '';
        if($item->children > 0)
            $has_child = ' has-child';
		if(!$item->parent_id){
        ?>
            <li>
                <a href="<?php echo $link; ?>" class="header <?php echo $class;?>" >
                    <?php echo $icon; ?>
                    <?php echo FSText::_(trim($item->name)); ?> 
                    <span class="fa arrow"></span>
                </a>
            
        <?php }else{ ?>
            <li>
                <a href="<?php echo $link; ?>" class="<?php echo $class;?>" >
                    <?php echo $icon; ?>
                    <?php echo FSText::_(trim($item->name)); ?>
                    <?php echo $collapse; ?>
                </a>
                        
        <?php } ?>
	    <?php 
		$num_child[$item->id] = $item->children ;
		if($item->children  > 0)
			echo "<ul class='nav nav-second-level'  >";
		if(@$num_child[$item->parent_id] == 1){
			if($item->children > 0){
				$parant_close ++;
			}else{
				$parant_close ++;
				for($i = 0 ; $i < $parant_close; $i++){
					echo "</ul>";
				}
				$parant_close = 0;
				$num_child[$item->parent_id]--;
			}
			if(@$num_child[$item->parent_id] >= 1) 
				$num_child[$item->parent_id]--;
		}	
		if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
			echo "</ul>";
		if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
			$num_child[$item->parent_id]--;
        echo '</li>';
	}
	?>
</ul>
<script>
$( document ).ready(function() {
    $('#side-menu a.actives').parent('li').parent('ul').addClass('in').attr('aria-expanded','true');
    
    $( "#side-menu > li" ).each(function() {
        var size = $(this).children('ul').size();
        if(!size){
            $(this).hide();
        }
        //console.log(size);  
    });
    
});
function myFunction() {
    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toUpperCase();
    ul = document.getElementById("side-menu");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        a = li[i].getElementsByTagName("a")[0];
        if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}
</script>
