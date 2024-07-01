<?php

class ProductsControllersPromotion extends FSControllers
{
    public function display()
    {
        global $tmpl, $user;
        $tmpl->addTitle('Giá tốt hôm nay');
        $now = date('Y-m-d H:i:s');
        $productID = [];
        $discount = [];
        $wholesale = [];
        $voucher = [];
        $gift = [];
        $flash = [];

        /**
         * Tìm ID sản phẩm đang có discount/ Flash
         */
        $promontionDiscount = $this->model->get_records("published = 1 AND DATE(date_end) >= DATE('$now') AND ((quantity > 0 AND sold < quantity) OR (quantity = 0))", "fs_promotion_discount_detail");
        if (!empty($promontionDiscount)) {
            foreach ($promontionDiscount as $item) {
                $productID[] = $item->product_id;
            }
        }

        /**
         * Tìm ID sản phẩm đang có wholesale
         */

        /**
         * Tìm ID sản phẩm đang có voucher
         */

        /**
         * Tìm ID sản phẩm đang có gift
         */

        /**
         * Tổng hợp thông tin
         */
        if (!empty($productID)) {
            $products = $this->model->get_records("published = 1 AND quantity > 0 AND status_prd <> 4 AND id IN (" . implode(",", $productID) . ")", "fs_products", "id, name, code, alias, quantity, image, price, price_old, is_gift, freeship, sold_out");
            $products = $this->nomalizeProducts($products, $promontionDiscount);

            foreach ($products as $item) {
                if ($item->have_discount) {
                    $discount[] = $item;
                }
                if ($item->have_wholesale) {
                    $wholesale[] = $item;
                }
                if ($item->have_voucher) {
                    $voucher[] = $item;
                }
                if ($item->have_gift) {
                    $gift[] = $item;
                }
                if ($item->have_flash) {
                    $flash[] = $item;
                }
            } 
        } 

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }
}
