<?php

class TemplateHelper
{

    public static function published($cid, $status)
    {
        if ($status != 'published') {

            $html = "<a title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
        } else {
            $html = "<a title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
        }
        return $html;
    }

    public static function dt_date_pick($title, $name, $value, $default = '', $size = 60, $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $class_col3 = 'col-md-6', $disabled = 0)
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if (!isset($value))
            $value = $default;
        //$value = escape($value);
        echo '<div class="form-group">';
        echo '	<label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>';
        echo '	<div class="' . $class_col2 . ' col-xs-12">';
        echo '	<div class="row">';
        echo '	<div class="' . $class_col3 . ' col-xs-6">';
        echo '		<input class="form-control" type="text" name="' . $name . '"  readonly="true" id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '"/>';
        echo '	</div>';
        if ($disabled == 0) {
            echo '      <a class="fl-left fa fa-calendar" href="javascript:void(0)" onclick="javascript:NewCssCal (\'' . $name . '\',\'YYYYmmdd\',\'arrow\',true,\'24\')">';
        } else {
            echo '      <a class="fl-left fa fa-calendar" disabled>';
        }
        //echo '			<img border="0" alt="Calenda" src="templates/default/images/cal.gif">';
        echo '		</a>';
        echo '	</div>';
        if ($comment)
            echo '<span class=\'comment\'>' . $comment . '</span>';
        echo '	</div>';
        echo '</div>';
        echo '<script type="text/javascript" src="' . URL_ROOT_ADMIN . 'templates/default/js/datetimepicker.js"></script>';
    }

    public static function datetimepicke($title, $name, $value, $default = '', $size = 60, $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $formats = '', $disabled = 0)
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if (!isset($value))
            $value = $default;
        if (!$formats) {
            $formats = 'YYYY-MM-DD HH:mm:ss'; // HH:mm:ss
        }
        //print_r($formats);
        //$value = escape($value);
        echo '<link rel="stylesheet" type="text/css" media="screen" href="' . URL_ROOT_ADMIN . 'templates/default/css/bootstrap-datetimepicker.min.css">
                ';
        echo '<div class="form-group">';
        echo '	<label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>';
        echo '	<div class="' . $class_col2 . ' col-xs-12">';
        echo '	<div class="input-group date datetimepicker" id="datetimepicker_' . $name . '">';
        if ($disabled == 0) {
            echo '<input class="form-control" type="text" name="' . $name . '"  id="' . $name . '"  value="' . htmlspecialchars($value) . '" size="' . $size . '"/>';
        } else {
            echo '<input class="form-control" type="text" name="' . $name . '"  id="' . $name . '"  value="' . htmlspecialchars($value) . '" size="' . $size . '" disabled/>';
        }

        echo '		<span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>';
        echo '	</div>';
        if ($comment)
            echo '<span class=\'comment\'>' . $comment . '</span>';
        echo '	</div>';
        echo '</div>';
        echo '<script src="' . URL_ROOT_ADMIN . 'templates/default/js/moment.js">
              </script><script src="' . URL_ROOT_ADMIN . 'templates/default/js/bootstrap-datetimepicker.min.js"></script>
                <script type="text/javascript">
                  $(function() {
                    $(".datetimepicker").datetimepicker({
                        format: "' . $formats . '"
                    });
                  });
                </script> 
            ';
    }

    public static function jscolorpicker($title, $name, $value, $default = 'FFFFFF', $size = 10, $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if (!isset($value))
            $value = $default;
        //$value = escape($value);
        echo '<script type="text/javascript" src="' . URL_ROOT_ADMIN . 'templates/default/js/jscolor.js"></script>';
        echo '<div class="form-group">';
        echo '	<label class="' . $class_col1 . ' col-xs-12 control-label" >' . $title . '</label>';
        echo '	<div class="' . $class_col2 . ' col-xs-12">';
        echo '		<input class="jscolor form-control" type="text" name="' . $name . '"  id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '"/>';
        if ($comment)
            echo '<span class=\'comment\'>' . $comment . '</span>';
        echo '	</div>';
        echo '</div>';
    }

    /*
     * For special case.
     * Reserve with published
     */

    function published2($cid, $status)
    {
        if ($status != 'unpublished') {

            $html = "<a style=\"color:#73c5fa;font-size:20px\" title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<i class=\"fa fa-check-square\"></i></a>";
        } else {
            $html = "<a style=\"color:red;font-size:20px\" title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<i class=\"fa fa-times-circle\"></i></a>";
        }
        return $html;
    }

    function activated($cid, $status)
    {
        if ($status != 'activated') {

            $html = "<a style=\"color:#73c5fa;font-size:20px\" title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<i class=\"fa fa-check-square\"></i></a>";
        } else {
            $html = "<a style=\"color:red;font-size:20px\" title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<i class=\"fa fa-times-circle\"></i></a>";
        }
        return $html;
    }

    public static function changeStatus($cid, $status)
    {
        if (substr(trim($status), 0, 2) == 'un') {
            $html = "<a style=\"color:#73c5fa;font-size:20px\" title=\"Disable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
        } else {
            $html = "<a style=\"color:red;font-size:20px\" title=\"Enable item\" onclick=\"return listItemTask('$cid','$status')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/unpublished.png\"></a>";
        }
        return $html;
    }

    public static function viewStatus($cid, $status)
    {
        if (substr(trim($status), 0, 2) == 'un') {
            $html = "<i style=\"color:#73c5fa;font-size:20px\" class=\"fa fa-check-square\"></i>";
        } else {
            $html = "<i style=\"color:red;font-size:20px\" class=\"fa fa-times-circle\"></i></a>";
        }
        return $html;
    }

    public static function views($link)
    {
        $html = "<a style='font-size:20px;' title=\"Views\" href=\"$link\">";
        $html .= " <i class='fa fa-link'></i></a>";
        return $html;
    }

    public static function edit($link)
    {
        $html = "<a title=\"Views\" href=\"$link\">";
        $html .= "<img width='20px' border=\"0\" alt=\"Views\" src=\"templates/default/images/edit.png\" /></a>";
        return $html;
    }

    /*
     * $title_field is Title
     * field_select is value of fields in thead
     * field_sorting is value of fields is sorting.
     * sort_direct: asc, desc
     */

    function order_field($title_field, $field_select, $field_sorting = '', $sort_direct = '')
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = trim(preg_replace('/&sortby=[a-zA-Z0-9_]+/i', '', $url)); // field
        $url = trim(preg_replace('/&sort=[a-z]+/i', '', $url));  // direct

        $sort_direct = $sort_direct ? $sort_direct : 'asc';
        $sort_direct_continue = $sort_direct == 'asc' ? 'desc' : 'asc';
        $link = $url . '&sortby=' . $field_select . '&sort=' . $sort_direct_continue;
        if ($field_select == $field_sorting) {
            $html = "<a title=\"Click to sort by this column\" href=\"$link\">";
            $html .= $title_field;
            $html .= "<img alt=\"$sort_direct\" src=\"templates/default/images/sort_$sort_direct.png\">";
            $html .= "</a>";
        } else {
            $html = "<a title=\"Click to sort by this column\" href=\"$link\">$title_field</a>";
        }
        return $html;
    }

    /* USE SESSTION
     * $title_field is Title
     * field_select is value of fields in thead
     * field_sorting is value of fields is sorting.
     * sort_direct: asc, desc
     */

    public static function orderTable($title_field, $field_select, $field_sorting, $sort_direct)
    {
        $sort_direct = $sort_direct ? $sort_direct : 'desc';
        $sort_direct_continue = $sort_direct == 'desc' ? '' : 'desc';
        if ($field_select == $field_sorting) {
            $html = "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">";
            $html .= $title_field;
            $html .= "<img alt=\"$sort_direct\" src=\"templates/default/images/sort_$sort_direct.png\">";
            $html .= "</a>";
        } else {
            $html = "<a title=\"Click to sort by this column\" href=\"javascript:tableOrdering('$field_select','$sort_direct_continue','');\">$title_field</a>";
        }
        return $html;
    }

    /*
     * rows > 0 ? textarea: input
     * name: field_name
     * display: echo
     */

    public static function edit_text($name, $value, $i, $size = 3, $rows = 1)
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if ($rows > 1) {
            $html = '<textarea class="form-control" rows="' . $rows . '" cols="' . $size . '" name="' . $name . '_' . $i . '" >' . htmlspecialchars($value) . '</textarea>';
            $html .= '<input type="hidden" name="' . $name . '_' . $i . '_original' . '" value="' . htmlspecialchars($value) . '"/>';
        } else {
            $html = '<input class="form-control" type="text" name="' . $name . '_' . $i . '"  value="' . htmlspecialchars($value) . '" size="' . $size . '"/>';
            $html .= '<input type="hidden" name="' . $name . '_' . $i . '_original' . '" value="' . htmlspecialchars($value) . '"/>';
        }
        return $html;
    }

    /*
     * rows > 0 ? textarea: input
     * name: field_name
     */

    public static function edit_selectbox($name, $value, $i, $arry_select = array(), $field_value = 'id', $field_label = 'name', $size = 1, $multi = 0, $class = '')
    {
        $class = $class ? $class : 'chosen-select chosen-select-deselect';
        if (!$multi) {
            $html_sized = $size > 1 ? "size=$size" : "";
            $html = '<select class="form-control chosen-select chosen-select-deselect select2-temp" name="' . $name . '_' . $i . '" id="' . $name . '_' . $i . '" ' . $html_sized . '>';
            $compare = 0;
            if (@$value)
                $compare = $value;
            $j = 0;
            if (count($arry_select) && $arry_select) {
                if (is_object(end($arry_select))) {
                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (!$compare && !$j) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare === ($select_item->$field_value))
                                $checked = "selected=\"selected\"";
                        }
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    foreach ($arry_select as $key => $name) {
                        $checked = "";
                        if (!$compare && !$j) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare == $key)
                                $checked = "selected=\"selected\"";
                        }
                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
            $html .= '<input type="hidden" name="' . $name . '_' . $i . '_original' . '" value="' . $value . '"/>';
        } else {
            $html_sized = $size > 1 ? "size=$size" : "";
            $html = '<select class="form-control chosen-select chosen-select-deselect-no-results select2-temp" name="' . $name . '_' . $i . '[]" id="' . $name . '_' . $i . '" ' . $html_sized . '  multiple="multiple">';
            $array_value = isset($value) ? explode(',', $value) : array();
            $j = 0;
            if (count($arry_select)) {
                if (is_object(end($arry_select))) {
                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (in_array($select_item->$field_value, $array_value))
                            $checked = "selected=\"selected\"";
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    foreach ($arry_select as $key => $name) {
                        if (in_array($name, $array_value))
                            $checked = "selected=\"selected\"";

                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
            $html .= '<input type="hidden" name="' . $name . '_' . $i . '_original' . '" value="' . $value . '"/>';
        }

        return $html;
    }

    function changeLimit($arr_limit)
    {
        $url = $_SERVER['REQUEST_URI'];
        $limit = FSInput::get('limit', 0, 'int');
        $html = '<div style="text-align: center; font-weight: bold; margin-top: 10px;">';
        $html .= "<select name=\"changeLimit\" id=\"changeLimit\" onchange=\"change_limit( this.value,'" . $url . "' );\" >";
        $html .= '<option value="" >Limit</option>';
        if (count($arr_limit)) {
            foreach ($arr_limit as $limit_item) {
                $checked = "";
                if ($limit_item == $limit) {
                    $checked = "selected=\"selected\"";
                }
                $html .= '<option value="' . $limit_item . '" ' . $checked . '>' . $limit_item . '</option>';
            }
        }
        $html .= '</select>';
        $html .= '</div>';
        return $html;
    }

    /*     * **
     * For list
     * config: array(title,field,ordering,type,col_width,no_col,no_col_sepa,align,arr_params,display_label)
     * type: text, datetime, date, image, edit_text,edit_selectbox, published,edit,change_status,
     * text: display string
     * @ordering: ordering this cols
     * display_label: display title into body
     * no_col_sepa: sepa in col (default: break line)
     * arr_params by type: edit_text($size,$rows)
     * 						text (have_link_edit,function)
     * 						label
     * 						image(search,replace,have_link_edit,with,heigh)
     * 						edit_selectbox(arry_select,field_value,field_label,size,multi)
     * 						change_status(function)
     * 	 * ==============
     * $params: the hidden tag name need add in form
     *
     */

    public static function genarate_form_liting($module, $view, $list, $fitler_config, $list_config, $sort_field, $sort_direct, $pagination = null, $params = array(), $first = 'index.php')
    {
        if (!count($list_config)) {
            return;
        }
        $total_col = 0;
        $total_col = count($list_config) + 2;
        // print_r($list);
        $error_img = "this.src='/images/1443089194_picture-01.png'";
        $prefix = $module . '_' . $view . '_';
        $html_filter = count($fitler_config) ? TemplateHelper::create_filter($fitler_config, $prefix) : '';
        $link = $first . '?module=' . $module . '&view=' . $view;
        if (count($params)) {
            foreach ($params as $name => $param) {
                $link .= '&' . $name . '=' . $param;
            }
        }
        $html_begin = '<form class="form-horizontal" action="' . $link . '" name="adminForm" method="post">';
        $i = 1;
        $arr_head = array();
        $arr_config = array();
        $arr_field_change = array();
        $view_view = '';
        $view_module = '';
        $view_task = '';
        $field_value = 'id';

        // Đánh số thứ tự
        $page = isset($pagination->page) ? $pagination->page : 0;
        $page = $page < 1 ? 1 : $page;
        $limit = isset($pagination->limit) ? $pagination->limit : 10;
        $start = ($page - 1) * $limit;
        foreach ($list_config as $item) {
            $col = $i;
            if (isset($item['no_col']))
                $col = $item['no_col'];
            if (!isset($arr_head[$col])) {
                $col_width = isset($item['col_width']) ? 'width="' . $item['col_width'] . '"' : '';
                if (!isset($item['ordering']) || empty($item['ordering'])) {
                    $arr_head[$col] = '<th class="title" ' . $col_width . ' >' . FSText::_($item['title']) . '</th>';
                } else {
                    $arr_head[$col] = '<th class="title" ' . $col_width . ' >' . TemplateHelper::orderTable(FSText::_($item['title']), $item['field'], @$sort_field, @$sort_direct) . '</th>';
                }
                $arr_config[$col] = array();
            }
            //var_dump($list_config[$i]['module']);
            if (!empty($list_config[$i]['field_value'])) {
                $field_value = $list_config[$i]['field_value'];
            }

            if (!empty($list_config[$i]['module'])) {
                $view_module = $list_config[$i]['module'];
            }
            if (!empty($list_config[$i]['task'])) {
                $view_task = $list_config[$i]['task'];
            }
            if (!empty($list_config[$i]['view'])) {
                $view_view = $list_config[$i]['view'];
            }
            $arr_config[$col][] = $item;
            $type = isset($item['type']) ? $item['type'] : 'text';
            if ($type == 'edit_text' || $type == 'edit_selectbox') {
                $arr_field_change[] = $item['field'];
            }
            $i++;
        }
        $html_head = '<div class="dataTable_wrapper">
                        <table style="width: 100%;" id="dataTables-example" class="table table-hover table-striped table-bordered"><thead><tr>';
        $html_head .= '<th width="30px" ></th>
                        <th width="30px" >
                            <input class="checkbox-custom" id="checkAll_box" type="checkbox" onclick="checkAll(' . count($list) . ')" value="" name="toggle">
                            <label for="checkAll_box" class="checkbox-custom-label"></label>
                        </th>';
        // $html_head .= implode($arr_head, '');
        $html_head .= implode('', $arr_head);
        $html_head .= '</tr></thead>';
        $html_body = '<tbody>';
        $total = 0;

        if (!count($list)) {
        } else {
            $i = 0;
            $view_task = $view_task ? '&task=' . $view_task : '';
            foreach ($list as $row) {
                $link_edit = "index.php?module=" . $module . "&view=" . $view . "&task=edit&id=" . $row->id . "&page=" . $page;
                $link_reply = "index.php?module=" . $module . "&view=" . $view . "&task=reply&id=" . $row->id . "&page=" . $page;

                $html_body .= '<tr class="row' . ($i % 2) . '">';
                $html_body .= '<td>' . ($i + $start + 1) . '<input type="hidden" name="id_' . $i . '" value="' . $row->id . '"/> </td>';
                $html_body .= '<td>
                            		<input class="checkbox-custom" type="checkbox" onclick="isChecked(this.checked);" value="' . $row->id . '"  name="id[]" id="cb' . $i . '">
                            		<label for="cb' . $i . '" class="checkbox-custom-label"></label>
                                </td>';
                if (@$row->total) {
                    $total += $row->total;
                }

                foreach ($arr_config as $col) {
                    if (!count($col)) {
                        continue;
                    }
                    if (isset($col[0]['align']))
                        $html_body .= '<td class = "' . $col[0]['align'] . '">';
                    else
                        $html_body .= '<td>';
                    $j = 0;
                    foreach ($col as $item) {
                        if ($j > 0) {
                            if (@$item['no_col_sepa'])
                                $html_body .= $item['no_col_sepa'];
                            else
                                $html_body .= '<br/><div class="break_line">&nbsp;</div>';
                        }

                        $type = isset($item['type']) ? $item['type'] : 'text';
                        $display_label = isset($item['display_label']) ? $item['display_label'] : 0;
                        if ($display_label)
                            $html_body .= $item['title'] . ': ';


                        switch ($type) {
                            case 'published':
                                $html_body .= TemplateHelper::published("cb" . ($i), $row->published ? "unpublished" : "published");
                                break;
                            case 'label':
                                $j--;
                                break;
                            case 'change_status_aj':
                                $inverse = isset($item['arr_params']['inverse']) ? $item['arr_params']['inverse'] = 1 : 0; // nghịch đảo giá trị
                                $function = isset($item['arr_params']['function']) ? $item['arr_params']['function'] : $item['field'];
                                if ($inverse == 1)
                                    $html_body .= TemplateHelper::changeStatusAj($row->id, $row->{$item['field']}, $item['field']);
                                else
                                    $html_body .= TemplateHelper::changeStatusAj($row->id, $row->{$item['field']}, $item['field']);
                                break;
                            case 'change_status':
                                $inverse = isset($item['arr_params']['inverse']) ? $item['arr_params']['inverse'] : 0; // nghịch đảo giá trị
                                $function = isset($item['arr_params']['function']) ? $item['arr_params']['function'] : $item['field'];
                                if ($inverse == 1)
                                    $html_body .= TemplateHelper::changeStatus("cb" . ($i), $row->{$item['field']} ? $function : "un" . $function);
                                else
                                    $html_body .= TemplateHelper::changeStatus("cb" . ($i), $row->{$item['field']} ? "un" . $function : $function);
                                break;
                            case 'edit':
                                $link_edit = "index.php?module=" . $module . "&view=" . $view . "&task=edit&id=" . $row->id . "&page=" . $page;
                                $html_body .= TemplateHelper::edit($link_edit);
                                break;
                            case 'preview':
                                $link_web = $item['link'] ? $item['link'] : '';
                                if ($link_web) {
                                    $link_web = str_replace('code=code', 'code=' . $row->alias, $link_web);
                                    $link_web = str_replace('id=id', 'id=' . $row->id, $link_web);
                                    $link_web = FSRoute::_("$link_web");
                                    $html_body .= "<a title=\"Views\" target='_blank' href=\"$link_web\">";
                                    $html_body .= "<img width='20px' border=\"0\" alt=\"Views\" src=\"templates/default/images/view.svg\" /></a>";
                                }
                                break;
                            case 'view':
                                $link_view = "index.php?module=" . $view_module . "&view=" . $view_view . $view_task . "&" . $field_value . "=" . $row->id;
                                $html_body .= TemplateHelper::views($link_view);
                                break;
                            case 'to_fun':
                                $view_module = '';
                                $link_view = "index.php?module=" . $view_module . "&view=" . $view_view . $view_task . "&" . $field_value . "=" . $row->id;
                                $html_body .= TemplateHelper::views($link_view);
                                break;
                            case 'datetime':
                                if (!$row->{$item['field']})
                                    $html_body .= '-';
                                else
                                    $html_body .= date('d/m/Y', strtotime($row->{$item['field']}));
                                break;
                            case 'date':
                                $html_body .= date('d/m/Y', strtotime($row->{$item['field']}));
                                break;
                            case 'timestamp':
                                $html_body .= date('d/m/Y', $row->{$item['field']});
                                break;
                            case 'edit_text':
                                $size = isset($item['arr_params']['size']) ? $item['arr_params']['size'] : 10;
                                $rows = isset($item['arr_params']['rows']) ? $item['arr_params']['rows'] : 1;
                                $html_body .= TemplateHelper::edit_text($item['field'], $row->{$item['field']}, $i, $size, $rows);
                                break;
                            case 'reply':
                                $html_body .= TemplateHelper::reply($link_reply);
                                break;
                            case 'text_status':
                                $module = FSInput::get('module');
                                $view = FSInput::get('view');

                                $array_ = isset($item['arr_params']) ? $item['arr_params'] : array();
                                $name_file = isset($item['field']) ? $item['field'] : 'is_status';
                                if (count($array_)) {
                                    //print_r($array_);
                                    if ($module == 'products' && $view == 'products') {
                                        $value_file = $row->$name_file == 0 ? 5 : $row->$name_file;
                                        $html_body .= isset($row->$name_file) ? $array_[$value_file] : '';
                                    } else {
                                        $html_body .= $row->$name_file ? $array_[$row->$name_file] : '';
                                    }
                                }
                                break;
                            case 'edit_selectbox':
                                $arry_select = isset($item['arr_params']['arry_select']) ? $item['arr_params']['arry_select'] : array();
                                $field_value = isset($item['arr_params']['field_value']) ? $item['arr_params']['field_value'] : 'id';
                                $field_label = isset($item['arr_params']['field_label']) ? $item['arr_params']['field_label'] : 'name';
                                $multi = isset($item['arr_params']['multi']) ? $item['arr_params']['multi'] : 0;
                                $size = isset($item['arr_params']['size']) ? $item['arr_params']['size'] : 1;
                                $html_body .= TemplateHelper::edit_selectbox($item['field'], $row->{$item['field']}, $i, $arry_select, $field_value, $field_label, $size, $multi);
                                break;
                            case 'image':
                                $link_img = $row->{$item['field']};
                                if (isset($item['arr_params']['search']) && isset($item['arr_params']['replace'])) {
                                    $link_img = str_replace($item['arr_params']['search'], $item['arr_params']['replace'], $link_img);
                                }
                                //with,height
                                $html_size = '';
                                $width = isset($item['arr_params']['width']) ? $item['arr_params']['width'] : '';
                                $height = isset($item['arr_params']['height']) ? $item['arr_params']['height'] : 0;
                                if ($width)
                                    $html_size .= ' width = "' . $width . '"';
                                if ($height)
                                    $html_size .= ' height = "' . $height . '"';
                                //link
                                $have_link_edit = isset($item['arr_params']['have_link_edit']) ? $item['arr_params']['have_link_edit'] : 0;
                                $image = '<img onerror="this.src=\'templates/default/images/spacer.gif\'" src="' . URL_ROOT . $link_img . '" ' . $html_size . ' />';
                                if ($have_link_edit)
                                    $html_body .= '<a href="' . $link_view . '">' . $image . '</a>';
                                else
                                    $html_body .= $image;
                                break;
                            case 'order':
                                $estore_code = 'DH';
                                $estore_code .= str_pad($row->id, 8, "0", STR_PAD_LEFT);
                                $html_body .= $estore_code;
                                break;
                            case 'orderBk':
                                $estore_code = 'MSDH';
                                $estore_code .= str_pad($row->id, 8, "0", STR_PAD_LEFT);
                                $html_body .= $estore_code;
                                break;
                            case 'format_money':
                                $html_body .= format_money_0($row->{$item['field']}, '', '');
                                break;
                            case 'log':
                                $link_edit = $item['link'] ? $item['link'] : '';
                                $icon = !empty($item['icon']) ? $item['icon'] : 'fa fa-edit';
                                if ($link_edit) {
                                    $link_edit = str_replace('record_id', $row->id, $link_edit);
                                    $link_edit = str_replace('user_id1', $row->user_id, $link_edit);
                                    //$link_edit = $not_rewrite == 1? $link_edit:FSRoute::_("$link_edit");
                                    $html_body .= '<a style="font-size: 20px;" href="' . $link_edit . '"><i class="' . $icon . '"></i></a>';
                                } else {
                                    $html_body .= '<a style="font-size: 20px;"><i class="' . $icon . '"></i></a>';
                                }
                                break;
                            case 'link_edit':
                                $link_edit = $item['link'] ? $item['link'] : '';
                                $icon = !empty($item['icon']) ? $item['icon'] : 'fa fa-edit';
                                $not_rewrite = !empty($item['not_rewrite']) ? $item['not_rewrite'] : 0;
                                if ($link_edit) {
                                    $link_edit = str_replace('record_id', $row->id, $link_edit);
                                    $link_edit = $not_rewrite == 1 ? $link_edit : FSRoute::_("$link_edit");
                                    $html_body .= '<a style="font-size: 20px;"  href="' . $link_edit . '"><i class="' . $icon . '"></i></a>';
                                } else {
                                    $html_body .= '<a style="font-size: 20px;"><i class="' . $icon . '"></i></a>';
                                }
                                break;
                            case 'text_link':
                                $link_web = $item['link'] ? $item['link'] : '';

                                if ($link_web) {
                                    if (@$row->category_alias) {
                                        $link_web = str_replace('ccode=ccode', 'ccode=' . $row->category_alias, $link_web);
                                    }
                                    if (@$row->category_alias) {
                                        $link_web = str_replace('cid=cid', 'cid=' . $row->category_id, $link_web);
                                    }
                                    $link_web = str_replace('code=code', 'code=' . $row->alias, $link_web);
                                    $link_web = str_replace('id=id', 'id=' . $row->id, $link_web);
                                    $link_web = FSRoute::_("$link_web");
                                    $html_body .= '<a style="text-align: left;"  href="' . $link_web . '">' . $row->{$item['field']} . '</a>';
                                }
                                break;
                            case 'text_link1':

                                $link_edit = "index.php?module=" . $module . "&view=" . $view . "&task=edit&id=" . $row->id . "&page=" . $page;
                                $html_body .= '<a style="text-align: left;"  href="' . $link_edit . '">' . $row->{$item['field']} . '</a>';
                                break;
                            case 'text_link2':
                                if ($row->{$item['field']})
                                    $link_edit = "$_SERVER[REQUEST_SCHEME]://$_SERVER[HTTP_HOST]/" . $row->{$item['field']};
                                else
                                    $link_edit = "";
                                $html_body .= '<a target="_blank" style="text-align: left;"  href="' . $link_edit . '">' . $link_edit . '</a>';
                                break;
                            case 'sync_status':
                                $id = $row->{$item['field']};
                                if ($id > 0) {
                                    $html_body .= '<img border="0" alt="Enabled status" src="templates/default/images/published.png">';
                                } else {
                                    $html_body .= '<img border="0" alt="Enabled status" src="templates/default/images/unpublished.png">';
                                }
                                break;
                            case 'table_name':
                                $table_name = $row->{$item['field']};
                                $table_name = str_replace('fs_products_', '', $table_name);
                                $link = 'index.php?module=' . $module . '&view=tables&task=edit&tablename=' . $table_name;
                                $html_body .= '<a href="' . $link . '" title="Sửa bảng" >' . $table_name . '</a>';
                                //$html_body .= format_money($row -> $item['field'],' VNĐ');
                                break;
                            case 'status':
                                $field = $item['field'];
                                if ($row->$field == NULL) {
                                    $row->$field = 0;
                                }
                                $status = isset($row->$field) ? 1 + $row->$field : '';
                                if ($status) {
                                    foreach ($item['arr_params'] as $value) {
                                        if ($value->id == $status) {
                                            $html_body .= $value->name;
                                        }
                                    }
                                }

                                break;
                            case 'text':

                            default:
                                if (isset($item['arr_params']['function']) && !empty($item['arr_params']['function'])) {
                                    $function = $item['arr_params']['function'];
                                    $params_for_function = @$item['arr_params']['params_for_function'];
                                    if ($item['field']) { // nếu định nghĩa field: params sẽ truyền vào là $row -> field
                                        if ($params_for_function)
                                            $html_body .= $this->$function($row->{$item['field']}, $params_for_function, $i);
                                        //else
                                        //$html_body .= 	$this -> $function($row -> $item['field']);
                                    } else { // nếu ko định nghĩa field: params sẽ truyền vào là ca $row
                                        if ($params_for_function)
                                            $html_body .= $this->$function($row, $params_for_function, $i);
                                        else
                                            $html_body .= $this->$function($row);
                                    }
                                } else {
                                    if (isset($item['arr_params']['have_link_edit']) && !empty($item['arr_params']['have_link_edit']))
                                        $html_body .= '<a href="' . $link_edit . '" >' . $row->{$item['field']} . '</a>';
                                    else
                                        $html_body .= $row->{$item['field']};
                                    break;
                                }
                        }
                        $j++;
                    }
                    $html_body .= '</td>';
                }
                $html_body .= '</tr>';
                $i++;
            }
        }
        $html_body .= '</tbody></table>';
        if ($total) {
            $html_body .= '<div class="total-price" >
                                <span> ' . FSText::_('Tổng tiền') . ':</span>
                                <strong class="red">' . format_money($total, ' VNĐ') . '</strong>
                         </div>';
        }
        $html_footer = '<nav class="text-center clearfix" aria-label="Page navigation">';
        if (isset($pagination)) {
            $html_footer .= $pagination->showPagination();
        }
        if (isset($limit_config)) {
            $html_footer .= TemplateHelper::changeLimit($limit_config, $this->page);
        }
        $html_footer .= '</nav>';
        // $html_field_change = count($arr_field_change) ? implode($arr_field_change, ',') : '';
        $html_field_change = count($arr_field_change) ? implode(',', $arr_field_change) : '';

        $page = FSInput::get('page', 0, 'int');
        $limit = FSInput::get('limit', 0, 'int');
        $html_footer .= '<input type="hidden" value="' . @$sort_field . '" name="sort_field" />';
        $html_footer .= '<input type="hidden" value="' . @$sort_direct . '" name="sort_direct" />';
        $html_footer .= '<input type="hidden" value="' . $module . '" name="module" />';
        $html_footer .= '<input type="hidden" value="' . $view . '" name="view" />';
        $html_footer .= '<input type="hidden" value="' . ($i + 1) . '" name="total">';
        $html_footer .= '<input type="hidden" value="' . FSInput::get('page', 0, 'int') . '" name="page">';
        $html_footer .= '<input type="hidden" value="' . $html_field_change . '" name="field_change">';
        $html_footer .= '<input type="hidden" value="" name="task">';
        $html_footer .= '<input type="hidden" value="0" name="boxchecked">';
        $html_footer .= '<input type="hidden" value="' . $page . '" name="page">';
        $html_footer .= '<input type="hidden" value="' . $limit . '" name="limit">';

        $html = $html_begin . $html_filter . $html_head . $html_body . $html_footer . '</form>';
        //		$html = '<xmp>'.$html_begin.$html_filter.$html_head.$html_body.$html_footer.'</form></div>'.'</xmp>';
        echo $html;
    }

    /*
     * Tạo cột phụ cạnh cột chính
     * Note: Ko có param Comments
     */
    public static function changeStatusAj($cid, $status, $name)
    {
        if ($status == 1) {
            $html = "<a title=\"Disable item\" id='aj_$cid" . "_" . $name . "' onclick=\"ajax_stt('$cid','0','$name')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Enabled status\" src=\"templates/default/images/published.png\"></a>";
        } else if ($status == 0) {
            $html = "<a title=\"Enable item\" id='aj_$cid" . "_" . $name . "' onclick=\"ajax_stt('$cid','1','$name')\" href=\"javascript:void(0);\">
			<img border=\"0\" alt=\"Disable status\" src=\"templates/default/images/unpublished.png\"></a>";
        }
        return $html;
    }

    static function sub_edit_selectbox($title, $name, $value, $default = '', $arry_select = array(), $field_value = 'id', $field_label = 'name', $size = 1, $multi = 0, $add_fisrt_option = 0)
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $html = '<span>' . $title . '</span>';
        if (!$multi) {
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select name="' . $name . '" id="' . $name . '" ' . $html_sized . '>';
            $compare = 0;
            if (isset($value))
                $compare = $value;
            else
                $compare = $default;

            if ($add_fisrt_option) {
                $checked = "";
                if (!$compare)
                    $checked = "selected=\"selected\"";
                $html .= '<option  value="0" ' . $checked . '>--' . $title . '--</option>';
            }
            $j = 0;
            if (count($arry_select)) {

                if (is_object(end($arry_select))) {

                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (!$compare && !$j && !$add_fisrt_option) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare === ($select_item->$field_value))
                                $checked = "selected=\"selected\"";
                        }
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    foreach ($arry_select as $key => $name) {
                        $checked = "";
                        if (!$compare && !$j && !$add_fisrt_option) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare == $key)
                                $checked = "selected=\"selected\"";
                        }
                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
        } else {
            // not working
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select name="' . $name . '[]" id="' . $name . '" ' . $html_sized . ' multiple="multiple">';
            $array_value = isset($value) ? explode(',', $value) : array();
            //			$compare  = 0;
            //			if(@$value)
            //				$compare = $value;
            $j = 0;
            if (count($arry_select)) {
                if (is_object(end($arry_select))) {
                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (in_array($select_item->$field_value, $array_value))
                            $checked = "selected=\"selected\"";
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    foreach ($arry_select as $key => $name) {
                        if (in_array($name, $array_value))
                            $checked = "selected=\"selected\"";
                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
        }
        $html .= '';
        return $html;
    }

    /*
     * FOR DETAIL PAGE
     * name: field_name
     * $sub_item: cột phụ
     */

    static function dt_edit_selectbox($title, $name, $value, $default = '', $arry_select = array(), $field_value = 'id', $field_label = 'name', $size = 1, $multi = 0, $add_fisrt_option = 0, $comment = '', $sub_item = '', $class = 'select2-temp', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $field = '', $showlabel = 1)
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $name = $name ? $name : $field;
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $class = $class ? $class : 'select2-temp';
        $html = '<div class="form-group">';
        if ($showlabel) {
            $html .= '<label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>';
        }
        $html .= '<div class="' . $class_col2 . ' col-xs-12">';
        if (!$multi) {
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select data-placeholder="' . $title . '" class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $html_sized . '>';
            $compare = 0;
            if (isset($value))
                $compare = $value;
            else
                $compare = $default;
            if ($add_fisrt_option) {
                $checked = "";
                if (!$compare)
                    $checked = "selected=\"selected\"";
                $html .= '<option  value="0" ' . $checked . '>--' . $title . '--</option>';
            }
            $j = 0;
            if ($arry_select && count($arry_select)) {

                if (is_object(end($arry_select))) {

                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (!$compare && !$j && !$add_fisrt_option) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare == ($select_item->$field_value)) {
                                $checked = "selected=\"selected\"";
                            }
                        }
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    $html .= '';
                    foreach ($arry_select as $key => $name) {
                        $checked = "";
                        if (!$compare && !$j && !$add_fisrt_option) {
                            $checked = "selected=\"selected\"";
                        } else {
                            if ($compare == $key)
                                $checked = "selected=\"selected\"";
                        }
                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
        } else {
            // not working
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select data-placeholder="' . $title . '" class="form-control select2-temp" name="' . $name . '[]" id="' . $name . '" ' . $html_sized . ' multiple="multiple">';

            $array_value = isset($value) ? explode(',', $value) : array();

            $j = 0;
            if (@count($arry_select)) {
                if (is_object(end($arry_select))) {
                    foreach ($arry_select as $select_item) {
                        $checked = "";
                        if (in_array($select_item->$field_value, $array_value))
                            $checked = "selected=\"selected\"";
                        $html .= '<option value="' . $select_item->$field_value . '" ' . $checked . '>' . $select_item->$field_label . '</option>';
                        $j++;
                    }
                } else {
                    foreach ($arry_select as $key => $name) {
                        if (in_array($name, $array_value))
                            $checked = "selected=\"selected\"";
                        $html .= '<option value="' . $key . '" ' . $checked . '>' . $name . '</option>';
                        $j++;
                    }
                }
            }
            $html .= '</select>';
            $html .= '<a data-id=' . $name . ' class="btn btn-outline btn-primary chosen-toggle select" style="cursor: pointer;margin-top: 10px;margin-right: 10px;">' . FSText::_('chọn tất cả') . '</a>';
            $html .= '<a data-id=' . $name . ' class="btn btn-outline btn-danger chosen-toggle deselect" style="cursor: pointer;margin-top: 10px;">' . FSText::_('Xóa chọn') . '</a>';
        }
        if ($sub_item)
            $html .= $sub_item;
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';

        echo $html;
    }
    static function dt_edit_selectbox2($title, $name, $value, $default = '', $arry_select = array(), $field_value = 0, $field_label = 1, $size = 1, $multi = 0, $add_fisrt_option = 0, $comment = '', $sub_item = '', $class = 'chosen-select chosen-select-deselect', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $class = $class ? $class : 'chosen-select chosen-select-deselect chosen-select chosen-select-deselect-deselect';
        $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>
                    <div class="' . $class_col2 . ' col-xs-12">
                    ';
        if (!$multi) {
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select data-placeholder="' . $title . '" class="form-control ' . $class . '" name="' . $name . '" id="' . $name . '" ' . $html_sized . '>';
            $compare = 0;
            if (isset($value))
                $compare = $value;
            else
                $compare = $default;

            if ($add_fisrt_option) {
                $checked = "";
                if (!$compare)
                    $checked = "selected=\"selected\"";
                $html .= '<option  value="0" ' . $checked . '>--' . $title . '--</option>';
            }
            $j = 0;
            if ($arry_select && count($arry_select)) {
                foreach ($arry_select as $select_item) {
                    $checked = "";
                    if (!$compare && !$j && !$add_fisrt_option) {
                        $checked = "selected=\"selected\"";
                    } else {
                        if ($compare === ($select_item[$field_value]))
                            $checked = "selected=\"selected\"";
                    }
                    $html .= '<option value="' . $select_item[$field_value] . '" ' . $checked . '>' . $select_item[$field_label] . '</option>';
                    $j++;
                }
            }
            $html .= '</select>';
        } else {
            // not working
            $html_sized = $size > 1 ? "size=$size" : "";
            $html .= '<select data-placeholder="' . $title . '" class="form-control chosen-select chosen-select-deselect-no-results" name="' . $name . '[]" id="' . $name . '" ' . $html_sized . ' multiple="multiple">';
            //  if($add_fisrt_option){
            //				$html .= '<option>--'.$title.'--</option>';
            //			}
            $array_value = isset($value) ? explode(',', $value) : array();
            //			$compare  = 0;
            //			if(@$value)
            //				$compare = $value;
            $j = 0;
            if (count($arry_select)) {
                foreach ($arry_select as $select_item) {
                    $checked = "";
                    if (in_array($select_item[$field_value], $array_value))
                        $checked = "selected=\"selected\"";
                    $html .= '<option value="' . $select_item[$field_value] . '" ' . $checked . '>' . $select_item[$field_label] . '</option>';
                    $j++;
                }
            }
            $html .= '</select>';
            $html .= '<a class="btn btn-outline btn-primary chosen-toggle select" style="cursor: pointer;margin-top: 10px;margin-right: 10px;">' . FSText::_('chọn tất cả') . '</a>';
            $html .= '<a class="btn btn-outline btn-danger chosen-toggle deselect" style="cursor: pointer;margin-top: 10px;">' . FSText::_('Xóa chọn') . '</a>';
        }
        if ($sub_item)
            $html .= $sub_item;
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';
        $html .= '<script type="text/javascript">
                		$(".chosen-toggle").each(function(index) {
                            $(this).on("click", function(){
                                 $(this).parent().find("option").prop("selected", $(this).hasClass("select")).parent().trigger("chosen:updated");
                            });
                        });
                </script>';
        echo $html;
    }

    /*
     * FOR DETAIL PAGE
     * tag: input, textarea, editor
     * in case editor: width => size, height => rows
     */

    static function dt_edit_text($title, $name, $value, $default = '', $maxlength = 255, $rows = 1, $editor = 0, $comment = '', $sub_item = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $disabled = 0, $type_editor = 0, $tool_tip = 0, $html_tool_tip = '')
    {
        // phan quyen theo field
        $size = 60;
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        if ($name) {
            $permission = FSSecurity::check_permission_field($module, $view, $name);
            if (!$permission) {
                return false;
            }
        }
        //END phan quyen theo field

        if (!isset($value))
            $value = $default;
        $value = html_entity_decode(stripslashes($value), ENT_COMPAT, 'UTF-8');
        $html = '';
        if ($tool_tip == 1) {
            $note = '';
            if (strpos($html_tool_tip, 'https://') !== false) {

                $note = '<div class="hover_img"><a><i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span><img src="' . $html_tool_tip . '" /></span></a> </div>';
            } else {
                $note = ' <i data-toggle="tooltip" title="' . $html_tool_tip . '" class="fa fa-comment-o"></i>';
            }
            echo '<div class="form-group">
                        <label class="' . $class_col1 . ' col-xs-12 control-label">
                        ' . $title . $note . '</label>
                        <div class="' . $class_col2 . ' col-xs-12">';
        } else {
            echo '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>
                    <div class="' . $class_col2 . ' col-xs-12">
                    ';
        }
        if ($rows > 1) {
            if (!$editor) {
                echo '<textarea class="form-control" rows="' . $rows . '" cols="' . $size . '" name="' . $name . '" id="' . $name . '" >' . $value . '</textarea>';
            } else {
                //				echo  '<textarea rows="10" cols="10" name="'.$name.'" id="'.$name.'" >'.$value.'</textarea>';
                //				echo "<script>CKEDITOR.replace( '".$name."');</script>";
                $k = 'oFCKeditor_' . $name;
                $oFCKeditor[$k] = new FCKeditor($name);
                $oFCKeditor[$k]->Value = stripslashes(@$value);
                $oFCKeditor[$k]->Width = $size;
                $oFCKeditor[$k]->Height = $rows;
                $oFCKeditor[$k]->Type = $type_editor;
                $oFCKeditor[$k]->Create();
            }
        } else {
            if ($name == 'price' || $name == 'price_old') {
                if ($value)
                    echo '<input type="text" class="form-control" name="' . $name . '" id="' . $name . '" value="' . format_money_0($value) . '" size="' . $size . '" maxlength="' . $maxlength . '"/>';
                else
                    echo '<input type="text" class="form-control" name="' . $name . '" id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '" maxlength="' . $maxlength . '" />';
            } else {
                if ($disabled == 0) {
                    echo '<input type="text" class="form-control" name="' . $name . '" id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '" maxlength="' . $maxlength . '"/>';
                } else {
                    echo '<input type="text" class="form-control" name="' . $name . '" id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '" maxlength="' . $maxlength . '" disabled/>';
                }
            }
        }
        if ($sub_item)
            echo $sub_item;
        if ($comment)
            echo '<p class="help-block">' . $comment . '</p>';
        echo '</div></div>';
        //echo $html;
    }

    /*
     * Tạo cột phụ cạnh cột chính
     * Note: Ko có param Comments, editor
     */

    static function sub_edit_text($title, $name, $value, $default = '', $size = 60, $rows = 1, $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if (!isset($value))
            $value = $default;
        $html = '<span>' . $title . '</span>';
        if ($rows > 1) {
            $html .= '<textarea rows="' . $rows . '" cols="' . $size . '" name="' . $name . '" id="' . $name . '" >' . $value . '</textarea>';
        } else {
            $html .= '<input class="form-control" type="text" name="' . $name . '" id="' . $name . '" value="' . htmlspecialchars($value) . '" size="' . $size . '"/>';
        }
        return $html;
    }

    /*
     * FOR DETAIL PAGE
     */

    static function dt_text($title, $value, $default = '', $comment = '', $use_htmlspecialchars = 1, $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $pos_text = 'left')
    {

        if (!isset($value))
            $value = $default;

        if ($pos_text) {
            $align = 'style="text-align: ' . $pos_text . ';"';
        } else {
            $align = 'style="text-align: left;"';
        }

        echo '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 " ' . $align . '>' . $title . ':</label>
                    <div class="' . $class_col2 . ' col-xs-12 " >';
        if ($use_htmlspecialchars)
            echo htmlspecialchars($value);
        else
            echo $value;

        if ($comment)
            echo '<p class="help-block">' . $comment . '</p>';
        echo '</div></div>';
    }

    /*
     * FOR DETAIL PAGE
     * tag: input, textarea, editor
     * in case editor: width => size, height => rows
     */

    function dt_image($title, $name, $value, $width = 0, $height = 0, $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>
                    <div class="' . $class_col2 . ' col-xs-12">';

        if ($value) {
            $html_w = $width ? ' width="' . $width . '" ' : '';
            $html_h = $height ? ' height="' . $height . '" ' : '';
            $html .= '<img src="' . $value . '" ' . $html_w . ' ' . $html_h . ' /><br/>';
        }
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';
        echo $html;
    }

    static function dt_sepa()
    {
        echo '<div class="col-xs-12"><div colspan="2"><hr class="sepa"/></div></div>';
    }

    public static function reply($link)
    {
        $html = "<a title=\"Replay\" href=\"$link\">";
        $html .= "<img border=\"0\" alt=\"Views\" src=\"templates/default/images/reply.png\" /></a>";
        return $html;
    }

    static function dt_edit_image($title, $name, $value = '', $width = 0, $height = 0, $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $ckfinder = '0')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $error_img = "this.src='/images/not_picture.png'";
        $module = FSInput::get('module');
        $view = FSInput::get('view');

        $id = FSInput::get('id', 0, 'int');
        if (!$id) {
            $ids = FSInput::get('id', array(), 'array');
            if ($ids)
                $id = $ids[0];
        }

        if ($ckfinder == 1) {
            $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">'
                . $title . '</label>
                    <div class="' . $class_col2 . ' col-xs-12">';
            $check_val = $value ? 1 : 0;

            if ($value) {
                $html_w = $width ? ' width="' . $width . '" ' : '';
                $html_h = $height ? ' height="' . $height . '" ' : '';
                $html .= '<div class="image-area-single" id = "html_' . $name
                    . '">';
                $html .= '<p><img class="img-responsive" onerror="' . $error_img
                    . '" src="' . $value . '" ' . $html_w . ' ' . $html_h
                    . ' /></p>';
                $html .= '</div>';
            }
            $html .= '<div class="fileUpload btn btn-primary ">
                    <span style="cursor: pointer; padding: 6px 12px; display: block" id="btn-image" class="btn-image"
                  data-name="' . $name . '"><i class="fa fa-cloud-upload"></i> Upload</span>
                   
                    <input type="hidden" id="' . $name . '" name="' . $name
                . '" value="'
                . str_replace(URL_ROOT, '', $value) . '" />
                <input type="hidden" id="type_' . $name . '" name="type_'
                . $name
                . '" value="'
                . $ckfinder . '" />
                    <input type="hidden" id="check_' . $name . '" value="'
                . $check_val . '" />
                </div>';
            if ($comment) {
                $html .= '<p class="help-block">' . $comment . '</p>';
            }
            $html .= '</div></div>';
            // $html .= '<script>
            //             $(\'.btn-image\').click(function () {
            //                 var name = $(this).attr(\'data-name\');
            //                 selectFileWithCKFinder(name);
            //             });

            //         </script>';

        } else {
            $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">'
                . $title . '</label>
                    <div class="' . $class_col2 . ' col-xs-12">';
            $check_val = $value ? 1 : 0;

            if ($value) {
                $html_w = $width ? ' width="' . $width . '" ' : '';
                $html_h = $height ? ' height="' . $height . '" ' : '';
                $html .= '<div class="image-area-single" id = "sort_' . $name . '">';
                $html .= '<p><img class="img-responsive sort_img_' . $name . '" onerror="' . $error_img . '" src="' . $value . '" ' . $html_w . ' ' . $html_h . ' /></p>';
                $html .= '<p class="del"><span onclick="remove_image(\'' . $module . '\',\'' . $view . '\',\'' . $id . '\',\'' . $name . '\',\'sort_' . $name . '\')"><img src="libraries/uploadify/delete.png"></span></p>';
                $html .= '</div>';
            }
            $html .= '
                <div class="fileUpload btn btn-primary ">
                    <span style="padding: 6px 12px;display: block"><i class="fa fa-cloud-upload"></i> Upload</span>
                    <input type="file" class="upload" name="' . $name . '" id="' . $name . '" data-class="sort_img_' . $name . '" />
                    <input type="hidden" id="type_' . $name . '" name="type_' . $name . '" value="' . $ckfinder . '" />
                    <input type="hidden" id="check_' . $name . '" value="' . $check_val . '" />
                </div>';
            if ($comment) {
                $html .= '<p class="help-block">' . $comment . '</p>';
            }
            $html .= '</div></div>';
        }
        echo $html;
    }

    /*
     * FOR DETAIL PAGE
     * tag: input, textarea, editor
     * in case editor: width => size, height => rows
     */

    static function dt_edit_image2(
        $title,
        $name,
        $value,
        $width = 0,
        $height = 0,
        $comment = '',
        $use_dropzone = 0,
        $list_other_images = array(),
        $class_col1 = 'col-md-3',
        $class_col2 = 'col-md-9',
        $type = 0
    ) {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        if (!$use_dropzone) {
            $html = '<tr><td valign="top" class="key" valign="top">' . $title . '</td><td class="value">';
            if ($value) {
                $html_w = $width ? ' width="' . $width . '" ' : '';
                $html_h = $height ? ' height="' . $height . '" ' : '';
                $html .= '<img src="' . $value . '" ' . $html_w . ' ' . $html_h . ' /><br/>';
            }
            $html .= '<input type="file" name="' . $name . '" id="' . $name . '"  />';
            if ($comment)
                $html .= '<p class="help-block">' . $comment . '</p>';
            $html .= '</td></tr>';
        } else {
            $id = FSInput::get('id');
            $module = FSInput::get('module');
            $view = FSInput::get('view');
            if ($id)
                $uploadConfig = base64_encode('edit|' . $id);
            else
                $uploadConfig = base64_encode('add|' . session_id());
            if ($list_other_images == '') {
                $list_other_images = TemplateHelper::get_other_images(
                    $module,
                    $uploadConfig,
                    $type
                );
            }
            $arr_sku_map = array();
            $i = 1;
            foreach ($list_other_images as $item) {
                $arr_sku_map['Data'][$i]['AttachmentID'] = $item->id;
                $arr_sku_map['Data'][$i]['FileName'] = $item->title;
                $arr_sku_map['Data'][$i]['Path'] = URL_ROOT . str_replace('/original/', '/original/', $item->image);
                $i++;
            }
            if (!count($arr_sku_map)) {
                $arr_sku_map['Data'][0]['AttachmentID'] = 0;
                $arr_sku_map['Data'][0]['FileName'] = '';
                $arr_sku_map['Data'][0]['Path'] = '';
                $arr_sku_map['Data'][0]['SubId'] = '';
            }
            $skuConfig = json_encode($arr_sku_map);
            $html = '
		    <link type="text/css" rel="stylesheet" media="all" href="' . URL_ROOT . 'libraries/jquery/dropzone/dist/min/dropzone.min.css" />
			<link type="text/css" rel="stylesheet" media="all" href="libraries/dropzone/dropzone.css" />

			<script type="text/javascript" src="' . URL_ROOT . 'libraries/jquery/dropzone/dist/min/dropzone.min.js"></script>
			<script type="text/javascript" src="libraries/uploadify/jquery.uploadify.js"></script>

			 <script>
              $(document).ready(function() {
                let data =' . $skuConfig . ';
				let previewNode = document.querySelector("#template");
				let uploadConfig =  $("#uploadConfig").val();
				previewNode.id = "";
				let previewTemplate = previewNode.parentNode.innerHTML;
				previewNode.parentNode.removeChild(previewNode);
				let myDropzone = new Dropzone(document.body, { // Make the whole body a dropzone
				  url: "index2.php?module=' . $module . '&view=' . $view . '&raw=1&task=upload_other_images&data="+uploadConfig+"&type_img=0",
				  thumbnailWidth: 100,
				  thumbnailHeight: 100,
				  parallelUploads: 20,
				  previewTemplate: previewTemplate,
				  autoQueue: true, 
				  previewsContainer: "#previews", 
				  clickable: ".fileinput-button", 
				  removedfile: function(file) {
				  		console.log(file);
					  	let reocord_id = $("#id_mage").val();
					    $.ajax({
					        type: "POST",
					        url: "index2.php?module=' . $module . '&view=' . $view . '&raw=1&task=delete_other_image",
					        data: { "name": file.name,"reocord_id":reocord_id,"id":file.size},
                  
					    });
					let _ref;
					return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;        
				  },
                  success: function(file, response){
                    //alert(response);
                    file.previewElement.id = "sort_"+response;
                  },  
				  init: function () {
                    let thisDropzone = this;  
                    if (data.Data != "") {
                        $.each(data.Data, function (index, item) {
                                var mockFile = {
                                    name: item.FileName,
                                    title: item.title,
                                    size: item.AttachmentID
                                };
                                thisDropzone.emit("addedfile", mockFile);
                                thisDropzone.emit("thumbnail", mockFile, item.Path);
                                $(mockFile.previewElement).prop("id", "sort_"+item.AttachmentID);
                                $(mockFile.previewTemplate).find(".title_dropzon").val(item.FileName);
                                $(mockFile.previewTemplate).find(".dz-color").val(item.SubId);
     							select_index = $("#sort_"+item.AttachmentID+" .dz-color option:selected").index();

                        });
                    }
	           	 }
				});

				$(function() {
					$("#previews").sortable({
						update : function () {
							serial = $("#previews").sortable("serialize");
							$.ajax({
								url: "index2.php?module=' . $module . '&view=' . $view . '&raw=1&task=sort_other_images",
								type: "post",
								data: serial,
								error: function(){
									alert("Lỗi load dữ liệu");
								}
							});

						}
					});
					
				});

			  });
				function change_color(element){
					value = $(element).val();
					console.log(value);
					parent_id =  $(element).parent().attr("id");
					id =  parent_id.replace("sort_", "");
					let uploadConfig =  $("#uploadConfig").val();
					 $.ajax({
				        type: "GET",
				       url: "index2.php?module=' . $module . '&view=' . $view . '&raw=1&task=change_attr_image",
				        data: { "field": "sub","data":uploadConfig,"id":id,"value":value}
				    });
//					 element.style.backgroundColor=element.options[element.selectedIndex].style.backgroundColor;
				}
                
                function change_tile(element){
					value = $(element).val();
					console.log(value);
					parent_id =  $(element).parent().attr("id");
                    id =  parent_id.replace("sort_", "");
					let uploadConfig =  $("#uploadConfig").val();
					 $.ajax({
				        type: "POST",
				        url: "index2.php?module=' . $module . '&view=' . $view . '&raw=1&task=change_title_attr_image",
				        data: {"data":uploadConfig,"id":id,"value":value}
				    });
				}
			  </script>
			';
            $html .= '<div class="dropzone files" id="previews">';
            $html .= '<div  id="template" class="dz-preview dz-image-preview">';
            $html .= '<div class="dz-details">';
            $no_img = "this.src='/images/not_picture.png'";
            $html .= '<img data-dz-thumbnail onerror="' . $no_img . '" />';
            $html .= '</div>';
            $html .= '<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress=""></span></div>';
            $html .= '<a class="dz-remove"  data-dz-remove id="">Remove</a>';
            $html .= '<input type="text" onchange="javascript: change_tile(this);" class="form-control title_dropzon" placeholder="Title" style="width:100px;border-radius: 0px;margin-top: 2px;">';
            $html .= '</select>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= '<input type="hidden" value="' . $uploadConfig
                . '" id="uploadConfig" />';
            $html .= '<input type="hidden" value="' . $id . '" id="id_mage" />';
            $html .= '<span class="post_images fileinput-button">Thêm ảnh/video</span>';
        }

        echo $html;
    }

    static function get_other_images(
        $module = '',
        $uploadConfig = '',
        $type = 0
    ) {
        $data = base64_decode($uploadConfig);
        $data = explode('|', $data);
        $where = '';
        // print_r($data);die;
        if ($data[0] == 'add')
            $where = 'session_id = \'' . $data[1] . '\'';
        else
            $where = 'record_id = ' . $data[1];

        global $db;
        $fs_table = new FSTable_ad();
        $tablename = $fs_table->_('fs_' . $module . '_images');

        $query = '  SELECT *
                    FROM ' . $tablename . ' 
                    WHERE ' . $where . ' AND `type` = ' . $type . '
                    ORDER BY ordering ASC, id ASC';
        $sql = $db->query($query);
        return $db->getObjectList();
    }

    static function get_colors($rid)
    {
        if (!$rid)
            return;
        $where = 'AND record_id = ' . $rid;
        global $db;
        $query = '  SELECT *
                    FROM fs_products_price
                    WHERE 1 = 1 ' . $where . ' ';
        $sql = $db->query($query);
        return $db->getObjectList();
    }

    public static function get_product_sub($rid)
    {
        if (!$rid) {
            return;
        }
        $where = 'AND product_id = ' . $rid;
        global $db;
        $query = '  SELECT *
                    FROM fs_products_sub
                    WHERE 1 = 1 ' . $where . ' ';
        $sql = $db->query($query);
        return $db->getObjectList();
    }
    /*
     * FOR DETAIL PAGE
     * tag: input, textarea, editor
     * in case editor: width => size, height => rows
     */

    public static function dt_edit_file($title, $name, $value = '', $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

        $module = FSInput::get('module');
        $view = FSInput::get('view');
        $id = FSInput::get('id');
        $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>
                    <div class="' . $class_col2 . '  col-xs-12">';
        $check_val = $value ? 1 : 0;
        if ($value) {
            $html .= '<div class="sort_' . $name . '">';
            $html .= '<a style="color: rgba(255, 153, 0, 0.79);" href="' . URL_ROOT . $value . '">' . $value . '</a>';
            $html .= '<span style="cursor: pointer;margin-left: 10px;color: #F44336;font-size: 16px;" onclick="remove_file(\'' . $module . '\',\'' . $view . '\',\'' . $id . '\',\'' . $name . '\',\'sort_' . $name . '\')">
                        <i class="fa fa-times-circle"></i>
                      </span><br/>';
            $html .= '</div>';
        }
        $html .= '
                    <div class="fileUpload btn btn-primary ">
                        <span><i class="fa fa-cloud-upload"></i> Upload</span>
                        <input type="file" class="upload" id ="' . $name . '" name="' . $name . '"  />
                        <input type="hidden" id="check_' . $name . '" value="' . $check_val . '" />                        
                    </div>';
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';
        echo $html;
    }

    public static function dt_edit_video($title, $name, $value = '', $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9')
    {
        // phan quyen theo field
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }
        //END phan quyen theo field

       
        $id = FSInput::get('id', 0, 'int');
        $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title . '</label>
                    <div class="' . $class_col2 . '  col-xs-12">';
        $check_val = $value ? 1 : 0;
        if ($value) {
            $html .= '
                <div class="sort_' . $name . '">
                    <video width="320" height="240" controls style="max-width: 100%;">
                        <source src="' . URL_ROOT . $value . '" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                    <span style="margin-left: 20px; cursor: pointer; color: #F44336; font-size: 16px;" onclick="remove_file(\'' . $module . '\',\'' . $view . '\',\'' . $id . '\',\'' . $name . '\',\'sort_' . $name . '\')">
                        <i class="fa fa-times-circle"></i>
                    </span>
                </div>
            '; 
        }
        $html .= '
            <div class="fileUpload btn btn-primary ">
                <span data-name="' . $name . '" id="btn-' . $name . '" class="btn-' . $name . '"><i class="fa fa-cloud-upload"></i> Upload</span>
                <input type="file" class="upload" id ="' . $name . '" name="' . $name . '"  />
                <input type="hidden" id="check_' . $name . '" value="' . $check_val . '" />                        
            </div>
        ';
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';
        echo $html;
    }

    /*
     * FOR DETAIL PAGE
     * tag: radio
     * in case editor: width => size, height => rows
     */

    public static function dt_checkbox($title, $name, $value, $default = 1, $array_value = array(1 => 'Có', 0 => 'Không'), $sub_item = '', $comment = '', $class_col1 = 'col-md-3', $class_col2 = 'col-md-9', $tool_tip = '', $html_tool_tip = '')
    {
        $module = FSInput::get('module');
        $view = FSInput::get('view', $module);
        $permission = FSSecurity::check_permission_field($module, $view, $name);
        if (!$permission) {
            return false;
        }

        if (!$array_value) {
            $array_value = array(1 => 'Có', 0 => 'Không');
        }

        $html = '<div class="form-group">
                    <label class="' . $class_col1 . ' col-xs-12 control-label">' . $title;
        if ($tool_tip == 1) {
            $note = '';
            if (strpos($html_tool_tip, 'https://') !== false) {

                $note = '<div class="hover_img"><a><i class="fa fa-comment-o" aria-hidden="true"></i>
                                 <span><img src="' . $html_tool_tip . '" /></span></a> </div>';
            } else {
                $note = ' <i data-toggle="tooltip" title="' . $html_tool_tip . '" class="fa fa-comment-o"></i>';
            }
            $html .= $note;
        }
        $html .= '</label>';
        $html .= '<div class="' . $class_col2 . ' col-xs-12">';
        $compare = isset($value) ? $value : $default;
        foreach ($array_value as $key => $item) {
            //$html .= '<label class="radio-inline control control--radio">';
            if ($compare == $key) {
                $html .= ' <input class="radio-custom" type="radio" name="' . $name . '" value="' . $key . '" checked="checked" id="' . $name . '_' . $key . '" />
                           <label for="' . $name . '_' . $key . '" class="radio-custom-label">' . $item . '</label>';
            } else {
                $html .= '<input class="radio-custom" type="radio" name="' . $name . '" value="' . $key . '" id="' . $name . '_' . $key . '"  />
                          <label for="' . $name . '_' . $key . '" class="radio-custom-label">' . $item . '&nbsp;&nbsp;</label>
                         ';
            }
            //$html .= '</label>';
        }

        if ($sub_item)
            $html .= $sub_item;
        if ($comment)
            $html .= '<p class="help-block">' . $comment . '</p>';
        $html .= '</div></div>';
        echo $html;
    }

    /*
     * Genarate filter
     * News solution
     */

    public static function create_filter($row, $prefix)
    {
        if (!count($row))
            return;
        $ss_keysearch = isset($_SESSION[$prefix . 'keysearch']) ? $_SESSION[$prefix . 'keysearch'] : '';

        $class = 'chosen-select chosen-select-deselect select2-temp';
        $html = '';
        $html .= '<div  class="filter_area">';
        $html .= '	<div class="row">';
        $html_text = '';
        if (isset($row['text_count'])) {
            $count = $row['text_count'];
            for ($i = 0; $i < $count; $i++) {
                $text_item = $row['text'][$i];
                $ss_text = isset($_SESSION[$prefix . 'text' . $i]) ? $_SESSION[$prefix . 'text' . $i] : '';
                $type = isset($text_item['type']) ? $text_item['type'] : '';
                $html_text .= '			<div class="col-xs-2" >';
                $html_text .= '<input type="text" placeholder="' . $text_item['title'] . '" class="form-control" name="text' . $i . '" id="text' . $i . '" value="' . $ss_text . '"  />';

                $html_text .= '			</div>';
            }
            $html .= '			<input type="hidden" name="text_count" value="' . $count . '" />';
        }

        if (isset($row['search'])) {
            $html .= '			<div class="col-xs-4">';
            $html .= '	<div class="input-group custom-search-form">
                            <input size="12" type="text" placeholder="' . FSText::_('Search') . '" name="keysearch" id="search" value="' . $ss_keysearch . '" class="form-control"  />
                            <span class="input-group-btn">
                            <button onclick="this.form.submit();" class="btn btn-default" type="button">
                                <i class="fa fa-search"></i>
                            </button>
                        </span>
                        </div>			
                        ';
            $html .= '</div>';
            $html .= $html_text;
        }


        if (isset($row['search'])) {
            $html .= '<div class="fl-left pd-15">';
            $html .= '<button class="btn btn-outline btn-primary" onclick="this.form.submit();">' . FSText::_('Search') . '</button>';
            $html .= '				<button class="btn btn-outline btn-primary" onclick="document.getElementById(\'search\').value=\'\';';
            if (isset($row['text_count'])) {
                $count = $row['text_count'];
                for ($i = 0; $i < $count; $i++) {
                    $html .= '				document.getElementById(\'text' . $i . '\').value=\'\'; ';
                }
            }
            $html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">' . FSText::_('Reset') . '</button>';
            $html .= '			</div>';
        }

        if (isset($row['filter_count'])) {
            $html .= '';
            $count = $row['filter_count'];
            $html .= '			<input type="hidden" name="filter_count" value="' . $count . '" />';
            for ($i = 0; $i < $count; $i++) {
                $filter_item = $row['filter'][$i];
                $ss_filter = isset($_SESSION[$prefix . 'filter' . $i]) ? $_SESSION[$prefix . 'filter' . $i] : '';
                $type = isset($filter_item['type']) ? $filter_item['type'] : '';
                if ($type == 'yesno') {
                    $field = isset($filter_item['field']) ? $filter_item['field'] : 'name';
                    $html .= '			<div class="col-xs-4" style="margin-bottom: 15px">';
                    $html .= '				<select name="filter' . $i . '" class="form-control ' . $class . '" onChange="this.form.submit()">';
                    $html .= '					<option value="2"> -- ' . $filter_item['title'] . ' -- </option>';
                    $selected_no = $ss_filter === 0 ? "selected='selected'" : "";
                    $selected_yes = $ss_filter === 1 ? "selected='selected'" : "";
                    $html .= "<option value='1'  " . $selected_yes . "> " . FSText::_('Yes') . "</option>";
                    $html .= "<option value='0'  " . $selected_no . "> " . FSText::_('No') . "</option>";

                    $html .= '				</select>';
                    $html .= '			</div>';
                    continue;
                }

                $field = isset($filter_item['field']) ? $filter_item['field'] : 'name';
                $html .= '			<div class="col-xs-4 " style="margin:10px 0">';
                $html .= '				<select name="filter' . $i . '" class="form-control ' . $class . '"  onChange="this.form.submit()">';
                $html .= '					<option value="0"> -- ' . $filter_item['title'] . ' -- </option>';

                if (isset($filter_item['list']))
                    if ($filter_item['list'])
                        foreach ($filter_item['list'] as $key => $item) {
                            if (is_object($item)) {
                                if ($item->id == $ss_filter) {
                                    $html .= "<option value='" . $item->id . "'  selected='selected'> " . $item->$field . "</option>";
                                } else {
                                    $html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
                                }
                            } else {
                                if ($key == $ss_filter) {
                                    $html .= "<option value='" . $key . "'  selected='selected'> " . $item . "</option>";
                                } else {
                                    $html .= "<option value='" . $key . "'>" . $item . "</option>";
                                }
                            }
                        }
                $html .= '				</select>';
                $html .= '			</div>';
            }
        }

        $html .= '		</div>';
        $html .= '</div>';
        return $html;
    }
}
