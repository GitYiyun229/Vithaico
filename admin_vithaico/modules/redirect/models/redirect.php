<?php

class RedirectModelsRedirect extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->limit = 30;
        $this->view = 'redirect';

        //$this -> table_types = 'fs_news_types';
        $this->arr_img_paths = array(
            array('large', 520, 290, 'resize_image_fix_height_webp'),
            array('resize', 250, 140, 'resize_image_fix_height_webp'),
            array('small', 120, 68, 'resize_image_fix_height_webp')
        );
        // $this->table_category_name = FSTable_ad::_('fs_news_categories', 1);
        $this->table_name = FSTable_ad::_('fs_redirect', 1);
        // $this->table_link = 'fs_menus_createlink';
        // $this->table_tags = FSTable_ad::_('fs_news_tags', 1);
        $limit_created_link = 30;
        $this->limit_created_link = $limit_created_link;
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        //$cday = date('d');
        $this->img_folder = 'images/redirect/' . $cyear . '/' . $cmonth;
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

        // to
        if (isset($_SESSION[$this->prefix . 'text1'])) {
            $date_to = $_SESSION[$this->prefix . 'text1'];
            if ($date_to) {
                $date_to = $date_to . ' 23:59:59';
                $date_to = strtotime($date_to);
                $date_new = date('Y-m-d H:i:s', $date_to);
                $where .= ' AND a.created_time <=  "' . $date_new . '" ';
            }
        }

        // estore
        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter) {
                $where .= ' AND a.category_id_wrapper like  "%,' . $filter . ',%" ';
            }
        }

        if (!$ordering)
            $ordering .= " ORDER BY id DESC ";

        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.alias LIKE '%" . $keysearch . "%' OR a.old_alias LIKE '%" . $keysearch . "%' ";
            }
        }

        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1 " .
            $where .
            $ordering . " ";
        return $query;
    }

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {
        $row = [];
        $alias = str_replace("$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/",'',FSInput::get('alias'));
        $old_alias = str_replace("$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/",'',FSInput::get('old_alias'));
        $id = FSInput::get('id');
        global $db;

        if($id){
            $record_id = FSInput::get('record_id');
            $module = FSInput::get('module_record');
            $view = FSInput::get('view_record');
            
            if (!$record_id) {
                Errors::_('Lỗi', 'alert');
                return false;
            }

            $fsstring = FSFactory::getClass('FSString', '', '../');
            $check_alias = $this->check_exist_alias_redirect($id, $alias);
            if ($check_alias) {
                Errors::_('Alias của bạn đã bị trùng tên', 'alert');
                return false;
            }
    
            $query = "UPDATE fs_redirect 
                      SET alias = '$alias', old_alias = '$old_alias'
                      WHERE record_id = $record_id AND `module` = '$module' AND `view` = '$view'
            ";
            $db->affected_rows($query);
     
            $this->update_record_module($alias,$old_alias,$record_id,$module,$view);

        } else{
           // $record_old = $this->get_record('alias = "'.$old_alias.'" ','fs_redirect');
           $record_new = $this->get_record('alias = "'.$alias.'" ','fs_redirect');
           // if(!$record_old){
           //     Errors::_('Link cũ không tồn tại', 'alert');
           //     return false;
           // }

           if(!$record_new){
               Errors::_('Link mới không tồn tại', 'alert');
               return false;
           }

           // $query = "  UPDATE fs_redirect 
           //             SET alias = '$record_new->alias', old_alias = '$record_old->alias', record_id = '$record_new->record_id'
           //             WHERE id = $record_old->id
           // ";
           // $db->affected_rows($query);
           // $id = $record_old->id;

           $row_redirect = [
               'record_id' => $record_new->record_id,
               'alias' => $record_new->alias,
               'module' => $record_new->module,
               'view' => $record_new->view,
               'task' => $record_new->task,
               'old_alias' => $old_alias
           ];

           $id = $this->_add($row_redirect, 'fs_redirect');
        }
        return $id;
    }

    function update_record_module($alias,$old_alias,$record_id,$module,$view){
        global $db;
        $table = '';
        if(!$module && $view)
            return false;

        switch ($module){
            case 'products': 
                switch ($view){
                    case 'cat':
                        $table = 'fs_products_categories';
                    break;
                    case 'product':
                        $table = 'fs_products';
                    break;
                }
                break;
            case 'news':
                switch ($view){
                    case 'cat':
                        $table = 'fs_news_categories';
                    break;
                    case 'news':
                        $table = 'fs_news';
                    break;
                    case 'tags':
                        $table = 'fs_news_tags';
                    break;
                }
            break;
            case 'contents':
                switch ($view){
                    case 'cat':
                        $table = 'fs_contents_categories';
                        break;
                    case 'contents':
                        $table = 'fs_contents';
                        break;
                }
            break;
        }

        $query = "UPDATE $table
                  SET alias = '$alias'
                  WHERE id = $record_id
        ";
        $rs = $db->affected_rows($query);
       
        return $rs;
    }

    function check_exist_alias_redirect($id, $alias)
    {
        global $db;
        $where = '';
        if ($id)
            $where .= " and record_id <> $id ";
        $sql = "SELECT * FROM fs_redirect WHERE alias = '$alias' $where ";
        $db->query($sql);
        return $db->getObject();
    }

    function save_redirect($id, $rs, $alias)
    {
        global $db;
        if ($id) {
            $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'news', `view` = 'news' WHERE record_id = $id AND `module` = 'news' AND `view` = 'news'";
            $db->affected_rows($query);
        } else {
            $query = "INSERT INTO fs_redirect (record_id,alias,`module`,`view`) 
                      VALUE ($rs,'$alias','news','news')";
            $db->insert($query);
        }
        return true;
    }

    // function remove()
    // {
    //     $id = FSInput::get('id', array(), 'array');

    //     foreach ($id as $item) {
    //         $this->_remove('record_id  = ' . $item . ' and `module` = "news" and `view` = "news" ', 'fs_redirect');
    //     }
    //     $rs = parent::remove();
    //     return $rs;
    // }
}
