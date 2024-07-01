<?php
/*
 * Huy write
 */
// models
include 'blocks/sidebar/models/sidebar.php';
class SidebarBControllersSidebar
{
	function __construct()
	{
	}
	function display($parameters)
	{
		global $user;

		$style = $parameters->getParams('style');
		$style = 'default';
		$id = FSInput::get('id', 0, 'int');
		$module = FSInput::get('module');
		$model = new SidebarBModelsSidebar();
		$userid = $user->userInfo;
		if(!empty($userid->max_courseid)){
			$max_courseid = $userid->max_courseid;
			$course = $model->get_categories($max_courseid);
		}

		// call views
		include 'blocks/sidebar/views/sidebar/' . $style. '.php';
	}

	/*
		 * get Array params
		 */
	function get_params($url)
	{
		$url_reduced  = substr($url, 10); // width : index.php
		$array_buffer = explode('&', $url_reduced, 10);
		$array_params = array();
		for ($i  = 0; $i < count($array_buffer); $i++) {
			$item = $array_buffer[$i];
			$pos_sepa = strpos($item, '=');
			$array_params[substr($item, 0, $pos_sepa)] = substr($item, $pos_sepa + 1);
		}
		return $array_params;
	}
	function check_active($link = '')
	{
		$link_rewrite = FSRoute::_($link) . "--";
		$url_current = URL_ROOT . substr($_SERVER['REQUEST_URI'], 1);

		if ($link_rewrite == $url_current)
			return true;
		$module = FSInput::get('module');
		$view = FSInput::get('view');
		if ($module == 'news' && ($view == 'news' || $view == 'cat')) {
			$ccode = FSInput::get('ccode');
			if (strpos($link, '&ccode=' . $ccode) != false) {
				return true;
			}
		}
		return false;
	}
	function check_activated($url)
	{
		if (!$url)
			return false;
		$array_params  = $this->get_params($url);
		$module  = isset($array_params['module']) ? $array_params['module'] : '';
		$module_c = FSInput::get('module');
		if ($module != $module_c)
			return false;
		switch ($module) {
			case 'contact':
			case 'admissions':
			case 'students':
			case 'libraries':
			case 'partners':
			case 'estores':
			case 'users':
			case 'image':
			case 'ranks':
			case 'course':
				if ($module == $module_c)
					return true;
				return false;
			case 'news':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'news':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;
					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;
					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}
			case 'event':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'event':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;
					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;
					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}
			case 'gallery':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'gallery':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;
					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;
					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}

			case 'recruitment':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'recruitment':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;
					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;
					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}
			case 'contents':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'content':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;
					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;
					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}


			case 'products':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'product':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['code']) ? $array_params['code'] : '';
						$code_c = FSInput::get('code');
						if ($code == $code_c)
							return true;
						return false;

					case 'service':
						if ($view != $view_c)
							return false;
						$code  = isset($array_params['type']) ? $array_params['type'] : '';
						$code_c = FSInput::get('type');
						if ($code == $code_c)
							return true;
						return false;

					case 'cat':
						$ccode  = isset($array_params['ccode']) ? $array_params['ccode'] : '';
						$ccode_c = FSInput::get('ccode');
						if (!empty($ccode) && $ccode_c == $ccode)
							return true;
						return false;

					case 'home':
						return true;
					default:
						return $view ==  $view_c ? true : false;
				}


				return false;
		}
	}
}
