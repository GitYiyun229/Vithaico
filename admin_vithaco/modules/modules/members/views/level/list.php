<?php  
	global $toolbar;
	$toolbar->setTitle(FSText :: _('Hạng thành viên') );
	$toolbar->addButton('save_all',FSText :: _('Save'),'','save.png'); 

?>
<div class="form_body">
	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post">
		
		<!--	FILTER	-->
		<?php 
		?>
		<!--	END FILTER	-->
		
		<div class="form-contents">
			<table border="1" class="tbl_form_contents" cellpadding="5" bordercolor="#CCC">
				<thead>
					<tr>
					<th width="3%">
						#
					</th>
					<th width="3%">
						<input type="checkbox" onclick="checkAll(<?php echo count($list); ?>);" value="" name="toggle">
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Level'), 'a.level',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable(FSText::_('Name'), 'a.name',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable('Điểm tối thiểu', 'point',$sort_field,$sort_direct) ; ?>
					</th>
					<th class="title">
						<?php echo  TemplateHelper::orderTable('Giảm giá (%)', 'discount',$sort_field,$sort_direct) ; ?>
					</th>
				</thead>
				<tbody>
					
					<?php $i = 0; ?>
					<?php if(@$list){?>
						<?php foreach ($list as $row) { ?>
						  
							<?php $link_detail = "index.php?module=".$this -> module."&view=".$this -> view."&task=edit&id=".$row->id; ?>
							<tr class="row<?php echo $i%2; ?>">
								<td><?php echo $i+1; ?>
								    <input type="hidden" name='<?php echo "id_".$i; ?>' value="<?php echo $row->id; ?>"/>
								</td>
								<td>
									<input type="checkbox" onclick="isChecked(this.checked);" value="<?php echo $row->id; ?>"  name="id[]" id="cb<?php echo $i; ?>">
								</td>
								<td>
									<?php echo $row -> level; ?>
								</td>
								<td>
								    <input type="text" name='<?php echo "name_".$i; ?>' value="<?php echo $row->name; ?>" size="60" />
								    <input type="hidden" name='<?php echo "name_".$i."_original"; ?>' value="<?php echo $row->name; ?>"/>
								 </td>
								 	<td>
									 	<input type="text" name='<?php echo "point_".$i; ?>' value="<?php echo $row->point; ?>" size="20" />
									    <input type="hidden" name='<?php echo "point_".$i."_original"; ?>' value="<?php echo $row->point; ?>"/>
								 	</td>
								 	<td>
									 	<input type="text" name='<?php echo "discount_".$i; ?>' value="<?php echo $row->discount; ?>" size="20" />
									    <input type="hidden" name='<?php echo "discount_".$i."_original"; ?>' value="<?php echo $row->discount; ?>"/>
								 	</td>
<!--								<td> <?php echo TemplateHelper::edit($link_detail); ?></td>-->
							</tr>
							<?php $i++; ?>
						<?php }?>
					<?php }?>
				</tbody>
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
		<input type="hidden" value="<?php echo ($i+1);?>" name="total">
		<input type="hidden" value="<?php echo FSInput::get('page',0,'int');?>" name="page">
		<input type="hidden" value="<?php echo 'name,point,discount';?>" name="field_change">
		<input type="hidden" value="" name="task">
		<input type="hidden" value="0" name="boxchecked">
	</form>
</div>