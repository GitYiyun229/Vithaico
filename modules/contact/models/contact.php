<?php 
	class ContactModelsContact{
			function __construct()
			{
			}
		function get_data(){
			$fs_table = FSFactory::getClass('fstable');
			$query = "select * from ".$fs_table -> getTable('fs_address')." where published = 1 ORDER BY ordering ASC";
			global $db;
			$sql = $db->query($query);
			$list = $db->getObjectList();
			return $list;
		}
        function get_city(){
            $query = "select * from fs_cities where published = 1 ORDER BY ordering ASC";
            global $db;
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }
        function get_city_ajax($id){
            $where = "";
            if ($id !=0) {
               $where =" AND city = ".$id." ";
            }
            $query = "select * from fs_address where published = 1 $where ORDER BY ordering ASC";
            global $db;
            $sql = $db->query($query);
            $list = $db->getObjectList();
            return $list;
        }

		     function save()
    {
        $email = FSInput::get('contact_email');
        $fullname = FSInput::get('contact_name');
        $address = FSInput::get('contact_address');
        $telephone = FSInput::get('contact_phone');
        $fax = FSInput::get('contact_fax');
        $subject = FSInput::get('contact_subject');
        $content = htmlspecialchars_decode(FSInput::get('message'));
        $time = date("Y-m-d H:i:s");
        $published = 0;
        $sql = "INSERT INTO 
                fs_contact (`email`,fullname,address,telephone,fax,subject,content,edited_time,created_time,published)
                VALUES ('$email','$fullname','$address','$telephone','$fax','$subject','$content','$time','$time','$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
	}
?>