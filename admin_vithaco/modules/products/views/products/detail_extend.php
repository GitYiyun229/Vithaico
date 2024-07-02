<!--	EXTENDED FIELDS    -->
<?php if(@$extend_fields) {?>
<table>
		<?php 
		for($i = 0 ; $i < count($extend_fields); $i ++)
		{
			if($extend_fields[$i]->is_filter != 1){
				if($extend_fields[$i] -> field_name == 'hide_name')
					continue;
				$fieldname  = $extend_fields[$i] -> field_name;
				$fieldid  = $extend_fields[$i] -> id;
				$foreign_tablename = $extend_fields[$i] -> foreign_tablename;
				$foreign_id = $extend_fields[$i] -> foreign_id;
				$fieldname_extend = str_replace("fs_extends_","",$foreign_tablename);
				$field_display  = $extend_fields[$i] -> field_name_display;
				$fieldtype  = $extend_fields[$i] -> field_type;

				if($fieldname == 'id' || $fieldname == 'ID' || $fieldname == 'Id')
					continue;
				switch ($fieldtype){
					case "text":
						TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname,'',650,6,1,'','','col-md-3','col-md-9','',1); 
						break;
					case "int":
						TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname,'','20');
						break;
					case "foreign_one":
						$sub_item ='';
						if($data_foreign[$fieldname]){
							TemplateHelper::dt_edit_selectbox($field_display,$fieldname,@$data_ext -> $fieldname,0,$data_foreign[$fieldname],'id', 'name',$size = 1,0,1,'',$sub_item);
						}
						break;
					case "foreign_multi":
						$sub_item ='';
						if($data_foreign[$fieldname]){
							TemplateHelper::dt_edit_selectbox($field_display,$fieldname,@$data_ext -> $fieldname,0,$data_foreign[$fieldname],'id', 'name',$size = 10,1,1,'Giữ phím Ctrl để chọn nhiều item',$sub_item);
							// TemplateHelper::dt_text('','<a target="_blink" href="index.php?module=extends&view=items&table_name='.$fieldname_extend.'"><font color="#1D8FCE">Chỉnh sửa thuộc tính bộ lọc</font></a>','','',0);
						}
						break;
					case "datetime":
						$value = isset($data_ext -> $fieldname)?strtotime(@$data_ext -> $fieldname):time();
						TemplateHelper::dt_edit_text($field_display,$fieldname,date('d-m-Y H:i:s',$value));
						break;
					default:
						TemplateHelper::dt_edit_text($field_display,$fieldname,@$data_ext -> $fieldname);
						break;
				}
			}
		}			
		?>
	
</table>
<?php }?>
<!--	end EXTENDED FIELDS    -->
<script>
function save_extend(id, note_id,foreign_id,fieldname){
var val_note = jQuery("#id_extend_edit_"+id).val();
jQuery.ajax({
  type: 'POST',
  url: 'index.php?module=products&view=products&task=save_extend&raw=1',
  data: {'val': val_note, 'note_id': note_id,'foreign_id':foreign_id},
  success: function(data) {
      if(data) {
    	  $('#'+fieldname).html(data);
    	  $('#id_extend_edit_'+id).val('');
    	  alert('Bạn đã thêm thành công!');
      } else {
          alert('Không thể lưu được');return false;
      }
  }
});
}
</script>	    
