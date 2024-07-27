<link rel="stylesheet" href="/modules/products/assets/css/select2.min.css">
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/products.css" />
<link rel="stylesheet" href="templates/default/css/bootstrap-datetimepicker.min.css">
<link href="templates/default/dist/css/style_thongke.css" rel="stylesheet">
<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
<script src="/modules/products/assets/js/select2.min.js"></script>
<?php
echo '';
?>
<script>
	$(document).ready(function() {
		$("#tabs").tabs();
		$('.select2').select2();
	});
</script>
<?php
$title = @$data ? FSText::_('Edit') : FSText::_('Add');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('apply', FSText::_('Apply'), '', 'apply.png');
$toolbar->addButton('cancel', FSText::_('Cancel'), '', 'cancel.png');
$this->dt_form_begin(1, 4, 'Thống kê');
?>
<input type="hidden" name="array_f1" id="array_f1" value="<?= $orderIdF1 ?>">
<div id="tabs" class="row">
	<div class="member-inffo">
		<div class="member-profile">
			<div class="frame">
				<div class="center">

					<div class="profile">
						<div class="profile-rank">
							<?php if (!empty($rank_member->image)) : ?>
								<img src="<?php echo URL_ROOT . $rank_member->image ?>" alt="">
							<?php endif; ?>
						</div>
						<div class="image">

							<div class="circle-1"></div>
							<div class="circle-2"></div>
							<img style="object-fit: cover;" src="<?php echo URL_ROOT . $data->image ?>" onerror="this.src='/images/user-customer-icon.svg'" width="70" height="70" alt="Jessica Potter">
						</div>
						<div class="name">Thông tin thành viên</div>
						<div class="name"><?= @$data->full_name ?></div>
						<div class="job">Phone: <?= @$data->telephone ?></div>
						<div class="job">Email: <?= @$data->email ?></div>
					</div>
					<div class="stats">
						<div class="box">
							<span class="parameter">Affliate</span>
							<span class="value"><?= @$data->hoa_hong ? @$data->hoa_hong : '0' ?>%</span>
						</div>
						<div class="box">
							<span class="parameter">
								<input type="text" value="<?= FSRoute::_('index.php?module=members&view=user&task=register') ?><?= '?affiliate=' . $data->ref_code ?>" class="form-control link_aff_copy" id="link_aff" name="link_aff">
								<a onclick="myFunction()" class="position-absolute top-50 end-0 translate-middle-y px-4">
									Link giới thiệu <img src="/modules/members/assets/images/icon-copy.svg" alt="img-copy">
								</a>
							</span>
						</div>
						<div class="box">
							<span class="value"><?= @$data->end_time ?></span></span>
							<span class="parameter">Thời gian duy trì tài khoản</span>
						</div>
						<div class="box">
							<span class="value"><?= @$data->due_time_month ?></span>
							<span class="parameter">Thời gian gia hạn tài khoản theo tháng</span>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="member-profile">
			<div class="frame">
				<div class="center">

					<div class="profile">
						<div class="profile-rank">
							<?php if (!empty($rank_member_f0->image)) : ?>
								<img src="<?php echo URL_ROOT . $rank_member_f0->image ?>" alt="">
							<?php endif; ?>
						</div>
						<div class="image">

							<div class="circle-1"></div>
							<div class="circle-2"></div>
							<img style="object-fit: cover;" src="<?php echo URL_ROOT . $data_f0->image ?>" onerror="this.src='/images/user-customer-icon.svg'" width="70" height="70" alt="Jessica Potter">
						</div>

						<div class="name">Thông tin thành viên giới thiệu</div>
						<div class="name"><?= @$data_f0->full_name ?></div>
						<div class="job">Phone: <?= @$data_f0->telephone ?></div>
						<div class="job">Email: <?= @$data_f0->email ?></div>


					</div>

					<div class="stats">
						<div class="box">
							<span class="parameter">Affliate</span>
							<span class="value"><?= @$data_f0->hoa_hong ? @$data_f0->hoa_hong : '0' ?>%</span>
						</div>
						<div class="box">
							<span class="parameter">
								<input type="text" value="<?= FSRoute::_('index.php?module=members&view=user&task=register') ?><?= '?affiliate=' . $data_f0->ref_code ?>" class="form-control link_aff_copy" id="link_afff0" name="link_afff0">
								<a onclick="myFunction1()" class="position-absolute top-50 end-0 translate-middle-y px-4">
									Link giới thiệu<img src="/modules/members/assets/images/icon-copy.svg" alt="img-copy">
								</a>
							</span>
						</div>
						<div class="box">
							<span class="value"><?= @$data_f0->end_time ?></span></span>
							<span class="parameter">Thời gian duy trì tài khoản</span>
						</div>
						<div class="box">
							<span class="value"><?= @$data_f0->due_time_month ?></span>
							<span class="parameter">Thời gian gia hạn tài khoản theo tháng</span>
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>

	<div class="member-info">


		<div class="member-info-content">

			<div class="member-info-content-item">
				<div class="member-info-content-item-title box-1">
					<div class="inner">
						<h3><?= count(@$list_f1) ?></h3>
						<p><?php echo FSText::_('Số lượng giới thiệu'); ?></p>
					</div>
					<a href="#fragment-1" class="small-box-footer"><span><?php echo FSText::_("More info"); ?></span></a>
				</div>
				<div class="member-info-content-item-title box-2">
					<div class="inner">
						<h3><?= @$total_coin . ' VT-Coin' ?></h3>
						<p><?php echo FSText::_('Hoa hồng đã nhận'); ?></p>
					</div>
					<a href="#fragment-2" class="small-box-footer"><span><?php echo FSText::_("More info"); ?></span></a>
				</div>
				<div class="member-info-content-item-title box-3">
					<div class="inner">
						<h3><?= count(@$list_order) ?></h3>
						<p><?php echo FSText::_('Tổng số đơn hàng'); ?></p>
					</div>
					<a href="#fragment-3" class="small-box-footer"><span><?php echo FSText::_("More info"); ?></span></a>
				</div>
				<div class="member-info-content-item-title box-4">
					<div class="inner">
						<h3><?= count(@$list_order_f1) ?></h3>
						<p><?php echo FSText::_('Tổng số đơn hàng f1'); ?></p>
					</div>
					<a href="#fragment-4" class="small-box-footer"><span><?php echo FSText::_("More info"); ?></span></a>
				</div>
			</div>
		</div>
	</div>
	<ul>
		<li><a href="#fragment-1"><span><?php echo FSText::_("Thống kê giới thiệu"); ?></span></a></li>
		<li><a href="#fragment-2"><span><?php echo FSText::_("Thống kê hoa hồng nhận"); ?></span></a></li>
		<li><a href="#fragment-3"><span><?php echo FSText::_("Thống kê số lượng đơn hàng"); ?></span></a></li>
		<li><a href="#fragment-4"><span><?php echo FSText::_("Thống kê số lượng đơn hàng F1"); ?></span></a></li>
	</ul>
	<div class="alert alert-danger margin-15" style="display:none;margin:15px opx">
		<span id="msg_error"></span>
	</div>
	<div id="fragment-1" style="padding: 0">
		<?php include_once 'detail_1.php'; ?>
	</div>
	<div id="fragment-2" style="padding: 0">
		<?php include_once 'detail_2.php'; ?>
	</div>
	<div id="fragment-3" style="padding: 0">
		<?php include_once 'detail_3.php'; ?>
	</div>
	<div id="fragment-4" style="padding: 0">
		<?php include_once 'detail_4.php'; ?>
	</div>
</div>


<?php
$this->dt_form_end(@$data, 1, 0);
?>

<script type="text/javascript" language="javascript">
	$(function() {
		$('.password_area').hide();
		$('#edit_pass_0').click(function() {
			$('.password_area').hide();
		});
		$('#edit_pass_1').click(function() {
			$('.password_area').show();
		});
		<?php if (@!$data || @$data->is_admin != 1) { ?>
			$('.shop_area').hide();
		<?php } ?>
		$('#is_admin_0').click(function() {
			$('.shop_area').hide();
		});
		$('#is_admin_1').click(function() {
			$('.shop_area').show();
		});
	})

	function myFunction() {
		var copyText = document.getElementById("link_aff");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		navigator.clipboard.writeText(copyText.value);
		alert('Copy link thành công !');
	}

	function myFunction1() {
		var copyText = document.getElementById("link_afff0");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		navigator.clipboard.writeText(copyText.value);
		alert('Copy link thành công !');
	}
	$('a.small-box-footer').click(function(e) {
		e.preventDefault(); // Prevent the default anchor behavior
		var targetFragment = $(this).attr('href'); // Get the href attribute value
		// Exclude the original clicked element when simulating the click
		$('a[href="' + targetFragment + '"]').not(this).click();
	});
	$(function() {
		$("#time_hoahong_0").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
		$("#time_hoahong_1").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
		$("#time_order_0").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
		$("#time_order_1").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
		$("#time_orderf1_0").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
		$("#time_orderf1_1").datepicker({
			clickInput: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			numberOfMonths: 2,
			changeYear: true,
			maxDate: " + d ",
			showMonthAfterYear: true
		});
	});
	$(document).ready(function() {
		$(".submit_filter_hoahong").on('click', function(e) {
			e.preventDefault(); // Ngăn chặn hành động mặc định của nút
			if (!formValidator0()) {
				return; // Nếu form không hợp lệ, dừng lại
			}
			let time_hoahong_0 = $("#time_hoahong_0").val();
			let time_hoahong_1 = $("#time_hoahong_1").val();
			let hoahong_status = $("#hoahong_status").val();
			let id = $("#id").val();
			$.ajax({
				url: "index.php?module=member_statistics&view=members&task=filter_time_hoa_hong&id=<?= $data->id ?>",
				type: "POST",
				data: {
					time_hoahong_0,
					time_hoahong_1,
					hoahong_status,
					id
				},
				dataType: "JSON",
				success: function(result) {
					$("#tab_filter_2").html(result.html);
					$("#filter_hoahong_coin").html(result.total_coin);
					$("#filter_hoahong_vnd").html(result.total_vnd);
					//fill html 
					$('#filter-text-date-hoahong').show();
					$("#filter_hoahong_time_0").html(time_hoahong_0);
					$("#filter_hoahong_time_1").html(time_hoahong_1);
					// load.fadeOut().html("");
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log("Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.");
				}
			});
		});
		$(".submit_filter_order").on('click', function(e) {
			e.preventDefault(); // Ngăn chặn hành động mặc định của nút
			if (!formValidator1()) {
				return; // Nếu form không hợp lệ, dừng lại
			}
			let time_order_0 = $("#time_order_0").val();
			let time_order_1 = $("#time_order_1").val();
			let id = $("#id").val();
			let array_f1 = $("#array_f1").val();
			$.ajax({
				url: "index.php?module=member_statistics&view=members&task=filter_time_order&id=<?= $data->id ?>",
				type: "POST",
				data: {
					time_order_0,
					time_order_1,
					id,
					array_f1
				},
				dataType: "JSON",
				success: function(result) {
					$("#tab_filter_3").html(result.html);
					$("#filter_order_coin").html(result.total_coin);
					$("#filter_order_vnd").html(result.total_vnd);
					// load.fadeOut().html("");
					//fill html 
					$('#filter-text-date-order').show();
					$("#filter_order_time_0").html(time_order_0);
					$("#filter_order_time_1").html(time_order_1);
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log("Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.");
				}
			});
		});
		$(".submit_filter_orderf1").on('click', function(e) {
			e.preventDefault(); // Ngăn chặn hành động mặc định của nút
			if (!formValidator2()) {
				return; // Nếu form không hợp lệ, dừng lại
			}
			let time_orderf1_0 = $("#time_orderf1_0").val();
			let time_orderf1_1 = $("#time_orderf1_1").val();
			let id = $("#id").val();
			let array_f1 = $("#array_f1").val();
			$.ajax({
				url: "index.php?module=member_statistics&view=members&task=filter_time_orderf1&id=<?= $data->id ?>",
				type: "POST",
				data: {
					time_orderf1_0,
					time_orderf1_1,
					id,
					array_f1
				},
				dataType: "JSON",
				success: function(result) {
					$("#tab_filter_4").html(result.html);
					$("#filter_orderf1_coin").html(result.total_coin);
					$("#filter_orderf1_vnd").html(result.total_vnd);
					// load.fadeOut().html("");
					//fill html 
					$('#filter-text-date-orderf1').show();
					$("#filter_orderf1_time_0").html(time_orderf1_0);
					$("#filter_orderf1_time_1").html(time_orderf1_1);

				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.log("Có lỗi trong quá trình đưa lên máy chủ. Xin bạn vui lòng kiểm tra lỗi kết nối.");
				}
			});
		});

		function formValidator0() {
			$('.alert-danger').show();

			if (!notEmpty('time_hoahong_0', 'Bạn phải chọn ngày bắt đầu')) {
				return false;
			}

			if (!notEmpty('time_hoahong_1', 'Bạn phải chọn ngày kết thúc')) {
				return false;
			}
			if (!notEmpty('hoahong_status', 'Bạn phải chọn trạng thái chi trả')) {
				return false;
			}

			$('.alert-danger').hide();
			return true;
		}

		function formValidator1() {
			$('.alert-danger').show();

			if (!notEmpty('time_order_0', 'Bạn phải chọn ngày bắt đầu')) {
				return false;
			}

			if (!notEmpty('time_order_1', 'Bạn phải chọn ngày kết thúc')) {
				return false;
			}

			$('.alert-danger').hide();
			return true;
		}

		function formValidator2() {
			$('.alert-danger').show();

			if (!notEmpty('time_orderf1_0', 'Bạn phải chọn ngày bắt đầu')) {
				return false;
			}

			if (!notEmpty('time_orderf1_1', 'Bạn phải chọn ngày kết thúc')) {
				return false;
			}

			$('.alert-danger').hide();
			return true;
		}

		function notEmpty(id, message) {
			var value = document.getElementById(id).value;
			var errorElement = document.getElementById('msg_error');
			if (value.trim() === "") {
				errorElement.innerHTML = message;
				return false;
			}
			return true;
		}
	});
</script>