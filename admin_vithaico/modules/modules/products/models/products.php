<?php

class ProductsModelsProducts extends FSModels
{
    var $limit;
    var $prefix;
    var $image_watermark;

    function __construct()
    {
        $limit = FSInput::get('limit', 20, 'int');
        $this->limit = $limit;
        $this->view = 'products';
        $this->type = 'products';
        $this->table_name = FSTable_ad::_('fs_products');
        $this->use_table_extend = 1;
        $this->table_category = FSTable_ad::_('fs_' . $this->type . '_categories');
        $this->table_types = FSTable_ad::_('fs_' . $this->type . '_types');

        //synchronize
        //			$this -> array_synchronize = array('fs_estores_products'=>array('id'=>'product_id','published'=>'record_published','alias'=>'product_alias','name'=>'product_name','category_name'=>'category_name','category_alias'=>'category_alias','category_alias_wrapper'=>'category_id_wrapper','category_id'=>'category_id','manufactory_country_id'=>'manufactory_country_id','manufactory_country_name'=>'manufactory_country_name','manufactory_country_flag'=>'manufactory_country_flag','manufactory_id'=>'manufactory_id','manufactory_alias'=>'manufactory_alias','manufactory_name'=>'manufactory_name'));
        // calculate filters:
        // $this->calculate_filters = 1;
        // config for save
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $this->img_folder = 'images/' . $this->type . '/' . $cyear . '/' . $cmonth . '/' . $cday;
        $this->check_alias = 1;
        $this->field_img = 'image';
        $this->field_reset_when_duplicate = array('comments_total');
        $this->arr_img_paths_og = array('large', 800, 600, 'resize_image_fix_height_webp');
        $this->arr_img_paths_spec = array(array('large', 800, 600, 'resize_image_fix_height_webp'), array('resized', 150, 112, 'resize_image_fix_height_webp'));
        $this->arr_img_paths_unbox = array(array('large', 800, 600, 'resize_image_fix_height_webp'), array('resized', 150, 112, 'resize_image_fix_height_webp'));
//        $this->arr_img_paths_unbox = array('resized', 150, 112, 'resize_image_fix_height_webp');
        $this->arr_img_paths_sub = array(array('large', 400, 400, 'resize_image_fix_height_webp'), array('resized', 210, 210, 'resize_image_fix_height_webp'), array('small', 60, 60, 'resize_image_fix_height_webp'));
        $this->arr_img_paths_other = array(array('large', 400, 400, 'resize_image_fix_height_webp'), array('resized', 210, 210, 'resize_image_fix_height_webp'), array('small', 60, 60, 'resize_image_fix_height_webp'));
        $this->arr_img_paths_landing = array(
            array('resize', 590, 330, 'resize_image_fix_height_webp'),
            array('small', 60, 60, 'resize_image_fix_height_webp')
        );
        parent::__construct();

        $this->load_params();
    }

    function load_params()
    {
        $module_params = $this->get_params($this->module, 'product');

        if ($module_params) { // params from fs_config_modules
            $this->module_params = $module_params;
            $arr_img_paths = array();
//            $arr_img_paths_other = array();

            FSFactory::include_class('parameters');
            $current_parameters = new Parameters ($module_params);
            // large size
            $image_large_size = $current_parameters->getParams('image_large_size');
            $image_large_method = $current_parameters->getParams('image_large_method');
            if (!$image_large_method)
                $image_large_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
            $image_large_width = $this->get_dimension($image_large_size, 'width');
            $image_large_height = $this->get_dimension($image_large_size, 'height');
            if (!$image_large_width && !$image_large_height) {
                $image_large_width = 374;
                $image_large_height = 380;
            }
            $arr_img_paths [] = array('large', $image_large_width, $image_large_height, $image_large_method);
//            $arr_img_paths_other [] = array('large', $image_large_width, $image_large_height, $image_large_method);

            // resized: ảnh đại diện trong trang danh sách
            $image_resized_size = $current_parameters->getParams('image_resized_size');
            $image_resized_method = $current_parameters->getParams('image_resized_method');
            if (!$image_resized_method)
                $image_resized_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng


            $image_resized_width = $this->get_dimension($image_resized_size, 'width');
            $image_resized_height = $this->get_dimension($image_resized_size, 'height');
            if (!$image_resized_width && !$image_resized_height) {
                $image_resized_width = 204;
                $image_resized_height = 190;
            }
            $arr_img_paths [] = array('resized', $image_resized_width, $image_resized_height, $image_resized_method);

            // small: ảnh nhỏ làm slideshow
            $image_small_size = $current_parameters->getParams('image_small_size');
            $image_small_method = $current_parameters->getParams('image_small_method');
            if (!$image_small_method)
                $image_small_method = 'resize_image'; // giữ nguyên dạng ảnh, thêm khoảng trắng
            $image_small_width = $this->get_dimension($image_small_size, 'width');
            $image_small_height = $this->get_dimension($image_small_size, 'height');
            if ($image_small_width || $image_small_height) {
                $arr_img_paths [] = array('small', $image_small_width, $image_small_height, $image_small_method);
//                $arr_img_paths_other [] = array('small', $image_small_width, $image_small_height, $image_small_method);
            }
            $this->arr_img_paths = $arr_img_paths;
//            $this->arr_img_paths_other = $arr_img_paths_other;

        } else {
            // default
            $this->arr_img_paths = array(array('large', 374, 380, 'resize_image'), array('resized', 204, 190, 'resize_image'), array('small', 47, 35, 'resize_image'));
//            $this->arr_img_paths_other = array(array('large', 374, 380, 'resize_image'), array('resized', 204, 190, 'resize_image'), array('small', 47, 35, 'resize_image'));
        }
    }


    /*
         * Trả lại kích thước chiều dài hoặc chiều rộng
         */
    function get_dimension($size, $dimension = 'width')
    {
        if (!$size)
            return 0;
        $array = explode('x', $size);
        if ($dimension == 'width') {
            return (intval(@$array [0]));
        } else {
            return (intval(@$array [1]));
        }
    }

    /*
         * Lấy parameter từ cấu hình vào.............................................................................
         */
    function get_params($module, $view, $task = '')
    {

        $where = '';
        $where .= 'module = "' . $module . '" AND view = "' . $view . '"';
        if ($task == 'display' || !$task) {
            $where .= ' AND ( task = "display" OR task = "" OR task IS NULL)';
        } else {
            $where .= ' AND task = "' . $task . '" ';
        }

        $fstable = FSFactory::getClass('fstable');
        global $db;
        $sql = " SELECT params  FROM " . $fstable->_('fs_config_modules') . "
				WHERE $where ";
        $db->query($sql);
        $rs = $db->getResult();
        return $rs;

        //			FSFactory::include_class('parameters');
        //			$config_name = 'products_';
        //			$data_params = $this -> get_records('');
        //			if($data -> task)
        //				$config_name  = '_'.$data -> task;
        //			$config = isset($config_module[$config_name])?$config_module[$config_name]:array()  ;
        //
        //			$current_parameters = new Parameters($data->params);
        //			$params = isset($config['params'])?$config['params']: null;
    }

    function setQuery()
    {

        // ordering
        $ordering = "";
        $where = "  ";
        if (isset ($_SESSION [$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION [$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION [$this->prefix . 'sort_direct'];
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
                $where .= ' AND a.edited_time >=  "' . $date_new . '" ';
            }
        }

        // to
        if (isset($_SESSION[$this->prefix . 'text1'])) {
            $date_to = $_SESSION[$this->prefix . 'text1'];
            if ($date_to) {
                $date_to = $date_to . ' 23:59:59';
                $date_to = strtotime($date_to);
                $date_new = date('Y-m-d H:i:s', $date_to);
                $where .= ' AND a.edited_time <=  "' . $date_new . '" ';
            }
        }
        if (isset ($_SESSION [$this->prefix . 'filter0'])) {
            $filter = $_SESSION [$this->prefix . 'filter0'];
            if ($filter) {
//                $where .= ' AND a.category_id_wrapper like   "%,' . $filter . ',%" ';
                $where .= ' AND (a.category_id_wrapper like  "%,' . $filter . ',%" or a.multi_categories like "%,' . $filter . ',%") ';
            }
        }

//        if (isset($_SESSION[$this->prefix . 'filter1'])) {
//            $filter = $_SESSION[$this->prefix . 'filter1'];
//            if ($filter == 2) {
//                $where .= ' AND a.published = 0 ';
//            } else if ($filter == 0) {
//                $where .= '';
//            } else {
//                $where .= ' AND a.published = ' . $filter . ' ';
//            }
//        }

        // Lọc brand
//        if (isset ($_SESSION [$this->prefix . 'filter2'])) {
//            $filter = $_SESSION [$this->prefix . 'filter2'];
//            if ($filter) {
//                $where .= ' AND a.trademark_id = ' . $filter . '';
//            }
//        }

        // Lọc status
        if (isset ($_SESSION [$this->prefix . 'filter1'])) {
            $filter = $_SESSION [$this->prefix . 'filter1'];
            if ($filter) {
                $where .= ' AND a.status_prd = ' . $filter . '';
            }
        }

        //merchant
        if (isset ($_SESSION [$this->prefix . 'filter2'])) {
            $filter2 = $_SESSION [$this->prefix . 'filter2'];
            if ($filter2) {
                $where .= ' AND a.gs = ' . $filter2 . '';
            }
        }

        if (!$ordering)
            $ordering .= " ORDER BY edited_time DESC , id DESC ";

        if (isset ($_SESSION [$this->prefix . 'keysearch'])) {
            if ($_SESSION [$this->prefix . 'keysearch']) {
                $keysearch = $_SESSION [$this->prefix . 'keysearch'];
                $where .= " AND ( a.name LIKE '%" . $keysearch . "%' OR a.alias LIKE '%" . $keysearch . "%' OR a.id = '" . $keysearch . "' OR a.code LIKE '%" . $keysearch . "%')";
            }
        }

        $query = " SELECT a.*
				  FROM 
				  	" . $this->table_name . " AS a
				  	WHERE 1=1 " . $where . $ordering . " ";
//        echo $query;
        return $query;
    }

    function get_data($str_cat_id)
    {
        global $db;
        $query = $this->setQuery($str_cat_id);
        if (!$query)
            return array();
        $sql = $db->query_limit($query, $this->limit, $this->page);
        echo $sql;
        $result = $db->getObjectList();

        return $result;
    }

    /*
         * select in category
         */
    function get_categories_tree()
    {
        global $db;
        $where = '';
        if (isset ($_SESSION [$this->prefix . 'category_keysearch'])) {
            if ($_SESSION [$this->prefix . 'category_keysearch']) {
                $keysearch = $_SESSION [$this->prefix . 'category_keysearch'];
                $where .= " AND ( name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' OR id = '" . $keysearch . "')";
            }
        }
        $sql = " SELECT id, image, name, parent_id AS parent_id  ,level
				FROM " . $this->table_category . "
				WHERE 1=1 " . $where;
        $db->query($sql);
        $categories = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($categories);
        return $list;
    }

    /*
        * select in category level 3
        */
    function get_categories_level_3()
    {
        global $db;
        $where = '';
        $sql = " SELECT id, name, parent_id AS parent_id  ,level
				FROM " . $this->table_category . "
				WHERE 1=1 AND level = 2 " . $where;
        $db->query($sql);
        $categories = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($categories);
        return $list;
    }

    /*
         * select in type
         */
    function get_type()
    {
        global $db;
        $query = " SELECT id, name 
				FROM " . $this->table_types;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $name = FSInput::get('name');
        if (!$name) {
            Errors::_('You must entere name');
            return false;
        }

        $id = FSInput::get('id', 0, 'int');
        if (!$id) {
            $row['quantity'] = FSInput::get2('count', 0, 'int');
        }

        // category and category_id_wrapper
        $category_id = FSInput::get('category_id', 0, 'int');
        if (!$category_id) {
            Errors::_('You must select category');
            return false;
        }


        $cat = $this->get_record_by_id($category_id, $this->table_category);
        $row ['category_id_wrapper'] = $cat->list_parents;
//        $row ['category_root_alias'] = $cat->root_alias;
        $row ['category_alias_wrapper'] = $cat->alias_wrapper;
        $row ['category_name'] = $cat->name;
        $row ['category_alias'] = $cat->alias;
        $row ['category_published'] = $cat->published;
        $row ['tablename'] = $cat->tablename;

        //$row ['specs'] = ''; // khi sửa ta xóa specs đi để còn update đc
//        $manufactory_id = FSInput::get('manufactory');
//        if ($manufactory_id) {
//            $manufactory = $this->get_record_by_id($manufactory_id, 'fs_manufactories');
//            $row ['manufactory'] = $manufactory_id;
//            $row ['manufactory_alias'] = $manufactory->alias;
//            $row ['manufactory_name'] = $manufactory->name;
//            $row ['manufactory_image'] = $manufactory->image;
//        }

        //lưu danh mục phụ
        $multi_categories = FSInput::get('multi_categories', array(), 'array');
        $str_multi_categories = implode(',', $multi_categories);
        if ($str_multi_categories) {
            $str_multi_categories = ',' . $str_multi_categories . ',';
        }
        $row['multi_categories'] = $str_multi_categories;

        //lưu cửa hàng chọn nhiều
//        $arr_store_id = FSInput::get('stores', array(), 'array');
//        $str_store_id = implode(',', $arr_store_id);
//        $row ['stores'] = ',' . $str_store_id . ',';

//lưu sp cùng loại chọn nhiều
        $arr_prd_id = FSInput::get('products_same', array(), 'array');
        if (@$arr_prd_id && !empty($arr_prd_id)) {

            $str_prd_id = implode(',', $arr_prd_id);
            $row ['products_same'] = ',' . $str_prd_id . ',' . $id . ',';
            $row1 = array();
            $row1 ['products_same'] = ',' . $str_prd_id . ',' . $id . ',';
            foreach ($arr_prd_id as $key => $value) {
                $sam = $this->_update($row1, 'fs_products', 'id = ' . $value);
            }
        } else {
            $row ['products_same'] = '';
        }


        //price
        $price = FSInput::get('price');
        $row ['price'] = $price = $this->standart_money($price, 0);

        $price_old = FSInput::get('price_old');
        $row ['price_old'] = $price_old = $this->standart_money($price_old, 0);

        if ($price > 0 && $price_old == 0) {
            $row ['price_old'] = $price;
            $row ['discount'] = 0;
        } elseif ($price == 0 && $price_old > 0) {
            $row ['price'] = $price_old;
            $row ['discount'] = 0;
        } else {
            $row ['discount'] = $row ['price_old'] - $row ['price'];
        }

//        //price mua kèm
        $price_compare = FSInput::get('price_compare');
        $row ['price_compare'] = $price_compare = $this->standart_money($price_compare, 0);
        //        //price thu loại 1
        $price_autumn = FSInput::get('price_autumn');
        $row ['price_autumn'] = $price_autumn = $this->standart_money($price_autumn, 0);
        //        //price thu loại 2
        $price_autumn_2 = FSInput::get('price_autumn_2');
        $row ['price_autumn_2'] = $price_autumn_2 = $this->standart_money($price_autumn_2, 0);
        //        //price thu loại 3
        $price_autumn_3 = FSInput::get('price_autumn_3');
        $row ['price_autumn_3'] = $price_autumn_3 = $this->standart_money($price_autumn_3, 0);
        //        //price thu loại 4
        $price_autumn_4 = FSInput::get('price_autumn_4');
        $row ['price_autumn_4'] = $price_autumn_4 = $this->standart_money($price_autumn_4, 0);

        // image thông số kỹ thuật
//        $image_name = $_FILES["image_spec"]["name"];
//        if ($image_name) {
//            $image = $this->upload_image('image_spec', '_' . time(), 2000000, $this->arr_img_paths_spec);
//            if ($image) {
//                $row['image_spec'] = $image;
//            }
//        }
        $type_image = FSInput::get('type_image_spec', 0, 'int');
        if ($type_image == 0) {
            $image_spec = $_FILES["image_spec"]["name"];
        } else {
            $image_spec = FSInput::get('image_spec');
        }
        if ($image_spec) {
            $image = $this->upload_image('image_spec', '_' . time(), 2000000,
                $this->arr_img_paths_spec, '', $type_image, $image_spec);
            if ($image) {
                $row['image_spec'] = $image;
            }
        }

        $type_image_unbox = FSInput::get('type_image_unbox', 0, 'int');
        if ($type_image_unbox == 0) {
            $image_unbox = $_FILES["image_unbox"]["name"];
        } else {
            $image_unbox = FSInput::get('image_unbox');
        }
        if ($image_unbox) {
            $image = $this->upload_image('image_unbox', '_' . time(), 2000000,
                $this->arr_img_paths_unbox, '', $type_image_unbox, $image_unbox);
            if ($image) {
                $row['image_unbox'] = $image;
            }
        }
$type_image_land = FSInput::get('type_image_land', 0, 'int');
        if ($type_image_land == 0) {
            $image_land = $_FILES["image_land"]["name"];
        } else {
            $image_land = FSInput::get('image_land');
        }
        if ($image_land) {
            $image = $this->upload_image('image_land', '_' . time(), 2000000,
                $this->arr_img_paths_landing, '', $type_image_land, $image_land);
            if ($image) {
                $row['image_land'] = $image;
            }
        }


//        $image_og = $_FILES["image_og"]["name"];
//        if ($image_og) {
//            $image = $this->upload_image('image', '_' . time(), 4000000, $this->arr_img_paths_og);
//            if ($image) {
//                $row['image_og'] = $image;
//            }
//        }

        $user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
        if (!$user_id)
            return false;
        $user = $this->get_record_by_id($user_id, 'fs_users', 'username');

        if ($id) {
            // $row['action_id'] = $user_id;
            // $row['action_name'] = $username;
            // $row['editor_id'] = $user_id;
            // $row['editor_name'] = $username;
//            $row['user_full_name'] = $username;
            $row['author_last'] = $user->username;
            $row['author_last_id'] = $user_id;
        } else {
            $row['author'] = $user->username;
            $row['author_id'] = $user_id;
            // $row['editor_id'] = $user_id;
            // $row['editor_name'] = $username;
//            $row['user_full_name'] = $username;
        }

        $products_related = $color = FSInput::get('products_record_related', array(), 'array');
        $str_products_related = implode(',', $products_related);
        if ($str_products_related) {
            $str_products_related = ',' . $str_products_related . ',';
        }
        $row ['products_related'] = $str_products_related;

// related products
        $record_compatable = FSInput::get('products_record_compatable', array(), 'array');
        $row['products_compatable'] = '';
        if (count($record_compatable)) {
            $record_compatable = array_unique($record_compatable);
            $row['products_compatable'] = implode(',', $record_compatable);
        }


        $news_related = $color = FSInput::get('news_record_related', array(), 'array');
        $str_news_related = implode(',', $news_related);
        if ($str_news_related) {
            $str_news_related = ',' . $str_news_related . ',';
        }
        $row ['news_related'] = $str_news_related;

        //lấy alias
//        $fsstring = FSFactory::getClass('FSString', '', '../');
//        $alias = $fsstring->stringStandart($name);
//        $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;
//        $check_alias = $this->check_exist_alias_redirect($id, $alias);
//        if ($check_alias) {
//            Errors::_('Alias của bạn đã bị trùng tên', 'alert');
//            $row['alias'] = $this->genarate_alias_news($row['alias'], $id);
//        }
        $id = parent::save($row, 1);
//        die;
        $this->save_redirect($id);

        if (!$id) {
            Errors::setError('Not save');
            return false;
        } else {
            $this->save_extension($row['tablename'], $id);
            // $this->save_extension_new($category_id, $id);
            $this->save_extension_new2($cat->tablename, $id);
        }
        $rs = $this->save_edit($id);
        $product_sub = $this->get_records('published = 1 AND product_id=' . $id, 'fs_products_sub', 'name, id, price, price_old, store, stocking');
        if (@$product_sub) {
            $price_min = 0;
            foreach ($product_sub as $item) {
                if ($price_min == 0) {
                    $price_min = $item->price;
                } elseif ($item->price < $price_min) {
                    $price_min = $item->price;
                }
            }
            $prd_active = $this->get_records('published = 1 AND product_id=' . $id . ' AND price =' . $price_min . ' ORDER BY price_old DESC LIMIT 1', 'fs_products_sub', 'name, id, price, price_old,discount, store, stocking');
            $row_up = array();
            $row_up['price'] = $prd_active[0]->price;
            $row_up['price_old'] = $prd_active[0]->price_old;
            $row_up['discount'] = $prd_active[0]->discount;
            $this->_update($row_up, 'fs_products', 'id=' . $id);
//            die;
        }
        // remove color
        if (!$this->remove_images_plus($id)) {
        }
        // edit color
        if (!$this->save_exist_images_plus($id)) {
            //				return false;
        }
        // save color
        if (!$this->save_new_images_plus($id)) {
        }
        $this->save_products_images($id);
        session_regenerate_id();
        return $id;
    }

    /*
         * save into extension table
         * (insert or update)
         */
    function save_extension($tablename, $record_id)
    {
        if (!$tablename || $tablename == 'fs_products')
            return;

        $data = $this->get_record('id = ' . $record_id, $this->table_name);
        global $db;

        // field default: cai nay can xem lai vi hien dang ko su dung. Can phai su dung de luoc bot cac  truong thua
        $field_default = $this->get_records(' type = "' . $this->type . '"  ', 'fs_tables');
        if (!$record_id)
            return false;

        if (!$db->checkExistTable($tablename))
            return false;
        $ext_id = FSInput::get('ext_id');

        // data same fs_TYPE
        $row ['record_id'] = $record_id;
        $fields_all_of_ext_table = $this->get_field_table($tablename, 1);
        foreach ($data as $field_name => $value) {
            if ($field_name == 'id' || $field_name == 'tablename')
                continue;
            if (!isset ($fields_all_of_ext_table [$field_name]))
                continue;
            if ($field_name == 'record_id')
                continue;
            $row [$field_name] = $value;
        }


        // main extension ==> add into summary field
        $summary_auto = '';
        // extention
        $fields_ext = $this->getExtendFields($tablename);

        if (count($fields_ext) > 0) {
            for ($i = 0; $i < count($fields_ext); $i++) {
                $fname = strtolower($fields_ext [$i]->field_name);
                if (!array_key_exists(strtolower($fname), $row)) {
                    $ftype = $fields_ext [$i]->field_type;
                    $display_name = $fields_ext [$i]->field_name_display;
                    $f_is_main = $fields_ext [$i]->is_main;
                    switch ($ftype) {
                        case 'image' :
                            $upload_area = $fname;
                            if ($_FILES [$upload_area] ["name"]) {
                                $fsFile = FSFactory::getClass('FsFiles', '');
                                $path = str_replace('/', DS, $this->img_folder);
                                $image = $fsFile->uploadImage($upload_area, $path, 2000000, '_ext' . time());
                                $row [$fname] = $image;
                            }
                            break;
                        case 'text' :
                            if (get_magic_quotes_gpc() == 0)
                                $row [$fname] = htmlspecialchars_decode($_POST [$fname]);
                            else
                                $row [$fname] = htmlspecialchars_decode($_POST [$fname]);
                            // summary_auto
                            if ($f_is_main && $row [$fname])
                                $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
                            break;
                        case 'varchar' :
                            if (get_magic_quotes_gpc() == 0)
                                $row [$fname] = htmlspecialchars_decode(stripslashes($_POST [$fname]));
                            else
                                $row [$fname] = htmlspecialchars_decode(stripslashes($_POST [$fname]));
                            // summary_auto
                            if ($f_is_main && $row [$fname])
                                $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
                            break;
                        case 'foreign_multi' :
                            $values = FSInput::get($fname, array(), 'array');
                            if (!count($values))
                                break;
                            $str_values = implode(',', $values);
                            $row [$fname] = count($values) ? ',' . $str_values . ',' : '';

                            // summary_auto
                            if (!$f_is_main)
                                break;
                            $table_name = $fields_ext [$i]->foreign_tablename;
                            // check exit extend_table
                            if (!$db->checkExistTable($table_name))
                                break;
                            $data_foreign = $this->get_records(' id IN (' . $str_values . ')', $table_name);
                            if (!count($data_foreign))
                                break;
                            $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>';
                            $s = 0;
                            foreach ($data_foreign as $item) {
                                if ($s > 0)
                                    $summary_auto .= ', ';
                                $summary_auto .= $item->name;
                                $s++;
                            }
                            $summary_auto .= '</span>';
                            break;
                        case 'foreign_one' :
                            $value = FSInput::get($fname);
                            $row [$fname] = $value;
                            if (!$value)
                                break;
                            // summary_auto
                            if (!$f_is_main)
                                break;
                            $table_name = $fields_ext [$i]->foreign_tablename;
                            // check exit extend_table
                            if (!$db->checkExistTable($table_name))
                                break;
                            $data_foreign = $this->get_record(' id =  ' . $value . '', $table_name);
                            if (!$data_foreign)
                                break;
                            $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $data_foreign->name;
                            $summary_auto .= '</span>';
                            break;
                        case 'datetime' :
                            $row [$fname] = date('Y-m-d H:i:s', strtotime(FSInput::get($fname)));
                            if ($f_is_main && $row [$fname])
                                $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
                            break;
                        default :
                            if (get_magic_quotes_gpc() == 0)
                                $row [$fname] = $db->escape_string(htmlspecialchars_decode(FSInput::get($fname)));
                            else
                                $row [$fname] = htmlspecialchars_decode(FSInput::get($fname));

                            if ($f_is_main && $row [$fname])
                                $summary_auto .= '<span class="sum_item"><span class="sum_item_lb">' . $display_name . ': </span>' . $row [$fname] . '</span>';
                            break;

                    }
                }
            }
        }

        //update summary_auto into table fs_TYPE
        $row2 ['summary_auto'] = $summary_auto;
        $this->_update($row2, $this->table_name, ' id =  ' . $record_id, 1);

        $row['code'] = strtotime(FSInput::get('expiration_date'));
        $row['types'] = FSInput::get('level');
        if ($ext_id) {
            return $this->_update($row, $tablename, ' id =  ' . $ext_id, 1);
        } else {
            return $this->_add($row, $tablename, 1);
        }
        return;
    }

    function save_edit($id)
    {
        global $db;

        $tablename = 'fs_products_sub';

//        var_dump($tablename); die;

        // remove field
        if (!$this->remove_exist_field($tablename, $id)) {
            return false;
        }

        // save exist field
        if (!$this->save_exist_field($tablename)) {
            return false;
        }

        // save new field
        if (!$this->save_new_field($tablename, $id)) {
            return false;
        }

        return true;
    }

    function remove_exist_field($tablename)
    {
        global $db;
        $field_remove = trim(FSInput::get('field_remove'));
        if ($field_remove) {
            $array_field_remove = explode(",", $field_remove);
            if (count($array_field_remove) > 0) {
                foreach ($array_field_remove as $item) {
                    $this->_remove('id = ' . $item, $tablename);
                }
            }
        }
        return true;
    }

    function save_exist_field($table_name)
    {
        global $db;

        // EXIST FIELD
        $field_extend_exist_total = FSInput::get('field_extend_exist_total');

        $arr_sql_alter = array();
        $time = date("Y-m-d H:i:s");
//var_dump($api);
        for ($i = 0; $i < $field_extend_exist_total; $i++) {
            $sql_update = " UPDATE " . $table_name . "
							SET ";

            $id_exist = FSInput::get('id_exist_' . $i);
            //lưu cửa hàng
//            $str_store = FSInput::get('store_exist_' . $i, array(), 'array');
//            if (!empty($str_store)) {
//                $str_store = implode($str_store, ',');
//                $str_store = ',' . $str_store . ',';
//            }
//            $store_exist = $str_store;
//            $store_exist_begin = FSInput::get('store_exist_' . $i . '_begin');

            $code_exist = FSInput::get('code_exist_' . $i);
            $code_exist_begin = FSInput::get('code_exist_' . $i . '_begin');

            //lưu giá
            $price_exist = FSInput::get('price_exist_' . $i);
            $price_exist = str_replace('.', '', $price_exist);
            $price_exist_begin = FSInput::get('price_exist_' . $i . '_begin');
            $price_h_exist = FSInput::get('price_h_exist_' . $i);
            $price_h_exist = str_replace('.', '', $price_h_exist);
            $price_h_exist_begin = FSInput::get('price_h_exist_' . $i . '_begin');
            $price_h_exist_begin = str_replace('.', '', $price_h_exist_begin);
            if ($price_h_exist > 0 && $price_exist == 0) {
                $price_exist = $price_h_exist;
                $discount = 0;
            } elseif ($price_h_exist == 0 && $price_exist > 0) {
                $price_h_exist = $price_exist;
                $discount = 0;
            } else {
                $discount = $price_exist - $price_h_exist;
            }


            $products_type_id_exist = FSInput::get('products_type_id_exist_' . $i);
            $products_type_id_exist_begin = FSInput::get('products_type_id_exist_' . $i . '_begin');

//            $stocking_exist = FSInput::get('is_stocking_exist_' . $i);
//            $stocking_exist_begin = FSInput::get('is_stocking_exist_' . $i . '_begin');

            $published_exist = FSInput::get('is_published_exist_' . $i);
            $published_exist_begin = FSInput::get('is_published_exist_' . $i . '_begin');

            $image = FSInput::get('name_image_exist_' . $i);
            $upload_area = "other_image_" . $i;
            if ($_FILES [$upload_area] ["name"]) {
                $image_new = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_sub);
                $path = PATH_BASE . $image;
                @unlink($path);
                foreach ($this->arr_img_paths_other as $img) {
                    @unlink(str_replace('/original/', '/' . $img[0] . '/', $path));
                }
                $image = $image_new;
            }

            if (($price_exist != $price_exist_begin) || ($price_h_exist != $price_h_exist_begin)
                || ($published_exist != $published_exist_begin) || ($products_type_id_exist != $products_type_id_exist_begin) || $_FILES [$upload_area] ["name"] || ($code_exist != $code_exist_begin)) {


                $sql_update .= " 	  
											price_old = '$price_exist', 
											price = '$price_h_exist', 
											discount = '$discount', 
											image = '$image', 
											name = '$products_type_id_exist',
											code = '$code_exist',
											published = '$published_exist',
											edited_time = '$time'
											";
                $sql_update .= " WHERE id = $id_exist ";

//                    print_r($sql_update);die();

                $db->query($sql_update);
                $rows = $db->affected_rows();

            }
//            }
        }
//die;
        return true;

        // END EXIST FIELD
    }

    function save_new_field($table_name, $id)
    {
//        echo ($table_name);
//        echo 1;die;
        global $db;
        $time = date("Y-m-d H:i:s");
        // NEW FIELD
        $new_field_total = FSInput::get('new_field_total');
//        var_dump($new_field_total);die();
        if ($new_field_total) {
            $row = array();
//            $arr_insert_table = array();
            for ($i = 0; $i < $new_field_total; $i++) {
//                $new_name = FSInput::get('new_name_' . $i);
//                $row['name'] = $new_name;
//                $new_code = FSInput::get('new_code_'.$i);
//                    $row['code'] = $new_code;
                //lưu record_id
                $row['product_id'] = $id;
                //lưu mã
                $new_code = FSInput::get('new_code_' . $i);
                $row['code'] = $new_code;

                //lưu tên
                $new_products_type = FSInput::get('new_products_type_id_' . $i);
                $row['name'] = $new_products_type;

//                $new_quan = FSInput::get('new_quan_' . $i);
//                $row['quantity'] = $new_quan;
                //lưu giá
                $price = FSInput::get('new_price_h_' . $i);
                $row ['price'] = $price = $this->standart_money($price, 0);

                $price_old = FSInput::get('new_price_' . $i);
                $row ['price_old'] = $price_old = $this->standart_money($price_old, 0);

                if ($price > 0 && $price_old == 0) {
                    $row ['price_old'] = $price;
                    $row ['discount'] = 0;
                } elseif ($price == 0 && $price_old > 0) {
                    $row ['price'] = $price_old;
                    $row ['discount'] = 0;
                } else {
                    $row ['discount'] = $row ['price_old'] - $row ['price'];
                }

                //lưu ảnh
                $upload_area = "new_other_image_" . $i;
//                echo $upload_area;
                if ($_FILES [$upload_area] ["name"]) {
                    $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_sub);
                    $row ['image'] = $image;
                }
                //lưu cửa hàng
//                $new_store_color = FSInput::get('new_store_color_' . $i, array(), 'array');
//
//                if (!empty($new_store_color)) {
//                    $new_store_color = implode($new_store_color, ',');
//                    $new_store_color = ',' . $new_store_color . ',';
//                }
//                $row['store'] = $new_store_color;
//
//                $new_stocking = FSInput::get('new_stocking_' . $i);
//                $row['stocking'] = $new_stocking;

                $new_published = FSInput::get('new_published_' . $i);
                $row['published'] = $new_published;

                $row['created_time'] = $time;
                $row['edited_time'] = $time;
//var_dump($row);die;
//                    $arr_insert_table[]  = 	"('$new_code','$new_price','$new_price_h','$new_color','$color_name','$new_species','$species_name','$new_memory','$memory_name','$new_origin','$origin_name','$new_warranty','$warranty_name','$new_published')";
//                $arr_insert_table[] = "('$new_code','$new_price','$new_price_h','$new_color','$color_name','$new_species','$species_name','$new_warranty','$warranty_name','$new_published')";
//                $arr_insert_table[] = "('$new_name','$new_quan', '$new_price','$new_price_h','$new_color','$color_name','$products_type', '$products_type_name','$new_published')";
                $id_sub = $this->_add($row, $table_name);

                if ($id_sub && $new_code == '')
                    $this->_update(array('code' => 'W' . $id_sub), 'fs_products_sub', 'id=' . $id_sub, 0);
            }

//die;
            if (!$id_sub) {
                Errors::setError("Không thể thêm mới sản phẩm phụ !");
                return false;
            }

        }
        return true;
    }

    function save_accessories_incentives($product_id)
    {
        if (!$product_id)
            return;
        global $db;
        $query = ' SELECT id,product_incenty_id,product_id 
						FROM fs_products_incentives
						WHERE product_id =  ' . $product_id;
        $db->query($query);
        $list = $db->getObjectList();
        if (count($list)) {
            foreach ($list as $item) {
                $product_incenty_id = $item->product_incenty_id;
                $price_new = FSInput::get('price_new_' . $product_incenty_id);
                $price_new_begin = FSInput::get('price_new_' . $product_incenty_id . "_begin");

                if ($price_new != $price_new_begin) {
                    $sql = ' UPDATE  fs_products_incentives SET ';
                    $sql .= ' `price_new` =  "' . $price_new . '"';
                    $sql .= ' WHERE product_id =    ' . $product_id . ' ';
                    $sql .= ' AND product_incenty_id = ' . $product_incenty_id . ' ';

                    $db->query($sql);
                    $db->affected_rows();
                }
            }
        }
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

        // 	calculate filters:
        $arr_table_name_changed = array();

        $field_change_arr = explode(',', $field_change);
        $total_field_change = count($field_change_arr);
        $record_change_success = 0;
        for ($i = 0; $i < $total; $i++) {
            $str_update = '';
            $update = 0;
            $row = array();
            $row1 = array();
            foreach ($field_change_arr as $field_item) {
                $field_value_original = FSInput::get($field_item . '_' . $i . '_original');
                $field_value_new = FSInput::get($field_item . '_' . $i);
                if (is_array($field_value_new)) {
                    $field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) . ',' : '';
                }

                if ($field_value_original != $field_value_new) {
                    $update = 1;
                    //	        	          $row[$field_item] = htmlspecialchars_decode($field_value_new);
                    $row [$field_item] = htmlspecialchars_decode($field_value_new);
//                    if ($field_item != 'seo_title' && $field_item != 'seo_keyword' && $field_item && 'seo_description') {
                        $row1 [$field_item] = htmlspecialchars_decode($field_value_new);
//                    }
                    //	        	          $str_update[] = "`".$field_item."` = '".$field_value_new."'";
                }
            }
            if ($update) {
                $cat = $this->get_record("id = " . FSInput::get('category_id_' . $i) . "", 'fs_products_categories', 'alias, name, list_parents, alias_wrapper,tablename');
                $row['category_alias'] = $cat->alias;
                $row['category_name'] = $cat->name;
                $row['category_id_wrapper'] = $cat->list_parents;
                $row['category_alias_wrapper'] = $cat->alias_wrapper;
                $row['tablename'] = $cat->tablename;
                $row1['category_alias'] = $cat->alias;
                $row1['category_name'] = $cat->name;
                $row1['category_id_wrapper'] = $cat->list_parents;
                $row1['category_alias_wrapper'] = $cat->alias_wrapper;
                // user
//                $user_group = $_SESSION['ad_group'];
                $user_id = $_SESSION['ad_userid'];
                $username = $_SESSION['ad_username'];
//                $fullname = $_SESSION['ad_fullname'];

                // $row2['editor_id'] = $user_id;
                // $row2['editor_name'] = $username;
//var_dump($row);
//var_dump($row1);die;
                $id = FSInput::get('id_' . $i, 0, 'int');
                $rs = $this->_update($row, $this->table_name, '  id = ' . $id, 0);
//                $this->_update($row2, $this->table_name, '  id = ' . $id, 0);
                if ($this->use_table_extend) {
                    $record = $this->get_record('id = ' . $id, $this->table_name);
                    $table_extend = $record->tablename;
                    // calculate filters:
                    $arr_table_name_changed [] = $table_extend;
                    global $db;
                    if ($table_extend && $table_extend != 'fs_products' && $db->checkExistTable($table_extend)) {
                        $rs1 = $this->_update($row1, $table_extend, '  record_id = ' . $id);
                    }
                }
                //synchronize
                $array_synchronize = $this->array_synchronize;
                if (count($array_synchronize)) {
                    foreach ($array_synchronize as $table_name => $fields) {
                        $i = 0;
                        $syn = 0;
                        $row5 = array();
                        $where = ' WHERE ';
                        foreach ($fields as $cur_field => $syn_field) {
                            if (!$i) {
                                $where .= $syn_field . ' = ' . $id;
                            } else {
                                if (isset ($row [$cur_field])) {
                                    $row5 [$syn_field] = $row [$cur_field];
                                    $syn = 1;
                                }
                            }
                            $i++;
                        }
                        if ($syn)
                            $rs = $this->_update($row5, $table_name, $where, 0);
                    }
                }

                if (!$rs) {
                    continue;
                }
//					return false;
                $record_change_success++;
            }
        }
//        // calculate filters:
//        if ($this->calculate_filters) {
//            $this->caculate_filter($arr_table_name_changed);
//        }
        return $record_change_success;
    }

    function getManufactories($tablename)
    {
        $where = '';
        if ($tablename) {
            $where .= 'OR tablenames like "%,' . $tablename . ',%"';
        }
        global $db;
        $query = ' SELECT id,name
						FROM fs_manufactories 
						WHERE tablenames is NULL
						 ' . $where . '	OR tablenames="" ';
        $sql = $db->query($query);
        $alias = $db->getObjectList();

        return $alias;
    }

    /*
         * select all group in table fs_group
         */
    function getRelatedCategories($tablename = '')
    {

        $permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'products_categories');
        $where = '  ';
//			if($permission_cities == 'none'){
//				$where .= ' AND 1 = 0';
//			}elseif($permission_cities && $permission_cities != 'all'){
//				$where .= ' AND id IN (0'.$permission_cities.'0)';
//			}
        global $db;
        if ($tablename) {
            $query = " SELECT name,id,parent_id as parent_id,level 
							FROM fs_products_categories
							WHERE	tablename  = '$tablename' " . $where . "
							 ";
        } else {
            $pid = FSInput::get('pid', 0);
            if ($pid) {
                $query = " SELECT name,id ,parent_id as parent_id,level  
								FROM fs_products_categories
								WHERE tablename = (								
									SELECT tablename 
									FROM fs_products_categories 
										WHERE id = 
											(	SELECT category_id FROM fs_products
												WHERE id = $pid ) 
									)
									" . $where . "";
            } else {
                $query = " SELECT name,id,parent_id as parent_id,level 
							FROM fs_products_categories 
							WHERE	1  = 1 " . $where . "
							 ";
            }
        }
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree');
        $result_tree = $tree->indentRows2($result, 3);
        if (count($result_tree))
            $result = $result_tree;
        else {
            foreach ($result as $item) {
                $item->treename = $item->name;
            }
        }
        return $result;
    }

    function getExtendFields($tablename)
    {
        global $db;
        if ($tablename == 'fs_products' || $tablename == '')
            return;

        $exist_table = $db->checkExistTable($tablename);
        if (!$exist_table) {
            Errors::setError(FSText::_('Table') . ' ' . $tablename . FSText::_(' is not exist'));
            return;
        }

        $cid = FSInput::get('cid');
        $query = " SELECT * 
						FROM fs_products_tables
						WHERE table_name =  '$tablename' 
						AND field_name <> 'id' 
						ORDER BY ordering ASC ";
                        // echo $query;
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    /*
         * select data FROM table extension
         */
    function getProductExt($tablename, $id = 0)
    {
        if (!$id)
            return;
        global $db;
        if ($tablename == 'fs_products')
            return;

        // check exist table
        if (!$tablename || $tablename == 'fs_products' || !$db->checkExistTable($tablename))
            return;

        $query = " SELECT *
						  FROM $tablename
						  WHERE record_id = $id ";

        $sql = $db->query($query);
        $result = $db->getObject();

        return $result;
    }

    function getTablenameFromCat()
    {
        $cid = FSInput::get('cid');
        $query = " SELECT tablename
						  FROM fs_products_categories
						  WHERE id = $cid ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        return $result;
    }


    /*
         * get alias of parent_root
         */
    function get_alias_parent_root($cid)
    {
        // get rootid
        $rootid = $cid;
        while ($cid) {
            $cid = $this->get_parent_id($cid);
            if ($cid) {
                $rootid = $cid;
            }
        }
        global $db;
        // query get alias
        $query = " SELECT alias
						FROM fs_products_categories 
						WHERE id = $rootid ";
        $sql = $db->query($query);
        $root_alias = $db->getResult();
        return $root_alias;
    }

    /*
         * get Id of parent
         */
    function get_parent_id($categoryid)
    {
        global $db;
        $query = " SELECT parent_id as parent_id
						FROM fs_products_categories 
						WHERE id = $categoryid ";
        $sql = $db->query($query);
        $alias = $db->getResult();

        return $alias;
    }

    /*
         * Lấy dữ liệu từ các bảng mở rộng
         */
    function get_data_foreign($extend_fields)
    {
        if (!count(array($extend_fields)))
            return array();
        $data_foreign = array();
        if ($extend_fields)
            foreach ($extend_fields as $field) {
                if ($field->field_type == 'foreign_one' || $field->field_type == 'foreign_multi') {
                    $table_name = $field->foreign_tablename;
                    $data_foreign [$field->field_name] = $this->get_records('group_id = ' . $field->foreign_id, 'fs_extends_items');
//				$data_foreign [$field->field_name] = $this->get_records (  'tablename = "'.$field -> table_name.'" AND field_name ="'.$field->field_name.'"', 'fs_products_filters' );
                }
            }

        return $data_foreign;
    }

    function get_products_compatable($product_compatable)
    {
        if (!$product_compatable)
            return;
        $query = " SELECT id, name, image  
					FROM fs_products
					WHERE id IN (" . $product_compatable . ") 
					 ORDER BY POSITION(','+id+',' IN '" . $product_compatable . "')
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_products_by_ids($str_products_together)
    {
        if (!$str_products_together)
            return;
        $query = " SELECT name,id 
						FROM fs_products
						WHERE id IN (" . $str_products_together . ") ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_data_for_export()
    {
        global $db;
        $query = $this->setQuery();
        if (!$query)
            return array();
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function get_products_incentives($product_id)
    {

        $query = " SELECT b.name,b.id, a.price_old,a.price_new,a.product_incenty_id 
					FROM fs_products_incentives AS a
					LEFT JOIN fs_products AS b ON a.product_incenty_id = b.id
					WHERE a.product_id = $product_id";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_products_related($product_related)
    {
        if (!$product_related)
            return;
        $query = " SELECT id, name,image 
					FROM fs_products
					WHERE id IN (0" . $product_related . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $product_related . "0')
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }


    /*
         *==================== AJAX RELATED PRODUCTS==============================
         */

    function ajax_get_products_related()
    {
        $news_id = FSInput::get('product_id', 0, 'int');
        $category_id = FSInput::get('category_id', 0, 'int');
        $keyword = FSInput::get('keyword');
        $where = ' WHERE published = 1 ';
        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
        }
        $where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";

        $query_body = ' FROM fs_products ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,category_id,name,category_name,image' . $query_body . $ordering . ' LIMIT 40 ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    /*
     *====================AJAX RELATED PRODUCTS end.==============================
     */
    /*
     *====================AJAX RELATED NEWS==============================
     */
    function get_news_related($news_related)
    {
        if (!$news_related)
            return;
        $query = " SELECT id, title 
					FROM fs_news
					WHERE id IN (0" . $news_related . "0) 
					 ORDER BY POSITION(','+id+',' IN '0" . $news_related . "0')
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    /*
             * select in category
             */
    function get_news_categories_tree()
    {
        global $db;
        $sql = " SELECT id, name, parent_id AS parent_id 
				FROM fs_news_categories";
        $db->query($sql);
        $categories = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $rs = $tree->indentRows($categories, 1);
        return $rs;
    }

    function ajax_get_news_related()
    {
        $category_id = FSInput::get('category_id', 0, 'int');
        $keyword = FSInput::get('keyword');
        $where = ' WHERE published = 1 ';
        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%"	) ';
        }
        $where .= " AND ( title LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";

        $query_body = ' FROM fs_news ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,category_id,title,category_name ' . $query_body . $ordering . ' LIMIT 40 ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }


    function save_exist_color($record_id)
    {

        $rs = 0;
        global $db;
        // Thay doi du lieu da nhap
        $other_color_exit = FSInput::get('other_color_exit', array(), 'array');
        $is_default = FSInput::get('default_color');
        foreach ($other_color_exit as $item) {
            $store_color = FSInput::get('store_color_' . $item, array(), 'array');
            if (!empty($store_color)) {
                $store_color = implode($store_color, ',');
                $store_color = ',' . $store_color . ',';
            }

            $id_exist = FSInput::get('id_exist_' . $item);
            $row ['record_id'] = $record_id;
            $color = $this->get_record_by_id($item, 'fs_products_colors');
            $row ['color_id'] = $item;
            $row ['color_code'] = $color->code;
            $row ['color_name'] = $color->name;
            $stock = FSInput::get('other_color_stock' . $item);
            $row ['is_stock'] = $stock ? 1 : 0;
            $row['store'] = $store_color;
            $row['alias'] = $color->alias;
            $row['cat_id'] = $this->get_record('id = ' . $record_id, 'fs_products')->category_id;
            // $row ['name'] = FSInput::get('color_name_exist_' . $item);
            // $product = $this->get_record_by_id ( $record_id, 'fs_products' );
            // $row ['name'] = $product->name.' '.$color->name;
            // $row ['sl_hn'] = FSInput::get('color_slhn_exist_' . $item);
            // $row ['sl_hcm'] = FSInput::get('color_slhcm_exist_' . $item);
            // $row ['sl_dn'] = FSInput::get('color_sldn_exist_' . $item);

            $row ['price'] = $this->standart_money(FSInput::get('color_price_exist_' . $item), 0);
            $row ['image'] = FSInput::get('name_price_color_exist_' . $item);
            // $row ['is_default'] = $is_default;
            if ($is_default == $item) {
                $row ['ordering'] = 1;
            }
            $upload_area_exit = "image_exit_color_" . $item;
            if ($_FILES [$upload_area_exit] ["name"]) {

                $image_exit = $this->upload_image($upload_area_exit, '_' . time(), 2000000, $this->arr_img_paths_other);
                $row ['image'] = $image_exit;
                // print_r($row);die;
            }
            $u = $this->_update($row, 'fs_products_price_colors', ' id=' . $id_exist);
            if ($u)
                $rs++;

        }
        return $rs;

        // END EXIST FIELD
    }

    function save_exist_size($record_id)
    {

        $rs = 0;
        global $db;
        // Thay doi du lieu da nhap
        $other_size_exit = FSInput::get('other_size_exit', array(), 'array');
        // $is_default = FSInput::get('default_color');
        foreach ($other_size_exit as $item) {
            $id_exist = FSInput::get('id_exist_' . $item);
            $row_size ['record_id'] = $record_id;
            $size = $this->get_record_by_id($item, 'fs_products_sizes');
            $row_size ['size_id'] = $item;
            $row_size ['size_name'] = $size->name;
            // $row_size ['name'] = FSInput::get('color_name_exist_' . $item);
            // $product = $this->get_record_by_id ( $record_id, 'fs_products' );
            // $row ['name'] = $product->name.' '.$color->name;
            // $row_size ['sl_hn'] = FSInput::get('color_slhn_exist_' . $item);
            // $row_size ['sl_hcm'] = FSInput::get('color_slhcm_exist_' . $item);
            // $row_size ['sl_dn'] = FSInput::get('color_sldn_exist_' . $item);
            // $row_size ['price'] = FSInput::get('color_price_exist_' . $item);
            $row_size ['image'] = FSInput::get('name_price_size_exist_' . $item);
            $upload_area_exit = "image_exit_size_" . $item;

            if ($_FILES [$upload_area_exit] ["name"]) {

                $image_exit = $this->upload_image($upload_area_exit, '_' . time(), 2000000, $this->arr_img_paths_other);
                $row_size ['image'] = $image_exit;
            }
            // print_r($row_size);die;
            $u = $this->_update($row_size, 'fs_products_price_sizes', ' id=' . $id_exist);
            if ($u)
                $rs++;

        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_color($record_id)
    {
        if (!$record_id)
            return true;
        $other_color = FSInput::get('other_color', array(), 'array');

        global $db;
        foreach ($other_color as $item) {
            $store_color = FSInput::get('new_store_color_' . $item, array(), 'array');
            if (!empty($store_color)) {
                $store_color = implode($store_color, ',');
                $store_color = ',' . $store_color . ',';
            }
            $row_color = array();
            $row_color ['record_id'] = $record_id;
            $color = $this->get_record_by_id($item, 'fs_products_colors');

            $row_color ['color_id'] = $item;
            $row_color ['color_code'] = $color->code;
            $row_color ['color_name'] = $color->name;
            $row_color ['name'] = FSInput::get('new_color_name_' . $item);
            $stock = FSInput::get('new_other_color_stock' . $item);
            $row_color ['is_stock'] = $stock;
            $row_color['store'] = $store_color;
            $row_color['alias'] = $color->alias;
            $row_color['cat_id'] = $this->get_record('id = ' . $record_id, 'fs_products')->category_id;
            // $product = $this->get_record_by_id ( $record_id, 'fs_products' );
            // $row ['name'] = $product->name.' '.$color->name;

            $row_color ['price'] = $this->standart_money(FSInput::get('new_color_price_' . $item), 0);

            $upload_area = "other_image_" . $item;
            if ($_FILES [$upload_area] ["name"]) {
                $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other);
                $row_color ['image'] = $image;
            }
            $rs = $this->_add($row_color, 'fs_products_price_colors', 0);
        }
        return true;
    }

    function save_new_ajax_color($record_id)
    {
        if (!$record_id)
            return true;

        $other_color = FSInput::get('a_new_other_color', array(), 'array');

        global $db;
        foreach ($other_color as $item) {
            $c_name = FSInput::get('a_new_color_name_' . $item);
            if (!$c_name) {
                echo 'Bạn chưa nhập tên màu';
                return;
            }
            $fsstring = FSFactory::getClass('FSString', '', '../');
            $c_alias = $fsstring->stringStandart($c_name);
            $c_code = FSInput::get('code_color_' . $item);
            $c_code = str_replace('#', '', $c_code);
            $upload_area = "a_new_other_image_" . $item;

            $c_store = FSInput::get('a_new_store_color_' . $item, array(), 'array');
            if (!empty($c_store)) {
                $c_store = implode($c_store, ',');
                $c_store = ',' . $c_store . ',';
            }
            $row_c = array();
            $row_c['name'] = $c_name;
            $row_c['alias'] = $c_alias;
            $row_c['code'] = $c_code;
            $row_c['published'] = 1;
            $row_c['created_time'] = date('Y-m-d H:m:s');
            $result = $this->_add($row_c, 'fs_products_colors');

            $row_c2 = array();
            $row_c2['record_id'] = $record_id;
            $row_c2['color_id'] = $result;
            $row_c2['color_code'] = $c_code;
            $row_c2['color_name'] = $c_name;
            $row_c2['is_stock'] = FSInput::get('a_new_other_color_stock' . $item);
            $row_c2['store'] = $c_store;
            $row_c2['alias'] = $c_alias;
            $row_c2['cat_id'] = $this->get_record('id = ' . $record_id, 'fs_products')->category_id;
            $row_c2['price'] = $this->standart_money(FSInput::get('a_new_color_price_' . $item), 0);

            if ($_FILES [$upload_area]["name"]) {
                $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other);
                $row_c2['image'] = $image;
            }
            $rs = $this->_add($row_c2, 'fs_products_price_colors', 0);
        }
        return true;
    }

    function save_new_size($record_id)
    {
        if (!$record_id)
            return true;
        $other_size = FSInput::get('other_size', array(), 'array');
        global $db;
        foreach ($other_size as $item) {

            $row_size = array();
            $row_size ['record_id'] = $record_id;
            $size = $this->get_record_by_id($item, 'fs_products_sizes');
            $row_size ['size_id'] = $item;
            $row_size ['size_name'] = $size->name;
            $row_size ['category_id'] = FSInput::get('category_id', 0, 'int');;
            // $product = $this->get_record_by_id ( $record_id, 'fs_products' );
            // $row ['name'] = $product->name.' '.$color->name;

            // $row ['price'] = FSInput::get('new_color_price_' . $item);
            $upload_area = "other_image_" . $item;
            if ($_FILES [$upload_area] ["name"]) {
                $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other);
                $row_size ['image'] = $image;
            }
//            var_dump($row);
//            die();
            $rs = $this->_add($row_size, 'fs_products_price_sizes', 0);
        }
        return true;
    }

    function remove_color($record_id)
    {

        $rs = 0;
        global $db;

        $other_color_exit = FSInput::get('other_color_exit', array(), 'array');
        $str_other_images = implode(',', $other_color_exit);
        $whewe = '';
        if ($str_other_images) {
            $whewe .= ' AND color_id NOT IN (' . $str_other_images . ')';
        }
        $query = " SELECT image 
						FROM fs_products_price_colors
						WHERE record_id = $record_id
						$whewe
						";

        $sql = $db->query($query);
        $images_need_remove = $db->getObjectList();
        $fsFile = FSFactory::getClass('FsFiles', '');
        $arr_img_paths = $this->arr_img_paths_other;
        foreach ($images_need_remove as $item) {

            if ($item->image) {
                $path = PATH_BASE . $item->image;
                $path = str_replace('/', DS, $path);
                $fsFile->remove_file_by_path($path);
                if (count($arr_img_paths)) {
                    foreach ($arr_img_paths as $item) {
                        $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, $path);
                        $fsFile->remove_file_by_path($path_resize);
                    }
                }
            }
        }
        // remove in database
        $sql = " DELETE FROM fs_products_price_colors
					WHERE record_id = " . $record_id . " " .
            $whewe;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
        // END EXIST FIELD
    }

    function remove_size($record_id)
    {

        $rs = 0;
        global $db;

        $other_color_exit = FSInput::get('other_size_exit', array(), 'array');
        $str_other_images = implode(',', $other_color_exit);
        $whewe = '';
        if ($str_other_images) {
            $whewe .= ' AND size_id NOT IN (' . $str_other_images . ')';
        }
        $query = " SELECT image 
						FROM fs_products_price_sizes
						WHERE record_id = $record_id
						$whewe
						";

        $sql = $db->query($query);
        $images_need_remove = $db->getObjectList();
        $fsFile = FSFactory::getClass('FsFiles', '');
        $arr_img_paths = $this->arr_img_paths_other;
        foreach ($images_need_remove as $item) {

            if ($item->image) {
                $path = PATH_BASE . $item->image;
                $path = str_replace('/', DS, $path);
                $fsFile->remove_file_by_path($path);
                if (count($arr_img_paths)) {
                    foreach ($arr_img_paths as $item) {
                        $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, $path);
                        $fsFile->remove_file_by_path($path_resize);
                    }
                }
            }
        }
        // remove in database
        $sql = " DELETE FROM fs_products_price_sizes
					WHERE record_id = " . $record_id . " " .
            $whewe;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
        // END EXIST FIELD
    }

    function remove_images_plus($record_id)
    {

        $rs = 0;
        global $db;

        $other_image_plus = FSInput::get('other_image_plus', array(), 'array');
        $str_other_images_plus = implode(',', $other_image_plus);
        $where = '';
        if ($str_other_images_plus) {
            $where .= ' AND id  IN (' . $str_other_images_plus . ')';


            $query = " SELECT image 
							FROM fs_" . $this->type . "_images_plus
							WHERE record_id = $record_id
							$where
							";
            $sql = $db->query($query);
            $images_need_remove = $db->getObjectList();
            $fsFile = FSFactory::getClass('FsFiles', '');
            $arr_img_paths = $this->arr_img_paths_other_plus;
            foreach ($images_need_remove as $item) {

                if ($item->image) {
                    $path = PATH_BASE . $item->image;
                    $path = str_replace('/', DS, $path);
                    $fsFile->remove_file_by_path($path);
                    if (count($arr_img_paths)) {
                        foreach ($arr_img_paths as $item) {
                            $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, $path);
                            $fsFile->remove_file_by_path($path_resize);
                        }
                    }
                }
            }
            // remove in database
            $sql = " DELETE FROM fs_products_images_plus
						WHERE record_id = " . $record_id . "" .
                $where;
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
            // END EXIST FIELD
        }
    }

    function save_exist_images_plus($record_id)
    {

        $rs = 0;
        global $db;
        // Thay doi du lieu da nhap
        $other_color_exit = FSInput::get('image_plus_exist_total', array(), 'array');
        foreach ($other_color_exit as $item) {
            $row ['record_id'] = $record_id;
            $row ['content'] = FSInput::get('content_plus_exit_' . $item);
            $row ['image'] = FSInput::get('name_image_plus_exist_' . $item);
            $upload_area_exit = "image_plus_exit_" . $item;

            if ($_FILES [$upload_area_exit] ["name"]) {

                $image_exit = $this->upload_image($upload_area_exit, '_' . time(), 2000000, $this->arr_img_paths_other_plus);
                $row ['image'] = $image_exit;
            }

            $u = $this->_update($row, 'fs_products_images_plus', ' id=' . $item);
            if ($u)
                $rs++;

        }
        return $rs;

        // END EXIST FIELD
    }

    function save_new_images_plus($record_id)
    {
        if (!$record_id)
            return true;
        global $db;
        for ($i = 0; $i < 5; $i++) {

            $row = array();

            $upload_area = "new_image_plus_" . $i;
            if ($_FILES [$upload_area] ["name"]) {
                $image = $this->upload_image($upload_area, '_' . time(), 2000000, $this->arr_img_paths_other_plus);
                $row ['image'] = $image;
                $row ['record_id'] = $record_id;
                $row ['content'] = FSInput::get('new_content_plus_' . $i);
                $rs = $this->_add($row, 'fs_products_images_plus', 0);
            }
            // $row ['content'] = FSInput::get ( 'new_content_plus_' . $i );
            // if($row){
            // 	// $row ['record_id'] = $record_id;

            // }
        }
        return true;
    }

    /**********************/

    /**********************/
    function remove_incentives()
    {
        $id = FSInput::get('id', 0, 'int');
        $product_incentives_id = FSInput::get('product_incentives_id', 0, 'int');
        if (!$id || !$product_incentives_id)
            return;

        $sql = " SELECT products_incentives 
			FROM fs_products 
			WHERE id = $id
				";
        global $db;
        $db->query($sql);
        $rs = $db->getResult();
        if (!$rs)
            return;

        $arr = explode(',', $rs);
        if (!count($arr))
            return;
        $str = '';
        $i = 0;
        foreach ($arr as $item) {
            if ($item != $product_incentives_id) {
                if ($i > 0)
                    $str .= ',';
                $str .= $item;
                $i++;
            }
        }
        $row['products_incentives'] = $str;

        // remove from fs_products_incentives
        $this->remove_from_products_incentives($id, $product_incentives_id);
        return $this->_update($row, 'fs_products', 'id = ' . $id . '');
    }

    function remove_from_products_incentives($id, $product_incentives_id)
    {
        $sql = " DELETE FROM fs_products_incentives
					WHERE product_id = $id
						AND product_incenty_id = $product_incentives_id ";
        global $db;
        $db->query($sql);
        $rows = $db->affected_rows();
    }

    function standart_money($money, $method)
    {
        $money = str_replace(',', '', trim($money));
        $money = str_replace(' ', '', $money);
        $money = str_replace('.', '', $money);
//		$money = intval($money);
        $money = (double)($money);
        if (!$method)
            return $money;
        if ($method == 1) {
            $money = $money * 1000;
            return $money;
        }
        if ($method == 2) {
            $money = $money * 1000000;
            return $money;
        }
    }

    /*
             * value: == 1 :hot
             * value  == 0 :unhot
             * published record
             */
    function home($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET show_in_home = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        // 	update sitemap
        if ($this->call_update_sitemap) {
            $this->call_update_sitemap();
        }

        return 0;
    }

    /*
     * value: == 1 :hot
     * value  == 0 :unhot
     * published record
     */
    function promotion($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET is_promotion = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        // 	update sitemap
        if ($this->call_update_sitemap) {
            $this->call_update_sitemap();
        }
        return 0;
    }

    function save_extend()
    {
        $row = array();

        $id = FSInput::get('note_id', 0, 'int');
        $val = FSInput::get('val');
        if (!$val)
            return;
        $foreign_id = FSInput::get('foreign_id', 0, 'int');
        if (!$foreign_id)
            return;

        $row ['name'] = $val;
        $row ['seo_title'] = $val;
        $row ['seo_keyword'] = $val;
        $row ['seo_description'] = $val;
        $row ['group_id'] = $foreign_id;
        $fsstring = FSFactory::getClass('FSString', '');
        $row ['alias'] = $fsstring->stringStandart($val);
        $maxOrdering = $this->getMaxOrderingExtend('fs_extends_items');
        $row ['ordering'] = $maxOrdering;
        $row ['published'] = 1;
        $time = date("Y-m-d H:i:s");
        $row ['created_time'] = $time;
        $row ['edited_time'] = $time;

        $rs = $this->_add($row, 'fs_extends_items', ' id = ' . $id);

        return $rs ? $id : 0;
    }

    /*
             * get Max value of Ordering field in table fs_categories
             */
    function getMaxOrderingExtend($foreign_tablename)
    {
        $query = " SELECT Max(a.ordering)
					 FROM " . $foreign_tablename . " AS a
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        if (!$result)
            return 1;
        return ($result + 1);
    }

    /*
     * value: == 1 :new
     * value  == 0 :unnew
     * published record
     */
    function is_new($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET is_new = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        // 	update sitemap
        if ($this->call_update_sitemap) {
            $this->call_update_sitemap();
        }
        return 0;
    }

    /*
     * value: == 1 :new
     * value  == 0 :unnew
     * published record
     */

    function change_ajax_stt($id, $value, $name)
    {
        global $db;
        $sql = " UPDATE " . $this->table_name . "
							SET $name = $value
						WHERE id = " . $id;
        $db->query($sql);
        $rows = $db->affected_rows();
        return $rows;
    }


    function is_hot($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET is_hot = $value
						WHERE id IN ( $str_ids ) ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
        // 	update sitemap
        if ($this->call_update_sitemap) {
            $this->call_update_sitemap();
        }
        return 0;
    }


    function getPagination($str_cat_id = null)
    {
        $total = $this->getTotal($str_cat_id);
        $pagination = new Pagination($this->limit, $total, $this->page);
        return $pagination;
    }

    /*
     * show total of models
     */
    function getTotal($str_cat_id)
    {
        global $db;
        $query = $this->setQuery($str_cat_id);
        $sql = $db->query($query);
        $total = $db->getTotal();
        return $total;
    }

    function get_data_by_color($color_id, $record_id)
    {
        global $db;
        if (!$color_id)
            return false;

        $query = " SELECT *
						FROM fs_products_price_colors
						WHERE color_id = " . $color_id . "
							AND record_id =" . $record_id;
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_data_by_size($size_id, $record_id)
    {
        global $db;
        if (!$size_id)
            return false;

        $query = " SELECT *
						FROM fs_products_price_sizes
						WHERE size_id = " . $size_id . "
							AND record_id =" . $record_id;
        $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    /**
     * Sửa thuộc tính của ảnh
     *
     * @return Bool
     */

    // ajax load quận/huyện (theo tỉnh thành))
    function ajax_get_product_district($city_id)
    {
        if (!$city_id)
            return;
        global $db;
        $query = ' SELECT id,name
						FROM fs_districts 
						WHERE city_id  = ' . $city_id;
        $sql = $db->query($query);
        $rs = $db->getObjectList();
        return $rs;
    }

    function save_products_images($record_id)
    {
        $this->_update(array(
            'record_id' => $record_id
        ), 'fs_products_images', 'session_id=\'' . session_id() . '\'');
    }

    function getExtendFieldsNew($category_id)
    {
        global $db;
        $where = '';
        if ($category_id) {
            $cat = $this->get_record('id=' . $category_id, 'fs_products_categories');
            if ($cat)
                $where = ' OR category_id IN(0' . $cat->list_parents . '0)';
        }
        $db->query('SELECT *
                    FROM fs_products_extend_fields
                    WHERE category_id=' . $category_id . $where . ' ORDER BY ordering ASC, id DESC');
        return $db->getObjectList();
    }

    function getExtendFieldsNew2($tablename)
    {
        global $db;
        if ($tablename == 'fs_products' || $tablename == '')
            return;

        $exist_table = $db->checkExistTable($tablename);
        if (!$exist_table) {
            Errors::setError(FSText::_('Table') . ' ' . $tablename . FSText::_(' is not exist'));
            return;
        }

        $cid = FSInput::get('cid');
        $query = " SELECT * 
						FROM fs_products_tables
						WHERE table_name =  '$tablename' 
						AND field_name <> 'id' and is_filter = 1
						ORDER BY ordering ASC ";
        $sql = $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function save_extension_new($category_id, $id)
    {
        $extend = $this->getExtendFieldsNew($category_id);
        if (!$extend || !$id)
            return false;
        $data_extends = array();
        foreach ($extend as $item) {
            switch ($item->field_type) {
                case 'multi_select':
                    $multi_select = FSInput::get($item->id . '_extend', array(), 'array');

                    $filter = '';
                    foreach ($multi_select as $ms)
                        $filter .= $item->id . '@' . $ms . ',';

                    if ($filter != '')
                        $filter = ',' . $filter;

                    $data_extends[$item->id] = array(
                        'filter' => $filter,
                        'value' => implode(',', $multi_select)
                    );
                    break;
                default:
                    $value = FSInput::get($item->id . '_extend', '');
                    $data_extends[$item->id] = array(
                        'filter' => ',' . $item->id . '@' . $value . ',',
                        'value' => $value
                    );
            }
        }
        $data_extends = serialize($data_extends);
        $this->_update(array(
            'data_extends' => $data_extends
        ), 'fs_products', 'id=' . intval($id));
    }

    function save_extension_new2($tablename, $id)
    {
        $extend = $this->getExtendFieldsNew2($tablename);
        if (!$extend || !$id)
            return false;
        $data_extends = array();
        $data_extends_column = array();
        foreach ($extend as $item) {
            switch ($item->field_type) {
                case 'foreign_multi':
                    $multi_select = FSInput::get($item->id . '_extend', array(), 'array');

                    $filter = '';
                    foreach ($multi_select as $ms)
                        $filter .= $item->id . '@' . $ms . ',';

                    if ($filter != '')
                        $filter = ',' . $filter;

                    $data_extends[$item->id] = array(
                        'filter' => $filter,
                        'value' => implode(',', $multi_select)
                    );
                    $data_extends_column[$item->field_name] = implode(',', $multi_select);
                    break;
                default:
                    $value = FSInput::get($item->id . '_extend', '');
                    $data_extends[$item->id] = array(
                        'filter' => ',' . $item->id . '@' . $value . ',',
                        'value' => $value
                    );
                    $data_extends_column[$item->field_name] =  $value;
            }
        }
        $data_extends = serialize($data_extends);
        $this->_update($data_extends_column,$tablename,'record_id=' . intval($id));
        $this->_update(array(
            'data_extends' => $data_extends
        ), 'fs_products', 'id=' . intval($id));
    }

    function get_store()
    {
        global $db;
        $sql = "SELECT *
                    FROM fs_address
                    WHERE published = 1 ORDER BY ordering ASC, id DESC";
        $db->query($sql);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree');
        $rs = $tree->indentRows2($result, 3);
        return $rs;
    }

    function save_redirect($id)
    {
        $alias = $this->get_record('id='.$id,'fs_products','id,alias')->alias;
        global $db;
        $id_redirect = $this->get_records('record_id = ' . $id . ' AND module = "products" AND view = "product" ORDER BY id DESC', 'fs_redirect');
        $alias_old = $id_redirect[0]->alias;
//        var_dump($id_redirect);die;
        if ($id_redirect && $alias_old == $alias) {
            $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'products', `view` = 'product' WHERE record_id = $id AND $alias_old == $alias AND `module` = 'products' AND `view` = 'product'";
            $db->affected_rows($query);
        } else {
            $query = "INSERT INTO fs_redirect (record_id,alias,old_alias,`module`,`view`) 
                      VALUE ($id,'$alias','$alias_old','products','product')";
            $db->insert($query);
        }
        return true;
    }

    function remove()
    {
        $id = FSInput::get('id', array(), 'array');

        foreach ($id as $item) {
            $this->_remove('record_id  = ' . $item . ' and `module` = "products" and `view` = "product" ', 'fs_redirect');
        }
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