<?php
ini_set('display_errors', '0');
ini_set('display_startup_errors', '1');
ini_set('session.gc_maxlifetime', 36000);
error_reporting (E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();

define('LINK_AMIN', 'admin');
require_once ("../includes/config.php");
require_once ("includes/defines.php");
require_once ('../libraries/database/pdo.php');
global $db;
$db = new FS_PDO();

require_once ("../includes/functions.php");
require_once ("../libraries/fsinput.php");
require_once ('../libraries/fsfactory.php');
require_once ("../libraries/fstext.php");
require_once ("libraries/fstable.php");
//require_once ('../libraries/database/mysql_log.php');
//$db -> connect();

$lang_request = FSInput::get('ad_lang');
if ($lang_request){
    $_SESSION['ad_lang'] = $lang_request;
} else{
    $_SESSION['ad_lang'] = isset($_SESSION['ad_lang']) ? $_SESSION['ad_lang'] : 'vi';
}
$module = FSInput::get('module', 'home');
$translate = FSText::load_languages('backend', $_SESSION['ad_lang'], $module);

require_once ("libraries/toolbar/toolbar.php");
require_once ("../libraries/fsrouter.php");
require_once ("libraries/pagination.php");
require_once ("libraries/template_helper.php");
require_once ('../libraries/errors.php');
//require_once ('../libraries/fsfactory.php');
require_once ("libraries/fssecurity.php");
require_once ('libraries/controllers.php');
require_once ('libraries/models.php');
include_once '../libraries/ckeditor/fckeditor.php';
require_once ('libraries/controllers_categories.php');
require_once ('libraries/models_categories.php');
define('PATH_ADMINISTRATOR', dirname(__file__));
$loginpath = "login.php";
if (!isset($_SESSION["ad_logged"]) || ($_SESSION["ad_logged"] != 1)){
    header("Location: login.php");
}

//$global_class = FSFactory::getClass('FsGlobal');
//$config = $global_class -> get_all_config();

function loadMainContent($module){
    if($module){
        if(!isset($_GET['module'])) $_GET['module'] = 'home';
        $view = FSInput::get('view', $module);
        $task = FSInput::get('task', 'display');
        $task = $task ? $task : 'display';
        $path = PATH_ADMINISTRATOR . DS . 'modules' . DS . $module . DS . 'controllers' .
            DS . $view . ".php";
        if (!file_exists($path))
            die(FSText::_("Not found controller"));
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        
        $permission = FSSecurity::check_permission($module, $view, $task);
        if (!$permission){
            echo FSText::_("Bạn không có quyền thực hiện chức năng này");
            return;
        }
        $controller->$task();
    }
}
$toolbar = new ToolbarHelper();
ob_start();
loadMainContent($module);
$main_content = ob_get_contents();
ob_end_clean();

$raw = FSInput::get('raw');
$print = FSInput::get('print');
if ($raw){
    echo $main_content;
    $db->close();
}else{
    if ($print)
        include_once ("templates/default/print.php");
    else
        include_once ("templates/default/index.php");
     $db->close();
}
if($module == 'update'){
	rewrite_log($main_content);
}

function rewrite_log($main_content){
	 $fn = "log/log_".time().".txt";
	$fp = fopen($fn,"w+") or die ("Error opening file in write mode!");
	$content .= '\n================'.time().'===================\n';
	$content .= $main_content;
    fputs($fp,$content);
    fclose($fp) or die ("Error closing file!");
}
?>
