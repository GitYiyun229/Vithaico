<?php

class IntroduceControllersIntroduce extends Controllers
{
    function __construct()
    {
        $this->view = 'introduce';
        parent::__construct();
    }

    function display()
    {
        parent::display();
        $sort_field = $this->sort_field;
        $sort_direct = $this->sort_direct;

        $model = $this->model;
        $categories = $model->get_categories_tree();
        $categories = $model->get_introduce_categories_tree_by_permission();
        $str_cat_id = '';
        foreach ($categories as $item) {
            $str_cat_id .= ',' . $item->id;
        }
        $str_cat_id .= ',';

        $list = $model->get_data($str_cat_id);


        $list_key = array();
        $pagination = $model->getPagination('');
        include 'modules/' . $this->module . '/views/' . $this->view . '/list.php';
    }

    function add()
    {
        $model = $this->model;
        $categories = $model->get_categories_tree();
        $list_key = array();
        // data from fs_news_categories
        $categories_home = $model->get_categories_tree();
        $maxOrdering = $model->getMaxOrdering();
//            $tag = $model->get_tags();
        $uploadConfig = base64_encode('add|' . session_id());
        $list_key = $model->get_records(' new_id = "' . $uploadConfig . '"', 'fs_news_keyword');

        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function edit()
    {
        $ids = FSInput::get('id', array(), 'array');
        $id = $ids[0];
        $model = $this->model;
        $categories = $model->get_introduce_categories_tree_by_permission();

//			$tags_categories = $model->get_tags_categories();
        $data = $model->get_record_by_id($id);
//            $tag = $model->get_tags();
        // data from fs_news_categories
        include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
    }

    function ajax_get_news_related()
    {
        $model = $this->model;
        $data = $model->ajax_get_news_related();
        $str_related = FSInput::get('str_related');
        $id = FSInput::get('id', 0, 'int');
        $html = $this->news_genarate_related($data, $str_related, $id);
        echo $html;
        return;
    }

    function news_genarate_related($data, $str_related = 0, $id)
    {
        $str_exist = FSInput::get('str_exist');
        $error_img = "this.src='/images/1443089194_picture-01.png'";
        if ($str_related) {
            if ($id) {
                $str_related = str_replace(',' . $id, '', $str_related);
            }
        }

        $html = '';
        $html .= '<div class="news_related">';
        foreach ($data as $item) {
            if ($str_exist && strpos(',' . $str_exist . ',', ',' . $item->id . ',') !== false) {
                $html .= '<div class="red news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')" style="display:none" >';
                $html .= $item->title . '<br/>';
                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/small/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            } else {
                $html .= '<div class="news_related_item  news_related_item_' . $item->id . '" onclick="javascript: set_news_related(' . $item->id . ')">';
                $html .= $item->title . '<br/>';
                $html .= '<img onerror="' . $error_img . '" src="' . str_replace('/original/', '/small/', URL_ROOT . @$item->image) . '">';
                $html .= '</div>';
            }
        }
        $html .= '</div>';
        $html .= '<input type="hidden" value="' . $str_related . '" id="str_related" name="str_related" />';
        return $html;
    }

    function add_html()
    {
        $id = FSInput::get('id', 0, 'int');
        $stt = FSInput::get('stt', 0, 'stt');
        $link = "javascript: created_indirect('index.php?module=news&view=news',8,'add_link_$id')";
        $html = '';
        $html .= '<tr id="add_item_' . $id . '">';
        $html .= '<td>' . $stt . '<input type="hidden" id="add_stt_' . $id . '" value="' . $stt . '" /></td>';
        $html .= '<td><input type="text" id="add_input_key_' . $id . '" class="form-control" placeholder="' . FSText::_('Keyword') . '" value="" /></td>';
        $html .= '<td><input type="text" id="add_input_replace_' . $id . '" class="form-control" placeholder="' . FSText::_('Keyword replace') . '" value="" /></td>';
        $html .= '     <td>';
        $html .= '         <div class="form-group input-group">';
        $html .= '             <input type="text" class="form-control" name="link" id="add_link_' . $id . '" value="" />';
        $html .= '             <a class="input-group-addon add_link" href="' . $link . '" ><i class="fa fa-link"></i></a>';
        $html .= '         </div>';
        $html .= '     </td>';
        $html .= '<td>
                                <select class="form-control" name="type" id="add_type_' . $id . '">
                                    <option value="0">' . FSText::_('Trong bài viết') . '</option>
                                    <option value="1">' . FSText::_('Ngoài bài viết') . '</option>
                                </select>
                          </td>';
        $html .= '<td>
                                <select class="form-control" name="type_link" id="add_type_link_' . $id . '">
                                    <option value="0">' . FSText::_('Trong website') . '</option>
                                    <option value="1">' . FSText::_('Ngoài website') . '</option>
                                </select>
                          </td>';
        $html .= '<td><a onclick="save_key(0)" class="btn btn-outline btn-success">' . FSText::_('Save') . '</a></td>';
        $html .= '<td></td>';
        $html .= '</tr>';

        echo $html;
    }

    function save_key()
    {
        $new_id = FSInput::get('new_id');
        if (!$new_id)
            return false;

        $model = $this->model;

        $id = FSInput::get('ids', 0, 'int');
        $row = array();
        $row['name'] = FSInput::get('key_name');
        $row['name_replace'] = FSInput::get('key_replace');
        $row['link_replace'] = FSInput::get('link_add');
        $row['type'] = FSInput::get('type_add', 0, 'int');
        $row['type_link'] = FSInput::get('type_link', 0, 'int');
        $row['new_id'] = $new_id;
        $time = date('Y-m-d H:i:s');
        $stt_add = FSInput::get('stt_add');
        $record = $model->get_record_by_id($new_id, 'fs_news', 'image,title,alias');
        if ($record) {
            $row['new_title'] = $record->title;
            $row['new_image'] = $record->image;
            if (!$row['link_replace']) {
                $row['link_replace'] = 'index.php?module=news&view=news&code=' . $record->alias . '&id=' . $new_id . '&Itemid=4';
            }
        }
        if ($id) {
            $row['edited_time'] = $time;
            $rs = $model->_update($row, 'fs_news_keyword', ' id = ' . $id, 1);
            $rs = $id;
        } else {
            $row['created_time'] = $time;
            $row['edited_time'] = $time;
            $rs = $model->_add($row, 'fs_news_keyword', 1);
        }
        //print_r($rs);
        $html = '';
        if ($rs) {
            $data = $model->get_record_by_id($rs, 'fs_news_keyword');
            if ($data) {
                $link = "javascript: created_indirect('index.php?module=news&view=news',8,'link_$data->id')";
                $html = '';
                $select = $data->type == 0 ? 'selected="selected"' : '';
                $select1 = $data->type == 1 ? 'selected="selected"' : '';
                $select_link = $data->type_link == 0 ? 'selected="selected"' : '';
                $select1_link = $data->type_link == 1 ? 'selected="selected"' : '';

                //$html .= '<tr id="add_item_'.$data->id.'">';
                $html .= '<td>' . $stt_add . '<input type="hidden" id="add_stt_' . $data->id . '" value="' . $stt_add . '" /></td>';
                $html .= '<td><input type="text" id="input_key_' . $data->id . '" class="form-control" placeholder="' . FSText::_('Keyword') . '" value="' . $data->name . '" /></td>';
                $html .= '<td><input type="text" id="input_replace_' . $data->id . '" class="form-control" placeholder="' . FSText::_('Keyword replace') . '" value="' . $data->name_replace . '" /></td>';
                $html .= '     <td>';
                $html .= '         <div class="form-group input-group">';
                $html .= '             <input type="text" class="form-control" name="link" id="link_' . $data->id . '" value="' . $data->link_replace . '" />';
                $html .= '             <a class="input-group-addon add_link" href="' . $link . '" ><i class="fa fa-link"></i></a>';
                $html .= '         </div>';
                $html .= '     </td>';
                $html .= '<td>
                                        <select class="form-control" name="type" id="type_' . $data->id . '">
                                            <option value="0" ' . $select . '>' . FSText::_('Trong bài viết') . '</option>
                                            <option value="1" ' . $select1 . '>' . FSText::_('Ngoài bài viết') . '</option>
                                        </select>
                                  </td>';
                $html .= '<td>
                                        <select class="form-control" name="type_link" id="type_link_' . $data->id . '">
                                            <option value="0" ' . $select_link . '>' . FSText::_('Trong website') . '</option>
                                            <option value="1" ' . $select1_link . '>' . FSText::_('Ngoài website') . '</option>
                                        </select>
                                  </td>';
                $html .= '<td><a onclick="save_key(' . $data->id . ')" class="btn btn-outline btn-success">' . FSText::_('Save') . '</a></td>';
                $html .= '<td><a onclick="delete_key(' . $data->id . ')" class="btn btn-outline btn-danger delete_' . $data->id . '"><i class="fa fa-times"></i></a></td>';
                //$html .= '</tr>';
            }
            echo $html;
        } else {
            return false;
        }
    }

    function delete_key()
    {
        $model = $this->model;
        $id = FSInput::get('id', 0, 'int');
        $rs = $model->_remove(' id = ' . $id, 'fs_news_keyword');
        if ($rs) {
            echo 1;
        } else {
            echo 2;
        }
    }

    function add_param()
    {
        $results_id = FSInput::get('results_id');
        $model = $this->model;
        $created_link = $model->get_linked_id();
        if (!$created_link)
            return;

        $field_display = $created_link->add_field_display;
        $field_value = $created_link->add_field_value;
        $add_param = $created_link->add_parameter;

        // create array if add multi param
        $arr_field_value = explode(',', $field_value);
        $arr_add_param = explode(',', $add_param);


        $list = $model->get_data_from_table($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);
        $pagination = $model->get_pagination_create_link($created_link->add_table, $field_display, $field_value, $created_link->add_field_distinct);

        include 'modules/' . $this->module . '/views/news/add_param.php';
    }

    function is_hot()
    {
        $this->is_check('is_hot', 1, 'is_hot');
    }

    function unis_hot()
    {
        $this->unis_check('is_hot', 0, 'un_hot');
    }

    function is_new()
    {
        $this->is_check('is_new', 1, 'is_new');
    }

    function unis_new()
    {
        $this->unis_check('is_new', 0, 'un_new');
    }

    function show_in_homepage()
    {
        $this->is_check('show_in_homepage', 1, 'show home');
    }

    function unshow_in_homepage()
    {
        $this->unis_check('show_in_homepage', 0, 'un home');
    }

    function is_slideshow()
    {
        $this->is_check('is_slide', 1, 'show slideshow');
    }

    function unis_slideshow()
    {
        $this->unis_check('is_slide', 0, 'un slideshow');
    }

    function is_new_video()
    {
        $this->is_check('is_new_video', 1, 'show news dưới slide');
    }

    function unis_new_video()
    {
        $this->unis_check('is_new_video', 0, 'un news dưới slide');
    }

    function view_comment($new_id)
    {
        $link = 'index.php?module=news&view=comments&keysearch=&text_count=1&text0=' . $new_id . '&filter_count=1&filter0=0';
        return '<a href="' . $link . '" target="_blink">Comment</a>';
    }

    function view_title($data)
    {
        $link = FSRoute::_('index.php?module=news&view=news&id=' . $data->id . '&code=' . $data->alias . '&ccode=' . $data->category_alias);
        return '<a target="_blink" href="' . $link . '" title="Xem ngoài font-end">' . $data->title . '</a>';
    }

}

?>