<?php
// models 
//	include 'modules/'.$module.'/models/'.$view.'.php';

class ProductsControllersClone_data extends Controllers
{
    function __construct()
    {
        $this->view = 'products';
        parent::__construct();
    }

    function display()
    {
        parent::display();

        $data = [];
        $url = isset($_GET['url']) ? trim($_GET['url']) : null;
        try{
            if (isset($url)) {
                $products = $this->getDataFromURL($url);
                if(isset($products['data'])){
                    $data['pagination'] = $this->rengerPageLinks($products['paginate_links']);
                    $data['url'] = $url;

                    $model = $this->model;
                    foreach($products['data'] as &$product){
                        $p = $model->check_exist_product($product['title']);
                        $product['exists'] = $p ? true : false;
                        $product['p_category_alias'] = $p->category_alias;
                        $product['p_alias'] = $p->alias;
                        $product['p_id'] = $p->id;
                    }
                    $data['products'] = $products['data'];
                }
            }
        } catch (Exception $e){

        }

        //Get common data
        $model = $this->model;
        $tre = $model->get_records('published = 1', 'fs_products_tre_em');
        $thanh_nien = $model->get_records('published = 1', 'fs_products_thanh_nien');
        $nam = $model->get_records('published = 1', 'fs_products_nam');
        $nu = $model->get_records('published = 1', 'fs_products_nu');
        $ngay_le = $model->get_records('published = 1', 'fs_products_ngay_le');
        $su_kien = $model->get_records('published = 1', 'fs_products_su_kien');
        $sizes_id = FSInput::get('size_id', array(), 'array');
        $list_size = implode(',', $sizes_id);
        if ($list_size) {
            $list_size = ',' . $list_size . ',';
        }
        $data['size_id'] = $list_size;

        $data['categories'] = $model->get_categories();

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    public function redirect_back($msg, $type, $url = null)
    {
        $url = $url ? '&url=' . $url : '';
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view . $url;
        setRedirect($link, $msg, $type);
    }

    function data_import(){
        $tre = FSInput::get('tre_em', array(), 'array');
        $list_tre = implode(',', $tre);
        if ($list_tre) {
            $list_tre = ',' . $list_tre . ',';
        }
        $data['tre_em'] = $list_tre;

        $thanh_nien = FSInput::get('thanh_nien', array(), 'array');
        $list_tn = implode(',', $thanh_nien);
        if ($list_tn) {
            $list_tn = ',' . $list_tn . ',';
        }
        $data['thanh_nien'] = $list_tn;

        $nam = FSInput::get('nam', array(), 'array');
        $list_nam = implode(',', $nam);
        if ($list_nam) {
            $list_nam = ',' . $list_nam . ',';
        }
        $data['nam'] = $list_nam;

        $nu = FSInput::get('nu', array(), 'array');
        $list_nu = implode(',', $nu);
        if ($list_nu) {
            $list_nu = ',' . $list_nu . ',';
        }
        $data['nu'] = $list_nu;

        $ngay_le = FSInput::get('ngay_le', array(), 'array');
        $list_nl = implode(',', $ngay_le);
        if ($list_nl) {
            $list_nl = ',' . $list_nl . ',';
        }
        $data['ngay_le'] = $list_nl;

        $su_kien = FSInput::get('su_kien', array(), 'array');
        $list_sk = implode(',', $su_kien);
        if ($list_sk) {
            $list_sk = ',' . $list_sk . ',';
        }
        $data['su_kien'] = $list_sk;
        $data['category_common'] = FSInput::get('category_common');
        return $data;
    }

    function check_data()
    {
        if(!isset($_POST['product_links'])){
            $this->redirect_back('Hãy nhập URL bạn muốn lấy dữ liệu!', 'error');
        }

        $dataCommon = self::data_import();
        $productLinks = $_POST['product_links'];
        $productsData = [];
        foreach($productLinks as $index => $link){
            $html = file_get_contents($link);
            if (empty($html)) {
                return [];
            }

            $dom = new DOMDocument();
            $dom->loadHTML($html);
            $rootId = $dom->getElementById("maincontent");
            if (empty($rootId)) {
                return [];
            }

            $dataElmTd = $this->getElementsByClass($rootId, "td", 'data');
            $dataAtributes = [];
            $dataAtributes['name'] = trim($this->getElementsByClass($rootId, "h1", 'product-name')[0]->textContent);
            $dataAtributes['chuyen_muc'] = trim($dataElmTd[0]->textContent);
            if(strlen($_POST['categories'][$index]) == 0 && strlen($dataCommon['category_common']) == 0){
                $this->redirect_back($dataAtributes['name'] . ' chưa chọn chuyên mục!', 'error', $_POST['url']);
            }

            $dataAtributes['category_id'] = $_POST['categories'][$index];
            $dataAtributes['xuat_xu'] = trim($dataElmTd[1]->textContent);
            $dataAtributes['thuong_hieu'] = trim($dataElmTd[2]->textContent);
            $dataAtributes['xuat_xu_thuong_hieu'] = trim($dataElmTd[3]->textContent);
            $dataAtributes['age'] = trim($dataElmTd[4]->textContent);
            $dataAtributes['chat_lieu'] = trim($dataElmTd[5]->textContent);
            $dataAtributes['gender'] = trim($dataElmTd[6]->textContent);
            $dataAtributes['code'] = $this->getElementsByClass($rootId, "span", 'value')[0]->textContent;

            $singleProduct = $this->getElementsByClass($rootId, 'div', 'single-image');
            if(isset($singleProduct[0])){
                $dataAtributes['src_single'] = $this->getElementsByClass($singleProduct[0], 'img', 'img-responsive')[0]->getAttribute('src');
            } else {
                $imgElm = $this->getElementsByClass($rootId, 'div', 'item-image');
                $imgElmSmall = $this->getElementsByClass($rootId, 'div', 'item-thumb');
                if(isset($imgElm)){
                    foreach($imgElm as $k => $img){
                        $dataAtributes['images'][] = [
                            'small' => $this->getElementsByClass($imgElmSmall[$k], 'img', 'img-responsive')[0]->getAttribute('src'),
                            'big' => $this->getElementsByClass($img, 'img', 'img-responsive')[0]->getAttribute('src')
                        ];
                    }
                }
            }

            $dataAtributes['description'] = '';
            if(isset($this->getElementsByClass($rootId, "div", 'description')[0])){
                $domProduct = $dom->getElementById('product-attribute-specs-table');
                $mota = '<br><div class="content-heading"><h2 class="title text-uppercase" style="margin: 20px 0px;">Thông tin sản phẩm</h2></div>';
                $mota = $mota . $domProduct->ownerDocument->saveXML($domProduct);
                $mota = str_replace('<caption class="table-caption">Thêm thông tin</caption>', '', $mota);
                $dataAtributes['description'] = trim($this->getElementsByClass($rootId, "div", 'description')[0]->textContent) . $mota;
            }

            $price = trim($this->getElementsByClass($rootId, "span", 'price')[0]->textContent);
            $dataAtributes['price'] = trim(str_replace([',', 'Giá đặc biệt'], '', substr($price, 0, -6)));

            $priceOriginal = trim($this->getElementsByClass($rootId, "span", 'price')[6]->textContent);
            $dataAtributes['price_old'] = trim(str_replace([',', 'Regular Price'], '', substr($priceOriginal, 0, -6)));
//            $dataAtributes['discount'] = $this->getDiscount($dataAtributes['price_old'], $dataAtributes['price']);

            $productsData[] = $dataAtributes;
        }

        $model = $this->model;
        $flag = $model->add_product($productsData, $dataCommon);
        if($flag){
            $this->redirect_back('Thêm thành công sản phẩm mới!', 'success', $_POST['url']);
        } else {
            $this->redirect_back('Có lỗi khi thêm sản phẩm mới, vui lòng liên hệ quản trị viên!', 'error', $_POST['url']);
        }
    }

//    function getDiscount($oldPrice, $newPrice)
//    {
//        return 100 - round($newPrice * 100 / $oldPrice);
//    }

    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    function getDataFromURL($url)
    {
        $html = file_get_contents($url);
        if (empty($html)) {
            return [];
        }

        $dom = new DOMDocument();
        $dom->loadHTML($html);
        $productId = $dom->getElementById("product-wrapper");
        if (empty($productId)) {
            return [];
        }
        $data = $this->getElementsByClass($productId, "div", 'catalog-product-item');

        $dataProducts = [];
        foreach ($data as $item) {
            $image = $this->getElementsByClass($item, "img", 'product-image-photo')[0]->getAttribute('data-src');
            $link = $this->getElementsByClass($item, "a", 'product-item-link')[0]->getAttribute('href');
            $title = $this->getElementsByClass($item, "a", 'product-item-link')[0]->textContent;
            $skuOrigin = $this->getElementsByClass($item, "p", 'productSku')[0]->textContent;
            $sku = str_replace('SKU: ', '', $skuOrigin);
            $price = $this->getElementsByClass($item, "span", 'price')[0]->textContent;

            $priceSale = @$this->getElementsByClass($item, "span", 'price')[6]->textContent;
            $sale = @$this->getElementsByClass($item, "span", 'sale-label')[0]->textContent;
            $available = @$this->getElementsByClass($item, "div", 'available-products')[0]->textContent;

            $price = trim(str_replace('Giá đặc biệt', '', $price));
            $priceSale = trim(str_replace('Regular Price', '',$priceSale));
            $discount = (substr(str_replace(',', '', $price), 0, -6) * 100 / substr(str_replace(',', '', $priceSale), 0, -6));

            $dataProducts[] = [
                'title' => trim($title),
                'image' => trim($image),
                'link' => trim($link),
                'sku_origin' => $skuOrigin,
                'sku' => trim($sku),
                'price' => $price,
                'price_sale' => $priceSale,
                'sale' => $sale ? trim($sale) : ( round($discount - 100) . ' %'),
                'available' => trim($available)
            ];
        }

        $paginate = @$this->getElementsByClass($dom, "ul", 'pagination')[0];
        $paginateLinks = [];
        if(isset($paginate)){
            $paginateItems = $this->getElementsByClass($paginate, "li", 'item');
            foreach ($paginateItems as $item) {
                if (!isset($this->getElementsByClass($item, "a", 'page')[0])) {
                    continue;
                }
                $link = $this->getElementsByClass($item, "a", 'page')[0]->getAttribute('href');
                if ($link != '#') {
                    $paginateLinks[$this->getElementsByClass($item, "a", 'page')[0]->textContent] = $link;
                }
            }
        }

        return [
            'data' => $dataProducts,
            'paginate_links' => $paginateLinks
        ];
    }

    function getElementsByClass(&$parentNode, $tagName, $className)
    {
        $nodes = array();

        $childNodeList = $parentNode->getElementsByTagName($tagName);
        for ($i = 0; $i < $childNodeList->length; $i++) {
            $temp = $childNodeList->item($i);
            if (stripos($temp->getAttribute('class'), $className) !== false) {
                $nodes[] = $temp;
            }
        }

        return $nodes;
    }

    function rengerPageLinks($data)
    {
        $html = '<ul class="pagination" aria-labelledby="paging-label">';
        foreach ($data as $k => $row) {
            $html .= '<li class="item">';
            $html .= '<a href="index.php?module=products&view=clone_data&url=' . $row . '" class="page">';
            $html .= '    <span>' . $k . '</span>';
            $html .= '</a>';
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    function add()
    {
        $model = $this->model;

        $maxOrdering = $model->getMaxOrdering();
        $origin = $model->get_records('published = 1', 'fs_products_origin');
        //$categories_products = $model->get_product_categories_tree_by_permission();
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $model = $this->model;
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $origin = $model->get_records('published = 1', 'fs_products_origin');
        $data = $model->get_record_by_id($id);

        //$categories_products = $model->get_product_categories_tree_by_permission();

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }
}

?>