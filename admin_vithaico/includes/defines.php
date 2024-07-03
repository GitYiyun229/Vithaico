<?php
$sort_path = $_SERVER['SCRIPT_NAME'];

$sort_path =  (preg_replace('/\/[a-zA-Z0-9\_]+\.php/i', '', $sort_path));

$pos = strripos($sort_path, '/');

$folder_admin = substr($sort_path, ($pos + 1));

define('URL_ROOT', $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . str_replace($folder_admin, '', $sort_path));
define('URL_ROOT_REDUCE', str_replace($folder_admin, '', $sort_path));
define('URL_ROOT_ADMIN', URL_ROOT . str_replace('/', '', $sort_path) . '/');

if (!defined('DS')) {
	define('DS', DIRECTORY_SEPARATOR);
}

$path = $_SERVER['SCRIPT_FILENAME'];
$path = str_replace('index.php', '', $path);
$path = str_replace('index2.php', '', $path);
$path = str_replace('/', DS, $path);
$path = str_replace('\\', DS, $path);
$path = str_replace(DS . $folder_admin . DS, DS, $path);
define('PATH_BASE', $path);

define('IS_REWRITE', 1);
define('WRITE_LOG_MYSQL', 0);
define('USE_MEMCACHE', 0);

$positions = array(
	'top_default' => 'Top',
	'bot_default' => 'Bottom',
	'home_news' => 'Tin tức',
	'top' => 'Home Top'
);
