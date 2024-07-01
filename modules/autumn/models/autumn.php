<?php
/**
 * @author vangiangfly
 * @category Model
 */

//class AutumnModelsAutumn
class AutumnModelsAutumn extends FSModels

{
    function __construct()
    {

    }

    function get_data_()
    {

        $query = " SELECT *
						FROM fs_points   
						WHERE published = 1 ";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_slide()
    {

        $query = " SELECT *
						FROM fs_banners   
						WHERE published = 1 AND category_id = 45";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_cat()
    {

        $query = " SELECT id, name, alias
						FROM fs_products_categories   
						WHERE published = 1 AND is_autumn = 1";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_cat_renew()
    {

        $query = " SELECT id, name, alias
						FROM fs_products_categories   
						WHERE published = 1 AND is_renew = 1";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_new()
    {

        $query = " SELECT id, title, alias, image, summary,created_time,category_alias
						FROM fs_news   
						WHERE published = 1 AND is_hot = 1 ORDER BY created_time DESC LIMIT 3";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_prd($cid)
    {
        $query = " SELECT id, name, alias, category_id, image, price_autumn,category_alias,price
						FROM fs_products  
						WHERE published = 1 AND is_autumn = 1 AND category_published AND category_id_wrapper LIKE '%," . $cid . ",%' ORDER BY id DESC";
//        echo $query;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_prd_renew($cid)
    {
        $query = " SELECT id, name, alias, category_id, image, price_autumn,category_alias,price
						FROM fs_products  
						WHERE published = 1 AND is_renew = 1 AND category_published AND category_id_wrapper LIKE '%," . $cid . ",%' ORDER BY id DESC";
//        echo $query;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_item($id)
    {
        $query = " SELECT id, name, alias, category_id, image, price_autumn,price_autumn_2,price_autumn_3,price_autumn_4,category_alias,price,price_old,summary
						FROM fs_products  
						WHERE id=" . $id;
//        echo $query;
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_banner()
    {

        $query = " SELECT *
						FROM fs_banners   
						WHERE published = 1 AND category_id = 51";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_banner_mb()
    {

        $query = " SELECT *
						FROM fs_banners   
						WHERE published = 1 AND category_id = 52";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObject();
        return $result;
    }

    function get_autumn()
    {
        $query = " SELECT id,name,price,code
						FROM fs_autumn   
						WHERE published = 1 ORDER BY ordering ASC, id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function get_combo()
    {
        $query = " SELECT id,name,price
						FROM fs_combo   
						WHERE published = 1 ORDER BY ordering ASC, id ASC";
        global $db;
        $sql = $db->query($query);
        $result = $db->getObjectList();
        return $result;
    }

    function set_query_body1($keyword)
    {
        $where = ' AND name LIKE \'%' . $keyword . '%\' ';
        $query = " FROM fs_products 
						  WHERE published = 1 AND is_autumn = 1 
						  	" . $where .
            " ORDER BY  id DESC
						 ";
        return $query;
    }
    function set_query_body2($keyword)
    {
        $where = ' AND name LIKE \'%' . $keyword . '%\' ';
        $query = " FROM fs_products 
						  WHERE published = 1 AND is_renew = 1 
						  	" . $where .
            " ORDER BY  id DESC
						 ";
        return $query;
    }
    function get_list($query_body)
    {
        if (!$query_body)
            return;
        $this->page = FSInput::get('page');
        $query_select = 'SELECT id,name,alias,category_id,category_alias,image,price_autumn ,price';
        $query = $query_select;
        $query .= $query_body;
//        echo $query;
        global $db;
        $db->query($query);
//			$db->query_limit ( $query, $this->limit, $this->page );
        $result = $db->getObjectList();
        return $result;
    }



    function autumn_save()
    {
        if (!isset($_SESSION['autumn']))
            return false;
        $autum = $this->get_record('published = 1 and id=' . $_SESSION['autumn'][2], 'fs_autumn', 'name');
        if ($_SESSION['autumn'][3]) {
            $combo = $this->get_record('published = 1 and id=' . $_SESSION['autumn'][3], 'fs_combo', 'name');
        }
        $id_prd = FSInput::get('id_prd');
        $price = FSInput::get('price');
        $price_old = FSInput::get('price_old');
        $id_sub = FSInput::get('id_sub');
        $prd_sub = $this->get_record('published = 1 and id=' . $id_sub, 'fs_products_sub', '*');
        $session_id = session_id();

        $row = array();
        $row['session_id'] = $session_id;
        $row['products_id'] = $id_prd;
        $row['product_id_old'] = $_SESSION['autumn'][0];
        $row['price_cu'] = $_SESSION['autumn'][1];
        $row['autumn_id'] = $_SESSION['autumn'][2];
        $row['autumn_name'] = $autum->name;
        if ($_SESSION['autumn'][3]) {
            $row['combo_id'] = $_SESSION['autumn'][3];
            $row['combo_name'] = $combo->name;
        }
        $row['is_temporary'] = 0;
        $row['price'] = $price;
        $row['price_old'] = $price_old;
        $row['total_after_discount'] = $price - $_SESSION['autumn'][1];
//        $row['color_id'] = $prd_sub->color_id;
//        $row['color_name'] = $prd_sub->color_name;
//        $row['species_id'] = $prd_sub->species_id;
//        $row['species_name'] = $prd_sub->species_name;
//        $row['origin_id'] = $prd_sub->origin_id;
//        $row['origin_name'] = $prd_sub->origin_name;

        $row['sender_name'] = FSInput::get('sender_name');
        $row['sender_sex'] = FSInput::get('sex');
        $row['sender_telephone'] = FSInput::get('sender_telephone');
//        $row['sender_email'] = FSInput::get('sender_email');
//        $row['sender_city'] = FSInput::get('sender_city');
//        $row['sender_district'] = FSInput::get('sender_district');
//        $row['sender_address'] = FSInput::get('sender_address');
//        $row['sender_comments'] = FSInput::get('sender_note');
        $row['created_time'] = date("Y-m-d H:i:s");
        $row['edited_time'] = date("Y-m-d H:i:s");


//        var_dump($row);
//        die;
        $id = $this->_add($row, 'fs_order_autumn');
        // update

        if ($id) {
//            unset($_SESSION['autumn']);
        }
        return $id;
    }

    function save_comment()
    {
//        $value = FSInput::get('value');
        $text = FSInput::get('full_rate');
        $name = FSInput::get('name_rate');
        $email = FSInput::get('email_rate');
        $phone = FSInput::get('phone_rate');
//        $record_id = FSInput::get('record_id', 0, 'int');
        $parent_id = FSInput::get('parent_id', 0, 'int');
        if (!$name || !$email || !$text)
            return false;

        $time = date('Y-m-d H:i:s');
        $published = 0;

        $sql = " INSERT INTO fs_autumn_comments
						(name,email,comment,phone,parent_id,published,created_time,edited_time)
						VALUES('$name','$email','$text','$phone','$parent_id','$published','$time','$time')
						";
//        echo $sql;die;
        global $db;
//			$db->query($sql);
        $id = $db->insert($sql);

        // var_dump($id); die();

        return $id;
    }

    function get_comments()
    {
        global $db;

        $query = " SELECT name,created_time,id,email,comment,parent_id,level
						FROM fs_autumn_comments
						WHERE  published = 1
						ORDER BY  created_time  DESC 
						";
        $db->query($query);
        $result = $db->getObjectList();

        $tree = FSFactory::getClass('tree', 'tree/');
        $list = $tree->indentRows2($result);
        return $list;
    }
    function getImages($record_id)
    {
        if (!$record_id)
            return;
        $limit = 10;
        $fs_table = FSFactory::getClass('fstable');
        $query = " SELECT id,image, record_id,title,alt,color_id
						  FROM " . $fs_table->getTable('fs_products_images') . "
						  WHERE record_id =  $record_id
						     
						 ";
        global $db;
        $result = $db->getObjectList($query);
        return $result;
    }
}

?>