
<!-- HEAD -->
	<?php 
	
	$title = isset($data)?"S&#7917;a b&#7843;ng":"Tạo mới bảng"; 
	global $toolbar;
	$toolbar->setTitle($title);
	if(isset($data)){
//		$toolbar->addButton('filter',FSText::_("B&#7897; l&#7885;c"),'','filter-export.png');
//		$toolbar->addButton('apply_edit',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
		$toolbar->addButton('save_edit',FSText::_('L&#432;u'),'','save.png'); 
	} else {
		$toolbar->addButton('apply_new',FSText::_('L&#432;u t&#7841;m'),'','apply.png'); 
		$toolbar->addButton('save_new',FSText::_('L&#432;u'),'','save.png'); 
	}
	$toolbar->addButton('cancel',FSText::_('Tho&#225;t'),'','cancel.png');
	$max_ordering = 0;
	?>
<!-- END HEAD-->
<!-- BODY-->
<div class="form_body">
	

	<form action="index.php?module=<?php echo $this -> module;?>&view=<?php echo $this -> view;?>" name="adminForm" method="post" enctype="multipart/form-data">
		
		<!--	TABLE	-->
		<fieldset>
			<legend>T&#7841;o t&#234;n b&#7843;ng</legend>
			<div id="tabs">
				<table>
					<tr>
						<td> T&#234;n b&#7843;ng</td>
						<td>
						<?php if(isset($data)){ ?> 	
							<input type="text" name = "table_name"  value = "<?php echo substr($table_name,11); ?>"  <?php echo $default_table?'disabled="disabled" ':''?> />
							<input type="hidden" name = "table_name_begin"  value = "<?php echo substr($table_name,11); ?>" />
						<?php } else { ?>
							 <input type="text" name = "table_name"  />
						<?php } ?>
						</td>
					</tr>
				</table>
			</div>
		</fieldset>
		<!--	end TABLE	-->
		
		
		<input type="hidden" value="" name="field_remove" id="field_remove" />
		<input type="hidden" value="<?php echo count($data); ?>" name="field_extend_exist_total" id="field_extend_exist_total" />
		<input type="hidden" value="" name="new_field_total" id="new_field_total" />
				
		<input type="hidden" value="<?php echo $this -> module;?>" name="module">
		<input type="hidden" value="<?php echo $this -> view;?>" name="view">
		<input type="hidden" value="<?php echo FSInput::get('tablename');?>" name="tablename" />
		<input type="hidden" value="" name="task" />
		<input type="hidden" value="0" name="boxchecked" />
	</form>
</div>
<!-- END BODY-->

<script>
	var ii = 0;
	// check 
	function   addField()
	{
		area_id = "#tr"+ii;
		
		htmlString = "<td>" ;
		htmlString +=  "<input type=\"text\" name='new_fshow_"+ii+"' id='new_fshow_"+ii+"'  />";
		htmlString += "</td>";
		htmlString += "<td>" ;
		htmlString +=  "<input type=\"text\" name='new_fname_"+ii+"' id='new_fname_"+ii+"' class='fname'  onblur='javascript: check_field_name();' />";
		htmlString += "</td>";
		htmlString += "<td>";
		htmlString += "<select name='new_ftype_"+ii+"'>";
		htmlString += "<option value=\"varchar\" >VARCHAR</option>";
		htmlString += "<option value=\"int\" >INT</option>";
		htmlString += "<option value=\"datetime\" >DATETIME</option>";
		htmlString += "<option value=\"text\" >TEXT</option>";
		htmlString += "</select>";
		htmlString += "</td>";
		
		htmlString += "<td>";
		htmlString += "<a href=\"javascript: void(0)\" onclick=\"javascript: remove_new_field("+ ii +")\" >" + " X&#243;a" + "</a>";
		htmlString += "</td>";
		
		$(area_id).html(htmlString);		
		ii++;
		$("#new_field_total").val(ii);
	}

	//remove extend field exits
	function remove_extend_field(area,fieldname)
	{
		if(confirm("You certain want remove this fiels"))
		{
			remove_field = "";
			remove_field = $('#field_remove').val();
			remove_field += ","+fieldname;
			$('#field_remove').val(remove_field);
			$('#extend_field_exist_'+area).html("");
		}
		return false;
	}
	//remove new extend field 
	function remove_new_field(area)
	{
		if(confirm("You certain want remove this fiels"))
		{
			area_id = "#tr"+area;
			$(area_id).html("");
		}
		return false;
	}

	function check_field_name(){
		var strExp = /^[0-9a-zA-Z_]+$/;
		$('.fname').blur(function(){
			// check regular:
			var val = $(this).val();
			if(!val.match(strExp)){
				$(this).addClass("redborder");
				alert('Chỉ nhập chữ, số và kí tự "_".');
				$(this).focus();
				return false;
			}else{
				$(this).removeClass("redborder");
			}

			// check exist
			var seen = {};
			$('.fname').each(function(){
				 var txt = $(this).val();
				 if (seen[txt]){
				     alert('Các trường không được trùng nhau');
				     $(this).addClass("redborder");
				     $(this).focus();
		     		 return false;
				 } else {
			        seen[txt] = true;
			        $(this).removeClass("redborder");
				 }
			});
						
		});
	}
</script>