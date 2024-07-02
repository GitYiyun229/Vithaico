<?php
/**
 * @author vangiangfly
 * @category Model
 */ 
class PointsModelsPoints
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
}
?>