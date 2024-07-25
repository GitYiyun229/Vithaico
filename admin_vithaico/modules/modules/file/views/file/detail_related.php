<div class="news_related">
    <div class="row">
            <div class="col-xs-12">
                <div class='news_related_search row'>
                    <div class="row-item col-xs-6" style="margin-bottom: 20px;">
    					<select class="form-control chosen-select"  name="news_related_category_id"  id="news_related_category_id">
    						<option value="">Danh mục</option>
    						<?php 
    						foreach ($categories as $item) {
    						?>
    							<option value="<?php echo $item->id; ?>" ><?php echo $item->treename;  ?> </option>	
    						<?php }?>
    					</select>
                    </div>
                    <div class="row-item col-xs-6">
                        <div class="input-group custom-search-form">
                            <input type="text" placeholder="Tìm kiếm" name='news_related_keyword' class="form-control" value='' id='news_related_keyword' />
                            <span class="input-group-btn">
                                <a id='news_related_search' class="btn btn-default">
                                    <i class="fa fa-search"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>    
            <div class="col-xs-12 col-md-6">
                <div class='title-related'><?php echo FSText::_('Danh sách tin liên quan'); ?></div>            
                <div id='news_related_l' >                
    				<div id='news_related_search_list'>
                        <input type="hidden" value="<?php echo @$data->news_related ?>" id="str_related" name="str_related" />
                    </div>
    			</div>
            </div>
            
    		<div class="col-xs-12 col-md-6">
    			<div id='news_related_r'>
    				<!--	LIST RELATE			-->
    				<div class='title-related'><?php echo FSText::_('Tin liên quan'); ?></div>
					<ul id='news_sortable_related'>	
						<?php
						$i = 0; 
						if(isset($news_related))
						foreach ($news_related as $item) { 
						?>
							<li id='news_record_related_<?php echo $item ->id?>'><?php echo $item -> title; ?> 
								<a class='news_remove_relate_bt'  onclick="javascript: remove_news_related(<?php echo $item->id?>)" href="javascript: void(0)" title='Xóa'>
									<img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
								</a> 
								<br />
								<img  width="80" src="<?php echo URL_ROOT.str_replace('/original/','/resized/',$item->image);?>">
								<input type="hidden" name='news_record_related[]' value="<?php echo $item -> id;?>" />
							</li>
						<?php }?>
					</ul>
    				<!--	end LIST RELATE			-->
    				<div id='news_record_related_continue'></div>
    			</div>
    		</div>
            
            <!--<div class='news_close_related col-xs-12' style="display:none">
        		<a href="javascript:news_close_related()"><strong class='red'>Đóng</strong></a>
        	</div>
        	<div class='news_add_related col-xs-12'>
        		<a href="javascript:news_add_related()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
        	</div> -->
    </div>
</div>
<script type="text/javascript" >
search_news_related();
$( "#news_sortable_related" ).sortable();
function news_add_related(){
	$('#news_related_l').show();
	$('#news_related_l').attr('width','50%');
	$('#news_related_r').attr('width','50%');		
	$('.news_close_related').show();
	$('.news_add_related').hide();
}
function news_close_related(){
	$('#news_related_l').hide();
	$('#news_related_l').attr('width','0%');
	$('#news_related_r').attr('width','100%');		
	$('.news_add_related').show();
	$('.news_close_related').hide();
}
$(document).ready( function(){
    var str_related = $('#str_related').val();
    var keyword_tag = $('#tags').val();
    if(keyword_tag){
      $("#news_related_search_list" ).load( "index2.php?module=news&view=news&task=ajax_get_news_related&raw=1",{"str_related":str_related,"keyword_tag":keyword_tag},function(){}); //load initial records  
    }
    
    $('textarea#tags').on('change',function(){
        //alert(123);
        var keyword_tag = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'index2.php?module=news&view=news&task=ajax_get_news_related&raw=1',
            data: {keyword_tag: keyword_tag,str_related:str_related},
            dataType: 'html',
            success: function(data) {
                $('#news_related_search_list').html(data);
            },
            error: function() {
                // code here
            }
        });
    
    });
});
function search_news_related(){
	$('#news_related_search').click(function(){
		var keyword = $('#news_related_keyword').val();
		var category_id = $('#news_related_category_id').val();
		var new_id = <?php echo @$data -> id?$data -> id:0?>;
		var str_exist = '';
		$( "#news_sortable_related li input" ).each(function( index ) {
			if(str_exist != '')
				str_exist += ',';
			str_exist += 	$( this ).val();
		});
		$.get("index2.php?module=news&view=news&task=ajax_get_news_related&raw=1",{new_id:new_id,category_id:category_id,keyword:keyword,str_exist:str_exist}, function(html){
			$('#news_related_search_list').html(html);
		});
	});
}
function set_news_related(id){
	var max_related = 10;
	var length_children = $( "#news_sortable_related li" ).length;
	if(length_children >= max_related ){
		alert('Tối đa chỉ có '+max_related+' tin liên quan'	);
		return;
	}
	var title = $('.news_related_item_'+id).html();                                     
	var html = '<li id="news_record_related_'+id+'">'+title+'<input type="hidden" name="news_record_related[]" value="'+id+'" />';
	html += '<a class="news_remove_relate_bt"  onclick="javascript: remove_news_related('+id+')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
	html += '</li>';
	$('#news_sortable_related').append(html);
	$('.news_related_item_'+id).hide();	
}
function remove_news_related(id){
    var str_related = $('#str_related').val();
    var keyword_tag = $('#tags').val();
	$('#news_record_related_'+id).remove();
	$('.news_related_item_'+id).show().addClass('red');	
    $.ajax({
        type: 'POST',
        url: 'index2.php?module=news&view=news&task=ajax_get_news_related&raw=1',
        data: {id: id,str_related:str_related,keyword_tag:keyword_tag},
        dataType: 'html',
        success: function(data) {
            $('#news_related_search_list').html(data);
        },
        error: function() {
            // code here
        }
    });
}
</script>
<style>
.title-related{
	 background: none repeat scroll 0 0 #F0F1F5;
    font-weight: bold;
    margin-bottom: 4px;
    padding: 2px 0 4px;
    text-align: center;
    width: 100%;
}
#news_related_search_list{
	height: 400px;
    overflow: scroll;
}
.news_related_item{
    border-bottom: 1px solid #EEEEEE;
    cursor: pointer;
    margin: 2px 10px;
    padding: 5px;
}
#news_sortable_related li{
	cursor: move;
    list-style: decimal outside none;
    margin-bottom: 8px;
}
.news_remove_relate_bt{
	padding-left: 10px;
}
.news_related table{
	margin-bottom: 5px;
}
</style>