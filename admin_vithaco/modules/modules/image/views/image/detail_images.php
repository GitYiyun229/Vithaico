<link type="text/css" rel="stylesheet" href="libraries/uploadify/uploadify.css" />
<script type="text/javascript" src="libraries/uploadify/jquery.uploadify.js"></script>
<table cellspacing="1" class="admintable">
	<tr class="tr_uploadify">        
		<td class="label key">Thêm ảnh</td>
        <td class="value">
        	 <div id="box-uploadify" >
              	<table>
        			<tr>
        				<td style="vertical-align: middle;"><input id="file_upload" name="file_upload" type="file"/></td>
        				<td style="vertical-align: middle;">&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:$('#file_upload').uploadify('upload','*')"><img src="libraries/uploadify/upload.png" /></a></td>
        			</tr>
        		</table>
                <div id="fileQueue"></div>
                <div id="feeds"></div><!--end: #feeds-->
             </div><!--end: #box-uploadify-->
        </td>
      </tr>
</table>

<script type="text/javascript">
		$(function() {
		    $(".tr_uploadify").css("display","table-row");
			$('#file_upload').uploadify({
				'auto'     : false,
				'debug'    : false,
                'fileSizeLimit' : '8192KB',
                'fileTypeDesc' : 'Image Files',
                'fileTypeExts' : '*.gif; *.jpg; *.png', 
                'queueID'  : 'fileQueue',
				'swf'      : 'libraries/uploadify/uploadify.swf',
				'uploader' : 'index2.php?module=image&view=image&raw=1&ad_lang=<?php echo $_SESSION['ad_lang'] ?>&task=upload_other_images&data=<?php echo $uploadConfig;?>',
				'onUploadComplete' : function(){
                    $("#feeds").load("index2.php?module=image&view=image&raw=1&task=get_other_images&data=<?php echo $uploadConfig;?>");
                } 
			});
	});
</script>
<script type="text/javascript">
		 $("#feeds").load("index2.php?module=image&view=image&raw=1&task=get_other_images&data=<?php echo $uploadConfig;?>");
</script>