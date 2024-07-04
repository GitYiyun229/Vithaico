<link type="text/css" rel="stylesheet" href="<?php echo URL_ROOT; ?>libraries/uploadify/uploadify.css" />
<script type="text/javascript" src="<?php echo URL_ROOT; ?>libraries/uploadify/jquery.uploadify.js"></script>
<table cellspacing="1" class="admintable">
<?php 	
	//TemplateHelper::dt_edit_selectbox('Loại','color','',0,$colors,'id', 'name',$size = 6,0);
?>
	<tr class="tr_uploadify" style="display: none">        
		<td class="label key">Thêm file</td>
        <td class="value">
        	 <div id="box-uploadify" >
              	<table>
        			<tr>
        				<td style="vertical-align: middle;"><input id="file_upload" name="file_upload" type="file"/></td>
<!--        				<td style="vertical-align: middle;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:$('#file_upload').uploadify('upload','*')"><img src="../libraries/uploadify/upload.png" /></a></td>-->
        				<td colspan="2" style="vertical-align: middle;" >&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:show_form_add_link();"><img src="templates/default/images/link.png" /></a></td>
        			</tr>
        			<tr class='add_link_area hide'> 
        				<td>Link: <input id="link_file" name="link_file" type="text" /></td>
        				<td>Tên:<input id="file_name" name="file_name" type="text" /></td>
        				<td><a href="javascript: add_link_normal()">Save</a> </td>
        			</tr>
        		</table>
                <div id="fileQueue"></div>
                <div id="feeds"></div><!--end: #feeds-->
             </div><!--end: #box-uploadify-->
        </td>
</table>
<script type="text/javascript">
		$(function() {
		    $(".tr_uploadify").css("display","table-row");
			$('#file_upload').uploadify({
				'auto'     : true,
				'debug'    : false,
                'fileSizeLimit' : '14800KB',
                'fileTypeDesc' : 'CHỌN FILES',
                'fileTypeExts' : '*.gif; *.jpg; *.jpeg; *.png;', 
//                'fileTypeExts' : '*.gif; *.jpg; *.jpeg; *.png; *.rar; *.zip; *.doc; *.docx; *.xls; *.xlsx;*.mpp;*.pdf;*.ppt;*.tiff;*.bmp;*.pptx;*.ps;*.odt;*.ods; *.odp; *.odg;  ', 
                'queueID'  : 'fileQueue',
				'swf'      : '../libraries/uploadify/uploadify.swf',
				'uploader' : 'index2.php?module=products&view=products&raw=1&task=uploadAjaxFiles&data=<?php echo $uploadConfig;?>',
				 'onUploadComplete' : function(){
                     $("#feeds").load("index2.php?module=products&view=products&raw=1&task=getAjaxFiles&data=<?php echo $uploadConfig;?>");
                 }
			});
	});
	 $("#feeds").load("index2.php?module=products&view=products&raw=1&task=getAjaxFiles&data=<?php echo $uploadConfig;?>");

	function add_link_normal() {
		var link_file = $('#link_file').val();
		var file_name = $('#file_name').val();
		if(!link_file || !file_name){
			alert('Trường link và tên file phải nhập');
			return;
		}
		$.ajax({
			url: "index2.php?module=products&view=products&raw=1&task=add_link&data=<?php echo $uploadConfig;?>",
			type: "get",
			data: "link_file="+link_file+"&file_name="+file_name,
			error: function(){
				alert("Không thêm được link");
			}
		});
		$("#link_file").val("");
		$("#file_name").val("");
		$("#feeds").load("index2.php?module=products&view=products&raw=1&task=getAjaxFiles&data=<?php echo $uploadConfig;?>");
	}
	function show_form_add_link() {
		if($('.add_link_area').hasClass('hide')){
			$('.add_link_area').removeClass('hide');
		}else{
			$('.add_link_area').addClass('hide');
		}	
	}
 </script>
