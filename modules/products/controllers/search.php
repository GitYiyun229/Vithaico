<?php

class ProductsControllersSearch extends FSControllers
{
    public $getPrice;
    public $getFilter;
    public $getSort;
    public $getKeyword;

	public function __construct()
	{
		parent::__construct();
		$this->getPrice = FSInput::get('price');
        $this->getFilter = FSInput::get('filter');
        $this->getSort = FSInput::get('sort');	
        $this->getKeyword = FSInput::get('keyword');	
	}

	public function display()
	{
		$model = $this->model;

		$getPrice = $this->getPrice;
        $getFilter = $this->getFilter;
        $getSort = $this->getSort;
        $getKeyword = $this->getKeyword;

        $arrSort = [
            FSText::_('Phổ biến'),
            FSText::_('Hàng mới'),
            FSText::_('Giá từ thấp đến cao'),
            FSText::_('Giá từ cao đến thấp'),
        ];
		$empty = 0;
	    $query = $model->setQueryBody($getKeyword, $getPrice, $getFilter, $getSort);
        $products = $model->getProducts($query);
		$total = $model->getTotal($query);    

		if (empty($products)) {
			$empty = 1;
			$products = $model->getAllProducts();
			$total = $model->getAllTotal();    
		}

		$products = $this->nomalizeProducts($products);

		global $tmpl;
 
		$tmpl->set_seo_special();

		$title = 'Tìm kiếm sản phẩm với từ khóa '.$getKeyword;
		if ($title)
			$tmpl->addTitle($title);

		$total_in_page = count($products);

		$str_meta_des = $getKeyword;

		$count = count($products) >= 4 ? 4 : count($products);
		for ($i = 0; $i < $count; $i++) {
			$item = $products[$i];
			$str_meta_des .= ',' . $item->name;
		}
		$tmpl->addMetakey($str_meta_des);
		$tmpl->addMetades($str_meta_des);
		 		
		include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
	} 

	public function loadMore()
    { 
        $model = $this->model;
		
        if (!$this->getKeyword) {
            return;
        }
		$empty = FSInput::get('empty');
		
		if ($empty) {
			$products = $model->getAllProducts();
		} else {
			$query = $model->setQueryBody($this->getKeyword, $this->getPrice, $this->getFilter, $this->getSort);
			$products = $model->getProducts($query);
		}

        $products = $this->nomalizeProducts($products);

        foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        }
    }

	public function validate()
	{
		if (($_SERVER['REQUEST_METHOD'] != 'POST') || !csrf::authenticationToken()) {
            echo json_encode([
                'error' => true,
                'message' => "Lỗi", 
            ]);
            exit();
        }
		$keyword = urlencode($this->getKeyword);
		$link = FSRoute::_('index.php?module=products&view=search') . "?keyword=$keyword";
		setRedirect($link);
	}

	public function getAjaxSearch()
	{
		$result = [];
        $model = $this->model;
        $list = $model->getAjaxSearch();
		$list = $this->nomalizeProducts($list);

        if (!empty($list)) {
            foreach ($list as $item) {
               $data = [
                    'value' => FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id"),
                    'data' => [
                        'text' => $item->name,
						// "brand" => $item->category_name,
                        "image" => URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image),
						"price_public" => format_money($item->price_public),
						"price_origin" => format_money($item->price_old),
					]
				];

				$result[] = $data;
            }
        }

        $sugges_result = [
            'query' => FSInput::get('query'),
            'suggestions' => $result
		];

        echo json_encode($sugges_result);
		exit;
	}

	public function getAjaxSearchAdmin()
	{
		$result = [];
        $model = $this->model;
        $list = $model->getAjaxSearchAdmin();
		$list = $this->nomalizeProducts($list);

        if (!empty($list)) {
            foreach ($list as $item) {
				$item->image = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
				$item->href = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
				$item->price_public = format_money($item->price_public);
				$item->value = $item->href;
				$result[] = $item; 
            }
        }

        $sugges_result = [
            'query' => FSInput::get('query'),
            'suggestions' => $result
		];

        echo json_encode($sugges_result);
		exit;
	}
}
