<?php

class CouponModelsCoupon extends FSModels {

    var $limit;
    var $prefix;

    function __construct() {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $this->limit = 30;
        $this->view = 'coupon';

        //$this -> table_types = 'fs_news_types';
        $this->arr_img_paths = array(
            array('resized', 260, 175, 'cut_image'),
            array('small', 90, 60, 'cut_image')
        );
        $this->table_category_name = FSTable_ad::_('fs_coupon_categories');
        $this->table_name = FSTable_ad::_('fs_coupon');
        $this->table_word = 'fs_coupon_code';
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        //$cday = date('d');
        $this->img_folder = 'images/coupon/' . $cyear . '/' . $cmonth;
        $this->check_alias = 0;
        $this->field_img = 'image';

        parent::__construct();
    }

    function setQuery() {

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
            $ordering .= " ORDER BY created_time DESC , id DESC ";


        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND a.title LIKE '%" . $keysearch . "%' ";
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

    function save($row = array(), $use_mysql_real_escape_string = 1) {
        $title = FSInput::get('title');
        if (!$title)
            return false;
        $id = FSInput::get('id', 0, 'int');
        $category_id = FSInput::get('category_id', 0, 'int');
        if (!$category_id) {
            Errors::_('Bạn phải chọn danh mục');
            return;
        }

        $cat = $this->get_record_by_id($category_id, $this->table_category_name);
        $row['category_id_wrapper'] = $cat->list_parents;
        $row['category_alias_wrapper'] = $cat->alias_wrapper;
        $row['category_name'] = $cat->name;
        $row['category_alias'] = $cat->alias;

        $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
        $time = date('Y-m-d H:i:s');
        $row['published'] = 1;

        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if (!$user_id)
            return false;

        $user = $this->get_record_by_id($user_id, 'fs_users', 'username');
        if ($id) {
            $row['updated_time'] = $time;
            $row['end_time'] = $time;
            $row['author_last'] = $user->username;
            $row['author_last_id'] = $user_id;
        } else {
            $row['created_time'] = $time;
            $row['updated_time'] = $time;
            $row['end_time'] = $time;
            $row['start_time'] = $time;
            $row['author'] = $user->username;
            $row['author_id'] = $user_id;
        }

        $fsstring = FSFactory::getClass('FSString', '', '../');
        $alias = $fsstring->stringStandart($title);
        $rs = parent::save($row);
        
        // code word
        if (!$this->remove_word($rs)) {
            
        }
        if (!$this->save_exist_word($rs)) {
            
        }
        if (!$this->save_new_word($rs)) {
            
        }

        return $rs;
    }


    /*
     * select in category of home
     */

    function get_categories_tree() {
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

    /*
     * Save all record for list form
     */

    function save_all() {
        $total = FSInput::get('total', 0, 'int');
        if (!$total)
            return true;
        $field_change = FSInput::get('field_change');
        if (!$field_change)
            return false;
        $field_change_arr = explode(',', $field_change);
        $total_field_change = count($field_change_arr);
        $record_change_success = 0;
        for ($i = 0; $i < $total; $i ++) {
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
                $record_change_success ++;
            }
        }
        return $record_change_success;
    }
    
    
    function remove_word($record_id) {
        if (!$record_id)
            return true;
        $other_word_remove = FSInput::get('other_word', array(), 'array');
        $str_other_word = implode(',', $other_word_remove);
        if ($str_other_word) {
            global $db;
            // remove in database
            $sql = " DELETE FROM " . $this->table_word . "
							WHERE document_id = $record_id AND id IN ($str_other_word)";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        return true;
    }

    function save_exist_word($id) {
        $document = $this->get_record_by_id($id, '' . $this->table_name . '');
        global $db;
        // EXIST FIELD
        $exist_total = FSInput::get('exist_total');

        $sql_alter = "";
        $arr_sql_alter = array();
        $rs = 0;

        for ($i = 0; $i < $exist_total; $i ++) {

            $id_exist = FSInput::get('id_exist_' . $i);

            $name_exist = FSInput::get('name_exist_' . $i);
            $name_exist_begin = FSInput::get('name_exist_' . $i . "_original");

            $word_exist = FSInput::get('word_exist_' . $i); 
            $word_exist_begin = FSInput::get('word_exist_' . $i . "_begin");
            
            $link_exist = FSInput::get('nm_link_exist_' . $i); 
            $link_exist_begin = FSInput::get('nm_link_exist_' . $i . "_begin");
            
            $time_exist = FSInput::get('created_time_exis_' . $i);
            $time_exist_begin = FSInput::get('created_time_exis_' . $i . "_begin");

            if (($name_exist != $name_exist_begin) || ($word_exist != $word_exist_begin) || ($link_exist != $link_exist_begin) || ($time_exist != $time_exist_begin)) {

                $name = FSInput::get('name_exist_' . $i);

                $file_upload = FSInput::get('word_exist_' . $i);
                if ($file_upload) {
                    $content = $file_upload;
                }else {
                    $content = $word_exist_begin;
                }

                $row = array();
                $row ['name'] = $name;
                $row ['content'] = $content;
                $row ['link'] = $link_exist;
                $row ['published_time'] = $time_exist;

                if (!$row ['name'] && !$row ['content']) {
                    continue;
                }
                $row ['document_name'] = $document->title;

                $u = $this->_update($row, '' . $this->table_word . '', ' id=' . $id_exist);
                if ($u)
                    $rs ++;
            }
        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_word($record_id) {
        $document = $this->get_record_by_id($record_id, '' . $this->table_name . '');
        global $db;
        for ($i = 0; $i < 50; $i ++) {
            $row = array();
            
            
            $name = FSInput::get("new_name_" . $i);
            $price = FSInput::get("new_file_word_" . $i);
            $link = FSInput::get("new_link_" . $i);
            $time = FSInput::get("created_time_" . $i);
            $row ['content'] = $price;
            $row ['link'] = $link;
            $row ['name'] = $name;

            if (!$row ['name'] && !$row ['content']) {
                continue;
            }

            $row ['document_id'] = $record_id;
            $row ['document_name'] = $document->title;
            $row ['published'] = 1;
//            $time = date('Y-m-d H:i:s');
            $row['published_time'] = $time;
            $rs = $this->_add($row, '' . $this->table_word . '', 1);
        }
        return true;
    }
    
    
    function get_document_word($document_id) {
        global $db;
        $query = " SELECT *
						  FROM 
						  	" . $this->table_word . "
						  	WHERE document_id = $document_id
						  	ORDER BY id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

 
}

?>