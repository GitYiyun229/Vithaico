<?php

class FSRoute
{
    var $url;

    function __construct($url)
    {
    }

    static function _($url)
    {
        return FSRoute::enURL($url);
    }

    /*
     * Trả lại tên mã hóa trên URL
     */
    static function get_name_encode($name, $lang)
    {
        $lang_url = array(
            'ct' => 'ce',
        );
        if ($lang == 'vi')
            return $name;
        else
            return $lang_url[$name];
    }

    static function addParameters($params, $value)
    {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        if ($module == 'products' && $view == 'search') {
            $array_paras_need_get = array('ccode', 'filter', 'manu', 'order', 'status', 'style', 'Itemid', 'keyword');
            $url = 'index.php?module=' . $module . '&view=' . $view;
            foreach ($array_paras_need_get as $item) {
                if ($item != $params) {
                    $value_of_param = FSInput::get($item);
                    if ($value_of_param) {
                        $url .= "&" . $item . "=" . $value_of_param;
                    }
                } else {
                    if ($value)
                        $url .= "&" . $item . "=" . $value;
                }
            }
            return FSRoute::_($url);
        }
        if ($module == 'products' && $view == 'cat') {
            $array_paras_need_get = array('ccode', 'manu', 'order', 'status', 'style', 'sort', 'Itemid', 'cid', $params);
            $url = 'index.php?module=' . $module . '&view=cat';
            foreach ($array_paras_need_get as $item) {
                if ($item != $params) {
                    $value_of_param = FSInput::get($item);
                    if ($value_of_param) {
                        $url .= "&" . $item . "=" . $value_of_param;
                    }
                } else {
                    if ($value)
                        $url .= "&" . $item . "=" . $value;
                }
            }
            return FSRoute::_($url);
        }

        return FSRoute::_($_SERVER['REQUEST_URI']);
    }

    function removeParameters($params)
    {
        // only filter
        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $ccode = FSInput::get('ccode');
        $filter = FSInput::get('filter');
        $manu = FSInput::get('manu');
        $Itemid = FSInput::get('Itemid');

        $url = 'index.php?module=' . $module . '&view=' . $view;
        if ($ccode) {
            $url .= '&ccode=' . $ccode;
        }
        if ($manu) {
            $url .= '&manu=' . $manu;
        }
        if ($filter) {
            $url .= '&filter=' . $filter;
        }
        $url .= '&Itemid=' . $Itemid;
        $url = trim(preg_replace('/&' . $params . '=[0-9a-zA-Z_-]+/i', '', $url));
    }

    static function enURL($url)
    {
        if (!$url)
            $url = $_SERVER['REQUEST_URI'];
        if (!IS_REWRITE)
            return URL_ROOT . $url;
        if (strpos($url, 'http://') !== false || strpos($url, 'https://') !== false)
            return $url;
        $url_reduced = substr($url, 10); // width : index.php
        $array_buffer = explode('&', $url_reduced, 10);
        $array_params = array();
        for ($i = 0; $i < count($array_buffer); $i++) {
            $item = $array_buffer[$i];
            $pos_sepa = strpos($item, '=');
            $array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
        }

        $module = isset($array_params['module']) ? $array_params['module'] : '';
        $view = isset($array_params['view']) ? $array_params['view'] : $module;
        $task = isset($array_params['task']) ? $array_params['task'] : 'display';
        $Itemid = isset($array_params['Itemid']) ? $array_params['Itemid'] : 0;

        $languge = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        $url_first = URL_ROOT;
        $url1 = '';
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'en';
        switch ($module) {

            case 'members':
                switch ($view) {
                    case 'log': {
                            switch ($task) {
                                case 'logout':
                                    return $url_first . FSRoute::get_name_encode('dang-xuat', $lang);
                            }
                        }
                    case 'members': {
                        }
                    case 'facebook':
                        switch ($task) {
                            case 'callback':
                                return $url_first . FSRoute::get_name_encode('fb-oauth-callback', $lang);
                            default:
                                return $url_first . FSRoute::get_name_encode('sign-in-with-facebook', $lang);
                        }
                    case 'google':
                        return $url_first . FSRoute::get_name_encode('sign-in-with-google', $lang);
                    case 'orders':
                        switch ($task) {
                            case 'detail':
                                $id = isset($array_params['id']) ? $array_params['id'] : '';
                                return $url_first . FSRoute::get_name_encode('chi-tiet-don-hang', $lang) . '-' . $id;
                            default:
                                return $url_first . FSRoute::get_name_encode('don-hang-cua-toi', $lang);
                        }
                    case 'user':
                        switch ($task) {
                            case 'login':
                                return $url_first . FSRoute::get_name_encode('dang-nhap', $lang);
                            case 'register':
                                return $url_first . FSRoute::get_name_encode('dang-ky-tai-khoan', $lang);
                            default:
                                return $url_first . FSRoute::get_name_encode('don-hang-cua-toi', $lang);
                        }
                    case 'level':
                        return $url_first . FSRoute::get_name_encode('hang-thanh-vien', $lang);
                    case 'address':
                        return URL_ROOT . FSRoute::get_name_encode('so-dia-chi', $lang);
                    case 'favorite':
                        return URL_ROOT . FSRoute::get_name_encode('san-pham-yeu-thich', $lang);
                    case 'introduce':
                        return URL_ROOT . FSRoute::get_name_encode('danh-sach-thanh-vien-gioi-thieu', $lang);
                    case 'dashboard':
                        return URL_ROOT . FSRoute::get_name_encode('tai-khoan-ca-nhan', $lang);
                    default:
                        return URL_ROOT . $url;
                }
                break;

            case 'products':
                switch ($view) {
                    case 'promotion':
                        return $url_first . "gia-tot-hom-nay";
                    case 'product':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $code . '-p' . $id . '.html';
                    case 'cat':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $code . '-pc' . $id . '.html';
                    case 'search':
                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = URL_ROOT . 'tim-kiem';
                        if ($keyword) {
                            $url .= '/' . $keyword;
                        }
                        return $url;
                    case 'cart':
                        switch ($task) {
                            case 'saveCart':
                                return $url_first . 'luu-gio-hang';
                            case 'orderSuccess':
                                return $url_first . 'dat-hang-thanh-cong';
                            default:
                                return $url_first . 'gio-hang';
                        }
                    default:
                        return $url_first . $url;
                }
                break;
            case 'news':
                switch ($view) {
                    case 'amp_news':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $ccode . '/amp/' . $code . '-n' . $id;
                    case 'news':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                    case 'tags':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . $ccode;
                    case 'home':
                        return $url_first . 'blogs/all';
                    case 'search':

                        $keyword = isset($array_params['keyword']) ? $array_params['keyword'] : '';
                        $url = URL_ROOT . 'tim-kiem-tin-tuc';
                        if ($keyword) {
                            $url .= '-' . $keyword;
                        }
                        return $url;
                    default:
                        return $url_first . $url;
                }
                break;
            case 'contents':
                switch ($view) {
                    case 'cat':
                        $ccode = isset($array_params['ccode']) ? $array_params['ccode'] : '';
                        return $url_first . 'danh-muc/' . $ccode . '.html';
                    case 'content':
                        $code = isset($array_params['code']) ? $array_params['code'] : '';
                        $id = isset($array_params['id']) ? $array_params['id'] : '';
                        return $url_first . $code . '-n' . $id . '.html';
                }
                break;


            case 'sitemap':
                return $url_first . 'site-map.html';
            default:
                return URL_ROOT . $url;
        }
    }

    /*
     * get real url from virtual url
     */
    function deURL($url)
    {
        if (!IS_REWRITE)
            return $url;
        return $url;
        if (strpos($url, URL_ROOT_REDUCE) !== false) {
            $url = substr($url, strlen(URL_ROOT_REDUCE));
        }
        if ($url == 'news.html')
            return 'index.php?module=news&view=home&Itemid=1';
        if (strpos($url, 'news-page') !== false) {
            $f = strpos($url, 'news-page') + 9;
            $l = strpos($url, '.html');
            $page = intval(substr($url, $f, ($l - $f)));
            return "index.php?module=news&view=home&page=$page&Itemid=1";
        }
        $array_url = explode('/', $url);
        $module = isset($array_url[0]) ? $array_url[0] : '';
        switch ($module) {
            case 'news':
                // if cat
                if (preg_match('#news/([^/]*)-c([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $url, $arr)) {
                    return "index.php?module=news&view=cat&id=" . @$arr[2] . "&Itemid=" . @$arr[3] . '&page=' . @$arr[5];
                }
                // if article
                if (preg_match('#news/detail/([^/]*)-i([0-9]*)-it([0-9]*).html#s', $url, $arr)) {
                    return "index.php?module=news&view=news&id=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            case 'companies':
                $str_continue = ($module = isset($array_url[1])) ? $array_url[1] : '';
                if ($str_continue == 'register.html')
                    return "index.php?module=companies&view=company&task=register&Itemid=5";
                if (preg_match('#category-id([0-9]*)-city([0-9]*)-it([0-9]*)(-page([0-9]*))?.html#s', $str_continue, $arr)) {
                    if (isset($arr[5]))
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3] . "&page=" . @$arr[5];
                    else
                        return "index.php?module=companies&view=category&id=" . @$arr[1] . "&city=" . @$arr[2] . "&Itemid=" . @$arr[3];
                }
            default:
                return $url;
        }
    }

    function get_home_link()
    {
        $lang = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
        if ($lang == 'vi') {
            return URL_ROOT;
        } else {
            return URL_ROOT . 'en';
        }
    }

    /*
     * Dịch ngang
     */
    function change_link_by_lang($lang, $link = '')
    {
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        if (!$module || ($module == 'home' && $view == 'home')) {
            if ($lang == 'en') {
                //				return URL_ROOT;
            } else {
                return URL_ROOT . 'vi';
            }
        }
        switch ($module) {

            case 'contents':
                switch ($view) {
                    case 'contents':
                        $code = FSInput::get('code');
                        $record = FSRoute::trans_record_by_field($code, 'alias', 'fs_contents', $lang, 'id,alias,category_alias');
                        if (!$record)
                            return;
                        $url = URL_ROOT . FSRoute::get_name_encode('c', $lang) . '-' . $record->alias;
                        return $url . '.html';
                        return $url;
                }
                break;
            default:
                $url = URL_ROOT . 'ce-about-digiworld';
                return $url . '.html';
        }
    }

    function get_record_by_id($id, $table_name, $lang, $select)
    {
        if (!$id)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name = $fs_table->getTable($table_name);

        $query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /*
     * Lấy bản ghi dịch ngôn ngữ
     */
    function trans_record_by_field($value, $field = 'alias', $table_name, $lang, $select = '*')
    {
        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE " . $field . " = '" . $value . "' ";

        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $select . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getObject();
        return $rs;
    }

    /*
     * Dịch từ field -> field ( tìm lại id rồi dịch ngược)
     */
    function translate_field($value, $table_name, $field = 'alias')
    {

        if (!$value)
            return;
        if (!$table_name)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $table_name_old = $fs_table->getTable($table_name);

        $query = " SELECT id
					  FROM " . $table_name_old . "
					  WHERE $field = '" . $value . "' ";
        global $db;
        $sql = $db->query($query);
        $id = $db->getResult();
        if (!$id)
            return;
        $query = " SELECT " . $field . "
					  FROM " . $fs_table->translate_table($table_name) . "
					  WHERE id = '" . $id . "' ";
        global $db;
        $sql = $db->query($query);
        $rs = $db->getResult();
        return $rs;
    }
}
