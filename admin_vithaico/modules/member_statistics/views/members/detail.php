<link rel="stylesheet" href="/modules/products/assets/css/select2.min.css">
<link type="text/css" rel="stylesheet" media="all" href="../libraries/jquery/jquery.ui/jquery-ui.css" />
<link type="text/css" rel="stylesheet" media="all" href="templates/default/css/products.css" />

<script src="/modules/products/assets/js/select2.min.js"></script>

<link href="templates/default/dist/css/style_thongke.css" rel="stylesheet">

<script type="text/javascript" src="../libraries/jquery/jquery.ui/jquery-ui.js"></script>
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
<div id="tabs" class="row">
	<div class="member-info">
		<div class="member-inffo">
			<div class="memmber-to">
				<div class="info">
					<h3><?php echo FSText::_('Thông tin thành viên'); ?></h3>
					<div class="inner">
						<p class="info-p"><?php echo FSText::_('Họ và tên : '); ?> <span class="info-span"><?= @$data->full_name ?></span></p>
						<p class="info-p"><?php echo FSText::_('Số điện thoại : '); ?> <span class="info-span"><?= @$data->telephone ?></span></p>
						<p class="info-p"><?php echo FSText::_('Email : '); ?> <span class="info-span"><?= @$data->email ?></span></p>
						<p class="info-p"><?php echo FSText::_('Mức hạng hiện tại : '); ?> <img src="<?= @$data->rank_image ?>" alt=""> </p>
						<p class="info-p"><?php echo FSText::_('Mức hoa hồng đang nhận : '); ?><span class="info-span"><?= @$data->hoa_hong ?>%</span></p>
						<p class="info-p"><?php echo FSText::_('Thời gian duy trì tài khoản : '); ?> <span class="info-span"><?= @$data->end_time ?>%</span></p>
						<p class="info-p"><?php echo FSText::_('Thời gian gia hạn tài khoản theo tháng: '); ?> <span class="info-span"><?= @$data->due_time_month ?>%</span></p>
						<p class="info-p"><?php echo FSText::_('Link đăng ký : '); ?>
							<span class="info-span"><?= FSRoute::_('index.php?module=members&view=user&task=register') ?><?= '?affiliate=' . $data->ref_code ?>
							</span>
							<input type="text" value="https://vithaico.phongcachso.com/dang-ky-tai-khoan?affiliate=1720862229" class="form-control link_aff_copy" id="link_aff" name="link_aff">
							<a onclick="myFunction()" class="position-absolute top-50 end-0 translate-middle-y px-4">
								<img src="/modules/members/assets/images/icon-copy.svg" alt="img-copy">
							</a>
						</p>
					</div>
				</div>
			</div>
			<div class="memmber-to">
				<div class="info">
					<h3><?php echo FSText::_('Thông tin người giới thiệu'); ?></h3>
					<div class="inner">
						<p class="info-p"><?php echo FSText::_('Họ và tên : '); ?> <span class="info-span"><?= @$data_f0->full_name ?></span></p>
						<p class="info-p"><?php echo FSText::_('Số điện thoại : '); ?> <span class="info-span"><?= @$data_f0->telephone ?></span></p>
						<p class="info-p"><?php echo FSText::_('Email : '); ?> <span class="info-span"><?= @$data_f0->email ?></span></p>
						<p class="info-p"><?php echo FSText::_('Mức hoa hồng đang nhận : '); ?> <span class="info-span"><?= @$data_f0->hoa_hong ?>%</span></p>
						<p class="info-p"><?php echo FSText::_('Thời gian duy trì tài khoản : '); ?> <span class="info-span"><?= @$data->end_time ?></span></p>
						<p class="info-p"><?php echo FSText::_('Thời gian gia hạn tài khoản theo tháng : '); ?> <span class="info-span"><?= @$data->due_time_month ?></span></p>
						<p class="info-p"><?php echo FSText::_('Link đăng ký : '); ?>
							<span class="info-span"><?= FSRoute::_('index.php?module=members&view=user&task=register') ?><?= '?affiliate=' . $data_f0->ref_code ?>
							</span>
							<input type="text" value="https://vithaico.phongcachso.com/dang-ky-tai-khoan?affiliate=1720862229" class="form-control link_aff_copy" id="link_afff0" name="link_afff0">
							<a onclick="myFunction()" class="position-absolute top-50 end-0 translate-middle-y px-4">
								<img src="/modules/members/assets/images/icon-copy.svg" alt="img-copy">
							</a>
						</p>
					</div>
				</div>
			</div>
		</div>

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

	function myFunction() {
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
</script>