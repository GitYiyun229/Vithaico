<?php

/**
 * @author vangiangfly
 * @category controller
 */

//class AutumnControllersAutumn
class AutumnControllersAutumn extends FSControllers

{
    var $module;
    var $view;

//    function __construct()
//    {
//        $this->module = 'autumn';
//        $this->view = 'autumn';
//        include 'modules/' . $this->module . '/models/' . $this->view . '.php';
//    }

    function display()
    {
//        $model = new AutumnModelsAutumn();
        $model = $this->model;
        $msg = '';
//        $data = $model->get_data_();
        $banner = $model->get_banner();
//        var_dump($banner);
        $banner_mb = $model->get_banner_mb();
        $slide = $model->get_slide();
        $list_cat_autumn = $model->get_cat();
        foreach ($list_cat_autumn as $item) {
            $list_prd[$item->id] = $model->get_prd($item->id);
//            var_dump($list_prd[$item->id]);
        }
        $list_newhot = $model->get_new();
        $comments = $model->get_comments();
//        var_dump($comments);
        $total_comment = count($comments);
        if ($total_comment) {
            $list_parent = array();
            $list_children = array();
            foreach ($comments as $item) {
                if (!$item->parent_id) {
                    $list_parent [] = $item;
                } else {
                    if (!isset ($list_children [$item->parent_id]))
                        $list_children [$item->parent_id] = array();
                    $list_children [$item->parent_id] [] = $item;
                }
            }
        }
        $images_face = URL_ROOT.$banner[0]->image;

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => FSText::_('Thu-cu-doi-moi'), 1 => '');
        global $tmpl;
        $tmpl -> assign ( 'og_image',$images_face );

        $tmpl->set_seo_special();
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $link = FSRoute::_("index.php?module=autumn&view=autumn");
        $tmpl -> assign( 'canonical',$link);
        include 'modules/' . $this->module . '/views/' . $this->view . '/' . 'default.php';
    }

    function loadmore()
    {
        // call models
        $model = $this->model;

        $pagecurrent = FSInput::get('pagecurrent');
        $limit = FSInput::get('limit');
        $cid = FSInput::get('cid');
        $total_old = $pagecurrent * $limit;
        $gt = $total_old . ',' . $limit;

        $fs_table = FSFactory::getClass('fstable');
        $table_name = $fs_table->getTable('fs_image');
        $sticky = $model->get_records('published = 1', 'fs_sticky', '*');

        $list = $model->get_ajax_loadmore();
//        if (count($list) < $limit)
//            echo '<script>$(".c-view-more .load_more").hide();</script>';
//var_dump($list);
        if ($list) {
//            echo 23;
            include 'modules/products/views/cat/loadmore.php';
        } else {
            $list = '';
            echo $list;
        }
    }

    function ajax_get_autumn()
    {
        $keyword = FSInput::get('keyword');

//        $model = new AutumnModelsAutumn();
        $model = $this->model;

        $query_body = $model->set_query_body1($keyword);
        $list_cmp = $model->get_list($query_body);
        $html = '';
        $html .= '<div class="row row_autumn">';
        foreach ($list_cmp as $item) {
            $html .= '<div class="col-md-2dot4 col_autumn col-xs-6">
                        <div class="item_prd text-center">
                            <a href="javascript:void(0)"  onclick="autumn(' . $item->id . ')">
                                <img src="https://didongthongminh.vn/' . str_replace('original', 'resized', $item->image) . '"
                                     alt="' . $item->name . '" class="img-responsive">
                                <h3>' . $item->name . '</h3>
                                <p>Giá thu cũ:
                                    <span>' . format_money($item->price_autumn, 'đ') . '</span></p>
                            </a>';
            $html .= '</div>
                    </div>';
        }
        $html .= '</div>';
        echo $html;

    }

    function sbm_autumn()
    {
//        if (isset($_SESSION['autumn']) && !empty($_SESSION['autumn'])) {
//            unset($_SESSION['autumn']);
//        }
        $id = FSInput::get('id');
//        $model = new AutumnModelsAutumn();
        $model = $this->model;

        $product = $model->get_item($id);
        $list_autumn = $model->get_autumn();
        $list_combo = $model->get_combo();
        $list_cat_autumn = $model->get_cat();
        foreach ($list_cat_autumn as $item) {
            $list_prd[$item->id] = $model->get_prd($item->id);
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-popup.php';
        return;
    }

    function list_products()
    {
        if (isset($_SESSION['autumn']) && !empty($_SESSION['autumn'])) {
            unset($_SESSION['autumn']);
        }
        $id = FSInput::get('id');
        $price = FSInput::get('price');
        $type_autumn = FSInput::get('type_autumn');
        $type_combo = FSInput::get('type_combo');
//        echo $id;
        $_SESSION['autumn'] = array($id, $price, $type_autumn, $type_combo);
//        var_dump($_SESSION['autumn']);
        $model = $this->model;
        $product_autum = $model->get_item($id);
        $list_autumn = $model->get_autumn();
        $list_combo = $model->get_combo();
        $list_cat_autumn = $model->get_cat_renew();
        foreach ($list_cat_autumn as $item) {
            $list_prd[$item->id] = $model->get_prd_renew($item->id);
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-listprd.php';
        return;
    }
    function chonmay()
    {
        $id = FSInput::get('id');
//        $price = FSInput::get('price');
//        $type_autumn = FSInput::get('type_autumn');
//        $type_combo = FSInput::get('type_combo');
//        echo $id;
//        var_dump($_SESSION['autumn']);
        $model = $this->model;
        $product = $model->get_item($id);
        $product_images = $model->getImages($product->id);


//        $cat_sale = $model->get_record('published = 1 AND id=' . $product->sale_id, 'fs_sales_categories', 'fdate,tdate');
//
//        $time_start = @$cat_sale->fdate;
//        $time_end = @$cat_sale->tdate;
//        $time_now = date('Y-m-d H:i:s');
        $product_active = $model->get_record('published = 1 and product_id=' . $product->id . ' and price = ' . $product->price . ' order by price asc limit 1', 'fs_products_sub', '*');
//        if ($time_start <= $time_now && $time_end >= $time_now && $product->is_hotdeal == 1) {
//            // nếu là sản phẩm sale thì tính lại active
//            $product_active = $model->get_record('published = 1 and product_id=' . $product->id . ' and price_h = ' . $product->h_price . ' order by price asc  limit 1', 'fs_products_sub', '*');
//            $price = $product->h_price;
//            $price_old = $product_active->price;
//            $price_active = $product->h_price;
//            $insale = 1;
//        } else {
            $price = $product->price;
            $price_old = $product->price_old;
            $price_active = $product->price;
//        }
//        var_dump($product_active);
//        $image_active = $model->get_record('record_id = '.$product->id.' AND color_id=' . $product_active->color_id, 'fs_products_images', 'image');

        $list_sub = $model->get_records('published = 1 and product_id=' . $product->id  . ' order by price asc', 'fs_products_sub', '*');
//        var_dump($list_sub);
        if ($list_sub) {
            $json = '['; // start the json array element
            $json_names = array();
            foreach ($list_sub as $item) {
//                if ($time_start <= $time_now && $time_end >= $time_now && $product->is_hotdeal == 1) {
//                    $price_sub = $item->price_h;
//                    $price_sub_old = $item->price;
//                } else {
                    $price_sub = $item->price;
                    $price_sub_old = $item->price_old;
//                }
//                memory_id: $item->memory_id, origin_id: $item->origin_id
                $json_names[] = "{price_old : $price_sub_old, color_id: $item->color_id, species_id: $item->species_id, origin_id: $item->origin_id, price: $price_sub , id: $item->id}";
            }
            $json .= implode(',', $json_names);
            $json .= ']'; // end the json array element
        }
//        $color = array();
//        $ram = array();
//        $origin = array();
//        foreach ($list_sub as $item){
//            $code_color[$item->color_id] = $model->get_record('published = 1 and id=' . $item->color_id, 'fs_products_colors', '*');
//            $image_color[$item->color_id]= $model->get_record('record_id = '.$product->id.' and color_id=' . $item->color_id, 'fs_products_images', '*');
//            if ($item->color_id) {
//                if (in_array($item->color_id, $color)) {
//
//                } else {
//                    $color[] = $item->color_id;
//                }
//            }
//            if ($item->species_id) {
//                if (in_array($item->species_id, $ram)) {
//
//                } else {
//                    $ram[] = $item->species_id;
//                }
//            }
//            if ($item->origin_id) {
//                if (in_array($item->origin_id, $origin)) {
//
//                } else {
//                    $origin[] = $item->origin_id;
//                }
//            }
//        }
        $list_autumn = $model->get_autumn();
        $list_combo = $model->get_combo();
        $list_cat_autumn = $model->get_cat();
        foreach ($list_cat_autumn as $item) {
            $list_prd[$item->id] = $model->get_prd($item->id);
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/ajax-buy.php';
        return;
    }

    function set_session()
    {

        $id = FSInput::get('id');
        $price = FSInput::get('price');
        $type_autumn = FSInput::get('type_autumn');
        $type_combo = FSInput::get('type_combo');
        if (isset($_SESSION['autumn']) && !empty($_SESSION['autumn'])) {
            unset($_SESSION['autumn']);
        }
        if (empty($_SESSION['autumn'])) {
            $_SESSION['autumn'] = array($id, $price, $type_autumn, $type_combo);
        }
        var_dump($_SESSION['autumn']);
    }

    function ajax_get_autumn1()
    {
        $keyword = FSInput::get('keyword');

//        $model = new AutumnModelsAutumn();
        $model = $this->model;
        $query_body = $model->set_query_body2($keyword);
        $list_cmp = $model->get_list($query_body);
        $html = '';
        $html .= '<div class="row row_autumn">';
        foreach ($list_cmp as $item) {
            $html .= '<div class="col-md-3 col_autumn col-xs-6">
                        <div class="item_prd text-center">
                            <a href="javascript:void(0)"  class="change_prd" data-id="'.$item->id.'">
                                <img src="https://didongthongminh.vn/' . str_replace('original', 'resized', $item->image) . '"
                                     alt="' . $item->name . '" class="img-responsive">
                                <h3>' . $item->name . '</h3>
                                <p><span>Giá máy:</span>
                                            <span>' . format_money($item->price, 'đ') . '</span>
                                        </p>
                                        <p><span>Giá máy cũ:</span>
                                            <span>' . format_money($_SESSION['autumn'][1], 'đ') . '</span>
                                        </p>
                                        <p><span>Bù chênh lệch:</span>';
                                            if ($item->price > $_SESSION['autumn'][1]) {
                                                $html .= '<span class="price_end">' . format_money($item->price - $_SESSION['autumn'][1], 'đ') . '</span>';
                                            } else {
                                                $html .= '<span class="price_end">Liên hệ</span>';

                                            };
                                        $html .= '</p>';
                                    $html .= '</a>';
                                $html .= '</div>
                    </div>';
        }
        $html .= '</div>';
        echo $html;

    }
    function autumn_save()
    {
        $model = $this->model;

        $session_order = $model->autumn_save();

//        $send_mail = $model->mail_to_buyer($session_order);

//           	 var_dump($session_order); die();
        if ($session_order) {
//        unset($_SESSION['autumn']);
            $_SESSION['sc'] = 1;
        }else{
            $_SESSION['sc'] = 2;
        }
//        $link = FSRoute::_('index.php?module=autumn&view=autumn&Itemid=250');
        $link = URL_ROOT.'thu-cu-doi-moi';
//        echo $link;die;
        setRedirect($link);
//        } else {
//            $link = FSRoute::_('index.php?module=autumn&view=autumn');
//            setRedirect($link, 'Bạn chưa đặt hàng thành công!');
//        }
    }
    function ajax_get_close(){
        if (@$_SESSION['sc']){
            unset($_SESSION['sc']);
        }
    }
    /* Save comment */
    function save_comment()
    {
        $url = FSInput::get('return');

        // var_dump($model); die();
        $model = $this->model;
        if (!$model->save_comment()) {
            $msg = 'Chưa lưu thành công comment!';
            setRedirect($url, $msg, 'error');
        } else {
            setRedirect($url, 'Cảm ơn bạn đã gửi bình luận');
        }
    }
    function all_conment()
    {
//        $id = FSInput::get('id');
        $model = $this->model;
        $comments = $model->get_comments();
        $total_comment = count($comments);
        $rating_count = $total_comment;
        // $comments_ad = $model->get_comments_admin();
        if ($total_comment) {
            $list_parent = array();
            $list_children = array();
            foreach ($comments as $item) {
                if (!$item->parent_id) {
                    $list_parent [] = $item;
                } else {
                    if (!isset ($list_children [$item->parent_id]))
                        $list_children [$item->parent_id] = array();
                    $list_children [$item->parent_id] [] = $item;
                }
            }
        }
        include 'modules/' . $this->module . '/views/' . $this->view . '/comments.php';
    }
//load ram
    function ajax_load_ram()
    {
        $ram_id = FSInput::get('ram_id');
        $model = $this->model;
        $id = FSInput::get('id');
        $data = $model->get_item($id);
        $cat_sale = $model->get_record('published = 1 AND id=' . $data->sale_id, 'fs_sales_categories', 'fdate,tdate');

        $time_start = @$cat_sale->fdate;
        $time_end = @$cat_sale->tdate;
        $time_now = date('Y-m-d H:i:s');
        $insale = 0;
        if ($time_start <= $time_now && $time_end >= $time_now && $data->is_hotdeal == 1) {
            $insale = 1;
        }//        var_dump($product_active);die;
//        var_dump($insale);
        $origin_active = $model->get_records(
            'product_id = ' . $data->id . ' AND species_id =' . $ram_id . '.AND published = 1',
            'fs_products_sub', '*');
//        var_dump($origin_active);
        $origin_arr = array();
//        $price_min = '';
//        $price_min_id = '';
//        $price_isset = array();
        foreach ($origin_active as $item) {
            if ($item->origin_id) {
                if (in_array($item->origin_id, $origin_arr)) {
                } else {
                    $origin_arr[] = $item->origin_id;
                }
            }
        }
        $price_min = '';
        $price_min_id = '';
        foreach ($origin_active as $item) {
            if ($insale == 1) {
                $price_show = $item->price_h;
            } else {
                $price_show = $item->price;
//                var_dump($price_show);
            }
            if ($price_min == '') {
                $price_min = $price_show;
                $price_min_id = $item->id;
            } else {
                if ($price_show < $price_min) {
                    $price_min = $price_show;
                    $price_min_id = $item->id;
                }
            }
        }
//        var_dump($price_min_id);
//        var_dump($price_min);
        $product_active = $model->get_record('published = 1 and product_id=' . $data->id . ' AND species_id = ' . $ram_id . ' AND id =' . $price_min_id . ' order by price asc limit 1', 'fs_products_sub', '*');

//        var_dump($product_active);
//        var_dump($origin_arr);
        $origin = '
        <span class="attr">Tình trạng : <b class="origin_title">' . @$product_active->origin_name . '</b></b></span>
        ';
        foreach ($origin_arr as $item => $value) {
            $origin_item = $model->get_record('id=' . $value, 'fs_origin', '*');
            $active = "";
            if ($product_active->origin_id == $value) {
                $active = "active";
            }
            $origin .= '
                <div data="origin_item" name="origin_title"
                                         name-item="' . $origin_item->name . '"
                                         origin_id="' . $origin_item->id . '"
                                         class="item_price origin_item origin_click ' . $active . '">
                                        <p class="radio_check"></p>
                                        <p class="gb">' . $origin_item->name . '</p>
                                    </div>
            ';
        }
        $color_by_origin = $model->get_records(
            'product_id = ' . $data->id . ' AND published = 1 AND species_id =' . $ram_id . ' AND origin_id =' . $product_active->origin_id,
            'fs_products_sub', '*');
//        var_dump($color_by_origin);
        $color = '<span class="attr cl">Màu sắc </span>';

        $i = 1;
        foreach ($color_by_origin as $item) {
            $color_item = $model->get_record('id=' . $item->color_id, 'fs_products_colors', '*');
            $active = "";
            if ($product_active->id == $item->id) {
                $active = "active";
            }
            if ($insale) {
                $price_show = $item->price_h;
//                var_dump($price_show);

            } else {
                $price_show = $item->price;
            }
            $color .= '
                                <span data="color_item" name="color_title"
                                     color_id="' . $color_item->id . '"
                                     name-item="' . $color_item->name . '"
                                     class="Selector item_price color_item ' . $active . '"
                                     data-toggle="tooltip"
                                     data-original-title="' . $color_item->name . '" style="background-color: #' . $color_item->code . '">
                                </span>
                           ';
            $i++;
        }


        $json = array(
            'origin' => '',
            'color' => '',
//            'store' => '',
        );
        $json['origin'] = $origin;
        $json['color'] = $color;
//        $json['store'] = $store;
        echo json_encode($json);
    }
    function ajax_load_origin()
    {
        $origin_id = FSInput::get('origin_id');
        $ram_id = FSInput::get('ram_id');
        $where = '';
        if ($ram_id) {
            $where = ' AND species_id =' . $ram_id;
        }
//        echo $where;
//        echo $origin_id;die;
        $model = $this->model;
        $id = FSInput::get('id');
        $data = $model->get_item($id);
//        var_dump($data->sale_id);
        $cat_sale = $model->get_record('published = 1 AND id=' . $data->sale_id, 'fs_sales_categories', 'fdate,tdate');

        $time_start = @$cat_sale->fdate;
        $time_end = @$cat_sale->tdate;
        $time_now = date('Y-m-d H:i:s');
        $insale = 0;
        if ($time_start <= $time_now && $time_end >= $time_now && $data->is_hotdeal == 1) {
            $insale = 1;
        }
//        var_dump($insale);die;
        $origin_active = $model->get_records(
            'product_id = ' . $data->id . ' AND published = 1 AND origin_id =' . $origin_id . $where,
            'fs_products_sub', '*');
//        var_dump($origin_active);
        $origin_arr = array();
        $price_isset = array();
        foreach ($origin_active as $item) {
            if ($item->price != 0) {
                $price_isset[$item->id] = $item->price;
            }
        }
//        var_dump($price_isset);die;
//        $price_min = '';
//        $price_min_id = '';
//        foreach ($origin_active as $item => $value) {
//            if ($price_min == '') {
//                $price_min = $value;
//                $price_min_id = $item;
//            } else {
//                if ($value < $price_min) {
//                    $price_min = $value;
//                    $price_min_id = $item;
//                }
//            }
//        }
//        var_dump($price_min_id);
        $price_min = '';
        $price_min_id = '';
        foreach ($origin_active as $item) {
            if ($insale == 1) {
                $price_show = $item->price_h;
            } else {
                $price_show = $item->price;
            }
            if ($price_min == '') {
                $price_min = $price_show;
                $price_min_id = $item->id;
            } else {
                if ($price_show < $price_min) {
                    $price_min = $price_show;
                    $price_min_id = $item->id;
                }
            }
        }
//        var_dump($price_min_id);
        $product_active = $model->get_record('published = 1 and product_id=' . $data->id . $where . ' AND id =' . $price_min_id . ' order by price asc limit 1', 'fs_products_sub', '*');

//        var_dump($product_active);
        $color = '';
        if ($product_active->color_id) {
            $color .= '<span class="attr cl">Màu sắc </span>';
            
            $i = 1;
            foreach ($origin_active as $item) {
                $color_item = $model->get_record('id=' . $item->color_id, 'fs_products_colors', '*');
                $active = "";
                if ($product_active->id == $item->id) {
                    $active = "active";
                }
                if ($insale) {
                    $price_show = $item->price_h;
                } else {
                    $price_show = $item->price;
                }
                $color .= '
                                <span data="color_item" name="color_title"
                                     color_id="' . $color_item->id . '"
                                     name-item="' . $color_item->name . '"
                                     class="Selector item_price color_item ' . $active . '"
                                     data-toggle="tooltip"
                                     data-original-title="' . $color_item->name . '" style="background-color: #' . $color_item->code . '">
                                </span>
                           ';

                $i++;
            }

//        print_r($color);die;
        }

        $json = array(
            'color' => '',
//            'store' => '',
        );
        $json['color'] = $color;
//        $json['store'] = $store;
        echo json_encode($json);
    }

}

?>