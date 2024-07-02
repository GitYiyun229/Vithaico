<?php

class  FSInput
{
    function __construct()
    {
    }


    public static function get($varname, $default = null, $type = '', $method = '')
    {
        global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $_REQUEST;

        $value = $default;

        if (isset($_POST[$varname])) {
            $value = $_POST[$varname];
        } else if (isset($_GET[$varname])) {
            $value = $_GET[$varname];
        } else if (isset($_REQUEST[$varname])) {
            $value = $_REQUEST[$varname];
        } else if (isset($_FILES[$varname])) {
            $value = $_FILES[$varname];
        }
        if (!isset($value) && !isset($default))
            return;

        if (!isset($value) && isset($default)) {
            $value = $default;
        }

        switch ($type) {
            case 'txt':
                $value = FSInput::def(trim($value));
                break;
            case 'int':
                $value = FSInput::cint($value);
                break;
            case 'sql':
                $value = FSInput::csql(trim($value));
                break;
            case 'array':
                $value = FSInput::carray($value);
                break;
            default:
                $value = FSInput::cstr(trim($value));
                break;
        }

        if (defined('IS_FRONTEND') && IS_FRONTEND) {
            if ($type != 'array') {
                $value = FSInput::clean($value);
                $value = FSInput::xss_clean($value);
                // $value = addslashes($value);
                $value = str_replace('"', '', $value);
                // $value = htmlentities($value, ENT_QUOTES, "UTF-8");
                // if ($varname == 'id' || $varname == 'cid' || $varname == 'field' || $varname == 'department' || $varname == 'type' || $varname == 'position') {
                // 	$value = "'".$value."'";
                // }
            }           
        } else{
            $value = FSInput::clean2($value);
        }
           
        return $value;
    }

    public static function xss_clean($data)
    {
        // Fix &entity\n;
        $data = str_replace(array('&amp;', '&lt;', '&gt;'), array('&amp;amp;', '&amp;lt;', '&amp;gt;'), $data);
        $data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
        $data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
        $data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

        // Remove any attribute starting with "on" or xmlns
        $data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

        // Remove javascript: and vbscript: protocols
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
        $data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

        // Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
        $data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

        // Remove namespaced elements (we do not need them)
        $data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

        do {
            // Remove really unwanted tags
            $old_data = $data;
            $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
        } while ($old_data !== $data);

        // we are done...
        return $data;
    }

    public static function clean($string = '')
    {
        $string = str_replace("'", '', $string);
        // $string =  str_replace("@", '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace('(', '', $string);
        $string = str_replace(')', '', $string);
        $string = str_replace('UNION', '', $string);
        $string = str_replace('union', '', $string);
        $string = str_replace('select', '', $string);
        $string = str_replace('SELECT', '', $string);
        $string = str_replace('delete', '', $string);
        $string = str_replace('DELETE', '', $string);
        $string = str_replace('truncate', '', $string);
        $string = str_replace('TRUNCATE', '', $string);
        $string = str_replace('CONCAT', '', $string);
        $string = str_replace('concat', '', $string);
        $string = str_replace('from', '', $string);
        $string = str_replace('FROM', '', $string);
        $string =  str_replace('DROP', '', $string);
        $string =  str_replace('DATABASE', '', $string);
        $string =  str_replace('drop', '', $string);
        $string =  str_replace('database', '', $string);
        $string = str_replace('*', '', $string);
        $string = str_replace('`', '', $string);
        $string = str_replace('=', '', $string);
//        $string =  str_replace('--', '', $string);
        $string = str_replace('--+', '', $string);
        $string = str_replace('--+-', '', $string);
        $string = str_replace(';%00', '', $string);
        $string = str_replace('`', '', $string);
        $string = str_replace('+', '', $string);
        $string = str_replace('|', '', $string);
        $string = str_replace('~', '', $string);
        $string = str_replace('!', '', $string);
        $string = str_replace('^', '', $string);
        $string = str_replace('"', '', $string);
        $string = str_replace('<', '', $string);
        $string = str_replace('>', '', $string);
        $string = str_replace('ScRiPt', '', $string);
        $string = str_replace("onclick", "", $string);
        $string = str_replace("onmouseover", "", $string);
        $string = str_replace("prompt(", "", $string);
        $string = str_replace("eval(", "", $string);
        $string = str_replace("<script", "", $string);
        $string = str_replace("alert(", "", $string);
        $string = str_replace("[]", "", $string);
        $string = str_replace("'", "", $string);
        $string = str_replace('<', '', $string);
        $string = str_replace('>', '', $string);
        $string = str_replace('*', '', $string);
        return $string;
    }

    public static function get2($varname, $default = null, $type = '', $method = '')
    {
        global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $_REQUEST;

        $value = $default;

        if (isset($_POST[$varname])) {
            $value = $_POST[$varname];
        } else if (isset($_GET[$varname])) {
            $value = $_GET[$varname];
        } else if (isset($_REQUEST[$varname])) {
            $value = $_REQUEST[$varname];
        } else if (isset($_FILES[$varname])) {
            $value = $_FILES[$varname];
        }
        if (!isset($value) && !isset($default))
            return;

        if (!isset($value) && isset($default)) {
            $value = $default;
        }
//		if(empty($value)){
//			if(isset($default)){
//				$value = $default;
//			}
//		}
        switch ($type) {
            case 'txt':
                $value = FSInput::def(trim($value));
                break;
            case 'int':
                $value = FSInput::cint($value);
                break;
            case 'sql':
                $value = FSInput::csql(trim($value));
                break;
            case 'array':
                $value = FSInput::carray($value);
                break;
            default:
                $value = FSInput::cstr(trim($value));
                break;
        }

        $value = FSInput::clean($value);
        return $value;
    }

    public static function get3($varname, $default = null, $type = '', $method = '')
    {
        global $HTTP_POST_VARS, $HTTP_GET_VARS, $HTTP_COOKIE_VARS, $_REQUEST;

        $value = $default;

        if (isset($_POST[$varname])) {
            $value = $_POST[$varname];
        } else if (isset($_GET[$varname])) {
            $value = $_GET[$varname];
        } else if (isset($_REQUEST[$varname])) {
            $value = $_REQUEST[$varname];
        } else if (isset($_FILES[$varname])) {
            $value = $_FILES[$varname];
        }
        if (!isset($value) && !isset($default))
            return;

        if (!isset($value) && isset($default)) {
            $value = $default;
        }
//		if(empty($value)){
//			if(isset($default)){
//				$value = $default;
//			}
//		}
        switch ($type) {
            case 'txt':
                $value = FSInput::def(trim($value));
                break;
            case 'int':
                $value = FSInput::cint($value);
                break;
            case 'sql':
                $value = FSInput::csql(trim($value));
                break;
            case 'array':
                $value = FSInput::carray($value);
                break;
            default:
                $value = FSInput::cstr(trim($value));
                break;
        }
        return $value;
    }


    public static function clean2($string = '')
    {
        $string = str_replace('UNION', '', $string);
        $string = str_replace('union', '', $string);

        $string = str_replace('CONCAT', '', $string);
        $string = str_replace('concat', '', $string);
//        $string =  str_replace('count', '', $string);
        $string = str_replace('COUNT', '', $string);
        $string = str_replace('from', '', $string);
        $string = str_replace('FROM', '', $string);
        $string = str_replace('`', '', $string);
        $string = str_replace('--', '', $string);
        $string = str_replace('--+', '', $string);
        $string = str_replace('--+-', '', $string);
        $string = str_replace(';%00', '', $string);
        $string =  str_replace('DROP', '', $string);
        $string =  str_replace('DATABASE', '', $string);
        $string =  str_replace('drop', '', $string);
        $string =  str_replace('database', '', $string);
        $string = str_replace('ScRiPt', '', $string);
        $string = str_replace("onclick", "", $string);
        $string = str_replace("onmouseover", "", $string);
        $string = str_replace("prompt(", "", $string);
        $string = str_replace("eval(", "", $string);
        $string = str_replace("<script", "", $string);
        $string = str_replace("alert(", "", $string);
        $string = str_replace("[]", "", $string);
        $string = str_replace('<', '', $string);
        return $string; // Removes special chars.
    }

    public static function encode($strval)
    {
        if (strlen($strval)) {
            $strval = htmlentities($_POST[$strval], ENT_QUOTES);
        }
        return $strval;
    }

    public static function decode($strval)
    {
        if (strlen($strval)) {
            $strval = html_entity_decode($strval, ENT_QUOTES);
        }
        return $strval;
    }

    public static function cstr($strval)
    {
//		if ( get_magic_quotes_gpc() == 0 ) $strval = addslashes($strval);
        if (@get_magic_quotes_gpc() == 0) $strval = stripslashes($strval);

        if (strlen($strval))
            $strval = htmlspecialchars($strval);
        return $strval;
    }


    public static function def($strval)
    {
        if (get_magic_quotes_gpc() == 0) $strval = addslashes($strval);

        $strval = htmlspecialchars($strval);

        return $strval;
    }


    public static function csql($strval)
    {
        if (get_magic_quotes_gpc() == 0) $strval = addslashes($strval);

        return $strval;
    }


    public static function cint($intval)
    {
        if (!isset($intval)) {
            return null;
        }
        if (empty($intval)) {
            return $intval;
        }
        $intval = (int)$intval;

        return $intval;
    }

    public static function carray($arrayval)
    {
        return (array)$arrayval;
    }

}

?>