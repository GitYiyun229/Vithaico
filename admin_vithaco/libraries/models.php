<?php
class FSModels
{
	var $module;
	var $view;
	var $limit;
	var $page;
	var $table_name;
	var $prefix;
	var $arr_img_paths;
	var $img_folder;
	var $field_img;
	var $field_width;
	var $check_alias;
	var $call_update_sitemap;
	var $field_except_when_duplicate; // this field is updated auto follow other field ( not update by REQUEST ). Example : list_parents
	var $field_reset_when_duplicate; // các trường không duplicate VD: hits,.... định dạng: array('hits','comments_unread',...)
	var $table_name_category;
	var $table_category_name;
	var $arr_img_paths_other;
	// đồng bộ dữ liệu ngoài bảng extend. Viết dang  array(tablename => array(field1_curent => field1_remote, field2_curent =>field2_remote,...)): 
	//trường 1 dùng để so sánh với id của dữ liêu
	var $array_synchronize = array();
	var $use_table_extend;  // use table extend. Example: fs_products_mobile
	var $type;  // ex: products, pharmacology
	var $calculate_filters;  // 1: calculate filters
	var $module_params;  // 
	var $image_watermark = array();

	function __construct()
	{
		$module = FSInput::get('module');
		$view = FSInput::get('view', $module);
		$this->module = $module;
		$this->view = $view;

		$page = FSInput::get('page', 0, 'int');
		$this->page = $page;

		$limit = FSInput::get('limit', 20, 'int');
		$limit = $limit ? $limit : 20;
		$this->limit = $limit;
		$prefix = $this->module . '_' . $this->view . '_';
		$this->prefix = $prefix;
		//			$this -> arr_img_paths = array();
		//			$this -> img_folder = '';
		$this->load_params();
	}

	/*
		 * Lấy tham số từ bảng module_config để cấu hình cho từng module
		 */
	function load_params()
	{
	}

	function get_data($value)
	{
		$value = $value ? $value : '';
		global $db;
		$query = $this->setQuery($value);
		if (!$query)
			return array();
		//			echo $query;
		$sql = $db->query_limit($query, $this->limit, $this->page);
		$result = $db->getObjectList();
		return $result;
	}
	function setQuery()
	{
		$field_search = 'name';
		// ordering
		$ordering = "";
		if (isset($_SESSION[$this->prefix . 'sort_field'])) {
			$sort_field = $_SESSION[$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
			$sort_direct = $sort_direct ? $sort_direct : 'asc';
			$ordering = '';
			if ($sort_field)
				$ordering .= " ORDER BY $sort_field $sort_direct, id DESC ,created_time DESC ";
		}
		if (!$ordering)
			$ordering .= " ORDER BY  id DESC, created_time DESC ";

		$where = "  ";

		if (isset($_SESSION[$this->prefix . 'keysearch'])) {
			if ($_SESSION[$this->prefix . 'keysearch']) {
				$keysearch = $_SESSION[$this->prefix . 'keysearch'];
				$where .= " AND " . $field_search . " LIKE '%" . $keysearch . "%' ";
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
	/*
		 * show total of models
		 */
	function getTotal($value)
	{
		$value = $value ? $value : '';
		global $db;
		$query = $this->setQuery($value);
		$total = $db->getTotal($query);
		return $total;
	}

	function getPagination($value = '')
	{
		$value = $value ? $value : '';
		$total = $this->getTotal($value);
		$pagination = new Pagination($this->limit, $total, $this->page);
		return $pagination;
	}

	/*
		 * get info of Category
		 */
	function get_record_by_id($id, $table_name = '')
	{
		if (!$id)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT *
						  FROM " . $table_name . "
						  WHERE id = $id ";
		global $db;
		$result = $db->getObject($query);
		return $result;
	}
	/*
		 * get record 
		 */
	function get_record($where = '', $table_name = '', $select = '*')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
						  FROM " . $table_name . "
						  WHERE " . $where;

		global $db;
		$db->query($query);
		$result = $db->getObject();
		return $result;
	}
	/*
	 * get record by rid
	 */
	function get_records($where = '', $table_name = '', $select = '*', $ordering = '', $limit = '', $field_key = '')
	{
		$sql_where = " ";
		if ($where) {
			$sql_where .= ' WHERE ' . $where;
		}
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . $sql_where;
		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		if ($limit)
			$query .= ' LIMIT ' . $limit;
		global $db;

		if (!$field_key)
			$result = $db->getObjectList($query);
		else
			$result = $db->getObjectListByKey($field_key, $query);

		return $result;
	}

	function get_count($where = '', $table_name = '')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT count(*)
						  FROM " . $table_name . "
						  WHERE " . $where;

		global $db;
		$result = $db->getResult($query);
		return $result;
	}

	/*
		 * Return result
		 */
	function get_result($where = '', $table_name = '', $field = 'id')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$select = " SELECT " .	$field . " ";
		$query = $select . "  FROM " . $table_name . "
						  WHERE " . $where;

		global $db;
		$result = $db->getResult($query);
		return $result;
	}

	function get_field_by_id($id, $field, $table_name = '')
	{
		if (!$id)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT $field
						  FROM " . $table_name . "
						  WHERE id = $id ";
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	/*
		 * get record by rid
		 */
	function get_record_by_rid($id, $table_name = '')
	{
		if (!$id)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT *
						  FROM " . $table_name . "
						  WHERE rid = $id ";

		global $db;
		$result = $db->getObject($query);
		return $result;
	}

	/*
		 * remove record
		 * $img_field is image field need remove.
		 * $img_paths is paths contain image
		 */
	function remove()
	{
		$checkMethod = 'check_remove';
		// check remove
		if (method_exists($this, $checkMethod)) {
			if (!$this->$checkMethod()) {
				Errors::_(FSText::_('Can not remove these records because have data are related'));
				return false;
			}
		}
		
		$cids = FSInput::get('id', array(), 'array');
		foreach ($cids as $cid) {
			if ($cid != 1)
				$cids[] = $cid;
		}
		if (!count($cids))
			return false;
		$str_cids = implode(',', $cids);

		$removeChildMethod = 'removeChild';
		if (method_exists($this, $removeChildMethod)) {
			$this->$removeChildMethod($str_cids);
		}

		foreach (array_unique($cids) as $item_remove) {
			$row = [];
			$record = $this->get_record_by_id($item_remove, $this->use_table_extend, 'alias');
			$user_id = isset($_SESSION['ad_userid']) ? $_SESSION['ad_userid'] : '';
			$user = $this->get_record_by_id($user_id, 'fs_users', 'username');

			$row['record_id'] = $item_remove;
			$row['alias'] = $record->alias;
			$row['table_name'] = $this->table_name;
			$row['user_id'] = $user_id;
			$row['user_name'] = $user->username;
			$row['created_time'] = date('Y-m-d H:i:s');
			$this->_add($row, 'fs_remove_log', 1);
		}

		$field_img = isset($this->field_img) ? $this->field_img : '';
		$use_table_extend = isset($this->use_table_extend) ? $this->use_table_extend : 0;

		// array table_names is changed. ( for calculate filter)
		$arr_table_name_changed = array();

		if ($field_img || $use_table_extend) {

			//print_r(123);die;   
			$select = 'id';
			if ($field_img)
				$select .= ',' . $field_img;
			if ($use_table_extend)
				$select .= ',tablename';

			$query = " SELECT " . $select . " FROM " . $this->table_name . "
						WHERE id IN (" . $str_cids . ") ";
			global $db;
			$result = $db->getObjectList($query);
			if (!$result)
				return;

			foreach ($result as $item) {
				// remove img					
				if ($field_img) {
					$old_image = $item->$field_img;

					$arr_img_paths = $this->arr_img_paths;
					if (count($arr_img_paths)) {
						foreach ($arr_img_paths as $item_path) {
							$path_resize = str_replace('/original/', '/' . $item_path[0] . '/', $old_image);
							$path_resize = PATH_BASE . str_replace('/', DS, $path_resize);
							unlink($path_resize);
						}
					}
					$old_image = PATH_BASE . str_replace('/', DS, $old_image);
					unlink($old_image);
				}
				if ($use_table_extend) {
					// remove data in table fs_Type_extend
					$table_extend = $item->tablename;
					// for caculator filters
					$arr_table_name_changed[] = $table_extend;
					if ($table_extend) {
						if ($table_extend && $table_extend != 'fs_products' && $db->checkExistTable($table_extend))
							$this->_remove('record_id  = ' . $item->id, $table_extend);
					}
				}

				//synchronize
				$array_synchronize = $this->array_synchronize;
				if (count($array_synchronize)) {
					foreach ($array_synchronize as $table_name => $fields) {
						$syn = 0;
						$row5 = array();
						$where = '';
						foreach ($fields as $cur_field => $syn_field) {
							$where .= $syn_field . ' = ' . $item->id;
							break;
						}
						$rs = $this->_update($row5, $table_name, $where, 0);
						$this->_remove($where, $table_name);
					}
				}
			}
		}
		$sql = " DELETE FROM " . $this->table_name . " 
						WHERE id IN ( $str_cids ) ";
		 
		global $db;
		$rows = $db->affected_rows($sql);

		// update sitemap
		if ($this->call_update_sitemap) {
			$this->call_update_sitemap();
		}
		// 	calculate filters:
		//			if($this -> calculate_filters){
		//				$this -> caculate_filter($arr_table_name_changed);
		//			}
		return $rows;
	}
	/*
		 * remove record
		 * $img_field is image field need remove.
		 * $img_paths is paths contain image
		 */

	/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
	function published($value)
	{
		$ids = FSInput::get('id', array(), 'array');

		if (count($ids)) {
			global $db;
			$str_ids = implode(',', $ids);
			$sql = " UPDATE " . $this->table_name . "
							SET published = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows($sql);

			// 	update sitemap
			if ($this->call_update_sitemap) {
				$this->call_update_sitemap();
			}
			// array table_names is changed. ( for calculate filter)
			$arr_table_name_changed = array();
			// update table fs_TYPE_extend
			if ($this->use_table_extend) {
				foreach ($ids as $id) {
					$record = $this->get_record('id = ' . $id, $this->table_name);
					$table_extend = $record->tablename;
					// calculate filter:
					$arr_table_name_changed[] = $table_extend;
					global $db;
					if ($table_extend && $table_extend != 'fs_products' && $db->checkExistTable($table_extend)) {
						$row['published'] = $value;
						$rs = $this->_update($row, $table_extend, ' record_id = ' . $id);
					}
				}
			}
			//synchronize
			$array_synchronize = $this->array_synchronize;
			if (count($array_synchronize)) {
				foreach ($array_synchronize as $table_name => $fields) {
					$i = 0;
					$syn = 0;
					$row5 = array();
					$where = ' ';
					foreach ($fields as $cur_field => $syn_field) {
						if (!$i) {
							$where .= $syn_field . ' = ' . $id;
						} else {
							if ($cur_field == 'published') {
								$row5[$syn_field] = $value;
								$syn = 1;
							}
						}
						$i++;
					}
					if ($syn) {
						$rs = $this->_update($row5, $table_name, $where);
					}
				}
			}

			// calculate filters:
			//				if($this -> calculate_filters){
			//					$this -> caculate_filter($arr_table_name_changed);
			//				}
			return $rows;
		}

		return 0;
	}
	/*
		 * value: == 1 :published
		 * value  == 0 :unpublished
		 * published record
		 */
	function duplicate()
	{
		$ids = FSInput::get('id', array(), 'array');
		$rs = 0;
		$field_except = $this->field_except_when_duplicate;
		$arr_fields_reset = $this->field_reset_when_duplicate; // các trường không duplicate dữ liệu sang
		$time = date('Y-m-d H:i:s');

		if (count($ids)) {
			global $db;
			$str_ids = implode(',', $ids);
			$records  = $this->get_records(' id IN (' . $str_ids . ')', $this->table_name);

			if (!count($records))
				return false;
			foreach ($records as $item) {
				$row = array();
				$field_key1 = 'name'; // title or name
				$key1 = ''; // title or name
				$key2 = ''; // alias
				$suffix_new = '';
				foreach ($item as $key => $value) {
					if (!empty($value)) {
						if ($key == 'id' || (isset($this->field_img) && $key == $this->field_img)) {
							continue;
						}
						if ($key == 'name' || $key == 'title') {
							$key1 = $value;
							$field_key1 = $key;
							continue;
						}
						if ($key == 'alias') {
							$key2 = $value;
							continue;
						}
						if ($key == 'edited_time' || $key == 'created_time' || $key == 'updated_time') {
							$row[$key]  =   $time;
							continue;
						}

						if (isset($arr_fields_reset) && in_array($key, $arr_fields_reset)) {
							$row[$key]  =   null;
							continue;
						}

						$row[$key] = $value;
					}
				}
				//print_r($row);die;

				if (!$key1)
					continue;
				$j = 0;
				while (true) {
					if (!$j) {
						$key1_copy = $key1 . ' copy';
						$key2_copy = $key2 . '-copy';
						$suffix_new = '-copy';
					} else {
						$key1_copy = $key1 . ' copy ' . $j;
						$key2_copy = $key2 . '-copy-' . $j;
						$suffix_new = '-copy-' . $j;
					}
					$where = $field_key1 . ' = "' . $db->escape_string($key1_copy) . '" OR alias = "' . $db->escape_string($key2_copy) . '" ';
					$check_exist = $this->get_count($where, $this->table_name);
					if (!$check_exist) {
						$row[$field_key1] = 	$key1_copy;
						$row['alias']	= 	$key2_copy;
						break;
					}
					$j++;
				}
				// duplicate image
				if (isset($this->field_img) && $suffix_new) {
					$field_img = $this->field_img;
					$link_img = $this->duplicate_image($item->$field_img, $suffix_new);
					if ($link_img)
						$row[$field_img] = $link_img;
				}
				$new_record_id = $this->_add($row, $this->table_name, 1);
				if ($new_record_id) {
					$row2 = array();
					$new_record = $this->get_record(' id = ' . $new_record_id, $this->table_name);
					// except : wrapper_alias, list_parents
					if ($field_except && count($field_except)) {
						foreach ($field_except as $f) {
							$row2[$f[0]] = str_replace(',' . $item->$f[1] . ',',  ',' . $new_record->$f[1] . ',', $row[$f[0]]);
						}
						$this->_update($row2, $this->table_name, ' id = ' . $new_record_id);
					}


					// duplicate data extend
					if ($this->use_table_extend) {
						$row3 = array();
						//							$row3 = $row;
						unset($row3['tablename']);
						$row3['record_id'] = $new_record_id;
						$table_extend = $item->tablename;
						// for caculator filters
						$arr_table_name_changed[] = $table_extend;

						if ($table_extend && $table_extend != 'fs_products' && $db->checkExistTable($table_extend)) {
							$record_extend = $this->get_record('record_id = ' . $item->id, $table_extend);
							foreach ($record_extend as $field_ext_name => $field_ext_value) {
								if (isset($row3[$field_ext_name]) || $field_ext_name == 'id')
									continue;
								if ($field_ext_name == 'alias') {
									$row3[$field_ext_name] = $row['alias'];
									continue;
								}
								if ($field_ext_name == 'name') {
									$row3[$field_ext_name] = $row['name'];
									continue;
								}
								$row3[$field_ext_name] = $db->escape_string($field_ext_value);
							}
							if (!$this->_add($row3, $table_extend))
								continue;
						}
					}

					$rs++;
				}
			}
			// 	update sitemap
			if ($this->call_update_sitemap) {
				$this->call_update_sitemap();
			}
			// calculate filters:
			//				if($this -> calculate_filters){
			//					$this -> caculate_filter($arr_table_name_changed);
			//				}
			return $rs;
		}

		return 0;
	}
	/*
		 * get Max value of Ordering field in table fs_categories
		 */
	function getMaxOrdering()
	{
		$query = " SELECT Max(a.ordering)
					 FROM " . $this->table_name . " AS a
					";
		global $db;
		$result = $db->getResult($query);
		if (!$result)
			return 1;
		return ($result + 1);
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

	function get_max_ordering_dropzone($tablename, $rid)
	{
		$query = " SELECT Max(a.ordering)
					 FROM " . $tablename . " AS a WHERE a.record_id = $rid
					";
		global $db;
		$sql = $db->query($query);
		$result = $db->getResult();
		if (!$result) {
			return 1;
		}
		return ($result + 1);
	}
	/*
		 * get field of table
		 */
	function get_field_table($table_name = '', $key_field_name = 0)
	{
		if (!$table_name)
			$table_name = $this->table_name;
		global $db;
		$query = "SHOW COLUMNS FROM " . $table_name . " ";
		$db->query($query);
		if ($key_field_name)
			$fields_in_table = $db->getObjectListByKey('Field');
		else
			$fields_in_table = $db->getObjectList();
		return $fields_in_table;
	}

	/*
		 * save into table
		 */
	function save($row = array(), $use_mysql_real_escape_string = 1)
	{
		$id = FSInput::get('id', 0, 'int');

		$this->freeMemcache();

		if (!$id)
			return $this->save_new($row, $use_mysql_real_escape_string);
		else
			return $this->save_change($id, $row, $use_mysql_real_escape_string);
	}

	function save_new($row, $use_mysql_real_escape_string = 0)
	{
		$fields_in_table = $this->get_field_table();
		global $db;
		$str_fields = array();
		$str_values = array();
		$field_img = isset($this->field_img) ? $this->field_img : 'image';
		$field_width = isset($this->field_width) ? $this->field_width : '';
		$type_image = FSInput::get('type_image', 0, 'int');

		for ($i = 0; $i < count($fields_in_table); $i++) {
			$item = $fields_in_table[$i];
			$field  = $item->Field;
			if (
				$field == $field_img && !isset($row[$field_img])
				&& $field_img
			) {
				//					$image = $_FILES[$field_img]["name"];
				if ($type_image == 0) {
					$image = $_FILES[$field_img]["name"];
				} else {
					$image = FSInput::get($field_img);
				}
				if ($image) {
					$image = $this->upload_image($field_img, '_' . time(), 2000000, $this->arr_img_paths, '', $type_image, $image);
					if ($image) {
						$row[$field_img] = $image;
					}
				}
				//					if($image){
				//						$image = $this -> upload_image($field_img,'_'.time(),10000000);
				//						$row[$field_img] = 	$image;
				//						if(!isset($row[$field_img]) && $field_width){
				//							// tính chiều rộng để thêm vào admin
				//							list($root_width,$root_height) = getimagesize(URL_ROOT.$image);
				//							$arr_img_paths = $this -> arr_img_paths;
				//							$get_height =$arr_img_paths[0][2];
				//							$new_width  = ceil($root_width * $get_height/ $root_height) ;
				//							$row[$field_width] = $new_width;
				//						}
				//					}
			}
			if ($field == 'alias') {
				if (!isset($row['alias'])) {
					$alias = FSInput::get('alias');
					$fsstring = FSFactory::getClass('FSString', '', '../');
					if (!$alias) {
						$title = FSInput::get('title');
						if (!$title)
							$title = FSInput::get('name');
						if (!$title) {
							Errors::_('Cần nhập tên hoặc tiêu đề');
							return false;
						}
						$row['alias'] = $fsstring->stringStandart($title);
					} else {
						$row['alias'] = $fsstring->stringStandart($alias);
					}
				}
				if (isset($this->check_alias) && $this->check_alias) {
					if ($this->check_exist($row['alias'], '')) {
						Errors::_('Alias của bạn đã bị trùng tên', 'alert');
						$row['alias'] = $this->genarate_alias_news($row['alias'], '');
					}
				}
			}
			if (isset($row[$field])) {
				if (strpos($row[$field], "'") !== false) {
					$row[$field] = str_replace("'", "\'", $row[$field]);
				}
				$str_fields[] =   "`" . $field . "`";
				$str_values[]  =   "'" . $row[$field] . "'";
			} else if (isset($_POST[$field])) {
				$type  = $item->Type;
				$value = FSInput::get($field);
				if (strpos($value, "'") !== false) {
					$value = str_replace("'", "\'", $value);
				}
				if (strpos($type, 'text') !== false || strpos($type, 'varchar') !== false) {
					$str_fields[] =   "`" . $field . "`";
					$str_values[]  =   "'" . $value . "'";
				} else {
					$str_fields[] =   "`" . $field . "`";
					$str_values[]  =   "'" . $value . "'";
				}
			} else {
				if ($field == 'edited_time' || $field == 'created_time' || $field == 'updated_time') {
					$time = date('Y-m-d H:i:s');
					$str_fields[] =   "`" . $field . "`";
					$str_values[]  =   "'" . $time . "'";
				}
			}
		}
		if (!count($str_fields))
			return false;

		$str_fields = implode(',', $str_fields);
		$str_values = implode(',', $str_values);


		$sql = ' INSERT INTO  ' . $this->table_name;
		$sql .=  '(' . $str_fields . ") ";
		$sql .=  'VALUES (' . $str_values . ") ";

		//print_r($sql);die;
		$id = $db->insert($sql);

		// calculate filters:
		if ($this->calculate_filters) {
			// chỉ tính toán đếm bộ lọc khi có bảng mở rộng
			$tablename = $row['tablename'];
			$save_extension_method = 'save_extension';
			if ($tablename && $tablename != 'fs_products') {
				$ext_id = $this->$save_extension_method($tablename, $id);
				if (!$ext_id) {
					Errors::setError('C&#243; l&#7895;i khi l&#432;u ph&#7847;n m&#7903; r&#7897;ng');
				}
			}

			$arr_table_name_changed = array();
			if (isset($row['tablename']) && !empty($row['tablename']))
				$arr_table_name_changed[] = $row['tablename'];
			//				$this -> caculate_filter($arr_table_name_changed);
		}
		$this->freeMemcache();
		return $id;
	}

	/*
		 * Update:
		 * update field from :row, time and request
		 */
	function save_change($id, $row = array(), $use_mysql_real_escape_string = 0)
	{
		if (!$id)
			return;
		global $db;
		$fields_in_table = $this->get_field_table();
		$str_update = array();
		$field_img = isset($this->field_img) ? $this->field_img : 'image';
		$field_width = isset($this->field_width) ? $this->field_width : '';
		$type_image = FSInput::get('type_image', 0, 'int');

		// mảng  $row1 này chỉ phục vụ cho việc đồng bộ dữ liệu ra bảng ngoài theo cấu hình $array_synchronize

		for ($i = 0; $i < count($fields_in_table); $i++) {
			$item = $fields_in_table[$i];
			$field  = $item->Field;

			if (
				$field == $field_img && !isset($row[$field_img])
				&& $field_img
			) {
				if ($type_image == 0) {
					$image = $_FILES[$field_img]["name"];
				} else {
					$image = FSInput::get($field_img);
				}
				if ($image) {
					if ($type_image == 0) {
						// remove old if exists record and img
						$this->remove_old_image($id, $field_img);
					}
					//						$image = $this -> upload_image($field_img,'_'.time(),10000000);
					$image = $this->upload_image($field_img,'_' . time(),2000000,$this->arr_img_paths,'',$type_image,$image);

					$row[$field_img] = 	$image;
											// var_dump($image);
											// var_dump($this->arr_img_paths);
											// die;
					//					if($field_width){
					//							// tính chiều rộng để thêm vào admin
					//							list($root_width,$root_height) = getimagesize(URL_ROOT.$image);
					//							$arr_img_paths = $this -> arr_img_paths;
					//							$get_height =$arr_img_paths[0][2];
					//							$new_width  = ceil($root_width * $get_height/ $root_height) ;
					//							$row[$field_width] = $new_width;
					//						}
				}
			}
			if ($field == 'alias') {
				if (!isset($row['alias'])) {
					$alias = FSInput::get('alias');
					$fsstring = FSFactory::getClass('FSString', '', '../');
					if (!$alias) {
						$title = FSInput::get('title');
						if (!$title)
							$title = FSInput::get('name');
						if (!$title) {
							Errors::_('Cần nhập tên hoặc tiêu đề');
							return false;
						}
						$row['alias'] = $fsstring->stringStandart($title);
					} else {
						$row['alias'] = $fsstring->stringStandart($alias);
					}
				}
				if ($this->check_alias) {
					if ($this->check_exist($row['alias'], $id)) {
						Errors::_('Alias của bạn đã bị trùng tên', 'alert');
						$row['alias'] = $this->genarate_alias_news($row['alias'], $id);
						//							return false;
					}
				}
			}
			if (isset($row[$field])) {
				$str_update[] = "`" . $field . "` = '" . $row[$field] . "'";
			} else if (isset($_POST[$field])) {
				$type  = $item->Type;

				$value = $_POST[$field];

				if (strpos($type, 'text') !== false || strpos($type, 'varchar') !== false) {
					$row[$field] = $value;
				} else {
					//						$str_update[] = "`".$field."` = '".$_POST[$field]."'";
					$row[$field] = $_POST[$field]; // synchronize
				}
			} else {
				if ($field == 'edited_time' || $field == 'updated_time') {
					$time = date('Y-m-d H:i:s');
					//						$str_update[] = "`".$field."` = '".$time."'";
					$row[$field] = $time; // synchronize
				}
			}
		}
		//			var_dump($row);die;
		//testVar($row); die;
		//			global $db;
		$rows = $this->_update($row, $this->table_name, ' id = ' . $id, 1);
		//			die;
		//synchronize
		$array_synchronize = $this->array_synchronize;
		if (count($array_synchronize)) {
			foreach ($array_synchronize as $table_name => $fields) {
				$i = 0;
				$syn = 0;
				$row5 = array();
				$where = ' ';
				foreach ($fields as $cur_field => $syn_field) {
					if (!$i) {
						$where .= $syn_field . ' = ' . $id;
					} else {
						if (isset($row[$cur_field])) {
							$row5[$syn_field] = $row[$cur_field];
							$syn = 1;
						}
					}
					$i++;
				}
				if ($syn)
					$rs = $this->_update($row5, $table_name, $where, 0);
			}
		}

		// 	calculate filters: 
		if ($this->calculate_filters) {

			// chỉ tính toán đếm bộ lọc khi có bảng mở rộng
			$tablename = $row['tablename'];
			$save_extension_method = 'save_extension';
			// save extension
			if ($tablename) {
				$ext_id = $this->$save_extension_method($tablename, $id);
				if (!$ext_id) {
					Errors::setError('C&#243; l&#7895;i khi l&#432;u ph&#7847;n m&#7903; r&#7897;ng');
				}
			}

			$arr_table_name_changed = array();
			if (isset($row['tablename']) && !empty($row['tablename']))
				$arr_table_name_changed[] = $row['tablename'];
		}
		$this->freeMemcache();
		if ($id)
			return $id;
		else if ($rows)
			return $rows;
		else
			return 0;
	}

	/*
		 * Change alias of category in table_item (news,products,...)
		 */
	function _update($row, $table_name, $where = '', $use_mysql_real_escape_string = 1)
	{
		global $db;

		$total = count($row);
		if (!$total || !$table_name)
			return;
		$sql = 'UPDATE ' . $table_name . ' SET ';
		$i = 0;

		foreach ($row as $key => $value) {
			if ($use_mysql_real_escape_string) {
				if (strpos($value, "'") !== false) {
					$value = str_replace("'", "\'", $value);
				}
				if ($value == 0) {
					$sql .= "`" . $key . "` = '" . $value . "'";
				} else {
					$sql .= "`" . $key . "` = '" . $db->escape_string($value) . "'";
				}
			} else {
				$sql .= "`" . $key . "` = '" . $value . "'";
			}
			if ($i < $total - 1)
				$sql .=  ',';
			$i++;
		}
		if ($where)
			$where = ' WHERE ' . $where;
		$sql .= $where;
		$rows = $db->affected_rows($sql);
		$this->freeMemcache();
		return $rows;
	}
	function _add($row, $table_name, $use_mysql_real_escape_string = 0)
	{
		if (!$table_name)
			return false;
		global $db;
		$str_fields = array();
		$str_values = array();

		if (!count($row))
			return;
		foreach ($row as $field => $value) {
			if ($use_mysql_real_escape_string) {
				$value = $db->escape_string($value);
			}
			$str_fields[] =   "`" . $field . "`";
			$str_values[]  =   "'" . $value . "'";
		}

		$str_fields = implode(',', $str_fields);
		$str_values = implode(',', $str_values);

		global $db;

		$sql = ' INSERT INTO  ' . $table_name;
		$sql .=  '(' . $str_fields . ') ';
		$sql .=  'VALUES (' . $str_values . ') ';
		// echo $sql;die;
		$id = $db->insert($sql);
		$this->freeMemcache();
		return $id;
	}

	function _add_multi($rows, $table_name, $use_mysql_real_escape_string = 0)
	{
		if (!$table_name)
			return false;
		$str_fields = '';
		$str_fields2 = array(); // luu dang ko co "`"

		if (!count($rows))
			return;
		global $db;
		$row_first = $rows[0];
		foreach ($row_first as $field => $value) {
			if ($str_fields)
				$str_fields .= ',';
			$str_fields .=   "`" . $field . "`";
			$str_fields2[] =   $field;
		}
		$str_values = '';
		$i = 0;
		foreach ($rows as $row) {
			if ($i)
				$str_values .= ',';
			$str_values .= '(';
			$k = 0;
			foreach ($str_fields2 as $field) {
				if ($k)
					$str_values .= ',';
				$value = isset($row[$field]) ? $row[$field] : '';
				if ($use_mysql_real_escape_string) {
					$value = $db->escape_string($value);
				} else {
				}
				$str_values  .=   "'" . $value . "'";
				$k++;
			}
			$str_values .= ')';
			$i++;
		}


		$sql = ' INSERT INTO  ' . $table_name;
		$sql .=  '(' . $str_fields . ") ";
		$sql .=  'VALUES ' . $str_values . " ";

		$id = $db->insert($sql);
		return $id;
	}

	/*
		 * Value need remove
		 */
	function _remove($where = '', $table_name = '')
	{
		$sql_where = '';
		if ($where)
			$sql_where .= ' WHERE ' . $where;
		if (!$table_name)
			$table_name = $this->table_name;
		$sql = " DELETE FROM " . $table_name . $sql_where;

		global $db;
		$rows = $db->affected_rows($sql);
		$this->freeMemcache();
		return $rows;
	}

	/*
		 * Return result
		 */
	function _get_result($where = '', $table_name = '', $field = 'id')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$select = " SELECT " .	$field . " ";
		$query = $select . "  FROM " . $table_name . "
						  WHERE " . $where;

		global $db;
		$result = $db->getResult($query);
		return $result;
	}

	/*
		 * Update only param call
		 */
	function record_update($row, $id, $table_name = '')
	{
		if (!$table_name)
			$table_name = $this->table_name;
		if (!count($row))
			return;

		$str_update = array();
		foreach ($row as $key => $value) {
			$str_update[] = "`" . $key . "` = '" . $value . "'";
		}

		// convert to string
		$str_update = implode(',', $str_update);

		$sql = ' UPDATE  ' . $table_name . ' SET ';
		$sql .=  $str_update;
		$sql .=  ' WHERE id = 	  ' . $id . ' ';

		global $db;
		$rows = $db->affected_rows($sql);
		if ($rows)
			return $rows ? $id : 0;
	}


	function get_all_record($table_name, $ordering = '')
	{
		$field = FSInput::get('field');
		$tablename = FSInput::get('tablename');
		$where = "";
		// if($field=='manufactory')
		// 	$where .="  AND tablenames like '%,fs_products_".$tablename.",%'";

		$query = " SELECT *
						  FROM " . $table_name . " 
						  WHERE 1 = 1 " . $where;
		if ($ordering)
			$query .= ' ORDER BY ' . $ordering;
		global $db;
		$result = $db->getObjectList($query);
		return $result;
	}
	/*
		 * check exist name, alias
		 */
	function check_exist_alias($name, $alias, $id = '', $table_name)
	{
		if (!$name || !$table_name)
			return;
		$query = " SELECT count(*)
						  FROM " . $table_name . " 
						WHERE (name = '" . $name . "'
						OR alias = '" . $alias . "') ";
		if ($id)
			$query .= ' AND id <> ' . $id . ' ';

		global $db;
		$result = $db->getResult($query);
		return $result;
	}

	/*
		 * Remove img
		 */
	// remove image of id IN str_id
	function remove_image($sts_ids, $path_arr = array(), $field = 'image', $table_name = '')
	{
		if (!$sts_ids || !count($path_arr))
			return;
		if (!$table_name)
			$table_name = $this->table_name;

		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
		global $db;
		$list = $db->getObjectList($sql);

		for ($i = 0; $i < count($list); $i++) {
			$image = $list[$i]->$field;
			if ($image)
				for ($j = 0; $j < count($path_arr); $j++) {

					if (!@unlink($path_arr[$j] . $image)) {
						Errors::_('Not remove image' . $path_arr[$j] . $image);
					}
				}
		}
		return true;
	}

	/*
		 * Note: Image link is fixed link. This have url_root
		 * Remove old width new method
		 */
	// remove image of id IN str_id
	function remove_old_image($sts_ids, $field = 'image', $table_name = '')
	{
		if (!$sts_ids)
			return;
		$path_arr = $this->arr_img_paths;
		if (!$table_name)
			$table_name = $this->table_name;

		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
		global $db;
		$list = $db->getObjectList($sql);

		for ($i = 0; $i < count($list); $i++) {
			$image = $list[$i]->$field;
			if (!empty($image)) {
				//					$image = 	str_replace(URL_ROOT,PATH_BASE, $image);
				$image = 	PATH_BASE . str_replace('/', DS, $image);
				if (!@unlink($image)) {
					Errors::_('Not remove image' . $image);
				}
				for ($j = 0; $j < count($path_arr); $j++) {
					$link = str_replace(DS . 'original' . DS, DS . $path_arr[$j][0] . DS, $image);
					if (!@unlink($link)) {
						Errors::_('Not remove image' . $link);
					}
				}
			}
		}
		return true;
	}
	/*
		 * Remove file
		 */
	// remove file of id IN str_id
	function remove_file($sts_ids, $path_arr = array(), $field = 'image', $table_name = '')
	{
		if (!$sts_ids || !count($path_arr))
			return;
		if (!$table_name)
			$table_name = $this->table_name;

		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  id IN (" . $sts_ids . ") ";
		global $db;
		$list = $db->getObjectList($sql);

		for ($i = 0; $i < count($list); $i++) {
			$image = $list[$i]->$field;
			if ($image)
				for ($j = 0; $j < count($path_arr); $j++) {

					if (!@unlink($path_arr[$j] . $image)) {
						Errors::_('Not remove image' . $path_arr[$j] . $image);
					}
				}
		}
		return true;
	}

	/*
		 * Check exist of record in tables of language
		 */
	function check_translate($table_name, $rid)
	{
		if (!$table_name)
			return false;
		global $db;
		$lang_arr = array('en', 'vi');
		$lang_current = $_SESSION['con_lang'];
		foreach ($lang_arr as $lang) {
			if ($lang != $lang_current) {
				$query = " SELECT id
							  FROM " . $table_name . "
							  WHERE rid = $rid ";

				$result = $db->getResult($query);
				if ($result)
					return true;
			}
		}
		return false;
	}
	/*
		 * get District
		 * default: Ha Noi
		 */
	function get_districts($city_id = '1473')
	{
		if (!isset($city_id))
			$city_id = 1473;
		global $db;
		$sql = " SELECT id, name FROM fs_districts
					WHERE city_id = $city_id ";
		return $db->getObjectList($sql);
	}
	function get_cities_follow_country($country_id = '66')
	{
		if (!$country_id)
			$country_id = 1473;
		global $db;
		$sql = " SELECT id, name FROM fs_cities
					WHERE country_id = $country_id ";
		return $db->getObjectList($sql);
	}

	function get_city()
	{
		global $db;
		$sql = " SELECT id, name FROM fs_cities ";
		return $db->getObjectList($sql);
	}
	/*
		 * get Estore
		 */
	function get_estore()
	{
		$estore_id = $_SESSION['estore_id'];
		if (!$estore_id)
			return;

		global $db;
		$sql = " SELECT *
					FROM fs_estores
					WHERE `id`  = '$estore_id' 
					";
		return $db->getObject($sql);
	}

	/*
		 * get rid
		 * 1. if rid exist: get Max rid
		 * 2. if rid not exist : get rid
		 */
	function get_record_id_for_language($table_name, $rid_need_check)
	{
		if (!$table_name && !$rid_need_check)
			return 0;
		global $db;
		$lang_arr = array('en', 'vi');
		$lang_current = $_SESSION['con_lang'];
		$exist = 0;
		foreach ($lang_arr as $lang) {
			$query = " SELECT rid
				  FROM " . $table_name . '_' . $lang . "
				  WHERE rid = $rid_need_check ";
			$result = $db->getResult($query);
			if ($result) {
				$exist = 1;
				break;
			}
		}
		if (!$exist)
			return $rid_need_check;
		$max_rid = 0;
		foreach ($lang_arr as $lang) {
			$query = " SELECT Max(rid) as max_rid
				  FROM " . $table_name . "
				   ";
			$result = $db->getResult($query);
			$max_rid = $max_rid > $result ? $max_rid : $result;
		}
		return $max_rid + 1;
	}

	/*
	     * Save all record for list form
	     */
	function save_all()
	{
		$total = FSInput::get('total', 0, 'int');
		//	        var_dump($total);die;
		if (!$total)
			return true;
		global $db;
		$field_change = FSInput::get('field_change');
		//	        var_dump($field_change);die;
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
			foreach ($field_change_arr as $field_item) {
				$field_value_original = FSInput::get($field_item . '_' . $i . '_original');
				$field_value_new = FSInput::get($field_item . '_' . $i);
				if (is_array($field_value_new)) {
					$field_value_new = count($field_value_new) ? ',' . implode(',', $field_value_new) . ',' : '';
				}
				//                    var_dump($row);die;

				if ($field_value_original != $field_value_new) {
					$update = 1;
					//	        	          $row[$field_item] = htmlspecialchars_decode($field_value_new);
					$row[$field_item] = $db->escape_string($field_value_new);
					//                        var_dump($row[$field_item]);die;

					//die;
					//	        	          $row[$field_item] = $db -> escape_string($field_value_new);
					//	        	          $str_update[] = "`".$field_item."` = '".$field_value_new."'";
				}
			}

			//	        	var_dump($row);die;
			if ($update) {
				//	        	    echo 1;die;
				if ($this->table_name == 'fs_products') {
					$cat = $this->get_record("id = " . $row['category_id'] . "", 'fs_products_categories', 'alias, name, list_parents, alias_wrapper');
					$row['category_alias'] = $cat->alias;
					$row['category_name'] = $cat->name;
					$row['category_id_wrapper'] = $cat->list_parents;
					$row['category_alias_wrapper'] = $cat->alias_wrapper;
				}

				$id = FSInput::get('id_' . $i, 0, 'int');
				$rs = $this->_update($row, $this->table_name, '  id = ' . $id, 0);
				if ($this->use_table_extend) {
					$record = $this->get_record('id = ' . $id, $this->table_name);
					$table_extend = $record->tablename;
					// calculate filters:
					$arr_table_name_changed[] = $table_extend;
					global $db;
					if ($table_extend && $table_extend != 'fs_products' && $db->checkExistTable($table_extend)) {
						$rs = $this->_update($row, $table_extend, '  record_id = ' . $id);
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
								if (isset($row[$cur_field])) {
									$row5[$syn_field] = $row[$cur_field];
									$syn = 1;
								}
							}
							$i++;
						}
						//							var_dump($row5);die;
						if ($syn)
							$rs = $this->_update($row5, $table_name, $where, 0);
					}
				}

				if (!$rs)
					return false;
				$record_change_success++;
			}
		}

		// calculate filters:
		//			if($this -> calculate_filters){
		//				$this -> caculate_filter($arr_table_name_changed);
		//			}
		return $record_change_success;
	}
	/*
         * Show list category of tags
         */
	function get_tags_categories()
	{
		global $db;
		$query = " SELECT a.*, a.parent_id as parent_id 
                          FROM 
                            " . 'fs_tags_categories' . " AS a
                           ";
		$result = $db->getObjectList($query);
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		$limit = $this->limit;
		$page  = $this->page ? $this->page : 1;

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

	function change_status($field, $value)
	{
		if (!$field)
			return false;
		$ids = FSInput::get('id', array(), 'array');
		if (count($ids)) {
			global $db;
			$str_ids = implode(',', $ids);
			$sql = " UPDATE " . $this->table_name . "
							SET `" . $field . "` = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows($sql);
			$this->freeMemcache();
			return $rows;
		}
		return 0;
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
							SET show_in_homepage = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		// 	update sitemap
		if ($this->call_update_sitemap) {
			$this->call_update_sitemap();
		}

		return 0;
	}
	function autumn($value)
	{
		$ids = FSInput::get('id', array(), 'array');

		if (count($ids)) {
			global $db;
			$str_ids = implode(',', $ids);
			$sql = " UPDATE " . $this->table_name . "
							SET is_autumn = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		// 	update sitemap
		if ($this->call_update_sitemap) {
			$this->call_update_sitemap();
		}

		return 0;
	}
	function renew($value)
	{
		$ids = FSInput::get('id', array(), 'array');

		if (count($ids)) {
			global $db;
			$str_ids = implode(',', $ids);
			$sql = " UPDATE " . $this->table_name . "
							SET is_renew = $value
						WHERE id IN ( $str_ids ) ";
			$rows = $db->affected_rows($sql);
			return $rows;
		}
		// 	update sitemap
		if ($this->call_update_sitemap) {
			$this->call_update_sitemap();
		}

		return 0;
	}
	/*
		 * @Return: 1: tồn tại, 0: không tồn tại 
		 */
	function check_exist($value, $id = '', $field = 'alias', $table_name = '')
	{
		if (!$value)
			return false;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT count(*)
					  FROM " . $table_name . " 
					WHERE 
						$field = '" . $value . "' ";
		if ($id)
			$query .= ' AND id <> ' . $id . ' ';
		global $db;
		$result = $db->getResult($query);
		return $result;
	}
	/*
		 * Tạo ra alias mới nếu nó tồn tại 
		 */
	function genarate_alias_news($value, $id = '', $table_name = '')
	{
		if (!$value)
			return false;
		if (!$table_name)
			$table_name = $this->table_name;
		$i = 1;
		while (true) {
			$value_news = $value . '-' . $i;
			if (!$this->check_exist($value_news, $id)) {
				return $value_news;
			}
			$i++;
		}
	}

	/*ANHDUNG write*/

	function upload_image($image_tag_name = 'image', $suffix = '', $max_size = 2000000, $arr_img_paths = array(), $img_folder = '', $type = '', $path_image = '')
	{
		// print_r($arr_img_paths );
		if (!$img_folder) {
			$img_folder = $this->img_folder;
		}
		$img_link = str_replace('\\', '/', $img_folder);
		$img_folder = str_replace('/', DS, $img_folder);
		$img_folder = PATH_BASE . $img_folder . DS;
		$fsFile = FSFactory::getClass('FsFiles');
		// upload
		$path = $img_folder . 'original' . DS;
		if (!$fsFile->create_folder($path)) {
			Errors::setError("Not create folder " . $path);
			return false;
		}
		if (!@$type) {
			$image = $fsFile->uploadImage($image_tag_name, $path, $max_size, $suffix);

			if (!$image) {
				return false;
			}
			if ($this->image_watermark) {
				$file = $fsFile->add_logo($path, $image, PATH_BASE . str_replace('/', DS, $this->image_watermark['path_image_watermark']), $this->image_watermark['position']);
			}

			$img_link = $img_link . '/original/' . $image;

			if (!count($arr_img_paths)) {
				$arr_img_paths = $this->arr_img_paths;
			}

			if (!count($arr_img_paths)) {
				return $img_link;
			}

			foreach ($arr_img_paths as $item) {
				$path_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path);
				$fsFile->create_folder($path_resize);
				if ($_FILES[$image_tag_name]["type"] != 'image/svg+xml') {
					$method_resize = $item[3] ? $item[3] : 'resized_not_crop';

					if (!$fsFile->$method_resize($path . $image, $path_resize . $image, $item[1], $item[2]))
						return false;
				} else {
					copy(PATH_BASE . '/' . $img_link, PATH_BASE . str_replace('/original/', "/$item[0]/", '/' . $img_link));
				}
			}

			return $img_link;
		} else {
			$image_spec_arr = explode('/', $path_image);

			$name_image = $image_spec_arr[count($image_spec_arr) - 1];
			chmod($path, 0777);
			copy(PATH_BASE . $path_image, PATH_BASE . $img_link . '/original/' . $name_image);

			$img_link = $img_link . '/original/' . $name_image;
			$file_type = strtolower(pathinfo(
				$name_image,
				PATHINFO_EXTENSION
			));

			//convert image webp
			if ($file_type == "png") {
				$source = imagecreatefrompng(PATH_BASE . $img_link);
				imagepalettetotruecolor($source);
				$file_new1 = str_replace('.png', '.webp', $name_image);
				$result = imagewebp($source, $path . $file_new1, 100);
			} elseif ($file_type == "jpg" || $file_type == "jpeg") {
				$source = imagecreatefromjpeg(PATH_BASE . $img_link);
				imagepalettetotruecolor($source);
				$file_new1 = str_replace(['.jpg', '.jpeg'], '.webp', $name_image);
				$result = imagewebp($source, $path . $file_new1, 100);
			}

			imagedestroy($source);

			if (!count($arr_img_paths)) {
				$arr_img_paths = $this->arr_img_paths;
			}

			if (!count($arr_img_paths)) {
				return $img_link;
			}


			foreach ($arr_img_paths as $item) {
				$path_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path);
				$fsFile->create_folder($path_resize);
				if ($file_type != 'svg') {
					$method_resize = $item[3] ? $item[3] : 'resized_not_crop';

					if (!$fsFile->$method_resize($path . $name_image, $path_resize . $name_image, $item[1], $item[2]))
						return false;
				} else {
					copy(PATH_BASE . '/' . $img_link, PATH_BASE . str_replace('/original/', "/$item[0]/", '/' . $img_link));
				}
			}

			return $img_link;
		}
	}

	function duplicate_image($source_image, $suffix_new)
	{
		if (!$source_image || !$suffix_new)
			return;
		$fsFile = FSFactory::getClass('FsFiles');
		$file_name = basename($source_image);
		$ext_image = $fsFile->getExt($file_name);
		$file_name_not_ext = $fsFile->getFileName($file_name, $ext_image);
		$file_name_new =  $file_name_not_ext . $suffix_new . '.' . $ext_image;
		$link_img_destination = str_replace('/' . $file_name, '/' . $file_name_new, $source_image);
		$path_source = PATH_BASE . str_replace('/', DS, $source_image);
		$path_destination = PATH_BASE . str_replace('/', DS, $link_img_destination);

		$fsFile->copy_file($path_source, $path_destination);

		$arr_img_paths = $this->arr_img_paths;
		if (!count($arr_img_paths))
			return $link_img_destination;
		foreach ($arr_img_paths as $item) {
			$path_source_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path_source);
			$path_destination_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path_destination);
			$fsFile->copy_file($path_source_resize, $path_destination_resize);
		}
		return $link_img_destination;
	}

	function update_sitemap($str_categories_id, $table_name = 'fs_news_categories', $module = 'news')
	{
		global $db;
		$sql = " SELECT * FROM  fs_sitemap
						WHERE record_id IN ( $str_categories_id ) 
						AND table_name = '" . $table_name . "'
						AND module = '" . $module . "'
						 ";
		$list_exit = $db->getObjectList($sql);
		$array_record_exit = array();
		$array_field = array('name', 'alias', 'alias_wrapper', 'parent_id', 'list_parents', 'level', 'published', 'ordering', 'created_time', 'updated_time');
		foreach ($list_exit as $item) {
			$record = $this->get_record_by_id($item->record_id, $table_name);
			if (!$record) {
				$this->_remove('record_id = ' . $item->record_id, 'fs_sitemap');
				continue;
			}
			$row = array();

			$row['record_id'] =  $record->id;
			$row['module'] =  $module;
			$row['table_name'] =  $table_name;
			foreach ($array_field as $field) {
				$row[$field] =  $record->$field;
			}
			$this->_update($row, 'fs_sitemap', '  record_id = ' . $record->id . ' AND module = "' . $module . '" AND table_name = "' . $table_name . '"');
			$array_record_exit[] = $record->id;
		}

		$arr_categories_id = explode(',', $str_categories_id);
		foreach ($arr_categories_id as $item) {

			if (in_array($item, $array_record_exit))
				continue;
			$record = $this->get_record_by_id($item, $table_name);
			if (!$record) {
				$this->_remove('record_id = ' . $item, 'fs_sitemap');
				continue;
			}
			$row = array();

			$row['record_id'] =  $record->id;
			$row['module'] =  $module;
			$row['table_name'] =  $table_name;
			foreach ($array_field as $field) {
				$row[$field] =  $record->$field;
			}
			$this->_add($row, 'fs_sitemap');
		}
	}
	function call_update_sitemap()
	{
		$cids = FSInput::get('id', array(), 'array');
		if (!count($cids))
			return false;
		$str_cids = implode(',', $cids);
		$this->update_sitemap($str_cids, $this->table_name, $this->module);
	}

	/*
		 * select in category
		 */
	function get_categories_tree()
	{
		global $db;
		$query = $this->setQuery();
		$result = $db->getObjectList($query);
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		$limit = $this->limit;
		$page  = $this->page ? $this->page : 1;

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
		 * select in category of home
		 */
	function get_categories_tree_all()
	{
		global $db;
		$query = " SELECT a.*
						  FROM 
						  	" . $this->table_category_name . " AS a 
						  	 ORDER BY ordering ";
		$result = $db->getObjectList($query);
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}

	/************************************************************************************************/
	/*  CALCULATE FILTER *****/
	/************************************************************************************************/
	/*
		 * Tính toán filter
		 * Nếu có $categories_id thì ta chỉ xét cho mỗi id này. NẾu không có ta phải xét tất
		 */
	function caculate_filter($arr_table_name = array(), $categories_id = null)
	{
		// caculate for table fs_TYPE
		//			$this -> calculate_filter_common();
		if (!count($arr_table_name))
			return true;
		foreach ($arr_table_name as $table_name) {
			// caculate for table fs_TYPE_extend
			$this->calculate_filter_extend($table_name, $categories_id);
		}
		return true;
	}
	/*
		 * Xóa filter theo bảng hoặc category
		 */
	function remove_filters($arr_table_name = array(), $arr_categories_id = array())
	{
		// caculate for table fs_TYPE
		$this->calculate_filter_common();
		if (count($arr_table_name)) {
			foreach ($arr_table_name as $table_name) {
				// caculate for table fs_TYPE_extend
				$this->_remove(' tablename = "' . $table_name . '"', 'fs_' . $this->type . '_filters_values');
			}
		}
		if (count($arr_categories_id)) {
			foreach ($arr_categories_id as $category_id) {
				// caculate for table fs_TYPE_extend
				$this->_remove(' category_id = "' . $category_id . '"', 'fs_' . $this->type . '_filters_values');
			}
		}
		return true;
	}

	function calculate_filter_common()
	{
		// get data from fs_TYPE
		$data = $this->get_records('published = 1', 'fs_' . $this->type);
		// get filter common
		$filters = $this->get_records('is_common = 1', 'fs_' . $this->type . '_filters');
		// get categories
		$categories = $this->get_records('', 'fs_' . $this->type . '_categories');

		if (!count($data) || !count($filters))
			return;
		$arr_filter = array();

		$arr_filter_id_current = array();
		$arr_filter_fieldname_current = array();
		$array_exit = array();

		foreach ($data as $item) {
			// duyệt ko có category
			$rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current, $array_exit, $item, 0);
			$arr_filter = $rs[0];
			$array_exit = $rs[1];
			if (count($categories)) {
				foreach ($categories as $category) {
					$rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current, $array_exit, $item, $category->id);
					$arr_filter = $rs[0];
					$array_exit = $rs[1];
				}
			}
		}
		$this->save_filter($arr_filter, $filters, 'fs_' . $this->type, $categories);
		return true;
	}

	/*
		 * Đêm bộ lọc trong trường bảng mở rộng
		 * Nếu $categories_id rỗng ta phải xét hết categories
		 */
	function calculate_filter_extend($table_name, $category_id =  null)
	{
		// get filter 
		$filters = $this->get_records(' tablename = "' . $table_name . '" OR tablename ="fs_' . $this->type . '"', 'fs_' . $this->type . '_filters', '*', null, null, 'id');

		// get categories
		if ($category_id)
			$categories = $this->get_records('id = ' . $category_id, 'fs_' . $this->type . '_categories', '*', null, null, 'id');
		else
			$categories = $this->get_records(' tablename = "' . $table_name . '"', 'fs_' . $this->type . '_categories', '*', null, null, 'id');

		if (!count($filters))
			return;
		$arr_filter = array();

		$arr_filter_id_current = array();
		$arr_filter_fieldname_current = array();
		$array_exit = array();
		// get data from fs_TYPE_extend
		$limit_for_data = 50; // số sản phẩm mỗi lần tính toán
		$total_data =  $this->get_count('published = 1', $table_name);
		$repeat = ceil($total_data / $limit_for_data);

		for ($k = 0; $k < $repeat; $k++) {
			$start = $k * $limit_for_data;

			$data = $this->get_records('published = 1', $table_name, '*', '', '' . $start . ',' . $limit_for_data);
			foreach ($data as $item) {
				// duyệt ko có category
				$rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current, $array_exit, $item, 0);
				$arr_filter = $rs[0];
				$array_exit = $rs[1];
				if (count($categories)) {
					foreach ($categories as $category) {
						$rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current, $array_exit, $item, $category->id);
						$arr_filter = $rs[0];
						$array_exit = $rs[1];
					}
				}
			}
		}
		$this->save_filter($arr_filter, $filters, $table_name, $categories);
		return true;
	}
	/*
		 * sinh mang filter khong co category
		 * $arr_filter_id_current : (Mảng id của các filter đang duyệt tới) có dạng:  (2,3,4)  
		 * $arr_filter_fieldname_current : mảng field_name của các filter đang duyệt tới. Để tránh duyệt cùng 1 fieldname .có dạng:  ('color','body','...) 
		 * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau 
		 * Thay đổi sau mỗi lần đệ quy: $arr_filter,$array_exit
		 */
	function genate_array_filter($arr_filter, $filters, $arr_filter_id_current, $arr_filter_fieldname_current, $array_exit, $record, $category_id = 0)
	{
		// check categories
		if ($category_id && !($this->check_item_in_category($category_id, $record)))
			return array(0 => $arr_filter, 1 => $array_exit);

		// check xem đã duyệt lặp ngược chưa. Nếu rồi thì ko duyệt filter con nữa
		if ($this->check_exits($array_exit, $arr_filter_id_current, $category_id)) {
			return array(0 => $arr_filter, 1 => $array_exit);
		}

		$str_ids_parent = count($arr_filter_id_current) ? implode(',', $arr_filter_id_current) : '';
		// duyệt con
		foreach ($filters as $filter) {
			// khong duyệt cùng field_name
			if (in_array($filter->field_name, $arr_filter_fieldname_current))
				continue;
			$str_ids_current = $str_ids_parent ? $str_ids_parent . ',' : '';
			$str_ids_current .= $filter->id;
			if (!isset($arr_filter[$category_id][$str_ids_current]))
				$arr_filter[$category_id][$str_ids_current] = 0;
			if ($this->calculate_record_compatible_filter($record, $filter->filter_value, $filter->calculator, $filter->field_name)) {
				$arr_filter[$category_id][$str_ids_current]++;

				// gọi đệ quy để duyệt con:
				$arr_filter_id_current_child = $arr_filter_id_current;
				$arr_filter_id_current_child[] = $filter->id;
				$arr_filter_fieldname_current_child = $arr_filter_fieldname_current;
				$arr_filter_fieldname_current_child[] = $filter->field_name;
				$array_exit_child = $this->generate_filter_array_exit($array_exit, $filter->id, $arr_filter_id_current, $category_id);
				$array_exit = $array_exit_child;
				$rs = $this->genate_array_filter($arr_filter, $filters, $arr_filter_id_current_child, $arr_filter_fieldname_current_child, $array_exit, $record, $category_id);
				//					$rs = $this -> genate_array_filter($arr_filter,$filters,$arr_filter_id_current_child,$arr_filter_fieldname_current_child,$array_exit_child ,$record,$category_id);
				$arr_filter = $rs[0];
				$array_exit = $rs[1];
			}
		}
		return array(0 => $arr_filter, 1 => $array_exit);
	}

	function calculate_filter_common_for_category($data)
	{
	}

	/*
		 * Kiểm tra trùng lặp khi duyệt trong trường hợp đảo duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
		 * $array_exit: có dạng array('0,1,2' => '2,0,1') dùng để check các filter đã duyệt. VD [1][2][3] = [2][1][3] sẽ bị trùng nhau
		 * true: đã tồn tại
		 * false: chưa => phải duyệt
		 */
	function check_exits($array_exit = array(), $arr_filter_id_current = array(), $category_id = 0)
	{
		// chưa tồn tại => true
		if (!count($array_exit) || !count($arr_filter_id_current))
			return false;
		// sắp xếp lại:
		$arr_filter_id_current_sort = $arr_filter_id_current;
		asort($arr_filter_id_current_sort);

		// chuyển qua chuỗi
		$str_filter_fieldname_current_sort = implode(',', $arr_filter_id_current_sort);
		$str_filter_fieldname_current = implode(',', $arr_filter_id_current);

		// nếu chưa tồn tại trong mảng array_exit
		if (!isset($array_exit[$category_id][$str_filter_fieldname_current_sort]))
			return false;

		// kiểm tra xem có giống mảng đang gọi ko?	
		if ($array_exit[$category_id][$str_filter_fieldname_current_sort] != $str_filter_fieldname_current)
			return true;

		return false;
	}

	/*
		 * Tính toán xem record này có thỏa mãn điều kiện filter đưa ra
		 * record: 1 record
		 * math: filter math
		 * field: filter filter
		 * return: yes or no
		 */
	function calculate_record_compatible_filter($record, $filter_value, $math, $field)
	{

		$record_value = @$record->$field;
		$filter_value1 = '';
		$filter_value2 = '';
		if ($math > 9 && $math < 14) {
			$arr_value = explode(",", $filter_value, 2);
			$filter_value1 = @$arr_value[0] ? $arr_value[0] : "";
			$filter_value2 = @$arr_value[1] ? $arr_value[1] : "";
		}

		switch ($math) {
			case '1':
				return false;
			case '2': // LIKE
				if ($filter_value) {
					if (stripos(mb_strtolower($record_value, 'UTF-8'), $filter_value) !== false) {
						return true;
					}
				}
				return false;
			case '3':	// Null	
				if (!$record_value || trim($record_value) == "")
					return true;
				return false;
			case '4':
				if (trim($record_value) != "")
					return true;
				return false;
			case '5': //==
				if ($record_value == $filter_value)
					return true;
				return false;
			case '6':
				if ($record_value > $filter_value)
					return true;
				return false;
			case '7':
				if ($record_value < $filter_value)
					return true;
				return false;
			case '8':
				if ($record_value >= $filter_value)
					return true;
				return false;
			case '9':
				if ($record_value <= $filter_value)
					return true;
				return false;
			case '10':
				if ($record_value > $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
			case '11':
				if ($record_value > $filter_value1 && $record_value <= $filter_value2)
					return true;
				return false;
			case '12':
				if ($record_value >= $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
			case '13':
				if ($record_value >= $filter_value1 && $record_value < $filter_value2)
					return true;
				return false;
			case '14': //FOREIGN_ONE
				if ($record_value == $filter_value) {
					return true;
				}
				return false;
			case '15': //FOREIGN_MULTI
				if ($filter_value) {
					if (stripos(mb_strtolower($record_value, 'UTF-8'), ',' . $filter_value . ',') !== false) {
						return true;
					}
				}
				return false;
			default:
				return false;
		}
	}

	/*
		 * Sinh ra mảng chứa các filter_id đã duyệt
		 */
	function generate_filter_array_exit($array_exit, $filter_id, $filter_parrent_id, $category_id)
	{
		$filter_parrent_current = $filter_parrent_id;
		$filter_parrent_current[] = $filter_id;
		$filter_parrent_current_sort = $filter_parrent_current;
		asort($filter_parrent_current_sort);
		$str_filter_parrent_current_sort = implode(',', $filter_parrent_current_sort);
		// nếu tồn tại thì ko thực hiện
		if (isset($array_exit[$category_id][$str_filter_parrent_current_sort]))
			return $array_exit;
		$array_exit[$category_id][$str_filter_parrent_current_sort] = implode(',', $filter_parrent_current);
		return $array_exit;
	}

	/*
		 * Kiểm tra xem item này có nằm trong category ko
		 */
	function check_item_in_category($category_id, $record)
	{
		if (!$category_id)
			return false;
		if (stripos(mb_strtolower($record->category_id_wrapper, 'UTF-8'), ',' . $category_id . ',') !== false)
			return true;
		return false;
	}

	/*
		 * table_name == ''? common:extend
		 * $arr_filter: mảng kết quả filter sau khi tính toán
		 * $filters: mảng filter lấy từ db ra để đối chiếu
		 * $calculator_empty: có tính toán với biến count == 0 hay ko?
		 */
	function save_filter($arr_filter, $filters, $table_name = '', $categories, $calculator_empty = 0)
	{
		if (!count($arr_filter))

			return;

		// remove old common data
		$this->_remove('is_common = 1', 'fs_' . $this->type . '_filters_values');
		// remove old extend data
		if ($table_name) {
			$this->_remove('tablename = "' . $table_name . '"', 'fs_' . $this->type . '_filters_values');
		}

		foreach ($arr_filter as $category_id => $filters_in_cat) {
			if (!count($filters_in_cat))
				continue;
			$category_alias  = 	$category_id ? $categories[$category_id]->alias : '';
			foreach ($filters_in_cat as $ids => $count) {
				// nếu không đếm trường hợp count == 0
				if (!$calculator_empty && !$count)
					continue;
				$row = array();
				$arr_ids = explode(',', $ids);
				$url_id = '';
				$url_alias = '';
				$total_ids = count($arr_ids);
				$j = 0;

				//					$common = 0;
				for ($i = $total_ids - 1; $i >= 0; $i--) {
					if ($i == ($total_ids - 1)) {
						$filter_current_id  =  $arr_ids[$i];
					} else {
						if (!$j) {
							$url_id .= ',';
							$url_alias .= ',';
						}
						$url_id .= $arr_ids[$i] . ',';
						$url_alias .= $filters[$arr_ids[$i]]->alias . ',';
						//							if(!$common && $filters[$arr_ids[$i]] -> is_common)
						//								$common = 1 ;
						$j++;
					}
				}
				$filter_current = $filters[$filter_current_id];

				// row
				$row['category_id'] = $category_id;
				$row['category_alias'] = $category_alias;
				$row['url_ids'] = $url_id;
				$row['url_alias'] = $url_alias;
				$row['url_total_params'] = ($total_ids - 1);
				$row['record_id'] = $filter_current_id;
				$row['total'] = $count;
				$row['filter_show']  = $filter_current->filter_show;
				//					$row['tablename']  = $filter_current -> tablename;
				$row['tablename']  = $table_name;
				$row['field_name']  = $filter_current->field_name;
				$row['field_show']  = $filter_current->field_show;
				$row['alias']  = $filter_current->alias;
				$row['calculator']  = $filter_current->calculator;
				$row['calculator_show']  = $filter_current->calculator_show;
				$row['filter_value']  = $filter_current->filter_value;
				$row['published']  = $filter_current->published;
				$row['is_common']  = $filter_current->is_common;
				$row['is_condition']  = $filter_current->is_condition;
				$this->_add($row, 'fs_' . $this->type . '_filters_values');
			}
		}
	}

	/*
		 * Đồng bộ lại trường liên quan, nếu A chọn B là relate thì B sẽ coi A là relate
		 */
	function sys_related($table_name = 'fs_news', $field_name = 'products_related', $record_ids, $id)
	{
		if (!$table_name || !$field_name || !$record_ids || !$id)
			return false;
		$list = $this->get_records(' id IN (0' . $record_ids . '0) AND (' . $field_name . ' NOT LIKE "%,' . $id . ',%"  OR products_related IS NULL ) ', $table_name);
		foreach ($list as $item) {
			$related_value = $item->$field_name;
			if (!$related_value)
				$related_value .= ',';
			$related_value .= $id . ',';
			$row[$field_name] = $related_value;
			$this->_update($row, $table_name, ' id = ' . $item->id);
		}
	}

	function _update_column($table_name, $column_name = '', $value = 'NULL')
	{
		$sql = 'UPDATE ' . $table_name . ' SET ' . $column_name . ' = ' . $value;
		global $db;
		$rows = $db->affected_rows($sql);
		return $rows;
	}

	/*
		 * save into extension table
		 * (insert or update)
		 */
	function save_extension_exel($tablename, $record_id, $row_exel)
	{

		$data = $this->get_record('id = ' . $record_id, $this->table_name);
		global $db;
		// field default: cai nay can xem lai vi hien dang ko su dung. Can phai su dung de luoc bot cac  truong thua
		$field_default = $this->get_records(' type = "' . $this->type . '"  ', 'fs_tables');
		if (!$record_id)
			return false;

		if (!$db->checkExistTable($tablename))
			return false;
		// data same fs_TYPE
		$row['record_id'] = $record_id;
		$fields_all_of_ext_table = $this->get_field_table($tablename, 1);
		foreach ($data as $field_name => $value) {
			if ($field_name == 'id' || $field_name == 'tablename')
				continue;
			if (!isset($fields_all_of_ext_table[$field_name]))
				continue;
			$row[$field_name] = $value;
		}
		if ($row_exel)
			$row2 = array_merge($row, $row_exel);
		else
			$row2 = $row;
		$check_id = $this->check_exist($record_id, $id = '', 'record_id', $tablename);
		if ($check_id) {
			return $this->_update($row2, $tablename, ' record_id =  ' . $record_id);
		} else {
			return $this->_add($row2, $tablename);
		}
		return;
	}
	function getExtendFields_exel($tablename)
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
							AND field_name <> 'id' ";
		$result = $db->getObjectList($query);

		return $result;
	}
	function buff_loop($field_group, $table_name = '')
	{
		if (!$field_group)
			return false;
		$str_id = '';
		$query = "	SELECT id , count(" . $field_group . ") as c , MAX(id) as mid
				FROM " . $table_name . "
				GROUP BY " . $field_group . "
				HAVING c >= 1
			";
		global $db;
		$arr_group_duplicate = $db->getObjectList($query);

		if (count($arr_group_duplicate)) {
			$i = 0;
			foreach ($arr_group_duplicate as $item) {
				if ($i)
					$str_id .= ',';
				$str_id .= $item->mid;
				$i++;
			}

			$query1 = "	SELECT id , count(" . $field_group . ") as c 
					FROM " . $table_name . "
					GROUP BY " . $field_group . "
					HAVING c = 0
				";
			global $db;
			$arr_no_duplicate = $db->getObjectList($query1);
			$j = 0;
			if (count($arr_no_duplicate)) {
				$str_id .= ',';
				foreach ($arr_no_duplicate as $item) {
					if ($j)
						$str_id .= ',';
					$str_id .= $item->id;
					$j++;
				}
			}
		}
		if (!$str_id)
			return;


		// remove in multil
		$sql = " DELETE FROM " . $table_name . "
						WHERE id NOT IN ($str_id)";

		global $db;
		$rows = $db->affected_rows($sql);

		return $rows;
	}
	/**
	 * Upload và resize ảnh
	 * 
	 * @return Bool
	 */
	function upload_other_images()
	{
		$module = FSInput::get('module');
		$type = FSInput::get('type_img');
		global $db;
		$cyear = date('Y');
		$cmonth = date('m');
		$cday = date('d');
		$data = base64_decode(FSInput::get('data'));
		$data = explode('|', $data);
		$data_main = $this->get_record('id =' . $data[1], $this->table_name, 'category_alias');

		$fsFile = FSFactory::getClass('FsFiles');

		// $path = PATH_BASE . 'images' . DS . 'gallery' . DS . $cyear . DS . $cmonth . DS . $cday . DS . 'original' . DS;
		$path = PATH_BASE . 'upload_images/images' . DS . $module . DS . $data_main->category_alias . DS . 'original' . DS;

		if (!$fsFile->create_folder($path)) {
			Errors::setError("Not create folder " . $path);
		}

		$file_type = explode('/', $_FILES['file']['type'])[0];

		if ($file_type == 'video') {
			$file_name = $fsFile->uploadFile('file', $path, 10000000, '_' . time());
		} else {
			$file_name = $fsFile->uploadImage('file', $path, 10000000, '_' . time());
		}

		$img_link = $path . $file_name;

		if (is_string($file_name) and $file_name != '' && !empty($this->arr_img_paths_other) && $file_type != 'video') {
			foreach ($this->arr_img_paths_other as $item) {
				$path_resize = str_replace(DS . 'original' . DS, DS . $item[0] . DS, $path);
				$fsFile->create_folder($path_resize);
				if ($_FILES['file']["type"] != 'image/svg+xml') {
					$method_resize = $item[3] ? $item[3] : 'resized_not_crop';
					if (!$fsFile->$method_resize($path . $file_name, $path_resize . $file_name, $item[1], $item[2]))
						return "Không tạo được ảnh resize. Vui lòng thử lại";
				} else {
					copy($img_link, str_replace('/original/', "/$item[0]/", $img_link));
				}
			}
		}

		$fs_table = new FSTable_ad();
		$tablename = $fs_table->_('fs_' . $module . '_images');
		$max_ordering_dz = $this->get_max_ordering_dropzone($tablename, $data[1]);
		$row = array();
		if ($data[0] == 'add')
			$row['session_id'] = $data[1];
		else
			$row['record_id'] = $data[1];
		$row['image'] = str_replace([PATH_BASE, DS], ['', '/'], $img_link);
		$row['title'] = $_FILES['file']['name'];
		$row['ordering'] = $max_ordering_dz;
		$row['file_type'] = $file_type;
		$row['type'] = $type;

		$rs = $this->_add($row, $tablename);
		echo  $rs;
		return $rs;
	}

	// $fsFile = FSFactory::getClass('FsFiles');
	// 	// upload
	// 	$path = $img_folder.'original'.DS;
	// 	if(!$fsFile -> create_folder($path)){
	//    		Errors:: setError("Not create folder ".$path);
	//   			return false;
	//    	}

	// 	$image = $fsFile -> uploadImage($image_tag_name, $path ,$max_size, $suffix);
	// 	if(!$image)
	// 		return false;
	// 	if($this->image_watermark){
	// 		$fsFile->add_logo($path,$image,PATH_BASE.str_replace('/',DS, $this->image_watermark['path_image_watermark']),$this->image_watermark['position']);
	// 	}	
	// 	$img_link = $img_link.'/original/'.$image	;
	// 	if(!count($arr_img_paths))
	// 		$arr_img_paths = $this -> arr_img_paths;

	// 	if(!count($arr_img_paths))
	// 		return $img_link;

	function delete_other_image($record_id = 0)
	{
		$reocord_id = FSInput::get('reocord_id', 0, 'int');
		$file_name = FSInput::get('name');
		$id = FSInput::get('id');

		$module = FSInput::get('module');
		global $db;

		$where = '';
		if ($id) {
			$where .= ' AND id = ' . $id;
		} else {
			$where .= ' AND title = \'' . $file_name . '\'';
		}

		if ($reocord_id) {
			$where .= ' AND record_id = ' . $reocord_id;
		}
		$fs_table = new FSTable_ad();
		$tablename = $fs_table->_('fs_' . $module . '_images');

		$query = ' SELECT * FROM ' . $tablename . ' WHERE  1 = 1 ' . $where;
		$db->query($query);
		$images = $db->getObject();
		if ($images) {
			$query = '  DELETE FROM ' . $tablename . ' WHERE id = \'' . $images->id . '\'';
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
		$tablename = $fs_table->_('fs_' . $module . '_images');

		global $db;
		if (isset($_POST["sort"])) {
			if (is_array($_POST["sort"])) {
				foreach ($_POST["sort"] as $key => $value) {
					$db->query("UPDATE " . $tablename . " SET ordering = $key WHERE id = $value");
				}
			}
		}
	}

	/**
	 * Sửa thuộc tính của ảnh
	 * 
	 * @return Bool
	 */
	function change_attr_image()
	{
		global $db;
		$data = base64_decode(FSInput::get('data'));
		$data = explode('|', $data);
		$row = array();
		$where = '';
		if ($data[0] == 'add') {
			$where .= ' AND session_id = "' . $data[1] . '" ';
		} else {
			$where .= ' AND record_id = "' . $data[1] . '" ';
		}
		$field = FSInput::get('field');
		$value = FSInput::get('value');

		$id = FSInput::get('id', 0, 'int');
		if (!$id)
			return;
		if ($field == 'color') {
			$color = $this->get_record_by_id($value, 'fs_products_colors');
			$row['color_id'] = $value;
			$row['color_code'] = $color->code;
			$row['color_name'] = $color->name;
		}
		if ($field == 'sub') {
			//			$sub = $this->get_record_by_id($value,'fs_products_sub');
			$row['sub_id'] = $value;
		}
		$rs = $this->_update($row, 'fs_' . $this->type . '_images', ' id = ' . $id . $where);
		return $rs;
	}

	/**
	 * Sửa tiêu đề ảnh của ảnh
	 * 
	 * @return Bool
	 */
	function change_title_attr_image()
	{
		global $db;
		$data = base64_decode(FSInput::get('data'));
		$data = explode('|', $data);
		$row = array();
		$where = '';
		if ($data[0] == 'add') {
			$where .= ' AND session_id = "' . $data[1] . '" ';
		} else {
			$where .= ' AND record_id = "' . $data[1] . '" ';
		}
		$value = FSInput::get('value');

		$id = FSInput::get('id', 0, 'int');
		if (!$id)
			return;

		$row['title'] = $value;

		$fs_table = new FSTable_ad();
		$tablename = $fs_table->_('fs_' . $this->type . '_images');

		$rs = $this->_update($row, $tablename, ' id = ' . $id . $where);
		return $rs;
	}

	/******************/
	function get_config_by_key($key)
	{
		if (!$key)
			return;
		$query = ' SELECT value
						  FROM fs_config
						  WHERE `name` = "' . $key . '"';
		global $db;
		$db->query($query);
		$result = $db->getResult();
		return $result;
	}

	/*
		 * Lay danh sach tinh / thanh pho
		 */
	function get_cities()
	{
		global $db;
		$query = " SELECT *
	                   FROM fs_local_cities
                       ORDER BY area_id,ordering ";
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}
	/*
		 * Lay danh sach tinh / thanh pho
		 */
	function get_cities_by_permission()
	{
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'cities');
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM fs_local_cities WHERE published = 1 ' . $where . '
                       ORDER BY area_id,ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		return $result;
	}

	function get_news_categories_tree_by_permission()
	{
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'news_categories');
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM fs_news_categories WHERE 1 = 1 ' . $where . '
                       ORDER BY ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}
	function get_introduce_categories_tree_by_permission()
	{
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'news_categories');
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM fs_introduce_categories WHERE 1 = 1 ' . $where . '
                       ORDER BY ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}
	function get_faq_categories_tree_by_permission()
	{
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'news_categories');
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM fs_faq_categories WHERE 1 = 1 ' . $where . '
                       ORDER BY ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}
	function get_product_categories_tree_by_permission()
	{
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', 'products_categories');
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM fs_products_categories WHERE 1 = 1 ' . $where . '
                       ORDER BY ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}

	function get_categories_tree_by_permission($table_category = '')
	{
		//$table_name = !empty($table_name)? $table_name:$this->table_name;
		$table_category = !empty($table_category) ? $table_category : $this->table_name_category;
		$permission_cities = $this->get_result('id=' . $_SESSION['ad_userid'], 'fs_users', $table_category);
		$where = '  ';
		if ($permission_cities == 'none') {
			$where .= ' AND 1 = 0';
		} elseif ($permission_cities && $permission_cities != 'all') {
			$where .= ' AND id IN (0' . $permission_cities . '0)';
		}
		global $db;
		$query = ' SELECT *
	                   FROM ' . $table_category . ' WHERE 1 = 1 ' . $where . '
                       ORDER BY ordering ';
		$sql = $db->query($query);
		$result = $db->getObjectList();
		$tree  = FSFactory::getClass('tree', 'tree/');
		$list = $tree->indentRows2($result);
		return $list;
	}

	function delete_image()
	{
		global $db;
		$id = FSInput::get('id', 0);
		$field = FSInput::get('field');
		$data = $this->get_record_by_id($id, $this->table_name);
		$row = array();
		$row[$field] = '';
		$rs = $this->_update($row, $this->table_name, 'id = ' . $id);
		//print_r($this->arr_img_paths);
		if ($rs) {
			$path = PATH_BASE . $data->$field;
			@unlink($path);
			@unlink(str_replace('.png', '.webp', $path));
			@unlink(str_replace('.jpg', '.webp', $path));
			foreach ($this->arr_img_paths as $image) {
				@unlink(str_replace('/original/', '/' . $image[0] . '/', $path));
				@unlink(str_replace('/original/', '/' . $image[0] . '/', str_replace('.png', '.webp', $path)));
				@unlink(str_replace('/original/', '/' . $image[0] . '/', str_replace('.jpg', '.webp', $path)));
			}
		}
	}

	function delete_file()
	{
		global $db;
		$id = FSInput::get('id', 0);
		$field = FSInput::get('field');
		$data = $this->get_record_by_id($id, $this->table_name);
		$row = array();
		$row[$field] = '';
		$rs = $this->_update($row, $this->table_name, 'id = ' . $id);
		//print_r($this->arr_img_paths);
		if ($rs) {
			$path = PATH_BASE . $data->$field;
			@unlink($path);
		}
	}

	function get_all_config()
	{
		global $db;
		$fstable  = FSFactory::getClass('fstable');
		$sql = " SELECT * FROM " . $fstable->_('fs_config') . "
						WHERE is_common = 1
					 ";
		$db->query($sql);
		$list =  $db->getObjectList();
		$array_config = array();
		foreach ($list as $item) {
			$array_config[$item->name] = $item->value;
		}
		return $array_config;
	}

	function send_email1($title, $content, $nTo, $mTo, $diachicc = 'tuananh@finalstyle.com')
	{
		//global $email_info;

		$global_class = FSFactory::getClass('FsGlobal');

		$admin_name = $global_class->getConfig('admin_name');
		$admin_email = $global_class->getConfig('admin_email');

		$nFrom = $admin_name;

		$random = rand(1, 40);
		switch ($random) {
			case 1:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info@ketnoigiaoduc.vn';
				$mPass = 'lzsaw{JZnHDE';
				break;
			case 2:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info1@ketnoigiaoduc.vn';
				$mPass = 'WCGiL7u8puS{';
				break;
			case 3:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info2@ketnoigiaoduc.vn';
				$mPass = 'hF8lD4%s4Q_Q';
				break;
			case 4:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info3@ketnoigiaoduc.vn';
				$mPass = '&m]4u-Vv~#h;';
				break;
			case 5:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info4@ketnoigiaoduc.vn';
				$mPass = 'i00?[+kM40}4';
				break;
			case 6:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info5@ketnoigiaoduc.vn';
				$mPass = ']D^TrXwVmq^$';
				break;
			case 7:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info6@ketnoigiaoduc.vn';
				$mPass = '=P(E[$qza}TK';
				break;
			case 8:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info7@ketnoigiaoduc.vn';
				$mPass = 'Rz0[[-FRSy8o';
				break;
			case 9:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info8@ketnoigiaoduc.vn';
				$mPass = 'iE,SMN%60[X2';
				break;
			case 10:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info9@ketnoigiaoduc.vn';
				$mPass = 'm[0gfl9iT?oF';
				break;
			case 11:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info10@ketnoigiaoduc.vn';
				$mPass = '0L!_sgJmfI^h';
				break;
			case 12:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info11@ketnoigiaoduc.vn';
				$mPass = 'WI.2!spTDU?D';
				break;
			case 13:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info12@ketnoigiaoduc.vn';
				$mPass = 'Z1Fh{FdRWH!(';
				break;
			case 14:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info13@ketnoigiaoduc.vn';
				$mPass = '{xt]O$WPSBHl';
				break;
			case 15:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info14@ketnoigiaoduc.vn';
				$mPass = 'z?IZGe*&}S0}';
				break;
			case 16:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'info15@ketnoigiaoduc.vn';
				$mPass = 'rokmhFTxI;en';
				break;
			case 17:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin@ketnoigiaoduc.vn';
				$mPass = '^XBC8xRi3Woc';
				break;
			case 18:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin1@ketnoigiaoduc.vn';
				$mPass = 'HxN*03D.@Q5m';
				break;
			case 19:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin2@ketnoigiaoduc.vn';
				$mPass = 'vtuI1U4MaOT.';
				break;
			case 20:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin3@ketnoigiaoduc.vn';
				$mPass = 'M)mp56G%;I3L';
				break;
			case 21:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin4@ketnoigiaoduc.vn';
				$mPass = 'Rqq(O_?6oyiF';
				break;
			case 22:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin5@ketnoigiaoduc.vn';
				$mPass = 'W0,JH[h.{MW{';
				break;
			case 23:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin6@ketnoigiaoduc.vn';
				$mPass = 'i!He}Skz7kvE';
				break;
			case 24:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin7@ketnoigiaoduc.vn';
				$mPass = ',QB&bhtr*-A,';
				break;
			case 25:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin8@ketnoigiaoduc.vn';
				$mPass = '}~-vU8(8o9fr';
				break;
			case 26:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin9@ketnoigiaoduc.vn';
				$mPass = 'T@(vC@_9[K#m';
				break;
			case 27:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin10@ketnoigiaoduc.vn';
				$mPass = '1Bd3@T-Zyzd&';
				break;
			case 28:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin11@ketnoigiaoduc.vn';
				$mPass = 'cI-.hCJH4N3A';
				break;
			case 29:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin12@ketnoigiaoduc.vn';
				$mPass = '8#-AA~4^JEd_';
				break;
			case 30:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin13@ketnoigiaoduc.vn';
				$mPass = 'uWU73y[iS8r{';
				break;
			case 31:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin14@ketnoigiaoduc.vn';
				$mPass = 'J7n3,3(ii_Bg';
				break;
			case 32:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin15@ketnoigiaoduc.vn';
				$mPass = ']6]u$0WL5T(U';
				break;
			case 33:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin16@ketnoigiaoduc.vn';
				$mPass = 'daLomwC9RzFl';
				break;
			case 34:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin17@ketnoigiaoduc.vn';
				$mPass = '6_e#Mz0TK5Z%';
				break;
			case 35:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin18@ketnoigiaoduc.vn';
				$mPass = 'BTA0SL+s1o]&';
				break;
			case 36:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin19@ketnoigiaoduc.vn';
				$mPass = 'iU@-H,wt-c*U';
				break;
			case 37:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin20@ketnoigiaoduc.vn';
				$mPass = 'w$Ta5RB+tuMm';
				break;
			case 38:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin21@ketnoigiaoduc.vn';
				$mPass = 'Igkfh)()o,$%';
				break;
			case 39:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin22@ketnoigiaoduc.vn';
				$mPass = '8hluk)-@kg~d';
				break;
			case 40:
				$server = 'pro17.emailserver.vn';
				$mFrom = 'admin23@ketnoigiaoduc.vn';
				$mPass = 'eaFu9oc26Lb^';
				break;
		}
		//$mFrom = 'info@ketnoigiaoduc.vn'; //$email_info['mFrom'];//dia chi email cua ban
		//$mPass = 'lzsaw{JZnHDE'; // $email_info['mPass'];//mat khau email cua ban

		FSFactory::include_class('class.smtp', 'mailserver');
		$mail = FSFactory::getClass('PHPMailer', 'mailserver');

		$body = $content;

		$mail->IsSMTP();
		//Tắt mở kiểm tra lỗi trả về, chấp nhận các giá trị 0 1 2
		// 0 = off không thông báo bất kì gì, tốt nhất nên dùng khi đã hoàn thành.
		// 1 = Thông báo lỗi ở client
		// 2 = Thông báo lỗi cả client và lỗi ở server
		$mail->SMTPDebug = 0; // enables SMTP debug information (for testing)
		$mail->Debugoutput = "html"; // Lỗi trả về hiển thị với cấu trúc HTML
		$mail->CharSet = "utf-8";

		$mail->SMTPAuth = true; // enable SMTP authentication
		$mail->SMTPSecure = "ssl"; // sets the prefix to the servier
		$mail->Host = $server; //$email_info['Host'];
		$mail->Port = '465'; //$email_info['Port'];

		$mail->Username = $mFrom; // GMAIL username
		$mail->Password = $mPass; // GMAIL password

		$mail->SetFrom($mFrom, $nFrom);
		//chuyen chuoi thanh mang
		$ccmail = explode(',', $diachicc);
		$ccmail = array_filter($ccmail);

		if (!empty($ccmail)) {
			foreach ($ccmail as $k => $v) {
				$mail->addBCC($v);
			}
		}
		$mail->addCC($admin_email, $admin_name);
		$mail->Subject = $title;
		$mail->MsgHTML($body);
		//$mail->MsgHTML(file_get_contents('email-template.html'), dirname(__FILE__));

		$address = $mTo;

		$mail->AddAddress($address, $nTo);
		$mail->AddReplyTo($admin_email, $admin_name);

		if (!$mail->Send()) {
			echo $random;
			echo "Có lỗi khi gửi mail: " . $mail->ErrorInfo;
			die;
		}
		return true;
	}

	function get_auto_increment($TABLE_NAME)
	{
		global $db, $db_info;
		$auto_increment = 0;
		$db->query('SELECT `AUTO_INCREMENT`
                        FROM  INFORMATION_SCHEMA.TABLES
                        WHERE TABLE_SCHEMA = \'' . $db_info['dbName'] . '\'
                        AND   TABLE_NAME   = \'' . $TABLE_NAME . '\'');
		$row = $db->getObject();
		if ($row)
			$auto_increment = $row->AUTO_INCREMENT;
		return $auto_increment;
	}

	public function getAjaxSearchProduct_()
	{
		global $db;
		$where = '';
		$query = FSInput::get('query', '');
		$keyword = $query;
		$keyword = " name LIKE '%$keyword%'";
		$arr_tags = explode(' ', $query);
		$total_tags = count($arr_tags);
		if ($total_tags) {
			$j = 0;
			for ($i = 0; $i < $total_tags; $i++) {
				$item = trim($arr_tags[$i]);
				if ($item) {
					$where .= "AND `name` LIKE '%" . $item . "%'";
					$j++;
				}
			}
		}

		$sql = "SELECT id, alias, `name`, `image`, price, price_old, promotion_end_time, promotion_start_time, quantity, status_prd, code
                FROM fs_products 
                WHERE published = 1 $where OR `code` = '$query'
                ORDER BY CASE
                    WHEN $keyword THEN 1
                    ELSE 2
                END,
                quantity DESC, price ASC
        ";

		$sql = $db->query($sql);
		$result = $db->getObjectList();
		return $result;
	}

	public function getAjaxSearchProduct()
	{
		global $db;
		$where = '';
		$keyword = FSInput::get('keyword', '');
		$cat = FSInput::get('cat');

		if (!$keyword && !$cat) {
			$sql = "SELECT id, alias, `name`, `image`, price, price_old, quantity, status_prd, code
					FROM fs_products
					WHERE published = 1
					ORDER BY id DESC
			";
		} else {
			$query = "name LIKE '%$keyword%'";

			$arr_tags = explode(' ', $keyword);
			$total_tags = count($arr_tags);
			if ($total_tags) {
				$j = 0;
				for ($i = 0; $i < $total_tags; $i++) {
					$item = trim($arr_tags[$i]);
					if ($item) {
						$where .= "AND `name` LIKE '%" . $item . "%'";
						$j++;
					}
				}
			}

			if ($cat) {
				$where .= " AND category_id_wrapper LIKE '%,$cat,%' ";
			}

			$sql = "SELECT id, alias, `name`, `image`, price, price_old, quantity, status_prd, code
					FROM fs_products 
					WHERE published = 1 $where OR `code` = '$keyword'
					ORDER BY CASE
						WHEN $query THEN 1
						ELSE 2
					END,
					quantity DESC, price ASC
			";
		}
		
		$limit = FSInput::get('limit');
		if ($limit) {
			$sql .= " LIMIT $limit ";
		}

		$sql = $db->query($sql);
		$result = $db->getObjectList();
		return $result;
	}

	public function getAjaxSearchMembers()
	{
		global $db;
		$where = '';
		$keyword = FSInput::get('keyword', '');

		if (!$keyword) {
			$sql = "SELECT id, full_name, email, telephone, `point`
					FROM fs_members
					WHERE published = 1
					ORDER BY id DESC
			";
		} else {
			$query = "full_name LIKE '%$keyword%'";

			$arr_tags = explode(' ', $keyword);
			$total_tags = count($arr_tags);
			if ($total_tags) {
				$j = 0;
				for ($i = 0; $i < $total_tags; $i++) {
					$item = trim($arr_tags[$i]);
					if ($item) {
						$where .= "AND `full_name` LIKE '%" . $item . "%'";
						$j++;
					}
				}
			}

			$sql = "SELECT id, full_name, email, telephone, `point`
					FROM fs_members 
					WHERE published = 1 $where OR `telephone` = '$keyword' OR `email` = '$keyword'
					ORDER BY CASE
						WHEN $query THEN 1
						ELSE 2
					END,
					id DESC
			";
		}
		
		$limit = FSInput::get('limit');
		if ($limit) {
			$sql .= " LIMIT $limit ";
		}

		$sql = $db->query($sql);
		$result = $db->getObjectList();
		return $result;
	}

	public function getSaleProducts($productsId, $timeNow)
	{
		global $db;
		$query = "SELECT product_id, discount, discount_unit, total, ordered FROM fs_flash_sale_detail WHERE published = 1 AND product_id IN ($productsId) AND date_end >= '$timeNow' ";

		return $db->getObjectList($query, USE_MEMCACHE);
	}

	public function getSaleProduct($productsId, $timeNow)
	{
		global $db;
		$query = "SELECT product_id, discount, discount_unit, total, ordered FROM fs_flash_sale_detail WHERE published = 1 AND product_id = $productsId AND date_end >= '$timeNow' ";

		return $db->getObject($query, USE_MEMCACHE);
	}


	public function freeMemcache()
	{
		// $memcache = new Memcache();
		// $memcache->addServer('127.0.0.1', 11211);
		// $memcache->flush();
		// return true;
	}
}
