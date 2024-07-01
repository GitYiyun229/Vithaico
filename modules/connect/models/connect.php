<?php
/**
 * @author vangiangfly
 * @category Model
 */ 
class ConnectModelsConnect
{
    function save()
    {

        $fullname = FSInput::get('contact_name');
        $address = FSInput::get('contact_address');
        $content = htmlspecialchars_decode(FSInput::get('message'));
        $time = date("Y-m-d H:i:s");
        $published = 0;
        $sql = "INSERT INTO 
                fs_contact (fullname,address,content,edited_time,created_time,published)
                VALUES ('$fullname','$address','$content','$time','$time','$published')";
        global $db;
        $db->query($sql);
        $id = $db->insert();
        return $id;
    }
}
?>