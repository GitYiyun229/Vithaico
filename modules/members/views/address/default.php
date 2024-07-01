<?php
$tmpl->addStylesheet('select2.min');
$tmpl->addStylesheet('members', 'modules/members/assets/css');
$tmpl->addStylesheet('address', 'modules/members/assets/css');

$tmpl->addScript('select2.min');
$tmpl->addScript('address', 'modules/members/assets/js');
?>

<div class="container">
    <div class="page-member">
        <div class="page-side">
            <div class="page-sidebar">
                <?php include PATH_BASE . 'modules/members/views/sidebar.php' ?>
            </div>
        </div>
        <div class="page-side">
            <div class="page-title mb-3 fs-5 fw-medium"><?php echo FSText::_('Sổ địa chỉ') ?></div>
            <div class="page-content page-address p-4 bg-white page-border-radius <?php echo empty($list) ? 'page-address-empty' : '' ?>">
                <div>
                    <?php if (empty($list)) { ?>
                        <p class="mb-4 text-center">Bạn chưa có địa chỉ nào, vui lòng thêm ngay!</p>
                    <?php } else { ?>
                        <?php foreach ($list as $item) { ?>
                            <div class="item-address p-4 d-flex align-items-end justify-content-between gap-3 position-relative mb-4">
                                <div>
                                    <div class="fw-medium mb-1"><?php echo $item->name ?></div>
                                    <div class="fw-medium mb-1"><?php echo $item->telephone ?></div>
                                    <div class="fw-medium"><?php echo $item->province_name . ' ' . $item->district_name . ' ' . $item->ward_name . ' ' . $item->address ?></div>
                                </div>
                                <div class="text-nowrap">
                                    <?php if ($item->default) { ?>
                                        <div class="position-absolute text-grey is-default">Mặc định</div>
                                    <?php } ?>
                                    <a href="" data-bs-toggle="modal" data-bs-target="#modalEdit<?php echo $item->id ?>" class="fw-medium">Chỉnh sửa</a>
                                    <span class="ms-3 me-3 text-grey">|</span>
                                    <a href="" class="fw-medium remove-address" data-id="<?php echo $item->id ?>">Xóa</a>
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>

                    <a href="" class="btn-add" data-bs-toggle="modal" data-bs-target="#modalAdd">
                        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5.5 10H15.5M10.5 15V5" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Thêm địa chỉ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-address fade" id="modalAdd" tabindex="-1" aria-labelledby="modalAddLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body p-4">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <p class="fs-4 mb-4 text-center">Thêm địa chỉ</p>
                <form action="" method="POST" class="modal-form">
                    <div class="col">
                        <input type="text" class="form-control" name="name" placeholder="Họ và tên">
                    </div>
                    <div class="col">
                        <input type="tel" class="form-control" name="telephone" placeholder="Số điện thoại">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" name="address" placeholder="Địa chỉ (Ví dụ: Số 23, ngõ 66, hồ tùng mậu)">
                    </div>
                    <div class="col">
                        <select name="province" class="form-control form-select2 form-province">
                            <option value="0"><?php echo FSText::_('Tỉnh/TP') ?></option>
                            <?php foreach ($province as $item) { ?>
                                <option value="<?php echo $item->code ?>"><?php echo $item->name ?></option>
                            <?php } ?>    
                        </select>
                    </div>
                    <div class="col">
                        <select name="district" class="form-control form-select2 form-district">
                            <option value="0"><?php echo FSText::_('Quận/Huyện') ?></option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="ward" class="form-control form-select2 form-ward">
                            <option value="0"><?php echo FSText::_('Phường/Xã') ?></option>
                        </select>
                    </div>
                    <div class="col col-12 form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="default" id="default">
                        <label class="form-check-label" for="default">
                            Đặt làm địa chỉ mặc định
                        </label>
                    </div>
                    <?php echo csrf::displayToken() ?>
                    <input type="hidden" name="module" value="members">
                    <input type="hidden" name="view" value="address">
                    <input type="hidden" name="task" value="saveAddress">
                    <input type="hidden" name="redirect" value="<?php echo FSRoute::_('index.php?module=members&view=address') ?>">
                    <div class="col col-12 d-flex align-items-center justify-content-end gap-3">
                        <a href="" class="btn-form btn-cancel" data-bs-dismiss="modal" aria-label="Close">Hủy</a>
                        <a href="" class="btn-form btn-save-address">Thêm</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($list)) { 
    foreach ($list as $item) { ?>
    <div class="modal modal-address fade" id="modalEdit<?php echo $item->id ?>" tabindex="-1" aria-labelledby="modalEdit<?php echo $item->id ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <p class="fs-4 mb-4 text-center">Thêm địa chỉ</p>
                    <form action="" method="POST" class="modal-form">
                        <div class="col">
                            <input type="text" class="form-control" name="name" placeholder="Họ và tên" value="<?php echo $item->name ?>">
                        </div>
                        <div class="col">
                            <input type="tel" class="form-control" name="telephone" placeholder="Số điện thoại" value="<?php echo $item->telephone ?>">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="address" placeholder="Địa chỉ (Ví dụ: Số 23, ngõ 66, hồ tùng mậu)" value="<?php echo $item->address ?>">
                        </div>
                        <div class="col">
                            <select name="province" class="form-control form-select2 form-province">
                                <option value="0"><?php echo FSText::_('Tỉnh/TP') ?></option>
                                <?php foreach ($province as $provinceItem) { ?>
                                    <option value="<?php echo $provinceItem->code ?>" <?php echo $provinceItem->code == $item->province_id ? 'selected' : '' ?>><?php echo $provinceItem->name ?></option>
                                <?php } ?>    
                            </select>
                        </div>
                        <div class="col">
                            <select name="district" class="form-control form-select2 form-district">
                                <?php foreach ($district as $districtItem) { 
                                    if ($districtItem->province_code == $item->province_id) {
                                    ?>
                                    <option value="<?php echo $districtItem->code ?>" <?php echo $districtItem->code == $item->district_id ? 'selected' : '' ?>><?php echo $districtItem->name ?></option>
                                <?php } } ?> 
                            </select>
                        </div>
                        <div class="col">
                            <select name="ward" class="form-control form-select2 form-ward">
                                <?php foreach ($ward as $wardItem) { 
                                    if ($wardItem->district_code == $item->district_id) {
                                    ?>
                                    <option value="<?php echo $wardItem->code ?>" <?php echo $wardItem->code == $item->ward_id ? 'selected' : '' ?>><?php echo $wardItem->name ?></option>
                                <?php } } ?> 
                            </select>
                        </div>
                        <div class="col col-12 form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="default" <?php echo $item->default ? 'checked' : '' ?> id="default<?php echo $item->id ?>">
                            <label class="form-check-label" for="default<?php echo $item->id ?>">
                                Đặt làm địa chỉ mặc định
                            </label>
                        </div>
                        <?php echo csrf::displayToken() ?>
                        <input type="hidden" name="id" value="<?php echo $item->id ?>">
                        <input type="hidden" name="module" value="members">
                        <input type="hidden" name="view" value="address">
                        <input type="hidden" name="task" value="saveAddress">
                        <input type="hidden" name="redirect" value="<?php echo FSRoute::_('index.php?module=members&view=address') ?>">
                        <div class="col col-12 d-flex align-items-center justify-content-end gap-3">
                            <a href="" class="btn-form btn-cancel" data-bs-dismiss="modal" aria-label="Close">Hủy</a>
                            <a href="" class="btn-form btn-save-address">Lưu</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php } 
} ?>