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
							<?php echo format_money($item->price_discount, '₫') ?>
						</div>
						<div class="layout-origin-price">
							<?php echo $item->price_old && $item->price_discount < $item->price_old ? format_money($item->price_old, '₫') : '' ?>
						</div>
						<div class="layout-info">
							<?php if ($item->have_flash) { ?>
								<div class="item-info item-flash">Flashsale</div>
							<?php } ?>
							<?php if ($item->is_gift) { ?>
								<div class="item-info item-gift">Quà tặng</div>
							<?php } ?>
							<?php if ($item->freeship) { ?>
								<div class="item-info item-freeship">Freeship</div>
							<?php } ?>
							<?php if ($item->percent) { ?>
								<div class="item-info item-percent">- <?php echo $item->percent ?>%</div>
							<?php } ?>
						</div>
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

			$subID = array_map(function ($item) {
				return $item['sub_id'];
			}, $cart);

			$products = $this->model->get_records("id IN (" . implode(",", $productID) . ") AND published = 1", "fs_products", "id, alias, name, quantity, code, nhanh_id, image, price, price_old");
			$subs = $this->model->get_records("id IN (" . implode(",", $subID) . ") AND published = 1", "fs_products_sub", "id, product_id, name, quantity, code, nhanh_id, price, price_old");
			$subsImages = $this->model->get_records("sub_id IN (" . implode(",", $subID) . ") AND record_id != 0", "fs_products_images", "id, image, record_id, sub_id");

			/**
			 * Chỉ hiện các KM nếu đăng nhập
			 */
			if ($user->userID) {
				$promotionDiscount = $this->model->getPromotionDiscountProducts(implode(',', $productID), date('Y-m-d H:i:s'));

				/**
				 * Tìm đơn hàng đã mua trong thời gian diễn ra discount/flash
				 */
				if (!empty($promotionDiscount)) {
					$arrQuery = array_map(function ($item) {
						return " (DATE(created_time) >= DATE('$item->date_start') AND DATE(created_time) <= DATE('$item->date_end')) ";
					}, $promotionDiscount);

					$order = $this->model->get_records("user_id = $user->userID AND ( " . implode(' OR ', $arrQuery) . ")", "fs_order");

					if (!empty($order)) {
						$orderID = array_map(function ($item) {
							return $item->id;
						}, $order);
						$orderDetail = $this->model->get_records("order_id IN (" . implode(',', $orderID) . ") AND promotion_discount_id <> 0", "fs_order_items");
					}
				}
			}

			foreach ($subs as $sub) {
				$sub->image = '';
				foreach ($subsImages as $image) {
					if ($sub->id == $image->sub_id) {
						$sub->image = $image->image;
					}
				}
			}

			foreach ($products as $product) {
				foreach ($subs as $sub) {
					if ($product->id == $sub->product_id) {
						$product->sub_code = $sub->code;
						$product->sub_nhanh_id = $sub->nhanh_id;
						$product->sub_name = $sub->name;
						$product->sub_image = $sub->image;
						$product->sub_price = $sub->price;
						$product->sub_price_old = $sub->price_old;
					}
				}

				if (!empty($promotionDiscount)) {
					foreach ($promotionDiscount as $promo) {
						if ($product->id == $promo->product_id) {
							$product->promotionDiscount = $promo;
							// break;
						}
					}
				}
			}

			foreach ($cart as $i => $item) {
				foreach ($products as $product) {
					if ($item['product_id'] == $product->id) {
						$cart[$i]['url'] = FSRoute::_("index.php?module=products&view=product&code=$product->alias&id=$product->id");
						$cart[$i]['code'] = $product->code;
						$cart[$i]['nhanh_id'] = $product->nhanh_id;
						$cart[$i]['product_name'] = $product->name;
						$cart[$i]['image'] = $product->image;
						$cart[$i]['price'] = $product->price;
						$cart[$i]['price_old'] = $product->price_old;
						$cart[$i]['promotion_discount'] = 0;
						$cart[$i]['promotion_discount_id'] = 0;
						$cart[$i]['promotion_discount_quantity'] = 0;

						if ($item['sub_id']) {
							$cart[$i]['code'] = $product->sub_code;
							$cart[$i]['nhanh_id'] = $product->sub_nhanh_id;
							$cart[$i]['sub_name'] = $product->sub_name;
							$cart[$i]['price'] = $product->sub_price;
							$cart[$i]['price_old'] = $product->sub_price_old;
							if ($product->sub_image) {
								$cart[$i]['image'] = $product->sub_image;
							}
						}

						if (isset($product->promotionDiscount)) {
							$cart[$i]['promotion_discount_id'] = $product->promotionDiscount->promotion_id;
							if ($product->promotionDiscount->quantity_user) {
								if ($product->promotionDiscount->price && $product->promotionDiscount->price > 0) {
									$price_discount = $cart[$i]['price'] - $product->promotionDiscount->price;
								} else {
									$price_discount = round($product->promotionDiscount->percent * $cart[$i]['price'] / 100, -3);
								}

								$quantity_discount = $product->promotionDiscount->quantity_user <= $cart[$i]['quantity'] ? $product->promotionDiscount->quantity_user : $cart[$i]['quantity'];

								/**
								 * Tính tổng sp có áp dụng discount/flash đã mua
								 */
								if (!empty($orderDetail)) {
									$orderQuantity = 0;
									foreach ($orderDetail as $orderDetailItem) {
										if ($orderDetailItem->product_id == $item['product_id'] && $orderDetailItem->promotion_discount_id == $product->promotionDiscount->promotion_id) {
											$orderQuantity += $orderDetailItem->promotion_discount_quantity;
										}
									}

									if ($orderQuantity >= $product->promotionDiscount->quantity_user) {
										$quantity_discount = 0;
									} else {
										$quantity_discount = $quantity_discount - $orderQuantity;
									}
								}
								$cart[$i]['promotion_discount'] = $price_discount * $quantity_discount;
								$cart[$i]['promotion_discount_quantity'] = $quantity_discount;
							} else {
								if ($product->promotionDiscount->price && $product->promotionDiscount->price > 0) {
									$cart[$i]['price'] = $product->promotionDiscount->price;
								} else {
									$cart[$i]['price'] = round($cart[$i]['price'] - $product->promotionDiscount->percent * $cart[$i]['price'] / 100, -3);
								}
							}
						}
						break;
					}
				}
			}
		}

		return $cart;
	}
}
