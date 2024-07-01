<?php

class PointsModelsSearch_point extends FSModels
{
    function __construct() {

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
}
?>