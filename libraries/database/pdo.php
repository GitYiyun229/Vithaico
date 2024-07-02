<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

class FS_PDO extends PDO
{

    var $pdo;
    var $query_id;
    var $record;
    var $db;
    var $port;
    var $query_string = '';
   

    function __construct()
    {
        global $db_info;
        $this->db = $db_info;

        if (empty($db_info['dbPort']))
            $this->port = 3306;
        else
            $this->port = $db_info['dbPort'];
        $this->connect();

        if (WRITE_LOG_MYSQL) {
            $this->log_query_start();
        }
    }


    function connect()
    {
        global $db_info;

        try {
            $this->pdo = new PDO('mysql:host=' . $db_info['dbHost'] . ';dbname=' . $db_info['dbName'] . ';charset=utf8', $db_info['dbUser'], $db_info['dbPass'], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES UTF8');
            $this->pdo->exec("SET CHARACTER SET utf8");      // Sets encoding UTF-8
        } catch (PDOException $ex) {
            die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
        }

        // @mysql_connect($db_info['dbHost'].":".$this->port,$db_info['dbUser'],$db_info['dbPass']);
        if ($this->pdo === false)
            $this->sql_error("Connection Error");
    }

    function close()
    {
        return $this->pdo = null;
    }

    function query($query_string)
    {

        if (!$query_string)
            return;
        $this->query_string = $query_string;
        return $this;

    }

    function query_limit($query_string, $limit, $page = 0)
    {
        if (!$page)
            $page = 1;
        if ($page < 0)
            $page = 1;
        $start = ($page - 1) * $limit;

        $this->query_string = $query_string . " LIMIT $start,$limit ";
        return $this;
    }

    function query_limit_export($query_string, $start, $end)
    {
        $start = $start;
        $this->query_string = $query_string . " LIMIT $start,$end ";
        return $this;
    }

    function escape_string($string)
    {
        if (!$string)
            return;

        $string = $this->pdo->quote($string);
        $string = substr($string, 1, -1);
        return $string;
    }

    function getObjectList($query_string = -1, $query_cache = false)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $mKey = '';

        if (USE_MEMCACHE && $query_cache) {
            $mKey = md5(USE_MEMCACHE_PREFIX . $query_string);
            global $memcache;
            $list = $memcache->get($mKey);

            // if ($_SERVER['REMOTE_ADDR'] == '117.6.78.194') {
            //     print_r($list);
            // }

            if ($list)
                goto data_binded;
        }

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $list = $sth->fetchAll(PDO::FETCH_OBJ);
        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        if (USE_MEMCACHE && $query_cache)
            $memcache->set($mKey, $list, 0, USE_MEMCACHE_TIME);

        data_binded:
        return $list;
    }

    function resultArray($query_string = -1)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $list = $sth->fetchAll();

        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        return $list;
    }

    function getObjectListByKey($key = 'id', $query_string = -1)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $list = $sth->fetchAll(PDO::FETCH_OBJ);
        $data = array();
        foreach ($list as $item) {
            $data[$item->$key] = $item;
        }

        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        return $data;
    }

    function getObject($query_string = -1, $query_cache = false)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $mKey = '';

        if (USE_MEMCACHE && $query_cache) {
            $mKey = md5(USE_MEMCACHE_PREFIX . $query_string);
            global $memcache;
            $row = $memcache->get($mKey);
            if ($row)
                goto data_binded;
        }

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $row = $sth->fetchObject();

        if (USE_MEMCACHE && $query_cache)
            $memcache->set($mKey, $row, 0, USE_MEMCACHE_TIME);

        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        data_binded:
        return $row;
    }

    function getResult($query_string = -1, $query_cache = false)
    {

        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;
        $mKey = '';
        if (USE_MEMCACHE && $query_cache) {
            $mKey = md5(USE_MEMCACHE_PREFIX . $query_string);
            global $memcache;
            $result = $memcache->get($mKey);
            if ($result)
                goto data_binded;
        }

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $result = $sth->fetchColumn(0);
        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        if (USE_MEMCACHE && $query_cache)
            $memcache->set($mKey, $result, 0, USE_MEMCACHE_TIME);

        data_binded:
        return $result;
    }

    function getTotal($query_string = -1, $query_cache = false)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $mKey = '';
        if (USE_MEMCACHE && $query_cache) {
            $mKey = md5(USE_MEMCACHE_PREFIX . $query_string);
            global $memcache;
            $result = $memcache->get($mKey);
            if ($result)
                goto data_binded;
        }

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $result = $sth->rowCount();
        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        data_binded:
        return $result;
    }

    function affected_rows($query_string = -1)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();

        $result = $sth->rowCount();
        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        return $result;
    }

    function insert($query_string = -1)
    {
        if (WRITE_LOG_MYSQL) {
            $starttime = microtime(true);
        }

        $query_string = $query_string && $query_string != -1 ? $query_string : $this->query_string;

        $sth = $this->pdo->prepare($query_string);
        $sth->execute();
        $result = $this->pdo->lastInsertId();

        if ($query_string != -1 && WRITE_LOG_MYSQL) {
            $this->log_query($starttime, $query_string);
        }

        return $result;
    }

    function sql_error($message, $query = "")
    {
        $msgbox_title = $message;
        echo $msgbox_title;

        if (isset($this->pdo)) {
            echo $query;
            echo "<hr/>";
            print_r($this->pdo->errorInfo());
        } else {
            global $db;
            echo $query;
            echo "<hr/>";
            print_r($db->pdo->errorInfo());
        }
        die;
    }

    function getTablename($table_name)
    {
        $lang = $this->hasLang();
        if (!$lang)
            return $table_name;
        else {
            if ($this->checkExistTable($table_name . "_" . $lang))
                return $table_name . "_" . $lang;
            else
                return $table_name;
        }
    }

    function hasLang()
    {
        if (!isset($_SESSION['lang']))
            return false;
        else {
            $sql = " SELECT id,`default` 
    				FROM fs_languages 
    				WHERE lang_sort = '" . $_SESSION['lang'] . "'	";
            $rs = $this->getObject($sql);

            if (!$rs) {
                return false;
            } else {
                if ($rs->default == 1)
                    return false;
            }
        }
        return $_SESSION['lang'];
    }

    function checkExistTable($tablename)
    {
        global $db_info, $db;
        $sql = "SELECT  TABLE_NAME  FROM INFORMATION_SCHEMA.TABLES WHERE 
				TABLE_TYPE='BASE TABLE' AND TABLE_NAME='$tablename'
				AND TABLE_SCHEMA = '" . $db_info['dbName'] . "'";
        $db->query($sql);
        $rs = $db->getResult();
        if ($rs)
            return true;
        return false;
    }

    function log_query($starttime, $query_string)
    {
        $endtime = microtime(true);
        $duration = $endtime - $starttime;
        $text_log = "\n" . $query_string . "\n";
        $text_log .= "\n" . "time:::" . $duration . "\n";
        $text_log .= "\n===========\n";
        $this->log_file($text_log);
    }

    function log_file($content)
    {
        $date = @date('Y-m-d');
        $fn = "log_mysql/log_" . $date . ".txt";
        $fp = fopen($fn, "a") or die("Error opening file in write mode!");
        fputs($fp, $content);
        fclose($fp) or die("Error closing file!");
    }

    function log_query_start()
    {
        $time = date('Y-m-d H:i:s');
        $content = '\n================REMOTE: ' . $_SERVER['REMOTE_ADDR'] . '  (' . $time . ')===================\n';
        $content .= '\n================URL : ' . $_SERVER["REQUEST_URI"] . '===================\n';
        $content .= '\n================' . time() . '===================\n';
        $this->log_file($content);
    }
}
