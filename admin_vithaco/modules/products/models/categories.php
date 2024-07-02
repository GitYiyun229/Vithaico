<?php

class ProductsModelsCategories extends ModelsCategories
{
    var $limit;
    var $prefix;

    function __construct()
    {
        parent::__construct();
        $limit = FSInput::get('limit', 200, 'int');
        $this->limit = $limit;
        $this->type = 'products';
        $this->table_items = FSTable_ad::_('fs_' . $this->type);
        $this->table_name = FSTable_ad::_('fs_' . $this->type . '_categories');
        $this->table_name_table = FSTable_ad::_('fs_' . $this->type . '_tables');
        $this->check_alias = 1;
        $this->call_update_sitemap = 0;
        $this->img_folder = 'images/' . $this->type . '/cat';
        $this->field_img = 'image';
        $this->table_images = 'products_categories';
        $this->arr_img_paths = array(
            array('small', 16, 16, 'resize_image_fix_height_webp'),
            array('resized', 80, 80, 'resize_image_fix_height_webp'),
            array('large', 160, 160, 'resize_image_fix_height_webp')
        );
        $this->arr_img_paths_icon = array(
            array('small', 16, 16, 'resize_image_fix_height_webp'),
            array('resized', 80, 80, 'resize_image_fix_height_webp'),
            array('large', 160, 160, 'resize_image_fix_height_webp')
        );

        $this->field_except_when_duplicate = array(
            array('list_parents', 'id'),
            array('alias_wrapper', 'alias')
        );

    }

    /*
     * Show list category of product follow page
     */
    function get_categories_tree()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        $limit = $this->limit;
        $page = $this->page ? $this->page : 1;

        $start = $limit * ($page - 1);
        $end = $start + $limit;

        $list_new = array();
        $i = 0;
        foreach ($list as $row) {
            if ($i >= $start && $i < $end) {
                $list_new[] = $row;
            }
            $i++;
            if ($i > $end)
                break;
        }
        return $list_new;
    }

    /*
     * Select all list category of product
     */
    function get_categories_tree_all()
    {
        global $db;
        $query = $this->setQuery();
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);

        return $list;
    }

    function setQuery()
    {

        // ordering
        $ordering = "";
        $task = FSInput::get('task');
        if (isset($_SESSION[$this->prefix . 'sort_field'])) {
            $sort_field = $_SESSION[$this->prefix . 'sort_field'];
            $sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
            $sort_direct = $sort_direct ? $sort_direct : 'asc';
            $ordering = '';
            if ($sort_field)
                $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";

        }

        if (!$ordering)
            $ordering .= " ORDER BY created_time DESC , id DESC ";

        $where = "  ";
        if (isset($_SESSION[$this->prefix . 'filter0'])) {
            $filter = $_SESSION[$this->prefix . 'filter0'];
            if ($filter == 2) {
                $where .= ' AND a.published = 0 ';
            } else if ($filter == 0) {
                $where .= '';
            } else {
                $where .= ' AND a.published = ' . $filter . ' ';
            }
        }

        if (isset($_SESSION[$this->prefix . 'filter1'])) {
            $filter = $_SESSION[$this->prefix . 'filter1'];
            if ($filter) {
                $where .= ' AND a.list_parents like  "%,' . $filter . ',%" ';
            }
        }

        if (isset($_SESSION[$this->prefix . 'keysearch'])) {
            if ($_SESSION[$this->prefix . 'keysearch'] && $task != 'edit' && $task != 'add') {
                $keysearch = $_SESSION[$this->prefix . 'keysearch'];
                $where .= " AND name LIKE '%" . $keysearch . "%' OR alias LIKE '%" . $keysearch . "%' ";
            }
        }

        $query = " SELECT a.*, a.parent_id as parent_id 
						  FROM 
						  	" . $this->table_name . " AS a
						  	WHERE 1=1" .
            $where .
            $ordering . " ";
        //echo $query;
        return $query;
    }

    function get_categories_level0()
    {
        global $db;
        $query = ' SELECT *
                        FROM ' . $this->table_name . ' 
                        WHERE published   = 1  AND level = 0 ';
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_tablenames()
    {
        $query = " 	   SELECT DISTINCT(a.table_name) 
						  FROM $this->table_name_table AS a 
						 ";
        global $db;
        $db->query($query);
        $list = $db->getObjectList();
        $list = array_merge(array(0 => (object)array('table_name' => FSTable_ad::_('fs_products'))), $list);
        return $list;
    }

    function save($row = array(), $use_mysql_real_escape_string = 0)
    {
        $id = FSInput::get('id', 0, 'int');
        $title = FSInput::get('name');

        $cat = $this->get_record_by_id($id);
        $vat = FSInput::get('vat');
        $tablename = FSInput::get('tablename');

//        $arr_warranty_id = FSInput::get('warranty', array(), 'array');
//        $str_warranty_id = implode(',', $arr_warranty_id);
//        $row ['warranty'] = ',' . $str_warranty_id . ',';
        // $image_name_image = $_FILES["image"]["name"];
        // if (($image_name_image)) {
        //     $image = $this->upload_image('image', '_' . time(), 5000000, $this->arr_img_paths);
        //     if ($image) {
        //         $row['image'] = $image;
        //     }
        // }

        $image_name_icon = $_FILES["icon"]["name"];
        if ($image_name_icon) {
            $image_icon = $this->upload_image('icon', '_' . time(), 5000000, $this->arr_img_paths);
            if ($image_icon) {
                $row['icon'] = $image_icon;
            }
        }

        $image_name_icon_hover = $_FILES["icon_hover"]["name"];
        if ($image_name_icon_hover) {
            $image_icon_hover = $this->upload_image('icon_hover', '_' . time(), 5000000, $this->arr_img_paths);
            if ($image_icon_hover) {
                $row['icon_hover'] = $image_icon_hover;
            }
        }

        // $image_name_logo = $_FILES["logo"]["name"];
        // if ($image_name_logo) {
        //     $image_logo = $this->upload_image('logo', '_' . time(), 5000000, '');
        //     if ($image_logo) {
        //         $row['logo'] = $image_logo;
        //     }
        // }


        $range = FSInput::get('price', array(), 'array');
        $str_range = implode(',', $range);
        if ($str_range) {
            $str_range = ',' . $str_range . ',';
        }
        $row['price'] = $str_range;

        $multi_cat = FSInput::get('multi_parent', array(), 'array');
        $str_multi_cat = implode(',', $multi_cat);
        if ($str_multi_cat) {
            $str_multi_cat = ',' . $str_multi_cat . ',';
        }
        $row['multi_parent'] = $str_multi_cat;

        $inheritance_perent_table = FSInput::get('inheritance_perent_table', 0, 'int');
        $tbl_name = '';
        if (!$inheritance_perent_table) {
            $tbl_name = FSInput::get('tablename');
            if (!$tbl_name) {
                $tbl_name = '';
            } else {
                $fsstring = FSFactory::getClass('FSString', '', '../');
                $tbl_name = $fsstring->stringStandart($tbl_name);
            }
        }
        // parent
        $parent_id = FSInput::get('parent_id');

        if (@$parent_id) {
            $parent = $this->get_record_by_id($parent_id, $this->table_name);
            $parent_level = $parent->level ? $parent->level : 0;
            $level = $parent_level + 1;
            if ($inheritance_perent_table) {
                $tbl_name = $parent->tablename;
            }
        } else {
            $level = 0;
        }

        if ($tbl_name) {
            $this->createProductTbl($tbl_name);

            $row['tablename'] = $tbl_name;
//            var_dump($row['tablename']);die;
        }

//        $fsstring = FSFactory::getClass('FSString', '', '../');
//        $alias = $fsstring->stringStandart($title);
//
//        $row['alias'] = FSInput::get('alias') ? FSInput::get('alias') : $alias;
//        if($id) {
//            $alias = $row['alias'];
//        }
//        $check_alias = $this->check_exist_alias_redirect($id,$alias);
//        if($check_alias){
//            Errors::_('Alias của bạn đã bị trùng tên','alert');
//            $row['alias'] = $this -> genarate_alias_news($row['alias'],$id);
//        }

        $news_related = $color = FSInput::get('news_record_related', array(), 'array');
        $str_news_related = implode(',', $news_related);
        if ($str_news_related) {
            $str_news_related = ',' . $str_news_related . ',';
        }
        $row ['news_related'] = $str_news_related;

        $products_order = $color = FSInput::get('products_record_order', array(), 'array');
        $str_products_order = implode(',', $products_order);
        if ($str_products_order) {
            $str_products_order = $str_products_order;
        }
        $row ['products_order'] = $str_products_order;

        // $row ['landing_product'] = FSInput::get('');
        $rid = parent::save($row);
        $this->save_redirect($rid);

        if ($tablename) {
            $this->update_table_extend($rid, $tablename);
            $row['tablename'] = $tablename;
            $this->_update($row, $this->table_itemsm, ' category_id = ' . $rid);
        }
        if (!empty($rid)) {
            $this->savePriceByCity($rid);
        }

        return $rid;
    }

    function savePriceByCity($rid)
    {
//        $cities = $this->get_list_city();
        $cat = $this->get_record('id = ' . $rid, 'fs_products_categories', 'list_parents')->list_parents;

        $arr_cat = explode(',', trim($cat, ','));
        $index = array_search($rid, $arr_cat);
        $city = FSInput::get('city_price', array(), 'array');
//        $calculate_price = FSInput::get('calculate_price', array(), 'array');
        $price_city = FSInput::get('price_city', array(), 'array');
        $priceByCity = array();
        for ($i = 0; $i < count($city); $i++) {
            $city_name = $this->get_record('city_id = ' . $city[$i], 'fs_address', 'city_name')->city_name;
            $priceByCity[$city[$i]] = (object)[
                'city_id' => (int)$city[$i],
                'city_name' => $city_name,
                'price' => (int)$this->standart_money($price_city[$i], 0),
            ];
        }
        $priceByCity = json_encode($priceByCity, JSON_UNESCAPED_UNICODE);
        foreach ($arr_cat as $key => $value){
            $catById = $this->get_record('id = ' . $value, 'fs_products_categories', 'price_by_city')->price_by_city;
            if (empty($catById) || $value == $rid){
                $this->_update(['price_by_city' => $priceByCity], 'fs_products_categories', 'id = ' . $rid, 0);
            }
            if ($key == $index){
                break;
            }
        }
        return true;
    }

    function update_table_extend($cid, $tablename)
    {

        $record = $this->get_record_by_id($cid, $this->table_name);
        $alias = $record->alias;
        if ($record->parent_id) {
            $parent = $this->get_record_by_id($record->parent_id, $this->table_name);
            $list_parents = ',' . $cid . $parent->list_parents;
            $alias_wrapper = ',' . $alias . $parent->alias_wrapper;
        } else {
            $list_parents = ',' . $cid . ',';
            $alias_wrapper = ',' . $alias . ',';
        }

        // update table items
        $id = FSInput::get('id', 0, 'int');
        if ($id) {
            $row2['category_id_wrapper'] = $list_parents;
            $row2['category_alias'] = $record->alias;
            $row2['category_alias_wrapper'] = $alias_wrapper;
            $row2['category_name'] = $record->name;
            $row2['category_published'] = $record->published;
            $this->_update($row2, $tablename, ' category_id = ' . $cid . ' ');
        }
    }

    function published($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            foreach ($ids as $id) {
                $record = $this->get_record_by_id($id, $this->table_name);
                $tablename = $record->tablename;
                $sql = " UPDATE " . $tablename . "
								SET category_published = $value
							WHERE category_id IN ( $id ) ";
                $db->query($sql);
                $result = $db->getResult();
            }
        }
        return parent::published($value);
    }

    /*
     * value: == 1 :new
     * value  == 0 :unnew
     * published record
     */
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

    /*
     * value: == 1 :new
     * value  == 0 :unnew
     * published record
     */
    function is_menu($value)
    {
        $ids = FSInput::get('id', array(), 'array');

        if (count($ids)) {
            global $db;
            $str_ids = implode(',', $ids);
            $sql = " UPDATE " . $this->table_name . "
							SET is_menu = $value
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

    function get_size()
    {
        $where = '';


        global $db;
        $query = ' SELECT id,name
							FROM fs_products_sizes 
							WHERE published   = 1 
							 ' . $where . '	OR tablenames="" ';
        $sql = $db->query($query);
        $alias = $db->getObjectList();

        return $alias;
    }

    function get_trademark()
    {
        global $db;
        $query = " SELECT a.*
						  FROM fs_products_thuong_hieu AS a
						  	WHERE published = 1 ORDER BY ordering ";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function upload_other_images()
    {
        $module = FSInput::get('module');
        global $db;
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');

        $path = PATH_BASE . 'images' . DS . $module . '_categories' . DS . $cyear . DS . $cmonth . DS . $cday . DS . 'original' . DS;
        require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
        $upload = new  Upload();
        $upload->create_folder($path);
        $file_type = explode('/', $_FILES['file']['type'])[0];
        if ($file_type == 'video')
            $file_name = $upload->uploadFile('file', $path, 60000000, '_' . time());
        else
            $file_name = $upload->uploadImage('file', $path, 10000000, '_' . time());

        $img_link = $path . $file_name;    
        if (is_string($file_name) and $file_name != '' and !empty($this->arr_banner_slide_paths_other) and $file_type != 'video') {
            foreach ($this->arr_banner_slide_paths_other as $item) {
                $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, $path);
                $upload->create_folder($path_resize);
                // $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
                // $upload->$method_resize ($path . $file_name, $path_resize . $file_name, $item [1], $item [2]);
                if ($_FILES['file']["type"] != 'image/svg+xml') { 
					$method_resize = $item[3] ? $item[3] : 'resized_not_crop'; 
					if (!$fsFile->$method_resize($path . $file_name, $path_resize . $file_name, $item[1], $item[2]))
						return "Không tạo được ảnh resize. Vui lòng thử lại";
				} else {  
					copy(PATH_BASE . '/'.$img_link, PATH_BASE . str_replace('/original/', "/$item[0]/", '/'.$img_link)); 
				}
            }
        }
        $data = base64_decode(FSInput::get('data'));
        $data = explode('|', $data);
        $row = array();
        if ($data[0] == 'add')
            $row['session_id'] = $data[1];
        else
            $row['record_id'] = $data[1];
        $row['image'] = 'images/' . $module . '_categories/' . $cyear . '/' . $cmonth . '/' . $cday . '/' . 'original' . '/' . $file_name;
        $row['title'] = $_FILES['file']['name'];
        $row['file_type'] = $file_type;

        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_' . $module . '_categories_images');

        $rs = $this->_add($row, $tablename);
        echo $rs;
        return $rs;
    }

    function delete_other_image($record_id = 0)
    {
        $reocord_id = FSInput::get('reocord_id', 0, 'int');
        $file_name = FSInput::get('name');
        $id = FSInput::get('id');

        $module = FSInput::get('module');
        global $db;

        $where = '';
        if ($file_name) {
            $where .= ' AND title = \'' . $file_name . '\'';
        } else {
            $where .= ' AND id = ' . $id;
        }

        if ($reocord_id) {
            $where .= ' AND record_id = ' . $reocord_id;
        }
        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_' . $module . '_categories_images');

        $query = '  SELECT *
                        FROM ' . $tablename . '
                        WHERE  1 = 1 ' . $where;
        $db->query($query);
        $images = $db->getObject();
        if ($images) {
            echo $query = '  DELETE FROM ' . $tablename . '
                                WHERE id = \'' . $images->id . '\'';
            $db->query($query);
            $path = PATH_BASE . $images->image;
            @unlink($path);
            foreach ($this->arr_img_paths_other as $image) {
                @unlink(str_replace('/original/', '/' . $image[0] . '/', $path));
            }
        }
    }

    function sort_other_images()
    {
        $module = FSInput::get('module');
        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_' . $module . '_categories_images');

        global $db;
        if (isset($_POST["sort"])) {
            if (is_array($_POST["sort"])) {
                foreach ($_POST["sort"] as $key => $value) {
                    $db->query("UPDATE " . $tablename . " SET ordering = $key WHERE id = $value");
                }
            }
        }
    }

    function get_range_price()
    {
        global $db;
        $sql = "SELECT *
                    FROM fs_products_filter_price
                    WHERE published = 1 ORDER BY ordering ASC, id DESC";
        $db->query($sql);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree');
        $rs = $tree->indentRows2($result);
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

    function save_redirect($id)
    {
        $alias = $this->get_record('id=' . $id, 'fs_products_categories', 'id,alias')->alias;
        $id_redirect = $this->get_records('record_id = ' . $id . ' AND module = "products" AND view = "cat" ORDER BY id DESC', 'fs_redirect');
        $alias_old = $id_redirect[0]->alias;
        global $db;
        if ($id_redirect && $alias_old == $alias) {
            $query = "UPDATE fs_redirect set record_id = $id, alias = '$alias', `module` = 'products', `view` = 'cat' WHERE record_id = $id AND $alias_old == $alias AND `module` = 'products' AND `view` = 'cat'";
            $db->affected_rows($query);
        } else {
            $query = "INSERT INTO fs_redirect (record_id,alias,old_alias,`module`,`view`) 
                      VALUE ($id,'$alias','$alias_old','products','cat')";
            $db->insert($query);
        }

        return true;
    }

    function remove()
    {
        $id = FSInput::get('id', array(), 'array');

        // foreach ($id as $item){
        //     $this -> _remove('record_id  = '.$item .' and `module` = "products" and `view` = "cat" ','fs_redirect');
        // }
        $rs = parent::remove();
        return $rs;
    }

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

    function get_list_images($id)
    {
        if ($id)
            $uploadConfig = base64_encode('edit|' . $id);
        else
            $uploadConfig = base64_encode('add|' . session_id());
        $data = base64_decode($uploadConfig);
        $data = explode('|', $data);
        $where = '';
        if ($data[0] == 'add')
            $where = 'session_id = \'' . $data[1] . '\'';
        else
            $where = 'record_id = ' . $data[1];

        global $db;
        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_products_categories_images');

        $query = '  SELECT *
                    FROM ' . $tablename . ' 
                    WHERE ' . $where . '
                    ORDER BY ordering, id DESC';
        $sql = $db->query($query);
        return $db->getObjectList();
    }

    function get_list_videos($id)
    {
        if ($id)
            $uploadConfig = base64_encode('edit|' . $id);
        else
            $uploadConfig = base64_encode('add|' . session_id());
        $data = base64_decode($uploadConfig);
        $data = explode('|', $data);
        $where = '';
        if ($data[0] == 'add')
            $where = 'session_id = \'' . $data[1] . '\'';
        else
            $where = 'record_id = ' . $data[1];

        global $db;
        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_products_categories_videos_images');

        $query = '  SELECT *
                    FROM ' . $tablename . ' 
                    WHERE ' . $where . '
                    ORDER BY ordering, id DESC';
        $sql = $db->query($query);
        return $db->getObjectList();
    }

    function ajax_get_landing_product($page, $search, $id)
    {
        global $db;
        $where = '';
        if ($search)
            $where = " and name like '%$search%'";
        $limit = $page * 10; // limit 10
        $offset = ($page - 1) * $limit;
        $query = "  SELECT *
			FROM fs_products 
            WHERE published = 1 " . $where . " and status_prd < 4 and (category_id_wrapper like '%," . $id . ",%' or multi_categories like '%," . $id . ",%') 
            LIMIT $limit OFFSET $offset
			";
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_products_categories_tree()
    {
        global $db;
        $sql = " SELECT id, name, parent_id AS parent_id 
				FROM fs_products_categories";
        $db->query($sql);
        $categories = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $rs = $tree->indentRows($categories, 1);
        return $rs;
    }


    function ajax_get_products_order()
    {
        $category_id = FSInput::get('category_id', 0, 'int');
        $keyword = FSInput::get('keyword');
        $where = ' WHERE published = 1 ';
        if ($category_id) {
            $where .= ' AND (category_id_wrapper LIKE "%,' . $category_id . ',%" or	multi_categories LIKE "%,' . $category_id . ',%" ) ';
        }
        $where .= " AND ( name LIKE '%" . $keyword . "%' OR alias LIKE '%" . $keyword . "%' )";

        $query_body = ' FROM fs_products ' . $where;
        $ordering = " ORDER BY created_time DESC , id DESC ";
        $query = ' SELECT id,quantity,category_id,name,category_name,image ' . $query_body . $ordering . ' LIMIT 40 ';
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_products_order($str_products)
    {
        if (!$str_products)
            return;
        $query = " SELECT id, name, image,quantity
					FROM fs_products
					WHERE id IN (" . $str_products . ") 
					 ORDER BY POSITION(','+id+',' IN '" . $str_products . "')
					";
        global $db;
        $sql = $db->query($query);


        $result = $db->getObjectList();
        return $result;
    }

    function get_list_city()
    {
        global $db;
        $sql = "SELECT city_id,city_name FROM fs_address WHERE published = 1 GROUP BY city_id  ORDER BY ordering asc ";
        $db->query($sql);
        return $db->getObjectList();
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

}
