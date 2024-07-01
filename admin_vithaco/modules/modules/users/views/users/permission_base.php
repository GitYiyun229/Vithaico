<div class="panel panel-primary">
<div class="panel-body">
	<table class="table table-hover table-striped table-bordered " >
		<thead>
			<tr>
				<th class="title" width="20%" rowspan="2">
					<?php echo FSText :: _('Module'); ?>
				</th>
				<th class="title" width="30%"  rowspan="2">
					<?php echo FSText :: _('Nhóm task vụ'); ?>
				</th>
				<th class="title" width="" colspan="2" style="text-align: center;"  >
					<?php  echo FSText :: _('Chức năng'); ?>
				</th>
			</tr>
			<tr>
				<th><?php echo FSText :: _('View'); ?> </th>
				<th style="text-align: center;"><?php echo FSText :: _('Phân quyền chức năng'); ?></th>
                <!--
				<th><?php //echo FSText :: _('Remove'); ?> </th>
                <th><?php //echo FSText :: _('Published'); ?> </th> -->
			</tr>
		
		</thead>
		<tbody>
			<?php foreach($arr_task as $module_name => $module):
                //var_dump($module);
            ?>
				<tr >
					<td align="left" rowspan="<?php echo (count($module));?>">
						<strong><?php echo FSText::_(ucfirst($module_name));?></strong>
					</td>
				<?php $k = 0;?>	
				<?php foreach($module as $view_name => $view):?>
					<?php $perm = @$list_permission[$view -> id] -> permission?@$list_permission[$view -> id] -> permission : 0; ?>
					<?php 
                    //print_r($perm);
					$name_box = "per_";
					$name_box .= $view -> id ?  ($view -> id): "0";
					$id_box = $name_box;
					$name_box .= "[]";
					?>
						
					<?php if($k){?>
					<tr >
					<?php }?>
						<td><?php echo $view -> description ?FSText::_($view -> description) : FSText::_(ucfirst($view_name));?></td>
							<td>
								<input type="checkbox" class="checkbox-custom" value="3"  name="<?php echo $name_box; ?>" <?php echo @$perm >= 3 ?"checked=\"checked\"":""; ?> id="<?php echo $id_box."_v1"; ?>"/>
                                <label for="<?php echo $id_box."_v1"; ?>" class="checkbox-custom-label"></label>
                            </td>
							<td>
                                <a style="font-size: 24px;display: block;text-align: center;color: #57baf9;" href="javascript:void(0)" onclick="load_funciton('<?php echo $view->module ?>','<?php echo $view->view ?>',<?php echo $id; ?>)">
                                    <i class="fa fa-truck"></i>
                                </a>    
                            </td>
					</tr>
					<?php $k ++;?>
				<?php endforeach;?>
			<?php endforeach;?>
		</tbody>
	</table>
</div>
</div>

<script type="text/javascript">
	function load_content(n_module = '',n_view = '',id)
	{
		if(!n_module || !n_view || !id)
            return false;
        $("#sv_bt").load("index.php?module=users&view=users&raw=1&task=display_page", {"n_module":n_module,"n_view":n_view,"user_id":id}, function() { //get content from PHP page
            //$(".loading-div").hide(); //once done, hide loading element
            $("#myModal").modal();
        });    
	}
    
    function load_funciton(n_module = '',n_view = '',id)
	{
		if(!n_module || !n_view || !id)
            return false;
        $("#sv_bt").load("index.php?module=users&view=users&raw=1&task=display_page_fun", {"n_module":n_module,"n_view":n_view,"user_id":id}, function() { //get content from PHP page
            //$(".loading-div").hide(); //once done, hide loading element
            $("#myModal").modal();
        });    
	}
</script>