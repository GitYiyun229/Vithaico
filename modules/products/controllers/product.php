<?php

class ProductsControllersProduct extends FSControllers
{
    public $commentFilter = [];
    public $rateName = [];

    public function __construct()
    {
        parent::__construct();
        $this->commentFilter = [
            0 => FSText::_('Tất cả'),
            6 => FSText::_('Có hình ảnh'),
            5 => FSText::_('5 sao'),
            4 => FSText::_('4 sao'),
            3 => FSText::_('3 sao'),
            2 => FSText::_('2 sao'),
            1 => FSText::_('1 sao'),
        ];
        $this->rateName = [
            1 => FSText::_('Tệ'),
            2 => FSText::_('Không hài lòng'),
            3 => FSText::_('Bình thường'),
            4 => FSText::_('Hài lòng'),
            5 => FSText::_('Tuyệt vời'),
        ];
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

        // tính lại giá sp nếu có discount hoặc flash sale
        // $data = $this->nomalizeProduct($data, $promotionDiscount);

        // ảnh sp, sp con
        $dataImage = $model->getDataImage($data->id);

        // tính lại giá sp con nếu có flash sale
        // $dataType = $model->getDataType($data->id);
        // if (!empty($dataType)) {
        //     foreach ($dataType as $item) {
        //         $item->price_public = $item->price;
        //         $item->price_old = $item->price_old ?: $item->price;
        //         $item->percent = $item->price_public && $item->price_old != 0 && $item->price_public < $item->price_old ? 100 - round($item->price_public / $item->price_old * 100, 0) : 0;

        //         if (!empty($promotionDiscount) && $user->userID) {
        //             if ($promotionDiscount->price && $promotionDiscount->price > 0) {
        //                 $item->price_discount = $promotionDiscount->price;
        //             } else {
        //                 $item->price_discount = $item->price_public - round($promotionDiscount->percent * $item->price_public / 100, -3);
        //             }

        //             if (!$promotionDiscount->quantity_user) {
        //                 $item->price_public = $item->price_discount;
        //             }

        //             $item->percent = round(100 - $item->price_public * 100 / $item->price_old, 0);
        //         }

        //         foreach ($dataImage as $imgIndex => $img) {
        //             if ($img->sub_id == $item->id) {
        //                 $item->thumbnail_index = $imgIndex + 1;
        //             }
        //         }
        //     }
        // }

        // sản phẩm cùng loại
        $dataSame = $model->getDataSame($data->products_same);

        // sản phẩm liên quan
        $dataRelated = $model->getDataRelated($data->products_related, $data->id);
        $dataRelated = $this->nomalizeProducts($dataRelated);

        // sản phẩm bán chạy
        $dataSell = $model->getDataSell($data->id);
        $dataSell = $this->nomalizeProducts($dataSell);

        // lấy thông số kỹ thuật
        $dataExtend = $model->getDataExtend($data->tablename);
        if (!empty($dataExtend)) {
            $arrFieldName = [];
            $arrFieldSelectId = [];

            foreach ($dataExtend as $item) {
                $arrFieldName[] = $item->field_name;
            }

            $dataExtendValue = $model->getDataExtendValue($data->tablename, implode(', ', $arrFieldName), $data->id);

            foreach ($dataExtend as $item) {
                if (($item->field_type == 'foreign_one' || $item->field_type == 'foreign_multi') && @$dataExtendValue->{$item->field_name}) {
                    $arrFieldSelectId[] = $dataExtendValue->{$item->field_name};
                }
            }

            if (!empty($arrFieldSelectId)) {
                $dataExtendSelect = $model->getDataExtendSelect(implode(',', $arrFieldSelectId));
            }

            foreach ($dataExtend as $item) {
                $item->field_value = @$dataExtendValue->{$item->field_name};

                if (!empty($arrFieldSelectId)) {
                    if ($item->field_type == 'foreign_one') {
                        foreach ($dataExtendSelect as $extendSelect) {
                            if ($extendSelect->id == $item->field_value) {
                                $item->field_value = $extendSelect->name;
                                break;
                            }
                        }
                    } else if ($item->field_type == 'foreign_multi') {
                        $arrValueId = explode(',', $item->field_value);
                        $arrValue = [];
                        foreach ($dataExtendSelect as $extendSelect) {
                            if (in_array($extendSelect->id, $arrValueId)) {
                                $arrValue[] = $extendSelect->name;
                            }
                        }
                        $item->field_value = implode(', ', $arrValue);
                    }
                }
            }
        }

        // sản phẩm có thể cũng thích
        $dataMore = $model->getDataMore();
        $dataMore = $this->nomalizeProducts($dataMore);

        // lấy bình luận, tính rate sản phẩm
        $dataRate = $model->getDataRate($data->id);
        $totalRatePoint = 4.7;
        $totalRate = 0;
        $countRate = [];
        $arrAdmin = [];
        if (!empty($dataRate)) {
            $totalRatePoint = 0;
            array_reduce($dataRate, function ($carry, $item) use (&$totalRatePoint, &$totalRate, &$countRate, &$arrAdmin) {
                if ($item->parent_id == 0) {
                    $totalRatePoint += $item->rating;
                    $totalRate++;

                    $countRate[$item->rating] = ($countRate[$item->rating] ?? 0) + 1;

                    return $carry;
                }

                $arrAdmin[] = $item;
                return $carry;
            });
            $dataRate = array_filter($dataRate, function ($item) {
                return $item->parent_id == 0;
            });

            array_map(function ($item) use ($arrAdmin) {
                $item->admin_answer = array_filter($arrAdmin, function ($admin) use ($item) {
                    return $item->id == $admin->parent_id;
                });
            }, $dataRate);

            $dataRate = array_values($dataRate);

            $totalRatePoint = round($totalRatePoint / $totalRate, 1);

            $rateId = array_map(function ($item) {
                return $item->id;
            }, $dataRate);
            $rateId = implode(',', $rateId);

            $dataRateImage = $this->model->get_records("record_id IN ($rateId)", 'fs_products_comments_images');

            foreach ($dataRate as $item) {
                $item->image = [];
                foreach ($dataRateImage as $image) {
                    if ($item->id == $image->record_id) {
                        $item->image[] = $image;
                    }
                }
            }
        }

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