<?php

class NewsModelsNews extends FSModels
{
    function __construct()
    {
        $limit = 10;
        $page = FSInput::get('page');
        $this->limit = $limit;
        $this->page = $page;
        // $fstable = FSFactory::getClass('fstable');
        $this->table_name = FSTable::_('fs_news', 1);
        $this->table_category = FSTable::_('fs_news_categories', 1);
        $this->table_comment = FSTable::_('fs_news_comments', 1);
        $this->table_banner = FSTable::_('fs_banners', 1);
    }

    function get_category_by_id($category_id)
    {
        if (!$category_id)
            return "";
        $query = " SELECT id,name,name_display,is_comment, alias, display_tags,display_title,display_sharing,display_comment,
                        display_category,display_created_time,display_related,updated_time,display_summary,products_related
						FROM " . $this->table_category . "  
						WHERE id = $category_id ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function getNews()
    {
        $id = FSInput::get2('id', 0, 'int');
        if ($id) {
            $where = " id = '$id' ";
        } else {
            $code = FSInput::get('code');
            if (!$code)
                die('Not exist this url');
            $where = " alias = '$code' ";
        }
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT *
						FROM " . $fs_table->getTable('fs_news', 1) . " 
						WHERE published = 1 and 
						" . $where . " ";
        //print_r($query) ;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function update_hits($news_id)
    {
        if (USE_MEMCACHE) {
            $fsmemcache = FSFactory::getClass('fsmemcache');
            $mem_key = 'array_hits';

            $data_in_memcache = $fsmemcache->get($mem_key);
            if (!isset($data_in_memcache))
                $data_in_memcache = array();
            if (isset($data_in_memcache[$news_id])) {
                $data_in_memcache[$news_id]++;
            } else {
                $data_in_memcache[$news_id] = 1;
            }
            $fsmemcache->set($mem_key, $data_in_memcache, 10000);
        } else {
            if (!$news_id)
                return;

            // count
            global $db, $econfig;
            $sql = " UPDATE fs_news 
						SET hits = hits + 1 
						WHERE  id = '$news_id' 
					 ";
            $db->query($sql);
            $rows = $db->affected_rows();
            return $rows;
        }
    }

    function get_list()
    {
        global $db;
        $query = " SELECT id, title, created_time, image, summary, alias
						FROM " . $this->table_name . "
						WHERE published = 1
						ORDER BY created_time DESC LIMIT 4
						";
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_list_categories($id)
    {
        global $db;
        $query = "SELECT id, name, alias
                  FROM " . $this->table_category . "
                  WHERE published = 1 and parent_id = $id
                  ORDER BY ordering asc, id ASC";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        // print_r($result);die;
        return $result;
    }

    function get_list_related($id, $cid)
    {
        global $db;
        $query = ' SELECT id,title,alias,image,summary,created_time,category_name
						FROM ' . FSTable::_('fs_news', 1) . '
						WHERE published = 1 AND id != ' . $id . ' AND category_id_wrapper LIKE "%,' . $cid . ',%"
						ORDER BY ordering DESC, id DESC LIMIT 4';
        $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_list_hot()
    {
        global $db;
        $query = "SELECT id, title, alias, image, summary, category_name, created_time
                  FROM " . $this->table_name . "
                  WHERE published = 1 AND is_hot = 1
                  ORDER BY created_time DESC, ordering ASC LIMIT 5";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }
    function get_list_promotion()
    {
        global $db;
        $query = "SELECT id, title, alias, image, summary, category_name, created_time
                  FROM " . $this->table_name . "
                  WHERE published = 1 AND is_promotion = 1
                  ORDER BY created_time DESC, ordering ASC LIMIT 5";
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function getNewerNewsList($cid, $created_time)
    {
        global $db;
        $limit = 10;
        $id = FSInput::get('id');
        $query = " SELECT id,title,created_time, category_id 
						FROM " . $this->table_name . "
						WHERE id <> $id
							AND category_id = $cid
							AND published = 1
							AND ( created_time > '$created_time' OR id > $id)
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function getOlderNewsList($cid, $created_time)
    {
        global $db;
        $limit = 10;
        $id = FSInput::get('id');
        $query = " SELECT id,title ,created_time,category_id
						FROM " . $this->table_name . "
						WHERE id <> $id
							AND category_id = $cid
							AND published = 1
							AND ( created_time < '$created_time' OR id < $id)
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function getRelateNewsList($cid)
    {
        if (!$cid)
            die;
        $code = FSInput::get('code');
        $where = '';
        if ($code) {
            $where .= " AND alias <> '$code' ";
        } else {
            $id = FSInput::get('id', 0, 'int');
            if (!$id)
                die('Not exist this url');
            $where .= " AND id <> '$id' ";
        }

        global $db;
        $limit = 5;
        $fs_table = FSFactory::getClass('fstable');

        $query = " SELECT id,title,alias, category_id,updated_time,image
						FROM " . $fs_table->getTable('fs_news') . "
						WHERE alias <> '" . $code . "'
							AND category_id = $cid
							AND published = 1
							" . $where . "
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    /*
         * get array [id] = alias
         */
    function get_content_category_ids($str_ids)
    {
        if (!$str_ids)
            return;
        $fs_table = FSFactory::getClass('fstable');

        // search for category

        $query = " SELECT id,alias
                          FROM " . $fs_table->getTable('fs_news_categories') . "
                          WHERE id IN (" . $str_ids . ")
                         ";

        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        $array_alias = array();
        if ($result)
            foreach ($result as $item) {
                $array_alias[$item->id] = $item->alias;
            }
        return $array_alias;
    }

    function get_comments($news_id)
    {
        global $db;
        if (!$news_id)
            return;
        //			$limit = 5;
        //			$id = FSInput::get('id');
        $query = " SELECT name,created_time,id,email,comment,parent_id,level,news_id
						FROM fs_news_comments
						WHERE news_id = $news_id
							AND published = 1
						ORDER BY  created_time  DESC
						";
        $db->query($query);
        $result = $db->getObjectList();
        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }

    function save_comment()
    {
        $name = FSInput::get('name');
        $email = FSInput::get('email');
        $text = FSInput::get('text');
        $record_id = FSInput::get('record_id', 0, 'int');
        $parent_id = FSInput::get('parent_id', 0, 'int');
        if (!$name || !$email || !$text || !$record_id)
            return false;

        $time = date('Y-m-d H:i:s');
        $published = 0;

        $sql = " INSERT INTO fs_news_comments
						(`name`,email,`comment`,news_id,parent_id,published,created_time,edited_time)
						VALUES('$name','$email','$text','$record_id','$parent_id','$published','$time','$time')
						";
        global $db;
        //$db->query($sql);
        $id = $db->insert($sql);
        if ($id)
            $this->recalculate_comment($record_id, $time);
        return $id;
    }

    function recalculate_comment($record_id, $time)
    {
        $sql = " UPDATE  fs_news
						SET comments_total = comments_total + 1,
						    comments_unread = comments_unread + 1,
						    comments_last_time = '" . $time . "' 
						    WHERE id = " . $record_id . "
						";
        global $db;
        //$db->query($sql);
        $rows = $db->affected_rows($sql);
    }

    function save_rating()
    {
        $id = FSInput::get('id', 0, 'int');
        $rate = FSInput::get('rate', 0, 'int');

        $sql = " UPDATE  fs_news
						SET rating_count = rating_count + 1,
						    rating_sum = rating_sum + " . $rate . "
						    WHERE id = " . $id . "
						";
        global $db;
        //$db->query($sql);
        $rows = $db->affected_rows($sql);

        // save cookies
        if ($rows) {
            $cookie_rating = isset($_COOKIE['rating_news']) ? $_COOKIE['rating_news'] : '';
            $cookie_rating .= $id . ',';
            setcookie("rating_news", $cookie_rating, time() + 60); //60s
        }
        return $rows;
    }

    function get_comment_by_id($comment_id)
    {
        if (!$comment_id)
            return false;
        $query = " SELECT * 
						FROM fs_contents_comments
						WHERE id =  $comment_id
							AND published = 1
						";
        global $db;
        $db->query($query);
        return $result = $db->getObject();
    }

    function get_relate_by_tags($tags, $exclude = '', $category_id)
    {
        if (!$tags)
            return;
        $arr_tags = explode(',', $tags);
        $where = ' WHERE published = 1';
        $where .= ' AND  category_id_wrapper like "%,' . $category_id . ',%" ';

        if ($exclude)
            $where .= ' AND id <> ' . $exclude . ' ';
        // $total_tags = count($arr_tags);
        // if($total_tags){
        // 	$where .= ' AND (';
        // 	$j = 0;
        // 	for($i = 0; $i < $total_tags; $i ++){
        // 		$item = trim($arr_tags[$i]);
        // 		if($item){
        // 			if($j > 0)
        // 				$where .= ' OR ';
        // 			$where .= " title like '%".addslashes($item)."%' ";
        // 			$j ++;
        // 		}
        // 	}
        // 	$where .= ' )';
        // }

        global $db;
        $limit = 10;
        $fs_table = FSFactory::getClass('fstable');

        $query = " SELECT id,title,alias, category_id , image, category_alias,summary
						FROM " . $fs_table->getTable('fs_news') . "
							" . $where . "
						ORDER BY  id DESC, ordering DESC
						LIMIT 0,$limit
						";
        $db->query($query);
        $result = $db->getObjectList();

        return $result;
    }

    function get_news_realted($str)
    {
        global $db;
        $sql = " SELECT id,alias,title,image,created_time,hits
                 FROM fs_news WHERE published = 1 and id in (0" . $str . "0) order by ordering desc, created_time desc limit 6
					 ";
        $db->query($sql);
        return $db->getObjectList();
    }

    function save_comment2()
    {
        global $db, $user, $config;
        $comment_guest = $_SESSION['comment_guest'];
        $row = array();
        $row['name'] = $comment_guest["name"];
        $row['email'] = $comment_guest["email"];
        $row['comment'] = $comment_guest["comment"];
        $row['record_id'] = $comment_guest["record_id"];

        if ($comment_guest["comment_id"])
            $row['parent_id'] = $comment_guest["comment_id"];

        $list_comment = $this->get_records('record_id = ' . $row['record_id'], 'fs_news_comments');
        $comment_published = 0;
        foreach ($list_comment as $item) {
            if ($item->published == '1') {
                $comment_published++;
            }
        }
        $data_prod = $this->get_record_by_id($row['record_id'], 'fs_news');
        $row2['comments_total'] = $data_prod->comments_total + 1;
        $row2['comments_published'] = $comment_published;
        $time = date("Y-m-d H:i:s");
        $row2['comments_last_time'] = $time;
        $row['created_time'] = $time;

        $this->_update($row2, $this->table_name, 'id = ' . $row['record_id'] . '', 0);
        $id = $this->_add($row, $this->table_comment);

        return $id;
    }

    function add_point($id, $check, $point)
    {
        global $db;
        if ($check == 0) {
            $point += 1;
            $query = "UPDATE fs_news_comments SET add_point = $point WHERE id = $id ";
        } else if ($check == 1) {
            if ($point != 0)
                $point -= 1;
            $query = "UPDATE fs_news_comments SET add_point = $point WHERE id = $id ";
        }
        return $db->affected_rows($query);
    }

    function get_redirect()
    {
        // $code = FSInput::get('ccode');
        $code = substr($_SERVER['REQUEST_URI'], strlen(URL_ROOT_REDUCE));
        if (!$code)
            return;
        $fs_table = FSFactory::getClass('fstable');
        $where = '';
        $where .= ' record_id <> 0 and ( alias = "' . $code . '" OR old_alias = "' . $code . '" ) ';
        //        $where .= ' AND id = ' . $id;
        global $db;
        $query = "SELECT  * FROM fs_redirect WHERE $where ";
        //        echo $query;die;
        $db->query($query);
        return $db->getObject('', USE_MEMCACHE);
    }

    function get_product_re($id)
    {
        global $db;
        $query = "SELECT  id, alias FROM fs_news WHERE id = " . $id;
        $db->query($query);
        return $db->getObject('', USE_MEMCACHE);
    }

    // function get_redirect()
    // {
    //     $code = FSInput::get('ccode');
    //     if (!$code)
    //         return;
    //     $where = '';
    //     $where .= ' alias = "' . $code . '" OR old_alias = "' . $code . '"';
    //     global $db;
    //     $query = "SELECT  * FROM fs_redirect WHERE $where ";
    //     $db->query($query);
    //     return $db->getObject('', USE_MEMCACHE);
    // }

    // function get_product_re($id)
    // {
    //     global $db;
    //     $query = "SELECT id, alias FROM fs_news WHERE id = " . $id;
    //     $db->query($query);
    //     return $db->getObject('', USE_MEMCACHE);
    // }
}
