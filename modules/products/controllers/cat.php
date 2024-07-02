<?php

class ProductsControllersCat extends FSControllers
{
    public $module;
    public $view;
    public $getPrice;
    public $getFilter;
    public $getSort;

    public function __construct()
    {
        parent::__construct();
        $this->getPrice = FSInput::get('price');
        $this->getFilter = FSInput::get('filter');
        $this->getSort = FSInput::get('sort');
    }

    public function display()
    {
        global $tmpl;
        $model = $this->model;
      
        $getPrice = $this->getPrice;
        $getFilter = $this->getFilter;
        $getSort = $this->getSort;

        $arrSort = [
           1=> FSText::_('phổ biến'),
           2=> FSText::_('hàng mới'),
           3=> FSText::_('giá từ thấp đến cao'),
           4=> FSText::_('giá từ cao đến thấp'),
        ];

        $cat = $model->getCat();

        if (!$cat) {
            setRedirect(URL_ROOT, FSText::_('Danh mục không tồn tại!'), 'error');
        }

        $query = $model->setQueryBody($cat->id, $getPrice, $getFilter, $getSort);
        $products = $model->getProducts($query);
        
        $products = $this->nomalizeProducts($products);
    
        $total = $model->getTotal($query);    

        $categoriesWrap = $model->getCategoriesWrap($cat->list_parents);
        $breadcrumbs = [];
        foreach ($categoriesWrap as $item) { 
            $breadcrumbs[] = [
                $item->name, 
                FSRoute::_("index.php?module=products&view=cat&code=$item->alias&id=$item->id")
            ];
        } 
        $canonical = FSRoute::_("index.php?module=products&view=cat&code=$cat->alias&id=$cat->id");
        $tmpl->assign('breadcrumbs', $breadcrumbs);
        $tmpl->assign('canonical', $canonical);

        // $tmpl->assign('og_image', $cat->og_image ? URL_ROOT . $cat->og_image : URL_ROOT . $products[0]->image);
        $tmpl->addTitle($cat->seo_title ? $cat->seo_title : $cat->name . ' Shop USA');
        $tmpl->addMetakey($cat->seo_keyword ? $cat->seo_keyword : $cat->name . ' Shop USA');
        // if ($cat->seo_description) {
        //     $tmpl->addMetades($cat->seo_description);
        // } else {
        //     $str_meta_des = 'Mua ';
        //     for ($i = 0; $i < 5; $i++) {
        //         $item_des = $products[$i];
        //         $str_meta_des .=  $item_des->name . ', ';
        //     }
        //     $str_meta_des .= '... với nhiều ưu đãi hấp dẫn tại Lỗ Vũ';
        //     $tmpl->addMetades($str_meta_des);
        // }

        // danh sách lọc
        $catList = $model->getCatList($cat->id, $cat->level, $cat->parent_id);
        $priceFilter = $model->getPriceFilter($cat->price);
        $catFilter = $model->getFilter($cat->tablename);
        if (!empty($catFilter)) {
            $groupFilter = [];
            foreach ($catFilter as $group) {
                $groupFilter[] = $group->foreign_id;
            }

            $catFilterItem = $model->getFilterItem(implode(',', $groupFilter));

            foreach ($catFilter as $group) {
                $group->filterItem = [];
                foreach ($catFilterItem as $item) {
                    if ($item->group_id == $group->foreign_id) {
                        $group->filterItem[] = $item;
                    }
                }
            }
        }

        include 'modules/' . $this->module . '/views/' . $this->view . '/default.php';
    }

    public function loadMore()
    {
        $model = $this->model;
        $id = FSInput::get('id');
        if (!$id) {
            return;
        }
        $query = $model->setQueryBody($id, $this->getPrice, $this->getFilter, $this->getSort);
        $products = $model->getProducts($query);
        $products = $this->nomalizeProducts($products);

        foreach ($products as $item) {
            echo $this->layoutProductItem($item);
        }
    }
}
