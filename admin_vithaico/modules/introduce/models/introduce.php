<?php 
	class IntroduceModelsIntroduce extends FSModels
	{
		var $limit;
		var $prefix ;
		function __construct()
		{
		    date_default_timezone_set('Asia/Ho_Chi_Minh');  
			$this -> limit = 30;
			$this -> view = 'introduce';
			
			//$this -> table_types = 'fs_news_types';
			$this -> arr_img_paths = array(
                                            array('lange',632,423,'cut_image'),
                                            array('resized',359,240,'cut_image'),
                                            array('small',112,75,'cut_image')
                                        );
			$this -> table_category_name = FSTable_ad::_('fs_introduce_categories',1);
            $this -> table_name = FSTable_ad::_('fs_introduce',1);
            $this -> table_link = 'fs_menus_createlink';
            $this -> table_tags = FSTable_ad::_('fs_tags',1);
            $limit_created_link = 30;
			$this->limit_created_link = $limit_created_link;
			// config for save
			$cyear = date('Y');
			$cmonth = date('m');
			//$cday = date('d');
			$this -> img_folder = 'images/introduce/'.$cyear.'/'.$cmonth;
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
            
            // from
    		if(isset($_SESSION[$this -> prefix.'text0']))
    		{
    			$date_from = $_SESSION[$this -> prefix.'text0'];
    			if($date_from){
    				$date_from = strtotime($date_from);
    				$date_new = date('Y-m-d H:i:s',$date_from);
    				$where .= ' AND a.created_time >=  "'.$date_new.'" ';
    			}
    		}
    
    		// to
    		if(isset($_SESSION[$this -> prefix.'text1']))
    		{
    			$date_to = $_SESSION[$this -> prefix.'text1'];
    			if($date_to){
    				$date_to = $date_to . ' 23:59:59';
    				$date_to = strtotime($date_to);
    				$date_new = date('Y-m-d H:i:s',$date_to);
    				$where .= ' AND a.created_time <=  "'.$date_new.'" ';
    			}
    		}
			
			// estore
			if(isset($_SESSION[$this -> prefix.'filter0'])){
				$filter = $_SESSION[$this -> prefix.'filter0'];
				if($filter){
					$where .= ' AND a.category_id_wrapper like  "%,'.$filter.',%" ';
				}
			}	
			
			if(!$ordering)
				$ordering .= " ORDER BY created_time DESC , id DESC ";
			
			
			if(isset($_SESSION[$this -> prefix.'keysearch'] ))
			{
				if($_SESSION[$this -> prefix.'keysearch'] )
				{
					$keysearch = $_SESSION[$this -> prefix.'keysearch'];
					$where .= " AND a.title LIKE '%".$keysearch."%' ";
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
			$title = FSInput::get('title');		
			if(!$title)
				return false;
			$id = FSInput::get('id',0,'int');	
			$category_id = FSInput::get('category_id',0,'int');
			if(!$category_id){
				Errors::_('Bạn phải chọn danh mục');
				return;
			}

			$cat =  $this->get_record_by_id($category_id,$this -> table_category_name);
			$row['category_id_wrapper'] = $cat -> list_parents;
			$row['category_alias_wrapper'] = $cat -> alias_wrapper;
			$row['category_name'] = $cat -> name;
			$row['category_alias'] = $cat -> alias;
            
            
      //       $image_name_icon = $_FILES["icon"]["name"];
    		// if($image_name_icon){
    		// 	$image_icon = $this->upload_image('icon','_'.time(),2000000,$this -> arr_img_paths_icon);
    		// 	if($image_icon){
    		// 		$row['icon'] = $image_icon;
    		// 	}
    		// }
            
            // related news
    		// $record_relate = FSInput::get('news_record_related',array(),'array');
    		// $row['news_related'] ='';
    		// if(count($record_relate)){
    		// 	$record_relate = array_unique($record_relate);
    		// 	$row['news_related'] = ','.implode(',', $record_relate).',';	
    		// }
			
			$row['content'] = htmlspecialchars_decode(FSInput::get('content'));
			$time = date('Y-m-d H:i:s');
            $row['published'] = 1;

            $user_id = isset($_SESSION['ad_userid'])? $_SESSION['ad_userid']:'';
            if(!$user_id)
                return false;
                
            $user = $this->get_record_by_id($user_id,'fs_users','username');
            if($id){
          		$row['updated_time'] = $time;
                $row['end_time'] = $time;
                $row['author_last'] = $user->username;
                $row['author_last_id'] = $user_id;
            }else{
            	$row['created_time'] = $time;
            	$row['updated_time'] = $time;
                $row['end_time'] = $time;
                $row['start_time'] = $time;
                $row['author'] = $user->username;
                $row['author_id'] = $user_id;
            }

//            $tags = FSInput::get('tag_alias', '', 'array');
//            $list_tags_id = implode(',', $tags);
//            $row['tag_alias'] = $list_tags_id;
            
            $fsstring = FSFactory::getClass('FSString','','../');
            $alias = $fsstring -> stringStandart($title);
			$rs = parent::save($row);

            return $rs;
		}
        
        function get_introduce_related($introduce_related){
    		if(!$introduce_related)
    				return;
    		$query   = " SELECT id, title,image 
    					FROM ".$this -> table_name."
    					WHERE id IN (0".$introduce_related."0) 
    					 ORDER BY POSITION(','+id+',' IN '0".$introduce_related."0')
    					";
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
        /*
		 *==================== AJAX RELATED news==============================
		 */
	
    	function ajax_get_introduce_related(){
    		$introduce_id = FSInput::get('new_id',0,'int');
            // category_id danh muc
    		$category_id = FSInput::get('category_id',0,'int');
            // tim kiem keyword
    		$keyword = FSInput::get('keyword');
            $keyword_tag = FSInput::get('keyword_tag');
            // chuoi id tin lien quan keyword tag
            $str_related = FSInput::get('str_related');
            // id khi click vao xoa tin lien quan
            $id = FSInput::get('id',0,'int');
            
    		$where = ' WHERE published = 1 ';
            
    		if($category_id){
    			$where .= ' AND (category_id_wrapper LIKE "%,'.$category_id.',%"	) ';
    		}
            if($keyword){
                $where .= " AND ( title LIKE '%".$keyword."%' OR alias LIKE '%".$keyword."%' OR content LIKE '%".$keyword."%' )";
            }
    		if($keyword_tag){
    		    $keyword_tag = explode(',',$keyword_tag);
                //$keyword_tag = str_replace(',','',$keyword_tag);
                $total = count($keyword_tag);
                $where .= ' AND ( ';
                for($i=0;$i<$total;$i++){
                    if($i == 0){
                        $where .= " title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }else{
                       $where .= " OR title LIKE '%".$keyword_tag[$i]."%' OR alias LIKE '%".$keyword_tag[$i]."%' OR content LIKE '%".$keyword_tag[$i]."%' ";
                    }
                }
                $where .= ' ) '; 
            }
            if($str_related){
                if($id){
                    $str_related = str_replace(','.$id,'',$str_related);
                }
                $where .= ' AND id NOT IN(0'.$str_related.'0) ';
            }
    		
    		$query_body = ' FROM '.$this -> table_name.' '.$where;
    		$ordering = " ORDER BY created_time DESC , id DESC ";
    		$query = ' SELECT id,category_id,title,category_name,image'.$query_body.$ordering.' LIMIT 100 ';
            //print_r($query);
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
		
		/*
		 * select in category of home
		 */
		function get_categories_tree()
		{
			global $db;
			$query = " SELECT a.*
						  FROM 
						  	".$this -> table_category_name." AS a
						  	WHERE published = 1 ORDER BY ordering ";         
			$sql = $db->query($query);
			$result = $db->getObjectList();
			$tree  = FSFactory::getClass('tree','tree/');
			$list = $tree -> indentRows2($result);
			return $list;
		}
		
		/*
	     * Save all record for list form
	     */
	    function save_all(){
	        $total = FSInput::get('total',0,'int');
	        if(!$total)
	           return true;
	        $field_change = FSInput::get('field_change');
	        if(!$field_change)
	           return false;
	        $field_change_arr = explode(',',$field_change);
	        $total_field_change = count($field_change_arr);
	        $record_change_success = 0;
	        for($i = 0; $i < $total; $i ++){
//	        	$str_update = '';
	        	$row = array();
	        	$update = 0;
	        	foreach($field_change_arr as $field_item){
	        	      $field_value_original = FSInput::get($field_item.'_'.$i.'_original')	;
	        	      $field_value_new = FSInput::get($field_item.'_'.$i)	;
	        		  if(is_array($field_value_new)){
        	      		$field_value_new = count($field_value_new)?','.implode(',',$field_value_new).',':'';
	        	      }
	        	      
	        	      if($field_value_original != $field_value_new){
	        	          $update =1;
	        	       		// category
	        	          if($field_item == 'category_id'){
	        	          		$cat =  $this->get_record_by_id($field_value_new,$this -> table_category_name);
								$row['category_id_wrapper'] = $cat -> list_parents;
								$row['category_alias_wrapper'] = $cat -> alias_wrapper;
								$row['category_name'] = $cat -> name;
								$row['category_alias'] = $cat -> alias;
								$row['category_id'] = $field_value_new;
	        	          }else{
								$row[$field_item] = $field_value_new;
	        	          }
	        	      }
	        	}
	        	if($update){
	        		$id = FSInput::get('id_'.$i, 0, 'int'); 
	        		$str_update = '';
	        		global $db;
	        		$j = 0;
	        		foreach($row as $key => $value){
	        			if($j > 0)
	        				$str_update .= ',';
	        			$str_update .= "`".$key."` = '".$value."'";
	        			$j++;
	        		}
            
		            $sql = ' UPDATE  '.$this ->  table_name . ' SET ';
		            $sql .=  $str_update;
		            $sql .=  ' WHERE id =    '.$id.' ';
		            $db->query($sql);
		            $rows = $db->affected_rows();
		            if(!$rows)
		                return false;
		            $record_change_success ++;
	        	}
	        }
	        return $record_change_success;  
	           
	        
	    }
        function get_linked_id()
		{
			$id = FSInput::get('id',0,'int');
			if(!$id)
				return;
			global $db;
			$query = " SELECT *
						FROM  ".$this -> table_link."
						WHERE published = 1
						AND id = $id 
						 ";
			$result = $db->getObject($query);
			
			return $result;
		}
        /*
		 * get List data from table
		 * for create link
		 */
		function get_data_from_table($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);
			if(!$query)
				return;
			global $db;
			$sql = $db->query_limit($query,$this->limit_created_link,$this->page);
			$result = $db->getObjectList();
			
			return $result;
		}
		
		function get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			global $db;
			$query = $this -> set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);

			$total = $db->getTotal($query);
			return $total;
		}
		
		function get_pagination_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct)
		{
			$total = $this->get_total_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct);		
			$pagination = new Pagination($this->limit_created_link,$total,$this->page);
			return $pagination;
		}
        function set_query_create_link($add_table,$add_field_display,$add_field_value,$add_field_distinct){
			$query  = '';
			if($add_field_distinct){
				if($add_field_display != $add_field_value){
					echo "Khi đã chọn distinct, duy nhất chỉ xét một trường. Bạn hãy check lại trường hiển thị và trường dữ liệu";
					return false;
				}
				$query .= ' SELECT DISTINCT '.$add_field_display. ' ';
			} else {
				$query .= ' SELECT '.$add_field_display. ' ,' . $add_field_value.'  ';
			}
			$query .= ' FROM '.$add_table ;
			$query .= '	WHERE published = 1 ';
			return $query;
		}
        
        function get_products_related($product_related){
    		if(!$product_related)
    				return;
    		$query   = ' SELECT id, name,image 
    					FROM '.$this -> table_products.'
    					WHERE id IN (0'.$product_related.'0) 
    					 ORDER BY POSITION(","+id+"," IN "0'.$product_related.'0")
    					';
    		global $db;
    		$sql = $db->query($query);
    		$result = $db->getObjectList();
    		return $result;
    	}
        function get_tags() {
            global $db;
            $query = " SELECT a.*
						  FROM 
						  	" . $this->table_tags. " AS a
						  	WHERE published = 1 ORDER BY ordering ";
            $sql = $db->query($query);
            $result = $db->getObjectList();
            return $result;
        }
	}
	
?>