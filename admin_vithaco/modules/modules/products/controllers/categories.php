<?php
class ProductsControllersCategories extends Controllers
{
    var $extend_field_type = array(
        'text' => 'Text',
        'select' => 'Select',
        'multi_select' => 'Multi select',
        'yesno' => 'Yes/No'
    );

    function __construct()
    {
        parent::__construct();
        $this->view = 'categories';
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $list = $this->model->get_categories_tree_all();
        $categories = $model->get_categories_level0();
        $news_categories = $model->get_news_categories_tree();
        $products_categories = $model->get_products_categories_tree();
        $value = '';
        $pagination = $model->getPagination($value);
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $model = $this->model;
        $categories = $model->get_categories_tree_all();
        $maxOrdering = $model->getMaxOrdering();
//        $list_trademark = $model->get_trademark();
        $tables = $model->get_tablenames();
        $range_price  = $model->get_range_price();
        $warranty = $model->get_records('published=1 ORDER BY ordering ASC','fs_warranty','id, name');
        $list_images = $model->get_list_images('');
        $list_videos = $model->get_list_videos('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $model = $this->model;
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $data = $model->get_record_by_id($id);
        $categories = $model->get_categories_tree_all();
//        $list_trademark = $model->get_trademark();
        $tables = $model->get_tablenames();
        $range_price  = $model->get_range_price();
        $warranty = $model->get_records('published=1 ORDER BY ordering ASC','fs_warranty','id, name');
        $news_categories = $model->get_news_categories_tree();
        $products_categories = $model->get_products_categories_tree();
        $news_related = $model->get_news_related($data->news_related);
        $products_order = $model->get_products_order($data->products_order);
        $list_images = $model->get_list_images($id);
        $list_videos = $model->get_list_videos($id);
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    /*
     * create link edit table name
     */
    function link_edit_tablename($table_name)
    {
        $table_name = str_replace('fs_products_', '', $table_name);
        $link = 'index.php?module=' . $this->module . '&view=tables&task=edit&tablename=' . $table_name;
        return '<a href="' . $link . '" title="Sửa bảng" >' . $table_name . '</a>';
    }

    function view_genarate_filter($data)
    {
        $table_name = str_replace('fs_products_', '', $data->tablename);
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view . '&task=genarate_filter&tablename=' . $table_name;
        return '<a href="' . $link . '" title="Tính toán lại bộ lọc" >Tính lại bộ lọc</a>';
    }

    function link_import($id)
    {
        $link = 'index.php?module=' . $this->module . '&view=import&cid=' . $id;
        return '<a href="' . $link . '" title="Sửa bảng" ><img src="templates/default/images/toolbar/icon-import.png" /> </a>';
    }

    function link_export($id)
    {
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view . '&task=extract_file&cid=' . $id . '&raw=1';
        return '<a href="' . $link . '" title="Sửa bảng" ><img src="templates/default/images/toolbar/icon_export_exel.png" /> </a>';
    }

    /*
     * Sinh ra bộ lọc tự động
     */
    function genarate_filter($rows)
    {
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $table_name = FSInput::get('tablename');
        if (!$table_name) {
            setRedirect($link, FSText:: _('Không được để trống bảng mở rộng'));
        }
        $table_name = 'fs_products_' . $table_name;
        $model = $this->model;
        $rs = $model->caculate_filter(array($table_name));

        if ($this->page)
            $link .= '&page=' . $this->page;
        if ($rows) {
            setRedirect($link, $rows . ' ' . FSText:: _('Đã tính lại xong bộ lọc'));
        } else {
            setRedirect($link, FSText:: _('Không tính được'), 'error');
        }
    }

    function is_hot()
    {
        $model = $this->model;
        $rows = $model->is_hot(1);
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $page = FSInput::get('page', 0);
        if ($page > 1)
            $link .= '&page=' . $page;
        if ($rows) {
            setRedirect($link, $rows . ' ' . FSText:: _('record was event'));
        } else {
            setRedirect($link, FSText:: _('Error when hot record'), 'error');
        }
    }

    function unis_hot()
    {
        $model = $this->model;
        $rows = $model->is_hot(0);
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $page = FSInput::get('page', 0);
        if ($page > 1)
            $link .= '&page=' . $page;
        if ($rows) {
            setRedirect($link, $rows . ' ' . FSText:: _('record was un_hot'));
        } else {
            setRedirect($link, FSText:: _('Error when un_hot record'), 'error');
        }
    }

    function is_menu()
    {
        $model = $this->model;
        $rows = $model->is_menu(1);
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $page = FSInput::get('page', 0);
        if ($page > 1)
            $link .= '&page=' . $page;
        if ($rows) {
            setRedirect($link, $rows . ' ' . FSText:: _('record was event'));
        } else {
            setRedirect($link, FSText:: _('Error when menu record'), 'error');
        }
    }

    function unis_menu()
    {
        $model = $this->model;
        $rows = $model->is_menu(0);
        $link = 'index.php?module=' . $this->module . '&view=' . $this->view;
        $page = FSInput::get('page', 0);
        if ($page > 1)
            $link .= '&page=' . $page;
        if ($rows) {
            setRedirect($link, $rows . ' ' . FSText:: _('record was un_menu'));
        } else {
            setRedirect($link, FSText:: _('Error when un_menu record'), 'error');
        }
    }


    function upload_other_images()
    {
        $this->model->upload_other_images();
    }

    /**
     * Xóa ảnh
     */
    function delete_other_image()
    {
        $this->model->delete_other_image();
    }

    /**
     * Sắp xếp ảnh
     */
    function sort_other_images()
    {
        $this->model->sort_other_images();
    }

    function show_in_homepage()
    {
        $this->is_check('show_in_homepage', 1, 'show home');
    }

    function unshow_in_homepage()
    {
        $this->unis_check('show_in_homepage', 0, 'un home');
    }

    function load_extend_fields(){

    }

    function ajax_get_landing_product()
    {
        $page = FSInput::get('page');
        $id = FSInput::get('id');
        $search = '';
        if (FSInput::get('search'))
            $search = FSInput::get('search');
        $news = $this->model->ajax_get_landing_product($page, $search, $id);
        foreach ($news as $item) {
            $data[] = array(
                'id' => $item->id,
                'text' => $item->name,
            );
        }
        $res = array();
        $res['results'] = !empty($data) ? $data : '';
        $res['pagination'] = array();
        if(empty($news)){
            $res['pagination']['more'] = false;
        }
        else {
            $res['pagination']['more'] = true;
        }
        
        echo json_encode($res);
    }

    function ajax_get_products_order()
    {
        $model = $this->model;
        $data = $model->ajax_get_products_order();
        $html = $this->products_genarate_order($data);
        echo $html;
        return;
    }

    function products_genarate_order($data)
    {
        $str_exist = FSInput::get('str_exist');
        $html = '';
        $html .= '<div class="products_order">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red products_order_item  products_order_item_' . $item->id . '" onclick="javascript: set_products_order(' . $item->id . ')" style="display:none" >';
                $html .= '<img src="'.URL_ROOT.str_replace('/origninal/','/resized/',$item->image).'" width="50" height="50">';
                $html .= $item->name;
                $html .= '(Tồn '.$item->quantity.')';
                $html .= '</div>';
            } else {
                $html .= '<div class="products_order_item  products_order_item_' . $item->id . '" onclick="javascript: set_products_order(' . $item->id . ')">';
                $html .= '<img src="'.URL_ROOT.str_replace('/origninal/','/resized/',$item->image).'" width="50" height="50">';
                $html .= $item->name;
                $html .= '<b style="color:red;">(Tồn '.$item->quantity.')</b>';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        return $html;
    }
}