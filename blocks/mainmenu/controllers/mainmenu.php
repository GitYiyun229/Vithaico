<?php

include 'blocks/mainmenu/models/mainmenu.php';

class MainMenuBControllersMainMenu
{
	function display($parameters, $title)
	{
		$group = $parameters->getParams('group');
		$style = $parameters->getParams('style');

		if (!$group) {
			$group = $parameters->getParams('category_id');
		}

		$style = $style ? $style : 'default';
		 
		if (!$group)
			return;
		 
		$model = new MainMenuBModelsMainMenu();
		$list = $model->getList($group);
		if (!$list)
			return;

		// call views
		include 'blocks/mainmenu/views/mainmenu/' . $style . '.php';
	}

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
			if (strpos($link, '&ccode=' . $ccode) !== false) {
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
			case 'poll':
			case 'contact':
			case 'goals':
			case 'gallery':
			case 'partners':
			case 'ranks':
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
			case 'contents':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'contents':
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
			case 'services':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				switch ($view) {
					case 'service':
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
			case 'projects':
				$view  = isset($array_params['view']) ? $array_params['view'] : $module;
				$view_c = FSInput::get('view');
				if ($view == 'industries' && $view_c == 'industries') {
					return true;
				} elseif (($view == 'home' && $view_c == 'cat') || ($view == 'home' && $view_c == 'project') || ($view == 'home' && $view_c == 'regions')) {
					return true;
				}
				switch ($view) {
					case 'project':
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
						//						case 'home':
						//							return true;
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

					case 'categories':
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
				//				case 'video':
				//					$view  = isset($array_params['view'])?$array_params['view']: $module;
				//					$view_c = FSInput::get('view');
				//					switch ($view){
				//						case 'video':
				//							if($view != $view_c)
				//								return false;
				//							$code  = isset($array_params['code'])?$array_params['code']:'';
				//							$code_c = FSInput::get('code');
				//							if($code == $code_c)
				//								return true;
				//							return false;
				//						default:
				//							return $view ==  $view_c ? true:false;
				//					}
				return false;
		}
	}
}
