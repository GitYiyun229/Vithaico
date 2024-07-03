<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; }
        #sortable li {  margin: 10px; cursor:move;  float: left; text-align: center;background:#FFFFFF;}
        #sortable li div{ margin:0px auto;}
        #sortable span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
        #sortable span:hover{ text-decoration:underline;}
        #sortable font{ padding:0px 2px; color:#000000;}
        #sortable li .image-area-single p{ margin: 0; padding: 0;}
        #sortable li .image-area-single{background-color: #FFF; border-radius: 3px; box-shadow: 0 1px 3px rgba(0,0,0,0.25); padding:10px; position: relative;}
        #sortable li .image-area-single .img{ overflow:hidden;}
        #sortable li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
        #sortable li .image-area-single .del img{ opacity: 0.5;}
        #sortable li .image-area-single .del img:hover{ opacity: 1;}
    </style>
</head>
<body>
<ul id="sortable">
	<?php foreach($list_other_images as $item){ ?>
		<li id="sort_<?php echo $item->id;?>">
			<div class="image-area-single">
				<p class="img"><img src="<?php echo URL_ROOT.str_replace('/original/','/small/', $item->image)?>" /></p>
				<p class="del" align="center"><span onclick="removeElement('sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="libraries/uploadify/delete.png"/></span></p>
			</div>
			<p class="title" align="center"><input type="text"  value="<?php echo $item->title;?>" id="titleElement" onchange="addTitleElement(this.value,'sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"/></p>
		</li>
	<?php } ?>
</ul>
<script type="text/javascript">
function addTitleElement(titleElement,divNum,data) {
		$.ajax({
			url: "index2.php?module=image&view=image&raw=1&task=add_title_other_images",
			type: "get",
			data: "data="+data+"&title="+titleElement,
			error: function(){
				alert("Không thêm được tiêu đề (-.-)");
			}
		});
	}
function removeElement(divNum,data) {
	  if (confirm('Bạn chắc chắn muốn xóa ảnh này?')){
		  var d = document.getElementById('sortable');
		  var olddiv = document.getElementById(divNum);
		  $.ajax({
				url: "index2.php?module=image&view=image&raw=1&task=delete_other_image",
				type: "get",
				data: "data="+data,
				error: function(){
					alert("Lỗi xoa dữ liệu");
				},
	            success: function(){
	                d.removeChild(olddiv);
	            }
	 		});
	  }else{
	  	return false;
	  }
	}
	$(function() {
		$("#sortable").sortable({
			update : function () {
				serial = $('#sortable').sortable('serialize');
				$.ajax({
					url: "index2.php?module=image&view=image&raw=1&task=sort_other_images",
					type: "post",
					data: serial,
					error: function(){
						alert("Lỗi load dữ liệu");
					}
				});

			}
		});
		
	});
</script>
</body>
</html>
