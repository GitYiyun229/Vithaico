<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/products.css"/>
<link type="text/css" rel="stylesheet" media="all" href="../ddtm_admin/templates/default/css/select2.min.css"/>
<script type="text/javascript" src="../ddtm_admin/templates/default/js/select2.min.js"></script>
<?php
	$title = FSText::_('Chọn 1 Danh mục để tiếp tục');
	global $toolbar;
	$toolbar->setTitle($title);
	//$toolbar->addButton('add',FSText::_('Th&#234;m m&#7899;i'),'','add.png');
	$toolbar->addButton('back', FSText:: _('Cancel'), '', 'cancel.png');

?>

<div class="row">
    <div class="col-md-6 col-xs-12" style="float: none;margin:auto">
        <select name="" id="" class="select2-cat">
            <option value="0">Chọn danh mục</option>
            <?php foreach($categories as $item) {?>
                <option value="<?php echo $item->id ?>">
                    <?php echo $item->name ?>
                </option>
            <?php } ?>    
        </select>
        <script>
            $(document).ready(function(){
                $('.select2-cat').select2();
                $('.select2-cat').on('change',function(){
                    let cid = $(this).select2('val');
                    url_current = window.location.href;
                    url_current = url_current.replace('#','');
                    if(cid != 0)
                        window.location.href=url_current+'&task=add&cid='+cid;
                    else
                        alert('Bạn chưa chọn danh mục!');
                        // window.location.href=url_current+'&task=add';
                })
            })
        </script>
    </div>
</div>
	<!--	CONTENT -->
        <!-- <ul class='product_categories' >
	 	<?php
        $num_child = array();
        $parant_close = 0;
	 	$i = 0;
	 	$count_children = 0;
	 	$summner_children = 0;
	 	$id = 0;

        $total = count($categories);
        foreach ( $categories as $item ) {
            $class = '';
            $link = '#';

            $class  .= ' level_'.$item -> level;
            if($i == ($total -1))
                $class .= ' last-item';
            if($item -> level ){
                /* Nếu hiện các Category cấp con thì dùng đoạn này.
                $count_children ++;
                if($count_children == $summner_children && $summner_children)
                    $class .= ' last-item';
                echo "<li class='item $class child_".$item->parent_id."' ><h2 class='h2_".$item->level."'><a href='".$link."'class=\"toolbar\"  onclick=\"javascript: submitbutton_('add','".$item -> id."')\"><span> ".$item -> name."</span></a></h2>  ";
                */
            } else {
                // Hiển thị Category cấp 1
                $count_children = 0;
                $summner_children = $item -> children;
                echo "<li class='item $class  ' id='pr_".$item -> id."' >";
                echo "<h2 class='h2_".$item->level."'>
                <a href='".$link."' class=\"toolbar\" onclick=\"javascript: submitbutton_('add','".$item -> id."')\">
                <span> ".$item -> image."</span>
                <span> ".$item -> name."</span>
                </a></h2>  ";
            }
            ?>
            <?php
            $num_child[$item->id] = $item->children ;
            if($item->children  > 0){
                if($item -> level)
                    echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children wrapper_children_level".$item -> level."' >";
                else
                    echo "<ul id='c_".$item->id."' class=' sub-menu wrapper_children_level".$item -> level."' >";
            }

            if(@$num_child[$item->parent_id] == 1)
            {
                if($item->children > 0)
                {
                    $parant_close ++;
                }
                else
                {
                    $parant_close ++;
                    for($i = 0 ; $i < $parant_close; $i++)
                    {
                        echo "</ul>";
                    }
                    $parant_close = 0;
                    $num_child[$item->parent_id]--;
                }

                if(( (@$num_child[$item->parent_id] == 0) && (@$item->parent_id >0 ) ) || !$item->children )
                {
                    echo "</li>";
                }
                if(@$num_child[$item->parent_id] >= 1)
                    $num_child[$item->parent_id]--;
            }


            if(isset($num_child[$item->parent_id] ) && ($num_child[$item->parent_id] == 1) )
                echo "</ul>";
            if(isset($num_child[$item->parent_id]) && ($num_child[$item->parent_id] >= 1) )
                $num_child[$item->parent_id]--;

        }
            ?> -->
	<!--	end CONTENT -->
</ul>

<script type='text/javascript'>

function submitbutton_(pressbutton,cid) {
	//alert('ssss');return;
		submitform_(pressbutton,cid);
}
/**
* Submit the admin form
*/
function submitform_(pressbutton,cid){
	if (pressbutton) {
		url_current = window.location.href;
		url_current = url_current.replace('#','');
		if(cid)
			window.location.href=url_current+'&task='+pressbutton+'&cid='+cid;
		else
			window.location.href=url_current+'&task='+pressbutton;
		return;
	}
}
</script>
