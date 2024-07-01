<?php

class TiktokModelsTiktok extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
 
        $this->limit = 30;
        $this->view = 'tiktok';

        //$this -> table_types = 'fs_news_types';
        $this->arr_img_paths = array(
            array('large', 520, 290, 'resize_image_fix_height_webp'),
            array('resize', 250, 140, 'resize_image_fix_height_webp'),
            array('small', 120, 68, 'resize_image_fix_height_webp')
        );
        $this->table_category_name = FSTable_ad::_('fs_news_categories', 1);
        $this->table_name = FSTable_ad::_('fs_tiktok', 1);
        $this->table_link = 'fs_menus_createlink';
        $this->table_tags = FSTable_ad::_('fs_news_tags', 1);
        $limit_created_link = 30;
        $this->limit_created_link = $limit_created_link;
        // config for save
        $cyear = date('Y');
        $cmonth = date('m'); 
        $this->img_folder = 'images/news/' . $cyear . '/' . $cmonth;
        $this->check_alias = 0;
        $this->field_img = 'image';

        parent::__construct();
    }

    function setQuery()
    {

        // ordering
        $ordering = "";
        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
        }

        // from
        if (isset($_SESSION[$this->prefix . 'text0'])) {
            $date_from = $_SESSION[$this->prefix . 'text0'];
            if ($date_from) {
                $date_from = strtotime($date_from);
                $date_new = date('Y-m-d H:i:s', $date_from);
                $where .= ' AND a.created_time >=  "' . $date_new . '" ';
            }
        }
 
        if (isset($_SESSION[$this->prefix . 'text1'])) {
            $date_to = $_SESSION[$this->prefix . 'text1'];
            if ($date_to) {
                $date_to = $date_to . ' 23:59:59';
                $date_to = strtotime($date_to);
                $date_new = date('Y-m-d H:i:s', $date_to);
                $where .= ' AND a.created_time <=  "' . $date_new . '" ';
            }
        }
 

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.title LIKE '%" . $keysearch . "%' ";
            }
        }
        $query = " SELECT *
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
            $where .
            $ordering . " ";
        return $query;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {
        $title = FSInput::get('title');
        if (!$title)
            return false;
        $id = FSInput::get('id', 0, 'int'); 
        $row['tiktok'] = FSInput::get('tiktok');
 
        $time = date('Y-m-d H:i:s'); 
        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if (!$user_id)
            return false;

        $user = $this->get_record_by_id($user_id, 'fs_users', 'username');
        if ($id) {
            $row['updated_time'] = $time; 
            $row['author_last'] = $user->username;
            $row['author_last_id'] = $user_id;
        } else {
            $row['created_time'] = $time;
            $row['updated_time'] = $time; 
            $row['author'] = $user->username;
            $row['author_id'] = $user_id;
        } 
        $rs = parent::save($row); 

        return $rs;
    } 
}
