<?php

class ContactModelsContact extends FSModels
{

    function __construct()
    {
        $fstable = FSFactory::getClass('fstable');
        $this->table_name = $fstable->_('fs_contact', 1);
        $this->table_center = $fstable->_('fs_training', 1);
        //        $this->table_vote = $fstable->_('fs_vote');
        $this->table_add = $fstable->_('fs_address', 1);
        //        $this->table_parts = $fstable->_('fs_contact_parts');
    }

    function get_address_current()
    {
        $add_id = FSInput::get('id');
        $query = "select * from fs_address order by ordering";
        global $db;
        $sql = $db->query($query);
        $object = $db->getObjectList();
        return $object;
    }

    function save()
    {
        $email = FSInput::get('contact_email');
        $fullname = FSInput::get('contact_name');
        $phone = FSInput::get('contact_phone');
        //        $type_id = FSInput::get('contact_group');
        //        $title = FSInput::get('contact_title');
        //        $parts = FSInput::get('contact_parts');
        //$website = FSInput::get('website');
        //$subject = FSInput::get('contact_subject');
        $content = htmlspecialchars_decode(FSInput::get('message'));
        $time = date("Y-m-d H:i:s");
        $published = 0;

        $sql = " INSERT INTO 
			    " . $this->table_name . " (`email`,fullname,telephone,content,edited_time,created_time,published)
				VALUES ('$email','$fullname','$phone','$content','$time','$time','$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        // dd($sql);
        // die;
        return $id;
    }

    function get_address_list()
    {
        $query = ' select * from ' . $this->table_add . ' where published = 1 ORDER BY ordering ASC';
        global $db;
        $sql = $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }
    function get_address_list2($id)
    {
        $query = ' select * from ' . $this->table_add . ' where published = 1 AND city_id = ' . $id . ' ORDER BY ordering ASC';
        global $db;
        $sql = $db->query($query);
        $list = $db->getObjectList();
        return $list;
    }

    function get_training_center()
    {
        $query = "SELECT id,name,address,map
                  FROM $this->table_center
                  WHERE published = 1 ORDER BY ordering asc ";
        global $db;
        $db->query($query);
        return $db->getObjectList();
    }

    function get_city()
    {
        $query = "SELECT id,name
                  FROM fs_cities 
                  WHERE published = 1 ORDER BY ordering ";
        global $db;
        $db->query($query);
        return $db->getObjectList();
    }
}