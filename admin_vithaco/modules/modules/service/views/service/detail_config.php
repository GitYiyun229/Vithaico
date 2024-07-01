
<div class="form-group">
    <div class="col-xs-12">
        <div class="">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50px">STT</th>
                        <th><?php echo FSText::_('Số lượng Giá trị(Nếu có 2 giá trị thì cách nhau dấu phẩy)'); ?></th>
                        <th><?php echo FSText::_('Chọn điều kiện tính toán') ?></th>
                        <th><?php echo FSText::_('giảm giá') ?></th>
                        <th width="50px">%</th>
                        <th width="50px"><?php echo FSText::_('save'); ?></th>
                        <th width="50px"><?php echo FSText::_('Xóa'); ?></th>
                    </tr>
                </thead>
                
                <tbody id="service_config2" >
                    <?php if(count($list_quanrity2)){ ?>
                    <?php $i = 1; foreach($list_quanrity2 as $item){ ?>
                        <tr id="item2_<?php echo $item->id ?>">
                            <td class="stt2"><?php echo $i; ?></td>
                            <td>
                                <input class="form-control" type="text" id="item2_quanrity_<?php echo $item->id ?>" value="<?php echo $item->quanrity_text ?>"/>
                            </td>
                            <td>
                                <select class="form-control chosen-select" id="item2_calculators_<?php echo $item->id ?>">
                                    <?php foreach($calculators as $key => $value){ 
                                    ?>
                                    <option value="<?php echo $key; ?>" <?php echo $item->calculators_int == $key? 'selected="selected"':''; ?>  ><?php echo $value; ?></option>
                                    <?php } ?>
                                </select>
                            </td>
                            <td>
                                <input class="form-control" type="number" id="item2_sale_<?php echo $item->id ?>" min="0" value="<?php echo $item->sale ?>"  />
                            </td>
                            <td><p class="help-block">%</p></td>
                            <td>
                                <a class="btn btn-outline btn-primary save" onclick="save2_item(<?php echo $item->id ?>,1)">
                                    <i class="fa fa-save"></i>
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-outline btn-danger delete" onclick="delete2_item(<?php echo $item->id ?>,1)" >
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
        <a id="add_item2" style="color: #fff;" class="btn btn-primary"> 
            <i class="fa fa-plus-circle"></i>
            <?php echo FSText::_('Thêm mới'); ?>
        </a>
    </div>
</div>

<?php $id = FSInput::get2('id',0,'int'); ?>
<input type="hidden" id="add_count2" value="1" />
<input type="hidden" id="add_stt2" value="<?php echo count($list_quanrity2); ?>" />
<input type="hidden" id="calculators" value='<?php echo json_encode($calculators); ?>' />

<div id="snackbar"></div>
<script type="text/javascript">
// add form keyword
$(document).ready(function(){
    var root = '/';
    var html = '',service_config = $('#service_config2'),add_count = $('#add_count2');
    
    
    $("#add_item2").click(function(){
        
        var obj = $('#calculators').val();
        obj = obj? JSON.parse(obj):[];
        html = '';
        var add_val = add_count.val();
        
        html += '<tr id="add2_'+add_val+'">';
        html += '<td class="stt2"></td>';
        html += '<td><input class="form-control" type="text" id="add2_quanrity_'+add_val+'" value=""/></td>';
        html += '<td>';
        html += '<select class="form-control chosen-select" id="add2_calculators_'+add_val+'">';
        html += '<option value=""><?php echo FSText::_('Tính toán') ?></option>';
        for (prop in obj) {
            html += '<option value="'+prop+'">'+obj[prop]+'</option>';
        }
        html += '</select>';
        html += '</td>';
        html += '<td><input class="form-control" type="number" id="add2_sale_'+add_val+'" value="0" min="0" /></td>';
        html += '<td><p class="help-block">%</p></td>';
        html += '<td><a class="btn btn-outline btn-primary save" onclick="save2_item('+add_val+')" ><i class="fa fa-save"></i></a></td>';
        html += '<td><a class="btn btn-outline btn-danger delete" onclick="delete2_item('+add_val+')" ><i class="fa fa-remove"></i></a></td>';
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

function save2_item(id,is_save = 0){
    if(!id)
        return false;
    
    if(is_save){
       var _item = 'item2_'; 
       var ids = id;
    }else{
      var _item = 'add2_';
      var ids = 0;  
    }
        
    var stt = $('#stt').val(),service_id = $('#service_id').val();
    
    var quanrity = $('#'+ _item +'quanrity_'+id).val();
    if(!quanrity){
        myFunction('yêu cầu nhập số lượng');
        return false;
    }
    
    var calculators = $('#'+ _item +'calculators_'+id).val();
    if(!calculators){
        myFunction('yêu cầu chọn điều kiện tính toán');
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
        data: {
            quanrity_text: quanrity,
            sale:sale,
            stt:stt,
            service_id:service_id,
            ids:ids,
            calculators:calculators,
            type:1
            },
        dataType: 'json',
        success: function(data) {
            if(data.error == true){
                $('#'+ _item + id).html(data.html);
                $('#'+ _item + id).attr('id','item2_'+data.id);
                ordering2();// ordering
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

function ordering2(){
    var stt = $('.stt2');
    stt.each(function( index ) {
        $(this).text(index + 1);
    });
}

function delete2_item(id,is_item = 0){
    if(!id)
        return false;
    
    if(is_item){
        var _item = 'item2_'; 
        var ids = id;
        
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=service&view=service&task=delete_item&raw=1',
            data: {ids: ids},
            dataType: 'text',
            success: function(data) {
                if(data == 1){
                    $('#'+ _item + id).remove();
                    ordering2();// ordering
                }else{
                    myFunction('lỗi không được');
                }
            },
        });
    }else{
        var _item = 'add2_';
        var ids = 0;  
        $('#'+ _item + id).remove();
        ordering2();// ordering
    }
}

</script>