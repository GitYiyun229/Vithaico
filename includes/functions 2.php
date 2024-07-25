<?php
function strip_tags_content($text, $tags = '', $invert = FALSE)
{

    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags);
    $tags = array_unique($tags[1]);

    if (is_array($tags) and count($tags) > 0) {
        if ($invert == FALSE) {
            return preg_replace('@<(?!(?:' . implode('|', $tags) . ')\b)(\w+)\b.*?>.*?</\1>@si', '', $text);
        } else {
            return preg_replace('@<(' . implode('|', $tags) . ')\b.*?>.*?</\1>@si', '', $text);
        }
    } elseif ($invert == FALSE) {
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text);
    }
    return $text;
}

function clean($string)
{
    //$string = str_replace('', '-', $string); // Replaces all spaces with hyphens.
    $string =  str_replace("'", '', $string);
    $string =  str_replace('OR', '', $string);
    $string =  str_replace('or', '', $string);
    //$string =  str_replace('%', '', $string);
    $string =  str_replace('&', '', $string);
    $string =  str_replace('(', '', $string);
    $string =  str_replace(')', '', $string);
    $string =  str_replace('AND', '', $string);
    $string =  str_replace('and', '', $string);
    $string =  str_replace('UNION', '', $string);
    $string =  str_replace('union', '', $string);
    $string =  str_replace('select', '', $string);
    $string =  str_replace('SELECT', '', $string);
    $string =  str_replace('CONCAT', '', $string);
    $string =  str_replace('concat', '', $string);
    $string =  str_replace('count', '', $string);
    $string =  str_replace('COUNT', '', $string);
    $string =  str_replace('from', '', $string);
    $string =  str_replace('FROM', '', $string);
    $string =  str_replace('*', '', $string);
    $string =  str_replace('`', '', $string);
    $string =  str_replace('=', '', $string);
    $string =  str_replace('--', '', $string);
    $string =  str_replace('--+', '', $string);
    $string =  str_replace('--+-', '', $string);
    $string =  str_replace(';%00', '', $string);
    $string =  str_replace('`', '', $string);
    $string =  str_replace('+', '', $string);
    $string =  str_replace('|', '', $string);
    $string =  str_replace('~', '', $string);
    $string =  str_replace('!', '', $string);
    $string =  str_replace('^', '', $string);
    $string =  str_replace('\\', '', $string);
    $string =  str_replace('"', '', $string);
    $string =  str_replace('/', '', $string);
    //$string = preg_replace('#[^\w()/.%\-&]#',"",$string);
    return $string; // Removes special chars.
}

function randomkey($str, $keyword = 0)
{
    $return = '';
    $strreturn = explode(" ", trim($str));
    $i = 0;
    $listid = '';
    while ($i < count($strreturn)) {
        $id = rand(0, count($strreturn));
        if (strpos($listid, '[' . $id . ']') === false) {
            if (isset($strreturn[$id])) {
                $return .= $strreturn[$id] . ' ';
                $i++;
                if ($keyword == 1 && ($i % 2) == 0 && $i < count($strreturn))  $return .= ',';
                $listid .= '[' . $id . ']';
            }
        }
    }
    return $return;
}
function addRelate($table, $feild_id, $field_relate, $record_id, $arrayRelate = array())
{
    $db_delete = new db_execute("DELETE FROM " . $table . " WHERE " . $feild_id . "=" . $record_id);
    unset($db_delete);
    foreach ($arrayRelate as $key => $value) {
        $db_relate_execute = new db_execute("INSERT INTO " . $table . "(" . $feild_id . "," . $field_relate . ") VALUES(" . $record_id . ", " . intval($value) . ")");
        unset($db_relate_execute);
    }
}

/*
save to cookie
time : thoi gian save cookie, neu = 0 thi` save o cua so hien ha`nh
*/
//3 ngay : 3*24*60*60
function savecookie($name = 'Cook', $value = '', $time = '259200')
{
    setcookie($name, $value, time() + $time, '/');
}

function array_language()
{
    return array(
        1 => "vn", 2 => "en"
    );
}

function formatNumber($value)
{
    return number_format($value, 0, "", ".");
}

function random()
{
    $rand_value = "";
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(65, 90));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    $rand_value .= chr(rand(97, 122));
    $rand_value .= rand(1000, 9999);
    return $rand_value;
}

function getAge($birthdate = '0000-00-00')
{
    if ($birthdate == '0000-00-00') return 'Unknown';

    $bits = explode('-', $birthdate);
    $age = date('Y') - $bits[0] - 1;

    $arr[1] = 'm';
    $arr[2] = 'd';

    for ($i = 1; $arr[$i]; $i++) {
        $n = date($arr[$i]);
        if ($n < $bits[$i])
            break;
        if ($n > $bits[$i]) {
            ++$age;
            break;
        }
    }
    return $age;
}

// '%y Year %m Month %d Day'=>  1 Year 3 Month 14 Days
// '%m Month %d Day'=>  3 Month 14 Day
// '%d Day %h Hours'=>  14 Day 11 Hours
// '%d Day' =>  14 Days
// '%h Hours %i Minute %s Seconds'  =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'   =>  49 Minute 36 Seconds
// '%h Hours=>  11 Hours
// '%a Days =>  468 Days

function count_date($date_1, $date_2, $differenceFormat = '%a')
{
    if (!empty($date_1) && !empty($date_2)) {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);
        $interval = date_diff($datetime1, $datetime2);
        return $interval->format($differenceFormat);
    } else {
        return 'chưa rõ';
    }
}

function count_date_create($date_1, $date_2)
{
    $count_y = count_date($date_1, $date_2, '%y');
    $count_m = count_date($date_1, $date_2, '%m');
    $count_d = count_date($date_1, $date_2, '%a');
    $count_h = count_date($date_1, $date_2, '%h');
    $count_i = count_date($date_1, $date_2, '%i');
    $count_s = count_date($date_1, $date_2, '%s');
    if ($count_y) {
        $count_date = $count_y . ' năm trước';
    } else if ($count_m) {
        $count_date = $count_m . ' tháng trước';
    } else if ($count_d) {
        $count_date = $count_d . ' ngày trước';
    } else if ($count_h) {
        $count_date = $count_h . ' giờ trước';
    } else if ($count_i) {
        $count_date = $count_i . ' phút trước';
    } else if ($count_s) {
        $count_date = $count_s . ' giây trước';
    }
    return $count_date;
}

function checked($session, $int = 0)
{
    $checked = !empty($session) && $session == $int ? 'checked="checked"' : '';
    return $checked;
}

function selected($session, $int = 0)
{
    $selected = !empty($session) && $session == $int ? 'selected="selected"' : '';
    return $selected;
}

function stripUnicode($str)
{
    if (!$str)
        return false;

    $unicode = array(
        'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
        'A' => 'À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ',
        'd' => 'đ',
        'D' => 'Đ',
        'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
        'E' => 'È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ',
        'i' => 'í|ì|ỉ|ĩ|ị',
        'I' => 'Ì|Í|Ị|Ỉ|Ĩ',
        'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
        'O' => 'Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ',
        'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
        'U' => 'Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ',
        'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
        'Y' => 'Ỳ|Ý|Ỵ|Ỷ|Ỹ',

    );
    foreach ($unicode as $nonUnicode => $uni) {
        $str = preg_replace("/($uni)/i", $nonUnicode, $str);
    }

    return $str;
}

function str_encode($encodeStr = "")
{
    $returnStr = "";
    if ($encodeStr == '') return $encodeStr;
    if (!empty($encodeStr)) {
        $enc = base64_encode($encodeStr);
        $enc = str_replace('=', '', $enc);
        $enc = str_rot13($enc);
        $returnStr = $enc;
    }
    return $returnStr;
}

function str_decode($encodedStr = "", $type = 0)
{
    $returnStr = "";
    $encodedStr = str_replace(" ", "+", $encodedStr);
    if (!empty($encodedStr)) {
        $dec = str_rot13($encodedStr);
        $dec = base64_decode($dec);
        $returnStr = $dec;
    }
    return $returnStr;
}

function getURLR($mod_rewrite = 1, $serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    if ($mod_rewrite == 1) {
        return $_SERVER['REQUEST_URI'];
    } else {
        return getURL($serverName, $scriptName, $fileName, $queryString, $varDenied);
    }
}

//hàm get URL
function getURL($serverName = 0, $scriptName = 0, $fileName = 1, $queryString = 1, $varDenied = '')
{
    $url     = '';
    $slash = '/';
    if ($scriptName != 0) $slash    = "";
    if ($serverName != 0) {
        if (isset($_SERVER['SERVER_NAME'])) {
            $url .= 'http://' . $_SERVER['SERVER_NAME'];
            if (isset($_SERVER['SERVER_PORT'])) $url .= ":" . $_SERVER['SERVER_PORT'];
            $url .= $slash;
        }
    }
    if ($scriptName != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($fileName    != 0) {
        if (isset($_SERVER['SCRIPT_NAME']))    $url .= substr($_SERVER['SCRIPT_NAME'], strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
    }
    if ($queryString != 0) {
        $dau = 0;
        $url .= '?';
        reset($_GET);
        if ($varDenied != '') {
            $arrVarDenied = explode('|', $varDenied);
            while (list($k, $v) = each($_GET)) {
                if (array_search($k, $arrVarDenied) === false) {
                    $url .= (($dau == 0) ? '' : '&') . $k . '=' . urlencode($v);
                    $dau  = 1;
                }
            }
        } else {
            while (list($k, $v) = each($_GET)) $url .= '&' . $k . '=' . urlencode($v);
        }
    }
    $url = str_replace('"', '&quot;', strval($url));
    return $url;
}

//hàm t?o link khi c?n thi?t chuy?n sang mod rewrite
function createLink($type = "detail", $url = array(), $path = "", $con_extenstion = 'html', $rewrite = 1)
{
    global $lang_path;
    $menuReturn = '';
    $keyReplace = '_';
    //neu ko de mod rewrite
    if ($rewrite == 0) {
        $menuReturn = $path . $type . ".php?";
        foreach ($url as $key => $value) {
            if ($key == "module") $value = strtolower($value);
            if ($key != "title") {
                $menuReturn .= $key . "=" . $value . "&";
            }
        }
        $menuReturn = substr($menuReturn, 0, strrpos($menuReturn, "&"));
        //tra ve url ko rewrite
        return $menuReturn;
    }
    $module = "d";
    switch (strtolower($url["module"])) {
        case "news":
        case "km":
            $module = 'n';
            break;
        case "static":
            $module = 's';
            break;
        case "phukien":
            $module = 'p';
            break;
    }
    //tao luat cho mod rewrite
    switch ($type) {

        case "detail":
            if (strtolower($url["module"]) == "product") {
                $menuReturn = "/" . (isset($url["supname"]) ? $url["supname"] . "/" : "") .  removeTitle($url["title"], $keyReplace) . '-c' . $url["iCat"] . 'd' . $url["iData"] . (isset($url["tab"]) ? 't' . $url["tab"] : '') . '.html';
            } else {
                $menuReturn = "/" .  removeTitle($url["title"], $keyReplace) . '-' . $module . $url["iCat"] . '-' . $url["iData"] . '.html';
            }
            break;
        case "type":
            $menuReturn = '/' .  removeTitle($url["title"], $keyReplace) . '/' . $url["iCat"] . '/';
            if (isset($url["iSup"])) $menuReturn = $lang_path .  removeTitle($url["title"], $keyReplace) . $keyReplace  . strtolower($url["module"]) . $keyReplace . $url["iCat"] . $keyReplace . 'hsx_' . $url["iSup"] . '.' . $con_extenstion;
            if (isset($url["iPri"])) $menuReturn = $lang_path .  removeTitle($url["title"], $keyReplace) . $keyReplace  . strtolower($url["module"]) . $keyReplace . $url["iCat"] . $keyReplace . 'gia_' . $url["iPri"] . '.' . $con_extenstion;
            break;
        case "sup":
            $menuReturn = "/" . removeTitle($url["title"], $keyReplace) . '/';
            break;
    }
    return $menuReturn;
}

function removethuoctinh($value)
{
    $value = str_replace("|", "", $value);
    $value = str_replace(";", "", $value);
    return $value;
}

function getKeyword($value)
{
    $value = str_replace("\'", "'", $value);
    $value = str_replace("'", "''", $value);
    $value = str_replace(" ", "%", $value);
    return $value;
}
 
/*
*	type: msg, error, alert.
*/

function setRedirect($url, $msg = '', $type = '')
{
    if ($msg) {
        switch ($type) {
            case 'error':
                if (!isset($_SESSION['msg_error']))
                    $msg_error = array();
                else
                    $msg_error = $_SESSION['msg_error'];

                $msg_error[] = $msg;
                $_SESSION['msg_error'] = $msg_error;
                break;
            case 'alert':
                if (!isset($_SESSION['msg_alert']))
                    $msg_alert = array();
                else
                    $msg_alert = $_SESSION['msg_alert'];

                $msg_alert[] = $msg;
                $_SESSION['msg_alert'] = $msg_alert;
                break;
            default:
                if (!isset($_SESSION['msg_success']))
                    $msg_suc = array();
                else
                    $msg_suc = $_SESSION['msg_success'];

                $msg_suc[] = $msg;
                $_SESSION['msg_success'] = $msg_suc;
                break;
        }
        $_SESSION['have_redirect'] = 1;
    }
    if (headers_sent()) {
        header("Content-Type: text/html; charset=utf-8", true);
        echo "<script>document.location.href='$url';</script>\n";
    } else {
        //@ob_end_clean(); // clear output buffer
        session_write_close();
        header("Content-Type: text/html; charset=utf-8", true);
        //header( 'HTTP/1.1 301 Moved Permanently' );
        header("Location: " . $url);
    }
    exit();
}

function replaceMQ($text)
{
    $text    = str_replace("\'", "'", $text);
    $text    = str_replace("'", "''", $text);
    return $text;
}
 
function getKeyRef($query, $keyname = "q")
{
    $strreturn = '';
    preg_match("#" . $keyname . "=(.*)#si", $query, $match);
    if (isset($match[1])) $strreturn = preg_replace('#\&(.*)#si', "", $match[1]);
    return urldecode($strreturn);
}

function int_to_words($x)
{
    $nwords = array(
        "không", "m?t", "hai", "ba", "b?n", "nam", "sáu", "b?y",
        "tám", "chín", "mu?i", "mu?i m?t", "mu?i hai", "mu?i ba",
        "mu?i b?n", "mu?i lam", "mu?i sáu", "mu?i b?y", "mu?i tám",
        "mu?i chín", "hai muoi", 30 => "ba muoi", 40 => "b?n muoi",
        50 => "nam muoi", 60 => "sáu muoi", 70 => "b?y muoi", 80 => "tám muoi",
        90 => "chín muoi"
    );
    if (!is_numeric($x)) {
        $w = '#';
    } else if (fmod($x, 1) != 0) {
        $w = '#';
    } else {
        if ($x < 0) {
            $w = 'minus ';
            $x = -$x;
        } else {
            $w = '';
        }
        if ($x < 21) {
            $w .= $nwords[$x];
        } else if ($x < 100) {
            $w .= $nwords[10 * floor($x / 10)];
            $r = fmod($x, 10);
            if ($r > 0) {
                $w .= ' ' . $nwords[$r];
            }
        } else if ($x < 1000) {
            $w .= $nwords[floor($x / 100)] . ' tram';
            $r = fmod($x, 100);
            if ($r > 0) {
                $w .= '  ' . int_to_words($r);
            }
        } else if ($x < 1000000) {
            $w .= int_to_words(floor($x / 1000)) . ' ngàn';
            $r = fmod($x, 1000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $w .= ' ';
                }
                $w .= int_to_words($r);
            }
        } else {
            $w .= int_to_words(floor($x / 1000000)) . ' tri?u';
            $r = fmod($x, 1000000);
            if ($r > 0) {
                $w .= ' ';
                if ($r < 100) {
                    $word .= ' ';
                }
                $w .= int_to_words($r);
            }
        }
    }
    return $w . '';
}

function fsdate($date = '', $type = 0)
{
    // format 'D, d/m/Y, H:i '
    if ($date) {
        $Day = date('D', strtotime($date));
        $str_date =  date('d/m/Y, H:i', strtotime($date));
    } else {
        $Day = date('D');
        $str_date =  date('d/m/Y, H:i');
    }
    $Day = strtoupper($Day);
    $str = "";
    //TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
    switch ($Day) {
        case 'MON':
            $str .= "Th&#7913; 2";
            break;
        case 'TUE':
            $str .= "Th&#7913; 3";
            break;
        case 'WED':
            $str .= "Th&#7913; 4";
            break;
        case 'THU':
            $str .= "Th&#7913; 5";
            break;
        case 'FRI':
            $str .= "Th&#7913; 6";
            break;
        case 'SAT':
            $str .= "Th&#7913; 7";
            break;
        case 'SUN':
            $str .= "Ch&#7911; nh&#7853;t ";
            break;
    }

    if ($type == 1) {
        $str .= ", ng&#224;y " . $str_date;
    } else {
        $str .= ", " . $str_date;
        $str .= " GMT+7";
    }

    return $str;
}

function show_datetime($date = '')
{
    // format 'D, d/m/Y, H:i '
    if ($date) {
        $Day = date('D', strtotime($date));
        $str_date =  date('d/m/Y, H:i A', strtotime($date));
    } else {
        $Day = date('D');
        $str_date =  date('d/m/Y, H:i A');
    }
    $Day = strtoupper($Day);
    $str = "";
    //TUE WED THU FRI SAT SUN MON TUE WED THU FRI SAT SUN MON JAN FEB
    switch ($Day) {
        case 'MON':
            $str .= "Thứ 2";
            break;
        case 'TUE':
            $str .= "Thứ 3";
            break;
        case 'WED':
            $str .= "Thứ 4";
            break;
        case 'THU':
            $str .= "Thứ 5";
            break;
        case 'FRI':
            $str .= "Thứ 6";
            break;
        case 'SAT':
            $str .= "Thứ 7";
            break;
        case 'SUN':
            $str .= "Chủ nhật";
            break;
    }
    $str .= ", " . $str_date;
    return $str;
}

function count_words($str)
{
    $words = 0;

    $str =  preg_replace("/ +/i", " ", $str);
    $array = explode(" ", $str);
    for ($i = 0; $i < count($array); $i++) {

        if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))

            $words++;
    }
    return $words;
}

function implodeWord($str, $noWord)
{

    $str = preg_replace("/ +/i", " ", $str);
    $array = explode(" ", $str);


    for ($i = 0; $i < $noWord; $i++) {
        if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i])) $aryContent[] = $array[$i];
    }
    $strContent = implode(" ", $aryContent);
    return $strContent;
}

function getWord($noWord, $str, $tag = '')
{

    if ($tag) {
        $noCountWord = count_words(strip_tags($str, $tag));
    } else {
        $noCountWord = count_words(strip_tags($str));
    }

    if ($noCountWord >= $noWord) {
        $content = implodeWord(strip_tags($str), $noWord) . '...';
    } else {
        $content = strip_tags($str);
    }

    $k = chr(92);
    $content = str_replace($k, "", $content);

    return $content;
}

function get_word_by_length($maxleng = 100, $str, $suppend = '...')
{
    $str =  preg_replace("/ +/i", " ", $str);

    $i = $maxleng;
    if (mb_strlen($str) <= $maxleng)
        return $str;

    while (true) {
        $character_current = @mb_substr($str, ($i), 1, 'utf-8');

        if (empty($character_current) || $character_current == ' ' || $character_current == ',' || $character_current == '|')
            return mb_substr($str, 0, $i, 'utf-8') . $suppend;
        $i--;
    }
    return     $str . $suppend;
}

function cutString($string = '', $totalChar = 0, $ext = '...')
{
    if (mb_strlen($string, 'UTF-8') > $totalChar) {
        $string = mb_substr($string, 0, $totalChar, 'UTF-8');
        if (mb_strrpos($string, ' ', 0, 'UTF-8')) {
            $string = mb_substr($string, 0, mb_strrpos($string, ' ', 0, 'UTF-8'), 'UTF-8');
        }
        return $string . $ext;
    }
    return $string;
}

function format_money($price, $current = '₫', $text = 'Liên hệ')
{
    if (!$price)
        return $text;
    return  number_format($price, 0, '.', '.').$current;
}

function format_money_0($price, $current = '₫', $text = 'Liên hệ')
{
    if (!$price)
        return $text;
    return number_format($price, 0, ',', '.') . '' . $current . '';
}

function get_price_eps($price)
{
    if (!$price)
        $price = 0;
    $rate_vnd_eps = 100000.0;
    $price = number_format($price / $rate_vnd_eps, 0, ',', '.');
    return $price;
}

function get_price_usd($price)
{
    $rate_vnd_usd = 1950000;
    return  number_format($price / $rate_vnd_usd, 0, ',', '.');
}

/*
 * return price VND
 */
function money_transform_to_vnd($price, $currency)
{

    if (!$currency || strtoupper($currency) == 'VND') {
        return $price;
    }
    if ($currency == "USD") {
        $rate_vnd_usd = 1950000;
        return  $price * $rate_vnd_usd;
    }
}

function calculator_price($price, $price_old, $is_promotion = 0, $date_start = '', $date_end = '', $use_wholesale = 0, $wholesale_prices = '')
{
    $result = array();
    if ($is_promotion) {
        if ($date_start <  date('Y-m-d H:i:s') && $date_end >  date('Y-m-d H:i:s')) {
            $result['price']  = $price;
            $result['price_old'] = $price_old;
        } else {
            $result['price'] = $price_old;
            $result['price_old'] = $price_old;
        }
    } else {
        if ($price_old - $price && $price)
            $percent = round((($price_old - $price) / $price_old) * 100);
        // $percent = 0;
        else
            $percent = 0;
        $result['price'] = $price;
        $result['percent'] = $percent;
        $result['price_old']  = $price_old;
    }
    if ($use_wholesale) {
        if (isset($_COOKIE['user_id'])) {
            $result['wholesale_prices'] = $wholesale_prices;
        } else {
            $result['wholesale_prices'] =    $result['price'];
        }
    }


    return $result;
}

/*
 * Input: date
 * Output: 12h30 ngày 2-3-2011
 */
function format_date($str_time)
{
    $time = strtotime($str_time);
    $hour = date('H', $time);
    $minute = date('i', $time);
    $date = date('d-m-Y', $time);
    return $hour . 'h' . $minute . ' ngày ' . $date;
}

function encodeURIComponent($str)
{
    $revert = array('%21' => '!', '%2A' => '*', '%27' => "'", '%28' => '(', '%29' => ')');
    return strtr(rawurlencode($str), $revert);
}

/******* end CUT STRING BY LENGTH ********/
function image_to_bytes($img_source, $method_resize = 'resized_not_crop', $new_width = 1, $new_height = 1, $quality = 100)
{
    // Begin capturing the byte stream
    ob_start();
    $img_source = str_replace(' ', '%20', $img_source);

    list($old_width, $old_height) = getimagesize($img_source);
    if ($method_resize == 'resized_not_crop') {
        if (!$new_width) {
            $new_width  = $old_width * $new_height / $old_height;
        }
        if (!$new_height) {
            $new_height = $old_height * $new_width / $old_width;
        }

        $file_ext = strtolower(substr($img_source, (strripos($img_source, '.') + 1), strlen($img_source)));

        $cropped_tmp = @imagecreatetruecolor($new_width, $new_height)
            or die("Cannot Initialize new GD image stream when cropped");

        // transparent
        imagealphablending($cropped_tmp, false);
        imagesavealpha($cropped_tmp, true);
        $transparent = imagecolorallocatealpha($cropped_tmp, 255, 255, 255, 127); //
        imagefilledrectangle($cropped_tmp, 0, 0, $new_width, $new_height, $transparent);
        // end transparent
        if ($file_ext == "png") {
            $source = imagecreatefrompng($img_source);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $source = imagecreatefromjpeg($img_source);
        } elseif ($file_ext == "gif") {
            $source = imagecreatefromgif($img_source);
        }

        imagecopyresampled($cropped_tmp, $source, 0, 0, 0, 0, $new_width, $new_height, $old_width, $old_height);


        if ($file_ext == "png") {
            $img  =  imagepng($cropped_tmp, NULL, 0);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $img  =  imagejpeg($cropped_tmp, NULL, 90);
        } elseif ($file_ext == "gif") {
            $img  =  imagegif($cropped_tmp, NULL, 0);
        }
    } else if ($method_resize == 'resize_image') {
        $crop_width = $new_width;
        $crop_height = $new_height;
        if (!$crop_width && !$crop_height) {
            $crop_width = $old_width;
            $crop_height = $old_height;
        } else if (!$crop_width) {
            $crop_width =     $crop_height * $old_width / $old_height;
        } else if (!$crop_height) {
            $crop_height =     $crop_width *  $old_height / $old_width;
        }
        if (($crop_width / $crop_height) > ($old_width / $old_height)) {
            $real_height = $crop_height;
            $real_width = $real_height * $old_width / $old_height;
        } else {
            $real_width = $crop_width;
            $real_height = (($real_width * $old_height) / $old_width);
        }

        $file_ext = strtolower(substr($img_source, (strripos($img_source, '.') + 1), strlen($img_source)));

        // new
        $newpic = imagecreatetruecolor(round($real_width), round($real_height));

        // transparent
        imagealphablending($newpic, false);
        imagesavealpha($newpic, true);
        $transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127); //
        imagefilledrectangle($newpic, 0, 0, $real_width, $real_height, $transparent);


        if ($file_ext == "png") {
            $source = imagecreatefrompng($img_source);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $source = imagecreatefromjpeg($img_source);
        } elseif ($file_ext == "gif") {
            $source = imagecreatefromgif($img_source);
        }

        if (!imagecopyresampled($newpic, $source, 0, 0, 0, 0, $real_width, $real_height, $old_width, $old_height)) {
            return false;
        }
        // create frame
        $final = imagecreatetruecolor($crop_width, $crop_height);
        // transparent
        imagealphablending($final, false); //
        imagesavealpha($final, true); //
        $transparent = imagecolorallocatealpha($final, 255, 255, 255, 127); //
        imagefill($final, 0, 0, $transparent);
        // end transparent

        imagecopy($final, $newpic, (abs($crop_width - $real_width) / 2), (abs($crop_height - $real_height) / 2), 0, 0, $real_width, $real_height);


        if ($file_ext == "png") {
            $img  =  imagepng($final, NULL, 0);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $img  =  imagejpeg($final, NULL, 100);
        } elseif ($file_ext == "gif") {
            $img  =  imagegif($final, NULL, 0);
        }
        // end transparent
    } else if ($method_resize == 'cut_image') {
        $crop_width = $new_width;
        $crop_height = $new_height;

        if (($crop_width / $crop_height) > ($old_width / $old_height)) {
            $real_width = $crop_width;
            $real_height = (($real_width * $old_height) / $old_width);
            $x_crop = 0;
            $y_crop = 0;
        } else {
            $real_height = $crop_height;
            $real_width = $real_height * $old_width / $old_height;
            $x_crop = ((abs($real_width - $crop_width)) / 2) * $old_height / $crop_height;
            $x_crop = round($x_crop);
            $y_crop =     0;
        }


        $file_ext = strtolower(substr($img_source, (strripos($img_source, '.') + 1), strlen($img_source)));

        // new
        $newpic = imagecreatetruecolor($crop_width, $crop_height);
        // transparent
        imagealphablending($newpic, false);
        imagesavealpha($newpic, true);
        $transparent = imagecolorallocatealpha($newpic, 255, 255, 255, 127); //
        imagefilledrectangle($newpic, 0, 0, $crop_width, $crop_height, $transparent);

        if ($file_ext == "png") {
            $source = imagecreatefrompng($img_source);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $source = imagecreatefromjpeg($img_source);
        } elseif ($file_ext == "gif") {
            $source = imagecreatefromgif($img_source);
        }

        if (!imagecopyresampled($newpic, $source, 0, 0, $x_crop, $y_crop, $real_width, $real_height, $old_width, $old_height)) {
            // Errors::setErrors("Not copy and resize part of an image with resampling when cropped");
        }


        // header('Content-Type: image/jpeg');

        if ($file_ext == "png") {
            $img  =  imagepng($newpic, NULL, 0);
        } elseif ($file_ext == "jpg" || $file_ext == "jpeg") {
            $img  =  imagejpeg($newpic, NULL, 90);
        } elseif ($file_ext == "gif") {
            $img  =  imagegif($newpic, NULL, 0);
        }




        // end transparent
    }

    //  // generate the byte stream
    //  imagejpeg($img, NULL, $quality);

    //  // and finally retrieve the byte stream
    $rawImageBytes = ob_get_clean();
    return "data:image/jpeg;base64," . base64_encode($rawImageBytes);
}

function image_resized($img_source, $method_resize = 'resized_not_crop', $new_width = 1, $new_height = 1, $quality = 100)
{
    $return = URL_ROOT . 'libraries/fsresized.php?s=' . $img_source . '&m=' . $method_resize . '&w=' . $new_width . '&h=' . $new_height . '&q=' . $quality;

    return  $return;
}

function image_to_base64($path_to_image)
{
    $type = pathinfo($path_to_image, PATHINFO_EXTENSION);
    $image = file_get_contents($path_to_image);
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($image);
    return $base64;
}

function recursiveRemoveDirectory($directory)
{
    foreach (glob("{$directory}/*") as $file) {
        if (is_dir($file)) {
            recursiveRemoveDirectory($file);
        } else {
            unlink($file);
        }
    }
    rmdir($directory);
}

function time_elapsed_string($ptime)
{
    $etime = time() - $ptime;
    if ($etime < 1) {
        return 'Vừa xong';
    }

    $a = array(
        365 * 24 * 60 * 60  =>  'year',
        30 * 24 * 60 * 60  =>  'month',
        24 * 60 * 60  =>  'day',
        60 * 60  =>  'hour',
        60  =>  'minute',
        1  =>  'second'
    );
    $a_plural = array(
        'year'   => 'năm',
        'month'  => 'tháng',
        'day' => 'ngày',
        'hour'   => 'giờ',
        'minute' => 'phút',
        'second' => 'giây'
    );

    foreach ($a as $secs => $str) {
        $d = $etime / $secs;
        if ($d >= 1) {
            // if ($etime < 86400000){
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' trước';
            // }else{
            // 	return date('d/m/Y | H:i',$ptime);
            // }
        }
    }
}

function randomPassword()
{
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789!@#$%^&*()+";
    for ($i = 0; $i < 10; $i++) {
        $n = rand(0, count($alphabet) - 1);
        $pass[$i] = $alphabet[$n];
    }
    return $pass;
}

function ckeditor($name, $content = '', $toolbar = '2', $language = 'vi', $width = 'auto', $height = 200)
{
    global $ckeditor_loaded;

    $code = '';
    if (!$ckeditor_loaded) {
        $code .= '<script type="text/javascript" src="' . URL_ROOT . 'asset/ckeditor/ckeditor.js"></script>';
        $ckeditor_loaded = true;
    }


    $code .= '<textarea name="' . $name . '" id="' . $name . '">' . $content . '</textarea>';
    $code .= "<script type=\"text/javascript\">
			config  = {};
			config.entities_latin = false;
			config.language = '" . $language . "';
			config.width = '" . $width . "';
			config.height = '" . $height . "';
			config.filebrowserBrowseUrl 		= '" . URL_ROOT . "asset/ckfinder/ckfinder.html';
			config.filebrowserImageBrowseUrl 	= '" . URL_ROOT . "asset/ckfinder/ckfinder.html';
			filebrowserUploadUrl: '" . URL_ROOT . "asset/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
			filebrowserImageUploadUrl: '" . URL_ROOT . "asset/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	";


    if ($toolbar == 1) {
        //{ name: 'colors', groups: [ 'colors' ] },
        //{ name: 'others', groups: [ 'others' ] }
        //{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        //{ name: 'styles', groups: [ 'styles' ] },
        //{ name: 'insert', groups: [ 'insert' ] },
        //{ name: 'links', groups: [ 'links' ] },
        $code .= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		
    		
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [ 'document', 'doctools' ] },
	
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    	];
    	config.removeButtons = 'Checkbox,Radio,TextField,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Anchor,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,Font,Cut,Undo,Redo,Copy,Scayt,Strike,RemoveFormat,Outdent,Indent,Blockquote,Table,SpecialChar,HorizontalRule,Styles,Format,About';
	";
    } elseif ($toolbar == 2) {
        $code .= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		{ name: 'links', groups: [ 'links' ] },
    		{ name: 'insert', groups: [ 'insert' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [  'document', 'doctools' ] },
    		'/',
    		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'styles', groups: [ 'styles' ] },
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    		{ name: 'colors', groups: [ 'colors' ] },
    		{ name: 'others', groups: [ 'others' ] }
    	];
	   config.removeButtons = 'Checkbox,Radio,TextField,Anchor,Form,Textarea,Select,Button,ImageButton,HiddenField,SelectAll,Replace,Find,Smiley,Iframe,PageBreak,Flash,ShowBlocks,Save,NewPage,Preview,Print,Templates,Underline,Subscript,Superscript,Language,BidiRtl,BidiLtr,CreateDiv,JustifyCenter,JustifyRight,Font';
	";
    } elseif ($toolbar == 3) {
        $code .= "config.toolbarGroups = [
    		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
            { name: 'colors', groups: [ 'colors' ] },
            { name: 'styles', groups: [ 'styles' ] },
    		{ name: 'editing', groups: [ 'find', 'selection', 'spellchecker', 'editing' ] },
    		{ name: 'links', groups: [ 'links' ] },
    		{ name: 'insert', groups: [ 'insert' ] },
    		{ name: 'tools', groups: [ 'tools' ] },
    		{ name: 'document', groups: [  'document', 'doctools' ] },
            { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
    		'/',
    		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi', 'paragraph' ] },
    		{ name: 'about', groups: [ 'about' ] },
    		{ name: 'forms', groups: [ 'forms' ] },
    		{ name: 'others', groups: [ 'others' ] }
    	];
	   config.removeButtons = 'Underline,Subscript,Superscript,Anchor,About';
	";
    }

    $code .= 'CKEDITOR.replace(\'' . $name . '\', config);';
    $code .= '</script>';

    return $code;
}

function testVar($var)
{
    print_r('<pre>');
    print_r($var);
    print_r('</pre>');
}

function image_replace_webp($image, $replace)
{
    return str_replace(['/original/', '.jpg', '.png'], ["/$replace/", '.webp', '.webp'], $image);
}