<?php
class FSControllers
{
	var $module;
	var $view;
	var $model;
	public $cartList = [];
	protected $tableProductFlashSale = 'fs_flash_sale_detail';

	function __construct()
	{
		global $module, $view;

		// $db->query("SELECT * FROM fs_redirect WHERE alias = '".FSInput::get('ccode')."' ");
		// $rs_request = $db->getObject();
		// $module = @$rs_request->module ? @$rs_request->module : 'home';
		// $view = @$rs_request->view ? @$rs_request->view : $module;
		$this->module = $module;
		$this->view  = $view;
		require_once 'modules/' . $this->module . '/models/' . $this->view . '.php';
		$model_name = ucfirst($this->module) . 'Models' . ucfirst($this->view);
		// echo $this -> pre_load($_SERVER['SERVER_ADDR'],$_SERVER['SERVER_ADDR']);
		//if($this -> pre_load($_SERVER['SERVER_ADDR'],$_SERVER['SERVER_ADDR']) != 'dzI1NDU0NDQzNDQ0dzIzNGY0czJuMnMyejJlNA==')die;
		$this->model = new $model_name();
		$this->cartList = $this->calculateCartPrice();
	}

	/*
	 * function lấy array F1 
	 */
	function GetArrayInfoF1($ref_code)
	{
		$members = $this->model->get_records('ref_by = ' . $ref_code, 'fs_members', 'id,level'); // lấy thông tin danh sách F1
		$array_id = [
			'array_ids' => [],
			'string_ids' => '',
			'count_ids' => '',
			'count_total_daily' => '',
			'total_price_order_F1' => '',
		];

		$total_daily = 0;

		if (!empty($members)) {
			$string_ids = [];
			foreach ($members as $item) {
				$array_id['array_ids'][] =  $item->id; // lấy danh sách id theo mảng
				$string_ids[] = $item->id;
				if ($item->level >= 2) //tính tổng F1 của member có bao nhiêu đại lý
				{
					$total_daily += 1;
				}
			}
			$array_id['string_ids'] = implode(',', $string_ids);  // lấy danh sách id theo chuỗi
			$array_id['count_ids'] = count($members);	// đếm số lượng f1
			$array_id['count_total_daily'] = $total_daily;
		}

		if (!empty($array_id['string_ids'])) { // lấy tổng doanh số nhóm 
			$total = $this->model->get_records("user_id IN (" . $array_id['string_ids'] . ")", 'fs_order', 'SUM(total_before) AS total_before_sum');
			if (!empty($total) && isset($total[0]->total_before_sum)) {
				$array_id['total_price_order_F1'] = $total[0]->total_before_sum;
			} else {
				$array_id['total_price_order_F1'] = 0;
			}
		}

		return $array_id;
	}



	/*
	 * function check Captcha
	 */
	function check_captcha()
	{
		$captcha = FSInput::get('txtCaptcha');
		if ($captcha == $_SESSION["security_code"]) {
			return true;
		}
		return false;
	}

	function ajax_check_captcha()
	{
		$result = $this->check_captcha();
		echo $result ? 1 : 0;
	}

	function alert_error($msg)
	{
		echo "<script type='text/javascript'>alert('" . $msg . "'); </script>";
	}

	function get_cities_ajax()
	{
		$model = $this->model;
		$cid = FSInput::get('cid');
		$rs  = $model->get_cities($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if (count($rs))
			foreach ($rs as $item) {
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}

	function get_location_ajax()
	{
		$model = $this->model;
		$cid = FSInput::get('cid', 0, 'int');
		$type = FSInput::get('type');
		$where = '';
		if ($type == 'city') {
			$tablename = 'fs_cities';
			$where = ' AND country_id = ' . $cid . ' ';
		} else if ($type == 'district') {
			$where = ' AND city_id = ' . $cid . ' ';
			$tablename = 'fs_districts';
		} else if ($type == 'commune') {
			$where = ' AND district_id = ' . $cid . ' ';
			$tablename = 'fs_commune';
		} else {
			return;
		}
		$rs  = $model->get_records(' published = 1' . $where, $tablename, 'id,name', ' ordering, id');

		$json = '['; // start the json array element
		$json_names = array();
		if (count($rs))
			foreach ($rs as $item) {
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		//		$json .= ',{id: 0, name: "Tự nhập nếu không có"}]'; // end the json array element
		$json .= ']'; // end the json array element
		echo $json;
	}

	function get_districts_ajax()
	{
		$model = $this->model;
		$cid = FSInput::get('cid');
		$rs  = $model->get_districts($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if (count($rs))
			foreach ($rs as $item) {
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}

	function get_commune_ajax()
	{
		$model = $this->model;
		$cid = FSInput::get('cid');
		$rs  = $model->get_communes($cid);

		$json = '['; // start the json array element
		$json_names = array();
		if (count($rs))
			foreach ($rs as $item) {
				$json_names[] = "{id: $item->id, name: '$item->name'}";
			}
		$json_names[] = "{id: 0, name: 'Tự nhập nếu không có'}";
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}

	function arrayToObject($array)
	{
		if (!is_array($array)) {
			return $array;
		}

		$object = new stdClass();
		if (is_array($array) && count($array) > 0) {
			foreach ($array as $name => $value) {
				$name = strtolower(trim($name));
				if (!empty($name)) {
					$object->$name = $this->arrayToObject($value);
				}
			}
			return $object;
		} else {
			return FALSE;
		}
	}

	function pre_load($string, $k)
	{
		$k = sha1($k);
		$strLen = strlen($string);
		$kLen = strlen($k);
		$j = 0;
		$hash = '';
		for ($i = 0; $i < $strLen; $i++) {
			$ordStr = ord(substr($string, $i, 1));
			if ($j == $kLen) {
				$j = 0;
			}
			$ordKey = ord(substr($k, $j, 1));
			$j++;
			$hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
		}
		return base64_encode($hash);
	}

	function insert_link_keyword2($description)
	{
		$model = $this->model;
		$description = htmlspecialchars_decode($description);
		$arr_keyword_name = $model->get_records('published = 1', 'fs_keywords', 'name,link');

		if (count($arr_keyword_name)) {
			foreach ($arr_keyword_name as $item) {

				//				print_r($item);
				//				preg_match('#<a[^>]*>(.*?)'.$item ->name.'(.*?)</a>#is',$description,$rs);
				//				preg_match('#<a[^>]*>([^<]*?)'.$item ->name.'([^>]*?)</a>#is',$description,$rs);
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)' . $item->name . '(((^((?!<a>).)*$))*?)</a>#is', $description, $rs);
				if (count($rs))
					continue;
				preg_match('#<img([^>]*)' . $item->name . '(.*?)/>#is', $description, $rs);
				if (count($rs))
					continue;
				if ($item->link)
					$link = $item->link;
				else
					$link = FSRoute::_('index.php?module=' . $this->module . '&view=search&keyword=' . $item->name);
				$description  = str_replace($item->name, '<a href="' . $link . '" class="follow red">' . $item->name . '</a>', $description);
			}
		}
		return $description;
	}

	function insert_link_keyword($description)
	{
		$model = $this->model;
		$description = htmlspecialchars_decode($description);
		$arr_keyword_name = $model->get_records('published = 1', 'fs_keywords', 'name,link');
		if (count($arr_keyword_name)) {
			foreach ($arr_keyword_name as $item) {
				$keyword = $item->name;
				preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)' . $keyword . '(((^((?!<a>).)*$))*?)</a>#is', $description, $rs);
				if (!count($rs)) {
					preg_match('#<a([^>]*)' . $keyword . '([^>]*)\>#is', $description, $rs);
					if (!count($rs)) {
						preg_match('#<img([^>]*)' . $keyword . '(.*?)/>#is', $description, $rs);
						if (!count($rs)) {
							if ($item->link)
								$link = $item->link;
							else
								$link = FSRoute::_('index.php?module=' . $this->module . '&view=search&keyword=' . str_replace(' ', '-', $keyword));
							$description  = str_replace($keyword, '<a href="' . $link . '" class="follow red">' . $keyword . '</a>', $description);
						}
					}
				}

				$keyword2 = htmlentities($item->name, ENT_COMPAT, "UTF-8");
				if ($keyword != $keyword2) {
					preg_match('#<a[^>]*>((^((?!</a>).)*$)*?)' . $keyword2 . '(((^((?!<a>).)*$))*?)</a>#is', $description, $rs);
					if (count($rs))
						continue;
					preg_match('#<a([^>]*)' . $keyword . '([^>]*)\>#is', $description, $rs);
					if (count($rs))
						continue;
					preg_match('#<img([^>]*)' . $keyword2 . '(.*?)/>#is', $description, $rs);
					if (count($rs))
						continue;


					if ($item->link)
						$link = $item->link;
					else
						$link = FSRoute::_('index.php?module=' . $this->module . '&view=search&keyword=' . str_replace(' ', '-', $keyword));
					$description  = str_replace($keyword2, '<a href="' . $link . '" class="follow red">' . $keyword2 . '</a>', $description);
				}
			}
		}
		return $description;
	}

	public function nomalizeProducts($products, $promotionDiscount = NULL)
	{
		global $user;
		if (!empty($products)) {
			$arrProductId = [];
			$timeNow = date('Y-m-d H:i:s');

			foreach ($products as $item) {
				$arrProductId[] = $item->id;
			}

			if ($user->userID) {
				$promotionDiscount = $this->model->getPromotionDiscountProducts(implode(',', $arrProductId), $timeNow);
			}

			foreach ($products as $item) {
				$item = $this->nomalizeProduct($item, $promotionDiscount);
			}
		}

		return $products;
	}

	public function nomalizeProduct($item, $promotionDiscount = NULL)
	{
		$item->price_public = $item->price;
		$item->price_discount = $item->price;
		$item->price_old = $item->price_old ?: $item->price;
		$item->percent = $item->price_public && $item->price_old != 0 && $item->price_public < $item->price_old ? 100 - round($item->price_public / $item->price_old * 100, 0) : 0;

		$item->total_flashsale = 0;
		$item->ordered_flashsale = 0;

		$item->have_discount = 0;
		$item->have_wholesale = 0;
		$item->have_voucher = 0;
		$item->have_gift = 0;
		$item->have_flash = 0;

		if (!empty($promotionDiscount) && $item->price_public) {
			if (is_array($promotionDiscount)) {
				foreach ($promotionDiscount as $promotion) {
					if ($promotion->product_id == $item->id) {
						$promotionInfo = $promotion;
						// break;
					}
				}
			} else {
				$promotionInfo = $promotionDiscount;
			}

			if (isset($promotionInfo) && $promotionInfo->product_id == $item->id) {
				$item->have_discount = !$promotionInfo->type ? 1 : 0;
				$item->have_flash = $promotionInfo->type;
				$item->total_flashsale = $promotionInfo->quantity ?: $item->quantity;
				$item->ordered_flashsale = $promotionInfo->sold;

				if ($promotionInfo->price && $promotionInfo->price > 0) {
					$item->price_discount = $promotionInfo->price;
				} else {
					$item->price_discount = round($item->price_public - $promotionInfo->percent * $item->price_public / 100, -3);
				}

				if (!$promotionInfo->quantity_user) {
					$item->price_public = $item->price_discount;
				}

				$item->percent = round(100 - $item->price_public * 100 / $item->price_old, 0);
			}
		}

		return $item;
	}

	public function layoutProductItem($item)
	{
		global $user;

		$url = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
		$src = URL_ROOT . str_replace(['/original/', '.jpg', '.png'], ['/resize/', '.webp', '.webp'], $item->image);

?>
		<div class="layout-product-item position-relative"> <a href="<?php echo $url ?>" title="<?php echo $item->name ?>" class="layout-product-item position-relative" target="_blank">
				<div class="box-img">
					<img src="<?php echo $src ?>" alt="" class="img-fluid layout-img" onerror="this.src='/images/not_picture.png'">
				</div>

				<div class="layout-content">
					<div class="layout-name">
						<?php echo $item->name ?>
					</div>
					<div class="layout-public-price">
						<?php if ($user->userID) { ?>
							<div class="price">
								<?php echo format_money($item->price, '₫') ?>
							</div>
						<?php } else { ?>
							<a href="<?php echo FSRoute::_('index.php?module=members&view=user&task=login') ?>" class="title_see_price"><?= FSText::_('Đăng nhập để xem giá') ?></a>
						<?php } ?>
					</div>
				</div>
			</a>
		</div>
	<?php
	}
	public function layoutProductItemFlashSale($item)
	{
		$url = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
		$src = URL_ROOT . str_replace(['/original/', '.jpg', '.png'], ['/larges/', '.webp', '.webp'], $item->image);

	?>
		<div class="layout-product-item position-relative">
			<div class="box-img">
				<img src="<?php echo $src ?>" alt="" class="img-fluid layout-img" onerror="this.src='/images/not_picture.png'">
			</div>
			<div class="layout-addcart position-absolute">
				<p class="btn-submit add-cart text-center fw-bold">
					<?php echo FSText::_('Thêm vào giỏ') ?>
				</p>
			</div>
			<a href="<?php echo $url ?>" title="<?php echo $item->name ?>" class="layout-product-item position-relative" target="_blank">
				<div class="layout-content">
					<div class="layout-name">
						<?php echo $item->name ?>
					</div>
					<div class="layout-public-price">
						<div class="price">

							<?= format_money($item->price_public, '₫') ?>
						</div>

						<div class="layout-origin-price">
							<?= format_money($item->price, '₫') ?>
						</div>
						<div class="layout-info">

							<!-- <div class="item-info item-flash">Flashsale</div> -->
							<div class="item-info item-percent">- <?php echo $item->percent ?>%</div>
						</div>
					</div>
				</div>
			</a>
		</div>
<?php
	}

	public function calculateCartPrice()
	{
		global $user;
		$cart = @$_SESSION['cart'] ?: [];
		if (!empty($cart)) {
			$productID = array_map(function ($item) {
				return $item['product_id'];
			}, $cart);
			$products = $this->model->get_records("id IN (" . implode(",", $productID) . ") AND published = 1", "fs_products", "id, alias,coin, name, quantity, image,price_discount, price, price_old");
			foreach ($cart as $i => $item) {
				foreach ($products as $product) {

					if ($item['product_id'] == $product->id) {
						$cart[$i]['url'] = FSRoute::_("index.php?module=products&view=product&code=$product->alias&id=$product->id");
						$cart[$i]['product_name'] = $product->name;
						$cart[$i]['image'] = $product->image;

						if ($user->userID) {
							$cart[$i]['price'] = $product->price_discount;  // giá khi đăng nhập là lấy giá triết khấu
							$cart[$i]['price_old'] = $product->price; 	//giá cũ mua lẻ
							$cart[$i]['coin'] = $product->coin;
						} else {
							$cart[$i]['price'] = $product->price; // giá khi không đăng nhập là lấy giá bán lẻ 
							$cart[$i]['price_old'] =  0; //giá cũ mua lẻ
							$cart[$i]['coin'] = 0;
						}
						break;
					}
				}
			}
		}

		return $cart;
	}

	public function calculateMemberCoin($id, $coin)
	{

		$row = [
			'vt_coin' =>  $coin,
		];

		$update = $this->model->_update($row, 'fs_members', 'id =' . $id);

		return $update;
	}

	/*
	 * function lấy tích luỹ mua hàng của thành viên
	 */
	function GetCoinMember()
	{
		global $user;
		$users = $user->userInfo;
		$total_order = 0;
		$order_info = $this->model->get_records("user_id = '" . $users->id . "' ", 'fs_order', 'member_coin');
		foreach ($order_info as $item) {
			$total_order += $item->member_coin;
		}
		return $total_order;
	}
	/*
	 *  function tính hạng cho chính member
	 */
	public function calculateMemberRankDaiLy()
	{
		global $user;
		$users = $user->userInfo;
		$total_order = 0;
		$order_info = $this->model->get_records("user_id = '" . $users->id . "'", 'fs_order', 'total_before');

		foreach ($order_info as $item) {
			$total_order += $item->total_before;
		}
		return $total_order;
	}

	/*
 *  Hàm tính hạng cho thành viên chính
 */
	public function calculateMemberRank($id)
	{
		$total_member_coin = 0;
		$orderInfo = $this->model->get_records("user_id = '" . $id . "'", 'fs_order', 'member_coin'); // thông tin đơn hàng của member đăng nhập hiện tại
		if (!empty($orderInfo)) {
			foreach ($orderInfo as $item) { // for để lấy tổng doanh số
				$total_member_coin += $item->member_coin;
			}
			$member = $this->model->get_record('id=' . $id, 'fs_members', 'id,level,hoa_hong,ref_code,ref_by'); // lấy thông tin của id hiện tại
			if (!empty($member)) {
				$infoF1 = $this->getArrayInfoF1($member->ref_code);
				$level = $member->level;
				// Kiểm tra hạng thành viên dựa trên $total_member_coin và các điều kiện F1
				switch (true) {
					case $level < 6 && $total_member_coin > 300 && ($infoF1['count_total_daily'] >= 200 || $infoF1['total_price_order_F1'] >= 1000000000):
						$level = 6;
						break;
					case $level < 5 && $total_member_coin > 300 && ($infoF1['count_total_daily'] >= 50 || $infoF1['total_price_order_F1'] >= 200000000):
						$level = 5;
						break;
					case $level < 4 && $total_member_coin > 300 && ($infoF1['count_total_daily'] >= 10 || $infoF1['total_price_order_F1'] >= 50000000):
						$level = 4;
						break;
					case $level < 3 && $total_member_coin > 300:
						$level = 3;
						break;
					case $level < 2 && $total_member_coin >= 100 && $total_member_coin <= 300:
						$level = 2;
						break;
					case $level < 1 && $total_member_coin > 1 && $total_member_coin <= 99:
						$level = 1;
						break;
					case  $total_member_coin <= 1:
						$level = 1;
						break;
				}

				// Cập nhật hạng thành viên nếu có thay đổi
				if ($member->level < $level) {
					$this->updateMemberRank($level, $id);
				}
			}
		}

		// Xử lý bước kiểm tra điều kiện F0 ở đây
		$member = $this->model->get_record('id=' . $id, 'fs_members', 'id,level,hoa_hong,ref_code,ref_by,vt_coin');

		return $member;
	}


	/*
	 *function tính update hạng cho thành viên khi đạt đủ điều kiện lên hạng
	 */
	public function UpdateMemberRank($level, $id)
	{

		$member = $this->model->get_record('id=' . $id, 'fs_members', 'id,level,hoa_hong,ref_code,ref_by,vt_coin');

		$levelInfo = $this->model->get_record('level = ' . $level, 'fs_members_group', '*');
		if (!empty($level) && $level >= $member->level) {
			$row = [
				'level' => $level,
				'hoa_hong' => $levelInfo->member_benefits,
			];
			$update_level = $this->model->_update($row, 'fs_members', 'id =' . $member->id);
			if ($update_level) {
				$row_log = [
					'level' => $level,
					'user_id' => $member->id,
					'created_time' => date('Y-m-d H:i:s'),
				];
				$log = $this->model->_add($row_log, 'fs_update_rank_log');
			}
		}
		return $update_level;
	}

	/*
	 *function tính phí Mỗi tháng phát sinh đơn hàng 2.800.000đ để duy trì hạng của mình.
	 */
	public function calculateMemberCheckToMonth()
	{
		global $user;
		$users = $user->userInfo;
		$total_month = 0;
		$order_info_month = $this->model->get_records("user_id = '" . $users->id . "' AND created_time >= DATE_FORMAT(NOW() ,'%Y-%m-01') AND created_time < DATE_ADD(DATE_FORMAT(NOW() ,'%Y-%m-01'), INTERVAL 1 MONTH ) ", 'fs_order', 'total_before');

		foreach ($order_info_month as $item) {
			$total_month += $item->total_before;
		}

		return $total_month;
	}
	/*
	* function tính theo tuần xem phát sinh đơn hàng bao nhiêu
	*/
	public function calculateMemberCheckToWeek()
	{
		global $user;
		$users = $user->userInfo;
		$total_week = 0;
		$order_info_month = $this->model->get_records("user_id = '" . $users->id . "' AND created_time >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY) AND created_time < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 7 DAY) ", 'fs_order', 'total_before');

		foreach ($order_info_month as $item) {
			$total_week += $item->total_before;
		}

		return $total_week;
	}
}
