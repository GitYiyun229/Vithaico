<?php
$tmpl->addStylesheet('promotion', 'modules/products/assets/css');
// $tmpl->addScript('promotion', 'modules/products/assets/js');
?>

<div class="container">
    <div class="section-banner mb-3">
        <img src="/images/flash-title.svg" alt="Giá tốt hôm nay" class="img-fluid mb-3 ms-auto me-auto d-block">
        <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => 7, 'style' => 'default']); ?>
    </div>

    <ul class="nav nav-tabs section-categories mb-3" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="discount-tab" data-bs-toggle="tab" data-bs-target="#discount-tab-pane" type="button" role="tab" aria-controls="discount-tab-pane" aria-selected="true">
                Chiết khấu sản phẩm
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="whosale-tab" data-bs-toggle="tab" data-bs-target="#whosale-tab-pane" type="button" role="tab" aria-controls="whosale-tab-pane" aria-selected="false">
                Mua sỉ giá hời
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="voucher-tab" data-bs-toggle="tab" data-bs-target="#voucher-tab-pane" type="button" role="tab" aria-controls="voucher-tab-pane" aria-selected="false">
                Voucher
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="gift-tab" data-bs-toggle="tab" data-bs-target="#gift-tab-pane" type="button" role="tab" aria-controls="gift-tab-pane" aria-selected="false">
                Quà tặng
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="flash-tab" data-bs-toggle="tab" data-bs-target="#flash-tab-pane" type="button" role="tab" aria-controls="flash-tab-pane" aria-selected="false">
                Flashsale
            </button>
        </li>
    </ul>
     
    <div class="tab-content section-list">
        <div class="tab-pane fade show active" id="discount-tab-pane" role="tabpanel" aria-labelledby="discount-tab" tabindex="0">
            <div class="list">
                <?php foreach ($discount as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>
        </div>

        <div class="tab-pane fade" id="whosale-tab-pane" role="tabpanel" aria-labelledby="whosale-tab" tabindex="0">
             
        </div>

        <div class="tab-pane fade" id="voucher-tab-pane" role="tabpanel" aria-labelledby="voucher-tab" tabindex="0">
             
        </div>

        <div class="tab-pane fade" id="gift-tab-pane" role="tabpanel" aria-labelledby="gift-tab" tabindex="0">
             
        </div>
        
        <div class="tab-pane fade" id="flash-tab-pane" role="tabpanel" aria-labelledby="flash-tab" tabindex="0">
            <div class="list">
                <?php foreach ($flash as $item) {
                    echo $this->layoutProductItem($item);
                } ?>
            </div>           
        </div>           
    </div>
</div>