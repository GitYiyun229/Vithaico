<?php

class StoreModelsLocation extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->limit = 30;
        $this->view = 'location';

        //$this -> table_types = 'fs_news_types';
        $this->arr_img_paths = array(
            array('large', 520, 290, 'resize_image_fix_height'),
            array('resize', 250, 140, 'resize_image_fix_height'),
            array('small', 120, 68, 'resize_image_fix_height')
        );
        $this->table_category_name = FSTable_ad::_('fs_address', 1);
        $this->table_name = FSTable_ad::_('fs_store_location', 1);
        $this->table_link = 'fs_menus_createlink';
        $this->table_tags = FSTable_ad::_('fs_news_tags', 1);
        $limit_created_link = 30;
        $this->limit_created_link = $limit_created_link;
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        //$cday = date('d');
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
                $where .= ' AND a.area_id = '.$filter.' ';
            }
        }

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.area_name LIKE '%" . $keysearch . "%' ";
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
        $title = FSInput::get('name');
        if (!$title)
            return false;
        $id = FSInput::get('id', 0, 'int');
//        $category_id = FSInput::get('category_id', 0, 'int');
//        if (!$category_id) {
//            Errors::_('Bạn phải chọn danh mục');
//            return;
//        }
//
//        $cat = $this->get_record_by_id($category_id, $this->table_category_name);
//        $row['category_id_wrapper'] = $cat->list_parents;
//        $row['category_alias_wrapper'] = $cat->alias_wrapper;
//        $row['category_name'] = $cat->name;
//        $row['category_alias'] = $cat->alias;


        //       $image_name_icon = $_FILES["icon"]["name"];
        // if($image_name_icon){
        // 	$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
        // 	if($image_icon){
        // 		$row['icon'] = $image_icon;
        // 	}
        // }

         //related news
//         $record_relate = FSInput::get('news_record_related',array(),'array');
//         $row['news_related'] ='';
//         if(count($record_relate)){
//         	$record_relate = array_unique($record_relate);
//         	$row['news_related'] = ','.implode(',', $record_relate).',';
//         }

//        $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
        $area = $this->get_record_by_id(FSInput::get('area_id'), 'fs_address');
        $row['area_name'] = $area->name;
        $time = date('Y-m-d H:i:s');
        $row['published'] = FSInput::get('published');
//        $row['end_time'] = date('Y-m-d H:i:s',strtotime(FSInput::get('end_time')));
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

//        $tags = FSInput::get('tags', '', 'array');
//        $list_tags_id = implode(',', $tags);
//        $list_tags_id = ','.$list_tags_id.',';
//        $row['tags'] = $list_tags_id;

//        $fsstring = FSFactory::getClass('FSString', '', '../');
//        $alias = $fsstring->stringStandart($title);
//        $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;

//        $check_alias = $this->check_exist_alias_redirect($id,$alias);
//        if($check_alias){
//            Errors::_('Alias của bạn đã bị trùng tên','alert');
//            $row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
//        }

        $rs = parent::save($row);

//        $this->save_redirect($id,$rs,$row['alias']);

        return $rs;
    }

    function check_exist_alias_redirect($id,$alias){
        global $db;
        $where = '';
        if($id)
            $where .= " and record_id <> $id ";
        $sql = "SELECT * FROM fs_redirect WHERE alias = '$alias' $where ";
        $db->query($sql);
        return $db->getObject();
    }

    function save_redirect($id,$rs,$alias){
        global $db;
        if($id){
            $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'news', `view` = 'news' WHERE record_id = $id AND `module` = 'news' AND `view` = 'news'";
            $db->affected_rows($query);
        }else{
            $query = "INSERT INTO fs_redirect (record_id,alias,`module`,`view`) 
                      VALUE ($rs,'$alias','news','news')";
            $db->insert($query);
        }
        return true;
    }

    function save_all()
    {
        $total = FSInput::get('total', 0, 'int');
        if (!$total)
            return true;
        $field_change = FSInput::get('field_change');
        if (!$field_change)
            return false;
        $field_change_arr = explode(',', $field_change);
        $total_field_change = count($field_change_arr);
        $record_change_success = 0;
        for ($i = 0; $i < $total; $i++) {
//	        	$str_update = '';
            $row = array();
            $update = 0;
            foreach ($field_change_arr as $field_item) {
                $field_value_original = FSInput::get($field_item . '_' . $i . '_original');
                $field_value_new = FSInput::get($field_item . '_' . $i);
                if (is_array($field_value_new)) {
                    $field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) . ',' : '';
                }

                if ($field_value_original != $field_value_new) {
                    $update = 1;
                    // category
                    if ($field_item == 'category_id') {
                        $cat = $this->get_record_by_id($field_value_new, $this->table_category_name);
                        $row['category_id_wrapper'] = $cat->list_parents;
                        $row['category_alias_wrapper'] = $cat->alias_wrapper;
                        $row['category_name'] = $cat->name;
                        $row['category_alias'] = $cat->alias;
                        $row['category_id'] = $field_value_new;
                    } else {
                        $row[$field_item] = $field_value_new;
                    }
                }
            }
            if ($update) {
                $id = FSInput::get('id_' . $i, 0, 'int');
                $str_update = '';
                global $db;
                $j = 0;
                foreach ($row as $key => $value) {
                    if ($j > 0)
                        $str_update .= ',';
                    $str_update .= "`" . $key . "` = '" . $value . "'";
                    $j++;
                }

                $sql = ' UPDATE  ' . $this->table_name . ' SET ';
                $sql .= $str_update;
                $sql .= ' WHERE id =    ' . $id . ' ';
                $db->query($sql);
                $rows = $db->affected_rows();
                if (!$rows)
                    return false;
                $record_change_success++;
            }
        }
        return $record_change_success;


    }

    function remove(){
        $id = FSInput::get('id',array(),'array');

        foreach ($id as $item){
            $this -> _remove('record_id  = '.$item .' and `module` = "news" and `view` = "news" ','fs_redirect');
        }
        $rs = parent::remove();
        return $rs;
    }

    function fs_cities(){
        global $db;
        $query = " SELECT a.*
						  FROM fs_cities
						  	WHERE published = 1 ORDER BY ordering asc ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }

    function get_news_categories_tree_by_permission()
    {
//        $permission_cities = $this -> get_result('id='.$_SESSION['ad_userid'],'fs_users','address');
//        $where = '  ';
//        if($permission_cities == 'none'){
//            $where .= ' AND 1 = 0';
//        }elseif($permission_cities && $permission_cities != 'all'){
//            $where .= ' AND id IN (0'.$permission_cities.'0)';
//        }
        global $db;
        $query = ' SELECT *
	                   FROM fs_address WHERE 1 = 1 '.$where.'
                       ORDER BY ordering ';
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree  = FSFactory::getClass('tree','tree/');
        $list = $tree -> indentRows2($result);
        return $list;
    }

    function get_categories_tree()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
}

?>