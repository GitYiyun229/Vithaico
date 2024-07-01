<?php

$title = FSText::_('Cấu hình API');
global $toolbar;
$toolbar->setTitle($title);
$toolbar->addButton('Save', FSText::_('Save'), '', 'save.png');
$toolbar->addButton('back', FSText::_('Cancel'), '', 'cancel.png');

$this->dt_form_begin(1, 4, $title);
?>
<style>
	.nav-tabs{
		margin-bottom: 40px;
	}
	.nav-link.btn{
		outline: none !important;
	}
	.nav-item.active .nav-link.btn{
		background: #333;
		color: #fff;
	}
</style>
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item active" role="presentation">
		<button class="nav-link btn btn-secondary" id="tab-1" data-toggle="tab" data-target="#tab1" type="button" role="tab" aria-controls="tab1" aria-selected="true">
			Ecount
		</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link btn btn-secondary" id="tab-2" data-toggle="tab" data-target="#tab2" type="button" role="tab" aria-controls="tab2" aria-selected="false">
			Bitrix
		</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link btn btn-secondary" id="tab-3" data-toggle="tab" data-target="#tab3" type="button" role="tab" aria-controls="tab3" aria-selected="false">
			GHTTK
		</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link btn btn-secondary" id="tab-4" data-toggle="tab" data-target="#tab4" type="button" role="tab" aria-controls="tab4" aria-selected="false">
			Google Merchant
		</button>
	</li>
	<li class="nav-item" role="presentation">
		<button class="nav-link btn btn-secondary" id="tab-5" data-toggle="tab" data-target="#tab5" type="button" role="tab" aria-controls="tab5" aria-selected="false">
			Email
		</button>
	</li>
</ul>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade in active" id="tab1" role="tabpanel" aria-labelledby="tab-1">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Cấu hình EC 1 (Đồng bộ Sản phẩm - Kho)</div>
				</div>
				<div class="panel-body">
					<?php foreach($data as $item) { ?>
						<?php if($item->name_api == 'EC1') { ?>
							<div class="form-group">
								<label class="col-sm-3 col-xs-12 control-label hover_img"><?php echo $item->title ?></label>
								<div class="col-sm-9 col-xs-12">
									<input class="form-control" type="text" name="<?php echo $item->name ?>" value="<?php echo $item->value ?>"> 			
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Cấu hình EC 2 (Đồng bộ Đơn hàng)</div>
				</div>
				<div class="panel-body">
					<?php foreach($data as $item) { ?>
						<?php if($item->name_api == 'EC2') { ?> 
							<div class="form-group">
								<label class="col-sm-3 col-xs-12 control-label hover_img"><?php echo $item->title ?></label>
								<div class="col-sm-9 col-xs-12">
									<input class="form-control" type="text" name="<?php echo $item->name ?>" value="<?php echo $item->value ?>"> 			
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="tab2" role="tabpanel" aria-labelledby="tab-2">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Cấu hình Bitrix</div>
				</div>
				<div class="panel-body">
					<?php foreach($data as $item) { ?>
						<?php if($item->name_api == 'Bitrix') { ?>
							<div class="form-group">
								<label class="col-sm-3 col-xs-12 control-label hover_img"><?php echo $item->title ?></label>
								<div class="col-sm-9 col-xs-12">
									<input class="form-control" type="text" name="<?php echo $item->name ?>" value="<?php echo $item->value ?>"> 			
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="tab3" role="tabpanel" aria-labelledby="tab-3">
		GHTTK is comming soon ...
	</div>
	<div class="tab-pane fade" id="tab4" role="tabpanel" aria-labelledby="tab-4">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Cấu hình Google Merchant</div>
				</div>
				<div class="panel-body">
					<?php foreach($data as $item) { ?>
						<?php if($item->name_api == 'GM') { ?>
							<div class="form-group">
								<label class="col-sm-3 col-xs-12 control-label hover_img"><?php echo $item->title ?></label>
								<div class="col-sm-9 col-xs-12">
									<input class="form-control" type="text" name="<?php echo $item->name ?>" value="<?php echo $item->value ?>"> 			
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="tab-pane fade" id="tab5" role="tabpanel" aria-labelledby="tab-5">
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">Cấu hình Email</div>
				</div>
				<div class="panel-body">
					<?php foreach($data as $item) { ?>
						<?php if($item->name_api == 'Mail') { ?>
							<div class="form-group">
								<label class="col-sm-3 col-xs-12 control-label hover_img"><?php echo $item->title ?></label>
								<div class="col-sm-9 col-xs-12">
									<input class="form-control" type="text" name="<?php echo $item->name ?>" value="<?php echo $item->value ?>"> 			
								</div>
							</div>
						<?php } ?>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$this->dt_form_end(@$data, 1, 0);
?>