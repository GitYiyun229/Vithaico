<?php

class PromotionControllersAccompanying extends Controllers
{
    function __construct()
    {
        $this->view = 'accompanying';
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $list = $model->get_data('');

        $pagination = $model->getPagination();
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $ids = FSInput::get('id', array(), 'array');
//        $id = $ids[0];
        $model = $this->model;
        $products = $model->get_all_products();
        $categories = $model->get_categories_tree();
        $maxOrdering = $model->getMaxOrdering();

//			$tags_categories = $model->get_tags_categories();
//			$data = $model->get_record_by_id($id);
        // data from fs_news_categories

//			$promotion_products = $model -> get_promotion_products($data -> id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_categories_tree();
//			$tags_categories = $model->get_tags_categories();
        $data = $model->get_record_by_id($id);
        $products = $model->get_all_products();
        $flash_sale = $model ->get_flash($id,'fs_accompanying_detail',$data->promotion_products);
//        if(@$flash_sale->promotion_products){
//            $flash_products = $model -> get_promotion_products($flash_sale -> promotion_products);
//        }
//        $hot_sale = $model ->get_flash($id,'fs_hot_sale');
//        if(@$hot_sale->promotion_products){
//            $hot_products = $model -> get_promotion_products($hot_sale -> promotion_products);
//        }

        // data from fs_news_categories

//			$promotion_products = $model -> get_promotion_products($data -> promotion_products);
//        $promotion_products = $model->get_list_promotion_products($data->promotion_products);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    // remove products_together
    function remove_product()
    {
        $model = $this->model;
        if ($model->remove_promotion_product()) {
            echo '1';
            return;
        } else {
            echo '0';
            return;
        }
    }

    function update_product($id)
    {

        $model = $this->model;
        $promotion = $model->get_record_by_id($id, 'fs_promotion');
//			if($promotion -> date_start < date('Y-m-d H:i:s') && $promotion -> date_end > date('Y-m-d H:i:s')){
        $link = 'index.php?module=' . $this->module . '&view=promotion&task=update&id=' . $id;
//			}else{
//				$link = 'index.php?module='.$this -> module.'&view=promotion&task=no_update';
//			}
        return '<a href="' . $link . '" title="Update lại toàn bộ danh sách  sản phẩm" ><img src="templates/default/images/toolbar/icon-update.png" /> </a>';

    }

    /*
     *
     */
    function update()
    {
        $id = FSInput::get('id', 0, 'int');
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $model = $this->model;
        $rs = $model->update_product($id);
        if ($this->page)
            $link .= '&page=' . $this->page;
        if ($rs) {
            setRedirect($link, $rs . ' ' . FSText:: _('Sản phẩm  đã update'));
        } else {
            setRedirect($link, FSText:: _('Không có sản phẩm  nào được upadte'));
        }
    }

    function no_update()
    {
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        if ($this->page)
            $link .= '&page=' . $this->page;
        setRedirect($link, FSText:: _('Không thể update. Bạn hãy kiểm tra lại thời gian k/m'), 'error');

    }
    function ajax_get_products_related()
    {
        $model = $this->model;
        $id = FSInput::get('product_id');
        $data = $model->ajax_get_products_related();
//        $html = $this->products_genarate_related($data);
        $html = $this->products_genarate_related($data,$id);

        echo $html;
        return;
    }

    function products_genarate_related($data,$promotion_id)
    {
        $arr_id = '';
        foreach ($data as $item_id){
            $arr_id .= $item_id->id . ',';
        }

        $arr_id = rtrim($arr_id,',');
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<a onclick="javascript:gene_all()" style="font-weight: 600;padding: 5px 10px;border: 1px solid #ccc;margin-top: 5px;display: block;width: 121px;cursor: pointer;">Chọn tất cả</a>';
        $html .= '<input type="hidden" name="gene_all" id="gene_all" value="' . $arr_id . '">';
        $html .= '<div class="products_related">';
        foreach ($data as $item) {
//            $class = '';
//            if($item->promotion_id != 0) {
//                $time = date('Y-m-d H:i:s');
//                $text = '';
//                if ($time < $item->promotion_start_time) {
//                    $text = 'Sắp diễn ra';
//                    $class = 'actived';
//                } elseif ($time > $item->promotion_end_time) {
//                    $text = 'Đã kết thúc';
//                } else {
//                    $text = 'Đang diễn ra';
//                    $class = 'actived';
//                }
//            }
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red products_related_item  products_related_item_' . $item->id . '" onclick="javascript: set_products_related(' . $item->id . ','.$item->price.','.$item->price_old.')" style="display:none" >';
                $html .= '<p style="margin-bottom: 0">'.$item->name . '</p>';

//                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            } else {
                $html .= '<div class="products_related_item  products_related_item_' . $item->id .  '" onclick="javascript: set_products_related(' . $item->id . ')">';
                $html .= '<p style="margin-bottom: 0;display: inline-block">'.$item->name . '</p>';

//                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
    function ajax_get_products_related_hot()
    {
        $model = $this->model;
        $id = FSInput::get('product_id');
        $data = $model->ajax_get_products_related();
//        $html = $this->products_genarate_related($data);
        $html = $this->products_genarate_related_hot($data,$id);

        echo $html;
        return;
    }
    function products_genarate_related_hot($data,$promotion_id)
    {
        $arr_id = '';
        foreach ($data as $item_id){
            $arr_id .= $item_id->id . ',';
        }

        $arr_id = rtrim($arr_id,',');
        $str_exist = FSInput::get('str_exist_hot');
        $html = '';
        $html .= '<a onclick="javascript:gene_all_hot()" style="font-weight: 600;padding: 5px 10px;border: 1px solid #ccc;margin-top: 5px;display: block;width: 121px;cursor: pointer;">Chọn tất cả</a>';
        $html .= '<input type="hidden" name="gene_all_hot" id="gene_all_hot" value="' . $arr_id . '">';
        $html .= '<div class="products_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red products_related_item  products_related_item_' . $item->id . '" onclick="javascript: set_products_related_hot(' . $item->id . ')" style="display:none" >';
                $html .= $item->name . '';
//                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            } else {
                $html .= '<div class="products_related_item  products_related_item_' . $item->id . '" onclick="javascript: set_products_related_hot(' . $item->id . ')">';
                $html .= $item->name . '';
//                $html .= '<img src="' . str_replace('/original/', '/resized/', URL_ROOT . @$item->image) . '" width="80">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}

?>