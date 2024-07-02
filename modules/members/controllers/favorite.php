<?php

require_once PATH_BASE . 'modules/members/controllers/members.php';

class MembersControllersFavorite extends MembersControllersMembers
{
    protected $table = 'fs_members';

    public function display()
    {
        global $tmpl, $user, $config;

        $tmpl->addTitle(FSText::_('Sản phẩm yêu thích'));

        $productFavorite = $this->model->get_records("user_id = $user->userID", 'fs_members_favorite');

        $productFavoriteId = array_map(function($item) {
            return $item->product_id;
        }, $productFavorite);

        $productFavoriteId = array_unique($productFavoriteId);

        if (!empty($productFavoriteId)) {
            $total = count($productFavoriteId);
            $productFavoriteId = implode(',', $productFavoriteId);
            $list = $this->model->getDataMore($productFavoriteId);
            $list = $this->nomalizeProducts($list);
        }

        require PATH_BASE . "modules/$this->module/views/$this->view/default.php";
    }

    public function loadMore()
    {
        $model = $this->model;
        $productFavoriteId = FSInput::get('items');
        $products = $model->getDataMore($productFavoriteId);
        $products = $this->nomalizeProducts($products);

        foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        }
    }

    public function addFavorite()
    {
        $this->auth('POST');
        global $user;

        $response = [
            'error' => false,
            'message' => 'Thêm sản phẩm yêu thích thành công!'
        ];

        $product_id = FSInput::get('product_id');
        $user_id = $user->userID;

        if (!$product_id) {
            $response = [
                'error' => true,
                'message' => 'Sản phẩm không được bỏ trống!'
            ];

            goto exitFunc;
        }

        $row = compact('product_id', 'user_id');

        if (!$this->model->_add($row, 'fs_members_favorite')) {
            $response = [
                'error' => true,
                'message' => 'Thêm sản phẩm yêu thích không thành công!'
            ];
        }

        exitFunc:
        echo json_encode($response);
        exit;
    }
}
