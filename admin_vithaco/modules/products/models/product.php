<?php 
	class ProductsModelsProduct extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'product';
			$this -> type = 'product';
			
			$this -> table_category_name = FSTable_ad::_('fs_products_categories');
			$this -> table_manufactor_name = FSTable_ad::_('fs_products_manufactor');

			$this -> arr_img_paths = array(
                                        array('resize',400,400,'resize_image'),
                                        //array('resize_detail',356,356,'resize_image_fix_height'),
																				array('resized',300,300,'resize_image'),
                                        array('small',200,200,'cut_image'),
                                        array('smaller',114,114,'cut_image'),
                                        array('tiny',80,80,'resize_image')
									);
			$this -> arr_img_paths_other = array(
                                        array('resize',400,400,'resize_imag e'),
                                        //array('resize_detail',356,356,'resize_image_fix_height'),
																				array('resized',300,300,'resize_image'),
                                        array('small',200,200,'cut_image'),
                                        array('smaller',114,114,'cut_image'),
                                        array('tiny',80,80,'resize_image')
									);
			$this -> table_name = FSTable_ad::_('fs_products');
			
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			$cday = date('d');
			$this -> img_folder = 'images/products/'.$cyear.'/'.$cmonth.'/'.$cday;
			$this -> check_alias = 0;
			$this -> field_img = 'image';
			
			parent::__construct();
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
				if($filter){
					$where .= ' AND (a.category_id_wrapper like  "%,'.$filter.',%" or a.multi_categories like "%,'.$filter.',%") ';
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
			return $query;
		}
		
		function save($row = array(), $use_mysql_real_escape_string = 1){
			$name = FSInput::get('name');
			if(!$name)
				return false;
			$id = FSInput::get('id',0,'int');
			$get_gift = $this->get_record_by_id($id,$this -> table_name);
           //echo $get_gift->user_id;die;
            $user_id = strpos($get_gift->user_id,$_SESSION['ad_userid']);
            if($user_id == false){
                $row['user_id'] = $get_gift->user_id.','.$_SESSION['ad_userid'];
            }else{
                $row['user_id'] = $get_gift->user_id;
            }
			$category_id = FSInput::get('category_id','int',0);
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục.');
				return;
			}

			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
			$row['category_published'] = $cat -> published;

			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			$row['description'] = htmlspecialchars_decode(FSInput::get('description'));
			$time = date('Y-m-d H:i:s');
			if($id){
                $row['edited_time'] = $time;
            }else{
                $row['created_time'] = $time;
						}
			return parent::save($row);
			
		}

        
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a WHERE published = 1
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		function get_manufactor_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_manufactor_name." AS a WHERE published = 1
						  	ORDER BY ordering ";
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
        function getPagination()
        {
            $total = $this->getTotal();
            $pagination = new Pagination($this->limit,$total,$this->page);
            return $pagination;
        }
        function getTotal()
        {
            global $db;
            $query = $this->setQuery();
            $sql = $db->query($query);
            $total = $db->getTotal();
            return $total;
        }
	}
?>