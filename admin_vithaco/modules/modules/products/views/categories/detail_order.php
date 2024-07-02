<div class="products_order">
    <table width="100%" bordercolor="#AAA" border="1">
        <tr valign="top">
            <td width="0%" id='products_order_l' style="display:none" >
                <div class='products_order_search'>
                    <span>Tìm kiếm: </span>
                    <input type="text" name='products_order_keyword' value='' id='products_order_keyword' />
                    <select class="select2-cat" name="products_order_category_id"  id="products_order_category_id">
                        <option value="">Danh mục</option>
                        <?php
                        foreach ($products_categories as $item) {
                            ?>
                            <option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>
                        <?php }?>
                    </select>
                    <input type="button" name='products_order_search' value='Tìm kiếm' id='products_order_search' />
                </div>
                <div id='products_order_search_list'>
                </div>
            </td>
            <td width="100%" id='products_order_r'>
                <!--	LIST RELATE			-->
                <div class='title'>Sản phẩm ưu tiên hiện trước</div>
                <ul id='products_sortable_order'>
                    <?php
                    $i = 0;
                    if(isset($products_order))
                    foreach ($products_order as $item) { ?>
                        <li id='products_record_order_<?php echo $item ->id?>'>
                            <img src="<?php echo URL_ROOT.str_replace('/orgininal/','/reszied/',$item->image) ?>" alt="" width="50" height="50">
                            <?php echo $item -> name; ?> 
                            <a class='products_remove_order_bt'  onclick="javascript: remove_products_order(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'>
                            <img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a> 
                            <input type="hidden" name='products_record_order[]' value="<?php echo $item -> id;?>" />
                        </li>
                <?php }?>
                </ul>
                <!--	end LIST RELATE			-->
                <div id='products_record_order_continue'></div>
            </td>
        </tr>
    </table>
    <div class='products_close_order' style="display:none">
        <a href="javascript:products_close_order()"><strong class='red'>Đóng</strong></a>
    </div>
    <div class='products_add_order'>
        <a href="javascript:products_add_order()"><strong class='red'>Thêm sản phẩm</strong></a>
    </div>
</div>
<script type="text/javascript" >
    search_products_order();
    $( "#products_sortable_order" ).sortable();
    function products_add_order(){
        $('#products_order_l').show();
        $('#products_order_l').attr('width','50%');
        $('#products_order_r').attr('width','50%');
        $('.products_close_order').show();
        $('.products_add_order').hide();
        $('.select2-cat').select2();
    }
    function products_close_order(){
        $('#products_order_l').hide();
        $('#products_order_l').attr('width','0%');
        $('#products_order_r').attr('width','100%');
        $('.products_add_order').show();
        $('.products_close_order').hide();
        $('.select2-cat').select2('destroy');
    }
    function search_products_order(){
        $('#products_order_search').click(function(){
            var keyword = $('#products_order_keyword').val();
            var category_id = $('#products_order_category_id').select2('val');
            var str_exist = '';
            $( "#products_sortable_order li input" ).each(function( index ) {
                if(str_exist != '')
                    str_exist += ',';
                str_exist += 	$( this ).val();
            });
            $.get("index2.php?module=products&view=categories&task=ajax_get_products_order&raw=1",{category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
                $('#products_order_search_list').html(html);
            });
        });
    }
    function set_products_order(id){
        var max_related = 10;
        var length_children = $( "#products_sortable_order li" ).length;
        if(length_children >= max_related ){
            alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
            return;
        }
        var title = $('.products_order_item_'+id).html();
        var html = '<li id="record_order_'+id+'">'+title+'<input type="hidden" name="products_record_order[]" value="'+id+'" />';
        html += '<a class="products_remove_order_bt"  onclick="javascript: remove_products_order('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
        html += '</li>';
        $('#products_sortable_order').append(html);
        $('.products_order_item_'+id).hide();
    }
    function remove_products_order(id){
        $('#products_record_order_'+id).remove();
        $('.products_order_item_'+id).show().addClass('red');
        $('#record_order_'+id).remove();
    }
</script>
<style>
    .products_order_search, #products_order_r .title{
        background: none repeat scroll 0 0 #F0F1F5;
        font-weight: bold;
        margin-bottom: 4px;
        padding: 2px 0 4px;
        text-align: center;
    }
    #products_order_search_list{
        height: 400px;
        overflow: scroll;
    }
    .products_order_item{
        background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
        border-bottom: 1px solid #EEEEEE;
        cursor: pointer;
        margin: 2px 10px;
        padding: 5px;
    }
    #products_sortable_order li{
        cursor: move;
        list-style: decimal outside none;
        margin-bottom: 8px;
    }
    .products_remove_order_bt{
        padding-left: 10px;
    }
    .products_order table{
        margin-bottom: 5px;
    }
</style>