<?php 
$tmpl->addStylesheet("search", "modules/products/assets/css");
$tmpl->addScript("search", "modules/products/assets/js");
?>
<div class="container">
    <?php if ($empty) { ?>
        <h1 class="fs-4 mb-3"><span>Không có kết quả phù hợp với từ khóa: <strong class="text-danger"><?php echo $getKeyword; ?></strong></span></h1>
        <p class="fs-4 mb-4">Quý khách có thể tham khảo thêm các sản phẩm dưới đây</p>
    <?php } else { ?>
        <h1 class="fs-4 mb-4">
            <span>Có <strong class="text-danger"><?php echo $total ?></strong> sản phẩm với từ khóa: <strong class="text-danger"><?php echo $getKeyword; ?></strong></span>
        </h1>
    <?php } ?>   
    
    <div class="section-item section-products d-flex flex-wrap">
        <?php foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        } ?> 
    </div>
    
    <div class="section-item loading-scroll w-100" limit="<?php echo $this->model->limit ?>" total-current="<?php echo count($products) ?>" total="<?php echo $total ?>" page="1"></div>
</div>

<input type="hidden" name="sort" value="<?php echo $getSort ?>">
<input type="hidden" name="filter" value="<?php echo $getFilter ?>">
<input type="hidden" name="price" value="<?php echo $getPrice ?>">
<input type="hidden" name="keysearch" value="<?php echo $getKeyword ?>">
<input type="hidden" name="empty" value="<?php echo $empty ?>">