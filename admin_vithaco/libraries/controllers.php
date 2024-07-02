<?php
/*
 * Huy write
 */

class Controllers
{
	var $module;
	var $view;
	var $model;
	var $gid;
	var $prefix;
	var $page;
	var $limit;
	var $sort_field;
	var $sort_direct;
	var $params_form = array(); // add hiden input tag into form
	var $array_file = array();  // list field permission
	function __construct()
	{
		$module = FSInput::get('module');
		$view = FSInput::get('view', $module);
		$this->module = $module;
		$this->view = $view;

		$prefix = $this->module . '_' . $this->view . '_';
		$this->prefix = $prefix;
		$page = FSInput::get('page', 0, 'int');
		$this->page = $page;

		include 'modules/' . $this->module . '/models/' . $this->view . '.php';

		$model_name = ucfirst($this->module) . 'Models' . ucfirst($this->view);
		$this->model = new $model_name();
	}

	function find_file($module, $view, $str_list_field = '')
	{
		if (!$module || !$view || !$str_list_field) {
			return false;
		}
		$array_file = array();
		$html = '';
		$model = $this->model;

		$this->array_file = $array_file;
	}

	function display()
	{
		$sort_field  = FSInput::get('sort_field');
		$sort_direct = FSInput::get('sort_direct');
		$sort_direct = $sort_direct ? $sort_direct : 'asc';

		if (@$sort_field) {
			$_SESSION[$this->prefix . 'sort_field']  =  $sort_field;
			$_SESSION[$this->prefix . 'sort_direct']  = $sort_direct;
		}

		if (isset($_REQUEST['keysearch'])) {
			//			$_SESSION[$this -> prefix.'keysearch']  =  clean($_REQUEST['keysearch']);
			$_SESSION[$this->prefix . 'keysearch']  =  $_REQUEST['keysearch'];
		}
		if (isset($_REQUEST['filter'])) {
			$_SESSION[$this->prefix . 'filter']  =  clean($_REQUEST['filter']);
		}

		// multi filter
		if (isset($_REQUEST['text_count'])) {
			$_SESSION[$this->prefix . 'text_count']  =  clean($_REQUEST['text_count']);
			$count = $_SESSION[$this->prefix . 'text_count'];
			for ($i = 0; $i < $count; $i++) {
				if (isset($_REQUEST['text' . $i]))
					$_SESSION[$this->prefix . 'text' . $i]  =  clean($_REQUEST['text' . $i]);
			}
		}
		// multi filter
		if (isset($_REQUEST['filter_count'])) {
			$_SESSION[$this->prefix . 'filter_count']  =  clean($_REQUEST['filter_count']);
			$count = $_SESSION[$this->prefix . 'filter_count'];
			for ($i = 0; $i < $count; $i++) {
				if (isset($_REQUEST['filter' . $i]))
					$_SESSION[$this->prefix . 'filter' . $i]  =  clean($_REQUEST['filter' . $i]);
			}
		}

		$this->sort_field = '';
		$this->sort_direct = 'asc';
		if (isset($_SESSION[$this->prefix . 'sort_field'])) {
			$this->sort_field = $_SESSION[$this->prefix . 'sort_field'];
			$sort_direct = $_SESSION[$this->prefix . 'sort_direct'];
			$this->sort_direct = $sort_direct ? $sort_direct : 'asc';
		}
	}

	function add()
	{
		$permission = FSSecurity::check_permission($this->module, $this->view, 'add');
		if (!$permission) {
			echo FSText::_("Bạn không có quyền thực hiện chức năng này");
			return;
		}
		$model = $this->model;
		$maxOrdering = $model->getMaxOrdering();
		$maxOrdering = $maxOrdering ? $maxOrdering  : 1;
		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}

	function edit()
	{
		$ids = FSInput::get('id', array(), 'array');
		$id = $ids[0];
		$model = $this->model;
		$data = $model->get_record_by_id($id);

		include 'modules/' . $this->module . '/views/' . $this->view . '/detail.php';
	}

	function remove()
	{
		$id = FSInput::get('id', 0, 'int');
		$model = $this->model;

		$rows = $model->remove();
		if ($rows) {
			setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, $rows . ' ' . FSText::_('record was deleted'));
		} else {
			setRedirect('index.php?module=' . $this->module . '&view=' . $this->view, FSText::_('Not delete'), 'error');
		}
	}
	function published()
	{
		$model = $this->model;
		$rows = $model->published(1);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was published'));
		} else {
			setRedirect($link, FSText::_('Error when published record'), 'error');
		}
	}
	function unpublished()
	{
		$model = $this->model;
		$rows = $model->published(0);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was unpublished'));
		} else {
			setRedirect($link, FSText::_('Error when unpublished record'), 'error');
		}
	}
	function is_check($fields = '', $value = 1, $title = '')
	{
		$model = $this->model;
		$rows = $model->change_status($fields, $value);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was event'));
		} else {
			setRedirect($link, FSText::_('Error when check record'), 'error');
		}
	}
	function unis_check($fields = '', $value = 0, $title = '')
	{
		$model = $this->model;
		$rows = $model->change_status($fields, $value);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was un check'));
		} else {
			setRedirect($link, FSText::_('Error when un check record'), 'error');
		}
	}
	function duplicate()
	{
		$model = $this->model;
		$rows = $model->duplicate();
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if ($this->page)
			$link .= '&page=' . $this->page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was clone'));
		} else {
			setRedirect($link, FSText::_('Error when clone record'), 'error');
		}
	}
	function apply()
	{
		$model = $this->model;
		$id = $model->save();
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if ($this->page)
			$link .= '&page=' . $this->page;
		// call Models to save
		if ($id) {
			setRedirect($link . '&task=edit&id=' . $id, FSText::_('Saved'));
		} else {
			setRedirect($link, FSText::_('Not save'), 'error');
		}
	}
	function save_add()
	{
		$model = $this->model;
		$id = $model->save();
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;

		// call Models to save
		if ($id) {
			$category_id = FSInput::get('category_id', 0, 'int');
			$link .= '&task=add';
			if ($category_id)
				$link .= '&cid=' . $category_id;
			setRedirect($link, FSText::_('Saved'));
		} else {
			setRedirect($link, FSText::_('Not save'), 'error');
		}
	}
	function save()
	{
		$model = $this->model;
		// check password and repass
		// call Models to save
		$id = $model->save();
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if ($this->page)
			$link .= '&page=' . $this->page;
		if ($id) {
			setRedirect($link, FSText::_('Saved'));
		} else {
			setRedirect($link, FSText::_('Not save'), 'error');
		}
	}

	function cancel()
	{
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if ($this->page)
			$link .= '&page=' . $this->page;
		setRedirect($link);
	}
	function back()
	{
		$page = FSInput::get('page', 0, 'int');
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if ($this->page)
			$link .= '&page=' . $this->page;
		setRedirect($link);
	}

	/*
	 * Genarate filter
	 * Old solution
	 */
	function genarate_filter($row)
	{
		if (!count($row))
			return;
		$prefix = $this->prefix;
		$ss_keysearch  = isset($_SESSION[$prefix . 'keysearch']) ? $_SESSION[$prefix . 'keysearch'] : '';
		$ss_filter   = isset($_SESSION[$prefix . 'filter']) ? $_SESSION[$prefix . 'filter'] : '';

		$html = '';
		$html .= '<div  class="filter_area">';
		$html .= '	<table>';
		$html .= '		<tr>';
		if (isset($row['search'])) {
			$html .= '			<td align="left" width="100%">';
			$html .= 				FSText::_('Search') . ':';
			$html .= '				<input type="text" name="keysearch" id="search" value="' . $ss_keysearch . '" class="text_area" onchange="document.adminForm.submit();" />';
			$html .= '				<button onclick="this.form.submit();">' . FSText::_('Search') . '</button>';
			$html .= '				<button onclick="document.getElementById(\'search\').value=\'\';this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">' . FSText::_('Reset') . '</button>';
			$html .= '			</td>';
		}
		if (isset($row['filter']['title'])) {
			$field = isset($row['filter']['field']) ? $row['filter']['field'] : 'name';
			$html .= '			<td nowrap="nowrap">';
			$html .= '				<select name="filter" class="type" onChange="this.form.submit()">';
			$html .= '					<option value="0"> -- ' . $row['filter']['title'] . ' -- </option>';

			foreach ($row['filter']['list'] as $item) {
				if ($item->id == $ss_filter) {
					$html .= "<option value='" . $item->id . "'  selected='selected'> " . $item->$field . "</option>";
				} else {
					$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
				}
			}
			$html .= '				</select>';
			$html .= '			</td>';
		}
		$html .= '		</tr>';
		$html .= '	</table>';
		$html .= '</div>';
		return $html;
	}

	/*
	 * Genarate filter
	 * News solution
	 */
	function create_filter($row)
	{
		if (!count($row))
			return;
		$prefix = $this->prefix;
		$ss_keysearch  = isset($_SESSION[$prefix . 'keysearch']) ? $_SESSION[$prefix . 'keysearch'] : '';


		$html = '';
		$html .= '<div  class="filter_area">';
		$html .= '	<table>';
		$html .= '		<tr>';

		$html_text = '';
		if (isset($row['text_count'])) {
			$count = $row['text_count'];
			for ($i = 0; $i < $count; $i++) {
				$text_item = $row['text'][$i];
				$ss_text   = isset($_SESSION[$prefix . 'text' . $i]) ? $_SESSION[$prefix . 'text' . $i] : '';
				$type = isset($text_item['type']) ? $text_item['type'] : '';
				$html_text .= '			<td align="left" >';
				$html_text .= 	$text_item['title'];
				$html_text .= 	'<input type="text" name="text' . $i . '" id="text' . $i . '" value="' . $ss_text . '" />';

				$html_text .= '			</td>';
			}
			$html .= '			<input type="hidden" name="text_count" value="' . $count . '" />';
		}

		if (isset($row['search'])) {
			$html .= '			<td align="left" >';
			$html .= 				FSText::_('Search') . ':';
			$html .= '				<input type="text" name="keysearch" id="search" value="' . $ss_keysearch . '" class="text_area"  />';

			$html .= '</td>';
			$html .= $html_text;
			$html .= '<td>';
			$html .= '				<button onclick="this.form.submit();">' . FSText::_('Search') . '</button>';
			$html .= '				<button onclick="document.getElementById(\'search\').value=\'\';';
			if (isset($row['text_count'])) {
				$count = $row['text_count'];
				for ($i = 0; $i < $count; $i++) {
					$html .= '				document.getElementById(\'text' . $i . '\').value=\'\'; ';
				}
			}
			$html .= '				this.form.getElementById(\'filter_state\').value=\'\';this.form.submit();">' . FSText::_('Reset') . '</button>';
			$html .= '			</td>';
		}
		if (isset($row['filter_count'])) {
			$count = $row['filter_count'];
			$html .= '			<input type="hidden" name="filter_count" value="' . $count . '" />';
			for ($i = 0; $i < $count; $i++) {
				$filter_item = $row['filter'][$i];
				$ss_filter   = isset($_SESSION[$prefix . 'filter' . $i]) ? $_SESSION[$prefix . 'filter' . $i] : '';
				$type = isset($filter_item['type']) ? $filter_item['type'] : '';
				if ($type == 'yesno') {
					$field = isset($filter_item['field']) ? $filter_item['field'] : 'name';
					$html .= '			<td nowrap="nowrap">';
					$html .= '				<select name="filter' . $i . '" class="type" onChange="this.form.submit()">';
					$html .= '					<option value="2"> -- ' . $filter_item['title'] . ' -- </option>';


					$selected_no = $ss_filter === 0 ? "selected='selected'" : "";
					$selected_yes = $ss_filter === 1 ? "selected='selected'" : "";
					$html .= "<option value='1'  " . $selected_yes . "> " . FSText::_('Yes') . "</option>";
					$html .= "<option value='0'  " . $selected_no . "> " . FSText::_('No') . "</option>";

					$html .= '				</select>';
					$html .= '			</td>';
					continue;
				}

				$field = isset($filter_item['field']) ? $filter_item['field'] : 'name';
				$html .= '			<td nowrap="nowrap">';
				$html .= '				<select name="filter' . $i . '" class="type" onChange="this.form.submit()">';
				$html .= '					<option value="0"> -- ' . $filter_item['title'] . ' -- </option>';
				if (isset($filter_item['list']))
					if ($filter_item['list'])
						foreach ($filter_item['list'] as $item) {
							if ($item->id == $ss_filter) {
								$html .= "<option value='" . $item->id . "'  selected='selected'> " . $item->$field . "</option>";
							} else {
								$html .= "<option value='" . $item->id . "'>" . $item->$field . "</option>";
							}
						}
				$html .= '				</select>';
				$html .= '			</td>';
			}
		}
		$html .= '		</tr>';
		$html .= '	</table>';
		$html .= '</div>';
		return $html;
	}

	function load_view($file_name = '', $view = '')
	{
		if (!$file_name)
			return;
		if (!$view)
			$view = $this->view;
		include 'modules/' . $this->module . '/views/' . $view . '/' . $file_name . '.php';
	}
	/*
	 * Change language content
	 */
	function translate()
	{
		$url_current = $_SERVER['REQUEST_URI'];
		$url_current =  trim(preg_replace('/&task=translate/i', '', $url_current));
		$lang_arr = array('en', 'vi');
		$con_lang = $_SESSION['con_lang'];
		for ($i = 0; $i < count($lang_arr); $i++) {
			$item  = $lang_arr[$i];
			if ($con_lang == $item) {
				if ($i == (count($lang_arr) - 1)) {
					$_SESSION['con_lang'] = $lang_arr[0];
					setRedirect($url_current);
				}
				$_SESSION['con_lang'] = $lang_arr[$i + 1];
				setRedirect($url_current);
			}
		}
		$_SESSION['con_lang'] = $lang_arr[0];
		setRedirect($url_current);
	}

	/*
	 * Save all record for list form
	 */
	function save_all()
	{
		$model = $this->model;
		// check password and repass
		// call Models to save
		$id = $model->save_all();
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0, 'int');
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($id) {
			setRedirect($link, FSText::_('Saved'));
		} else {
			setRedirect($link, FSText::_('Not save'), 'error');
		}
	}
	function district()
	{
		$model  = $this->model;
		$cid = FSInput::get('cid', 0, 'int');
		$rs  = $model->get_districts($cid);

		$json = '['; // start the json array element
		$json_names = array();
		foreach ($rs as $item) {
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}

	/*
	 * for Ajax
	 * change cities follow country
	 */
	function get_cities_follow_country()
	{
		$model  = $this->model;
		$cid = FSInput::get('cid');
		$rs  = $model->get_cities_follow_country($cid);

		$json = '['; // start the json array element
		$json_names = array();
		foreach ($rs as $item) {
			$json_names[] = "{id: $item->id, name: '$item->name'}";
		}
		$json .= implode(',', $json_names);
		$json .= ']'; // end the json array element
		echo $json;
	}
	function home()
	{
		$model = $this->model;
		$rows = $model->home(1);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was home'));
		} else {
			setRedirect($link, FSText::_('Error when home record'), 'error');
		}
	}
	function unhome()
	{
		$model = $this->model;
		$rows = $model->home(0);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was unhome'));
		} else {
			setRedirect($link, FSText::_('Error when unhome record'), 'error');
		}
	}
	function autumn()
	{
		$model = $this->model;
		$rows = $model->autumn(1);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was home'));
		} else {
			setRedirect($link, FSText::_('Error when home record'), 'error');
		}
	}
	function unautumn()
	{
		$model = $this->model;
		$rows = $model->autumn(0);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was unhome'));
		} else {
			setRedirect($link, FSText::_('Error when unhome record'), 'error');
		}
	}
	function renew()
	{
		$model = $this->model;
		$rows = $model->renew(1);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was home'));
		} else {
			setRedirect($link, FSText::_('Error when home record'), 'error');
		}
	}
	function unrenew()
	{
		$model = $this->model;
		$rows = $model->renew(0);
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		$page = FSInput::get('page', 0);
		if ($page > 1)
			$link .= '&page=' . $page;
		if ($rows) {
			setRedirect($link, $rows . ' ' . FSText::_('record was unhome'));
		} else {
			setRedirect($link, FSText::_('Error when unhome record'), 'error');
		}
	}
	function dt_form_begin($include_tablehead = 1, $panel = 1, $panel_header = '', $icon = 'fa-cog', $on_col = 0, $col = '', $begin_form = 0, $tool_tip = '', $html_tool_tip = '')
	{
		$icon = $icon ? $icon : 'fa-cog';
		switch ($panel) {
			case 1:
				$class = 'panel-default';
				break;
			case 2:
				$class = 'panel-primary';
				break;
			case 3:
				$class = 'panel-success';
				break;
			case 4:
				$class = 'panel-info';
				break;
			case 5:
				$class = 'panel-warning';
				break;
			case 6:
				$class = 'panel-danger';
				break;
			case 7:
				$class = 'panel-green';
				break;
			case 8:
				$class = 'panel-yellow';
				break;
			case 9:
				$class = 'panel-red';
				break;
			default:
				$class = 'panel-info';
				break;
		}
		$params_form = $this->params_form;
		$link = 'index.php?module=' . $this->module . '&view=' . $this->view;
		if (count($params_form)) {
			foreach ($params_form as $name => $param) {
				$link .= '&' . $name . '=' . $param;
			}
		}
		if ($panel_header) {
			$icon = '<i class="fa ' . $icon . '"></i>';
			$note = '';
			if ($tool_tip == 1) {
				if (strpos($html_tool_tip, 'https://') !== false) {
					$note = '<div class="hover_img"><a><i class="fa fa-comment-o" aria-hidden="true"></i>
                    <span><img src="' . $html_tool_tip . '" /></span></a> </div>';
				} else {
					$note = ' <i data-toggle="tooltip" title="' . $html_tool_tip . '" class="fa fa-comment-o"></i>';
				}
			}
			$panel_header = '<div class="panel-heading">' . $icon . ' ' . $panel_header . $note . '</div>';
		}

		if ($on_col == 1 && $begin_form) {
			$html  = '<form class="form-horizontal" role="form" action="' . $link . '" name="adminForm" method="post" enctype="multipart/form-data">';
			$html .= '<div class="row">';
		} else if (!$on_col && !$begin_form) {
			$html  = '<form class="form-horizontal" role="form" action="' . $link . '" name="adminForm" method="post" enctype="multipart/form-data">';
			$html .= '<div class="row">';
		} else {
			$html = '';
		}
		$html .= '<div class="' . $col . ' col-xs-12">';
		$html .= '<div class="panel ' . $class . '">';
		$html .=     $panel_header;
		$html .= '   <div class="panel-body">';

		//if($include_tablehead)
		//$html .= '<table cellspacing="1" class="admintable">';
		echo $html;
	}

	function dt_form_end_col()
	{
		$html = '';
		$html .= '</div><!--end: .form-contents-->';
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}

	function dt_form_end($data, $include_tablebottom = 1, $seo = 0, $panel = 1, $panel_header = '', $icon = 'fa-cog', $on_col = 0, $col = '')
	{
		$icon = $icon ? $icon : 'fa-cog';
		$html = '';
		if (!$on_col) {
			$html .= '</div>';
			$html .= '</div><!--end: .form-contents-->';
			$html .= '</div>';
		}
		//if($include_tablebottom)
		//$html .= '</table>';
		if (@$data->id) {
			$html .= '<input type="hidden" value="' . $data->id . '" name="id" id="id">';
		}
		$html .= '<input type="hidden" value="' . $this->module . '" name="module">';
		$html .= '<input type="hidden" value="' . $this->view . '" name="view">';
		$html .= '<input type="hidden" value="" name="task">';
		$html .= '<input type="hidden" value="0" name="boxchecked">';
		$html .= '<input type="hidden" value="' . $this->page . '" name="page">';
		$params_form = $this->params_form;
		if (count($params_form)) {
			foreach ($params_form as $name => $param) {
				$html .= '<input type="hidden" value="' . $param . '" name="' . $name . '">';
			}
		}

		echo $html;
		switch ($panel) {
			case 1:
				$class = 'panel-default';
				break;
			case 2:
				$class = 'panel-primary';
				break;
			case 3:
				$class = 'panel-success';
				break;
			case 4:
				$class = 'panel-info';
				break;
			case 5:
				$class = 'panel-warning';
				break;
			case 6:
				$class = 'panel-danger';
				break;
			case 7:
				$class = 'panel-green';
				break;
			case 8:
				$class = 'panel-yellow';
				break;
			case 9:
				$class = 'panel-red';
				break;
			default:
				$class = 'panel-info';
				break;
		}

		$htmls = '';
		if ($panel_header) {
			$icon = '<i class="fa ' . $icon . '"></i>';
			$panel_header = '<div class="panel-heading">' . $icon . ' ' . $panel_header . '</div>';
		}
		if ($seo) {
			$col_seo = $col ? 'col-sm-12' : '';
			echo  '<div class="' . $col . ' col-xs-12">';
			echo  '<div class="panel ' . $class . '">';
			echo      $panel_header;
			echo  '   <div class="panel-body">';
			//TemplateHelper::dt_sepa();
			TemplateHelper::dt_edit_text(FSText::_('SEO title'), 'seo_title', @$data->seo_title, '', 100, 1, 0, '', '', $col_seo, $col_seo);
			TemplateHelper::dt_edit_text(FSText::_('SEO meta keyword'), 'seo_keyword', @$data->seo_keyword, '', 100, 1, 0, '', '', $col_seo, $col_seo);
			TemplateHelper::dt_edit_text(FSText::_('SEO meta description'), 'seo_description', @$data->seo_description, '', 100, 9, 0, '', '', $col_seo, $col_seo);
			echo  '</div><!--end: .form-contents-->';
			echo  '</div>';
			echo  '</div>';
		}
		echo '</div>';
		echo '</form>';
	}

	function add_params_form($name, $value = '')
	{
		$params_form = $this->params_form;
		$params_form[$name] = $value;
		$this->params_form = $params_form;
	}

	//  convert array to object
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
	function ObjecttoArray($obj)
	{
		if (is_object($obj)) $obj = (array) $obj;
		if (is_array($obj)) {
			$new = array();
			foreach ($obj as $key => $val) {
				$new[$key] = $this->ObjecttoArray($val);
			}
		} else {
			$new = $obj;
		}
		return $new;
	}
	/**
	 * Upload nhiều ảnh cho sản phẩm
	 */
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
	/*
    	 * Sửa thuộc tính của ảnh
    	 */
	function change_attr_image()
	{
		$this->model->change_attr_image();
	}

	/**
	 * sửa tiêu đề ảnh
	 */
	function change_title_attr_image()
	{
		$this->model->change_title_attr_image();
	}

	function delete_image()
	{
		$this->model->delete_image();
	}

	function delete_file()
	{
		$this->model->delete_file();
	}

	public function getAjaxSearchProduct_()
	{
		$result = [];
        $model = $this->model;
        $list = $model->getAjaxSearchProduct_();

        if (!empty($list)) {
            foreach ($list as $item) {
				$item->image = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
				$item->href = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
				// $item->price_public = format_money($item->price_public);
				$item->price = format_money($item->price);
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

	public function getAjaxSearchProduct()
	{
		$list = $this->model->getAjaxSearchProduct();
		if (!empty($list)) {
            foreach ($list as $item) {
				$item->image = URL_ROOT . str_replace(['/original/', '.png', '.jpg'], ['/resized/', '.webp', '.webp'], $item->image);
				$item->href = FSRoute::_("index.php?module=products&view=product&code=$item->alias&id=$item->id");
				$item->price = format_money($item->price);
				$item->quantity = $item->quantity ?: 0;
            }
        }
		echo json_encode($list);
		exit;
	}

	public function getAjaxSearchMembers()
	{
		$list = $this->model->getAjaxSearchMembers();
		echo json_encode($list);
		exit;
	}
}
