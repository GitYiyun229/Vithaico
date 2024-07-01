<?php
require_once("../../../../includes/config.php");
require_once('../../../../libraries/database/mysql.php');
$db = new Mysql_DB();
	$id = $_GET['id'];
	$parent_id = $_GET['parent_id'];
	$query = "DELETE FROM fs_menus_admin WHERE id = ".$id;
	$db->query($query);			
	$db->fetch_row();
	if($parent_id==0){
		echo 'parent'.$id;
	}else{
		echo 'child'.$id;
	}
?>