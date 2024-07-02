<?php 
	class ProductsModelsThuonghieu extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 10;
			$this -> view = 'products';
			$this -> table_name = 'fs_products_thuong_hieu';
			parent::__construct();
            $this->img_folder = 'images/' . $this->type . '/logo';
            $this->field_img = 'image';
            $this -> arr_img_paths = array(array('resized',200,100,'resize_image'));
		}

        function setQuery(){

            // ordering
            $ordering = "";
            $where = "  ";
            if(isset($_SESSION[$this -> prefix.'sort_field']))
            {
                $sort_field = $_SESSION[$this -> prefix.'sort_field'];
                $sort_direct = $_SESSION[$this -> prefix.'sort_direct'];
                $sort_direct = $sort_direct?$sort_direct:'asc';
                $ordering = '';
                if($sort_field)
                    $ordering .= " ORDER BY $sort_field $sort_direct, created_time DESC, id DESC ";
            }

            // estore
            if(isset($_SESSION[$this -> prefix.'filter0'])){
                $filter = $_SESSION[$this -> prefix.'filter0'];
                if($filter == 2){
                    $where .= ' AND a.published = 0 ';
                }else if($filter == 0){
                    $where .= '';
                } else{
                    $where .= ' AND a.published = '.$filter.' ';
                }
            }

            if(!$ordering)
                $ordering .= " ORDER BY created_time DESC , id DESC ";


            if(isset($_SESSION[$this -> prefix.'keysearch'] ))
            {
                if($_SESSION[$this -> prefix.'keysearch'] )
                {
                    $keysearch = $_SESSION[$this -> prefix.'keysearch'];
                    $where .= " AND a.name LIKE '%".$keysearch."%' ";
                }
            }

            $query = " SELECT a.*
						  FROM 
						  	".$this -> table_name." AS a
						  	WHERE 1=1 ".
                $where.
                $ordering. " ";
            //echo $query;
            return $query;
        }
//
//        function save($row = array(), $use_mysql_real_escape_string = 1){
//            $title = FSInput::get('title');
//            if(!$title)
//                return false;
//            $id = FSInput::get('id',0,'int');
//
//            $time = date('Y-m-d H:i:s');
//            $row['published'] = 1;
//
//            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
//            if(!$user_id)
//                return false;
//
//            $user = $this->get_record_by_id($user_id,'fs_users','username');
//            if($id){
//                $row['created_time'] = $time;
//            }else{
//                $row['updated_time'] = $time;
//                $row['start_time'] = $time;
//            }
//
//            $fsstring = FSFactory::getClass('FSString','','../');
//            $alias = $fsstring -> stringStandart($title);
//            print_r($row);die;
//            $rs = parent::save($row);
//            return $rs;
//        }

	}
	
?>