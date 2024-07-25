<?php

class ProductsControllersProduct extends FSControllers
{
    public $commentFilter = [];
    public $rateName = [];

    public function __construct()
    {
        parent::__construct();
       
    }

    function display()
    {
        global $tmpl, $config, $user;
        $model = $this->model;
        $timeNow = date('Y-m-d H:i:s');

        $data = $model->getData();
        if (!$data) {
            setRedirect(URL_ROOT, FSText::_('Sản phẩm không tồn tại'), 'error');
        }

        $promotionDiscount = NULL;
        if ($user->userID) {
            $promotionDiscount = $model->getPromotionDiscountProduct($data->id, $timeNow);
        }

        // ảnh sp, sp con
        $dataImage = $model->getDataImage($data->id);
        // sản phẩm cùng loại
        $dataSame = $model->getDataSame($data->category_id, $data->id);
        // $dataRelated = $this->nomalizeProducts($dataSame);



        // sản phẩm liên quan
        $dataRelated = $model->getDataRelated($data->products_related, $data->id);
        // $dataRelated = $this->nomalizeProducts($dataRelated);


        $canonical = FSRoute::_("index.php?module=products&view=product&code=$data->alias&id=$data->id");
        $dataCategories = $model->getDataCategories($data->category_id_wrapper);

        $breadcrumbs = [];
        
        foreach ($dataCategories as $item) {
            $breadcrumbs[] = [$item->name, FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")];
        }

        $breadcrumbs[] = [$data->name, $canonical];
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->assign('og_image', URL_ROOT . $data->image);
        $tmpl->assign('canonical', $canonical);

        switch ($data->status_prd) {
            case 1:
                $status_prd = FSText::_('Còn hàng');
                break;
            case 2:
                $status_prd = FSText::_('Còn hàng');
                break;
            case 3:
                $status_prd = FSText::_('Còn hàng');
                break;
            case 4:
                $status_prd = FSText::_('Hết hàng');
                break;
            default:
                $status_prd = FSText::_('Còn hàng');
                break;
        }

        if (!$data->quantity) {
            $status_prd = FSText::_('Hết hàng');
        }

        if ($user->userID) {
            $favorite = $this->model->get_record("user_id = $user->userID AND product_id = $data->id", 'fs_members_favorite');
        }

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    public function loadMore()
    {
        $model = $this->model;

        $products = $model->getDataMore();
        $products = $this->nomalizeProducts($products);

        foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        }
    }
}