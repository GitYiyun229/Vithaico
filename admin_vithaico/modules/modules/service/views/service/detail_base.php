
<div class="form-group">
    <div class="col-xs-12">
        <div class="keyword">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50px">STT</th>
                        <th><?php echo FSText::_('Số tuần'); ?></th>
                        <th><?php echo FSText::_('giảm giá') ?></th>
                        <th width="50px">%</th>
                        <th width="50px"><?php echo FSText::_('save'); ?></th>
                        <th width="50px"><?php echo FSText::_('Xóa'); ?></th>
                    </tr>
                </thead>
                
                <tbody id="service_config" >
                    <?php if(count($list_quanrity)){ ?>
                    <?php $i = 1; foreach($list_quanrity as $item){ ?>
                        <tr id="item_<?php echo $item->id ?>">
                            <td class="stt"><?php echo $i; ?></td>
                            <td>
                                <input class="form-control" type="number" id="item_quanrity_<?php echo $item->id ?>" min="1"  value="<?php echo $item->quanrity ?>"/>
                            </td>
                            <td>
                                <input class="form-control" type="number" id="item_sale_<?php echo $item->id ?>" min="0" value="<?php echo $item->sale ?>"  />
                            </td>
                            <td><p class="help-block">%</p></td>
                            <td>
                                <a class="btn btn-outline btn-primary save" onclick="save_item(<?php echo $item->id ?>,1)">
                                    <i class="fa fa-save"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-outline btn-danger delete" onclick="delete_item(<?php echo $item->id ?>,1)" >
                                    <i class="fa fa-remove"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $i++;} ?>
                    <?php } ?>
                </tbody>
            </table>
            <!-- END: -->
        </div>
        <!-- END: -->
    </div>
    <!-- END: -->
</div>

<div class="form-group">
    <div class="col-xs-12">
        <a id="add_item" style="color: #fff;" class="btn btn-primary"> 
            <i class="fa fa-plus-circle"></i>
            <?php echo FSText::_('Thêm mới'); ?>
        </a>
    </div>
</div>

<?php $id = FSInput::get2('id',0,'int'); ?>
<input type="hidden" id="add_count" value="1" />
<input type="hidden" id="add_stt" value="<?php echo count($list_quanrity); ?>" />

<div id="snackbar"></div>
<script>
// add form keyword
$(document).ready(function(){
    var root = '/';
    var html = '',service_config = $('#service_config'),add_count = $('#add_count');
    $("#add_item").click(function(){
        html = '';
        var add_val = add_count.val();
        
        html += '<tr id="add_'+add_val+'">';
        html += '<td class="stt"></td>';
        html += '<td><input class="form-control" type="number" id="add_quanrity_'+add_val+'" min="1"  value="1"/></td>';
        html += '<td><input class="form-control" type="number" id="add_sale_'+add_val+'" value="0" min="0" /></td>';
        html += '<td><p class="help-block">%</p></td>';
        html += '<td><a class="btn btn-outline btn-primary save" onclick="save_item('+add_val+')" ><i class="fa fa-save"></i></a></td>';
        html += '<td><a class="btn btn-outline btn-danger delete" onclick="delete_item('+add_val+')" ><i class="fa fa-remove"></i></a></td>';
        html += '</tr>';
        
        add_val = parseInt(add_val) + 1;
        // add count
        add_count.val(add_val);
        // add html
        service_config.append(html);
        // ordering
        ordering();
    });
    
});

function save_item(id,is_save = 0){
    var root = '/';
    
    if(!id)
        return false;
    
    if(is_save){
       var _item = 'item_'; 
       var ids = id;
    }else{
      var _item = 'add_';
      var ids = 0;  
    }
        
    var stt = $('#stt').val(),service_id = $('#service_id').val();
    
    var quanrity = $('#'+ _item +'quanrity_'+id).val();
    if(quanrity <= 0){
        myFunction('Số lượng phải lớn hơn 0');
        return false;
    }
    
    var sale = $('#'+ _item +'sale_'+id).val();
    if(sale < 0){
        myFunction('giá trị giảm giá phải lớn hơn hoặc bằng 0');
        return false;
    }
    
    $.ajax({
        type: 'POST',
        url: 'index2.php?module=service&view=service&task=save_item&raw=1',
        data: {quanrity: quanrity,sale:sale,stt:stt,service_id:service_id,ids:ids},
        dataType: 'json',
        success: function(data) {
            if(data.error == true){
                $('#'+ _item + id).html(data.html);
                $('#'+ _item + id).attr('id','item_'+data.id);
                ordering();// ordering
                myFunction('Lưu thành công');
            }else{
                myFunction('Không lưu được');
            }
        },
        error: function() {
            // code here
            myFunction('lỗi không connect server');
        }
    });
}

function ordering(){
    var stt = $('.stt');
    stt.each(function( index ) {
        $(this).text(index + 1);
    });
}

function delete_item(id,is_item = 0){
    if(!id)
        return false;
    
    if(is_item){
        var _item = 'item_'; 
        var ids = id;
        
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=service&view=service&task=delete_item&raw=1',
            data: {ids: ids},
            dataType: 'text',
            success: function(data) {
                if(data == 1){
                    $('#'+ _item + id).remove();
                    ordering();// ordering
                }else{
                    myFunction('lỗi không được');
                }
            },
        });
    }else{
        var _item = 'add_';
        var ids = 0;  
        $('#'+ _item + id).remove();
        ordering();// ordering
    }
}

</script>