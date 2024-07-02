<div class="panel panel-primary">
    <div class="panel-heading">
        <i class="fa fa-key"></i> <?php echo FSText::_('Tối ưu Seo') ?>
    </div>   
    <div class="panel-body">
        <div class="form-group">
        
            <?php $title = @$data ? FSText :: _('Edit'): FSText :: _('Add');  ?>
            <div class="table-responsive keyword">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo FSText::_('Keyword') ?></th>
                            <th><?php echo FSText::_('Keyword replace') ?></th>
                            <th><?php echo FSText::_('Link') ?></th>
                            <th><?php echo FSText::_('Loại seo') ?></th>
                            <th><?php echo FSText::_('Loại link') ?></th>
                            <th><?php echo $title; ?></th>
                            <th><?php echo FSText::_('Xóa'); ?></th>
                        </tr>
                    </thead>
                    <tbody id="keywordInput" >
                    <?php if(count($list_key)){ ?>
                        <?php for($i=0;$i<count($list_key);$i++){ 
                            $item = $list_key[$i];
                        ?>
                        <tr id="item_<?php echo $item->id  ?>">
                            <td>
                                <?php echo $i+1; ?>
                                <input type="hidden" id="stt_<?php echo $item->id; ?>" value="<?php echo $i+1; ?>" />
                            </td>
                            <td>
                                <input type="text" id="input_key_<?php echo $item->id ?>" class="form-control" placeholder="<?php echo FSText::_('Keyword') ?>" value="<?php echo $item->name ?>" />
                            </td>
                            <td><input type="text" id="input_replace_<?php echo $item->id ?>" class="form-control" placeholder="<?php echo FSText::_('Keyword replace') ?>" value="<?php echo $item->name_replace ?>" /></td>
                            <td>
                                <div class="form-group input-group">
                                    <input type="text" class="form-control" name="link" id="link_<?php echo $item->id ?>" value="<?php echo $item->link_replace ?>" />
                                    <a class="input-group-addon" href="javascript: created_indirect('index.php?module=news&view=news',8,'link_<?php echo $item->id ?>');" >
                                        <i class="fa fa-link"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <select class="form-control" name="type" id="type_<?php echo $item->id ?>">
                                    <option value="0" <?php echo $item->type == 0? 'selected="selected"':'' ?>><?php echo FSText::_('Trong bài viết'); ?></option>
                                    <option value="1" <?php echo $item->type == 1? 'selected="selected"':'' ?>><?php echo FSText::_('Ngoài bài viết'); ?></option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="type_link" id="type_link_<?php echo $item->id ?>">
                                    <option value="0" <?php echo $item->type_link == 0? 'selected="selected"':'' ?>><?php echo FSText::_('Trong website'); ?></option>
                                    <option value="1" <?php echo $item->type_link == 1? 'selected="selected"':'' ?>><?php echo FSText::_('Ngoài website'); ?></option>
                                </select>
                            </td>
                            <td><a onclick="save_key(<?php echo $item->id; ?>)" class="btn btn-outline btn-success"><?php echo FSText::_('Save'); ?></a></td>
                            <td>
                                <a onclick="delete_key(<?php echo $item->id; ?>)" class="btn btn-outline btn-danger btn delete_<?php echo $item->id ?>">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        <?php } ?>
                     <?php } ?>   
                    </tbody>
                </table>
                <a id="add_key" style="color: #fff;" class="btn btn-primary" > 
                    <i class="fa fa-plus-circle"></i>
                    <?php echo FSText::_('Add') ?>
                </a>
                <input type="hidden" id="add_id" value="0" />
            	<input type="hidden" id="add_stt" value="<?php echo count($list_key); ?>" />
                <input type="hidden" id="new_id" value="<?php echo @$data->id? $data->id:$uploadConfig; ?>" />
            </div><!-- END: table-responsive -->
        </div>
        <p class="help-block">1.Keyword: từ khóa tìm kiếm trong nội dung bài viết.</p>
        <p class="help-block">2.Keyword replace: từ khóa thay thế Keyword khi tìm thấy có Keyword trong nội dung bài viết,nếu để trống mặc định sẽ lấy tiêu đề của bài viết hiện tại.</p>
        <p class="help-block">3.Link: link điều hướng,nếu để trống mặc định sẽ lấy link của bài viết hiện tại.(nếu là link ngoài website yêu cầu nhập đầy đủ - VD: http://dantri.com.vn/)</p>
        <p class="help-block">4.Loại seo: chọn trong bài viết thì dùng tối ưu seo trong chính nội dung bài viết hiện tại(trạng thái: tắt tự động seo),chọn ngoài bài viết sẽ phục vụ cho các bài tích chọn auto seo(trạng thái: bật tự động seo).</p>
        <p class="help-block">5.Loại link: link trong website tối đa sẽ chỉ có 3 keyword(thuộc loại link trong website) trong 1 bài viết,
         link ngoài website sẽ không bị giới hạn như loại link trong(chỉ có 1/nhiều Keyword thuộc loại link ngoài của 1 bài viết được nằm trong nội dung bài seo khác.).</p>
    </div><!--end: .form-contents-->
</div>
<style>
    
    .keyword .form-group {
        margin-right: 0px;
        margin-left: 0px;
    }
    #snackbar {
        visibility: hidden;
        min-width: 250px;
        margin-left: -125px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 2px;
        padding: 16px;
        position: fixed;
        z-index: 1;
        left: 50%;
        bottom: 30px;
        font-size: 17px;
    }
    
    #snackbar.show {
        visibility: visible;
        -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
        animation: fadein 0.5s, fadeout 0.5s 2.5s;
    }
    
    @-webkit-keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    
    @keyframes fadein {
        from {bottom: 0; opacity: 0;}
        to {bottom: 30px; opacity: 1;}
    }
    
    @-webkit-keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
    
    @keyframes fadeout {
        from {bottom: 30px; opacity: 1;}
        to {bottom: 0; opacity: 0;}
    }
</style>

<script>
// add form keyword
$(document).ready(function(){
    $("#add_key").click(function(){
        var id = $('#add_id').val();
        var stt = $('#add_stt').val();
        id = parseInt(id) + 1;
        stt = parseInt(stt) + 1;
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=news&view=news&task=add_html&raw=1',
            data: {id: id,stt:stt},
            dataType: 'html',
            success: function(data) {
                $('#keywordInput').append(data);
                $('#add_id').val(id);
                $('#add_stt').val(stt);
            },
            error: function() {
                // code here
            }
        });
    });
});

function myFunction() {
    // Get the snackbar DIV
    var x = document.getElementById("snackbar")
    // Add the "show" class to DIV
    x.className = "show";
    // After 3 seconds, remove the show class from DIV
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}

// delete
function delete_key(id){
    $('#snackbar').remove();
    $.ajax({
        type: 'POST',
        url: 'index2.php?module=news&view=news&task=delete_key&raw=1',
        data: {id: id},
        dataType: 'text',
        success: function(data) {
            if(data == 1){
                $('.delete_'+id).parent('td').parent('tr').remove();
                $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Đã xóa.') ?></div>');
            }else{
                $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Lỗi không xóa được.') ?></div>');
            }
            myFunction();
        },
        error: function() {
            $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Lỗi không xóa được.') ?></div>');
            myFunction();
        }
    });
}
// create link
function created_indirect(link,created_link_id,results_id){
	$('#'+results_id).val(link);
	window.open("index2.php?module=news&view=news&task=add_param&id="+created_link_id+"&results_id="+results_id, "","height=600,width=700,menubar=0,resizable=1,scrollbars=1,statusbar=0,titlebar=0,toolbar=0");
}
// save
function save_key(id){
    
    $('#snackbar').remove();
    var new_id = $('#new_id').val();
    if(!new_id){
        $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Không lưu được') ?></div>');
        myFunction();
        return false;
    }
    var add_id = $('#add_id').val();
    if(id == 0){
        var key_name = $('#add_input_key_'+add_id).val();
        var key_replace = $('#add_input_replace_'+add_id).val();
        var link_add = $('#add_link_'+add_id).val();
        var type_add = $('#add_type_'+add_id).val();
        var type_link_add = $('#add_type_link_'+add_id).val();
        var stt_add = $('#add_stt_'+add_id).val();
        var item_id = $('#add_item_'+add_id);
    }else{
        var key_name = $('#input_key_'+id).val();
        var key_replace = $('#input_replace_'+id).val();
        var link_add = $('#link_'+id).val();
        var type_add = $('#type_'+id).val();
        var type_link_add = $('#type_link_'+id).val();
        var stt_add = $('#stt_'+id).val();
        var item_id = $('#item_'+id);
    }
    if(!key_name){
        $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Bạn chưa nhập từ khóa.') ?></div>');
        myFunction();
        return false;
    }
    //if(!key_replace){
    //    $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Bạn chưa nhập từ khóa thay thế.') ?></div>');
    //    myFunction();
    //    return false;
    //}
    //if(!link_add){
//        $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Bạn chưa nhập link.') ?></div>');
//        myFunction();
//        return false;
//    }
    
    $.ajax({
        type: 'POST',
        url: 'index2.php?module=news&view=news&task=save_key&raw=1',
        data: {ids: id,key_name:key_name,key_replace:key_replace,link_add:link_add,type_add:type_add,type_link:type_link_add,stt_add:stt_add,new_id:new_id},
        contentType: "application/x-www-form-urlencoded; charset=UTF-8",
        dataType: 'html', 
        success: function(data) {
            if(data){
                item_id.html(data);
                $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Lưu thành công') ?></div>');
            }else{
                $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Không lưu được') ?></div>');
            }
            myFunction();
        },
        error: function() {
            $('#keywordInput').append('<div id="snackbar"><?php echo FSText::_('Không lưu được') ?></div>');
            myFunction();
            // code here
        }
    });
}

</script>
