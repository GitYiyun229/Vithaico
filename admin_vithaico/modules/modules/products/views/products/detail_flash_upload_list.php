<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script type="text/javascript" src="../libraries/uploadify/myuploadify.js"></script>
    <style>
        #sortable { list-style-type: none; margin: 0; padding: 0; }
        #sortable li {  margin:10px 10px 20px; cursor:move; text-align: center;background:#FFFFFF;}
        #sortable li div{ margin:0px auto;}
        #sortable span{ font-family:tahoma, Arial; font-size:11px; color:#cc0000; cursor:pointer; }
        #sortable span:hover{ text-decoration:underline;}
        #sortable font{ padding:0px 2px; color:#000000;}
        #sortable li .image-area-single p{ margin: 0; padding: 0;}
        #sortable li .image-area-single{background-color: #FFFFFF;
		    border-radius: 3px;
		    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.25);
		    float: left;
		    margin-right: 22px;
		    padding: 10px;
		    position: relative;}
        #sortable li .image-area-single .img{ overflow:hidden;}
        #sortable li .image-area-single .del{ position: absolute; top: -10px; right: -10px;}
        #sortable li .image-area-single .del img{ opacity: 0.5;}
        #sortable li .image-area-single .del img:hover{ opacity: 1;}
    </style>
</head>
<body>
<ul id="sortable">
	<?php if($listFiles){?>
		<?php foreach($listFiles as $item){ ?>
			<li id="sort_<?php echo $item->id;?>">
				<div class="image-area-single">
					<p class="img"><?php echo basename($item->link_file); ?></p>
					<p class="del" align="center"><span onclick="removeElement('sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')"><img src="../libraries/uploadify/delete.png"/></span></p>
				</div>
				Tên: <input type="text" name="summary_other_file" cols="40" rows="5"  id="titleElement" onchange="addTitleElement(this.value,'sort_<?php echo $item->id;?>','<?php echo $item->id; ?>')" value="<?php echo $item->name;?>" />
				<div class='clear'></div>	
			</li>
		<?php } ?>
	<?php } ?>
</ul>
<script type="text/javascript">
function addTitleElement(titleElement,divNum,data) {
		$.ajax({
			url: "index2.php?module=products&view=products&raw=1&task=add_title_other_files",
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
				url: "index2.php?module=products&view=products&raw=1&task=delete_other_file",
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
					url: "index2.php?module=products&view=products&raw=1&task=sort_other_files",
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