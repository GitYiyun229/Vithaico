<?php 
	class ConfigModelsReviews extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
			$this -> limit = 20;
			$this -> view = 'reviews';
			$this -> type = 'reviews';
			$this -> arr_img_paths = array(
                                            //array('resized',50,50,'resize_image'),
                                            array('small',50,50,'cut_image'),
                                        );
			$this -> table_name = FSTable_ad::_('fs_reviews');
			//$this -> table_category_name = FSTable_ad::_('fs_partners_categories');
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
//			$cday = date('d');
			$this -> img_folder = 'images/reviews/'.$cyear.'/'.$cmonth;
//			$this -> check_alias = 0;
			$this -> field_img = 'image';
//			$this -> field_width = 'width';
			
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
        
        //function save($row = array(), $use_mysql_real_escape_string = 1){
//			$name = FSInput::get('name');
//			//$show_in_homepage = FSInput::get('show_in_homepage');
//			if(!$name)
//				return false;
//			$id = FSInput::get('id',0,'int');
//            	
//			$category_id = FSInput::get('category_id','int',0);
//			if(!$category_id){
//				Errors::_('Bạn phải chọn danh mục');
//				return;
//			}
//			
//			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
//			$row['category_id_wrapper'] = $cat -> list_parents;
//			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
//			$row['category_name'] = $cat -> name;
//			$row['category_alias'] = $cat -> alias;
//			//$row['category_published'] = $cat -> published;
//            
//			return parent::save($row);
//		}
        /*
		 * select in category of home
		 */
		//function get_categories_tree()
//		{
//			global $db;
//			$query = " SELECT a.*
//						  FROM 
//						  	".$this -> table_category_name." AS a
//						  	ORDER BY ordering ";
//			$sql = $db->query($query);
//			$result = $db->getObjectList();
//			$tree  = FSFactory::getClass('tree','tree/');
//			$list = $tree -> indentRows2($result);
//			return $list;
//		}
		
	}
	
?>