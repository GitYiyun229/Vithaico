<div class="products_compatable">
	<div class="row">
		<div class="col-xs-12">
			<div class='products_compatable_search row'>
				<div class="row-item col-xs-6" style="margin-bottom: 20px;">
					<select class="form-control chosen-select" name="products_compatable_category_id" id="products_compatable_category_id">
						<option value="">Danh mục</option>
						<?php
						foreach ($categories as $item) {
						?>
							<option value="<?php echo $item->id; ?>"><?php echo $item->treename;  ?> </option>
						<?php } ?>
					</select>
				</div>
				<div class="row-item col-xs-6">
					<div class="input-group custom-search-form">
						<input type="text" placeholder="Tìm kiếm" name='products_compatable_keyword' class="form-control" value='' id='products_compatable_keyword' />
						<span class="input-group-btn">
							<a id='products_compatable_search' class="btn btn-default">
								<i class="fa fa-search"></i>
							</a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-6">
			<div class='title-compatable'>Danh sách phụ kiện</div>
			<div id='products_compatable_l'>
				<div id='products_compatable_search_list'></div>
			</div>
		</div>

		<div class="col-xs-12 col-md-6">
			<div id='products_compatable_r'>
				<!--	LIST RELATE			-->
				<div class='title-compatable'>Phụ kiện mua kèm</div>
				<ul id='products_sortable_compatable'>
					<?php
					$i = 0;
					if (isset($products_compatable))
						foreach ($products_compatable as $item) {
					?>
						<li id='products_record_compatable_<?php echo $item->id ?>'><?php echo $item->name; ?>
							<a class='products_remove_compatable_bt' onclick="javascript: remove_products_compatable(<?php echo $item->id ?>)" href="javascript: void(0)" title='Xóa'>
								<img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png">
							</a>
							<br />
							<img width="80" src="<?php echo URL_ROOT . str_replace('/original/', '/resized/', $item->image); ?>">
							<input type="hidden" name='products_record_compatable[]' value="<?php echo $item->id; ?>" />
						</li>
					<?php } ?>
				</ul>
				<!--	end LIST RELATE			-->
				<div id='products_record_compatable_continue'></div>
			</div>
		</div>

		<!--<div class='products_close_compatable col-xs-12' style="display:none">
        		<a href="javascript:products_close_compatable()"><strong class='red'>Đóng</strong></a>
        	</div>
        	<div class='products_add_compatable col-xs-12'>
        		<a href="javascript:products_add_compatable()"><strong class='red'>Thêm sản phẩm liên quan</strong></a>
        	</div> -->
	</div>
</div>
<script type="text/javascript">
	//search_products_compatable();
	// $("#products_sortable_compatable").sortable();

	function products_add_compatable() {
		$('#products_compatable_l').show();
		$('#products_compatable_l').attr('width', '50%');
		$('#products_compatable_r').attr('width', '50%');
		$('.products_close_compatable').show();
		$('.products_add_compatable').hide();
	}

	function products_close_compatable() {
		$('#products_compatable_l').hide();
		$('#products_compatable_l').attr('width', '0%');
		$('#products_compatable_r').attr('width', '100%');
		$('.products_add_compatable').show();
		$('.products_close_compatable').hide();
	}
	//function search_products_compatable(){
	$("#products_compatable_category_id").change(function() {
		var category_id = $('#products_compatable_category_id').val();
		var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
		var str_exist = '';
		products_compatable(keyword = null, category_id, product_id, str_exist)
	})
	$('#products_compatable_search').on('click', function() {
		var keyword = $('#products_compatable_keyword').val();
		if (keyword == '' || keyword == null) {
			alert('Bạn chưa nhập từ khóa tìm kiếm');
			return
		}
		var category_id = $('#products_compatable_category_id').val();
		var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
		var str_exist = '';
		products_compatable(keyword, category_id = null, product_id, str_exist);
	});
	$('#products_compatable_keyword').on('keyup', function(e) {
		if (e.key === 'Enter' || e.keyCode === 13) {
			var keyword = $('#products_compatable_keyword').val();
			if (keyword == '' || keyword == null) {
				alert('Bạn chưa nhập từ khóa tìm kiếm');
				return
			}
			var category_id = $('#products_compatable_category_id').val();
			var product_id = <?php echo @$data->id ? $data->id : 0 ?>;
			var str_exist = '';
			products_compatable(keyword, category_id = null, product_id, str_exist);
		}
	});
	//}
	function products_compatable(keyword, category_id, product_id, str_exist){

		$("#products_sortable_compatable li input").each(function(index) {
			if (str_exist != '')
				str_exist += ',';
			str_exist += $(this).val();
		});
		$.get("index2.php?module=products&view=products&task=ajax_get_products_compatable&raw=1", {
			product_id: product_id,
			keyword: keyword,
			category_id: category_id,
			str_exist: str_exist
		}, function(html) {
			$('#products_compatable_search_list').html(html);
		});
	}
	function set_products_compatable(id) {
		var max_compatable = 10;
		var length_children = $("#products_sortable_compatable li").length;
		if (length_children >= max_compatable) {
			alert('Tối đa chỉ có ' + max_compatable + ' sản phẩm');
			return;
		}
		var title = $('.products_compatable_item_' + id).html();
		var html = '<li id="products_record_compatable_' + id + '">' + title + '<input type="hidden" name="products_record_compatable[]" value="' + id + '" />';
		html += '<a class="products_remove_relate_bt"  onclick="javascript: remove_products_compatable(' + id + ')" href="javascript: void(0)" title="Xóa"><img border="0" alt="Remove" src="templates/default/images/toolbar/remove_2.png"></a>';
		html += '</li>';

		$('#products_sortable_compatable').append(html);
		$('.products_compatable_item_' + id).hide();
	}

	function remove_products_compatable(id) {
		$('#products_record_compatable_' + id).remove();
		$('.products_compatable_item_' + id).show().addClass('red');
	}
</script>
<style>
	.title-compatable {
		background: none repeat scroll 0 0 #F0F1F5;
		font-weight: bold;
		margin-bottom: 4px;
		padding: 2px 0 4px;
		text-align: center;
		width: 100%;
	}

	#products_compatable_search_list {
		height: 400px;
		overflow: scroll;
	}

	.products_compatable_item {
		background: url("/admin/images/page_next.gif") no-repeat scroll right center transparent;
		border-bottom: 1px solid #EEEEEE;
		cursor: pointer;
		margin: 2px 10px;
		padding: 5px;
	}

	#products_sortable_compatable li {
		cursor: move;
		list-style: decimal outside none;
		margin-bottom: 8px;
	}

	.products_remove_relate_bt {
		padding-left: 10px;
	}

	.products_compatable table {
		margin-bottom: 5px;
	}
</style>