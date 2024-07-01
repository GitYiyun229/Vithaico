<?php

class ProductsModelsClone_data extends FSModels
{
    var $limit;
    var $prefix;

    function __construct()
    {
        $this->limit = 10;
        $this->view = 'products';
        $this->table_name = 'fs_products_thuong_hieu';
        parent::__construct();
        $this->img_folder = 'images/' . $this->type . '/logo';
        $this->field_img = 'image';
        $this->arr_img_paths = array(array('resized', 200, 100, 'resize_image'));
        $this->arr_img_paths_other = array(
            array('large', 465, 440, 'resize_image'),
            array('resized', 180, 180, 'resize_image'),
            array('small', 47, 35, 'resize_image'));
    }

    function check_exist_product($name)
    {
        $exists_product = $this->get_record('name like "' . $name . '"', 'fs_products');
        if($exists_product){
            return $exists_product;
        }
        return null;
    }

    function add_product($data, $dataCommon)
    {
        try {
            $fsstring = FSFactory::getClass('FSString', '', '../');
            foreach ($data as $item) {
                $exists_product = $this->get_record('name like "' . $item['name'] . '"', 'fs_products');
                if($exists_product){
                    continue;
                }

                $row = [];
                $row['name'] = $item['name'];
                $row['code'] = $item['code'];
                $row['alias'] = $fsstring->stringStandart($row['name']);
                $row['price'] = (float)$item['price'];
                $row['price_old'] = (float)$item['price_old'];
                $row['diem_thuong'] = $item['price'] / 100;
                $row['diem_gop'] = 0;
                $row['size'] = 0;
//                $row['discount'] = (float)$item['discount'];
//                $row['discount_unit'] = 'percent';
                $row['quantity'] = 100;
                $row['count'] = 100;
//                $row['currency'] = 'VND';
                $row['published'] = 1;
                $row['tablename'] = 'fs_products';
                $row['updated_time'] = date('Y-m-d H:i:s');
                $row['created_time'] = date('Y-m-d H:i:s');
                $row['edited_time'] = date('Y-m-d H:i:s');
                $row['ordering'] = $this->get_max_ordering('fs_products');
//                $row['date_end'] = date('Y-m-d H:i:s', strtotime(date("Y-m-d", mktime()) . " + 365 day"));
                $row['weight'] = $this->get_max_ordering('fs_products');
//                $row['image'] = 1;

                //Thuong hieu
                $manufactory = $this->get_records('name like "%' . $item['thuong_hieu'] . '%"', 'fs_products_thuong_hieu', '*', '', '', '');
                if(empty($manufactory) || !isset($manufactory[0])){
                    $manufactory = $this->add_manufactories($item['thuong_hieu']);
                }
                $row['trademark_id'] = $manufactory[0]->id;
                $row['trademark_name'] = $manufactory[0]->name;
                $row['manufactory'] = $manufactory[0]->id;
                $row['manufactory_alias'] = $manufactory[0]->alias;
                $row['manufactory_name'] = $manufactory[0]->name;
                $row['manufactory_image'] = $manufactory[0]->image;

                //Other info
                $row['size_id'] = '';
                $row['tre_em'] = $dataCommon['tre_em'];
                $row['thanh_nien'] = $dataCommon['thanh_nien'];
                $row['nam'] = $dataCommon['nam'];
                $row['nu'] = $dataCommon['nu'];
                $row['ngay_le'] = $dataCommon['ngay_le'];
                $row['su_kien'] = $dataCommon['su_kien'];

                //Chuyen muc
//                if(strlen($item['category_id']) == 0){
                    $category_id = strlen($item['category_id']) > 0 ? $item['category_id'] : $dataCommon['category_common'];
                    $category = $this->get_record_by_id($category_id, 'fs_products_categories');
//                }
//                else {
//                    $category = $this->get_records('name like "%' . $item['chuyen_muc'] . '%"', 'fs_products_categories', '*', '', '1', '');
//                    if(empty($category)){
//                        $category = $this->add_category($item['chuyen_muc']);
//                    }
//                }
                $row['category_id'] = $category->id;
                $row['category_id_wrapper'] = $category->list_parents;
                $row['category_name'] = $category->name;
                $row['category_alias'] = $category->alias;
                $row['category_alias_wrapper'] = $category->alias_wrapper;
                $row['category_published'] = $category->published;

                $row['description'] = $item['description'];

                $item['category_name'] = $row['category_name'];
                $row['summary'] = self::get_summary($item) . $category->description;
                $gender = [
                    'BOY' => 1,
                    'GIRL' => 2,
                    'UNISEX' => 3,
                ];
                $row['sex'] = $gender[$item['gender']];

                //required fields
                $row['sale_count'] = 0;
                $row['seo_title'] = $item['name'];
                $row['seo_keyword'] = $category->name;

                $arr = explode(" ", $item['description']);
                $arr = array_splice($arr, 0, 30);
                $desc = implode($arr, ", ");
                $row['seo_description'] = $desc;
                $row['show_in_home'] = 0;
                $row['is_sell'] = 0;
                $row['is_hot'] = 0;
                $row['rating_count'] = 0;
                $row['rating_sum'] = 0;
                $row['is_new'] = 0;
                $row['like'] = 0;
                $row['show_in_home'] = 0;
                $row['user_full_name'] = 'admin';

                $pId = $this->_add($row, 'fs_products', 0);
                if($pId == 0){
                    throw new Exception('Lỗi thêm mới product!');
                }

                $item['product_id'] = $pId;
                $this->addImages($item);
            }

            return true;
        } catch (Exception $e){
            return false;
        }
    }

    function save_file($url, $savePath){
        set_time_limit(0); // unlimited max execution time
        $options = array(
            CURLOPT_FILE    => $savePath,
            CURLOPT_TIMEOUT =>  28800, // set this to 8 hours so we dont timeout on big files
            CURLOPT_URL     => $url,
        );

        $ch = curl_init();
        curl_setopt_array($ch, $options);
        curl_exec($ch);
        curl_close($ch);
    }

    function addImages($item)
    {
        ini_set("memory_limit","256M");
        try{
            $row['record_id'] = $item['product_id'];
            $row['title'] = $item['name'];

            if(isset($item['src_single'])){
                $size = getimagesize($item['src_single']);
                $ext = image_type_to_extension($size[2]);
                $file_name = '1_' . time() . $ext;

                $filePath = $this->uploadFile($item['src_single'], $file_name);
                $rowP['image'] = $filePath;
                $record = $this->_update($rowP, 'fs_products', 'id = ' . $item['product_id']);
            } else {
                $filePath = '';
                foreach($item['images'] as $k => $img){
                    $size2 = getimagesize($img['big']);
                    $time = ($k + 1) . '_' . rand(5, 100) . time();
                    $ext = image_type_to_extension($size2[2]);
                    $file_nameX = $time . ($k > 0 ?  '_1' : '') . $ext;
                    $filePathX = $this->uploadFile($img['big'], $file_nameX);
                    if($filePath == ''){
                        $filePath = $filePathX;
                    }
                    if($k > 0){
                        $row['image'] = $filePathX;
                        $record = $this->_add($row, 'fs_products_images');
                    }
                }
                $rowP['image'] = $filePath;
                $recordP = $this->_update($rowP, 'fs_products', 'id = ' . $item['product_id']);
            }
            return $record;
        } catch (Exception $e){
            return false;
        }
    }

    function uploadFile($srcFile, $file_name)
    {
        $cyear = date('Y');
        $cmonth = date('m');
        $cday = date('d');
        $pathOrigin = 'images' . DS . 'products' . DS . $cyear . DS . $cmonth . DS . $cday . DS . 'original' . DS;
        $descPathOrigin = PATH_BASE . $pathOrigin . $file_name;

        $imageContent = file_get_contents($srcFile);

        $this->create_folder(PATH_BASE . $pathOrigin);
        file_put_contents($descPathOrigin, $imageContent);

        foreach ($this->arr_img_paths_other as $item) {
            $path_resize = str_replace(DS . 'original' . DS, DS . $item [0] . DS, PATH_BASE . $pathOrigin);
            require_once(PATH_BASE . 'libraries' . DS . 'upload.php');
            $upload = new Upload();
            $this->create_folder(PATH_BASE . $path_resize);

            $method_resize = $item [3] ? $item [3] : 'resized_not_crop';
            $upload->$method_resize ($descPathOrigin, $path_resize . $file_name, $item [1], $item [2]);
        }
        return $pathOrigin . $file_name;
    }

    function create_folder($path, $chmod = '0777')
    {
        $path = str_replace('/', DS, $path);
        $folder_reduce = str_replace(PATH_BASE, '', $path);
        $arr_folder = explode(DS, $folder_reduce);

        if (!count($arr_folder))
            return;
        $folder_current = PATH_BASE;
        foreach ($arr_folder as $item) {
            $folder_current .= $item;
            if (!is_dir($folder_current)) {
                if (!mkdir($folder_current)) {
                    chmod($folder_current, $chmod);
                    return false;
                }
            }
            $folder_current .= DS;
        }
        return true;
    }

    function get_summary($item){
        $html = '
                <div class="btgrid">
                    <div class="row row-1">
                        <div class="col col-md-6">
                            <div class="content">
                                <p><span style="color:#0033cc;"><strong>* Thể loại:</strong></span> '. $item['category_name'] .'</p>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="content">
                                <p><span style="color:#0033cc;"><strong>* Giới tính:</strong>&nbsp;</span>'. $item['gender'] .'</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row row-2">
                        <div class="col col-md-6">
                            <div class="content">
                            <p><span style="color:#0033cc;"><strong>* Thương hiệu&nbsp;:</strong></span>'. $item['thuong_hieu'] .'</p>
                            </div>
                        </div>
                    
                        <div class="col col-md-6">
                            <div class="content">
                                <p><span style="color:#0033cc;"><strong>* Sử dụng:</strong>&nbsp;</span>Phù hợp với bé '. $item['age'] .'</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row row-3">
                    <div class="col col-md-6">
                            <div class="content">
                            <p><span style="color:#0033cc;"><strong>* Xuất xứ thương hiệu:&nbsp;</strong></span>'. $item['xuat_xu_thuong_hieu'] .'</p>
                            </div>
                        </div>
                        <div class="col col-md-6">
                            <div class="content">
                                <p><strong><span style="color:#003399;">* </span></strong><span style="color:#0033cc;"><strong>Chất liệu:</strong></span><strong>&nbsp;</strong>'. $item['chat_lieu'] .'</p>
                            </div>
                        </div>
                    </div>
                </div>';
        return $html;
    }

    function add_manufactories($name)
    {
        try{
            $row['name'] = $name;
            $fsstring = FSFactory::getClass('FSString', '', '../');
            $row['alias'] = $fsstring->stringStandart($name);
            $row['published'] = 1;
            $row['ordering'] = $this->get_max_ordering('fs_products_thuong_hieu');
            $row['updated_time'] = date('Y-m-d H:i:s');
            $row['created_time'] = date('Y-m-d H:i:s');

            $record_id = $this->_add($row, 'fs_products_thuong_hieu', 1);
            $record = $this->get_record_by_id($record_id, 'fs_products_thuong_hieu');

            return $record;
        } catch (Exception $e){
            return null;
        }
    }

    function add_category($name)
    {
        try {
            $fsstring = FSFactory::getClass('FSString', '', '../');
            $name = preg_replace('/[.*]+/i', '', $name);
            $name = $this->seems_utf8($name) ? $name : utf8_encode($name);

            $row = array();
            $row['name'] = $name;
            $row['alias'] = $fsstring->stringStandart($name);
            $row['parent_id'] = 0;
            $row['updated_time'] = date('Y-m-d H:i:s');
            $row['published'] = 1;
            $row['ordering'] = $this->get_max_ordering('fs_products_categories');
            $row['level'] = 0;
            $row['created_time'] = date('Y-m-d H:i:s');

            $record_id = $this->_add($row, 'fs_products_categories', 1);
            $record = $this->get_record_by_id($record_id, 'fs_products_categories');
            return $record;
        } catch (Exception $e){
            return null;
        }
    }

    function seems_utf8($str) {
        for ($i=0; $i<strlen($str); $i++) {
            if (ord($str[$i]) < 0x80) continue; # 0bbbbbbb
            elseif ((ord($str[$i]) & 0xE0) == 0xC0) $n=1; # 110bbbbb
            elseif ((ord($str[$i]) & 0xF0) == 0xE0) $n=2; # 1110bbbb
            elseif ((ord($str[$i]) & 0xF8) == 0xF0) $n=3; # 11110bbb
            elseif ((ord($str[$i]) & 0xFC) == 0xF8) $n=4; # 111110bb
            elseif ((ord($str[$i]) & 0xFE) == 0xFC) $n=5; # 1111110b
            else return false; # Does not match any model
            for ($j=0; $j<$n; $j++) { # n bytes matching 10bbbbbb follow ?
                if ((++$i == strlen($str)) || ((ord($str[$i]) & 0xC0) != 0x80))
                    return false;
            }
        }
        return true;
    }

    function update_parent($cid, $alias)
    {
        $record = $this->get_record_by_id($cid, 'fs_products_categories');
        if ($record->parent_id) {
            $parent = $this->get_record_by_id($record->parent_id, 'fs_products_categories');
            $list_parents = ',' . $cid . $parent->list_parents;
            $alias_wrapper = ',' . $alias . $parent->alias_wrapper;
        } else {
            $list_parents = ',' . $cid . ',';
            $alias_wrapper = ',' . $alias . ',';
        }
        $row['list_parents'] = $list_parents;
        $row['alias_wrapper'] = $alias_wrapper;

        // update table items
        // $id = FSInput::get('id',0,'int');
        // if($id){
        $row2['category_id_wrapper'] = $list_parents;
        $row2['category_alias'] = $record->alias;
        $row2['category_alias_wrapper'] = $alias_wrapper;
        $row2['category_name'] = $record->name;
        $row2['category_published'] = $record->published;
        $this->_update($row2, 'fs_products', ' category_id = ' . $cid . ' ');

        // update table categories : records have parent = this
        $this->update_categories_children($cid, 0, $list_parents, '', $alias_wrapper, $record->level);
        // }
        // change this record
        $rs = $this->record_update($row, $cid, 'fs_products_categories');
        // update sitemap
//			$this -> update_sitemap($cid,$this -> table_name,$this -> module);
        return $rs;
    }

    function update_categories_children($parent_id, $root_id, $list_parents, $root_alias, $alias_wrapper, $level)
    {
        if (!$parent_id)
            return;
        $query = ' SELECT * FROM fs_products_categories
						WHERE parent_id = ' . $parent_id;
        global $db;
        $db->query($query);
        $result = $db->getObjectList();
        if (!count($result))
            return;
        foreach ($result as $item) {

            $row3['list_parents'] = "," . $item->id . $list_parents;
            $row3['alias_wrapper'] = "," . $item->alias . $alias_wrapper;
            $row3['level'] = ($level + 1);
            if ($this->_update($row3, 'fs_products_categories', ' id = ' . $item->id . ' ')) {
                // update sitemap
//					$this -> update_sitemap($item -> id,$this -> table_name,$this -> module);

                // update table items owner this category
                $row2['category_id_wrapper'] = $row3['list_parents'];
                $row2['category_alias_wrapper'] = $row3['alias_wrapper'];
//					$row2['category_name'] =  $row3['name'];
                $this->_update($row2, 'fs_products', ' category_id = ' . $item->id . ' ');

                // đệ quy
//					$this -> update_categories_children($item -> id,$root_id,$row3['list_parents'],$root_alias,$row3['alias_wrapper'],$level);
            }
            $this->update_categories_children($item->id, $root_id, $row3['list_parents'], $root_alias, $row3['alias_wrapper'], $row3['level']);
        }
    }

    function get_max_ordering($tablename)
    {
        $query = " SELECT Max(a.ordering)
					 FROM " . $tablename . " AS a
					";
        global $db;
        $sql = $db->query($query);
        $result = $db->getResult();
        if (!$result)
            return 1;
        return ($result + 1);
    }

    function get_categories()
    {
        return $this->get_records('', 'fs_products_categories', '*', '', '', 'id');
    }

    function syn_products()
    {
        $root = 136;
        $table_extend = 'fs_products_accessories';

//===============
        //product_cat => Ok
        //brandId => Ok
        //meta_description: xóa kí tự xuống dòng , kí tự tròn và ô vuông( VD: 2039) => OK

        // image, => Ok
        // manufactories_,origin_, => Ok
        // tags(idv_sell_product_info) => ok
        // fs_products_... (extend)

        // hasVas(idv_sell_product_info)
        $arr_syn = array(
            'goods_id' => 'id',
            'goods_sn' => 'code',
            'goods_name' => 'name',
//				  'url'=>'alias',
            'click_count' => 'hits',
            'shop_price' => 'price_old',
            'warn_number' => 'warranty_time',
            'goods_brief' => 'promotion_info',
            'goods_desc' => 'description',
            'add_time' => 'created_time',
            'last_update' => 'edited_time',
//				  'warranty'=>'warranty_time',
//				  'meta_title'=>'seo_title',
            'keywords' => 'seo_keyword',
//				  'quantity'=>'quantity',
            'is_real' => 'published',
//				  'spec'=>'specification',
//				  'meta_description'=>'seo_description',
        );
        $fsstring = FSFactory::getClass('FSString', '', '../');
        $array_new_cat = $this->get_records('', 'fs_products_categories', '*', '', '', 'id');

//			$array_new_manufactories = $this -> get_records(' tablenames LIKE "%,'.$table_extend.',%"','fs_manufactories','*','','','old_id');
        $array_new_manufactories = $this->get_records('', 'fs_manufactories', '*', '', '', 'old_id');
//			$array_new_origin = $this -> get_records('','fs_origin','*','','','id');

        // remote db
        include_once 'remote_db.php';
        $remote_db = new Remote_db();
        $select = ' SELECT * FROM ecs_goods ';
        $sql = $remote_db->query($select);
        // get child_id
//			$select = ' select childListId  FROM idv_seller_category where id = '.$root;
//			$sql = $remote_db->query($select);
//			$list_id_root = $remote_db->getResult();

        // danh sách sp trong root
        $select = ' select a.*
				 from ecs_goods 	AS a
					ORDER BY a.goods_id ASC
			';
        $sql = $remote_db->query($select);
        $list_remote = $remote_db->getObjectList();
        for ($i = 0; $i < count($list_remote); $i++) {
            $row = array();
            $item_r = $list_remote[$i];
            if ($item_r->cat_id == 84 || $item_r->cat_id == 101 || $item_r->cat_id == 102 || $item_r->cat_id == 103 || $item_r->cat_id == 106 || $item_r->cat_id == 84 || $item_r->cat_id == 108 || $item_r->cat_id == 84 || $item_r->cat_id == 109 || $item_r->cat_id == 110 || $item_r->cat_id == 111 || $item_r->cat_id == 112 || $item_r->cat_id == 117 || $item_r->cat_id == 118 || $item_r->cat_id == 118 || $item_r->cat_id == 120 || $item_r->cat_id == 121 || $item_r->cat_id == 122 || $item_r->cat_id == 123 || $item_r->cat_id == 124 || $item_r->cat_id == 125 || $item_r->cat_id == 126 || $item_r->cat_id == 128 || $item_r->cat_id == 129 || $item_r->cat_id == 131 || $item_r->cat_id == 133 || $item_r->cat_id == 134 || $item_r->cat_id == 136) {
                $row['alias'] = $fsstring->stringStandart($item_r->goods_name);
                foreach ($arr_syn as $field_old => $field_new) {
                    if ($field_new == 'created_time' || $field_new == 'edited_time') {
                        $row[$field_new] = date("Y-m-d H:i:s", $item_r->$field_old);
                    } else {
                        $row[$field_new] = $item_r->$field_old;
                    }
                }
                $row['tablename'] = $table_extend;

                //price
                $price_old = $item_r->shop_price;
                if ($price_old > 30000000) {
                    $price_old = 0;
                }
                $discount = '';
                $discount_unit = '';
                if ($discount_unit == 'percent') {
                    if ($discount > 100 || $discount < 0) {
                        $row ['price_old'] = $price_old;
                        $row ['price'] = $price_old;
                        $row ['discount'] = 0;

                    } else {
                        $row ['price_old'] = $price_old;
                        $row ['discount'] = $discount;
                        $row ['price'] = $price_old * (100 - $discount) / 100;
                    }

                } else {
                    if ($discount > $price_old || $discount < 0) {
                        $row ['price_old'] = $price_old;
                        $row ['price'] = $price_old;
                        $row ['discount'] = 0;
                    } else {
                        $row ['price_old'] = $price_old;
                        $row ['discount'] = $discount;
                        $row ['price'] = $price_old - $discount;
                    }
                }
                $cat = $array_new_cat[$root];
                $row['category_id'] = $cat->id;
                $row['category_id_wrapper'] = $cat->list_parents;
                $row['category_root_alias'] = $cat->root_alias;
                $row['category_name'] = $cat->name;
                $row['category_alias'] = $cat->alias;
                $row['category_alias_wrapper'] = $cat->alias_wrapper;
                $row ['category_published'] = $cat->published;
                $row['show_in_homepage'] = $cat->show_in_homepage;

                // manufactory
                $brandId = $item_r->brand_id;
                $manufactory = $array_new_manufactories[$brandId];
                $row['manufactory'] = $manufactory->id;
                $row['manufactory_alias'] = $manufactory->alias;
                $row['manufactory_name'] = $manufactory->name;
                $row['ordering'] = $i + 1;
                $row ['quantity'] = 10;

                // image
                if ($item_r->goods_img) {
                    $row['image'] = $this->get_main_image($item_r->goods_img);
                }
                $exist = $this->check_exist($item_r->goods_id, 0, 'id', 'fs_products');
                if ($exist) {
                    $this->_update($row, 'fs_products', 'id=' . $item_r->goods_id, 1);
                    $this->save_extension($table_extend, $item_r->goods_id);
                } else {
                    $rs = $this->_add($row, 'fs_products', 1);
                    $this->save_extension($table_extend, $item_r->goods_id);
                }
            }
        }
    }

    function syn_products_update()
    {
//			$root = 136;
//			$table_extend = 'fs_products_accessories';

//			$root = 138;
//			$table_extend = 'fs_products_advice';

//			$root = 137;
//			$table_extend = 'fs_products_tablet';

        $root = 135;
        $table_extend = 'fs_products_phone';

        $arr_syn = array(
            'goods_id' => 'id',
        );
        $fsstring = FSFactory::getClass('FSString', '', '../');
        $array_new_cat = $this->get_records('', 'fs_products_categories', '*', '', '', 'id');

        $array_new_manufactories = $this->get_records('', 'fs_manufactories', '*', '', '', 'old_id');

        // remote db
        include_once 'remote_db.php';
        $remote_db = new Remote_db();
        $select = ' SELECT * FROM ecs_goods ';
        $sql = $remote_db->query($select);

        // danh sách sp trong root
        $select = ' select a.*
				 from ecs_goods 	AS a
					ORDER BY a.goods_id ASC
			';
        $sql = $remote_db->query($select);
        $list_remote = $remote_db->getObjectList();
        for ($i = 0; $i < count($list_remote); $i++) {
            $row = array();
            $item_r = $list_remote[$i];
            switch ($item_r->cat_id) {
                //fs_products_accessories
//					case 77:
//					case 84:
//					case 117:
//					case 118:
//					case 119:
//					case 121:
//					case 122:
//					case 129:
//					case 130:
//					case 131:
//					case 133:
//					case 134:
                //fs_products_advice
//					case 101:
//					case 102:
//					case 103:
//					case 106:
//					case 107:
//					case 108:
//					case 109:
//					case 110:
//					case 111:
//					case 112:
//					case 113:
//					case 114:
//					case 115:
//					case 116:
//					case 123:
//					case 136:
                //fs_products_tablet
//					case 99:
                //fs_products_phone
                case 1:
                case 36:
                case 41:
                case 44:
                case 46:
                case 63:
                case 64:
                case 75:
                case 93:
                case 94:
                case 95:
                case 97:
                case 98:
                case 100:
                case 120:
                case 124:
                case 125:
                case 126:
                case 128:
                case 135:

                    foreach ($arr_syn as $field_old => $field_new) {
                        $row[$field_new] = $item_r->$field_old;
                    }
                    $row['tablename'] = $table_extend;

                    $cat = $array_new_cat[$root];
                    $row['category_id'] = $cat->id;
                    $row['category_id_wrapper'] = $cat->list_parents;
                    $row['category_root_alias'] = $cat->root_alias;
                    $row['category_name'] = $cat->name;
                    $row['category_alias'] = $cat->alias;
                    $row['category_alias_wrapper'] = $cat->alias_wrapper;
                    $row ['category_published'] = $cat->published;
                    $row['show_in_homepage'] = $cat->show_in_homepage;

                    $exist = $this->check_exist($item_r->goods_id, 0, 'id', 'fs_products');
                    if ($exist) {
                        $this->_update($row, 'fs_products', 'id=' . $item_r->goods_id, 1);
                        $this->save_extension($table_extend, $item_r->goods_id);
                    }
                    break;
            }
        }
    }

}

?>