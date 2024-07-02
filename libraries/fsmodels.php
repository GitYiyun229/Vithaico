<?php
class FSModels
{
	var $limit;
	var $page;
	protected $tableProductFlashSale = 'fs_flash_sale_detail';

	function __construct()
	{
		$page = FSInput::get('page', 0, 'int');
		$limit = FSInput::get('limit', 10, 'int');
		$this->page = $page;
		$this->limit = $limit;
	}

	function _update($row, $table_name, $where = '', $use_mysql_real_escape_string = 0, $show = null)
	{
		$total = count($row);
		if (!$total || !$table_name)
			return;
		$sql = 'UPDATE ' . $table_name . ' SET ';
		$i = 0;
		foreach ($row as $key => $value) {
			$sql .= "`" . $key . "` = '" . $value . "'";
			if ($i < $total - 1)
				$sql .= ',';
			$i++;
		}
		if ($where)
			$where = ' WHERE ' . $where;
		$sql .= $where;

		if ($show) {
			echo $sql;
		}

		global $db;
		$db->query($sql);
		$rows = $db->affected_rows();
		return $rows;
	}

	function _add($row, $table_name, $use_mysql_real_escape_string = 0)
	{
		if (!$table_name)
			return false;
		$str_fields = array();
		$str_values = array();

		if (!count($row))
			return;
		foreach ($row as $field => $value) {
			$str_fields[] = "`" . $field . "`";

			$value = htmlspecialchars_decode($value);


			//			$value = htmlspecialchars($value);
			//			$value = mysql_real_escape_string($value);
			$str_values[] = "'" . $value . "'";
		}

		$str_fields = implode(',', $str_fields);
		$str_values = implode(',', $str_values);

		global $db;

		$sql = ' INSERT INTO  ' . $table_name;
		$sql .= '(' . $str_fields . ") ";
		$sql .= 'VALUES (' . $str_values . ") ";
		// print_r($sql);
		$db->query($sql);
		$id = $db->insert();

		return $id;
	}

	function _add_multiple($rows, $table_name, $use_mysql_real_escape_string = 0)
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
		 * Remove img
		 */
	// remove image of id IN str_id
	function remove_image($where, $path_arr = array(), $field = 'image', $table_name = '')
	{
		if (!$where || !count($path_arr))
			return;
		if (!$table_name)
			return false;
		$sql = " SELECT " . $field . "
					 FROM " . $table_name . "
					 WHERE  " . $where;
		global $db;
		$db->query($sql);
		$list = $db->getObjectList();

		for ($i = 0; $i < count($list); $i++) {
			$image = $list[$i]->$field;
			if ($image)
				for ($j = 0; $j < count($path_arr); $j++) {

					if (!@unlink($path_arr[$j] . $image)) {
						//						$fserrors = FSFactory::getClass('Errors');
						//						$fserrors -> _('Not remove image'.$path_arr[$j].$image);
						//						return false;
					}
				}
		}
		return true;
	}

	/*
	 * Get wrapper of list id
	 * ex: get parent_ids from fs_category where id IN ()
	 * return string of wrapper
	 */
	function _get_wrapper($tablename, $field_wrapper, $where_value, $where_field = 'id', $where_type = 'IN')
	{
		if (!$tablename || !$field_wrapper || !$where_value)
			return;
		$sql = ' SELECT  ' . $field_wrapper;
		$sql .= ' FROM ' . $tablename;
		if ($where_type == 'IN') {
			$sql .= ' WHERE  ' . $where_field . ' IN (' . $where_value . ') ';
		} else {
			$sql .= ' WHERE  ' . $where_field . $where_type . $where_value;
		}
		global $db;
		$db->query($sql);
		$list = $db->getObjectlist();

		$str_wrapper = '';
		for ($i = 0; $i < count($list); $i++) {
			$item = $list[$i];
			if ($item->$field_wrapper) {
				if ($str_wrapper)
					$str_wrapper .= ',';
				$str_wrapper .= $item->$field_wrapper;
			}
		}
		if (!$str_wrapper)
			return;
		$arr_wrapper = explode(',', $str_wrapper);
		$arr_wrapper = array_unique($arr_wrapper);
		return implode(',', $arr_wrapper);
	}

	function get_estore()
	{
		$estore_id = $_SESSION['estore_id'];
		if (!$estore_id)
			return;

		global $db;
		$sql = " SELECT id,category_ids,estore_name,estore_url,category_ids_wrapper,product_categories_wrapper, city_id, district_id,destination_ids,username,etemplate
				FROM fs_estores
				WHERE `id`  = '$estore_id' 
				";
		$db->query($sql);
		return $db->getObject();
	}

	/*
	 * get Destination
	 * default: Hoan kiem, Ha Noi
	 */
	function get_destination($district_id = '1478')
	{
		if (!$district_id)
			return false;
		global $db;
		$sql = " SELECT id, name FROM fs_destination
				WHERE district_id = $district_id ";
		$db->query($sql);
		return $db->getObjectList();
	}

	function alert_error($msg)
	{
		echo "<script type='text/javascript'>alert('" . $msg . "'); </script>";
	}

	function get_estore_by_ids($str_estore_id)
	{
		if (!$str_estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id IN (" . $str_estore_id . ") 
				AND published = 1";
		$db->query($sql);
		return $list = $db->getObjectListByKey('id');
	}

	function get_estore_by_id($estore_id)
	{
		if (!$estore_id)
			return;
		global $db;
		$sql = " SELECT id,estore_name,username,estore_url FROM fs_estores
				WHERE id = (" . $estore_id . ") 
				AND published = 1";
		$db->query($sql);
		return $list = $db->getObject();
	}

	/*
	 * get record by rid
	 */
	function get_record_by_id($id, $table_name = '', $select = '*')
	{
		if (!$id)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT " . $select . "
					  FROM " . $table_name . "
					  WHERE id = $id ";

		global $db;
		$sql = $db->query($query);
		$result = $db->getObject();
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
		$select = " SELECT " . $field . " ";
		$query = $select . "  FROM " . $table_name . "
					  WHERE " . $where;

		global $db;
		$sql = $db->query($query);
		$result = $db->getResult();
		return $result;
	}

	/*
	 * select count(...) thỏa mãn điều kiện
	 */
	function get_count($where = '', $table_name = '', $select = '*')
	{
		if (!$where)
			return;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = ' SELECT count(' . $select . ')
					  FROM ' . $table_name . '
					  WHERE ' . $where;

		global $db;
		$sql = $db->query($query);
		$result = $db->getResult();
		return $result;
	}

	/*
	 * get record by rid
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
		// echo $query;
		global $db;
		//$db->query ( $query );
		$result = $db->getObject($query, USE_MEMCACHE);
		return $result;
	}

	/*
	 * get records
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

		//		echo $query;
		global $db;
		$sql = $db->query($query);
		if (!$field_key)
			$result = $db->getObjectList('', USE_MEMCACHE);
		else
			$result = $db->getObjectListByKey($field_key);
		return $result;
	}

	/*
	 * save into table
	 */
	function _save($row = array(), $table_name = '', $use_mysql_real_escape_string = 0)
	{
		$id = FSInput::get('id', 0, 'int');
		if (!$id)
			return $this->_add($row, $table_name, $use_mysql_real_escape_string);
		else
			return $this->_update($row, $table_name, ' WHERE id = ' . $id, $use_mysql_real_escape_string);
	}

	function get_countries()
	{
		global $db;
		$sql = " SELECT id, name FROM fs_countries
				WHERE published = 1
				ORDER BY `ordering`
				";
		$db->query($sql);
		return $db->getObjectList();
	}

	/*
	 * get list District
	 * default: Ha Noi
	 */
	function get_districts($city_id)
	{
		if (!$city_id)
			return;
		global $db;
		$sql = " SELECT id, name FROM fs_districts
				WHERE city_id = $city_id 
				AND published = 1
				ORDER BY `ordering`
				";
		$db->query($sql);
		return $db->getObjectList();
	}

	function get_cities($country_id = 66)
	{
		global $db;
		$sql = " SELECT id, name FROM fs_cities 
				WHERE country_id = $country_id 
				AND published = 1
				ORDER BY `ordering`";
		$db->query($sql);
		return $db->getObjectList();
	}

	function get_communes($district_id = 66)
	{
		global $db;
		$sql = " SELECT id, name FROM fs_commune
				WHERE district_id = $district_id 
				AND published = 1
				ORDER BY `ordering`";
		$db->query($sql);
		return $db->getObjectList();
	}

	function get_sitemap($level = 0)
	{
		$where = '';
		if ($level)
			$where .= ' AND level < "' . $level . '" ';
		global $db;
		$sql = " SELECT name,alias, level, parent_id,module, record_id as id,id as sitemap_id
				FROM fs_sitemap
				WHERE published  = 1
				" . $where . "
				ORDER BY module,ordering";
		$db->query($sql);
		$list = $db->getObjectList();
		if (!$list)
			return;
		$tree_class = FSFactory::getClass('tree', 'tree/');

		// call views
		$arr_sitemap = array();
		foreach ($list as $item) {
			if (!isset($arr_sitemap[$item->module]))
				$arr_sitemap[$item->module] = array();
			$arr_sitemap[$item->module][] = $item;
		}
		if (!count($arr_sitemap))
			return;
		foreach ($arr_sitemap as $key => $items) {
			$arr_sitemap[$key] = $tree_class->indentRows($items);
		}
		return $arr_sitemap;
	}

	function check_exist($value, $id = '', $field = 'alias', $table_name = '')
	{
		if (!$value)
			return true;
		if (!$table_name)
			$table_name = $this->table_name;
		$query = " SELECT count(*)
					  FROM " . $table_name . " 
					WHERE 
						$field = '" . $value . "' ";
		if ($id)
			$query .= ' AND id <> ' . $id . ' ';
		global $db;
		$sql = $db->query($query);
		$result = $db->getResult();
		return $result;
	}

	/*
	 * Chèn từ khóa vào nội dung ( bài viết hoặc sản phẩm)
	 */
	function insert_keyword_to_content($content)
	{
		$content = htmlspecialchars_decode($content);
		$arr_keyword_name = $this->get_records('published = 1', 'fs_keywords', 'name,link');
		if (count($arr_keyword_name)) {
			foreach ($arr_keyword_name as $item) {
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)' . $item->name . '(((^((?!<a>).)*$))*?)</a>#is', $content, $rs);
				if (count($rs))
					continue;
				$link = $item->link ? FSRoute::_($item->link) : FSRoute::_('index.php?module=products&view=search&keyword=' . str_replace(' ', '+', trim($item->name)));
				$content  = str_replace($item->name, '<a href="' . $link . '" >' . $item->name . '</a>', $content);
			}
		}
		return $content;
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
		$sql = $db->query($query);
		$result = $db->getResult();
		if (!$result)
			return 1;
		return ($result + 1);
	}

	function send_email1($title, $content, $nTo, $mTo, $diachicc = '', $is_mail = 0)
	{
		//global $email_info;
		global $config;
		$global_class = FSFactory::getClass('FsGlobal');

		$admin_name = $global_class->getConfig('admin_name');
		$admin_email = $global_class->getConfig('admin_email');

		// print_r($admin_email);die;
		$nFrom = $admin_name;

		// $server = 'smtp.gmail.com';
		// $mFrom = 'mail.finalstyle.noreply@gmail.com';
		// $mPass = 'fs123456!@#$%^';
		$server = $config['mail_host'];
		$mFrom = $config['mail_email'];
		$mPass = $config['mail_password'];

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
		$mail->SMTPSecure = $config['mail_secure']; // sets the prefix to the servier
		$mail->Host = $server; //$email_info['Host'];
		$mail->Port = $config['mail_port']; //$email_info['Port'];

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

		if ($is_mail)
			$mail->addCC($admin_email, $admin_name);

		$mail->Subject = $title;
		$mail->MsgHTML($body);

		// print_r($admin_name);die;
		//$mail->MsgHTML(file_get_contents('email-template.html'), dirname(__FILE__));

		$address = $mTo;

		$mail->AddAddress($address, $nTo);
		$mail->AddReplyTo($admin_email, $admin_name);

		if (!$mail->Send()) {
			return true;
			//echo $random;
			//                echo "có lỗi khi gửi email: " . $mail->ErrorInfo;
			//                die;
		}
		return false;
	}

	// public function getSaleProducts($productsId, $timeNow)
	// {
	// 	global $db;
	// 	$query = "SELECT product_id, quantity, quantity_user, sold, price, percent, `type` FROM fs_promotion_discount_detail WHERE product_id IN ($productsId) AND DATE(date_end) >= DATE('$timeNow') ";

	// 	return $db->getObjectList($query, USE_MEMCACHE);
	// }

	public function getPromotionDiscountProduct($productsId, $timeNow)
	{
		global $db;
		$sql = "SELECT id, promotion_id, product_id, quantity, quantity_user, sold, price, percent, `type`, date_end, date_start 
				FROM fs_promotion_discount_detail 
				WHERE published = 1 AND product_id = $productsId AND DATE(date_end) >= DATE('$timeNow') 
				AND ((quantity > 0 AND sold < quantity) OR (quantity = 0)) ORDER BY date_start ASC
		"; 
		return $db->getObject($sql, USE_MEMCACHE);
	}

	public function getPromotionDiscountProducts($productsId, $timeNow)
	{
		global $db;
		$sql = "SELECT id, promotion_id, product_id, quantity, quantity_user, sold, price, percent, `type`, date_end, date_start 
				FROM fs_promotion_discount_detail 
				WHERE published = 1 AND product_id IN ($productsId) AND DATE(date_end) >= DATE('$timeNow') 
				AND ((quantity > 0 AND sold < quantity) OR (quantity = 0)) ORDER BY date_start DESC
		";
		return $db->getObjectList($sql, USE_MEMCACHE);
	}

	function _remove($where = '', $table_name = '')
	{ 
		if (!$table_name || $where)
			return false;

		$sql = " DELETE FROM $table_name WHER $where";

		global $db;
		$rows = $db->affected_rows($sql); 
		return $rows;
	}
}
