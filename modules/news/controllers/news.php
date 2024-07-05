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
        $data = $model->getNews();
        if (!$data)
            setRedirect(URL_ROOT, 'Không tồn tại bài viết này', 'Error');

        // $relate_news_list = $model->getRelateNewsList($data->news_related);
        // if ($data->tags) {
        //     $tags = $model->get_tags($data->tags);
        // }

        $list_hot_news = $this->model->get_list_hot();
        $list_promotion_news = $this->model->get_list_promotion();
        $relate_news_list = $model->get_list_related($data->id, $data->category_id);

        global $tmpl;
        $tmpl->setTitle($data->seo_title ? $data->seo_title : $data->title);
        $tmpl->setMetades($data->seo_description ? $data->seo_description : $data->content);
        $tmpl->setMetakey($data->seo_keyword ? $data->seo_keyword : $data->title);
        $tmpl->assign('og_image', URL_ROOT . $data->image);

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
        $row['name'] = $name;
        $row['user_id'] = $user_id;
        $row['comment'] = $text;
        $row['record_id'] = $record_id;
        $row['parent_id'] = $parent_id;
        // $row ['published'] = 1;
        $row['readed'] = 1;
        $row['created_time'] = $time;
        $row['edited_time'] = $time;
        $row['replied'] = 1;
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

    function add_point()
    {
        $id = FSInput::get('id');
        $check = FSInput::get('check');
        $point = $this->model->get_record('id = ' . $id, 'fs_news_comments', 'id,add_point')->add_point;
        $rs = $this->model->add_point($id, $check, $point);

        if ($check == 0) {
            $update_point = $point + 1;
            $update_check = 1;
        } else if ($check == 1) {
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
