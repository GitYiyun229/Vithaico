<?php
/*
 * Huy write
 */

// controller

class NewsControllersNews extends FSControllers
{
    var $module;
    var $view;

    function display()
    {
        // call models
        $model = $this->model;

        $redirect = $model->get_redirect();
        // print_r($redirect);die;
        // $code = FSInput::get('ccode');
        $code = substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT_REDUCE));
        if (@$redirect) {
            $data_prd = $model->get_product_re($redirect->record_id);
            $linh_rec = FSRoute::_('index.php?module=news&view=news&ccode=' . $data_prd->alias);
            if ($code != $data_prd->alias) {
                header("HTTP/1.1 301 Moved Permanently");
                header("Location: " . $linh_rec);
                exit();
            }
        }
        
        $data = $model->getNews();
        if (!$data) {
            $link = URL_ROOT . '404.html';
            setRedirect($link);
        }
        $category_id = $data->category_id;
        $category = $model->get_category_by_id($category_id);
        if (!$category)
            die('Kh&#244;ng th&#7845;y Category');
        

        $list_related = $this->model->get_news_realted($data->news_related);

        $list_comment = $this->model->get_records(" record_id = $data->id and parent_id = 0 and published = 1", 'fs_news_comments', '*', 'created_time DESC');
        foreach($list_comment as $key=>$item) {
            $list_comment[$key]->childs = $this->model->get_records(" record_id = $data->id and parent_id = $item->id and published = 1", 'fs_news_comments');
        }
        $total_comment = $this->model->get_count(" record_id = $data->id and published = 1", 'fs_news_comments', '*', 'created_time DESC');
        $user = $model->get_record_by_id($data->author_id, 'fs_users','image,summary,fname');
        
        $content = $data->content;
        
        preg_match_all('#{-(.*?)-}#is', $content, $tmp);
       // print_r($tmp[1]);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[0])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    $body_product .= '</div></div></a>';
                    $str_include .= '{-'.$id_pr.'-}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }

        preg_match_all('#{1-(.*?)-1}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                    $str_include .= '{1-'.$id_pr.'-1}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }

        preg_match_all('#{2-(.*?)-2}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    $body_product .= '</div></div></a>';
                    $str_include .= '{2-'.$id_pr.'-2}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }
        preg_match_all('#{3-(.*?)-3}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                    $str_include .= '{3-'.$id_pr.'-3}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }
        preg_match_all('#{4-(.*?)-4}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                    $str_include .= '{4-'.$id_pr.'-4}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }
        preg_match_all('#{5-(.*?)-5}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }
        preg_match_all('#{6-(.*?)-6}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                    $str_include .= '{6-'.$id_pr.'-6}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }
        preg_match_all('#{7-(.*?)-7}#is', $content, $tmp);
        // preg_match_all('#{[0-9]*}#is', $content, $tmp);
        //print_r($tmp);
        $body_product = '';
        $str_include = '';
        if(isset($tmp[1])){
            $body_product .= '<div class="problock clear" style="margin-bottom:10px;">';
            foreach($tmp[1] as $id_pr){
                $it_pro = $model -> get_product($id_pr);
                $price = $it_pro->price;
                $price_sale = $price;
                $flash_sale = $this->model->get_sale_product($id_pr);
                if(!empty($flash_sale)&&(($time_now <=$item->promotion_end_time))) {
                    if ($flash_sale->discount_unit == 1) {
                        $price_sale = $price - $flash_sale->discount;
                        $percent = round(100 - $price_sale * 100 / $item->price_old, 0);
                    } else {
                        $percent = $flash_sale->discount;
                        $price_sale = $price - $flash_sale->discount * $price / 100;
                    }
                    $text_coundown = '';
                    if ($time_now < $item->promotion_start_time) {
                        $text_coundown = '<span style="color:#d40b25"><b>Diễn ra sau </b></span> ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_start_time));
                    } elseif ($time_now <= $item->promotion_end_time) {
                        $text_coundown = 'Còn: ';
                        $time_end = date('M d Y H:i:s', strtotime($item->promotion_end_time));
                    }
                }
                if ($it_pro){
                    $link_product = FSRoute::_('index.php?module=products&view=product&ccode='.$it_pro->alias);
                    $body_product .= '<a class="pro col-md-3" href="'.$link_product.'"><div class="content">';
                    $body_product .= '<div class="left col-md-12"><img src="'.URL_ROOT.str_replace('original','resized',$it_pro->image).'" alt="'.$it_pro->name.'"></div>';
                    $body_product .= '<div class="right col-md-12"><span class="name">'.$it_pro->name.'</span>';
                    $body_product .= '<span class="price">'.format_money($price_sale ).'</span>';
                    $body_product .= '<span class="price_old">'.format_money($it_pro->price_old).'</span>';
                    
                    $body_product .= '</div></div></a>';
                    $str_include .= '{7-'.$id_pr.'-7}';
                }
            }
            $body_product .= '</div>';
            $content = str_replace($str_include,$body_product,$content);
        }

        $data->content = $content;

        $description = $this->insert_link_keyword($data->content);

        if ($data->products_related) {
            $products_related = $model->get_record('published = 1 and id IN(0' . $data->products_related . '0)', 'fs_products');
        }

        $breadcrumbs = array();
        $breadcrumbs[] = array(0 => 'Tin tức & Sự kiện', 1 => FSRoute::_('index.php?module=news&view=home&Itemid=2'));
        $breadcrumbs[] = array(0 => $category->name, 1 => FSRoute::_('index.php?module=news&view=cat&id=' . $data->category_id . '&ccode=' . $data->category_alias));
//			$breadcrumbs[] = array(0=>$data->title, 1 => '');	
        global $tmpl, $module_config;
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->assign('title', $data->title);
        $tmpl->assign('tags_news', $data->tags);
        $tmpl->assign('products_related', $data->products_related);
        $tmpl->assign('news_related', $data->news_related);
        $images_face = URL_ROOT . str_replace('/original/', '/original/', $data->image);
        $tmpl->assign('og_image', $images_face);
        $link_news = FSRoute::_("index.php?module=news&view=news&ccode=" . $data->alias);
        $tmpl->assign('canonical', $link_news);
        $link_amp = FSRoute::_('index.php?module=news&view=amp_news&code=' . $data->alias . '&id=' . $data->id . '&ccode=' . $data->category_alias . '&Itemid=50');
        $tmpl->assign('html_amp', $link_amp);
        // seo
//			 $this -> set_header($data);
        $this->update_hits();
        $tmpl->set_data_seo($data);

        // call views
        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }


    function save_comment()
    {
        $model = $this->model;

        $row = array();
        $row['name'] = addslashes(FSInput::get('fullname'));
        $row['email'] = addslashes(FSInput::get('email'));
        $row['comment'] = addslashes(FSInput::get('content'));
        $row['record_id'] = addslashes(FSInput::get('id'));

        if (FSInput::get('comment_id')) {
            $row['comment_id'] = addslashes(FSInput::get('comment_id'));
        }
        $_SESSION['comment_guest'] = $row;

        $id = $model->save_comment2();
        if (!$id) {
            setRedirect(URL_ROOT, 'Có lỗi xảy ra, bạn vui lòng thử lại', 'error');
        }
        if ($id) {
            $link = FSInput::get('link');
            setRedirect($link, 'Bình luận thành công, vui lòng chờ xét duyệt', 'success');
        }

        unset($_SESSION['comment_guest']);
    }

    function replyComment()
    {
        global $user;
        $userInfo = $user->userInfo;
        $name = $userInfo->full_name;
        $text = FSInput::get('text');
        $record_id = FSInput::get('record_id', 0, 'int');
        $parent_id = FSInput::get('parent_id', 0, 'int');
        $user_id = FSInput::get('user_id', 0, 'int');

        if (!$name || !$text || !$record_id) {
            echo 0;
            return false;
        }

        $time = date('Y-m-d H:i:s');
        $row ['name'] = $name;
        $row ['user_id'] = $user_id;
        $row ['comment'] = $text;
        $row ['record_id'] = $record_id;
        $row ['parent_id'] = $parent_id;
        // $row ['published'] = 1;
        $row ['readed'] = 1;
        $row ['created_time'] = $time;
        $row ['edited_time'] = $time;
        $row ['replied'] = 1;
        $rs = $this->model->_add($row, 'fs_products_comments');
        echo $rs ? 1 : 0;
        if ($rs) {
            $row3['replied'] = 1;
            $this->model->_update($row3, 'fs_products_comments', ' id = ' . $parent_id);
        }
        if ($rs)
            $this->recal_comments($record_id);
        setRedirect(URL_ROOT, 'Cảm ơn bạn đã nhận xét', 'success');
        // return $rs;
    }

    // check captcha
    function check_captcha()
    {
        $captcha = FSInput::get('txtCaptcha');

        if ($captcha == $_SESSION["security_code"]) {
            return true;
        } else {
        }
        return false;
    }

    function rating()
    {
        $model = $this->model;
        if (!$model->save_rating()) {
            echo '0';
            return;
        } else {
            echo '1';
            return;
        }
    }

    function count_views()
    {
        $model = $this->model;
        if (!$model->count_views()) {
            echo 'hello';
            return;
        } else {
            echo '1';
            return;
        }
    }

    // update hits
    function update_hits()
    {
        $model = new NewsModelsNews();
        $id = $model->update_hits();
        return;
    }

    /*
 * Tạo ra các tham số header ( cho fb)
 */
    function set_header($data, $image_first = '')
    {
        $link = FSRoute::_("index.php?module=news&view=news&id=" . $data->id . "&code=" . $data->alias . "&ccode=" . $data->category_alias);
        $str = '<meta property="og:title"  content="' . htmlspecialchars($data->title) . '" />
					<meta property="og:type"   content="website" />
					';
        $image = URL_ROOT . str_replace('/original/', '/large/', $data->image);
        $str .= '<meta property="og:image"  content="' . $image . '" />
				<meta property="og:image:width" content="390"/>
				<meta property="og:image:height" content="204"/>

				';


        $str .= '<meta property="og:url"    content="' . $link . '" /> 
  					<meta property="og:description"  content="' . htmlspecialchars($data->summary) . '" />';

        global $tmpl;
        $tmpl->addHeader($str);
    }

    function add_point(){
        $id = FSInput::get('id');
        $check = FSInput::get('check');
        $point = $this->model->get_record('id = '.$id,'fs_news_comments','id,add_point')->add_point;
        $rs = $this->model->add_point($id,$check,$point);

        if($check == 0){
            $update_point = $point + 1;
            $update_check = 1;
        } else if($check == 1){
            $update_point = $point - 1;
            $update_check = 0;
        }

        $update_point  = $update_point == 0 ? '' : $update_point;

        $json = array(
            'error' => true,
            'point' => $update_point,
            'check' => $update_check
        );
        echo json_encode($json);
    }
}

?>