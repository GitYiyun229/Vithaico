<?php 
class HomeModelsHome extends FSModels{
    public function __construct(){
        parent::__construct();
    }
    /**
     * Lay tat ca cac menu noi bat
     * 
     * @return Object $list
     */ 
    public function get_menu_modules(){
        global $db;
		$sql = $db->query(' SELECT id, name, image, link  ,module,view,icon,code_color
                            FROM fs_menus_admin 
                            WHERE published = 1 AND parent_id = 0
                            ORDER BY ordering');
		$list = $db->getObjectList();
        return $list;
    }
    /**
     * Lay ten website
     * 
     * @return String
     */ 
    public function get_site_name(){
        global $db;
		$sql = $db->query(' SELECT name, title, value  
                            FROM fs_config 
                            WHERE id = 1 
                            LIMIT 1');
		$site = $db->getObject();
        if($site)
            return $site->value;
        else
            return '';
    }
}