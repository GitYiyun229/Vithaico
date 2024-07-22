<?php
// print_r($_REQUEST);die;
// alert error
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once "includes/defines.php";
if (USE_BENMARCH) {
    require_once 'libraries/Benchmark.class.php';
    Benchmark::startTimer();
}

// session
if (!isset($_SESSION)) {
    session_start();
}

$time = time() + 60 * 60 * 24 * 30;
if (!isset($_COOKIE['city_store'])) {
    setcookie('city_store', 1, $time, '/');
    setcookie('city_store_name', 'Hà Nội', $time, '/');
}
require_once "includes/config.php";
require_once "libraries/database/pdo.php";
$db = new FS_PDO();
if (USE_MEMCACHE) {
    $memcache = new Memcache();
    // $memcached->setOption(Memcached::OPT_CLIENT_MODE, Memcached::DYNAMIC_CLIENT_MODE);
    $memcache->addServer('127.0.0.1', 11211);
}
require_once "libraries/fsinput.php";
require_once 'libraries/fsfactory.php';

$cache = 0;
global $page_cache;
$page_cache = 1;

$raw = FSInput::get('raw');
$print = FSInput::get('print');

require_once "libraries/fstext.php";
require_once "libraries/fstable.php";
require_once "libraries/fsrouter.php";
require_once "libraries/csrf.php";
require_once "includes/functions.php";
require_once "libraries/fscontrollers.php";
require_once "libraries/fsmodels.php";
require_once 'libraries/fsdevice.php';
require_once 'libraries/fsuser.php';

//tao token chong tan cong csrf
csrf::createToken();

/* Phiên bản mobile */
$mobile = @$_SESSION['run_pc'];
$detect = new FSDevice;
if (($detect->isMobile()) && !$detect->isTablet() && !$mobile) {
    define('IS_MOBILE', 1);
    define('IS_MOBILE_PLUS', 1);
} else {
    define('IS_MOBILE', 0);
    define('IS_MOBILE_PLUS', 0);
}

if ($detect->isiOS() && substr($detect->version("iOS"), 0, 2) < 14 || substr($detect->version("Safari"), 0, 2) < 14) {
    define('IS_VERSION', 0);
} else {
    define('IS_VERSION', 1);
}

if ($detect->isTablet())
    define('IS_TABLEt', 1);
else
    define('IS_TABLEt', 0);

$user = new FSUser();

global $module, $view, $task;

$module = FSInput::get('module') ? FSInput::get('module') : 'home';
$view = FSInput::get('view') ? FSInput::get('view') : $module;
$task = FSInput::get('task') ? FSInput::get('task') : 'display';
$item_id = FSInput::get('Itemid');
$lang_request = FSInput::get('lang');

if ($lang_request) {
    $_SESSION['lang'] = $lang_request;
} else {
    $_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'vi';
}

$use_cache = USE_CACHE;
$translate = FSText::load_languages('font-end', $_SESSION['lang'], $module);
$uri = $_SERVER['REQUEST_URI'];
if (strpos($uri, "//") !== false) {
    $uri = str_replace('//', '/', $uri);
    header('Location: ' . $uri);
}

if ($raw) {
    $global_class = FSFactory::getClass('FsGlobal');
    $config = $global_class->get_all_config();
    $module_config = $global_class->get_module_config($module, $view, $task);
    include("libraries/templates.php");
    global $tmpl;
    $tmpl = new Templates();
    $cache_time = 0;
    if ($use_cache) {
        $cache_time = isset($module_config->cache) ? $module_config->cache : 3600;
    }
    // load main content not use Template
    $fsCache = FSFactory::getClass('FSCache');
    $uri = $_SERVER['REQUEST_URI'];

    preg_match('#\/(.*?)\.html#is', $uri, $u);
    if (isset($u[0])) {
        $u = $u[0];
    } else {
        $u = $uri;
    }
    $key = md5($u);
    $folder_cache = 'modules/' . $module;
    $content_cache = $fsCache->get($key, $folder_cache, $cache_time);
    if ($content_cache) {
        echo $content_cache;
    } else {


        $html = call_module($module, $view, $task);
        // put cache
        $fsCache->put($key, $html, $folder_cache);
        echo $html;
    }
    //
} else {
    // call config before call Template
    $global_class = FSFactory::getClass('FsGlobal');
    $config = $global_class->get_all_config();
    $module_config = $global_class->get_module_config($module, $view, $task);

    $cache_time = 0;
    if ($use_cache) {
        $cache_time = isset($module_config->cache) ? $module_config->cache : 3600;
    }
    // load main content use Template
    include("libraries/templates.php");
    global $tmpl;
    $tmpl = new Templates();

    if ($print) {
        $main_content = loadMainContent($module, $view, $task, 0);
        include_once('templates/' . $tmpl->tmpl_name . '/print.php');
        die;
    }

    if (!$cache_time || !$use_cache) {
        $main_content = loadMainContent($module, $view, $task, 0);
        ob_start();
        include_once("templates/" . $tmpl->tmpl_name . "/index.php");
        $all_website_content = ob_get_contents();
        ob_end_clean();

        echo get_wrapper_site($tmpl, 'header', $module, 0);
        echo $all_website_content;

        if (USE_BENMARCH) {
            echo '<div  class="benmarch noc hide">';
            echo Benchmark::showTimer(5) . ' sec| ';
            echo Benchmark::showMemory('kb') . ' kb';
            echo '</div>';
        }
        echo get_wrapper_site($tmpl, 'footer', $module, 0);
        echo '</body></html>';
    } else if ($use_cache != 2) {
        // use cache local or no cache
        $main_content = loadMainContent($module, $view, $task, $cache_time);
        ob_start();
        include_once("templates/" . $tmpl->tmpl_name . "/index.php");
        $all_website_content = ob_get_contents();
        ob_end_clean();

        echo get_wrapper_site($tmpl, 'header', $module, $cache_time);
        echo $all_website_content;

        if (USE_BENMARCH) {
            echo '<div class="benmarch ca1">';
            echo Benchmark::showTimer(5) . ' sec| ';
            echo Benchmark::showMemory('kb') . ' kb';
            echo '</div>';
        }
        echo get_wrapper_site($tmpl, 'footer', $module, $cache_time);
        echo '</body></html>';
    } else { 
        // use cache global
        $fsCache = FSFactory::getClass('FSCache');
        $uri = $_SERVER['REQUEST_URI'];
        preg_match('#\/(.*?)\.html#is', $uri, $u);
        if (isset($u[0])) {
            $u = $u[0];
        } else {
            $u = $uri;
            if (strpos($u, 'module') === false) {
                $u = '/';
            }
        }
        $key = md5($u);

        $folder_cache = 'modules/' . $module . '/' . $view;

        $sort = FSInput::get('order', 'defautl');
        switch ($sort) {
            case 'alpha':
                $folder_cache .= '_alpha';
                break;
            case 'desc':
                $folder_cache .= '_desc';
                break;
            case 'asc':
                $folder_cache .= '_asc';
                break;
        }

        $content_cache = $fsCache->get($key, $folder_cache, $cache_time);
        if ($content_cache) {
            echo $content_cache;
            if (USE_BENMARCH) {
                echo '<div  class="benmarch ca2 hide">';
                echo Benchmark::showTimer(5) . ' sec| ';
                echo Benchmark::showMemory('kb') . ' kb';
                echo '</div>';
            }
            echo '</body></html>';
        } else {
            // load content module ( not use cache by use cache Global)
            $main_content = loadMainContent($module, $view, $task, 0);

            ob_start();
            include_once("templates/" . $tmpl->tmpl_name . "/index.php");
            $html_body = $all_website_content = ob_get_contents();
            $html_header = get_wrapper_site($tmpl, 'header', $module, 0);
            $html_footer = get_wrapper_site($tmpl, 'footer', $module, 0);
            ob_end_clean();

            $html = $html_header . $html_body . $html_footer;
            // put cache
            $fsCache->put($key, $html, $folder_cache);
            echo $html;
            if (USE_BENMARCH) {
                echo '<div  class="benmarch noc2">';
                echo Benchmark::showTimer(5) . ' sec| ';
                echo Benchmark::showMemory('kb') . ' kb';
                echo '</div>';
            }
        }
    }
}

function display_msg_redirect()
{
    global $config;
    $html = '';
    if (isset($_SESSION['have_redirect'])) {
        if ($_SESSION['have_redirect'] == 1) {
            $html .= '
                <div id="msgModal" class="w-100 h-100 position-fixed left-0 top-0 flash-message-container" style="display: block;">
                    <div class="d-flex align-items-center justify-content-center w-100 h-100 ">
            ';

            $types = array(0 => 'error', 1 => 'alert', 2 => 'success');
            foreach ($types as $type) {
                if (isset($_SESSION["msg_$type"])) {
                    if ($type == 'success') {
                        $html .= '
                        <div class="p-4 text-center flash-message '.$type.'">
                            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="52" height="52" rx="26" fill="#3BA500" fill-opacity="0.08"/>
                                <rect x="6" y="6" width="40" height="40" rx="20" fill="#3BA500" fill-opacity="0.08"/>
                                <path d="M21.75 26L24.58 28.83L30.25 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#3BA500" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        ';
                    } else {
                        $html .= '
                        <div class="p-4 text-center flash-message '.$type.'">
                            <svg width="52" height="52" viewBox="0 0 52 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="52" height="52" rx="26" fill="#E81B2B" fill-opacity="0.08"/>
                                <rect x="6" y="6" width="40" height="40" rx="20" fill="#E81B2B" fill-opacity="0.08"/>
                                <path d="M23.17 28.83L28.83 23.17M28.83 28.83L23.17 23.17M26 36C31.5 36 36 31.5 36 26C36 20.5 31.5 16 26 16C20.5 16 16 20.5 16 26C16 31.5 20.5 36 26 36Z" stroke="#E81B2B" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        ';
                    }
                    $msg_error = $_SESSION["msg_$type"];
                    foreach ($msg_error as $item) {
                        $html .= '<div class="message mt-3">' . $item . '</div>';
                    }
                    unset($_SESSION["msg_$type"]);

                    // if ($type == 'success') {
                    //     $html .= '<a class="bt-modals" data-dismiss="modal">OK</a>';
                    // } else {
                    //     $html .= '<a class="bt-modals" data-dismiss="modal">Đóng</a>';
                    // }
                }
            }

            $html .= "</div></div></div>";
            $html .= '
                <script>
                    var modal = document.getElementById("msgModal");
                    var span = document.getElementsByClassName("close-modal")[0];
                    modal.onclick = function() {
                        modal.style.display = "none";
                    }
                    setTimeout(function(){
                        modal.style.display = "none";
                    }, 1500)
                </script>
            ';
        }
        unset($_SESSION['have_redirect']);
    }
    return $html;
}

/*
 * function Load Main content
 */
function loadMainContent($module = '', $view = '', $task = '', $cache_time = 0)
{
    $html = '';
    
    $html .= display_msg_redirect();

    if ($cache_time) {
        $fsCache = FSFactory::getClass('FSCache');
        $key = md5($_SERVER['REQUEST_URI']);
        $content_cache = $fsCache->get($key, 'modules/' . $module, $cache_time);
        if ($content_cache) {
            return $html . $content_cache;
        } else {
            $main_content = call_module($module, $view, $task);
            $fsCache->put($key, $main_content, 'modules/' . $module);
            return $html . $main_content;
        }
    } else { 
        $main_content = call_module($module, $view, $task);
        return $html . $main_content;
    }
}


function call_module($module, $view, $task)
{
    $path = PATH_BASE . 'modules' . DS . $module . DS . 'controllers' . DS . $view . ".php"; 
    if (file_exists($path)) {
        ob_start();
        require_once $path;
        $c = ucfirst($module) . 'Controllers' . ucfirst($view);
        $controller = new $c();
        $controller->$task();
        $main_content = ob_get_contents();
        ob_end_clean();
        return $main_content;
    } else {
        return;
    }
}

/*
 * Get header, footer for case: Cache Local
 * @cache_time ( second)
 */
function get_wrapper_site($tmpl, $wrapper_name = 'header', $module, $cache, $cache_time = 10)
{
    if ($cache && $cache_time) {
        $fsCache = FSFactory::getClass('FSCache');
        $key = md5($_SERVER['REQUEST_URI']);
        $wrapper = $fsCache->get($key, $wrapper_name . '/' . $module, $cache_time);
        if ($wrapper) {
            return $wrapper;
        } else {
            $func_call = 'load' . ucfirst($wrapper_name);
            ob_start();
            $tmpl->$func_call();
            $wrapper = ob_get_contents();
            ob_end_clean();
            $fsCache->put($key, $wrapper, $wrapper_name . '/' . $module);
            return $wrapper;
        }
    } else {
        $func_call = 'load' . ucfirst($wrapper_name);
        ob_start();
        $tmpl->$func_call();
        $rs = ob_get_contents();
        ob_end_clean();
        return $rs;
    }
}
