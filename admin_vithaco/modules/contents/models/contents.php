<?php

class ContentsModelsContents extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $limit = FSInput::get('limit', 20, 'int');
        $this->limit = $limit;
        $this->view = 'contents';

        $this->table_category_name = FSTable_ad::_('fs_contents_categories');
        $this->arr_img_paths = array(
            array('resized', 467, 547, 'resize_image'),
//                                            array('small',282,170,'cut_image')
        );
        $this->table_name = FSTable_ad::_('fs_contents');

        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $this->img_folder = 'images/contents/' . $cyear . '/' . $cmonth . '/' . $cday;
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

        // filter category
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

    function save($row = array(), $use_mysql_real_escape_string = 1)
    {
        $title = FSInput::get('title');
        $show_in_homepage = FSInput::get('show_in_homepage');
        if (!$title)
            return false;
        $id = FSInput::get('id', 0, 'int');
        $category_id = FSInput::get('category_id', 'int', 0);
        if (!$category_id) {
            Errors::_('Bạn phải chọn danh mục');
            return;
        }

        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if (!$user_id)
            return false;

        $user = $this->get_record_by_id($user_id, 'fs_users', 'username');
        if ($id) {
            $row['author_last'] = $user->username;
        } else {
            $row['author'] = $user->username;
        }

        $cat = $this->get_record_by_id($category_id, 'fs_contents_categories');
        $row['category_id_wrapper'] = $cat->list_parents;
        $row['category_alias_wrapper'] = $cat->alias_wrapper;
        $row['category_name'] = $cat->name;
        $row['category_alias'] = $cat->alias;
        $row['category_published'] = $cat->published;

        $row['content'] = htmlspecialchars_decode(FSInput::get('content'));
        //if(isset($show_in_homepage ) && $show_in_homepage != 0)
//			{
//					$rs = $this -> _update_column('fs_contents', 'show_in_homepage','0');
//			}
        //lấy alias
        $fsstring = FSFactory::getClass('FSString', '', '../');
        $alias = $fsstring->stringStandart($title);
        $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;
        $check_alias = $this->check_exist_alias_redirect($id, $alias);

        if ($check_alias) {
            Errors::_('Alias của bạn đã bị trùng tên', 'alert');
            $row['alias'] = $this->genarate_alias_news($row['alias'], $id);
        }
//			return parent::save($row);
        $id = parent::save($row, 1);

        $this->save_redirect($id, $row['alias']);
        return $id;
    }

    /*
     * select in category of home
     */
    function get_categories_tree()
    {
        global $db;
        $query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a
						  	ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }

    /*
     * Save all record for list form
     */
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
                        $cat = $this->get_record_by_id($field_value_new, 'fs_contents_categories');
                        $row['category_id_wrapper'] = $cat->list_parents;
                        $row['category_alias_wrapper'] = $cat->alias_wrapper;
                        $row['category_name'] = $cat->name;
                        $row['category_alias'] = $cat->alias;
                        $row['category_published'] = $cat->published;
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

    function save_redirect($id, $alias)
    {
        global $db;
        $id_redirect = $this->get_record('record_id = ' . $id . ' AND module = "contents" AND view = "contents"', 'fs_redirect');
        if ($id_redirect) {
            $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'contents', `view` = 'contents' WHERE record_id = $id AND `module` = 'contents' AND `view` = 'contents'";
            $db->affected_rows($query);
        } else {
            $query = "INSERT INTO fs_redirect (record_id,alias,`module`,`view`) 
                      VALUE ($id,'$alias','contents','contents')";
            $db->insert($query);
        }
        return true;
    }

    function remove()
    {
        $id = FSInput::get('id', array(), 'array');

        // foreach ($id as $item) {
        //     $this->_remove('record_id  = ' . $item . ' and `module` = "contents" and `view` = "contents" ', 'fs_redirect');
        // }
        $rs = parent::remove();
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
}

?>