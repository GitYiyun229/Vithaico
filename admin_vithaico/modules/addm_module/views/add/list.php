<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Menu quản trị') );
	$toolbar->addButton('add',FSText :: _('Add'),'','add.png'); 
	$toolbar->addButton('edit',FSText :: _('Edit'),FSText :: _('You must select at least one record'),'edit.png'); 
	$toolbar->addButton('remove',FSText :: _('Remove'),FSText :: _('You must select at least one record'),'remove.png'); 
	$toolbar->addButton('published',FSText :: _('Published'),FSText :: _('You must select at least one record'),'published.png');
	$toolbar->addButton('unpublished',FSText :: _('Unpublished'),FSText :: _('You must select at least one record'),'unpublished.png');
?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this->module?>&view=<?php echo $this->view?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
			$filter_config  = array();
			$fitler_config['search'] = 1; 
//			$fitler_config['filter']['title'] = FSText::_('Estores'); 
//			$fitler_config['filter']['list'] = $estores; 
//			$fitler_config['filter']['field'] = 'estore_name'; 
			echo $this -> genarate_filter($fitler_config);
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" width="100%" cellpadding="0" cellspacing="0" class="tbl_form_contents" bordercolor="#CCC">				
					<?php 
					if(@$list){
					$i = 0;
					foreach ($list as $row) { 
					$i++;
					?>	
					<tbody class="parent<?php echo $row['id']?>">
						<tr>
							<td><?php echo $i?></td>
							<td>
								<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row['id']; ?>"  name="id[]" id="cb<?php echo $i?>">
							</td>
							<td align="left" style="padding-left:100px;">
								<font size="+1" color="#FF0000"><?php echo $row["name"]?></font>&nbsp;&nbsp;<a class="btl-menu" href="javascript:void(0)" onclick="deleteMenu(<?php echo $row['id']?>,<?php echo $row['parent_id']?>,'<?php echo 'modules/'.$this->module.'/models/delete.php'?>')" lang="<?php echo $row['id']?>"><img src="../images/del_button.png" border="0" alt="Xóa menu" title="Xóa menu" align="absmiddle" /></a>
							</td>
							<td><?php echo TemplateHelper::published("cb".($i),$row['published']?"unpublished":"published"); ?></td>
						</tr>
					</tbody>
					<?php
					if(isset($row['child']) && !empty($row['child'])){
					?>
					<tbody class="parent<?php echo $row['id']?>">
						<tr>
							<td>&nbsp;</td>	
							<td>&nbsp;</td>			
							<td style="padding-left:10px;">
								<table cellpadding="3" cellspacing="0">
									<?php
										$j=0;
										foreach($row['child'] as $child){
										$j++;
									?>	
									<tr class="child<?php echo $child['id']?>">
										
										<td align="right" width="30%" style="font-weight:bold;"><font color="#FF0000"><?php echo $j?></font>&nbsp;Tên module </td>
										<td align="left" width="50%" >: <?php echo $child['name']?></td>
										
										<td>
											<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $child['id']; ?>"  name="id[]" id="cb<?php echo $j?>">
										</td>
										<td><?php echo TemplateHelper::published("cb".($j),$child['published']?"unpublished":"published"); ?></td>
										<td><a class="btl-menu" lang="<?php echo $child['id']?>" href="javascript:void(0)" onclick="deleteMenu(<?php echo $child['id']?>,<?php echo $child['parent_id']?>,'<?php echo 'modules/'.$this->module.'/models/delete.php'?>')"><img src="../images/del_button.png" border="0" alt="Xóa module" title="Xóa module" /></a></td>
									</tr>
									<tr class="child<?php echo $child['id']?>">
										
										<td align="right"  width="30%" style="font-weight:bold;">Link</td>										
										<td align="left" width="50%" >: <?php echo $child['link']?></td>
										<td>&nbsp;</td>
										<td >&nbsp;</td>
										<td>&nbsp;</td>
									</tr>
									<?php
										}	
									?>
								</table>
							</td>
							<td>&nbsp;</td>
						</tr>
					</tbody>
					<?php			
					}
					?>
				<?php
				}
				}
				?>	
			</table>
		</div>
		<div class="footer_form">
			<?php if(@$pagination) {?>
			<?php echo $pagination->showPagination();?>
			<?php } ?>
		</div>
		
		<input type="hidden" value="<?php echo @$sort_field; ?>" name="sort_field">
		<input type="hidden" value="<?php echo @$sort_direct; ?>" name="sort_direct">
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>